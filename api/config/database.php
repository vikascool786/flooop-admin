<?php
class Database{
  
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "a1610nqz_flooop";
    private $username = "a1610nqz_flooop";
    private $password = "Vineetaw1!";
	/*private $db_name = 'axomaxjq_flooop';
	private $username = 'axomaxjq_flooop';
	private $password = 'AnsFloopDb@102020';*/
    public $conn;
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>