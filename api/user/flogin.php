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
require_once '../libs/php-graph-sdk/vendor/autoload.php';
 
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
$accessToken = $data->accessToken;
$fbUserId = $data->userId;
$oauth_data_facebook = ['accessToken'=>$accessToken,'fbUserId'=>$fbUserId]; //print_r($oauth_data_facebook); exit;

$fb = new \Facebook\Facebook([
  'app_id' => $fb_app_id,
  'app_secret' => $fb_app_secret,
  'default_graph_version' => 'v2.10',
  //'default_access_token' => '{access-token}', // optional
]);

try {
  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  //$response = $fb->get('/me', $accessToken);
  //$response = $fb->get('/me?fields=id,email,first_name,last_name,profile_pic', $accessToken);
  $response = $fb->get(
  '/me?fields=id,email,first_name,last_name',
  $accessToken);
  //echo 'response:';print_r($response);
} catch(\Facebook\Exceptions\FacebookResponseException $e) 
{
  // When Graph returns an error
  //echo 'Graph returned an error: ' . $e->getMessage();
  //exit;
  http_response_code(401);
  //print_r($e);
  // tell the user login failed
  echo json_encode(array("message" => "Login failed."));
	
} catch(\Facebook\Exceptions\FacebookSDKException $e) 
{
  // When validation fails or other local issues
  //echo 'Facebook SDK returned an error: ' . $e->getMessage();
  //exit;
  //print_r($e);
  http_response_code(401);
 
    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}


// to get profile picture,
/*try {
  // Returns a `FacebookFacebookResponse` object
  $response2 = $fb->get(
    '/'.$fbUserId.'/picture',
    $accessToken
  );
} catch(FacebookExceptionsFacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(FacebookExceptionsFacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$graphNode2 = $response2->getGraphNode();
print_r($response2); print_r($graphNode2); exit;*/
//

$me = $response->getGraphUser(); //print_r($response);
$graphNode = $response->getGraphNode(); //print_r($graphNode); exit;

$userIdFb = $me->getId();
//$name = $me->getName();
$firstName = $me->getFirstName();
$lastName = $me->getLastName();
$name = $firstName.' '.$lastName;
$email = $me->getEmail();
//echo 'Logged in as ' . $me->getName();
//echo 'Logged in as :' . $name.', email: '.$email.', userIdFb: '.$userIdFb;
//print_r($me);
//print_r($graphNode);//
//exit;


// make sure data is not empty
#TODO - PUT FULL VALIDATION/SECURITY

// set user property values
$user->email = $email;
$email_exists = $user->emailExists();

// generate json web token

 
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
	
	$user->oauth_type = 'FACEBOOK';
	$user->oauth_data_fb = json_encode($oauth_data_facebook);
	
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