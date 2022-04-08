<?php 
  // Headers
  include_once '../../config/postHeader.php';
  include_once '../../config/Database.php';
  include_once '../../config/redis.php';
  include_once '../../models/User.php';
  
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $user = new User($db);
  
  //prepare respond array
  $respond_array = array( 'code' => 500,
                          'msg' => '',
                          'msgCode' => 0,
                          'token' => '');

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  if ($data->recaptcha == null || $data->username == null  || $data->password == null  ) {
    $respond_array['msg'] = "Please fill in all fields";
    $respond_array['msgCode'] = 50001;  
    echo json_encode($respond_array);
    die();
  }

  //verify recaptcha
  $curlx = curl_init();

	curl_setopt($curlx, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($curlx, CURLOPT_HEADER, 0);
	curl_setopt($curlx, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlx, CURLOPT_POST, 1);
	$verify_data =  [ 'secret' => '6LdCK1cfAAAAAMpSvzND9MI6w6HBEx1DtXHVoOal', //<--- your reCaptcha secret key
		              'response' => $data->recaptcha];
	curl_setopt($curlx, CURLOPT_POSTFIELDS, $verify_data);
	$resp = json_decode(curl_exec($curlx));
	curl_close($curlx);
	if ($resp->success) {
    $user->username = $data->username;

    //Get User Data
    $user->getUserByUsername();
    //Verify User Login Credential
    if ($user->user_id != null) {
      //Check User Status
      if ($user->status == 1) {
        //Verify Password
        $hashed_password = hash_hmac('sha256', $data->password, $user->salt);
        if ($user->password == $hashed_password) {
          if ($user->createToken()) {
            $respond_array['code'] = 200;
            $respond_array['msg'] = "Action success!";
            $respond_array['msgCode'] = 20000;
            $respond_array['token'] = $user->access_token;
          } else {
            $respond_array['msg'] = "Unknown error on token creation. Please contact admin!";
            $respond_array['msgCode'] = 50009; 
          }
        } else {
          if ($user->failAttempt()) {
            $respond_array['msg'] = "Wrong password entered!";
            $respond_array['msgCode'] = 50008;
            if ($user->fail_login > 2) {
              if ($user->updateStatus(3)) {
                $respond_array['msg'] = "Your account was blocked. Please contact admin!";  
                $respond_array['msgCode'] = 50003; 
              } else {
                $respond_array['msg'] = "Unknown error on fail login attempt. Please contact admin!";
                $respond_array['msgCode'] = 50007; 
              }
            }
          } else {
            $respond_array['msg'] = "Unknown error on fail login attempt. Please contact admin!";
            $respond_array['msgCode'] = 50007; 
          }
        }
      } else if ($user->status == 2) {
        $respond_array['msg'] = "Your account was deactivated. Please contact admin!";
        $respond_array['msgCode'] = 50002;  
      } else if ($user->status == 3) {
        $respond_array['msg'] = "Your account was blocked. Please contact admin!";  
        $respond_array['msgCode'] = 50003;  
      } else if ($user->status == 0) {
        $respond_array['msg'] = "Your account was deleted. Please contact admin!"; 
        $respond_array['msgCode'] = 50004;  
      } else {
        $respond_array['msg'] = "Unknown error. Please contact admin!";
        $respond_array['msgCode'] = 50005;  
      }
    } else {
      $respond_array['msg'] = "User not exist!";
      $respond_array['msgCode'] = 50006;  
    }
  } else {
    $respond_array['msg'] = "Captcha Failed!";
    $respond_array['msgCode'] = 58000;  
  }
  
  echo json_encode($respond_array);