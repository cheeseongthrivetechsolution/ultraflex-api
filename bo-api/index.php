<?php 
  //Connecting to Redis server on localhost 
  $redis = new Redis(); 
  $redis->connect('127.0.0.1', 6379); 
  echo "Connection to server sucessfully";

   var_dump($redis);   
   $redis->set("say","Hello World");
   echo $redis->get("say");