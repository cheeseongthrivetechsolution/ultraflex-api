<?php
	//Defining environment DEV = development, STAGING = staging, PROD = production;
	$environment = "DEV";

	//Database
	putenv("host=localhost");
	putenv("db_name=ultraflexV2");
	putenv("username=ultraflex");
	putenv("password=ultraflexultraflex");
	//Cors
	putenv("access_origin=frontend-production-url");

	if ($environment == 'DEV') {
		//Database
		putenv("host=localhost");
		putenv("db_name=test");
		putenv("username=root");
		putenv("password=");
		//Cors
		putenv("access_origin=*");
	} else if ($environment == 'STAGING') {
		//Database
		putenv("host=localhost");
		putenv("db_name=ultraflexV2stage");
		putenv("username=ultraflex");
		putenv("password=ultraflexultraflex");
		//Cors
		putenv("access_origin=frontend-staging-url");
	}
	header('Access-Control-Allow-Origin: '.getenv('access_origin'));
	header('Content-Type: application/json');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

	try {
		// Create a Redis Instance
		$redis = new \Redis();

		// Try to connect to a redis server
		// In this case within the host machine and the default port of redis
		$redis->connect('127.0.0.1', 6379);

		/***********USAGE*************/
		// Define some Key
		// $redis->set('user', 'sdkcarlos');

		// Obtain value
		// $user = $redis->get('user');

		// Should Output: sdkcarlos
		// print($user);
	} catch (Exception $ex) {
		echo $ex->getMessage();
	}
