<?php
class User{
  
    // database connection and table name
    private $conn;
    private $table_name = "users";
  
    // object properties
    public $id;
	public $addDate;
	public $lastModified;
    public $oauth_type;
	public $oauth_data_fb;
	public $oauth_data_google;
	public $oauth_data_twitter;
	public $oauth_data_linkedin;
	public $ip_address;
    public $username;
    public $password;
    public $salt;
    public $email;
    public $activation_code;
	public $forgotten_password_code;
	public $forgotten_password_time;
	public $remember_code;
	public $created_on;
	public $last_login;
	public $active;
	public $first_name;
	public $last_name;
	public $company;
	public $phone;
	public $zoom_access_token;
	public $zoom_connected_at;
	public $zoom_refreshed_at;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
		$this->oauth_type = NULL;
		$this->oauth_data_fb = NULL;
		$this->oauth_data_google = NULL;
		$this->oauth_data_twitter = NULL;
		$this->oauth_data_linkedin = NULL;
		$this->first_name = NULL;
		$this->last_name = NULL;
		$this->profilephoto = NULL;
		$this->zoom_access_token = NULL;
		$this->zoom_connected_at = NULL;
		$this->zoom_refreshed_at = NULL;
    }
	
	// read user
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

    /**
     * Get the timezone details
     *
     * @param array $options
     * @return mixed
     */
    function readTimeZone($options = [])
    {

        $where = '';
        if (isset($options['id'])) {
            $id = filter_var($options['id'], FILTER_SANITIZE_NUMBER_INT);
            $where = 'where id = :id';
        }

        // select all query
        $query = "SELECT * FROM event_timezone " . $where;
        //echo $query;
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        if (isset($options['id']))
            $stmt->bindParam(':id', $id);

        // execute query
        $stmt->execute();

        return $stmt;
    }
	
	// read user
	function readSingle($options=[])
	{
	  	
		$where = ''; //print_r($options);
		if(isset($options['id'])){
			$id = filter_var($options['id'], FILTER_SANITIZE_NUMBER_INT); 
			$where = 'where id = :id';
		}
		if(isset($options['email'])){
			$email = filter_var($options['email'], FILTER_SANITIZE_EMAIL); 
			$where = 'where email = :email';
		}
		if(isset($options['code'])){
			$code = $options['code']; 
			$where = 'where forgotten_password_code = :code';
		}
		
		// select all query
		$query = "SELECT * FROM " . $this->table_name . "  ".$where;
	    //echo $query;
		// prepare query statement
		$stmt = $this->conn->prepare($query);
		
		if(isset($options['id']))
		$stmt->bindParam(':id', $id);
		
		if(isset($options['email']))
		$stmt->bindParam(':email', $email);
		
		if(isset($options['code']))
		$stmt->bindParam(':code', $code);
	  
		// execute query
		$stmt->execute();
	  
		return $stmt;
	}
	
	// create user.
	function create()
	{
	  
		// query to insert record
		/*$query = "INSERT INTO
					" . $this->table_name . "
				SET
					username=:username, email=:email, password=:password,addDate=:addDate,lastModified=:lastModified";*/
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					username=:username, email=:email, password=:password,first_name=:first_name,last_name=:last_name,profilephoto=:profilephoto,
					oauth_type=:oauth_type,oauth_data_fb=:oauth_data_fb,oauth_data_google=:oauth_data_google,
					oauth_data_twitter=:oauth_data_twitter,oauth_data_linkedin=:oauth_data_linkedin, 
					addDate=:addDate,lastModified=:lastModified";			
	  
		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		// #TODO - Senitize it
		$this->username=htmlspecialchars(strip_tags($this->email));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->first_name=htmlspecialchars(strip_tags($this->first_name));
		$this->last_name=htmlspecialchars(strip_tags($this->last_name));
		$this->profilephoto=htmlspecialchars(strip_tags($this->profilephoto));
		
		// bind values
		$stmt->bindParam(":username", $this->email);
		$stmt->bindParam(":email", $this->email);
		$stmt->bindParam(":first_name", $this->first_name);
		$stmt->bindParam(":last_name", $this->last_name);
		$stmt->bindParam(":profilephoto", $this->profilephoto);
		$stmt->bindParam(":oauth_type", $this->oauth_type);
		$stmt->bindParam(":oauth_data_fb", $this->oauth_data_fb);
		$stmt->bindParam(":oauth_data_google", $this->oauth_data_google);
		$stmt->bindParam(":oauth_data_twitter", $this->oauth_data_twitter);
		$stmt->bindParam(":oauth_data_linkedin", $this->oauth_data_linkedin);
		//$stmt->bindParam(":password", $this->password);
		$stmt->bindParam(":addDate", $this->addDate);
		$stmt->bindParam(":lastModified", $this->lastModified);
	  	
		// hash the password before saving to database
    	$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    	$stmt->bindParam(':password', $password_hash);
		
		// execute query
			if($stmt->execute()){
				$user_id = $this->conn->lastInsertId();
				return $user_id;
				//return true;
			}
			//else { print_r($stmt->errorInfo());}
			
		return false;
		  
	}
	
	// check if given email exist in the database
	public function emailExists()
	{
 
    	// query to check if email exists
    	$query = "SELECT id, email, password, first_name, last_name 
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";
 
    	// prepare the query
    	$stmt = $this->conn->prepare( $query );
 
    	// sanitize
    	$this->email=htmlspecialchars(strip_tags($this->email));
 
    	// bind given email value
    	$stmt->bindParam(1, $this->email);
 
    	// execute the query
    	$stmt->execute();
 
    	// get number of rows
    	$num = $stmt->rowCount();
 
    	// if email exists, assign values to object properties for easy access and use for php sessions
    	if($num>0){
 
			// get record details / values
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
			// assign values to object properties
			$this->id = $row['id'];
			$this->first_name = $row['first_name'];
			$this->last_name = $row['last_name'];
			$this->email = $row['email'];
			$this->password = $row['password'];
	 
			// return true because email exists in the database
			return true;
		}
 
    	// return false if email does not exist in the database
    	return false;
	}
	
	// update a user record
	public function update(){
	
		// if password needs to be updated
		$password_set=!empty($this->password) ? ", password = :password" : "";
	
		// if no posted password, do not update the password
		$query = "UPDATE " . $this->table_name . "
				SET
					firstname = :firstname,
					lastname = :lastname,
					email = :email
					{$password_set}
				WHERE id = :id";
	
		// prepare the query
		$stmt = $this->conn->prepare($query);
	
		// sanitize
		$this->firstname=htmlspecialchars(strip_tags($this->firstname));
		$this->lastname=htmlspecialchars(strip_tags($this->lastname));
		$this->email=htmlspecialchars(strip_tags($this->email));
	
		// bind the values from the form
		$stmt->bindParam(':firstname', $this->firstname);
		$stmt->bindParam(':lastname', $this->lastname);
		$stmt->bindParam(':email', $this->email);
	
		// hash the password before saving to database
		if(!empty($this->password)){
			$this->password=htmlspecialchars(strip_tags($this->password));
			$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
			$stmt->bindParam(':password', $password_hash);
		}
	
		// unique ID of record to be edited
		$stmt->bindParam(':id', $this->id);
	
		// execute the query
		if($stmt->execute()){
			return true;
		}
	
		return false;
	}

    /**
     * update a user's access token
     *
     * @return bool
     */
    public function updateAccessToken()
    {

        // Update query statement
        $query = "UPDATE " . $this->table_name . "
				SET
					zoom_access_token = :zoom_access_token,
					zoom_refreshed_at = :zoom_refreshed_at
				WHERE id = :id";

        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Bind the updated values
        $stmt->bindParam(':zoom_access_token', $this->zoom_access_token);
        $stmt->bindParam(':zoom_refreshed_at', $this->zoom_refreshed_at);

        // Bind with the unique user Id which records are updating with
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
	
	public function change_password(){
	
		$query = "UPDATE " . $this->table_name . "
				SET
					password = :password,
					lastModified = :lastModified
				WHERE id = :id";
	
		// prepare the query
		$stmt = $this->conn->prepare($query);
	
		// sanitize
		$this->password=htmlspecialchars(strip_tags($this->password));
		
		// bind the values from the form
		$stmt->bindParam(':lastModified', date('Y-m-d H:i:s'));
		
		// hash the password before saving to database
		if(!empty($this->password)){
			$this->password=htmlspecialchars(strip_tags($this->password));
			$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
			$stmt->bindParam(':password', $password_hash);
		}
	
		// unique ID of record to be edited
		$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
	
		// execute the query
		if($stmt->execute()){
			return true;
		}
	
		return false;
	}
	
	public function update_resetpass1(){
	
		$query = "UPDATE " . $this->table_name . "
				SET
					forgotten_password_code = :forgotten_password_code,
					forgotten_password_time = :forgotten_password_time 
				WHERE id = :id";
	
		// prepare the query
		$stmt = $this->conn->prepare($query);
	
		// sanitize
		//$this->firstname=htmlspecialchars(strip_tags($this->firstname));
		//$this->lastname=htmlspecialchars(strip_tags($this->lastname));
		//$this->email=htmlspecialchars(strip_tags($this->email));
	
		// bind the values from the form
		$stmt->bindParam(':forgotten_password_code', $this->forgotten_password_code);
		$stmt->bindParam(':forgotten_password_time', $this->forgotten_password_time);
		
		// unique ID of record to be edited
		$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		//$id="2"; $stmt->bindParam(':id', $id,PDO::PARAM_INT);
	
		// execute the query
		if($stmt->execute()){
			return true;
		}
		else { print_r($stmt->errorInfo());}
		
		return false;
	}
	
	public function update_resetpass2(){
	
		$query = "UPDATE " . $this->table_name . "
				SET
					password = :password,
					forgotten_password_code = :forgotten_password_code,
					forgotten_password_time = :forgotten_password_time,
					lastModified = :lastModified 
				WHERE id = :id";
	
		// prepare the query
		$stmt = $this->conn->prepare($query);
	
		// sanitize
		//$this->firstname=htmlspecialchars(strip_tags($this->firstname));
		//$this->lastname=htmlspecialchars(strip_tags($this->lastname));
		//$this->email=htmlspecialchars(strip_tags($this->email));
	
		// bind the values from the form
		$today = date('Y-m-d H:i:s');
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':forgotten_password_code', $this->forgotten_password_code);
		$stmt->bindParam(':forgotten_password_time', $this->forgotten_password_time);
		$stmt->bindParam(':lastModified', $today);
		
		// unique ID of record to be edited
		$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		//$id="2"; $stmt->bindParam(':id', $id,PDO::PARAM_INT);
	
		// execute the query
		if($stmt->execute()){
			return true;
		}
		else { print_r($stmt->errorInfo());}
		
		return false;
	}
}
?>