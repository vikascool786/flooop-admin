<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors','1');
	// Report all PHP errors (see changelog)
	error_reporting(E_ALL);	// E_ERROR | E_WARNING | E_PARSE | E_ALL | 0

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/user.php';


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
$code = $data->code;
$state = $data->state;
$session_state = $data->session_state;
//print_r($data); exit;

if ($session_state !== $state) {
    // Abort! Something is wrong.
	http_response_code(404);
	
	echo json_encode(array(
		"message" => "not found.",
		"error" => "not found",
	));
	exit;
}
$access_token = '';
$url = 'https://www.linkedin.com/oauth/v2/accessToken';
$redirect_uri = LI_OAUTH_CALLBACK;
$encoded = 'grant_type=authorization_code&code='.$code.'&redirect_uri='.urlencode($redirect_uri).'&client_id='.LI_CLIENT_ID.'&client_secret='.LI_CLIENT_SECRET;
$headers = array(
    "Content-Type: application/x-www-form-urlencoded"
  );
  
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST,  true);
curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
//print_r($response); //exit;
if (curl_errno($ch)) {
    //print "Error: " . curl_error($ch);
	// Abort! Something is wrong.
	http_response_code(404);
	
	echo json_encode(array(
		"message" => "not found.",
		"error" => "not found",
	));
	exit;
} else {
    //print json_encode(json_decode($response), JSON_PRETTY_PRINT);
	$output = json_decode($response); //print_r($output);
	$access_token = $output->access_token; //echo 'access_token:'.$access_token;
	curl_close($ch);
}

if($access_token!='')
{
	//echo '<br><pre>';
	// fetch first name, last name
	if(1){
	$url = 'https://api.linkedin.com/v2/me';
	$headers = array(
		"Authorization: Bearer ".$access_token
	  );  
	  
	$ch2 = curl_init();
	curl_setopt($ch2, CURLOPT_URL, $url);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_POST,  true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
	curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
	
	$response2 = curl_exec($ch2);
	$output2 = json_decode($response2); //print_r($output2);
	$userIdLi = $output2->id;
	$firstName = $output2->localizedFirstName; //echo 'first_name:'.$firstName;
	$lastName = $output2->localizedLastName; //echo 'last_name:'.$lastName;
	curl_close($ch2);
	} // end of if
	
	//print_r($response2);
	
	// fetch email
	$url = 'https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))';
	$headers = array(
		'Authorization: Bearer '.$access_token,
		'X-Restli-Protocol-Version: 2.0.0',
      	'Accept: application/json',
      	'Content-Type: application/json'
	  );  
	  
	$ch3 = curl_init();
	curl_setopt($ch3, CURLOPT_URL, $url);
	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_POST,  true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
	curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers);
	
	$response3 = curl_exec($ch3); //print_r($response3);
	if (curl_errno($ch3)) {
			//print "Error: " . curl_error($ch3);
			// Abort! Something is wrong.
			http_response_code(404);
			
			echo json_encode(array(
				"message" => "not found.",
				"error" => "not found",
			));
			exit;
		}	
	//print_r($response3);
	$output3 = json_decode($response3); //print_r($output3);
	//$email = $output3->elements[0]->handle~->emailAddress; echo 'email:'.$email;
	$elements = $output3->elements[0]; //print_r($elements);
	$d = 'handle~';
	$email = $elements->$d->emailAddress; //print_r('email:'.$email);
	//$last_name = $output2->localizedLastName; echo 'last_name:'.$last_name;
	curl_close($ch3);
	
	
	// fetch profile picture
	if(0){
	$url = 'https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams))';
	$headers = array(
		'Authorization: Bearer '.$access_token,
		'X-Restli-Protocol-Version: 2.0.0',
      	'Accept: application/json',
      	'Content-Type: application/json'
	  );  
	  
	$ch4 = curl_init();
	curl_setopt($ch4, CURLOPT_URL, $url);
	curl_setopt($ch4, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_POST,  true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
	curl_setopt($ch4, CURLOPT_HTTPHEADER, $headers);
	
	$response4 = curl_exec($ch4); //print_r($response4);
	if (curl_errno($ch4)) {
			//print "Error: " . curl_error($ch4);
			// Abort! Something is wrong.
			http_response_code(404);
			
			echo json_encode(array(
				"message" => "not found.",
				"error" => "not found",
			));
			exit;
		}	
	//print_r($response3);
	$output4 = json_decode($response4); print_r($output4);
	curl_close($ch4);
	}

//exit;  
//$userIdLi = $user_tw->id;
/*$name = $user_tw->name;
$userArr = explode(" ",$name);
$firstName = $userArr[0];
$lastName = (isset($userArr[1]))?$userArr[1]:"";
$email = $user_tw->email;*/
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
	$oauth_data_linkedIn = ['access_token'=>$access_token,'id'=>$userIdLi];
	
	// profile image
	/*$url_to_image = $user_tw->profile_image_url_https;
	$target_dir = PROJECT_ROOT_PATH."/upload/avatar/";
	$filename = basename($url_to_image);
	$path = $target_dir.$filename;
	file_put_contents($path,file_get_contents($url_to_image));*/
	$filename = 'default.jpg';
	
    // set event property values
    $user->oauth_type = 'LINKEDIN';
	$user->oauth_data_linkedin = json_encode($oauth_data_linkedIn);
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

} // if access token
exit;