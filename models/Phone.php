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

  // Create phone number
  public function create() {

    // Create query
    $query = 'INSERT INTO ' . $this->table . '(contact_id, phone_number) VALUES (:contact_id, :phone_number)';
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    // Clean data
    $this->contact_id = htmlspecialchars(strip_tags($this->contact_id));
    $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));

    // Bind data
    $stmt->bindParam(':contact_id', $this->contact_id);
    $stmt->bindParam(':phone_number', $this->phone_number);

    // Execute query
    $stmt->execute();


    return true;
  }

  // Get one phone number
  public function readOne(){

    // query to read single record
    $query = "SELECT * FROM " . $this->table . " WHERE id = ?";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->contact_id = $row['contact_id'];
    $this->phone_number = $row['phone_number'];
    $this->created_at = $row['created_at'];
  }

  // Update phone
  public function update() {
    // Create query
    $query = 'UPDATE ' . $this->table . ' SET phone_number = :phone_number WHERE id = :id';
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    // Clean data
    $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
    $this->id = htmlspecialchars(strip_tags($this->id));
    // Bind data
    $stmt->bindParam(':phone_number', $this->phone_number);
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }
    // Print error
    printf('Error: %s.\n', $smtm->error);

    return false;
  }

  // Delete contact
  public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    // Bind data
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

}
