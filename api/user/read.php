<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$user = new User($db);
// $path = APPLICATION_URL.'upload/avatar/';
$path = 'http://floooplife.com/flooopadmin/upload/avatar/'; 
  
// read products will be here

// query products
$stmt = $user->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // users array
    $users_arr=array();
    $users_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  		
		$path_http = $path.'default.jpg';
		// $path_root = PROJECT_ROOT_PATH.'/upload/avatar/'.$profilephoto;
		$path_root = 'http://floooplife.com/flooopadmin/upload/avatar/'.$profilephoto;
		if(file_exists($path_root) && $profilephoto!='')
		{
			$path_http = $path.$profilephoto;	
		}
		
        $user_item=array(
            "id" => $id,
            "ip_address" => $ip_address,
			"username" => $username,
			"password" => $password,
			"salt" => $salt,
			"email" => $email,
			"activation_code" => $activation_code,
			"forgotten_password_code" => $forgotten_password_code,
			"forgotten_password_time" => $forgotten_password_time,
            "remember_code" => $remember_code,
            "created_on" => $created_on,
			"last_login" => $last_login,
			"active" => $active,
			"first_name" => $first_name,
			"last_name" => $last_name,
			"profilephoto" =>$profilephoto,
			"path" =>$path_http,
			"company" => $company,
			"phone" => $phone,
			"addDate" => $addDate,
			"lastModified" => $lastModified,
        );
  
        array_push($users_arr["records"], $user_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show users data in json format
    echo json_encode($users_arr);
}
  // no users found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no users found
    echo json_encode(
        array("message" => "No users found.")
    );
}