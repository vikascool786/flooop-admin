<?php
/*
	AMD CLASS
	16.05.2020
	Written for my friend Nayeem.
	Written by Amit Dave.

*/
function prn($var){
	echo '<pre>'; print_r($var); echo '</pre>';
}
function prd($string_to_print) {
	echo "<pre>";
	print_r($string_to_print);
	echo "</pre>";		
	die;
}
		
function sanisitize_input($input_string)
{
	$san_input=trim(htmlspecialchars(stripslashes($input_string)));
	return $san_input;
	
	/*
		// How to use it in controller
		$data_post = array_filter($data_post, 'sanisitize_input');
	*/
}	
function formfilter( $dataArray ) 
{
	foreach($dataArray as $key=>$valueArr)
	{
		$keyData=strip_tags($valueArr);
		$NewArr[$key]=$keyData;
	}
	return $NewArr;
}	
function slug($title)
{
	$z = strtolower($title);
    $z = preg_replace('/[^a-z0-9 -]+/', '', $z);
    $z = str_replace(' ', '-', $z);
    return trim($z, '-');
}
function price_format($cost,$currency,$symbol)
{
	$price_format = $symbol.'&nbsp;'.number_format($cost,2);
	if($currency=='AED' || $currency=='SAR' || $currency=='BHD' || $currency=='KWD' || $currency=='OMR' || $currency=='INR'){
		$price_format = number_format($cost,2).'&nbsp;'.$symbol;	
	}
	 
	return $price_format;
}

