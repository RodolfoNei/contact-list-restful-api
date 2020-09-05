<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../../config/Database.php';
include_once '../../models/Phone.php';

// Instantiate DB & connect
$db = (new Database())->connect();
// Instantiate contact object
$phone = new Phone($db);
// set ID property of record to read
$phone->id = isset($_GET['id']) ? $_GET['id'] : die();
// read the details of contact
$phone->readOne();

if ($phone->phone_number != null) {
    // create array
    $phone_arr = array(
        "id" =>  $phone->id,
        "contact_id" => $phone->contact_id,
        "phone_number" => $phone->phone_number,
        "created_at" => $phone->created_at,
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($phone_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "Phone does not exist."));
}
