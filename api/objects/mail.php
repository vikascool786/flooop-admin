<?php
	ini_set('display_errors','1');
	// Report all PHP errors (see changelog)
	error_reporting(E_ALL);	// E_ERROR | E_WARNING | E_PARSE | E_ALL | 0
	
include_once '../../phpmailer/phpmailer.function.php';

class Mail{
  
    // database connection and table name
    private $conn;
    //private $table_name = "events";
  
    // object properties
    public $id;
	public $addDate;
	public $lastModified;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read products
	//function read($page)
	function send($options){
			//print_r($options);exit;
	  	
		// Send email
			$fromName = 'Flooop.Life';
			$fromEmail = 'password@flooop.life'; 
			$to = $options['to'];
			$Subject = $options['Subject'];
			$mailType = $options['mailType'];
			
			if($mailType=='EVENT-INVITE'){
				$event_id = $options['event_id'];
				$link = APPLICATION_URL_FRONT.'event-detail/'.$event_id;
				
				$message = '<p>Hello</p>
					<p>You are invited to an event at Flooop by [SENDERNAME]:</p>
					<p>&nbsp;</p>
					<p><strong>Event Details:</strong></p>
					<p>Event Title: [EVENTTITLE]</p>
					<p>Hosted By: [HOST]</p>
					<p>Date Time: [EVENTDATETIME]</p>
					<p>Duration: [DURATION]</p>
					<p>Link: <a href="[LINK]" >Click here</a></p>
					<p>&nbsp;</p>
					<p>Team, Flooop</p>';
				
				$message = str_replace('[LINK]',$link,$message);
				$message = str_replace('[SENDERNAME]',$options['sender_name'],$message);
				$message = str_replace('[EVENTTITLE]',$options['event_title'],$message);
				$message = str_replace('[HOST]',$options['event_host'],$message);
				$message = str_replace('[EVENTDATETIME]',$options['event_datetime'],$message);
				$message = str_replace('[DURATION]',$options['event_duration'],$message);
			}
			if($mailType=='EVENT-SUBSCRIBE'){
				$event_id = $options['event_id'];
				$link = APPLICATION_URL_FRONT.'event-detail/'.$event_id;
				
				$message = '<p>Hello</p>
					<p>You have successsfully subscribed for an event at Flooop:</p>
					<p>&nbsp;</p>
					<p><strong>Event Details:</strong></p>
					<p>Event Title: [EVENTTITLE]</p>
					<p>Hosted By: [HOST]</p>
					<p>Date Time: [EVENTDATETIME]</p>
					<p>Duration: [DURATION]</p>
					<p>Link: <a href="[LINK]" >Click here</a></p>
					<p>&nbsp;</p>
					<p>Team, Flooop</p>';
				
				$message = str_replace('[LINK]',$link,$message);
				$message = str_replace('[EVENTTITLE]',$options['event_title'],$message);
				$message = str_replace('[HOST]',$options['event_host'],$message);
				$message = str_replace('[EVENTDATETIME]',$options['event_datetime'],$message);
				$message = str_replace('[DURATION]',$options['event_duration'],$message);
			}
			if($mailType=='FORGOT-PASSWORD'){
				
				$code = $options['code'];
				$link = $options['link']; //APPLICATION_URL_FRONT.'reset-password/'.$code;
				
				// $message = '<p>Hello [FIRSTNAME] [LASTNAME]</p>
				// <p>You have applied for password reset, click below link to reset your password:</p>
				// <p>Link: [LINK]</p>
				// <p>&nbsp;</p>
				// <p>Team, Flooop</p>';
				$message = '<p>Hi [FIRSTNAME] [LASTNAME]</p>
				<p>Please check link bellow to reset your password:</p>
				<p>Link: [LINK]</p>
				<p>&nbsp;</p>
				<p>Cheers</p>
				<p>Flooop.Life Team</p>
				<p>&nbsp;</p>
				<p>Connect. Anytime. Anywhere.</p>
				<p><a href="http://floooplife.com">Flooop.Life</a></p>';
				
				$message = str_replace('[LINK]',$link,$message);
				$message = str_replace('[FIRSTNAME]',$options['first_name'],$message);
				$message = str_replace('[LASTNAME]',$options['last_name'],$message);
			}
			$html = '<div>'.$message.'</div>';
		
			smtpmailer($to, $fromEmail, $fromName, $Subject, $html, false);
			smtpmailer('vikas@floooplife.com', $fromEmail, $fromName, $Subject, $html, false);
		// send email ends
						
		
		return true;
	}
	
}
?>