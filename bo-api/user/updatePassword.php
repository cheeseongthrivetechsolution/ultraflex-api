<?php
  //Import configs
  include_once '../../config/main_bo-api.php';
  include_once '../../config/Database.php';
  //Import models
  include_once '../../models/User.php';
  //header
	header('Access-Control-Allow-Methods: PUT');
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog post object
  $user = new User($db);
  //prepare respond array
  $respond_array = array( 'code' => 500,
                          'msg' => '');
  //Get request, parse data for method PUT/DELETE
  parse_str(file_get_contents("php://input"),$put_vars);
  $token = isset($put_vars["token"]) ? $put_vars["token"] : "";
  $lang = isset($put_vars["lang"]) ? strtolower($put_vars['lang']) : "en";

  $current = isset($put_vars["current"]) ? $put_vars["current"] : "";
  $new = isset($put_vars["new"]) ? $put_vars['new'] : "";
  $confirm_new = isset($put_vars["confirm_new"]) ? $put_vars["confirm_new"] : "";
  //Translate return message
  $message = file_get_contents("../../translate/".$lang.".json");
  $message = preg_replace( '![ \t]*//.*[ \t]*[\r\n]!', '', $message );
  $message = json_decode( $message, true );
  //Input Validation
  if ($token == "") {
    $respond_array['code'] = 401;
    $respond_array['msg'] = $message['m50013'];
    echo json_encode($respond_array);
    die();
  }
  if ($current == "") {
    $respond_array['msg'] = $message['m50021'];
    echo json_encode($respond_array);
    die();
  }
  if ($new == "") {
    $respond_array['msg'] = $message['m50022'];
    echo json_encode($respond_array);
    die();
  } else {
    if (strlen($new) < 6 || preg_match('[@_!#$%^&*()<>?/|}{~:]', $new)) {
      $respond_array['msg'] = $message['m50023'];
      echo json_encode($respond_array);
      die();
    }
  }
  if ($confirm_new == "") {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $respond_array['msg'] = $message['m50024'];
      echo json_encode($respond_array);
      die();
    }
  } else if ($confirm_new != $new) {
    $respond_array['msg'] = $message['m50025'];
    echo json_encode($respond_array);
    die();
  }
  //Get User Data
  $user->access_token = $token;
  $user->getInfoByToken();
  //Check user Exists
  if ($user->user_id == null) {
    $respond_array['msg'] = $message['m50014'];
    echo json_encode($respond_array);
    die();
  }
  //Check user Status
  if ($user->status != 1) {
    $respond_array['code'] = 401;
    $respond_array['msg'] = $message['m20001'];
    echo json_encode($respond_array);
    die();
  }
  if ($user->password != $user->encryptPassword($current, $user->salt)) {
    $respond_array['msg'] = $message['m50026'];
    echo json_encode($respond_array);
    die();
  }
  //Check Token expiry
  if (!$redis->exists('ultraflex_'.$user->username)) {
    $respond_array['code'] = 401;
    $respond_array['msg'] = $message['m50015'];
  } else {
    //reset token expiry to keep user alive
    $redis->expire("ultraflex_".$user->username, 1800);
    //update properties
    $user->password = $new;
    if ($user->updatePassword()) {
      $respond_array['code'] = 200;
      $respond_array['msg'] = $message['m20003'];
    } else {
      $respond_array['msg'] = $message['m50017'];
    }
  }
  echo json_encode($respond_array);
