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
           $result= [];
           while ($row = $query->fetch_assoc()) {    $result[]= $row; }
            // var_dump($result);
          return $result;
        }
        return [];
    }

    function post_comments($PostID){
        global $db;
        $query = $db->query("SELECT  * FROM Comments WHERE PostID = '".$PostID."' ");
     
        if($query){
            $result= [];
           while ($row = $query->fetch_assoc()) {    $result[]= $row; }
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
  
  
 
    var_dump($_POST);
    if(isset($_POST['submit']) && !empty($_POST['content'])){
        if(add_post($USER['Username'],$_POST['content'])){
            header("Location: index.php");
        }
    }

    if(isset($_POST['like']) && !empty($_POST['PostID'])){
        if(add_like_to_post($_POST['PostID'])){
            header("Location: index.php");
        }
    }

    if(isset($_POST['comment']) && !empty($_POST['PostID']) && !empty($_POST['comment_content'])){
        if(add_comment_to_post($USER['Username'], $_POST['PostID'], $_POST['comment_content'])){
            header("Location: index.php");
        }
    }
?>
