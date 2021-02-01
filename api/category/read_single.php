<?php
 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/category.php';

  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$category = new Category($db);
$path = APPLICATION_URL.'upload/category/';

//$data = json_decode(file_get_contents("php://input"));
if(!empty($_POST))$data = $_POST;else $data = $_GET; 
$data = json_encode($data); $data = json_decode($data);
$cid = $data->id;
//print_r($_GET);print_r($data); exit;  
  
// read products will be here

// query event
$stmt = $category->readSingle(['id'=>$cid]);
$num = $stmt->rowCount();
//echo 'num:'.$num;  
// check if more than 0 record found
if($num>0){
  
    // products array
    $category_arr=array();
    $category_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
		
		$path_http = $path.'default.jpg';
		$path_root = PROJECT_ROOT_PATH.'/upload/category/'.$cat_image;
		if(file_exists($path_root) && $cat_image!='')
		{
			$path_http = $path.$cat_image;	
		}
  		
		$category_item=array(
            "id" => $id,
            "cat_title" => $cat_title,
			"cat_image" => $cat_image,
			"path" => $path_http,
			"status" => $status,
        );
  
        array_push($category_arr["records"], $category_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
 	 
    // show products data in json format
    echo json_encode($category_arr);
}
  // no products found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No category found.")
    );
}