<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/event.php';
include_once '../objects/event_cat_match.php';
include_once '../objects/event_lang_match.php';

  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$event = new Event($db);
$ecm = new EventCatMatch($db);
$elm = new EventLangMatch($db);
$path = APPLICATION_URL.'upload/events/';

//$data = json_decode(file_get_contents("php://input"));
$data = $_POST; $data = json_encode($data); $data = json_decode($data);
$eid = $data->id;
 //print_r($data); exit;  
  
// read products will be here

// query event
$stmt = $event->readSingle(['id'=>$eid]);
$num = $stmt->rowCount();
//echo 'num:'.$num;  
// check if more than 0 record found
if($num>0){
  
    // products array
    $events_arr=array();
    $events_arr["records"]=array();
  
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
		$path_root = PROJECT_ROOT_PATH.'/upload/events/'.$event_image;
		if(file_exists($path_root) && $event_image!='')
		{
			$path_http = $path.$event_image;	
		}
  		$event_date_value = '';
		if($event_date!='')
		{
			$event_date_value = date("l, F d",strtotime($event_date));
		}
		$event_duration_value = '';
		if($event_duration!='')
		{
			$event_duration_value = $event_duration.' Minutes';	
		}
		$event_start_value = '';
		if($event_start!='')
		{
			$arr = explode(":",$event_start);
			$hour = $arr[0];
			$ampm = 'AM';
			if($hour>12){
				$hour = $hour-12;	
				$ampm = 'PM';
			}
			$event_start_value = $hour.':'.$arr[1].' '.$ampm;
		}
		
  		$event_lang_arr = $event_cat_arr = [];
		$stmt_ecm = $ecm->read(['event_id'=>$id]);
		$num_ecm = $stmt_ecm->rowCount();	
		if($num_ecm>0)
		{
			while ($row_ecm = $stmt_ecm->fetch(PDO::FETCH_ASSOC))
			{
				$event_cat_arr[] = ['cat_id'=>$row_ecm['cat_id']];	
			}
		}
		$stmt_elm = $elm->read(['event_id'=>$id]);
		$num_elm = $stmt_elm->rowCount();	
		if($num_elm>0)
		{
			while ($row_elm = $stmt_elm->fetch(PDO::FETCH_ASSOC))
			{
				$event_lang_arr[] = ['lang_id'=>$row_elm['lang_id']];	
			}
		}
			
        $event_item=array(
            "id" => $id,
            "event_title" => ucwords($event_title),
			"host_id" => $host_id,
			"event_date" => $event_date_value,
			"event_start" => $event_start_value,
			"event_duration" => $event_duration_value,
			"timezone" => $timezone_title,
			"event_image" => $event_image,
			"path" => $path_http,
			"event_desc" => html_entity_decode($event_desc),
            "event_tags" => $event_tags,
			"event_languages" => $event_lang_arr,
			"event_categories" => $event_cat_arr,
			"max_group_size" => $max_group_size,
			"event_attendees_do" => $event_attendees_do,
			"event_attendees" => $event_attendees,
			"attendees_can_invite" => $attendees_can_invite,
			"display_attendees" => $display_attendees,
			"event_cohost" => $event_cohost,
			"event_question" => $event_question,
            "status" => $status,
        );
  
        array_push($events_arr["records"], $event_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($events_arr);
}
  // no products found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No event found.")
    );
}