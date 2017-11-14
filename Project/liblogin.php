<?php
session_start();
include('regfunc.php');
?>
<html>
<head>
<link rel="stylesheet" href="mystyle.css">
</head>
<body>
<div class="loginsec">
<img src="images/4.png" class="logpic">
<h3>LIBRARIAN LOGIN</h3>
<form method="POST">
<p><?php include('errors.php'); ?></p>
<input TYPE="text" name="id" placeholder="Enter Your ID"/></br></br>
<input type="password" name="password" placeholder="Enter Your Password"/></br></br>
<button type="submit" name="liblogin">Log In</button>
<p>Not REGISTERED yet? <a href="libsignup.php">Sign Up</a></p>
</form>
<a href="login.php">I AM USER</a></p>
</div>
</body>
</html>