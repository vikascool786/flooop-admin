<?php
class Category{
  
    // database connection and table name
    private $conn;
    private $table_name = "event_category";
  
    // object properties
    public $id;
	public $addDate;
	public $lastModified;
    public $cat_title;
    public $cat_image;
    public $status;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read category.
	function read(){
	  
		// select all query
		$query = "SELECT c.* FROM " . $this->table_name . " c ORDER BY c.orderno ASC";
	    //echo $query;
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
			$where = 'where id = :id';
		}
		//echo 'where:'.$where; echo 'options:';print_r($options); exit;
		
		// select all query
		$query = "SELECT *   
					FROM " . $this->table_name . " 
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
	
}
?>