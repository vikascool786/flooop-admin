<?php

header('Access-Control-Allow-Origin:*');
include("amd.php");

$sql = 'select * from '.EVENTS;
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       //echo '<br>Name-'.$row['event_title'];
	   $data[] = [
	   	'event_title'=>$row['event_title'],
		'host_id'=>$row['host_id'],
		'event_date'=>$row['event_date'],
		'event_start'=>$row['event_start'],
		'event_duration'=>$row['event_duration'],
		'timezone'=>$row['timezone'],
		'event_image'=>$row['event_image'],
		'event_desc'=>$row['event_desc'],
		'event_tags'=>$row['event_tags'],
		'status'=>$row['status'],
	   ];
    }
} else {
    echo "0 results";
}

echo '<pre>'; print_r($data); exit;
?>