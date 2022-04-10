<?php
	class Database {
		//DB Params
		private $host;
		private $db_name;
		private $username;
		private $password;
		private $conn;

		public function __construct() {
        $this->host = getenv('host');
        $this->db_name = getenv('db_name');
        $this->username = getenv('username');
        $this->password = getenv('password');
    }
		//DB Connect
		public function connect() {
			$this->conn = null;

			try {
				$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->username, $this->password);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e) {
				echo 'DB Connection Error: '.$e->getMessage();
			}
			return $this->conn;
		}
	}
