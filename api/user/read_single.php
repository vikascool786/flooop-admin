<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/user.php';


  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$user = new User($db);
// $path = APPLICATION_URL.'upload/avatar/';
$path = 'http://floooplife.com/flooopadmin/upload/avatar/'; 

//$data = json_decode(file_get_contents("php://input"));
$data = $_POST; $data = json_encode($data); $data = json_decode($data);
$id = $data->id;
 //print_r($data); exit;  
  
// read products will be here

// query event
$stmt = $user->readSingle(['id'=>$id]);
$num = $stmt->rowCount();
//echo 'num:'.$num;  
// check if more than 0 record found
if($num>0){
  
    // products array
    $user_arr=array();
    $user_arr["records"]=array();
  
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
  
        array_push($user_arr["records"], $user_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($user_arr);
}
  // no products found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No user found.")
    );
}