<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors','1');
	// Report all PHP errors (see changelog)
	error_reporting(E_ALL);	// E_ERROR | E_WARNING | E_PARSE | E_ALL | 0

include_once '../config/core.php';

if(!empty($_POST))$data = $_POST;else $data = $_GET; 
$data = json_encode($data); $data = json_decode($data);
$linkedin_state = $data->linkedin_state;

$url = 'https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id='.LI_CLIENT_ID.'&redirect_uri='.urlencode(LI_OAUTH_CALLBACK).'&state='.$linkedin_state.'&scope=r_liteprofile%20r_emailaddress';

http_response_code(401);
	
echo json_encode(array(
	"message" => "unauthorized",
	"error" => "unauthorized",
	"url"	=> urlencode($url),
));
exit;