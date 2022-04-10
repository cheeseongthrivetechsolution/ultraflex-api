<?php
  //Import configs
  include_once '../../config/main_bo-api.php';
  include_once '../../config/Database.php';
  //Import models
  include_once '../../models/User.php';
  //header
	header('Access-Control-Allow-Methods: POST');

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $user = new User($db);

  //prepare respond array
  $respond_array = array( 'code' => 500,
                          'msg' => '',
                          'token' => '');
  //Get request
  $username = isset($_POST["username"]) ? $_POST["username"] : "";
  $password = isset($_POST["password"]) ? $_POST["password"] : "";
  $recaptcha = isset($_POST["recaptcha"]) ? $_POST["recaptcha"] : "";
  $lang = isset($_POST["lang"]) ? strtolower($_POST['lang']) : "";

  if ($lang == "") {
    $lang = 'en';
  }
  //Translate return message
  $message = file_get_contents($lang.".json");
  $message = preg_replace( '![ \t]*//.*[ \t]*[\r\n]!', '', $message );
  $message = json_decode( $message, true );
  if ($password== "" || $username== ""  || $recaptcha == "") {
    $respond_array['msg'] = $message['m50001'];
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
		                'response' => $recaptcha];
	curl_setopt($curlx, CURLOPT_POSTFIELDS, $verify_data);
	$resp = json_decode(curl_exec($curlx));
	curl_close($curlx);
	if ($resp->success) {
    $user->username = $username;

    //Get User Data
    $user->getLoginCredentials();
    //Verify User Login Credential
    if ($user->user_id != null) {
      //Check User Status
      if ($user->status == 1) {
        //Verify Password
        $hashed_password = hash_hmac('sha256', $password, $user->salt);
        if ($user->password == $hashed_password) {
          if ($user->login()) {
            $respond_array['code'] = 200;
            $respond_array['msg'] = $message['m20000'];
            $respond_array['token'] = $user->access_token;
            //Set token to redis
            $redis->set('ultraflex_'.$user->username, $user->access_token, 6000);
          } else {
            $respond_array['msg'] = $message['m50009'];
          }
        } else {
          if ($user->failAttempt()) {
            $respond_array['msg'] = $message['m50008'];
            if ($user->fail_login > 2) {
              if ($user->updateStatus(3)) {
                $respond_array['msg'] = $message['m50003'];
              } else {
                $respond_array['msg'] = $message['m50007'];
              }
            }
          } else {
            $respond_array['msg'] = $message['m50007'];
          }
        }
      } else if ($user->status == 2) {
        $respond_array['msg'] = $message['m50002'];
      } else if ($user->status == 3) {
        $respond_array['msg'] = $message['m50003'];
      } else if ($user->status == 0) {
        $respond_array['msg'] = $message['m50004'];
      } else {
        $respond_array['msg'] = $message['m50005'];
      }
    } else {
      $respond_array['msg'] = $message['m50006'];
    }
  } else {
    $respond_array['msg'] = $message['m50010'];
  }

  echo json_encode($respond_array);
