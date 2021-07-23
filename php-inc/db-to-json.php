<?php
include('config.php');

$DB_TABLES = [];

$TABLES_TO_GET = ["UserProfiles", "Users", "Posts", "Comments" ];

foreach($TABLES_TO_GET as $table){
   $ses_sql = mysqli_query($db,"SELECT * FROM ".$table);
   $rows = mysqli_fetch_assoc($ses_sql);
   if($rows){
      $DB_TABLES[$table] = $rows;
   }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($DB_TABLES);
