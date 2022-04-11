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
  //Translate return message
  $message = file_get_contents($lang.".json");
  $message = preg_replace( '![ \t]*//.*[ \t]*[\r\n]!', '', $message );
  $message = json_decode( $message, true );
  //Input Validation
  if ($token == "") {
    $respond_array['code'] = 401;
    $respond_array['msg'] = $message['m50013'];
    echo json_encode($respond_array);
    die();
  }
  //Get User Data
  $user->access_token = $token;
  $user->getInfoByToken();
  //Check user Exists
  if ($user->user_id == null) {
    $respond_array['code'] = 401;
    $respond_array['msg'] = $message['m50014'];
    echo json_encode($respond_array);
    die();
  }
  //Check Token expiry
  if (!$redis->exists('ultraflex_'.$user->username)) {
    $respond_array['code'] = 401;
    $respond_array['msg'] = $message['m50015'];
  } else {
    //reset token expiry to keep user alive
    $redis->expire("ultraflex_".$user->username, 600);
    //turn on/off sound
    $user->sound = $user->sound == 1 ? 0 : 1;
    if ($user->soundSwitch()) {
      $respond_array['code'] = 200;
      $respond_array['msg'] = $message['m20000'];
    } else {
      $respond_array['msg'] = $message['m50017'];
    }
  }
  echo json_encode($respond_array);
