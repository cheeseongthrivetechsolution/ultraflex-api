<?php
  class Role {
    // DB stuff
    private $conn;
    private $table = 'user_role';
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

    //Get user info by username
  }
