<?php

// required headers

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: POST");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  

// get database connection

include_once '../config/core.php';

include_once '../config/database.php';

  

// instantiate user object

include_once '../objects/user.php';

include_once '../../phpmailer/phpmailer.function.php';

  

$database = new Database();

$db = $database->getConnection();

  

$user = new User($db);

  

// get posted data

//$data = json_decode(file_get_contents("php://input"));

$data = $_POST; $data = json_encode($data); $data = json_decode($data);

 //print_r($data); exit;  

// make sure data is not empty

#TODO - PUT FULL VALIDATION/SECURITY



if(

    !empty($data->email) &&

    !empty($data->firstName) && 

	!empty($data->lastName)   

){

	

	$stmt = $user->readSingle(['email'=>$data->email]);

	$num = $stmt->rowCount();

  	

	if($num>0){

		// set response code - 400 bad request

    	http_response_code(400);

  

    	// tell the user

    	echo json_encode(array("message" => "Unable to create user. Email already registered."));	

	}

	else { 

  	$user_image = 'default.jpg';

	//if($_FILES['file']['name']!='')

	if(0)

	{

		 $target_dir = PROJECT_ROOT_PATH."/upload/events/";

		 $file = $_FILES['file']['name'];

		 $path = pathinfo($file);

		 $filename = time(); //$path['filename'];

		 $ext = $path['extension'];

		 $temp_name = $_FILES['file']['tmp_name'];

		 $path_filename_ext = $target_dir.$filename.".".$ext;

		 

		// Check if file already exists

		if (file_exists($path_filename_ext)) {

		 	//echo "Sorry, file already exists.";

			

		 }else{

		 	move_uploaded_file($temp_name,$path_filename_ext);

		 	//echo "Congratulations! File Uploaded Successfully.";

			$event_image = $filename.".".$ext;

		 }	

	}

	

	

	$password = mt_rand();

	

    // set event property values

    $user->ip_address = ''; //$data->host_id;

	$user->username = $data->email;

    $user->password = $password;

    $user->salt = '';

    $user->email = $data->email;

	$user->activation_code = '';

	$user->forgotten_password_code = '';

	$user->forgotten_password_time = '';

	$user->remember_code = ''; 

	$user->created_on = date('Y-m-d H:i:s');

	$user->last_login = date('Y-m-d H:i:s');

	$user->active = '1';

	$user->first_name = $data->firstName;

	$user->last_name = $data->lastLame;

	$user->company	 = '';

	$user->phone = '';

	

    $user->addDate = date('Y-m-d H:i:s');

	$user->lastModified = date('Y-m-d H:i:s');

  	

    	// create the user.

		/*

			CC:

			1. user/create.php

			2. user/glogin.php

			3. user/flogin.php

			4. user/tlogin.php

			5. user/llogin.php

		*/

    	if($user->create()){

  			

			// Send email

				$fromName = 'Flooop';

				$fromEmail = 'amit@answebtechnologies.in'; //$postData['form_email'];

				$to = $user->email;

				$Subject = 'Welcome to Flooop! Your account created successfully';

				$link = APPLICATION_URL_FRONT.'login';

				$message = '<p>Hi '.$data->first_name.' '.$data->last_name.',</p>

				<p>&nbsp;</p>

				<p>Welcome to Flooop. We’re thrilled to see you here!</p>

				<p>&nbsp;</p>

				<p>We’re confident that our service will help you.</p>

				<p>Get to know us in our video. You’ll be guided through to ensure you get the very best out of our service.</p>

				<p>You can also find more of our guides here to learn more about service.</p>

				<p>You can access using following creadentials:</p>

				<p>Username: '.$data->email.'</p>

				<p>Password: '.$password.'</p>

				<p><a href="'.$link.'">Click</a> here to login</p>

				<p>&nbsp;</p>

				<p>Warm Regards,</p>

				<p>Team, Flooop</p>';

				

				$html = '<div>'.$message.'</div>';

				

				smtpmailer($to, $fromEmail, $fromName, $Subject, $html, false);

				smtpmailer('amit.dave.india@gmail.com', $fromEmail, $fromName, $Subject, $html, false);

				// send email ends

				

        	// set response code - 201 created

        	http_response_code(201);

  

        	// tell the user

        	echo json_encode(array("message" => "You have successfully created your account. Please check your inbox to access your account."));

    	}

  

    	// if unable to create the user, tell the user

    	else{

  

        // set response code - 503 service unavailable

        http_response_code(503);

  

        // tell the user

        echo json_encode(array("message" => "Unable to create user."));

    }

	

	}

}

  

// tell the user data is incomplete

else{

  

    // set response code - 400 bad request

    http_response_code(400);

  

    // tell the user

    echo json_encode(array("message" => "Unable to create user. Data is incomplete."));

}

?>