<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../../twitteroauth/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

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

print_r($access_token);
exit;