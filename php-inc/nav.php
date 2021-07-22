<?php
include_once('config.php');
include_once('config_routes.php');
?>


  <header>
    <nav class="navbar d-flex flex-column flex-md-row align-items-center py-3 px-3 mb-4 border-bottom fixed-top navbar-expand-lg">
        <a  href="<?=$ROUTES['home']?>" class=" d-flex align-items-center text-dark text-decoration-none"><img src="/<?=$ServerPath[1]?>/assets/logo.png" alt="<?=$APP_NAME?>" width="20px" style=""> <span class="fs-4"><?=$APP_NAME?></span></a>
        <div class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
            <a href="#" class="me-3 py-2 text-dark text-decoration-none" >Covid Cases Count</a>
            <a href="#" class="me-3 py-2 text-dark text-decoration-none" >Covid Testing Sites</a>
            <a href="<?=$ROUTES['profile']?>" class="me-3 py-2 text-dark text-decoration-none" >Profile</a>
            <a href="<?=$ROUTES['post']?>" class="me-3 py-2 text-dark text-decoration-none" >Post</a>
            <a href="<?=$ROUTES['about']?>" class="me-3 py-2 text-dark text-decoration-none" >About</a>
            <?php if(!empty($_SESSION[$USER_SESSION_KEY])): ?>
                <a href="<?=$ROUTES['logout']?>" class="py-2 text-dark text-decoration-none" >Logout (<?=$_SESSION[$USER_SESSION_KEY]['Username']?>)</a>
            <?php else: ?>
                <a href="<?=$ROUTES['register']?>" class="me-3 py-2 text-dark text-decoration-none" >Register</a>
                <a href="<?=$ROUTES['login']?>" class="py-2 text-dark text-decoration-none">Login</a>
            <?php endif; ?>
        </div>
    </nav>
  </header>