<?php
  //Import configs
  include_once '../../config/main_bo-api.php';
  include_once '../../config/Database.php';
  //Import models
  include_once '../../models/User.php';
  include_once '../../models/Department.php';
  //header
	header('Access-Control-Allow-Methods: GET');
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog post object
  $user = new User($db);
  $department = new Department($db);
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
    $redis->expire("ultraflex_".$user->username, 1800);
    //prepare data return
    $result = $department->getDepartmentList();
    $num = $result->rowCount();

    if ($num > 0) {
      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $post_item = array(
          'department_id' => $department_id,
          'name' => $name,
          'sequence' => $sequence,
          'remark' => $remark,
          'status' => $status,
          'created_at' => $created_at,
          'created_by' => $created_by,
          'updated_at' => $updated_at,
          'updated_by' => $updated_by
        );
        array_push($respond_array['row'], $post_item);
      }
    }


    $data = $department->getDepartmentList();
    $respond_array['code'] = 200;
    $respond_array['msg'] = $message['m20000'];
  }
  echo json_encode($respond_array);
