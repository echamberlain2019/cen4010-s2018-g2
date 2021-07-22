<?php
   include("../php-inc/config.php");
   include("../php-inc/config_routes.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {

		var_dump($_POST);
      // username and password sent from form 
	  	if(!empty(trim($_POST["username"])) && !empty(trim($_POST["password"])) ){

			$myusername = mysqli_real_escape_string($db,$_POST['username']);
			$mypassword = mysqli_real_escape_string($db,$_POST['password']); 
				
			$sql = "SELECT * FROM users WHERE username = '$myusername'";
			$result = mysqli_query($db,$sql);
			if($result){
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				$count = mysqli_num_rows($result);
				
				// If result matched $myusername and $mypassword, table row must be 1 row
				if($count != 1) {
					
					// Validate password
					if(empty(trim($_POST["password"]))){
						$error = "Please enter a password.";     
					} elseif(strlen(trim($_POST["password"])) < 6){
						$error = "Password must have atleast 6 characters.";
					} else{
						$password = trim($_POST["password"]);
					}

					$sql = "INSERT INTO users (Username, Password) VALUES ('$myusername', '$mypassword')";
					$result = mysqli_query($db,$sql);
					if($result){
						header("location:" . $ROUTES['login'].'?username='.$myusername.'&r=');
						die();
					}else {
						$error = "User not insearted.";
					}
				}else {
					$error = "Username exist.";
				}
			} else {
				$error = "Username exist.";
			}
		} else {
			$error = "Username or Password are empty.";
		}
   }
?>
<?php  include("../php-inc/header.php"); ?>
<body class="my-login-page gradient-custom">
<section class="vh-100">
	<div class="container h-100 d-flex  justify-content-center align-items-center">
		<div class="row w-100">
			<div class="card-wrapper ">
				
				<div class="card fat">
					<div class="card-body">
						<div class="row flex-row d-flex  justify-content-center align-items-center">
							<div class="col ">
								<?php include_once('../php-inc/login-brand.php'); ?>
							</div>
							<div class="col ">
								<h4 class="card-title text-center">Register</h4>
								<form method="POST" class="my-login-validation" novalidate="">

									<?php include("../php-inc/form_display_errors.php");?>
									
									<div class="form-group mb-3">
										<label for="username">Username</label>
										<input id="username" type="text" class="form-control" name="username" required>
										<div class="invalid-feedback">
											Your username is invalid
										</div>
									</div>

									<div class="form-group mb-3">
										<label for="password">Password</label>
										<input id="password" type="password" class="form-control" name="password" required data-eye>
										<div class="invalid-feedback">
											Password is required
										</div>
									</div>

									<!-- <div class="form-group">
										<label for="password_confirm">Confirm Password</label>
										<input id="password_confirm" type="password" class="form-control" name="password_confirm" required data-eye>
										<div class="invalid-feedback">
											Password comfirm is required
										</div>
									</div> -->

									<!-- <div class="form-group">
										<div class="custom-checkbox custom-control">
											<input type="checkbox" name="agree" id="agree" class="custom-control-input" required="">
											<label for="agree" class="custom-control-label">I agree to the <a href="#">Terms and Conditions</a></label>
											<div class="invalid-feedback">
												You must agree with our Terms and Conditions
											</div>
										</div>
									</div> -->

									<div class="form-group m-0">
										<button type="submit" class="btn btn-primary">
											Register
										</button>
									</div>
									<div class="mt-4 text-center">
										Already have an account? <a href="<?=$ROUTES['login']?>">Login</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<?php include('../php-inc/copyrights.php');?>
			</div>
		</div>
	</div>
</section>

<?php  include("../php-inc/footer.php"); ?>
	