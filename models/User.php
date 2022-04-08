<?php 
  class User {
    // DB stuff
    private $conn;
    private $table = 'user';

    // Post Properties
    public $user_id;
    public $department_id;
    public $username;
    public $password;
    public $salt;
    public $email;
    public $dob;
    public $gender;
    public $avatar;
    public $sound;
    public $phone;
    public $remark;
    public $status;
    public $last_login;
    public $login_ip;
    public $fail_login;
    public $created_at;
    public $create_by;
    public $updated_at;
    public $update_by;
    public $access_token;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    //Login
    public function getUserByUsername() {
        // Create query
        $query = '  SELECT * 
                    FROM ' . $this->table . '
                    WHERE
                        username = :username ';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':username', $this->username);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        if ($row) {
            $this->user_id = $row['user_id'];
            $this->department_id = $row['department_id'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->salt = $row['salt'];
            $this->email = $row['email'];
            $this->dob = $row['dob'];
            $this->gender = $row['gender'];
            $this->avatar = $row['avatar'];
            $this->sound = $row['sound'];
            $this->phone = $row['phone'];
            $this->remark = $row['remark'];
            $this->status = $row['status'];
            $this->last_login = $row['last_login'];
            $this->login_ip = $row['login_ip'];
            $this->fail_login = $row['fail_login'];
            $this->created_at = $row['created_at'];
            $this->create_by = $row['create_by'];
            $this->updated_at = $row['updated_at'];
            $this->update_by = $row['update_by'];
            $this->access_token = $row['access_token'];
        }
        
    }
    
    //Failed Login Attempt
    public function failAttempt() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                    SET fail_login = :fail_login
                    WHERE user_id = :user_id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        $this->fail_login = $this->fail_login+1;

        // Bind data
        $stmt->bindParam(':fail_login', $this->fail_login);
        $stmt->bindParam(':user_id', $this->user_id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function updateStatus($status) {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                    SET status = :status, fail_login = 0
                    WHERE user_id = :user_id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $this->user_id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function createToken() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                    SET access_token = :access_token
                    WHERE user_id = :user_id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Create access token
        $access_token = hash_hmac('sha256', $this->username . $this->password, $this->randomKey());
        $this->access_token = $access_token;

        // Bind data
        $stmt->bindParam(':access_token', $access_token);
        $stmt->bindParam(':user_id', $this->user_id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function randomKey() {
		$salt = "";
		$index = 0;
		$sl = 32;

		$letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','Z','0','1','2','3','4','5','6','7','8','9');
		for ($i = 0; $i < $sl; $i++) {
			$index = mt_rand(0, count($letters) - 1);
			$salt .= ($index % 2) == 0 ? $letters[$index] : strtolower($letters[$index]);
		}
		return $salt;
	}

    
  }