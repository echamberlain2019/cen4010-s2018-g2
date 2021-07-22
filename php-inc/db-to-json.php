<?php
include('config.php');

$ses_sql = mysqli_query($db,"SELECT * FROM userprofiles");
$rows = mysqli_fetch_all($ses_sql,MYSQLI_ASSOC);
if($rows){
   $DB_TABLES['userprofiless'] = $rows;
}

$ses_sql = mysqli_query($db,"SELECT * FROM users");
$rows = mysqli_fetch_all($ses_sql,MYSQLI_ASSOC);
if($rows){
   $DB_TABLES['userss'] = $rows;
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($DB_TABLES);
