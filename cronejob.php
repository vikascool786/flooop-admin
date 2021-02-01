<?php

include("api/amd.php");
include 'phpmailer/phpmailer.function.php';

$where = 'where 1';
$sql = 'select * from '.EVENTS.' '.$where;
$result = $conn->query($sql);
//what will be flow of forgot-password?
$data = [];
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       //echo '<br>Name-'.$row['event_title'];
	    extract($row);
	    $eid = $id;
	   
	    echo '<br>Event:'.$event_title.' ,event_date:'.$event_date.', event_start:'.$event_start;
	    
		$where = 'where event_id='.$eid;
		$sql = 'select * from '.EVENTS_ATTENDEES.' as a  
				left join '.USERS.' on b on a.id=b.user_id 
				'.$where;
		$result_ea = $conn->query($sql);
		if ($result_ea->num_rows > 0) {
    		while($row_ea = $result_ea->fetch_assoc()) {
				$receiver = $row_ea['email'];
				 			
				// Send email
				$fromName = 'amit';
				$fromEmail = 'amit@answebtechnologies.in'; //$postData['form_email'];
				$to = $receiver;
				$Subject = 'Remainder of Event:'.$event_title;
				$html = '<div>'.$message.'</div>';
				
				smtpmailer($to, $fromEmail, $fromName, $Subject, $html, false);
				smtpmailer('amit.dave.india@gmail.com', $fromEmail, $fromName, $Subject, $html, false);
				// send email ends
				
			}
		}
		
    }
} else {
    echo "0 results";
}

?>