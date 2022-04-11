<?php
  //Import configs
  include_once '../../config/main_bo-api.php';
  include_once '../../config/Database.php';
  //Import models
  include_once '../../models/User.php';
  //header
	header('Access-Control-Allow-Methods: GET');
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog post object
  $user = new User($db);
  //prepare respond array
  $respond_array = array( 'code' => 500,
                          'row' => array(),
                          'msg' => '');
  //Get request
  $token = isset($_GET["token"]) ? $_GET["token"] : "";
  $lang = isset($_GET["lang"]) ? strtolower($_GET['lang']) : "en";
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
    //reset token expiry to keep user alive for 10 minutes
    $redis->expire("ultraflex_".$user->username, 600);
    //prepare data return
    $data =  array(
      'name' => $user->name,
      'department' => "",
      'grade' => "",
      'sound' => $user->sound,
      'avatar' => $user->avatar,
      'sound' => $user->sound,
    );
    $respond_array['code'] = 200;
    $respond_array['row'] = $data;
    $respond_array['msg'] = $message['m20000'];
  }
  echo json_encode($respond_array);
