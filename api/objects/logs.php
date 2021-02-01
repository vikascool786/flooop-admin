<?php
/*
	TASK: CANCEL_EVENT, EVENT_FAV_ADD,EVENT_FAV_REMOVE, 
*/
class Logs{
  
    // database connection and table name
    private $conn;
    private $table_name = "logs";
  
    // object properties
    public $id;
	public $addDate;
    public $user_id;
    public $task;
	public $description;
	public $entity_id;
	public $entity_title;
	public $ipAddr;
	public $extraDetail;
	
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read category.
	function read($options=[]){
	  	
		$where = 'where 1 '; //print_r($options);
		if(isset($options['user_id'])){
			$user_id = filter_var($options['user_id'], FILTER_SANITIZE_NUMBER_INT); 
			$where .= 'and user_id = :user_id';
		}
		if(isset($options['task'])){
			$task = filter_var($options['task'], FILTER_SANITIZE_STRING); 
			$where .= 'and task = :task';
		}
		if(isset($options['entity_id'])){
			$entity_id = filter_var($options['entity_id'], FILTER_SANITIZE_NUMBER_INT); 
			$where .= 'and entity_id = :entity_id';
		}
		
		// select all query
		$query = "SELECT * FROM " . $this->table_name . "  ".$where." ORDER BY id DESC";
	    //echo $query;
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	  	
		if(isset($options['user_id']))
		$stmt->bindParam(':user_id', $user_id);
		if(isset($options['task']))
		$stmt->bindParam(':task', $task);
		if(isset($options['entity_id']))
		$stmt->bindParam(':entity_id', $entity_id);
		
		
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
					user_id=:user_id, task=:task,description=:description,entity_id=:entity_id,entity_title=:entity_title,ipAddr=:ipAddr,extraDetail=:extraDetail,addDate=:addDate";
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		// #TODO - Senitize it
		$this->user_id=filter_var($this->user_id,FILTER_SANITIZE_NUMBER_INT);
		//$this->task=filter_var($this->task,FILTER_SANITIZE_NUMBER_INT);
	  
		// bind values
		$stmt->bindParam(":user_id", $this->user_id);
		$stmt->bindParam(":task", $this->task);
		$stmt->bindParam(":description", $this->description);
		$stmt->bindParam(":entity_id", $this->entity_id);
		$stmt->bindParam(":entity_title", $this->entity_title);
		$stmt->bindParam(":ipAddr", $this->ipAddr);
		$stmt->bindParam(":extraDetail", $this->extraDetail);
		$stmt->bindParam(":addDate", $this->addDate);
		
		// execute query
		if($stmt->execute()){
			return true;
		}
	  
		return false;
		  
	}
	
}
?>