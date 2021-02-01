<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



// files for decoding jwt will be here
// required to encode json web token
include_once '../config/core.php';

// files needed to connect to database
include_once '../config/database.php';
include_once '../objects/user.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate user object
$user = new User($db);

// retrieve given jwt here
// get posted data
//$data = json_decode(file_get_contents("php://input"));
$data = $_POST; $data = json_encode($data); $data = json_decode($data);
//print_r($data->email);

if(
    !empty($data->code)
	
){
	
	// set user property values
	$code = $data->code; //password_hash($data->code, PASSWORD_BCRYPT); ;
	$stmt = $user->readSingle(['code'=>$code]);
	$num = $stmt->rowCount(); //echo '<br>num:'.$num; exit;
		  
	// check if more than 0 record found
	if($num>0){
		// set response code
		http_response_code(200);

		// show error message
		echo json_encode(array("message" => "Able to process request."));
	}
	else {
			
		// set response code
		http_response_code(404);

		// show error message
		echo json_encode(array("message" => "Unable to process request Link expired."));
				
	}
}
else
{
	// set response code - 400 bad request
    http_response_code(401);
  
    // tell the user
    echo json_encode(array("message" => "Unable to process request. Data is incomplete."));	
}