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

// Get phone numbers related to the contact
$phone_numbers = array();
$phone_result = $contact->getPhones($contact->id);
while ($phone_row = $phone_result->fetch(PDO::FETCH_ASSOC)) {
  extract($phone_row);
  array_push($phone_numbers, $phone_number);
}

if ($contact->name != null) {
    // create array
    $contact_arr = array(
        "id" =>  $contact->id,
        "name" => $contact->name,
        "email" => $contact->email,
        "address" => $contact->address,
        'phone_numbers' => $phone_numbers,
        "created_at" => $contact->created_at,
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($contact_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "Contact does not exist."));
}
