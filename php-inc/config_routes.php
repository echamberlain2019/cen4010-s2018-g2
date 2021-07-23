<?php
$ServerPath = explode('/', $_SERVER['REQUEST_URI']);


// APP CONFIG 
$ROUTES = [
    'home' => '/'.$ServerPath[1].'/index.php',
    'login' => '/'.$ServerPath[1].'/user/login.php',
    'logout' => '/'.$ServerPath[1].'/user/logout.php',
    'register' => '/'.$ServerPath[1].'/user/register.php',
    'profile'  => '/'.$ServerPath[1].'/user/profile.php',
    'about'  => '/'.$ServerPath[1].'/about.html',
    'post'  => '/'.$ServerPath[1].'/post.php',
 ];
