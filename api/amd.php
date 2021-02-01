<?php

function sanisitize_input($input_string)
{
	$san_input=trim(htmlspecialchars(stripslashes($input_string)));
	return $san_input;
}
function formfilter( $dataArray ) {
	foreach($dataArray as $key=>$valueArr)
	{
		$keyData=strip_tags($valueArr);
		$NewArr[$key]=$keyData;
	}
	return $NewArr;
}
function getCurrencyFormat($price,$currency)
{
	$curSymbolStripe = ''; // 3 letter ISO code; https://stripe.com/docs/currencies#charge-currencies (USD,GBP,SEK,INR)
	$curSymbol = '';
	$priceLabel = '';
	
	switch($currency)
	{
		case 'USD':	$curSymbolStripe = 'USD';
					$curSymbol = '$';
					$priceLabel = '$'.number_format($price,2);
					break;
		case 'GBP':	$curSymbolStripe = 'GBP';
					$curSymbol = '&pound;';
					$priceLabel = '&pound;'.number_format($price,2);
					break;
		case 'SEK':	$curSymbolStripe = 'SEK';
					$curSymbol = 'Kr';
					$priceLabel = number_format($price,2).' Kr';
					break;
	
	}
	
	return array('curSymbol'=>$curSymbol,'curSymbolStripe'=>$curSymbolStripe,'priceLabel'=>$priceLabel);	
}

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

define('EVENTS','events');
define('EVENTS_ATTENDEES','event_attendees');
define('USERS','users');

?>