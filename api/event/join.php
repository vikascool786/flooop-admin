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
include_once '../objects/event.php';
include_once '../objects/mail.php';
  
$database = new Database();
$db = $database->getConnection();
  
$ea = new Event_Attendees($db);
$user = new User($db);
$event = new Event($db);
$mail = new Mail($db);
  
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
		//$ea->user_id = $decoded->data->id; //$data->user_id;
		//$ea->event_id = $data->event_id;
    	$stmt = $ea->find(['event_id'=>$data->event_id,'user_id'=>$userId]);
		$num = $stmt->rowCount(); //echo '<br>num:'.$num; exit;
		  
		// check if more than 0 record found
		if($num>0){
			// set response code - 201 created
        	http_response_code(409);
  
        	// tell the user
        	echo json_encode(array("message" => "Conflict! Event already joined."));
	
		}
		else { 
			// set event property values
			$ea->user_id = $userId;
			$ea->event_id = $data->event_id;
			$ea->status =	'CONFIRM'; 
			$ea->addDate = date('Y-m-d H:i:s');
			$ea->lastModified = date('Y-m-d H:i:s');
		
    	// create the event
    	if($ea->create()){
  			
			$stmt = $user->readSingle(['id'=>$userId]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$stmt_event = $event->readSingle(['id'=>$data->event_id]);
			$row_event = $stmt_event->fetch(PDO::FETCH_ASSOC);
			
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
			
			// Email Sending
			if($_SERVER['HTTP_HOST']!='localhost'){
				$options = [
					'mailType' => 'EVENT-SUBSCRIBE',
					'to' => $row['email'],
					'Subject' => 'Congratulation on joining Flooop event "'.$row_event['event_title'].'"',
					'event_id'=>$data->event_id,
					'event_title'=>$row_event['event_title'],
					'event_host'=>$row_event['first_name'].'&nbsp;'.$row_event['last_name'],
					'event_datetime'=>date("M d, Y",strtotime($row_event['event_date'])).'&nbsp;'.date("H:i",strtotime($row_event['event_start'])).'&nbsp;'.$row_event['timezone_title'],
					'event_duration'=>$row_event['event_duration'].' Minutes',
				];
				$mail->send($options);
			}
			// email sending ends
							
        	// set response code - 201 created
        	http_response_code(201);
  
        	// tell the user
        	echo json_encode(array("message" => "Event joined successfully.", "jwt" => $jwt));
    	}
  		// if unable to create the product, tell the user
    	else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to join event."));
    }
	
	} // if num>0
	
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
    echo json_encode(array("message" => "Unable to join event. Data is incomplete."));
}

?>