<?php
   
   include("../php-inc/config_routes.php");
   session_start();
   
   if(session_destroy()) {
      header("Location: ".$ROUTES['login'].'?logout=1');
   }