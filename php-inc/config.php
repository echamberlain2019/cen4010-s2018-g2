<?php

//DEBUG 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//DB
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'cen4010_su21_g02');
define('DB_PASSWORD', '5qpmBFABZR');
define('DB_DATABASE', 'cen4010_su21_g02');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

if (mysqli_connect_errno()) {
   throw new RuntimeException("Connect to Database failed: %s\n", mysqli_connect_errno());
   die();
}

$USER_SESSION_KEY = 'login_user';
$USER_ID_SESSION_KEY = 'user_id';
$APP_NAME = 'COVID HUB';
