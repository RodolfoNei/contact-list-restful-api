<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Phone.php';

// Instantiate DB & connect
$db = (new Database())->connect();
// Instantiate phone object
$phone = new Phone($db);
// Get posted data
$data = json_decode(file_get_contents("php://input"));

if(
  !empty($data->contact_id) &&
  !empty($data->phone_number)
) {
    $phone->contact_id = $data->contact_id;
    $phone->phone_number = $data->phone_number;

    // Create POST
    if ($phone->create()) {
      // set response code - 201 created
      http_response_code(201);
      
      echo json_encode(array('message' => 'Phone number created'));

    } else {
      // set response code - 503 service unavailable
      http_response_code(503);

      echo json_encode(array('message' => 'Phone number not created'));
    }
  } else {
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create phone number. Data is incomplete."));
  }
