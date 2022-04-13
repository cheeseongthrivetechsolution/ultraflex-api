<?php
  //Import configs
  include_once '../../config/main_bo-api.php';
  include_once '../../config/Database.php';
  //Import models
  include_once '../../models/User.php';
  include_once '../../models/Department.php';
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
  parse_str(file_get_contents("php://input"),$put_vars);
  $username = isset($put_vars["username"]) ? $put_vars["username"] : "";
  $password = isset($put_vars["password"]) ? $put_vars["password"] : "";
  $recaptcha = isset($put_vars["recaptcha"]) ? $put_vars["recaptcha"] : "";
  $lang = isset($put_vars["lang"]) ? strtolower($put_vars['lang']) : "en";
  //Translate return message
  $message = file_get_contents("../../translate/".$lang.".json");
  $message = preg_replace( '![ \t]*//.*[ \t]*[\r\n]!', '', $message );
  $message = json_decode( $message, true );
  //Input Validation
  if ($username == "") {
    $respond_array['msg'] = $message['m50001'];
  } else if ($password == "") {
    $respond_array['msg'] = $message['m50002'];
  } else if ($recaptcha == "") {
    $respond_array['msg'] = $message['m50003'];
  }
  if ($respond_array['msg'] != "") {
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
  if (!$resp->success) {
    $respond_array['msg'] = $message['m50004'];
    echo json_encode($respond_array);
    die();
  }
  //Get User Data
  $user->username = $username;
  $user->getInfoByUsername();
  //Check user Exists
  if ($user->user_id == null) {
    $respond_array['msg'] = $message['m50005'];
    echo json_encode($respond_array);
    die();
  }
  //Verify User Status
  if ($user->status == 0) {
    $respond_array['msg'] = $message['m50006'];
  } else if ($user->status == 2) {
    $respond_array['msg'] = $message['m50007'];
  } else if ($user->status == 3) {
    $respond_array['msg'] = $message['m50008'];
  } else if ($user->status == 1) {
    //Verify Password
    $hashed_password = $user->encryptPassword($password, $user->salt);
    if ($hashed_password != $user->password) {
      if ($user->failAttempt()) {
        $respond_array['msg'] = $message['m50009'];
        if ($user->fail_login > 2) {
          if ($user->updateStatus(3)) {
            $respond_array['msg'] = $message['m50008'];
          } else {
            $respond_array['msg'] = $message['m50010'];
          }
        }
      } else {
        $respond_array['msg'] = $message['m50011'];
      }
    } else {
      if ($user->login()) {
        $respond_array['code'] = 200;
        $respond_array['msg'] = $message['m20000'];
        $respond_array['token'] = $user->access_token;
        //Set token to redis
        $redis->set('ultraflex_'.$user->username, $user->access_token, 600);
      } else {
        $respond_array['msg'] = $message['m50012'];
      }
    }
  }
  echo json_encode($respond_array);
