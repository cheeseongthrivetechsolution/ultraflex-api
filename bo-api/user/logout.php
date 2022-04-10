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

  //Get request
  $token = isset($_REQUEST["token"]) ? $_REQUEST["token"] : "";
  $lang = isset($_REQUEST["lang"]) ? strtolower($_REQUEST['lang']) : "";

  if ($lang == "") {
    $lang = 'en';
  }
  //Translate return message
  $message = file_get_contents($lang.".json");
  $message = preg_replace( '![ \t]*//.*[ \t]*[\r\n]!', '', $message );
  $message = json_decode( $message, true );

  if ($token== "") {
    $respond_array['code'] = 401;
    $respond_array['msg'] = $message['m50011'];
    echo json_encode($respond_array);
    die();
  }

  $user->access_token = $token;
  //Get User Token
  $user->getToken();
  if ($user->username != null) {
    if ($redis->exists('ultraflex_'.$user->username)) {
      $redis->delete('ultraflex_'.$user->username);
      if ($user->logout()) {
        $respond_array['code'] = 200;
        $respond_array['msg'] = $message['m20000'];
      } else {
        $respond_array['msg'] = $message['m50014'];
      }
    } else {
      $respond_array['code'] = 401;
      $respond_array['msg'] = $message['m50013'];
    }
  } else {
    $respond_array['code'] = 401;
    $respond_array['msg'] = $message['m50012'];
  }

  echo json_encode($respond_array);
