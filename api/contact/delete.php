<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Contact.php';

// Instantiate DB & connect
$db = (new Database())->connect();
// Instantiate contact object
$contact = new Contact($db);
// Get posted data
$data = json_decode(file_get_contents("php://input"));
// Set ID to DELETE
$contact->id = $data->id;

// Delete post
if ($contact->delete()) {
  echo json_encode(array('message' => 'Contact deleted'));
} else {
  echo json_encode(array('message' => 'Contact not deleted'));
}
