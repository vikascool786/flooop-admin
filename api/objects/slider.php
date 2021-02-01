<?php
class Slider{
  
    // database connection and table name
    private $conn;
    private $table_name = "slider";
  
    // object properties
    public $id;
	public $addDate;
	public $image;
    public $title;
    public $subtitle;
	public $link_title;
	public $link_value;
    public $status;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read category.
	function read(){
	  
		// select all query
		$query = "SELECT c.* FROM " . $this->table_name . " c ORDER BY c.id ASC";
	    //echo $query;
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	  
		// execute query
		$stmt->execute();
	  
		return $stmt;
	}
	
}
?>