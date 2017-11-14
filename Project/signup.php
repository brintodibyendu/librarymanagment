<?php 
session_start();
include('regfunc.php');
?>
<html>
<head>
<script>
function TeachStu()
{
	if(document.getElementById('teacher').checked){
		document.getElementById('ifteacher').style.display='block';
		document.getElementById('ifstudent').style.display='none';
	}
	else if(document.getElementById('student').checked){
		document.getElementById('ifstudent').style.display='block';
		document.getElementById('ifteacher').style.display='none';
	}
}
</script>
</head>
<body>
<center>
<h2>USER REGISTRATION</h2>
<form method="POST" action="signup.php">
<?php include('errors.php'); ?>
<input type="text" name="id" placeholder="Enter Your ID" value="<?php echo $id;?>"></br></br>
<input type="text" name="username" placeholder="Enter Your Name" value="<?php echo $username;?>"/></br></br>
<input type="password" name="password" placeholder="Enter Your Password"/></br></br>
<input type="email" name="email" placeholder="Enter Your mail" value="<?php echo $email;?>"/></br></br>
<input type="text" name="nationality" placeholder="Enter Your nationality" value="<?php echo $nationality;?>"/></br></br>
<input type="radio" name="gender" value="MALE" />MALE</br>
<input type="radio" name="gender" value="FEMALE"/>FEMALE</br></br>
<input type="number" name="age" placeholder="AGE" value="<?php echo $age;?>"/></br></br>
<input type="text" name="location" placeholder="Enter Your location" value="<?php echo $location;?>"/></br></br>
<p>Are You Teacher or Student?</p>
<input type="radio" name="type" id="teacher" onclick="javascript:TeachStu();" value="TEACHER" />TEACHER</br>
<input type="radio" name="type" id="student" onclick="javascript:TeachStu();"value="STUDENT"/>STUDENT</br></br>
<div id="ifteacher" style="display:none">
<input type="text" name="designation" placeholder="Enter Your Designation"/></br></br>
</div>
<div id="ifstudent" style="display:none">
<input type="text" name="level" placeholder="Enter Your level"/></br></br>
<input type="text" name="term" placeholder="Enter Your term"/></br></br>
</div>
<button type="submit" name= "register">SUBMIT</button></br></br>
<p>Already a member? <a href="login.php">Sign In</a></p>
</form>
</center>
</body>
</html>