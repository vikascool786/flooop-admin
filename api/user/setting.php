<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;

// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
require __DIR__ . '/../../application/config/zoom.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);

$data = json_decode(json_encode($_POST));
$jwt = isset($data->jwt) ? $data->jwt : "";

$rowUser = null;
if ($jwt) {
    try {
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $userId = $decoded->data->id;

        $stmtUser = $user->readSingle(['id' => $userId]);
        $rowUser = $stmtUser->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {

    }
}

// If user exist
if (!is_null($rowUser)) {

    $userSetting = [];

    $zoom["connectedAt"] = $rowUser['zoom_connected_at'];
    $zoom["refreshedAt"] = $rowUser['zoom_refreshed_at'];
    $zoom["__ref_id"] = $rowUser['id'];

    if ($rowUser['zoom_access_token'] != "" && $rowUser['zoom_access_token'] != "NULL" && !is_null($rowUser['zoom_access_token'])) {
        $zoom["connected"] = true;
    } else {
        $zoom["connected"] = false;
        $zoom["authorisedUrl"] = $config['ZOOM_AUTHORISED_URL'];
    }
    $userSetting["zoom"] = $zoom;

    // set response code - 200 OK
    http_response_code(200);
    // show users data in json format
    echo json_encode($userSetting);

} else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no users found
    echo json_encode(array("message" => "No users found."));
}