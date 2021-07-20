<?php
$conn = mysqli_connect("localhost","cen4010_su21_g02@localhost", "5qpmBFABZR") or die("could not connect");
mysqli_select_db($conn,"cen4010_su21_g02") or die("could not find db");
$output = '';
//collect
if(isset($_POST['search'])) {
	$searchq = $_POST['search'];
	$searchq = preg_replace("#[^0-9a-z]#i","",$searchq);
	
	$query = mysqli_query($conn, "SELECT * FROM Users WHERE Username LIKE '%$searchq%'");
	$count = mysqli_num_rows($query);
	if($count==0){
		$output = 'There was no search results';
	}else{
		while($row = mysqli_fetch_array($query)) {
			$username = $row['Username'];
			
			$message = "Users Found: ";
			$output .= '<div>'.$message.$username.'</div>';
		}
	}
}
?>

<html>
 <head>
  <title>Search</title>
 </head>
 <body>
   <h1> Search </h1>
 
 <form action="search.php" method="post">
	<input type="text" name="search" placeholder="Search for members..." />
	<input type="submit" value=">>" />
 </form>

<?php print("$output");?>
 
 </body>
</html>