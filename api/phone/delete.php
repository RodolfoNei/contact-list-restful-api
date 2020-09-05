<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Phone.php';

// Instantiate DB & connect
$db = (new Database())->connect();
// Instantiate contact object
$phone = new Phone($db);
// Get posted data
$data = json_decode(file_get_contents("php://input"));
// Set ID to DELETE
$phone->id = $data->id;

// Delete post
if ($phone->delete()) {
  echo json_encode(array('message' => 'Phone deleted'));
} else {
  echo json_encode(array('message' => 'Phone not deleted'));
}
