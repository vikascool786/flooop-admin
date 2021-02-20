<?php


$appURL = ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . "://{$_SERVER['SERVER_NAME']}";

define('APPLICATION_URL', $appURL.'/flooopadmin/');
define('PROJECT_ROOT_PATH', '/home1/a1610nqz/public_html/flooopadmin/');
define('APPLICATION_URL_FRONT', $appURL.'/');

// set your default time-zone

date_default_timezone_set('Asia/Kolkata');

 

// variables used for jwt

$key = "example_key";

$issued_at = time();

$expiration_time = $issued_at + (60 * 60); // valid for 1 hour

$issuer = "https://answebtechnologies.in/flooop/";

$client_id = '430299638290-0ncq4i2q1n6j40vvr4m2ic5f4rlbpjt6.apps.googleusercontent.com';	// Google api for login

$fb_app_id = '739382543594363';

$fb_app_secret = '723d21a4965f8e61507465245e0c36f0';



define('TW_CONSUMER_KEY', 'Hv3UQqAIcXNIEsMhcdDeefVo6');

define('TW_CONSUMER_SECRET', 'RzDJa8cixsLVYELBgv3uqGFrLcxw9kRyTwyUDo2jG801iQJkhe');

define('TW_ACCESS_TOKEN', '141433125-KeMx7GOR1HxWFwmkcdwILCj1oXjMuoBqGv32S8F8');

define('TW_ACCESS_SECRET', 'tPWWkMCR9stFEG9ewQBR2bu0q2jLHoztACeiBdDIXokXX');

define('TW_OAUTH_CALLBACK', 'https://answebtechnologies.in/flooop/twcallback');

//define('TW_OAUTH_CALLBACK', 'http://localhost:8080/twcallback');



define('LI_OAUTH_CALLBACK', 'https://answebtechnologies.in/flooop/licallback'); // linkedin callback

//define('LI_OAUTH_CALLBACK', 'http://localhost:8080/licallback'); // linkedin callback

define('LI_CLIENT_ID', '77r76dcwnsn0vu');

define('LI_CLIENT_SECRET', '0gTutb6isbnYyt3Z');



//define('TW_OAUTH_CALLBACK', 'http://localhost:8080/twcallback');

//http://localhost:8080/

/*$consumer_key = 'Hv3UQqAIcXNIEsMhcdDeefVo6';

$consumer_secret = 'RzDJa8cixsLVYELBgv3uqGFrLcxw9kRyTwyUDo2jG801iQJkhe';

$access_token = '141433125-KeMx7GOR1HxWFwmkcdwILCj1oXjMuoBqGv32S8F8';

$access_secret = 'tPWWkMCR9stFEG9ewQBR2bu0q2jLHoztACeiBdDIXokXX';*/



function getCurrencyFormat($price,$currency,$symbol)

{

	//$curSymbolStripe = ''; // 3 letter ISO code; https://stripe.com/docs/currencies#charge-currencies (USD,GBP,SEK,INR)

	//$curSymbol = '';

	$priceLabel = '';

	

	switch($currency)

	{

		case 'USD':	$priceLabel = $symbol.' '.number_format($price,2);

					break;

		case 'GBP':	$priceLabel = $symbol.' '.number_format($price,2);

					break;

		case 'SEK':	$priceLabel = number_format($price,2).' '.$symbol;

					break;

		default:

					$priceLabel = number_format($price,2).$symbol;

	}

	

	//return array('curSymbol'=>$curSymbol,'curSymbolStripe'=>$curSymbolStripe,'priceLabel'=>$priceLabel);	

	return array('priceLabel'=>$priceLabel);	

}

/*

	d1,d2 = array(date,time,ampm,timezone)

	

*/

function getDateDiff($d1,$d2)

{

	date_default_timezone_set($d1['timezone']);

	$date_d1 = $d1['date'].' '.$d1['time'];

	$date_d2 = $d2['date'].' '.$d2['time'];

	

	$original_datetime= date('Y-m-d H:i:s',strtotime($date_d1)); 

	$original_timezone = new DateTimeZone($d1['timezone']);

	//$datetime = new DateTime($original_datetime, $original_timezone);

	$datetime = new DateTime($original_datetime);

	$datetime->setTimeZone($original_timezone);

	//$msgTime = $datetime->format('h:i a');

	//$msgDate = $datetime->format('Y-m-d');

	//echo "<p>msgTime:$msgTime, msgDate: $msgDate</p>";

	

	$zoneName=$d2['timezone'];

	$target_timezone = new DateTimeZone($zoneName);

	$datetime->setTimeZone($target_timezone);

	$msgTime = $datetime->format('h:i a');

	$msgDate = $datetime->format('Y-m-d');

	

	date_default_timezone_set($d2['timezone']);

	

	$date1 = new DateTime($msgDate.' '.$msgTime);

	$date2 = new DateTime($date_d2);

	$interval = $date1->diff($date2);

	//echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 

	//echo $interval->h." hours, ".$interval->i." minutes, ".$interval->s." seconds"; 

					

	$t1 = strtotime($msgDate.' '.$msgTime);

	$t2 = strtotime(date('Y-m-d H:i:s'));

	$diff = $t1 - $t2;

	if($t1>$t2)

	$diff_type = 'positive';

	else

	$diff_type = 'negative';

	

	//echo 'diff:'.$diff;

	$data = ['diff_years'=>$interval->y,'diff_months'=>$interval->m,'diff_days'=>$interval->d,'diff_hours'=>$interval->h,'diff_minutes'=>$interval->i,

	'diff_seconds'=>$interval->s,'diff_seconds2'=>$diff,'diff_type'=>$diff_type];

	return $data;

}

?>