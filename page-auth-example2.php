<?php session_start();?>
<?php ## if(!empty($_SESSION['user_id'])): you can use this instead when user_id is created ?>
<?php if(!empty($_SESSION['login_user']['Username'])): ?>
User (<?=$USER['Username']?>) is logged in. <a href="<?=$ROUTES['logout']?>" >Logout (<?=$_SESSION['login_user']['Username']?>)</a>
<?php else: ?>
   User not logged in.
<?php endif; ?>