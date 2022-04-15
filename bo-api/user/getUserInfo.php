<?php
  //Import configs
  include_once '../../config/main_bo-api.php';
  include_once '../../config/Database.php';
  //Import models
  include_once '../../models/User.php';
  include_once '../../models/Department.php';
  include_once '../../models/Position.php';
  include_once '../../models/Role.php';
  //header
	header('Access-Control-Allow-Methods: GET');
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog post object
  $user = new User($db);
  $department = new Department($db);
  $position = new Position($db);
  $role = new Role($db);
  //prepare respond array
  $respond_array = array( 'code' => 500,
                          'row' => array(),
                          'msg' => '');
  //Get request
  $token = isset($_GET["token"]) ? $_GET["token"] : "";
  $lang = isset($_GET["lang"]) ? strtolower($_GET['lang']) : "en";
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
  //Check user Status
  if ($user->status != 1) {
    $respond_array['code'] = 401;
    $respond_array['msg'] = $message['m20001'];
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
      'username' => $user->username,
      'name' => $user->name,
      'department' => $department->getDepartmentName($user->department_id),
      'position' => $position->getPositionName($user->position_id),
      'role' => $role->getRoleName($user->role_id),
      'email' => $user->email,
      'dob' => $user->dob,
      'gender' => $user->gender,
      'avatar' => $user->avatar,
      'phone' => $user->phone,
      'last_login' => $user->last_login,
      'login_ip' => $user->login_ip,
    );
    $respond_array['code'] = 200;
    $respond_array['row'] = $data;
    $respond_array['msg'] = $message['m20000'];
  }
  echo json_encode($respond_array);
