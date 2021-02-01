<?php
//https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
// required headers
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
// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
//print_r($data->email);

if(
    $jwt && 
	!empty($data->password) && 
	!empty($data->password_old) && 
	!empty($data->password_confirm) 
){
	
	try {

        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
		$userId = $decoded->data->id;
		
		$stmt = $user->readSingle(['id'=>$userId]);
		$num = $stmt->rowCount();
		if($num<=0){
			// set response code - 201 created
        	http_response_code(404);
  
        	// tell the user
        	echo json_encode(array("message" => "No user found!."));
		
		}
		else { 
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$passNew = $data->password;
			$passOld = $data->password_old;
			$passNewConfirm = $data->password_confirm;
			
			//$password_hash = password_hash($passOld, PASSWORD_BCRYPT);
			//$a = '$2y$10$Cn7EUD8UcrQQ8RwfcrQiwOZvwag.KbUBA5y9ss0a4eGIWQ.jGW7F2';
			//print_r($row);echo 'num: '.$num.', userId:'.$userId.', pass: '.$row['password'].' => '.$password_hash; exit;
			if(password_verify($passOld,$row['password'])){
			
				$user->password = $passNew;
				$user->lastModified = date('Y-m-d H:i:s');
				$user->id = $userId;
	
				if($user->change_password())
				{
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
			
				// set response code
				http_response_code(200);
				
				// response in json format
				echo json_encode(
					array(
						"message" => "Password changed successfully",
						"jwt" => $jwt
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
			else
			{
				// set response code - 406 not acceptable.
        		http_response_code(406);
  
        		// tell the user
        		echo json_encode(array("message" => "Conflict! old password not matched."));
		
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
			"message" => "Access denied.",
			"error" => $e->getMessage()
		));
	}
}
else
{
	// set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to process request. Data is incomplete."));	
}