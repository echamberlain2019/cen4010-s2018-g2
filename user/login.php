<?php
	include("../php-inc/config.php");
	include("../php-inc/config_routes.php");
	session_start();
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$count = 0;
		// username and password sent from form 
		if(!empty($_POST['username']) && !empty($_POST['password'])){

			$myusername = mysqli_real_escape_string($db,$_POST['username']);
			$mypassword = mysqli_real_escape_string($db,$_POST['password']); 
			
			$sql = "SELECT * FROM Users WHERE Username = '$myusername' and Password = '$mypassword'";
			$result = mysqli_query($db,$sql);
			if($result){
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				$count = mysqli_num_rows($result);
			}
		
			if($row && $count == 1) {
				unset($row['Password']);
				$_SESSION[$USER_SESSION_KEY] = $row;

				$_SESSION[$USER_ID_SESSION_KEY] = $row['user_id'] ?? 0;			

				header("location: ".$ROUTES['profile']);
				die();
			}else {
				$error = "Your Login Username or Password is invalid";
			}
		} else {
			$error = "The Username and Password cannot be empty.";
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
									<h4 class="card-title text-center">Member Login</h4>
									<form method="POST" class="my-login-validation" novalidate="">
										
										<?php include("../php-inc/form_display_errors.php");?>

										<div class="form-group mb-3">
											<label for="username">Username</label>
											<input id="username" type="text" class="form-control" maxlength="255" name="username" value="<?=$_GET['username']??''?>" required autofocus>
											<div class="invalid-feedback">
												Username is invalid
											</div>
										</div>

										<div class="form-group mb-3">
											<label for="password">Password
												<a href="forgot.html" class="float-right">
													Forgot Password?
												</a>
											</label>
											<input id="password" type="password" class="form-control" maxlength="255" name="password" required data-eye>
											<div class="invalid-feedback">
												Password is required
											</div>
										</div>
<!-- 
										<div class="form-group">
											<div class="custom-checkbox custom-control">
												<input type="checkbox" name="remember" id="remember" class="custom-control-input">
												<label for="remember" class="custom-control-label">Remember Me</label>
											</div>
										</div> -->

										<div class="form-group m-0">
											<button type="submit" class="btn btn-primary">
												Login
											</button>
										</div>
										<div class="mt-4 text-center">
											Don't have an account? <a href="<?=$ROUTES['register']?>">Create One</a>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php include('../php-inc/copyrights.php');?>
			</div>
		</div>
	</section>

<?php  include("../php-inc/footer.php"); ?>
