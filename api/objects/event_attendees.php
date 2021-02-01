<?php
class Event_Attendees{
  
    // database connection and table name
    private $conn;
    private $table_name = "event_attendees";
  
    // object properties
    public $id;
	public $addDate;
	public $lastModified;
    public $event_id;
    public $user_id;
    public $status;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read products
	function read(){
	  
		// select all query
		$query = "SELECT * FROM " . $this->table_name . "  ORDER BY id DESC";
	    //echo $query;
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	  
		// execute query
		$stmt->execute();
	  
		return $stmt;
	}
	
	function find($options=[])
	{
	  	
		$where = 'where 1 '; //print_r($options);
		if(isset($options['event_id'])){
			$event_id = filter_var($options['event_id'], FILTER_SANITIZE_NUMBER_INT); 
			$where .= ' and ea.event_id = :event_id';
		}
		if(isset($options['user_id'])){
			$user_id = filter_var($options['user_id'], FILTER_SANITIZE_NUMBER_INT); 
			$where .= ' and ea.user_id = :user_id';
		}
		//echo 'where:'.$where; echo 'options:';print_r($options); exit;
		
		// select all query
		//$query = "SELECT * FROM " . $this->table_name . "  ".$where;
		$query = "SELECT ea.*, u.first_name,u.last_name,u.profilephoto  
				FROM " . $this->table_name . " as ea
				LEFT JOIN users as u on ea.user_id=u.id 
				  ".$where;
	    //echo $query; 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
		
		if(isset($options['event_id']))
		$stmt->bindParam(':event_id', $event_id);
		
		if(isset($options['user_id']))
		$stmt->bindParam(':user_id', $user_id);
		
		
		// execute query
		$stmt->execute();
	  
		return $stmt;
	}
	
	// create record
	function create()
	{
	  
		// query to insert record
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					event_id=:event_id, user_id=:user_id,
					 status=:status,addDate=:addDate,lastModified=:lastModified";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->event_id=htmlspecialchars(strip_tags($this->event_id));
		$this->user_id=htmlspecialchars(strip_tags($this->user_id));
		
		// bind values
		$stmt->bindParam(":event_id", $this->event_id);
		$stmt->bindParam(":user_id", $this->user_id);
		$stmt->bindParam(":status", $this->status);
		$stmt->bindParam(":addDate", $this->addDate);
		$stmt->bindParam(":lastModified", $this->lastModified);
	  
		// execute query
		if($stmt->execute()){
			return true;
		}
	  
		return false;
		  
	}
	
	function delete()
	{
		// query to insert record
		$query = "DELETE FROM
					" . $this->table_name . "
				WHERE
					event_id=:event_id and user_id=:user_id";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->event_id=htmlspecialchars(strip_tags($this->event_id));
		$this->user_id=htmlspecialchars(strip_tags($this->user_id));
		
		// bind values
		$stmt->bindParam(":event_id", $this->event_id);
		$stmt->bindParam(":user_id", $this->user_id);
		
		// execute query
		if($stmt->execute()){
			return true;
		}
	  
		return false;
			
	}
}
?>