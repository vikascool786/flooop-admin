<?php
/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

// Set the uplaod directory
//$uploadDir = '/uploads/';

error_reporting(0);
//ini_set('max_execution_time', 0); //300 seconds = 5 minutes

defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__) . ''));



$opt=$_REQUEST['opt'];
$optheight = 0;
$optwidth = 0;

if($opt!="" && $opt=="slider_image")
{
	define('GALLERY_IMAGES', '/upload/slider/');
	$targetFolder=ROOT_PATH.GALLERY_IMAGES;
}
if($opt!="" && $opt=="blog_image")
{
	define('GALLERY_IMAGES', '/upload/blog/');
	$targetFolder=ROOT_PATH.GALLERY_IMAGES;
}
if($opt!="" && $opt=="gallery_image")
{
	define('GALLERY_IMAGES', '/upload/gallery/');
	$targetFolder=ROOT_PATH.GALLERY_IMAGES;
}
if($opt!="" && $opt=="common_image")
{
	define('GALLERY_IMAGES', '/assets/frameworks/img/');
	$targetFolder=ROOT_PATH.GALLERY_IMAGES;
}
if($opt!="" && $opt=="class_image")
{
	define('GALLERY_IMAGES', '/assets/frameworks/img/class/');
	$targetFolder=ROOT_PATH.GALLERY_IMAGES;
}


// Set the allowed file extensions
$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile   = $_FILES['Filedata']['tmp_name'];
	//
	$fileParts = pathinfo($_FILES['Filedata']['name']); //print_r($fileParts);
	list($width, $height, $type, $attr) =  getimagesize($_FILES["Filedata"]["tmp_name"]);
	
	$filename = $fileParts['filename'];
	$filename = str_replace(" ","_",$filename);
	$filename=  preg_replace('/[^a-zA-Z0-9_.]/', '', $filename);
	$newName=$filename."_id_".time().'.'.$fileParts['extension'];
		
	//$uploadDir  = $_SERVER['DOCUMENT_ROOT'] .dirname($_SERVER['PHP_SELF']) . $uploadDir;
	//$targetFile = $uploadDir . $_FILES['Filedata']['name'];
	
	$targetPath = $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' .$newName; //echo  'target file = '.$targetFile; exit;
	
	//
	//$uploadDir  = $_SERVER['DOCUMENT_ROOT'] .dirname($_SERVER['PHP_SELF']) . $uploadDir;
	//$targetFile = $uploadDir . $_FILES['Filedata']['name'];

	// Validate the filetype
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

		// Save the file
		move_uploaded_file($tempFile, $targetFile);
		//echo 1;
		echo $newName;
	} else {

		// The file type wasn't allowed
		echo 'Invalid file type.';

	}
}
?>