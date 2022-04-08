<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new User($db);

  // Get ID
  // $post->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $post->login();
  
  // Create array
  // $post_arr = array(
  //   'id' => $post->id,
  //   'title' => $post->title,
  //   'body' => $post->body,
  //   'author' => $post->author,
  //   'category_id' => $post->category_id,
  //   'category_name' => $post->category_name
  // );

  // Make JSON
  echo json_encode($post);