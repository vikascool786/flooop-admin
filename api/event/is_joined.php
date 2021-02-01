<?php

// required headers
// https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// files for decoding jwt will be here
// required to encode json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
  
// get database connection
include_once '../config/database.php';
  
// instantiate product object
include_once '../objects/event_attendees.php';
include_once '../objects/user.php';
  
$database = new Database();
$db = $database->getConnection();
  
$ea = new Event_Attendees($db);
$user = new User($db);
  
// get posted data
//$data = json_decode(file_get_contents("php://input"));
$data = $_POST; $data = json_encode($data); $data = json_decode($data);
// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
$flag_joined = NULL;
//print_r($data); exit;  
// make sure data is not empty
#TODO - PUT FULL VALIDATION/SECURITY

if(
    !empty($data->event_id) && $jwt 
){
	
	try {
		$flag_joined = '0';
		
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
		$userId = $decoded->data->id;
		// check if already joined or not?
		$stmt = $ea->find(['event_id'=>$data->event_id,'user_id'=>$userId]);
		$num = $stmt->rowCount(); //echo '<br>num:'.$num; exit;
		
		$stmt = $user->readSingle(['id'=>$userId]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
		// regenerate jwt will be here
		// we need to re-generate jwt because user details might be different
		$token = array(
		   "iat" => $issued_at,
		   "exp" => $expiration_time,
		   "iss" => $issuer,
		   "data" => array(
			   "id" => $userId,
			   "first_name" => $row['first_name'],
			   "last_name" => $row['last_name'],
			   "email" => $row['email']
		   )
		);
		$jwt = JWT::encode($token, $key);
			  
		// check if more than 0 record found
		if($num>0){
			$flag_joined = '1';
			// set response code - 201 created
        	http_response_code(200);
  
        	// tell the user
        	echo json_encode(array("message" => "Conflict! Event already joined.", "jwt" => $jwt,"flag_joined"=>$flag_joined));
	
		}
		else { 
			// set response code - 201 created
        	http_response_code(200);
  
        	// tell the user
        	echo json_encode(array("message" => "Event not joined.", "jwt" => $jwt,"flag_joined"=>$flag_joined));
	
		} // if num>0
	
	}
	// catch will be here
	// if decode fails, it means jwt is invalid
	catch (Exception $e)
	{
	 	$flag_joined = NULL;
		// set response code
		http_response_code(401);
	 
		// tell the user access denied  & show error message
		echo json_encode(array(
			"message" => "Token expired, please login again.",
			"error" => $e->getMessage(),
			"flag_joined"=>$flag_joined
		));
	}
}
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to join event. Data is incomplete.","flag_joined"=>$flag_joined));
}

?>