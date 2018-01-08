<?php 
session_start();
include('regfunc.php');
?>
<html>
<head></head>
<body>
<center>
<h2>LIBRARIAN REGISTRATION</h2>
<form method="POST" action="libsignup.php">
<?php include('errors.php'); ?>
<input type="text" name="id" placeholder="Enter Your ID" /></br></br>
<input type="text" name="username" placeholder="Enter Your Name" /></br></br>
<input type="password" name="password" placeholder="Enter Your Password"/></br></br>
<input type="email" name="email" placeholder="Enter Your mail"/></br></br>
<select id="g">
<option>CSE</option><option>EEE</option><option>ME</option><option>CE</option><option>CHE</option>
<option>IPE</option><option>WRE</option><option>URP</option><option>ARCHITECTURE</option><option>NAME</option>
</select>
<input type="text" id="genre" name="genre" style="display:none"/>
<button type="submit" name="libregister">Sign Up</button></br>
<a href="liblogin.php">REGISTERED?</a></p>
</form>
</center>
<script>
var e = document.getElementById("g");
e.onclick=function()
{
		var strUser = e.options[e.selectedIndex].text;
document.getElementById("genre").value=strUser;	
		}
</script>
</body>
</html>