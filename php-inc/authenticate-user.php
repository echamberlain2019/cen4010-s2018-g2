<?php
   include_once('config.php');
   include_once('config_routes.php');
   session_start();
   
   
   $USER = $_SESSION[$USER_SESSION_KEY] ?? null;
   if($USER){
      $ses_sql = mysqli_query($db,"SELECT * FROM Users WHERE Username='".$USER['Username']."'");
      $rows = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
      if(!$rows){
         $USER = null;
      }
   }

   if(!$USER){
      header("location:".$ROUTES['login']);
      die();
   }