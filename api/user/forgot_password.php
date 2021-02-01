<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



// files for decoding jwt will be here
// required to encode json web token
include_once '../config/core.php';

// files needed to connect to database
include_once '../config/database.php';
include_once '../objects/user.php';
include_once '../objects/mail.php';
include_once '../../phpmailer/phpmailer.function.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate user object
$user = new User($db);
$mail = new Mail($db);

// retrieve given jwt here
// get posted data
//$data = json_decode(file_get_contents("php://input"));
$data = $_POST; $data = json_encode($data); $data = json_decode($data);
//print_r($data->email);

if(
    !empty($data->email)
){
	
	// set user property values
	$user->email = $data->email; //echo 'email: '.$data->email;
	$email_exists = $user->emailExists();
	if($email_exists){
		
		//echo 'userId:'.$user->id; exit;
		// query user
			$a = mt_rand();
			$password_hash = password_hash($a, PASSWORD_BCRYPT);
			$password_hash = str_replace("/","",$password_hash);

			$user->forgotten_password_code = $password_hash;
			$user->forgotten_password_time = time();
			$user->lastModified = date('Y-m-d H:i:s');
			$user->id = $user->id;
			
			if($user->update_resetpass1())
			{
				// send email
				if(0){
				$fromName = 'Flooop.Life';
				$fromEmail = 'password@flooop.life'; //$postData['form_email'];
				$to = $user->email;
				$Subject = 'Password Reset';
				$link = APPLICATION_URL_FRONT.'#/reset-password';
				$message = '<p>Hi</p>
				<p>Please check link bellow to reset your password:</p>
				<p>Code: '.$a.'</p>
				<p>Link: '.$link.'</p>
				<p>&nbsp;</p>
				<p>Cheers</p>
				<p>Flooop.Life Team</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p>Connect. Anytime. Anywhere.</p>
				<p><a href="http://floooplife.com">Flooop.Life</a></p>';
				
				$html = '<div>'.$message.'</div>';
				
				smtpmailer($to, $fromEmail, $fromName, $Subject, $html, false);
				smtpmailer('vikas@floooplife.com', $fromEmail, $fromName, $Subject, $html, false);
				}
				
				if($_SERVER['HTTP_HOST']!='localhost'){
				$link = APPLICATION_URL_FRONT.'#/reset-password/'.$password_hash;
				$options = [
					'mailType' => 'FORGOT-PASSWORD',
					'to' => $user->email,
					'Subject' => 'Password Reset',
					'first_name' => $user->first_name,
					'last_name' => $user->last_name,
					'code'=>$password_hash,
					'link'=>$link,
				];
				$mail->send($options);
				}
				// send email ends
				
				
				// set response code
				http_response_code(200);
				
				// response in json format
				echo json_encode(
					array(
						"message" => "Password reset link emailed, check your inbox",
					)
				);	
			}
			// message if unable to update user
			else{
			// set response code
			http_response_code(401);
		
			// show error message
			echo json_encode(array("message" => "Unable to process request."));
		}
		
		
		
		
	}
	else	// email exists
	{
		// set response code
		http_response_code(200);
		
		// response in json format
		echo json_encode(
			array(
				"message" => "Password reset link emailed, check your inbox",
			)
		);		
	} // email exists
	
}
else
{
	// set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to process request. Data is incomplete."));	
}