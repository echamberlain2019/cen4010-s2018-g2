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

<?php 
 include 'main.php';
 $check  = new Main;
 $get    = new Main;
 $send   = new Main;
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

<html>
 <head>
  <title>Post on Covid Hut</title>
  <link rel="stylesheet" href="css/style.css"/>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

 </head>
<body>
<div class="head">
 <div class="head-in">
  <diV class="head-logo">
   <h1 class="h-1"></h1>
  </div><?php 
   if($check->logged_in() === false){
    include 'login.php';
   } 
  ?></div>
</div>



 <div class="wrapper">  
  <div class="content">
   <div class="center">
    <div class="posts">
     <div class="create-posts">
      <form action="" method="post" enctype="multipart/form-data">
      <div class="c-header">
       <div class="c-h-inner">
        <ul> 
         <li style="border-right:none;"><img src="img/icon3.png"></img><a href="#">Update Status</a></li>
         <li><input type="file"  onchange="readURL(this);" style="display:none;" name="post_image" id="uploadFile"></li>
         <li><img src="img/icon1.png"></img><a href="#" id="uploadTrigger" name="post_image">Add Photos/Video</a></li>
        </ul>
       </div>
      </div>
      <div class="c-body">
       <div class="body-left">
        <div class="img-box">
         <img src="<?php echo $data['profile_image'];?>"></img>
         
        </div>
       </div>
       <div class="body-right">
        <textarea class="text-type" name="status" placeholder="What's on your mind?"></textarea>
       </div>
       <div id="body-bottom">
       <img src="#"  id="preview"/>
       </div>
      </div>
      <div class="c-footer">
       <div class="right-box">
        <ul>
         <li><button class="btn1"><img class="iconw-margin" src="img/iconw.png"></img>Public<img class="iconp-margin" src="img/iconp.png"></img></button></li>
         <li><input type="submit" name="submit" value="Post" class="btn2"/></li>
        </ul>
       </div>
        
       </div>
      </div>
      </div>
  <script type="text/javascript">
        $("#uploadTrigger").click(function(){
           $("#uploadFile").click();
        });
              function readURL(input) {
                  if (input.files && input.files[0]) {
                      var reader = new FileReader();

                      reader.onload = function (e) {
                       $('#body-bottom').show();
                          $('#preview').attr('src', e.target.result);
                      }

                      reader.readAsDataURL(input.files[0]);
                  }
              }

        </script>
<?php foreach($post as $row){
       $time_ago = $row['status_time'];
      echo '
      <div class="post-show">
         <div class="post-show-inner">
          <div class="post-header">
           <div class="post-left-box">
            <div class="id-img-box"><img src="'.$row['profile_image'].'"></img></div>
            <div class="id-name">
             <ul>
              <li><a href="#">'.$row['username'].'</a></li>
              <li><small>'.$get->timeAgo($time_ago).'</small></li>
             </ul>
            </div>
           </div>
           <div class="post-right-box"></div>
          </div>
         
           <div class="post-body">
           <div class="post-header-text">
            '.$row['status'].'
           </div>'.( ($row['status_image'] != 'NULL') ? '<div class="post-img">
            <img src="'.$row['status_image'].'"></img></div>' : '').'
           <div class="post-footer">
            <div class="post-footer-inner">
             <ul>
              <li><a href="#">Like</a></li>
              <li><a href="#">Comment</a></li>
              <li><a href="#">Share</a></li>
             </ul> 
            </div>
           </div>
          </div>
         </div>
        </div><br> ';  
     } 
    ?>
        </div>
     </form> 
             
   </div>

 



</body>
</html>
