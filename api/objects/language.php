<?php
class Language{
  
    // database connection and table name
    private $conn;
    private $table_name = "event_lang";
  
    // object properties
    public $id;
	public $addDate;
	public $lastModified;
    public $lang_title;
    public $lang_image;
    public $status;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read language.
	function read(){
	  
		// select all query
		$query = "SELECT * FROM " . $this->table_name . "  ORDER BY id ASC";
	    //echo $query;
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	  
		// execute query
		$stmt->execute();
	  
		return $stmt;
	}
	
}
?>