<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/event.php';
include_once '../objects/event_attendees.php';
include_once '../objects/event_cat_match.php';
include_once '../objects/event_lang_match.php';
include_once '../objects/user.php';
include_once '../objects/user_fav_events.php';

include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$event = new Event($db);
$ecm = new EventCatMatch($db);
$elm = new EventLangMatch($db);
$ea = new Event_Attendees($db);
$user = new User($db);
$ef = new User_Fav_Events($db);
$path = APPLICATION_URL.'upload/events/';
$pathUser = APPLICATION_URL.'upload/avatar/';

//$data = json_decode(file_get_contents("php://input"));
$data = $_POST; $data = json_encode($data); $data = json_decode($data);
$eid = $data->id;
// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";

// check if jwt present and if user is already joined or not {
$userId = '0';
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
		//http_response_code(401);
	 
		// tell the user access denied  & show error message
		/*echo json_encode(array(
			"message" => "Access denied.",
			"error" => $e->getMessage()
		));*/
		//$events_arr["jwt"]= "";
		//$flag_joined = NULL;
	}
}
		
// } check if jwt present and if ...
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
	$events_arr["jwt"]= $jwt;
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
		
		$flag_joined = NULL;
		$flag_fav = NULL;
		
		if($userId!='0'){
			$flag_joined = '0';
			$flag_fav = '0';
			
			$stmt_ea = $ea->find(['event_id'=>$id,'user_id'=>$userId]);
			$num = $stmt_ea->rowCount(); //echo '<br>num:'.$num; exit;
			if($num>0)
			$flag_joined = '1';
			
			$stmt_ef = $ef->find(['event_id'=>$id,'user_id'=>$userId]);
			$num = $stmt_ef->rowCount(); //echo '<br>num:'.$num; exit;
			if($num>0)
			$flag_fav = '1';		
		}
		
		$path_http = $path.'default.jpg';
		//print_r(PROJECT_ROOT_PATH);exit;
		$path_root = PROJECT_ROOT_PATH.'/upload/events/'.$event_image;
		if(file_exists($path_root )  && $event_image!='')
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
		$event_start_value = $event_start_hours = $event_start_minutes = ''; 
		if($event_start!='')
		{
			$arr = explode(":",$event_start);
			$hour = $arr[0];
			/*$ampm = 'AM';
			if($hour>12){
				$hour = $hour-12;	
				$ampm = 'PM';
			}*/
			$ampm = $event_ampm;
			$event_start_value = $hour.':'.$arr[1].' '.$ampm;
			$event_start_hours = $hour;
			$event_start_minutes = $arr[1];
		}
		$event_countdown_label = '';
		if($event_date!='')
		{
			$t1 = strtotime($event_date_value.' '.$event_start);
			$t2 = time();
			$countDownPoint = 2*60*60;
			if($t1-$t2<=$countDownPoint)
			$event_countdown_label = '2 hours (120 Minutes) until start';		
		}
		
		$event_cost_label = 'FREE';
		if($event_cost!=NULL && $event_cost!='0')
		{
			$event_cost_arr = getCurrencyFormat($event_cost,$currency_code,$currency_symbol);	// getCurrencyFormat($price,$currency,$symbol)		
			$event_cost_label = $event_cost_arr['priceLabel'];
		}
		
  		$event_lang_arr = $event_cat_arr = $event_hosts_arr = $event_attendees_arr = $event_conversations_arr = $event_reviews_arr = [];
		$stmt_ecm = $ecm->read(['event_id'=>$id]);
		$num_ecm = $stmt_ecm->rowCount();	
		if($num_ecm>0)
		{
			while ($row_ecm = $stmt_ecm->fetch(PDO::FETCH_ASSOC))
			{
				$event_cat_arr[] = ['cat_id'=>$row_ecm['cat_id']];	
			}
		}
		
		$event_lang_label = ''; $sep = '';
		$stmt_elm = $elm->read(['event_id'=>$id]);
		$num_elm = $stmt_elm->rowCount();	
		if($num_elm>0)
		{
			while ($row_elm = $stmt_elm->fetch(PDO::FETCH_ASSOC))
			{
				$event_lang_arr[] = ['lang_id'=>$row_elm['lang_id']];	
				$event_lang_label .= $sep.$row_elm['lang_title'];
				$sep = ',';
			}
		}
		
		$path_img = $pathUser.'default.jpg';
		$path_img_default = $pathUser.'default.jpg';
		$event_hosts_arr = [
			['first_name'=>'John','last_name'=>'Doe','path_img'=>$path_img,'path_img_default'=>$path_img_default,'rating'=>'4.99','reviews_count'=>'80','message'=>'Lorem Ipsum has been the industry standard dummy text ever since the 1500s.When an unknown Lorem Ipsum has been the industry standard dummy text ever since the 1500s :)']
		];
		/*$event_attendees_arr = [
			['first_name'=>'Maria','last_name'=>'Sharapowa','path_img'=>$path_img,'path_img_default'=>$path_img_default]
		];*/
		$stmt_ea = $ea->find(['event_id'=>$eid]);
		$num_ea = $stmt_ea->rowCount();
		//echo 'num_ea:'.$num_ea; exit; 
		// check if more than 0 record found
		if($num_ea>0){
			while ($row_ea = $stmt_ea->fetch(PDO::FETCH_ASSOC))
			{
				$event_attendees_arr[] = 
					['first_name'=>$row_ea['first_name'],'last_name'=>$row_ea['last_name'],'path_img'=>$path_img,'path_img_default'=>$path_img_default];	
			}
		}
		
		$event_conversations_arr = [
			['first_name'=>'Maria','last_name'=>'Sharapowa','path_img'=>$path_img,'path_img_default'=>$path_img_default,'message'=>'Lorem Ipsum has been the industry standard dummy text ever since the 1500s.When an unknown Lorem Ipsum has been the industry standard dummy text ever since the 1500s :)'],
		];
		
		$event_reviews_arr = [
			['first_name'=>'Maria','last_name'=>'Sharapowa','path_img'=>$path_img,'path_img_default'=>$path_img_default,'review_date'=>'June 2020','rating'=>'5','message'=>'Lorem Ipsum has been the industry standard dummy text ever since the 1500s.When an unknown Lorem Ipsum has been the industry standard dummy text ever since the 1500s :)'],
		];
		$event_rating = '4.9';
		$event_reviews_count = '80';
		$event_things_to_keep = 'My name is john,I am a doctor I am good man ';
		//print_r($event_cohost);	
        $event_item=array(
            "id" => $id,
            "event_title" => ucwords($event_title),
			"host_id" => $host_id,
			"event_cost" => $event_cost,
			"event_currency" => $event_currency,
			"event_cost_label" => $event_cost_label,
			"event_date" => $event_date_value,
			"event_date2" => date('Y-m-d',strtotime($event_date)),	// yy-mm-dd format
			"event_start" => $event_start_value,
			"event_start_hours" => $event_start_hours,
			"event_start_minutes" => $event_start_minutes,
			"event_ampm" => $event_ampm,
			"event_duration" => $event_duration_value,
			"timezone" => $timezone_title,
			"timezone_id" => $timezone,
			"event_countdown_label" => $event_countdown_label,
			"event_image" => $event_image,
			"path" => $path_http,
			"event_desc" => html_entity_decode($event_desc),
            "event_tags" => $event_tags,
			"event_languages" => $event_lang_arr,
			"event_lang_label" => $event_lang_label,
			"event_categories" => $event_cat_arr,
			"max_group_size" => trim($max_group_size),
			"event_attendees_do" => $event_attendees_do,
			"event_attendees" => $event_attendees,
			"attendees_can_invite" => $attendees_can_invite,
			"display_attendees" => $display_attendees,
			"event_question" => $event_question,
			"event_hosts" => $event_hosts_arr,
			"event_cohost" => $event_cohost,
			"event_attendees2" => $event_attendees_arr, // who attending the event
			"event_conversations" => $event_conversations_arr,
			"event_reviews" => $event_reviews_arr,
			"event_rating" => $event_rating,
			"event_reviews_count" => $event_reviews_count,
			"event_things_to_keep" => $event_things_to_keep,
			"zoom_id" => $zoom_id,
			"zoom_password" => $zoom_password,
			"zoom_url" => $zoom_url,
            "status" => $status,
			"flag_joined" => $flag_joined,
			"flag_fav" => $flag_fav,
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

function check_file_exists_here($url){
   $result=get_headers($url);
   return stripos($result[0],"200 OK")?true:false; //check if $result[0] has 200 OK
}