<?php
  class User {
    // DB stuff
    private $conn;
    private $table = 'user';
    // Post Properties
    public $user_id;
    public $department_id;
    public $role_id;
    public $username;
    public $password;
    public $salt;
    public $name;
    public $email;
    public $dob;
    public $gender;
    public $avatar;
    public $phone;
    public $remark;
    public $status;
    public $last_login;
    public $login_ip;
    public $fail_login;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $access_token;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    //Get user info by username
    public function getInfoByUsername() {
        // Create query
        $query = '  SELECT * FROM ' . $this->table . '
                    WHERE username = :username';
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
          $this->role_id = $row['role_id'];
          $this->username = $row['username'];
          $this->password = $row['password'];
          $this->salt = $row['salt'];
          $this->name = $row['name'];
          $this->email = $row['email'];
          $this->dob = $row['dob'];
          $this->gender = $row['gender'];
          $this->avatar = $row['avatar'];
          $this->phone = $row['phone'];
          $this->remark = $row['remark'];
          $this->status = $row['status'];
          $this->last_login = $row['last_login'];
          $this->login_ip = $row['login_ip'];
          $this->fail_login = $row['fail_login'];
          $this->created_at = $row['created_at'];
          $this->created_by = $row['created_by'];
          $this->updated_at = $row['updated_at'];
          $this->updated_by = $row['updated_by'];
          $this->access_token = $row['access_token'];
        }
    }

    //Get user info by token
    public function getInfoByToken() {
        // Create query
        $query = '  SELECT * FROM ' . $this->table . '
                    WHERE access_token = :access_token';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind ID
        $stmt->bindParam(':access_token', $this->access_token);
        // Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Set properties
        if ($row) {
          $this->user_id = $row['user_id'];
          $this->department_id = $row['department_id'];
          $this->role_id = $row['role_id'];
          $this->username = $row['username'];
          $this->password = $row['password'];
          $this->salt = $row['salt'];
          $this->name = $row['name'];
          $this->email = $row['email'];
          $this->dob = $row['dob'];
          $this->gender = $row['gender'];
          $this->avatar = $row['avatar'];
          $this->phone = $row['phone'];
          $this->remark = $row['remark'];
          $this->status = $row['status'];
          $this->last_login = $row['last_login'];
          $this->login_ip = $row['login_ip'];
          $this->fail_login = $row['fail_login'];
          $this->created_at = $row['created_at'];
          $this->created_by = $row['created_by'];
          $this->updated_at = $row['updated_at'];
          $this->updated_by = $row['updated_by'];
          $this->access_token = $row['access_token'];
        }
    }

    //login
    public function login() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                    SET access_token = :access_token, fail_login = :fail_login, last_login = :last_login, login_ip = :login_ip
                    WHERE user_id = :user_id';
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Create access token
        $access_token = hash_hmac('sha256', $this->username . $this->password, $this->generateSalt());
        //set new data
        $this->access_token = $access_token;
        $this->fail_login = 0;
        //Temporary use. Need enhancement on date now();
        date_default_timezone_set('Asia/Singapore');
        $now = date("Y-m-d H:i:s");
        // Bind data
        $stmt->bindParam(':access_token', $access_token);
        $stmt->bindParam(':fail_login', $this->fail_login);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':last_login', $now);
        $stmt->bindParam(':login_ip', $_SERVER['REMOTE_ADDR']);
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Logout
    public function logout() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                    SET access_token = ""
                    WHERE user_id = :user_id';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind data
        $stmt->bindParam(':user_id', $this->user_id);
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        return false;
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

    //Update status
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

    //Update basic info
    public function updateBasic() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                    SET name = :name, email = :email, phone = :phone, dob = :dob, gender = :gender, updated_by = :updated_by, updated_at = :updated_at
                    WHERE user_id = :user_id';
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        date_default_timezone_set('Asia/Singapore');
        $now = date("Y-m-d H:i:s");
        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':dob', $this->dob);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':updated_by', $this->user_id);
        $stmt->bindParam(':updated_at', $now);
        $stmt->bindParam(':user_id', $this->user_id);
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Update basic info
    public function updatePassword() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                    SET password = :password, salt = :salt, updated_by = :updated_by, updated_at = :updated_at
                    WHERE user_id = :user_id';
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        date_default_timezone_set('Asia/Singapore');
        $now = date("Y-m-d H:i:s");
        $salt = $this->generateSalt();
        $this->password = $this->encryptPassword($this->password, $salt);
        // Bind data
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':salt', $salt);
        $stmt->bindParam(':updated_by', $this->user_id);
        $stmt->bindParam(':updated_at', $now);
        $stmt->bindParam(':user_id', $this->user_id);
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Failed Login Attempt
    // public function soundSwitch() {
    //     // Create query
    //     $query = 'UPDATE ' . $this->table . '
    //                 SET sound = :sound
    //                 WHERE user_id = :user_id';
    //     // Prepare statement
    //     $stmt = $this->conn->prepare($query);
    //     // Bind data
    //     $stmt->bindParam(':sound', $this->sound);
    //     $stmt->bindParam(':user_id', $this->user_id);
    //     // Execute query
    //     if($stmt->execute()) {
    //         return true;
    //     }
    //     return false;
    // }

    //Generate Salt for hashing
    public function generateSalt() {
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

    //Encript password and etc.
    public function encryptPassword($string, $salt) {
      return hash_hmac('sha256', $string, $salt);
    }
  }
