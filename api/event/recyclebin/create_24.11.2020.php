<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/core.php';
include_once '../config/database.php';
  
// instantiate product object
include_once '../objects/event.php';
  
$database = new Database();
$db = $database->getConnection();
  
$event = new Event($db);
  
// get posted data
//$data = json_decode(file_get_contents("php://input"));
$data = $_POST; $data = json_encode($data); $data = json_decode($data);
//print_r($data); exit;  
// make sure data is not empty
#TODO - PUT FULL VALIDATION/SECURITY

if(
    !empty($data->event_title) &&
    !empty($data->event_description) &&
    //!empty($data->event_image) &&
    !empty($data->event_date) && 
	//!empty($data->event_start) && 
	!empty($data->event_duration) 
){
  
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
			
		 }else{
		 	move_uploaded_file($temp_name,$path_filename_ext);
		 	//echo "Congratulations! File Uploaded Successfully.";
			$event_image = $filename.".".$ext;
		 }	
	}
	
	// event_start
	if($data->event_start_AmPm=='PM') $data->event_start_hours = $data->event_start_hours + 12;
	$event_start = $data->event_start_hours.':'.$data->event_start_minutes;
	
    // set event property values
    $event->host_id = '1'; //$data->host_id;
	$event->event_title = $data->event_title;
    $event->event_desc = $data->event_description;
    $event->event_image = $event_image;
    $event->event_date = $data->event_date;
	$event->event_start = $event_start;
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
  	
    // create the event
    if($event->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Event was created."));
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
?>