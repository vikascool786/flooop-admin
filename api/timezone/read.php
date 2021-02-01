<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/timezone.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$timezone = new Timezone($db);
  
// read products will be here

// query products
$stmt = $timezone->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $timezone_arr=array();
    $timezone_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  		
        $timezone_item=array(
            "id" => $id,
            "title" => $title,
			"value" => $value,
			"status" => $status,
        );
  
        array_push($timezone_arr["records"], $timezone_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show data in json format
    echo json_encode($timezone_arr);
}
  // no products found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no timezone found
    echo json_encode(
        array("message" => "No timezone found.")
    );
}