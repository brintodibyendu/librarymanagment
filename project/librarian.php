<?php
session_start();
    $bid="";
	$bname="";
	$language="";
	$edition="";
	$copy="";
	$genre="";
	$libid="";
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
$errors=array();
if(!isset($_SESSION['libid'])){
	$_SESSION['msg']="You must login first";
	header('LOCATION:liblogin.php');
}
if(isset($_GET['logout'])){
	session_destroy();
	unset($_SESSION['libid']);
	unset($_SESSION['genre']);
	header("LOCATION:liblogin.php");
}
if(isset($_POST['report']))
{
	header('LOCATION:userreport.php');
}

?>
<html>
<head>
<title> welcome <?php echo $_SESSION['libid'];?> </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
body {
  padding: 1em;
  font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 15px;
  // font-size: 1vw;
  background-color: #f9f9f9;
}
h2
{
	color: #fff;
	font-size: 40px;
}
h1
{
	color: #04AEC5;
	font-size: 20px;
}
h3
{
	color: #0F6CC9;
	font-size: 20px;
}
.container {
  max-width: 38em;
  margin: 0em auto;
  background-color: #fff;
  border-radius: @br * 1.4;
  box-shadow: 0px 3px 10px -2px rgba(0,0,0,0.2);
}
.sidenav {
      background-color: #f1f1f1;
	margin: 0em auto;
    }
	
.hero-image {
  background-image: url("images/blue.png");
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
  color: black;
}
</style>
</head>
<body>
<center>
<div class="hero-image">
  <div class="hero-text">
<h2>WELCOME <?php echo $_SESSION['libid'];?></h2>
  </div>
</div>
</br></br>
</center>
<?php if(isset($_SESSION['success'])): ?>
<h4> <?php 
unset($_SESSION['success']);
?></h4>


<?php endif ?>
<?php if(isset($_SESSION["libid"])): ?>
<?php endif ?>

<form method="post" action="librarian.php">
<div class="container-fluid">
<div class="row content">
    <div class="col-sm-3 sidenav">
      <ul class="nav nav-pills nav-stacked">
        <li><a href="bleh.php">Home</a></li>
        <li><a href="book_manage.php">Books Management</a></li>
        <li><a href="borrow_confirm.php">Borrow Requests</a></li>
        <li><a href="events.php">Events Management</a></li></br>
		<li><button type="submit" class="btn btn-success" name="report">CREATE REPORT</button></li></br></br>
		<a href="liblogin.php?logout='1'" class="btn btn-danger navbar-btn" role="button">Log Out</a>
		</ul>
</div>
<div class="container">
<div class="row content">
    <div class="col-sm-4 ">
	<img src="images/user.png" class="img-circle" alt="Cinque Terre" width="100" height="100"> 
	</div>
	<div class="col-sm-8 sidenav">
<?php
$libid=$_SESSION['libid'];
$conn1=oci_connect('BRINTO','tiger','localhost/orcl');
$query1="SELECT * FROM LIBUSER WHERE LIBID='$libid'";
$result1=oci_parse($conn1,$query1);
oci_execute($result1);
while($row=oci_fetch_array($result1)){
	echo"
	<h3>NAME   : {$row['USERNAME']} </h3>
	<h3>LIB ID:{$row['LIBID']}</h3>
	<h3>GENRE  : {$row['GENRE']}</h3>
	<h3>EMAIL  : {$row['EMAIL']}</h3>
	";
	}
?>
	</div>
	</br></br>
	</div>
	</div>
	</div>
	</div>
	</form>
	</body>
	</html>