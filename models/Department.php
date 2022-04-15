<?php
  class Department {
    // DB stuff
    private $conn;
    private $table = 'department';
    // Post Properties
    public $department_id;
    public $name;
    public $sequence;
    public $remark;
    public $status;
    public $create_by;
    public $updated_at;
    public $update_by;
    public $access_token;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    //Get Position Name
    public function getDepartmentName($id) {
      // Create query
      $query = '  SELECT name FROM ' . $this->table . '
                  WHERE department_id = :department_id AND status = 1;';
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Bind ID
      $stmt->bindParam(':department_id', $id);
      // Execute query
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      // Set properties
      if ($row) {
        return $row['name'];
      }
      return null;
    }
  }
