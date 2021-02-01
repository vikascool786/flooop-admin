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
include_once '../objects/user_fav_events.php';
include_once '../objects/user.php';
include_once '../objects/logs.php';
  
$database = new Database();
$db = $database->getConnection();
  
$ef = new User_Fav_Events($db);
$user = new User($db);
$logs = new Logs($db);
  
// get posted data
//$data = json_decode(file_get_contents("php://input"));
$data = $_POST; $data = json_encode($data); $data = json_decode($data);
// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
//print_r($data); exit;  
// make sure data is not empty
#TODO - PUT FULL VALIDATION/SECURITY

if(
    !empty($data->event_id) && $jwt 
){
	
	try {

        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
		$userId = $decoded->data->id;
		// check if already joined or not?
		$stmt = $ef->find(['event_id'=>$data->event_id,'user_id'=>$userId]);
		$num = $stmt->rowCount(); //echo '<br>num:'.$num; exit;
		  
		// check if more than 0 record found
		if($num<=0){
			$ef->user_id = $userId;
			$ef->event_id = $data->event_id;
			
			if($ef->create())
			{
				// set event property values
				$logs->user_id = $userId;
				$logs->task = 'EVENT_FAV_ADD';
				$logs->description =	'Event added as favourite by user'; 
				$logs->entity_id =	$data->event_id; 
				$logs->entity_title =	''; 
				$logs->ipAddr =	$_SERVER['REMOTE_ADDR']; 
				$logs->extraDetail =	''; 
				$logs->addDate = date('Y-m-d H:i:s');
				$logs->create();
				
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
					
					// set response code - 201 created
					http_response_code(200);
		  
					// tell the user
					echo json_encode(array("message" => "Event added in favourites successfully.", "jwt" => $jwt));
				
  			}
			else{
  
        		// set response code - 503 service unavailable.
        		http_response_code(503);
  
        		// tell the user
        		echo json_encode(array("message" => "Unable to process your request."));
    		}	
		}
		else { 
			
			$ef->user_id = $userId;
			$ef->event_id = $data->event_id;
			if($ef->delete())
			{
				// set event property values
				$logs->user_id = $userId;
				$logs->task = 'EVENT_FAV_REMOVE';
				$logs->description = 'Event removed as favourite  by user'; 
				$logs->entity_id =	$data->event_id; 
				$logs->entity_title =	''; 
				$logs->ipAddr =	$_SERVER['REMOTE_ADDR']; 
				$logs->extraDetail =	''; 
				$logs->addDate = date('Y-m-d H:i:s');
				$logs->create();
				
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
					
					// set response code - 201 created
					http_response_code(200);
		  
					// tell the user
					echo json_encode(array("message" => "Event removed from favourites successfully.", "jwt" => $jwt));
				
  			}
			else{
  
        		// set response code - 503 service unavailable.
        		http_response_code(503);
  
        		// tell the user
        		echo json_encode(array("message" => "Unable to process your request."));
    		}
	
		} // if num<=0
	
	}
	// catch will be here
	// if decode fails, it means jwt is invalid
	catch (Exception $e)
	{
	 
		// set response code
		http_response_code(401);
	 
		// tell the user access denied  & show error message
		echo json_encode(array(
			"message" => "Token expired, please login again.",
			"error" => $e->getMessage()
		));
	}
}
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to cancel event. Data is incomplete."));
}

?>