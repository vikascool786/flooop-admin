<?php
class User_Fav_Events{
  
    // database connection and table name
    private $conn;
    private $table_name = "user_fav_events";
  
    // object properties
    public $id;
	public $addDate;
	public $event_id;
    public $user_id;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read records
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
			$where .= ' and a.event_id = :event_id';
		}
		if(isset($options['user_id'])){
			$user_id = filter_var($options['user_id'], FILTER_SANITIZE_NUMBER_INT); 
			$where .= ' and a.user_id = :user_id';
		}
		//echo 'where:'.$where; echo 'options:';print_r($options); exit;
		
		// select all query
		//$query = "SELECT * FROM " . $this->table_name . "  ".$where;
		$query = "SELECT a.*, b.first_name,b.last_name,b.profilephoto,c.event_title   
				FROM " . $this->table_name . " as a
				LEFT JOIN users as b on a.user_id=b.id 
				LEFT JOIN events as c on a.event_id=c.id 
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
					 addDate=:addDate";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->event_id=htmlspecialchars(strip_tags($this->event_id));
		$this->user_id=htmlspecialchars(strip_tags($this->user_id));
		
		// bind values
		$addDate = date('Y-m-d H:i:s');
		$stmt->bindParam(":event_id", $this->event_id);
		$stmt->bindParam(":user_id", $this->user_id);
		$stmt->bindParam(":addDate", $addDate);
		
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