<?php
class Event{
  
    // database connection and table name
    private $conn;
    private $table_name = "events";
  
    // object properties
    public $id;
	public $addDate;
	public $lastModified;
    public $event_title;
    public $host_id;
	public $event_cost;
	public $event_currency;
    public $event_start;
    public $event_duration;
    public $timezone;
    public $event_image;
	public $event_desc;
	public $event_tags;
	public $event_lang;
	public $max_group_size;
	public $event_attendees_do;
	public $event_attendees;
	public $attendees_can_invite;
	public $display_attendees;
	public $event_cohost;
	public $event_question;
	public $status;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read products
	//function read($page)
	function read($page,$userId,$catId){
	  	
		$page = ($page!='undefined')?$page:'events';
		$userId = ($userId!='undefined')?$userId:'0';
		$catId = ($catId!='undefined')?$catId:'0';
		
		if($page=='events'){
			// select all query
			//$query = "SELECT e.* FROM " . $this->table_name . " e ORDER BY e.id DESC";
			$query = "SELECT e.* ,et.title as timezone_title,et.value as timezone_value,c.short_name as currency_code,c.symbol as currency_symbol 
				  FROM " . $this->table_name . " e 
				  LEFT JOIN event_timezone as et on e.timezone=et.id 
				  LEFT JOIN currency as c on e.event_currency=c.id 
				  WHERE e.event_date>='".date('Y-m-d')."'
				  ORDER BY e.event_date ASC";
		}
		if($page=='HomeLiveUpcoming'){
			// select all query
			//$query = "SELECT e.* FROM " . $this->table_name . " e ORDER BY e.id DESC";
			$query = "SELECT e.* ,et.title as timezone_title,et.value as timezone_value, c.short_name as currency_code,c.symbol as currency_symbol 
				  FROM " . $this->table_name . " e 
				  LEFT JOIN event_timezone as et on e.timezone=et.id 
				  LEFT JOIN currency as c on e.event_currency=c.id 
				  WHERE e.event_date>='".date('Y-m-d')."'
				  ORDER BY e.event_date ASC
				  LIMIT 0,3";
		}
		if($page=='AccountEventAttendee')
		{
			//$userId = '2';
			$query = "SELECT ea.addDate as joinDate,e.* ,et.title as timezone_title,et.value as timezone_value, 
						c.short_name as currency_code,c.symbol as currency_symbol 
						FROM event_attendees ea  
						LEFT JOIN " . $this->table_name . " e on ea.event_id=e.id 
						LEFT JOIN event_timezone as et on e.timezone=et.id 
				  		LEFT JOIN currency as c on e.event_currency=c.id 
				  		WHERE ea.user_id=".$userId." and e.event_date>='".date('Y-m-d')."'
				  		ORDER BY e.event_date ASC
						";	
		}
		if($page=='AccountMyEventsUpcoming')
		{
			$query = "SELECT e.* ,et.title as timezone_title,et.value as timezone_value, c.short_name as currency_code,c.symbol as currency_symbol 
				  FROM " . $this->table_name . " e 
				  LEFT JOIN event_timezone as et on e.timezone=et.id 
				  LEFT JOIN currency as c on e.event_currency=c.id 
				  WHERE e.host_id=".$userId." and e.event_date>='".date('Y-m-d')."'
				  ORDER BY e.event_date ASC";	
		}
		if($page=='AccountMyEventsPast')
		{
			$query = "SELECT e.* ,et.title as timezone_title,et.value as timezone_value, c.short_name as currency_code,c.symbol as currency_symbol 
				  FROM " . $this->table_name . " e 
				  LEFT JOIN event_timezone as et on e.timezone=et.id 
				  LEFT JOIN currency as c on e.event_currency=c.id 
				  WHERE e.host_id=".$userId." and e.event_date<'".date('Y-m-d')."'
				  ORDER BY e.event_date ASC";	
		}
		if($page=='Category')
		{
			$query = "select ecm.cat_id,e.* ,et.title as timezone_title,et.value as timezone_value, 
						c.short_name as currency_code,c.symbol as currency_symbol  
						FROM event_cat_match as ecm  
						LEFT JOIN events as e on ecm.event_id=e.id 
						LEFT JOIN event_timezone as et on e.timezone=et.id 
						LEFT JOIN currency as c on e.event_currency=c.id 
						WHERE ecm.cat_id=".$catId." and e.event_date>='".date('Y-m-d')."'
						ORDER BY e.event_date ASC ";
		}
		
		//echo 'page:'.$page;
	    //echo $query; exit;
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	  
		// execute query
		$stmt->execute();
	  
		return $stmt;
	}
	
