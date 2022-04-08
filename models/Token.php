<?php 
  class Token {
    // DB stuff
    private $conn;
    private $table = 'token';

    // Post Properties
    public $token_id;
    public $user_id;
    public $access_token;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    //getToken
    public function getToken() {
        
    }

    //Create Token
    public function create() {
        
    }
    
  }