<?php
// CONTACT TABLE MODEL

class Contact {
  // DB Connection
  private $conn;
  private $table = 'contact';

  // Contact fields
  public $id;
  public $name;
  public $email;
  public $address;
  public $created_at;
  // public $phone_numbers;

  // Constructor
  public function __construct($db) {
    $this->conn = $db;
  }

  // Get all contacts
  public function read() {
    // Create query
    $query = 'SELECT * FROM ' . $this->table . ' ORDER BY name ASC';
    // Prepare Statement
    $stmt = $this->conn->prepare($query);
    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get one contact
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
    $this->name = $row['name'];
    $this->email = $row['email'];
    $this->address = $row['address'];
    $this->created_at = $row['created_at'];
  }

  // Get all phones related to a contact
  public function getPhones($contact_id) {
    // Create query
    $query = 'SELECT p.phone_number
              FROM phone p
              WHERE p.contact_id = ' . $contact_id;
    // Prepare Statement
    $stmt = $this->conn->prepare($query);
    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Create contact
  public function create() {
    // Create query
    $query = 'INSERT INTO ' . $this->table . '(name, email, address) VALUES (:name, :email, :address)';
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    // Clean data
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->address = htmlspecialchars(strip_tags($this->address));
    // Bind data
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':address', $this->address);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }
    // Print error
    printf('Error: %s.\n', $stmt->error);

    return false;
  }

  // Update contact
  public function update() {
    // Create query
    $query = 'UPDATE ' . $this->table . ' SET name = :name, email = :email, address = :address WHERE id = :id';
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    // Clean data
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->address = htmlspecialchars(strip_tags($this->address));
    $this->id = htmlspecialchars(strip_tags($this->id));
    // Bind data
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':address', $this->address);
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
