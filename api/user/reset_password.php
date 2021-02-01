<?php
/*$a = '1852605273';
$password_hash = password_hash($a, PASSWORD_BCRYPT);
echo 'a:'.$a.',PASSWORD_BCRYPT: '.PASSWORD_BCRYPT.' <br>password hash: '.$password_hash;
exit;*/

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
    !empty($data->code) && 
	!empty($data->password) && 
	!empty($data->password_confirm) 
){
	
	// set user property values
	$code = $data->code; //password_hash($data->code, PASSWORD_BCRYPT); ;
	$stmt = $user->readSingle(['code'=>$code]);
	$num = $stmt->rowCount(); //echo '<br>num:'.$num; exit;
		  
	// check if more than 0 record found
	if($num>0){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			// query user
			$password_new = password_hash($data->password, PASSWORD_BCRYPT);
			
			$user->password = $password_new;
			$user->forgotten_password_code = '';
			$user->forgotten_password_time = '';
			$user->lastModified = date('Y-m-d H:i:s');
			$user->id = $row['id'];
			
			if($user->update_resetpass2())
			{
				// set response code
				http_response_code(200);
				
				// response in json format
				echo json_encode(
					array(
						"message" => "Password reset successfully",
					)
				);	
			}
			// message if unable to update user
			else{
				// set response code
				http_response_code(401);
		
				// show error message
				echo json_encode(array("message" => "Unable to process request."));
			}
		
		
		}
		else {
			
				// set response code
				http_response_code(401);
		
				// show error message
				echo json_encode(array("message" => "Unable to process request."));
						
		}
}
else
{
	// set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to process request. Data is incomplete."));	
}