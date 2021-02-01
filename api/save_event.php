<?php

header('Access-Control-Allow-Origin:*');
include("amd.php");

if($_SERVER['HTTP_HOST']=='localhost'){
	define('APPLICATION_URL', 'http://localhost/flooop/');
	$db_host = 'localhost';
	$db_name = 'flooop';
	$db_username = 'root';
	$db_pass = '';
	
}
if($_SERVER['HTTP_HOST']=='answebtechnologies.in' || $_SERVER['HTTP_HOST']=='www.answebtechnologies.in'){
	if($_SERVER['HTTP_HOST']=='answebtechnologies.in'){
		define('APPLICATION_URL', 'https://answebtechnologies.in/flooop/');
	}
	if($_SERVER['HTTP_HOST']=='www.answebtechnologies.in'){
		define('APPLICATION_URL', 'https://www.answebtechnologies.in/flooop/');
	}
	
	$db_host = 'localhost';
	$db_name = 'axomaxjq_flooop';
	$db_username = 'axomaxjq_flooop';
	$db_pass = 'AnsFloopDb@102020';
}

$conn = new mysqli($db_host,$db_username,$db_pass, $db_name);
 
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//echo 'Hello World!';
//exit;

$postData = $_POST;
$postData = formfilter($postData);

//$post = json_decode(file_get_contents("php://input"));

//echo '<pre>'; print_r($postData);

$today = date("Y-m-d H:i:s");
$event_title = $postData['event_title'];
$host_id =  '1'; //$postData['host_id'];
$event_date = date("Y-m-d",strtotime($postData['event_date']));
$event_start = $postData['event_start'];
$timezone = ''; //$postData['timezone'];
$event_image = ''; //$postData['event_image'];
$event_desc = $postData['event_description'];
$event_tags = $postData['event_keywords'];
$status = '1';//$postData['status'];

$fields = 'addDate,lastModified,event_title,host_id,event_date,event_start,timezone,event_image,event_desc,event_tags,status';
$val = '"'.$today.'","'.$today.'","'.$event_title.'","'.$host_id.'","'.$event_date.'","'.$event_start.'","'.$timezone.'","'.$event_image.'","'.$event_desc.'","'.$event_tags.'","'.$status.'" ';
$sql = 'INSERT INTO events ('.$fields.')
VALUES ('.$val.')';

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

exit;


?>