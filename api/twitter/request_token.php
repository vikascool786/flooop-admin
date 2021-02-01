<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../../twitteroauth/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET);

$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => TW_OAUTH_CALLBACK));

if(isset($request_token['oauth_callback_confirmed']) && $request_token['oauth_callback_confirmed']==true){
	//$_SESSION['oauth_token'] = $request_token['oauth_token'];
	//$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
	
	http_response_code(401);
	
	echo json_encode(array(
		"message" => "unauthorized.",
		"error" => "unauthorized",
		"oauth_token"	=> urlencode($request_token['oauth_token']),
		"oauth_token_secret"	=> urlencode($request_token['oauth_token_secret']),
		"url"	=> urlencode($url),
	));
}
else{
	http_response_code(502);
	
	echo json_encode(array(
		"message" => "bad gateway.",
		"error" => "bad gateway",
	));	
}
//print_r($request_token);
exit;