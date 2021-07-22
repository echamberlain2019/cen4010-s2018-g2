<?php
   include('../php-inc/authenticate-user.php');
   $has_profile = false;
   $user_profile = false;
   if(!empty($USER)){
        
        $ses_sql = mysqli_query($db,"SELECT * from userprofiles WHERE username = '".$USER['Username']."' ");
        $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
        if($row){
            $has_profile = true;
            $user_profile = $row;
        }        
        
   }

    $_SESSION['profile_update_msg'] = '';
    $_SESSION['profile_update_success'] = true;

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $count = 0;
        // username and password sent from form 

        if(!empty($_POST['username'])){
            

            $user_profile['Username'] = mysqli_real_escape_string($db,$_POST['username']);
            $user_profile['Bio'] = mysqli_real_escape_string($db,$_POST['bio']); 

            if(!empty($_FILES["profilepic"]["name"]) ){
                $target_dir = '../assets/uploads/';
                
                $target_file = $target_dir . '/' . time() .'--'. basename($_FILES["profilepic"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                
                if (!is_dir($target_dir)){
                    $_SESSION['profile_update_msg'] .= "<br> Path is not valid Directory.";
                    $_SESSION['profile_update_success'] = false;
                }
                if(!is_writable($target_dir)){
                    $_SESSION['profile_update_msg'] .= "<br> Directory is not writable, check folder permissions";
                    $_SESSION['profile_update_success'] = false;
                }
            

                if ($move_file = move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)) {
                    $user_profile['ProfilePic'] = $target_file;
                } else {
                    $_SESSION['profile_update_msg'] .= "<br> Sorry, there was an error uploading your file";
                    $_SESSION['profile_update_success'] = false;
                }
            }
            
            $sql = "UPDATE users SET Username = '".$user_profile['Username']."' WHERE Username= '".$USER['Username']."'";
            $result = mysqli_query($db,$sql);
            if(!$result){
                $_SESSION[$USER_SESSION_KEY] = $result;
                $_SESSION['profile_update_msg'] .= "<br> Issue updating user table.";
                $_SESSION['profile_update_success'] = false;
            }

            if($has_profile){
                $sql = "UPDATE userprofiles SET Username = '".$user_profile['Username']."', Bio = '".($user_profile['Bio'] ?? ' ')."',  ProfilePic = '".($user_profile['ProfilePic'] ?? '')."' WHERE UserProfileID= '".$user_profile['UserProfileID']."'";
                $result = mysqli_query($db,$sql);
                
                if(!$result){
                    $_SESSION['profile_update_msg'] .= "<br> Issue updating userprofiles table. ". $sql;
                    $_SESSION['profile_update_success'] = false;
                }
            }else {
                $sql = "INSERT INTO userprofiles (Username, Bio, ProfilePic) VALUES('".$user_profile['Username']."', '".$user_profile['Bio']."', '".$user_profile['ProfilePic']."')";
                $result = mysqli_query($db,$sql);
                if(!$result){
                    $_SESSION['profile_update_msg'] .= "<br> Issue inserting into userprofiles table.";
                    $_SESSION['profile_update_success'] = false;
                }
            }


            if($_SESSION['profile_update_success'] === true){
                header("location:".$ROUTES['profile']);
                die();
            }
             
        } else {
            $_SESSION['profile_update_msg'] .= "<br> Username cannot be empty.";
            $_SESSION['profile_update_success'] = false;
        }
        
    }
    $_SESSION['profile_update_msg'] = trim($_SESSION['profile_update_msg'], '<br>');
    


    $show_edit_view = !empty($_GET['action']) && $_GET['action'] == 'edit' ;
    if(empty($user_profile['ProfilePic'])){
        $user_profile['ProfilePic'] = 'https://via.placeholder.com/150'; 
    }
?>

<?php  include("../php-inc/header.php"); ?>
<body>
    <!-- NAV -->
<?php include_once('../php-inc/nav.php'); ?>

    <div class="page-header header-filter" data-parallax="true" style="transform: translate3d(0px, 66.6667px, 0px);"></div>

    <div class="main main-raised">
		<div class="profile-content">
            <div class="container">
                <?php if(!$show_edit_view): ?>
                <div class="row">
	                <div class="col-md-12 ml-auto mr-auto">
        	           <div class="profile">
                        <div class="profile-tabs" style="position: absolute; right: 0;">
                            <ul class="nav nav-pills nav-pills-icons justify-content-center" role="tablist">
                                
                                <li class="nav-item">
                                    
                                    <a class="nav-link" href="<?=$_SERVER['PHP_SELF']?>?action=edit"><i class="fas fa-cog" aria-hidden="true"></i> Edit Profile </a>
                                    
                                </li>
                                
                            </ul>
                            </div>
	                        <div class="avatar">
	                            <img src="<?=$user_profile['ProfilePic']?>" alt="<?=$USER['Username']?>'s Profile Picture" class="img-raised rounded-circle img-fluid">
	                        </div>
	                        <div class="name">
	                            <h3 class="title"><?=$USER['Username']?></h3>
	                        </div>
	                    </div>
    	            </div>
                </div>
                <div class="description text-center">
                    <div><h6>BIO:</h6> <?=$user_profile['Bio'] ?? "**Bio is empty.**"?></div>
                </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-md-12 ml-auto mr-auto">
                            <div class="profile">
                                <div class="avatar">
                                    <img src="<?=$user_profile['ProfilePic']?>" alt="<?=$USER['Username']?>'s Profile Picture" class="img-raised rounded-circle img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="POST" class="my-login-validation" novalidate="" enctype="multipart/form-data">
                        

                    <?php if($show_edit_view): ?>
                        <?php if($_SESSION['profile_update_success'] === false):?>
                            <div class="alert alert-danger alert-dismissible fade show"  role="alert">
                                <?=$_SESSION['profile_update_msg']?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    <?php endif ?>

                        <div class="profile-username">
                            <div class="form-group mb-4">
                                <label for="username">Username</label>
                                <input id="username" type="text" class="form-control" name="username" required value="<?=$USER['Username']?>">
                                <div class="invalid-feedback">
                                    Your username is invalid
                                </div>
                            </div>
                        </div>

                        <div class="profile-bio">

                            <div class="form-group mb-4">
                                <label for="profilebio">Profile Bio</label>
                                <textarea class="form-control" id="profilebio" rows="3" name="bio"><?=$user_profile['Bio']?? ''?></textarea>
                                <div class="invalid-feedback">
                                    Your Profile Bio is invalid.
                                </div>
                            </div>

                        </div>

                        <div class="profile-pic">
                            <div class="form-group mb-4">
                                <label for="profilepic">Upload New Profile Pic</label>
                                <input type="file" name="profilepic" class="form-control-file" id="profilepic">
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Save Profile Changes" name="submit">
                    </form>
				<?php endif; ?>
            </div>
        </div>
	</div>
    
    
    


    
<?php  include("../php-inc/footer.php"); ?>