	function readSingle($options=[])
	{
	  	
		$where = ''; //print_r($options);
		if(isset($options['id'])){
			$id = filter_var($options['id'], FILTER_SANITIZE_NUMBER_INT); 
			$where = 'where e.id = :id';
		}
		//echo 'where:'.$where; echo 'options:';print_r($options); exit;
		
		// select all query
		$query = "SELECT e.* ,et.title as timezone_title, c.short_name as currency_code,c.symbol as currency_symbol,u.first_name,u.last_name   
					FROM " . $this->table_name . " e 
					LEFT JOIN event_timezone as et on e.timezone=et.id 
					LEFT JOIN currency as c on e.event_currency=c.id 
					LEFT JOIN users as u on e.host_id=u.id 
					 ".$where;
	    //echo $query;
		// prepare query statement
		$stmt = $this->conn->prepare($query);
		
		if(isset($options['id']))
		$stmt->bindParam(':id', $id);
		
		
		// execute query
		$stmt->execute();
	  
		return $stmt;
	}
	
	// create event.
	function create()
	{
	  
		// query to insert record
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					event_title=:event_title, host_id=:host_id,event_cost=:event_cost,event_currency=:event_currency, event_date=:event_date, event_start=:event_start,event_ampm=:event_ampm, 
					event_duration=:event_duration, timezone=:timezone, event_image=:event_image, event_desc=:event_desc,
					event_tags=:event_tags,event_lang=:event_lang,max_group_size=:max_group_size,event_attendees_do=:event_attendees_do,
					event_attendees=:event_attendees,
					attendees_can_invite=:attendees_can_invite,display_attendees=:display_attendees,event_cohost=:event_cohost,
					event_question=:event_question,
					 status=:status,addDate=:addDate,lastModified=:lastModified";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		// #TODO - Senitize it
		$this->event_title=htmlspecialchars(strip_tags($this->event_title));
		$this->event_desc=htmlspecialchars(strip_tags($this->event_desc));
		$this->event_tags=htmlspecialchars(strip_tags($this->event_tags));
		$this->event_image=htmlspecialchars(strip_tags($this->event_image));
		//$this->created=htmlspecialchars(strip_tags($this->created));
	  
		// bind values
		$stmt->bindParam(":event_title", $this->event_title);
		$stmt->bindParam(":host_id", $this->host_id);
		$stmt->bindParam(":event_cost", $this->event_cost);
		$stmt->bindParam(":event_currency", $this->event_currency);
		$stmt->bindParam(":event_date", $this->event_date);
		$stmt->bindParam(":event_start", $this->event_start);
		$stmt->bindParam(":event_ampm", $this->event_ampm);
		$stmt->bindParam(":event_duration", $this->event_duration);
		$stmt->bindParam(":timezone", $this->timezone);
		$stmt->bindParam(":event_image", $this->event_image);
		$stmt->bindParam(":event_desc", $this->event_desc);
		$stmt->bindParam(":event_tags", $this->event_tags);
		$stmt->bindParam(":event_lang", $this->event_lang);
		$stmt->bindParam(":max_group_size", $this->max_group_size);
		$stmt->bindParam(":event_attendees_do", $this->event_attendees_do);
		$stmt->bindParam(":event_attendees", $this->event_attendees);
		$stmt->bindParam(":attendees_can_invite", $this->attendees_can_invite);
		$stmt->bindParam(":display_attendees", $this->display_attendees);
		$stmt->bindParam(":event_cohost", $this->event_cohost);
		$stmt->bindParam(":event_question", $this->event_question);
		$stmt->bindParam(":status", $this->status);
		$stmt->bindParam(":addDate", $this->addDate);
		$stmt->bindParam(":lastModified", $this->lastModified);
	  
		// execute query
		if($stmt->execute()){
			//$event_id = $stmt->insert_id; 
			//$event_id = mysqli_insert_id($this->conn); echo 'event_id:= '.$event_id; 
			$event_id = $this->conn->lastInsertId(); //echo 'event_id:= '.$event_id; 
			//return true;
			return $event_id;
		}
	  
		return false;
		  
	}
	
