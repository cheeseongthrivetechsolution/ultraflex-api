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
  $lang = isset($_GET["lang"]) ? strtolower($_GET['lang']) : "";

  if ($lang == "") {
    $lang = 'en';
  }
  //Translate return message
  $message = file_get_contents($lang.".json");
  $message = preg_replace( '![ \t]*//.*[ \t]*[\r\n]!', '', $message );
  $message = json_decode( $message, true );

  if ($token == "") {
    $respond_array['code'] = 401;
    $respond_array['msg'] = $message['m50011'];
    echo json_encode($respond_array);
    die();
  }

  $user->access_token = $token;
  //Get User Data
  $user->getToken();
  if ($user->username != null) {
    if ($redis->exists('ultraflex_'.$user->username)) {
      $redis->expire("ultraflex_".$user->username, 6000);
      $userInfo = $user->getUserInfo();
      if($userInfo){
        if ($userInfo['user_id'] != null) {
          $data =  array(
            'name' => $userInfo['name'],
            'avatar' => $userInfo['avatar'],
            'sound' => $userInfo['sound'],
          );
          $respond_array['code'] = 200;
          $respond_array['row'] = $data;
          $respond_array['msg'] = $message['m20000'];
        } else {
          $respond_array['msg'] = $message['m50006'];
        }
      } else {
        $respond_array['msg'] = $message['m50006'];
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
