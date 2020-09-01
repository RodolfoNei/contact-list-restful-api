<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../../config/Database.php';
include_once '../../models/Contact.php';

// Instantiate DB & connect
$db = (new Database())->connect();
// Instantiate contact object
$contact = new Contact($db);
// set ID property of record to read
$contact->id = isset($_GET['id']) ? $_GET['id'] : die();
// read the details of contact
$contact->readOne();

if ($contact->name != null) {
    // create array
    $product_arr = array(
        "id" =>  $contact->id,
        "name" => $contact->name,
        "email" => $contact->email,
        "address" => $contact->address,
        "created_at" => $contact->created_at,
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($product_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "Contact does not exist."));
}
