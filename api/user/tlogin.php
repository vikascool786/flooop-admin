<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/user.php';
include_once '../../twitteroauth/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$user = new User($db);

if(!empty($_POST))$data = $_POST;else $data = $_GET; 
$data = json_encode($data); $data = json_decode($data);
$oauth_token = $data->oauth_token;
$oauth_verifier = $data->oauth_verifier;
$session_oauth_token = $data->session_oauth_token;
$session_oauth_token_secret = $data->session_oauth_token_secret;
//print_r($data); exit;

if ($session_oauth_token !== $oauth_token) {
    // Abort! Something is wrong.
	http_response_code(404);
	
	echo json_encode(array(
		"message" => "not found.",
		"error" => "not found",
	));
}

//$connection = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET);
$connection = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET, $session_oauth_token, $session_oauth_token_secret);

//$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => TW_OAUTH_CALLBACK));
$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $oauth_verifier]);

//$_SESSION['access_token'] = $access_token;

// Authenticated requests

// Now we make a TwitterOAuth instance with the users access_token.
$connection = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

/*
	Get account details

At this point we will use the access token that is authorized to act as the user, to get their account details. 
*/

$user_tw = $connection->get('account/verify_credentials', ['tweet_mode' => 'extended', 'include_entities' => 'true','include_email'=>'true']);

//print_r($access_token);
//print_r($user_tw);

$userIdTW = $user_tw->id;
$name = $user_tw->name;
$userArr = explode(" ",$name);
$firstName = $userArr[0];
$lastName = (isset($userArr[1]))?$userArr[1]:"";
$email = $user_tw->email;
//echo '$firstName:'.$firstName.', lastName: '.$lastName;exit;
// set user property values
$user->email = $email;
$email_exists = $user->emailExists();

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
	$oauth_data_twitter = ['access_token'=>$access_token];
	
	// profile image
	$url_to_image = $user_tw->profile_image_url_https;
	$target_dir = PROJECT_ROOT_PATH."/upload/avatar/";
	$filename = basename($url_to_image);
	$path = $target_dir.$filename;
	file_put_contents($path,file_get_contents($url_to_image));
	
	
    // set event property values
    $user->oauth_type = 'TWITTER';
	$user->oauth_data_twitter = json_encode($oauth_data_twitter);
	$user->profilephoto = $filename;
	
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
			5. 
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

exit;