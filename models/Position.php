<?php
  class Position {
    // DB stuff
    private $conn;
    private $table = 'position';
    // Post Properties
    public $position_id;
    public $department_id;
    public $name;
    public $code;
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
