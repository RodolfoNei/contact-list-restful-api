<?php
// PHONE TABLE MODEL

class Phone {
  // DB Connection
  private $conn;
  private $table = 'phone';

  // Phone fields
  public $id;
  public $contact_id;
  public $phone_numbers;
  public $created_at;

  // Constructor
  public function __construct($db) {
    $this->conn = $db;
  }

  // Create phone
  public function create() {

    foreach ($this->phone_numbers as $phone_number) {
      // Create query
      $query = 'INSERT INTO ' . $this->table . '(contact_id, phone_number) VALUES (:contact_id, :phone_number)';
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Clean data
      $this->contact_id = htmlspecialchars(strip_tags($this->contact_id));
      $phone_number = htmlspecialchars(strip_tags($phone_number));

      // Bind data
      $stmt->bindParam(':contact_id', $this->contact_id);
      $stmt->bindParam(':phone_number', $phone_number);

      // Execute query
      $stmt->execute();
    }

    return true;
  }

}
