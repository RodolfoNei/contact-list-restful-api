<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Contact.php';

// Instantiate DB & connect
$db = (new Database())->connect();
// Instantiate contact object
$contact = new Contact($db);
// Get posted data
$data = json_decode(file_get_contents("php://input"));

if(
  !empty($data->name) &&
  !empty($data->email) &&
  !empty($data->address)
) {
    $contact->name = $data->name;
    $contact->email = $data->email;
    $contact->address = $data->address;

    // Create POST
    if ($contact->create()) { 
      // set response code - 201 created
      http_response_code(201);
      
      echo json_encode(array('message' => 'Contact created'));

    } else {
      // set response code - 503 service unavailable
      http_response_code(503);

      echo json_encode(array('message' => 'Contact not created'));
    }
  } else {
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create contact. Data is incomplete."));
  }