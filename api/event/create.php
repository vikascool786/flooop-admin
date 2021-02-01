<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

include_once '../config/database.php';
  
// instantiate product object
include_once '../objects/event.php';
include_once '../objects/user.php';
include_once '../objects/event_cat_match.php';
include_once '../objects/event_lang_match.php';
  
$database = new Database();
$db = $database->getConnection();
  
$event = new Event($db);
$user = new User($db);
$ecm = new EventCatMatch($db);
$elm = new EventLangMatch($db);
  
// get posted data
//$data = json_decode(file_get_contents("php://input"));
$data = $_POST; $data = json_encode($data); $data = json_decode($data);
// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
//print_r($data); exit;  
// make sure data is not empty
#TODO - PUT FULL VALIDATION/SECURITY

if(
    !empty($data->event_title) &&
    !empty($data->event_description) &&
    //!empty($data->event_image) &&
    !empty($data->event_date) && 
	//!empty($data->event_start) && 
	!empty($data->event_duration) && 
	$jwt
){
  	
	// validate the jwt present {
		if($jwt)
		{
			try {
				// decode jwt
				$decoded = JWT::decode($jwt, $key, array('HS256'));
				$userId = $decoded->data->id;
				
				$stmt_user = $user->readSingle(['id'=>$userId]);
				$rowUser = $stmt_user->fetch(PDO::FETCH_ASSOC);
					
				// regenerate jwt will be here
				// we need to re-generate jwt because user details might be different
				$token = array(
				   "iat" => $issued_at,
				   "exp" => $expiration_time,
				   "iss" => $issuer,
				   "data" => array(
					   "id" => $userId,
					   "first_name" => $rowUser['first_name'],
					   "last_name" => $rowUser['last_name'],
					   "email" => $rowUser['email']
				   )
				);
				$jwt = JWT::encode($token, $key);
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
				exit;
			}
		}
		
		// } validate the jwt present and if ...
		
		
  	$event_image = 'default.jpg';
	if($_FILES['file']['name']!='')
	{
		 $target_dir = PROJECT_ROOT_PATH."/upload/events/";
		 $file = $_FILES['file']['name'];
		 $path = pathinfo($file);
		 $filename = time(); //$path['filename'];
		 $ext = $path['extension'];
		 $temp_name = $_FILES['file']['tmp_name'];
		 $path_filename_ext = $target_dir.$filename.".".$ext;
		 

		// Check if file already exists
		if (file_exists($path_filename_ext)) {
		 	//echo "Sorry, file already exists.";
		 	//echo "if";
			
		 }else{
		 	//echo "else";
		 	move_uploaded_file($temp_name,$path_filename_ext);
		 	//echo "Congratulations! File Uploaded Successfully.";
			$event_image = $filename.".".$ext;
		 }	
		 
	}
	
	// event_start
	//if($data->event_start_AmPm=='PM') $data->event_start_hours = $data->event_start_hours + 12;
	$event_start = $data->event_start_hours.':'.$data->event_start_minutes;
	
	$event_ampm = strtoupper($data->event_start_AmPm);
	
    // set event property values
    $event->host_id = $userId; //$data->host_id;
	$event->event_cost = '0';
	$event->event_currency = NULL;
	$event->event_title = $data->event_title;
    $event->event_desc = $data->event_description;
    $event->event_image = $event_image;
    $event->event_date = $data->event_date;
	$event->event_start = $event_start;
	$event->event_ampm = $event_ampm;
	$event->event_duration = $data->event_duration;
	$event->timezone = $data->event_start_timezone;
	$event->status = '1'; //$data->status;
	$event->event_tags = $data->event_keywords;
	$event->event_lang = '1';
	$event->max_group_size = $data->event_group;
	$event->event_attendees_do = $data->event_attendees_do;
	$event->event_attendees = $data->event_attendees;
	$event->attendees_can_invite	 = $data->event_invite;
	$event->display_attendees = $data->event_name_display;
	$event->event_cohost = $data->event_hosts;
	$event->event_question = $data->event_questions;
	
    $event->addDate = date('Y-m-d H:i:s');
	$event->lastModified = date('Y-m-d H:i:s');
  	
	$result = $event->create();  //echo 'result:'.$result; exit;
    // create the event
    //if($event->create())
	if($result){
  		$event_id = $result; 
		// save 'event_cat_match' table
		if($data->event_categories!=''){
			$arr_cat = explode(",",$data->event_categories); 
			foreach($arr_cat as $key=>$val){
				$cat_id = $val; 
				$ecm->event_id = $event_id;
				$ecm->cat_id = $cat_id;
    			$ecm->addDate = date('Y-m-d H:i:s');
				$ecm->create(); 
			}
		}
		
		// save 'event_lang_match' table
		if($data->event_languages!=''){
			$arr_lang = explode(",",$data->event_languages); 
			foreach($arr_lang as $key=>$val){
				$lang_id = $val; 
				$elm->event_id = $event_id;
				$elm->lang_id = $lang_id;
    			$elm->addDate = date('Y-m-d H:i:s');
				$elm->create(); 
			}
		}
    	
		
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Event was created.", "event_id" => $event_id));
    }
  
    // if unable to create the product, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create event."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create event. Data is incomplete."));
}


function check_file_exists_here($url){
   $result=get_headers($url);
   return stripos($result[0],"200 OK")?true:false; //check if $result[0] has 200 OK
}
?>