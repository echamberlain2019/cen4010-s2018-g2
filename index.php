<!DOCTYPE html>
<html lang="en">
<head>
  <title>Covid Hut</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
  <script src="main.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="home.css">   
  <link rel="stylesheet" href="post.css">

</head>
<body style="padding-top:150px; background: linear-gradient(to bottom, #ffffff 0%, #000000 100%);">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-C9F8W5GX0Y"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-C9F8W5GX0Y');

</script>
<div class="container-fluid bg-1 text-center" style="align-content: center; padding-left: 50px; padding-right: 50px; padding-bottom: 20px;">
  <form action="search.php" method="post">
	<input type="text" name="search" placeholder="Search for members..." />
	<input type="submit" value=">>" />
 </form>

</div>

<div class="container-fluid bg-1 text-center" style="padding-top: 0px; padding-bottom: 20px;">
       <h2 style="text-align:center; font-size:50px; font-weight: bolder;">Welcome to Covid Hut!</h2>
       <h3 style="text-align:center;">Feel free to browse the newest posts, search for specific posts, or browse our Covid Count and Testing Sites pages!</h3>
</div>
 <br><br>
 <?php include_once('php-inc/nav.php'); ?>
 <br><br>

<div class="container-fluid" style="background-image: url('blue_background.jpg'); background-size:cover;">
   <div style="height:30px; background-color:black; color:transparent;">
       <?php include_once('post.php'); ?>
   </div>
 
   <div class="center">
         <div class="posts">
                <div class="create-posts">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="post-header">
                                <div class="post-h-inner">
                                    <ul> 
                                        <li style="border-right:none;"><i class="fa fa-pencil-square-o" aria-hidden="true" style="padding-right:10px;"></i><a href="#">Update Status</a></li>
                                        <li><input type="file" onchange="readURL(this);" style="display:none;" name="post_image" id="uploadFile"></li>
                                        <li><i class="fa fa-camera" aria-hidden="true"style="padding-right:10px;"></i><a href="#" id="uploadTrigger" name="post_image">Add Photo/Video</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="post-body">
                                <div class="body-left">
                                    <div class="img-box">
                                        <img src="<?=$user_profile['ProfilePic']?>"></img>
         
                                    </div>
                                </div>
                                <div class="body-right">
                                    <textarea   textarea class="text-type" name="content" placeholder="What do you want to talk about?"></textarea>
                                </div>
                                <div id="body-bottom">
                                    <img src="#"  id="preview"/>
                                </div>
                            </div>
                            <div class="post-footer">
                                <div class="right-box">
                                    <ul>
                                    <li><button class="btn1"><i class="fa fa-globe" aria-hidden="true" style="padding-right:10px;"></i>Public</button></li>
                                    <li><input type="submit" name="submit" value="Post" class="btn2"/></li>
                                    </ul>
                                </div>
        
                            </div>
                        </form>
                    </div>
                </div>

                <?php $posts  = posts();?>
                <?php foreach($posts as $post): ?>
                
                    <div class="post-show">
                        <div class="post-show-inner">
                            <div class="post-header">
                                <div class="post-left-box">
                                    <div class="id-img-box"><img src="<?=str_replace('../assets/', 'assets/', ($post['ProfilePic']?? 'https://via.placeholder.com/100'))?>"></img></div>
                                    <div class="id-name">
                                        <ul>
                                            <li><a href="#"><?=$post['Username']?></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="post-right-box"></div>
                            </div>
                            
                            <form action="" method="post" class="" enctype="multipart/form-data">
                                <div class="post-body">
                                    <div class="post-header-text"><?=$post['Content']?></div>
                                    
                                    
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
                                                <li><input type="submit" name="like" value="Likes (<?=$post['Likes']?>)" class="btn2"/></li>
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

            </div>
      </div>
 </div>


<footer class="container-fluid bg-2 text-center" style="background-color: white; text-align: center;">
    <h2 style="color: grey; text-align:center; vertical-align: middle;">Copyright 2021 Covid Hut</h2>
</footer>

</body>
</html>
