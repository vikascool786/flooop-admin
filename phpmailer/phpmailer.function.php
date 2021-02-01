<?php

require_once('class.phpmailer.php');

/*	define('MAIL_USER', 'info@vasmind.com'); // email id
	define('MAIL_PASSWORD', 'Infomail@082020'); // email password
	define('SMTP_SERVER', 'mail.vasmind.com'); // sec. smtp server
*/
//if($_SERVER['HTTP_HOST']=='answebtechnologies.in' || $_SERVER['HTTP_HOST']=='www.answebtechnologies.in'){
	define('MAIL_USER', 'vikas@floooplife.com'); // email id
	define('MAIL_PASSWORD', 'Vineetaw1!'); // email password
	define('SMTP_SERVER', 'mail.floooplife.com'); // sec. smtp server
//}
	
function smtpmailer($to, $from, $from_name, $subject, $body, $is_gmail=false) { 
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
    
    if ($is_gmail) {
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;  
		$mail->Username = "vikas.cool786@gmail.com";  
		$mail->Password = "VikaS#@#1988";   
	} else {
		$mail->Host = SMTP_SERVER;
		// $mail->Username = "vikas.cool786@gmail.com";  
		// $mail->Password = "VikaS#@#1988";   
		$mail->Username = MAIL_USER;  
		$mail->Password = MAIL_PASSWORD;
		$mail->Port = 25;
	}     
       
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	$mail->IsHTML(true);
	
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}


?>