<?php
/*$a = mt_rand();
$password_hash = password_hash($a, PASSWORD_BCRYPT);
echo 'a:'.$a.', <br>password hash: '.$password_hash;
exit;*/

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
include_once '../../phpmailer/phpmailer.function.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate user object
$user = new User($db);

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
		$stmt = $user->readSingle(['email'=>$data->email]);
		$num = $stmt->rowCount(); //echo '<br>num:'.$num;
		  
		// check if more than 0 record found
		if($num>0){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			//print_r($row);
			
			$a = mt_rand();
			$password_hash = password_hash($a, PASSWORD_BCRYPT);

			$user->forgotten_password_code = $password_hash;
			$user->forgotten_password_time = time();
			$user->lastModified = date('Y-m-d H:i:s');
			$user->id = $row['id'];
			
			if($user->update_resetpass1())
			{
				// send email
				// Send email
				$fromName = 'Flooop';
				$fromEmail = 'amit@answebtechnologies.in'; //$postData['form_email'];
				$to = $user->email;
				$Subject = 'Reset password link:';
				$link = APPLICATION_URL_FRONT.'reset-password';
				$message = '<p>Hello</p>
				<p>You have applied for password reset, click below link and use below code to reset password:</p>
				<p>Code: '.$a.'</p>
				<p>Link: '.$link.'</p>
				<p>&nbsp;</p>
				<p>Team, Flooop</p>';
				
				$html = '<div>'.$message.'</div>';
				
				smtpmailer($to, $fromEmail, $fromName, $Subject, $html, false);
				smtpmailer('amit.dave.india@gmail.com', $fromEmail, $fromName, $Subject, $html, false);
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