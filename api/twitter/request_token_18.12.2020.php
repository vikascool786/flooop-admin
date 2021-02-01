<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$consumer_key = 'Hv3UQqAIcXNIEsMhcdDeefVo6';
$consumer_secret = 'RzDJa8cixsLVYELBgv3uqGFrLcxw9kRyTwyUDo2jG801iQJkhe';
$access_token = '141433125-KeMx7GOR1HxWFwmkcdwILCj1oXjMuoBqGv32S8F8';
$access_secret = 'tPWWkMCR9stFEG9ewQBR2bu0q2jLHoztACeiBdDIXokXX';

$ch = curl_init();

//$encoded = 'name='.$user['name'].'&email='.$user['email'].'&api_key='.WEBINAR_API.'&webinar_id=e3a8e7f511&schedule=0&ip_address='.$_SERVER['REMOTE_ADDR'];
/*$headers = array(
    "Authorization: Bearer 2443206.pt.JCotAicHIsDqvQI4BCkzKKPTYvLwZp9OxDgz8uCvF9vOlaOPXvAp9fiHFlMNs-J_OxxRisSgcT2h6HUumKskyA",
    "Harvest-Account-ID: 1357392"
	"Content-Type: application/json"
  );*/
$nonce = md5(mt_rand(1, 10000000));  
$url = "https://api.twitter.com/oauth/request_token";
$tstamp = time();
$callback = rawurlencode('https://answebtechnologies.in');

$parameters = array("oauth_consumer_key" => $consumer_key,
          "oauth_nonce" => $nonce,
          "oauth_signature_method" => "HMAC-SHA1",
          "oauth_timestamp" => $tstamp,
          "oauth_token" => $access_token,
          "oauth_version" => "1.0");
$signature = sign($url,'POST',$nonce,$parameters,[]); //echo '$signature:'.$signature; exit;
/*$headers = array('Authorization: OAuth oauth_callback= '.$callback.',oauth_consumer_key="'.$consumer_key.'", oauth_nonce="'.$nonce.'", oauth_signature="'.$signature.'", oauth_signature_method="HMAC-SHA1", oauth_timestamp="'.$tstamp.'",  oauth_version="1.0"');*/
$headers = array('Authorization: OAuth oauth_callback= '.$callback.',oauth_consumer_key="'.rawurlencode($consumer_key).'", oauth_nonce="'.rawurlencode($nonce).'", oauth_signature="'.rawurlencode($signature).'", oauth_signature_method="HMAC-SHA1", oauth_timestamp="'.rawurlencode($tstamp).'",  oauth_version="1.0"');
  
curl_setopt($ch, CURLOPT_URL, $url);  // set url 
curl_setopt($ch, CURLOPT_POST,  true);
//curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//return the transfer as a string 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_USERAGENT, "themattharris' HTTP Client");

// $output contains the output string 
$output = curl_exec($ch); 

print_r($output);
// close curl resource to free up system resources 
curl_close($ch);

function sign($uri, $method, $nonce, $parameters, $data) {
	$consumer_key = 'Hv3UQqAIcXNIEsMhcdDeefVo6';
$consumer_secret = 'RzDJa8cixsLVYELBgv3uqGFrLcxw9kRyTwyUDo2jG801iQJkhe';
$access_token = '141433125-KeMx7GOR1HxWFwmkcdwILCj1oXjMuoBqGv32S8F8';
$access_secret = 'tPWWkMCR9stFEG9ewQBR2bu0q2jLHoztACeiBdDIXokXX';

  $base = $method.'&'.rawurlencode($uri).'&';
  $parameters = array_merge($parameters, $data);
  ksort($parameters);
  array_map('rawurlencode', $parameters);
  array_map('rawurlencode', array_keys($parameters));
  $pstring = '';
  foreach ($parameters as $key => $value)
	  $pstring .= sprintf("%s=%s&", $key, $value);
  $pstring = substr($pstring, 0, strlen($pstring) - 1);
  $base .= rawurlencode($pstring);
  //$signingKey = rawurlencode($consumer_secret).'&'.rawurlencode($access_secret);
  $signingKey = rawurlencode($consumer_secret).'&';
  return base64_encode(hash_hmac('sha1', $base, $signingKey, true));
}

exit;