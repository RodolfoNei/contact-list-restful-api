<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Phone.php';

// Instantiate DB & connect
$db = (new Database())->connect();
// Instantiate contact object
$phone = new Phone($db);
// Contact query
$result = $phone->read();
// Get row count
$num = $result->rowCount();
// Check if any contacts
if ($num > 0) {
  // Contacts array
  $phones_arr = array();
  $phones_arr['data'] = array();

  // Assign each contact row variables
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $phone_item = array(
      'id' => $id,
      'contact_id' => $contact_id,
      'phone_number' => $phone_number,
      'created_at' => $created_at,
    );

    // Push to 'data'
    array_push($phones_arr['data'], $phone_item);
  }
  
  // Convert to JSON and output
  echo json_encode($phones_arr);
} else {
  // No Phone Numbers
  echo json_encode(array('message' => 'No phone numbers created.'));
}
