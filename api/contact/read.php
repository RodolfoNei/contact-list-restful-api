<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Contact.php';

// Instantiate DB & connect
$db = (new Database())->connect();
// Instantiate contact object
$contact = new Contact($db);
// Contact query
$result = $contact->read();
// Get row count
$num = $result->rowCount();
// Check if any contacts
if ($num > 0) {
  // Contacts array
  $contacts_arr = array();
  $contacts_arr['data'] = array();

  // Assign each contact row variables
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    // Get phone numbers related to the contact
    $phone_numbers = array();
    $phone_result = $contact->getPhones($id);
    while ($phone_row = $phone_result->fetch(PDO::FETCH_ASSOC)) {
      extract($phone_row);
      array_push($phone_numbers, $phone_number);
    }

    $contact_item = array(
      'id' => $id,
      'name' => $name,
      'email' => $email,
      'address' => $address,
      'phone_numbers' => $phone_numbers
    );

    // Push to 'data'
    array_push($contacts_arr['data'], $contact_item);
  }
  // Convert to JSON and output
  echo json_encode($contacts_arr);
} else {
  // No Contacts
  echo json_encode(array('message' => 'No Contacts Found'));
}
