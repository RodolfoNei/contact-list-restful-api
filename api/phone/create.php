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

$phone->contact_id = $data->contact_id;
$phone->phone_number = $data->phone_number;

// Create POST
if ($phone->create()) {
  echo json_encode(array('message' => 'Phone number created'));
} else {
  echo json_encode(array('message' => 'Phone number not created'));
}
