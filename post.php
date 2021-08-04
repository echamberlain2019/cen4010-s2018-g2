<?php
    include('php-inc/authenticate-user.php'); // this file include config and routes
    
    $has_profile = false;
    $user_profile = false;
    if(!empty($USER)){
        
        $ses_sql = mysqli_query($db,"SELECT * from UserProfiles WHERE username = '".$USER['Username']."' ");
        $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
        if($row){
            $has_profile = true;
            $user_profile = $row;

            $user_profile['ProfilePic'] = str_replace('../assets/', 'assets/', $user_profile['ProfilePic']);
        }        
        
    }   



    function posts(){
        global $db;
        $query = $db->query("SELECT  * FROM Posts as p LEFT JOIN UserProfiles AS up ON p.Username = up.Username ");
     
        if($query){
            $result = [];
            while ($row = $query->fetch_assoc()) {
                $result[] = $row;
            }
            // var_dump($result);
          return $result;
        }
        return [];
    }

    function post_comments($PostID){
        global $db;
        $query = $db->query("SELECT  * FROM Comments WHERE PostID = '".$PostID."' ");
     
        if($query){
            $result = [];
            while ($row = $query->fetch_assoc()) {
                $result[] = $row;
            }
            // var_dump($result);
            return $result;
        }
        return [];
    }
    
    function add_post($Username,$Content){
      global $db; 
      $query = $db->prepare('INSERT INTO `Posts` (`PostID`, `Username`, `Content`, `DatePublished`, `Likes`, `Hashtag`) VALUES (NULL, ?, ?, CURRENT_TIMESTAMP, 0, NULL)');
      $query->bind_param("ss", $Username, $Content);
      $query->execute();
      //var_dump($query);
      return $query->insert_id ?? 0;
    }

    function add_like_to_post($PostID){
        global $db; 
        $query = $db->query("UPDATE Posts SET Likes = Likes + 1 WHERE PostID = '".$PostID."'");
        return $query;
    }

    function add_comment_to_post($Username,$PostID,$Comment){
        global $db; 
        $query = $db->prepare('INSERT INTO `Comments` (`PostCommentID`, `PostID`, `CommenterID`, `Comment`, `DateCommented`) VALUES (NULL, ?, ?, ?, CURRENT_TIMESTAMP)');
        $query->bind_param("iss", $PostID, $Username, $Comment);
        $query->execute();
        var_dump($query);
        return $query->insert_id ?? 0;
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

 
    var_dump($_POST);
    if(isset($_POST['submit']) && !empty($_POST['content'])){
        if(add_post($USER['Username'],$_POST['content'])){
            header("Location: post.php");
        }
    }

    if(isset($_POST['like']) && !empty($_POST['PostID'])){
        if(add_like_to_post($_POST['PostID'])){
            header("Location: post.php");
        }
    }

    if(isset($_POST['comment']) && !empty($_POST['PostID']) && !empty($_POST['comment_content'])){
        if(add_comment_to_post($USER['Username'], $_POST['PostID'], $_POST['comment_content'])){
            header("Location: post.php");
        }
    }
?>

<html>
 <head>
    <title>Post on Covid Hut</title>
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

  
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/main.css">
    <link rel="stylesheet" href="post.css">
    
</head>

<body>
    <?php include_once('php-inc/nav.php'); ?>
    <div class="head">
        <div class="head-in">
            <div class="head-logo">
                <h1 class="h-1"></h1>
            </div>
        </div>
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
                                        <li style="border-right:none;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><a href="#">Update Status</a></li>
                                        <li><input type="file" onchange="readURL(this);" style="display:none;" name="post_image" id="uploadFile"></li>
                                        <li><i class="fa fa-camera" aria-hidden="true"></i><a href="#" id="uploadTrigger" name="post_image">Add Photos/Video</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="c-body">
                                <div class="body-left">
                                    <div class="img-box">
                                        <img src="<?=$user_profile['ProfilePic']??'https://via.placeholder.com/100';?>"></img>
         
                                    </div>
                                </div>
                                <div class="body-right">
                                    <textarea   textarea class="text-type" name="content" placeholder="What's on your mind?"></textarea>
                                </div>
                                <div id="body-bottom">
                                    <img src="#"  id="preview"/>
                                </div>
                            </div>
                            <div class="c-footer">
                                <div class="right-box">
                                    <ul>
                                    <li><button class="btn1"><i class="fa fa-globe" aria-hidden="true"></i>Public</button></li>
                                    <li><input type="submit" name="submit" value="Post" class="btn2"/></li>
                                    </ul>
                                </div>
        
                            </div>
                        </form>
                    </div>
                </div>

                <?php $posts  = posts(); ?>
                <?php if($posts  && count($posts) > 0): ?>
                <?php foreach($posts as $post): ?>
                
                    <div class="post-show">
                        <div class="post-show-inner">
                            <div class="post-header">
                                <div class="post-left-box">
                                    <div class="id-img-box"><img src="<?=str_replace('../assets/', 'assets/', ($post['ProfilePic']?? 'https://via.placeholder.com/100'))?>"></img></div>
                                    <div class="id-name">
                                        <ul>
                                            <li><a href="#"><?=$post['Username']?></a></li>
                                            <li><small><?=timeAgo($post['DatePublished'])?></small></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="post-right-box"></div>
                            </div>
                            
                            <form action="" method="post" class="" enctype="multipart/form-data">
                                <div class="post-body">
                                    <div class="post-header-text"><?=$post['Content']??''?></div>
                                    
                                    <?php if( !empty($post['status_image']) ) : ?> 
                                        <!-- this is not used what is status_image ??? -->
                                        <div class="post-img">
                                            <img src="<?=$post['status_image']?>"/>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php $post_comments = post_comments($post['PostID']); ?>
                                    <?php if( !empty($post_comments) ) : ?> 
                                        <div class="comments">
                                            <?php foreach($post_comments as $comment): ?>
                                                <div class="a-comment">
                                                    <div class="commnet-text"><?=$comment['Comment']?></div>
                                                    <small class="commenter-username"><?=$comment['CommenterID']?></small>
                                                    <small class="comment-date"><?=$comment['DateCommented']?></small>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                
                                    <input type="hidden" name="PostID" value="<?=$post["PostID"]?>">
                                    <textarea class="text-type" name="comment_content" placeholder="Comment"></textarea>
                                    

                                    <div class="post-footer">
                                        <div class="post-footer-inner">
                                            <ul>
                                                <li><input type="submit" name="like" value="Likes (<?=$post['Likes']??0?>)" class="btn2"/></li>
                                                <li><input type="submit" name="comment" value="Comment" class="btn2"/></li>
                                                <li><a href="#">Share</a></li>
                                            </ul> 
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
</body>
</html>