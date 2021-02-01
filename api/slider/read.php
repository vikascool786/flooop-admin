<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here

// include database and object files
include_once '../config/core.php'; /// /home/axomaxjq/domains/answebtechnologies.in/public_html/flooopadmin/api/config
//echo PROJECT_ROOT_PATH; exit;
include_once '../config/database.php';
include_once '../objects/slider.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$slider = new Slider($db);
// $path = APPLICATION_URL.'upload/slider/';
$path = 'http://floooplife.com/flooopadmin/upload/slider/'; 
  
// read products will be here

// query products
$stmt = $slider->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $slider_arr=array();
    $slider_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	$n=1;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  		$active = ($n==1)?true:false;
		
		$path_http = $path.'default_1920x1080.png';
		$path_root = PROJECT_ROOT_PATH.'/upload/slider/'.$image;
		$path_root = 'http://floooplife.com/flooopadmin/upload/slider/'.$image;
		if(file_exists($path_root) && $image!='')
		{
			$path_http = $path.$image;	
		}
			
        $slider_item=array(
            "id" => $id,
            "image" => $image,
			"title" => $title,
			"subtitle" => $subtitle,
			"link_title" => $link_title,
			"link_value" => $link_value,
			"path" => $path_http,
			"status" => $status,
			"active" => $active,
        );
  
        array_push($slider_arr["records"], $slider_item);
		$n++;
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show data in json format
    echo json_encode($slider_arr);
}
  // no products found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No slides found.")
    );
}