<?php
	ini_set('display_errors','1');
	// Report all PHP errors (see changelog)
	error_reporting(E_ALL);	// E_ERROR | E_WARNING | E_PARSE | E_ALL | 0

// required headers
//header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// files needed to connect to database
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/user.php';

include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

//require_once '../libs/google-api-php-client/src/Client.php';
require_once '../libs/google-api-php-client/vendor/autoload.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$user = new User($db);

// get posted data
//$data = json_decode(file_get_contents("php://input"));
$data = $_POST; $data = json_encode($data); $data = json_decode($data);
//print_r($data); //exit;  


//$client_id = '430299638290-0ncq4i2q1n6j40vvr4m2ic5f4rlbpjt6.apps.googleusercontent.com'; // google api, ans server.
$id_token = $data->id_token;
$oauth_data_google = ['token'=>$id_token];
//$client = new Google_Client(['client_id' => $client_id]);  // Specify the CLIENT_ID of the app that accesses the backend
$client = new Google\Client(['client_id' => $client_id]); //new Client(['client_id' => $client_id]);
$payload = $client->verifyIdToken($id_token); //print_r($payload); exit;
if ($payload) {
  $userid = $payload['sub'];
  $email = $payload['email'];
  $name = $payload['name'];
  $picture = $payload['picture'];	  
  // If request specified a G Suite domain:
  //$domain = $payload['hd'];
} else {
  // Invalid ID token
  // set response code
    http_response_code(401);
 
    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}


// make sure data is not empty
#TODO - PUT FULL VALIDATION/SECURITY

// set user property values
$user->email = $email;
$email_exists = $user->emailExists();

// generate json web token

/*include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;*/
 
// generate jwt will be here
// check if email exists and if password is correct
//if($email_exists && password_verify($data->password, $user->password))
if($email_exists){
 
    $token = array(
       "iat" => $issued_at,
       "exp" => $expiration_time,
       "iss" => $issuer,
       "data" => array(
           "id" => $user->id,
           "first_name" => $user->first_name,
           "last_name" => $user->last_name,
           "email" => $user->email
       )
    );
 
    // set response code
    http_response_code(200);
 
    // generate jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
				"id" => $user->id,
				"email" => $user->email
            )
        );
 
}
 
// login failed will be here
// login failed
else{
 
    // set response code
    //http_response_code(401);
 
    // tell the user login failed
    //echo json_encode(array("message" => "Login failed."));
	
	// Create User.
	$password = mt_rand();
	$user->oauth_type = 'GOOGLE';
	$user->oauth_data_google = json_encode($oauth_data_google);
	
	$firstName = $lastName = '';
	if($name!=''){
		$nameArr = explode(" ",$name);
		$firstName = $nameArr[0];
		if(isset($nameArr[1]))$lastName = $nameArr[1];
	}
    // set event property values
    $user->ip_address = ''; //$data->host_id;
	$user->username = $email;
    $user->password = $password;
    $user->salt = '';
    $user->email = $email;
	$user->activation_code = '';
	$user->forgotten_password_code = '';
	$user->forgotten_password_time = '';
	$user->remember_code = ''; 
	$user->created_on = date('Y-m-d H:i:s');
	$user->last_login = date('Y-m-d H:i:s');
	$user->active = '1';
	$user->first_name = $firstName;
	$user->last_name = $lastName;
	$user->company	 = '';
	$user->phone = '';
	
    $user->addDate = date('Y-m-d H:i:s');
	$user->lastModified = date('Y-m-d H:i:s');
  	
    	// create the user.
		/*
			CC:
			1. user/create.php
			2. user/glogin.php
			3. user/flogin.php
			4. user/tlogin.php
			5. user/llogin.php
		*/
		$result = $user->create();
		
    	if($result){
  			$userId = $result;
			
			$token = array(
			   "iat" => $issued_at,
			   "exp" => $expiration_time,
			   "iss" => $issuer,
			   "data" => array(
				   "id" => $userId,
				   "first_name" => $firstName,
				   "last_name" => $lastName,
				   "email" => $email
			   )
			);
 
    		// set response code
    		http_response_code(200);
 
    		// generate jwt
    		$jwt = JWT::encode($token, $key);
    		echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
				"id" => $userId,
				"email" => $email
            )
        );
		}
		else{
  
        	// set response code - 503 service unavailable
        	 http_response_code(401);
 
    		// tell the user login failed
		    echo json_encode(array("message" => "Login failed."));
    	}	
	// Create User ends.
}

?>