	// update event.
	function update()
	{
	  
		// query to insert record
		$query = "UPDATE 
					" . $this->table_name . "
				SET
					event_title=:event_title, host_id=:host_id,event_cost=:event_cost,event_currency=:event_currency, event_date=:event_date, event_start=:event_start,event_ampm=:event_ampm, 
					event_duration=:event_duration, timezone=:timezone, event_image=:event_image, event_desc=:event_desc,
					event_tags=:event_tags,event_lang=:event_lang,max_group_size=:max_group_size,event_attendees_do=:event_attendees_do,
					event_attendees=:event_attendees,
					attendees_can_invite=:attendees_can_invite,display_attendees=:display_attendees,event_cohost=:event_cohost,
					event_question=:event_question,
					 status=:status,lastModified=:lastModified 
					 WHERE id=:id";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		// #TODO - Senitize it
		$this->event_title=htmlspecialchars(strip_tags($this->event_title));
		$this->event_desc=htmlspecialchars(strip_tags($this->event_desc));
		$this->event_tags=htmlspecialchars(strip_tags($this->event_tags));
		$this->event_image=htmlspecialchars(strip_tags($this->event_image));
		//$this->created=htmlspecialchars(strip_tags($this->created));
	  
		// bind values
		$stmt->bindParam(":event_title", $this->event_title);
		$stmt->bindParam(":host_id", $this->host_id);
		$stmt->bindParam(":event_cost", $this->event_cost);
		$stmt->bindParam(":event_currency", $this->event_currency);
		$stmt->bindParam(":event_date", $this->event_date);
		$stmt->bindParam(":event_start", $this->event_start);
		$stmt->bindParam(":event_ampm", $this->event_ampm);
		$stmt->bindParam(":event_duration", $this->event_duration);
		$stmt->bindParam(":timezone", $this->timezone);
		$stmt->bindParam(":event_image", $this->event_image);
		$stmt->bindParam(":event_desc", $this->event_desc);
		$stmt->bindParam(":event_tags", $this->event_tags);
		$stmt->bindParam(":event_lang", $this->event_lang);
		$stmt->bindParam(":max_group_size", $this->max_group_size);
		$stmt->bindParam(":event_attendees_do", $this->event_attendees_do);
		$stmt->bindParam(":event_attendees", $this->event_attendees);
		$stmt->bindParam(":attendees_can_invite", $this->attendees_can_invite);
		$stmt->bindParam(":display_attendees", $this->display_attendees);
		$stmt->bindParam(":event_cohost", $this->event_cohost);
		$stmt->bindParam(":event_question", $this->event_question);
		$stmt->bindParam(":status", $this->status);
		//$stmt->bindParam(":addDate", $this->addDate);
		$stmt->bindParam(":lastModified", $this->lastModified);
		
		$stmt->bindParam(":id", $this->id);
	  
		// execute query
		if($stmt->execute()){
			//$event_id = $stmt->insert_id; 
			//$event_id = mysqli_insert_id($this->conn); echo 'event_id:= '.$event_id; 
			$event_id = $this->id; //echo 'event_id:= '.$event_id; 
			//return true;
			return $event_id;
		}
	  
		return false;
		  
	}
}
?>