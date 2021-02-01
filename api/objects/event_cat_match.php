<?php
class EventCatMatch{
  
    // database connection and table name
    private $conn;
    private $table_name = "event_cat_match";
  
    // object properties
    public $id;
	public $addDate;
    public $cat_id;
    public $event_id;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read category.
	function read($options=[]){
	  	
		$where = ''; //print_r($options);
		if(isset($options['event_id'])){
			$event_id = filter_var($options['event_id'], FILTER_SANITIZE_NUMBER_INT); 
			$where = 'where event_id = :event_id';
		}
		if(isset($options['cat_id'])){
			$cat_id = filter_var($options['cat_id'], FILTER_SANITIZE_NUMBER_INT); 
			$where = 'where cat_id = :cat_id';
		}
		
		// select all query
		$query = "SELECT * FROM " . $this->table_name . "  ".$where." ORDER BY id DESC";
	    //echo $query;
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	  	
		if(isset($options['event_id']))
		$stmt->bindParam(':event_id', $event_id);
		if(isset($options['cat_id']))
		$stmt->bindParam(':cat_id', $cat_id);
		
		
		// execute query
		$stmt->execute();
	  
		return $stmt;
	}
	
	// create record.
	function create(){
	  
		// query to insert record
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					event_id=:event_id, cat_id=:cat_id,addDate=:addDate";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		// #TODO - Senitize it
		$this->event_id=filter_var($this->event_id,FILTER_SANITIZE_NUMBER_INT);
		$this->cat_id=filter_var($this->cat_id,FILTER_SANITIZE_NUMBER_INT);
	  
		// bind values
		$stmt->bindParam(":event_id", $this->event_id);
		$stmt->bindParam(":cat_id", $this->cat_id);
		$stmt->bindParam(":addDate", $this->addDate);
		
		// execute query
		if($stmt->execute()){
			return true;
		}
	  
		return false;
		  
	}
	
	function delete($options=[])
	{
		$where = ''; //print_r($options);
		if(isset($options['event_id'])){
			$event_id = filter_var($options['event_id'], FILTER_SANITIZE_NUMBER_INT); 
			$where = 'where event_id = :event_id';
		}
		if(isset($options['cat_id'])){
			$cat_id = filter_var($options['cat_id'], FILTER_SANITIZE_NUMBER_INT); 
			$where = 'where cat_id = :cat_id';
		}
		
		// query to insert record
		$query = "DELETE FROM
					" . $this->table_name . "
				 ".$where;
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		
		// bind values
		if(isset($options['event_id']))
		$stmt->bindParam(":event_id", $event_id);
		if(isset($options['cat_id']))
		$stmt->bindParam(":cat_id", $cat_id);
		
		// execute query
		if($stmt->execute()){
			return true;
		}
	  
		return false;
			
	}
}
?>