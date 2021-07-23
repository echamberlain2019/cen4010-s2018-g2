<?php 
   include('php-inc/authenticate-user.php'); // this file include config and routes
?>
 
User (<?=$USER['Username']?>) is logged in. <a href="<?=$ROUTES['logout']?>" >Logout (<?=$_SESSION[$USER_SESSION_KEY]['Username']?>)</a>