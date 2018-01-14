<!DOCTYPE html>
<html>
<head>
<title>Welcome to Library</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
body, html {
    height: 100%;
    margin: 0;
}

.hero-image {
  background-image: url("images/h.jpg");
  height: 20%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}

.hero-text {
  text-align: center;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
}
.sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
</style>
</head>
<body>

<div class="hero-image">
  <div class="hero-text">
    <h1 style="font-size:20px">Central Library</h1>
    <h2 style="font-size:35px"> Welcome to Online Library System </h2>
  </div>
</div>


<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="">Home</a></li>
        <li><a href="#section2">About</a></li>
        <li><a href="view_events.php">Events</a></li>
        <li><a href="#section3">Administraton</a></li>
		<li><a href="#section3">Research papers</a></li>
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Favourite lists <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#section41">Teachers</a></li>
              <li><a href="#section42">Students</a></li>
            </ul>
          </li>
		 <li><a href="#section3">Resources</a></li>
		<li><a href="book.php">Show books</a></li>
	   </ul>
	   
	</div>
	<div class="col-sm-9 sidenav">
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>
	<div class="carousel-inner">
      <div class="item active">
        <img src="images/books.jpg" alt="Los Angeles" style="width:60%; height:0%;margin:auto;" >
      </div>

      <div class="item">
        <img src="images/1.jpg" alt="Chicago" style="width:60%; height:0%;margin:auto">
      </div>
    
      <div class="item">
        <img src="images/2.jpg" alt="New york" style="width:60%; height:0%;margin:auto">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
	</div>
	</div>
	
	
  </div>
  
	<div class="row content">
    <div class="col-sm-3">
	<p> Are you a member? </p>
    <a href="login.php" class="btn btn-danger navbar-btn" role="button">Log in</a>
	 </div>
	 <div class="col-sm-9">
	 <h1> Recent books </h1>
	 <a href="">Advanced Engineering blah blah</a>
	 <p> by Md Abul Kalam </p></br>
	 <a href="">Advanced Mathematics for Engineers</a>
	 <p> by Md Abdur Rahman </p>
	 </div>
	   
	   
</div>
	


</body>
</html>
<?php
include('footer.php');
?>