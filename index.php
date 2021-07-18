<!DOCTYPE html>
<html lang="en">
<head>
  <title>Covid Hut</title>
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
    <nav class="navbar navbar-fixed-top">
        <div class="navbar-header"><img src="logo.png" id ="chip"></a></div>
    </nav>

<div class="container-fluid bg-1 text-center" style="align-content: center; padding-left: 50px; padding-right: 50px; padding-bottom: 20px;">
  <label for="search">
    <i class="fa fa-search" aria-hidden="true"></i>
  </label>
  <input type="search" id="search" name="search">
</div>

<div class="container-fluid bg-1 text-center" style="padding-top: 0px; padding-bottom: 20px;">
  <div class="col-sm-5" style=" display:inline-block">
       <h2>Welcome to Covid Hut!</h2>
       <h3>Feel free to browse the newest posts, search for specific posts, or browse our Covid Count and Testing Sites pages!</h3>
  </div>

  <div class="col-sm-5" style="padding-left: 100px;">
    <h2>Current Pandemic Statistics:</h2>
    <h3>Covid Cases: </h3>
    <h3>Vaccination Count:</h3>
  </div>
</div>

<nav class="navbar navbar-fixed-top">
  <a href="#">Covid Cases Count</a>
  <a href="#">Covid Testing Sites</a>
  <a href="#">Login</a>
  <a href="#">Profile</a>
  <a href="#">Post</a>
  <a href="#">About</a>
</nav>

<div class="container">
	<div class="row">
		<div class="Carousel" data-items="1,3,5,6" data-slide="1" id="Carousel"  data-interval="1000">
            <div class="Carousel-inner">
                <div class="item">
                    <div class="post">
                        <p class="title">Multi Item Carousel</p>
                        <p></p>
                    </div>
                </div>
                <div class="item">
                    <div class="post">
                        <p class="title">Multi Item Carousel</p>
                        <p></p>
                    </div>
                </div>
                <div class="item">
                    <div class="post">
                        <p class="title">Multi Item Carousel</p>
                        <p></p>
                    </div>
                </div>
                <div class="item">
                    <div class="post">
                        <p class="title">Multi Item Carousel</p>
                        <p></p>
                    </div>
                </div>
                <div class="item">
                    <div class="post">
                        <p class="title">Multi Item Carousel</p>
                        <p></p>
                    </div>
                </div>
                <div class="item">
                    <div class="post">
                        <p class="title">Multi Item Caurosel</p>
                        <p></p>
                    </div>
                </div>
                <div class="item">
                    <div class="post">
                        <p class="title">Multi Item Carousel</p>
                        <p></p>
                    </div>
                </div>
                <div class="item">
                    <div class="post">
                        <p class="title">Multi Item Carousel</p>
                        <p></p>
                    </div>
                </div>
               
            </div>
            <button class="btn btn-primary left"><</button>
            <button class="btn btn-primary right">></button>
        </div>
	</div>

<div class="container-fluid bg-1 text-center">
  <div class="col-sm-5">
     <h2>Trending Posts</h2>
  </div>

  <div class="col-sm-5">
      <h2>Vaccine Sites</h2>
  </div>
</div>

</body>
</html>