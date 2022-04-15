<?php
  class Role {
    // DB stuff
    private $conn;
    private $table = 'role';
    // Post Properties
    public $role_id;
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

    //Get Role Name
    public function getRoleName($id) {
      // Create query
      $query = '  SELECT name FROM ' . $this->table . '
                  WHERE role_id = :role_id AND status = 1;';
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Bind ID
      $stmt->bindParam(':role_id', $id);
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
