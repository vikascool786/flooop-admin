<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here

// include database and object files
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

include_once '../config/database.php';
include_once '../objects/event.php';
include_once '../objects/event_attendees.php';
include_once '../objects/user.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$event = new Event($db);
$path = APPLICATION_URL.'upload/events/';
$user = new User($db);
$ea = new Event_Attendees($db);

// get posted data
//$data = json_decode(file_get_contents("php://input"));
$data = $_POST; $data = json_encode($data); $data = json_decode($data);
// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
  
// read products will be here

// query products
$stmt = $event->read();
$num = $stmt->rowCount();
  
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
		
		// check if jwt present and if user is already joined or not {
		$flag_joined = NULL;	 
		if($jwt)
		{
			try {
				$flag_joined = '0';
				// decode jwt
				$decoded = JWT::decode($jwt, $key, array('HS256'));
				$userId = $decoded->data->id;
				// check if already joined or not?
				$stmt = $ea->find(['event_id'=>$id,'user_id'=>$userId]);
				$num = $stmt->rowCount(); //echo '<br>num:'.$num; exit;
				
				$stmt = $user->readSingle(['id'=>$userId]);
				$rowUser = $stmt->fetch(PDO::FETCH_ASSOC);
					
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
				
				$events_arr["jwt"]= $jwt;
				
				if($num>0)
				$flag_joined = '1';
			}
			// catch will be here
			// if decode fails, it means jwt is invalid
			catch (Exception $e)
			{
			 
				// set response code
				http_response_code(401);
			 
				// tell the user access denied  & show error message
				echo json_encode(array(
					"message" => "Access denied.",
					"error" => $e->getMessage()
				));
			}
		}
		
		// } check if jwt present and if ...
		
		$path_http = $path.'default.jpg';
		$path_root = PROJECT_ROOT_PATH.'/upload/events/'.$event_image;
		if(file_exists($path_root) && $event_image!='')
		{
			$path_http = $path.$event_image;	
		}
  		
        $event_item=array(
            "id" => $id,
            "event_title" => $event_title,
			"host_id" => $host_id,
			"event_date" => $event_date,
			"event_start" => $event_start,
			"event_duration" => $event_duration,
			"timezone" => $timezone,
			"event_image" => $event_image,
			"path" => $path_http,
			"event_desc" => html_entity_decode($event_desc),
            "event_tags" => $event_tags,
			"event_lang" => $event_lang,
			"max_group_size" => $max_group_size,
			"event_attendees_do" => $event_attendees_do,
			"event_attendees" => $event_attendees,
			"attendees_can_invite" => $attendees_can_invite,
			"display_attendees" => $display_attendees,
			"event_cohost" => $event_cohost,
			"event_question" => $event_question,
            "status" => $status,
			"flag_joined" => $flag_joined
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
        array("message" => "No events found.")
    );
}