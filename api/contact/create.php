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

$contact->name = $data->name;
$contact->email = $data->email;
$contact->address = $data->address;

// Create post
if ($contact->create()) {
  echo json_encode(array('message' => 'Contact created'));
} else {
  echo json_encode(array('message' => 'Contact not created'));
}
