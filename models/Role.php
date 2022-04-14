<?php
  class Role {
    // DB stuff
    private $conn;
    private $table = 'user_role';
    // Post Properties
    public
    public $role_id;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    //Get user info by username
  }
