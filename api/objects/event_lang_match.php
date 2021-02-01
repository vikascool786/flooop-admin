<?php
class EventLangMatch{
  
    // database connection and table name
    private $conn;
    private $table_name = "event_lang_match";
  
    // object properties
    public $id;
	public $addDate;
    public $lang_id;
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
		if(isset($options['lang_id'])){
			$lang_id = filter_var($options['lang_id'], FILTER_SANITIZE_NUMBER_INT); 
			$where = 'where lang_id = :lang_id';
		}
		
		// select all query
		//$query = "SELECT * FROM " . $this->table_name . "  ".$where." ORDER BY id DESC";
		$query = "SELECT a.*, b.lang_title  
				  FROM " . $this->table_name . " as a 
				  LEFT JOIN event_lang as b on a.lang_id=b.id
				   ".$where." ORDER BY id DESC";
	    //echo $query;
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	  	
		if(isset($options['event_id']))
		$stmt->bindParam(':event_id', $event_id);
		if(isset($options['lang_id']))
		$stmt->bindParam(':lang_id', $lang_id);
		
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
					event_id=:event_id, lang_id=:lang_id,addDate=:addDate";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		// #TODO - Senitize it
		$this->event_id=filter_var($this->event_id,FILTER_SANITIZE_NUMBER_INT);
		$this->lang_id=filter_var($this->lang_id,FILTER_SANITIZE_NUMBER_INT);
	  
		// bind values
		$stmt->bindParam(":event_id", $this->event_id);
		$stmt->bindParam(":lang_id", $this->lang_id);
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
		if(isset($options['lang_id'])){
			$lang_id = filter_var($options['lang_id'], FILTER_SANITIZE_NUMBER_INT); 
			$where = 'where lang_id = :lang_id';
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
		if(isset($options['lang_id']))
		$stmt->bindParam(":lang_id", $lang_id);
		
		// execute query
		if($stmt->execute()){
			return true;
		}
	  
		return false;
			
	}
}
?>