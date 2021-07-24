<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
  <script src="main.js"></script>
  <link rel="stylesheet" href="home.css">
</head>
<body>

<?php session_start();?>
<?php ## if(!empty($_SESSION['user_id'])): you can use this instead when user_id is created ?>
<?php if(!empty($_SESSION['login_user']['Username'])): ?>
User (<?=$USER['Username']?>) is logged in. <a href="<?=$ROUTES['logout']?>" >Logout (<?=$_SESSION['login_user']['Username']?>)</a>
<?php else: ?>
   User not logged in.
<?php endif; ?>
   @$user_id = $_SESSION['user_id'];
   $data  = $get->user_data($user_id);
  $post  = $get->posts();
  if(isset($_POST['submit'])){
      $status  = $_POST['status'];
  if (isset($_FILES['post_image'])===true) {
      if (empty($_FILES['post_image']['name']) ===true) {
      if(!empty($status)===true){
         $send->add_post($user_id,$status);
    }
      }else {                                                                                                      
     $allowed = array('jpg','jpeg','gif','png'); 
     $file_name = $_FILES['post_image']['name']; 
     $file_extn = strtolower(end(explode('.', $file_name)));
     $file_temp = $_FILES['post_image']['tmp_name'];
     
     if (in_array($file_extn, $allowed)===true) {
      $file_parh = 'images/posts/' . substr(md5(time()), 0, 10).'.'.$file_extn;
       move_uploaded_file($file_temp, $file_parh);
       $send->add_post($user_id,$status,$file_parh);

     }else{
      echo 'incorrect File only Allowed with less then 1mb ';
      echo implode(', ', $allowed);
     }
    }
   
  }
?>

<?php
   function posts(){
    global $pdo;
    $query = $pdo->prepare("SELECT * FROM `posts`,`users` WHERE user_id = user_id_p ORDER BY `post_id` DESC");
    $query->execute();
    return $query->fetchAll();
    }
  
   function add_post($user_id,$status,$file_parh){
    global $pdo; 
    if(empty($file_parh)){
     $file_parh = 'NULL';
    }
    $query = $pdo->prepare('INSERT INTO `posts` (`post_id`, `user_id_p`, `status`, `status_image`, `status_time`) VALUES (NULL, ?, ?,?,  CURRENT_TIMESTAMP)');
    $query->bindValue(1,$user_id);
    $query->bindValue(2,$status);
    $query->bindValue(3,$file_parh);
    $query->execute();
    header('Location: index.php');
   }

   function user_data($user_id){
    global $pdo;
    $query = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
    $query->bindvalue(1,$user_id);
    $query->execute();
 
    return $query->fetch();
   }
 
   function timeAgo($time_ago){
 
    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );

    if($seconds <= 60){
        return "just now";
    }

    else if($minutes <=60){
        if($minutes==1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }

    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }

    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }

    else if($weeks <= 4.3){
        if($weeks==1){
            return "a week ago";
        }else{
            return "$weeks weeks ago";
        }
    }

    else if($months <=12){
        if($months==1){
            return "a month ago";
        }else{
            return "$months months ago";
        }
    }

    else{
        if($years==1){
            return "one year ago";
        }else{
            return "$years years ago";
        }
    }
   }
  }
?>

