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
<h3>USER LOGIN</h3>
<form method="POST">
<?php include('errors.php'); ?>
<input TYPE="text" name="id" placeholder="Enter Your ID"/></br></br>
<input type="password" name="password" placeholder="Enter Your Password"/></br></br>
<button type="submit" name="login">LOG IN</button></br>
<p>Not a member yet? <a href="signup.php">Sign Up</a></p>
</form>
<button type="submit" id="showbook">SHOW BOOKS</button></br></br>
<p><a href="liblogin.php">I AM LIBRARIAN</a></p>
</div>
<script>
var btn = document.getElementById('showbook');
btn.addEventListener('click', function() {
  document.location.href = 'book.php';
});
</script>
</body>
</html>