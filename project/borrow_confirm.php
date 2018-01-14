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
if(isset($_POST['confirm']))
{
	$id=$_POST['b'];
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$confirm=$_POST['id2'];
	$copy="";
    if($confirm=="NO")
	{
		$stid = oci_parse($conn, 'begin CONFIRM_NO(:p); end;');
		oci_bind_by_name($stid, ':p', $id);
		oci_execute($stid);
	}
	else if($confirm=="YES" && !empty($sdate) && !empty($edate))
	{
		$query2="UPDATE BORROW SET START_DATE=TO_DATE('$sdate','YYYY-MM-DD'),FINISH_DATE=TO_DATE('$edate','YYYY-MM-DD'),STATUS='$confirm' WHERE BORROW_ID='$id'";
		$result2=oci_parse($conn,$query2);
		oci_execute($result2);
	}
	else if(empty($sdate) || empty($edate))
	{
		array_push($errors,"Please select date");
	}
}
?>
<html>
<head>
<title> Borrow Handle </title>
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
  
  background-color: #fff;
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
<h2> Borrow Requests </h2>
  </div>
</div>
</br></br>
</center>
<form method="POST" action="borrow_confirm.php">
<div class="container-fluid">
<div class="row content">
    <div class="col-sm-3 sidenav">
      <ul class="nav nav-pills nav-stacked">
        <li><a href="bleh.php">Home</a></li>
        <li><a href="book_manage.php">Books Management</a></li>
        <li class="active"><a href="borrow_confirm.php">Borrow Requests</a></li>
        <li><a href="events.php">Events Management</a></li>
		<li><a href="librarian.php">Back</a></li></br>
		
		<li><button type="submit" class="btn btn-success" name="report">CREATE REPORT</button></li></br></br>
		<a href="liblogin.php?logout='1'" class="btn btn-danger navbar-btn" role="button">Log Out</a>
		</ul>
</div>

<div class="col-sm-9">
<table border="2" class="table" id="issue">
<tr class="success">
<th>BORROW ID</th>
<th>USER ID</th>
<th>BOOK ID</th>
</tr>
<?php
$libid=$_SESSION['libid'];
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
$query="SELECT BORROW_ID,USER_ID,BOOK_ID FROM BORROW WHERE LIBID='$libid' AND STATUS IS NULL";
$result=oci_parse($conn,$query);
oci_execute($result);
while($row=oci_fetch_array($result))
{
	echo "<tr><td>{$row['BORROW_ID']}</td>
	<td>{$row['USER_ID']}</td>
	<td>{$row['BOOK_ID']}</td>
	</tr>\n";
}
?>
</br>
</table></br>
<input type="text" id="b" name="b" placeholder="BORROW ID"/></br>
<label>Start Date:</label></br>
<input type="date" name="sdate" id="sdate"/></br>
<label>Finish Date:</label></br>
<input type="date" name="edate"></br>
<label>Confirm Borrow?</label></br>
<select id="c">
<option value="YES">YES</option>
<option value="NO">NO</option>
</select></br></br>
<input type="text" id="id" name="id2"/>
<button type="submit" class="btn btn-success" name="confirm" id="confirm">CONFIRM</button></br></br>
</form>
</div>
</div>
</div>
<script>
var tab1=document.getElementById("issue"),rindex1;
for(var i=1;i<tab1.rows.length;i++)
{
	tab1.rows[i].onclick=function()
	{
		rindex1=this.rowIndex;
		console.log(rindex1);
		document.getElementById("b").value=this.cells[0].innerHTML;
	}
}
var e = document.getElementById("c");
		e.onclick=function()
		{
		var strUser = e.options[e.selectedIndex].value;
		document.getElementById("id").value=strUser;	
		}
</script>
</body>
</html>