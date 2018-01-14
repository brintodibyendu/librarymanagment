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
if(isset($_POST['addbook']))
{
	header("LOCATION:addbook.php");
}
if(isset($_POST['updatebook']))
{
	$bid=$_POST['bid'];
	$bname=$_POST['bname'];
	$language=$_POST['blang'];
	$edition=$_POST['bedition'];
	$copy=$_POST['bcopy'];
	$genre=$_SESSION['genre'];
	$libid=$_SESSION['libid'];
	if(empty($bid))
	{
		array_push($errors,"book id is empty");
	}
	if(empty($bname))
	{
		array_push($errors,"book name is empty");
	}
	if(empty($language))
	{
		array_push($errors,"language is empty");
	}
	if(empty($edition))
	{
		array_push($errors,"edition is empty");
	}
	if(empty($copy))
	{
		array_push($errors,"copy is empty");
	}
	if(count($errors)==0)
	{
	    $query2="UPDATE BOOKS SET BOOK_NAME='$bname',LANGUAGE='$language',EDITION='$edition',COPY='$copy' WHERE BOOK_ID='$bid'";
		$result2=oci_parse($conn,$query2);
		oci_execute($result2,OCI_DEFAULT);
	}
}
if(isset($_POST['deletebook']))
{
	$bid=$_POST['bid'];
	$bname=$_POST['bname'];
	$language=$_POST['blang'];
	$edition=$_POST['bedition'];
	$copy=$_POST['bcopy'];
	$genre=$_SESSION['genre'];
	$libid=$_SESSION['libid'];
	if(empty($bid))
	{
		array_push($errors,"book id is empty");
	}
	if(empty($bname))
	{
		array_push($errors,"book name is empty");
	}
	if(empty($language))
	{
		array_push($errors,"language is empty");
	}
	if(empty($edition))
	{
		array_push($errors,"edition is empty");
	}
	if(empty($copy))
	{
		array_push($errors,"copy is empty");
	}
	if(count($errors)==0)
	{
	    $query2="DELETE FROM BOOKS WHERE BOOK_ID='$bid'";
		$result2=oci_parse($conn,$query2);
		oci_execute($result2,OCI_DEFAULT);
	}
}
?>

<html>
<head>
<title> Book Managing </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
body {
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
  max-width: 50em;
  
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
<h2>MANAGEMENT OF BOOKS</h2>
  </div>
</div>
</br></br>
</center>

<div class="container-fluid">
<div class="row content">
    <div class="col-sm-3 sidenav">
      <ul class="nav nav-pills nav-stacked">
        <li><a href="bleh.php">Home</a></li>
        <li class="active"><a href="book_manage.php">Books management</a></li>
        <li><a href="borrow_confirm.php">Borrow requests</a></li>
        <li><a href="events.php">Events Management</a></li>
		<li><a href="librarian.php">Back </a></li></br>
		<li><button type="submit" class="btn btn-success" name="report">CREATE REPORT</button></li></br></br>
		<a href="liblogin.php?logout='1'" class="btn btn-danger navbar-btn" role="button">Log Out</a>
		</ul>
</div>




<form method="POST" action="book_manage.php">
<div class="col-sm-9">
<div class="container">
<table id="book" class="table table-hover table-dark" border="2">
<thead>
<tr class="danger">
<th scope="col"  style="display:none">BOOK_ID</th>
<th scope="col">BOOK_NAME</th>
<th scope="col">LANGUAGE</th>
<th scope="col">EDITION</th>
<th scope="col">COPY</th>
<th scope="col">SELECT</th>
</tr>
</thead>
<tbody>
<?php 
$gen=$_SESSION['genre'];
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
$query="SELECT BOOK_ID,BOOK_NAME,LANGUAGE,EDITION,COPY FROM BOOKS B WHERE LOWER(B.GENRE)=ANY(SELECT LOWER(GENRE) FROM LIBUSER L WHERE LOWER(L.GENRE)=LOWER('$gen'))";
$result=oci_parse($conn,$query);
oci_execute($result);
while($row=oci_fetch_array($result)){
	echo
	"<tr class='select'>
	<td style='display:none'>{$row['BOOK_ID']}</td>
	<td>{$row['BOOK_NAME']}</td>
	<td>{$row['LANGUAGE']}</td>
	<td>{$row['EDITION']}</td>
	<td>{$row['COPY']}</td>
	<td><input type='radio' name='sss'></td>
	</tr>\n";
} 
?></tbody>
</table></br>
<input type="text" name="bid" id="bid" style="display:none"/>
<p>Book Name</p>
<input type="text" name="bname" id="bname"/>
<p>Book Language</p>
<input type="text" name="blang" id="blang"/>
<p>Edition</p>
<input type="text" name="bedition" id="bedition"/>
<p>Number of Copies</p>
<input type="text" name="bcopy" id="bcopy"/>
</br>
<button type="submit" class="btn btn-primary" name="addbook" id="addbook">ADD</button>
<button type="submit" class="btn btn-success" name="updatebook" id="updatebook">UPDATE</button>
<button type="submit" class="btn btn-danger" name="deletebook" id="deletebook">DELETE</button></br>
</center>
</div>
</div>
</form>
</div>
</div>
<script>
function selectRow()
{
	var radios=document.getElementsByName("sss");
	for(var k=0;k<radios.length;k++)
	{
		radios[k].onclick=function(){
var tab=document.getElementById("book"),rindex;
for(var i=1;i<tab.rows.length;i++)
{
	tab.rows[i].onclick=function()
	{
		rindex=this.rowIndex;
		console.log(rindex);
		document.getElementById("bid").value=this.cells[0].innerHTML;
		document.getElementById("bname").value=this.cells[1].innerHTML;
		document.getElementById("blang").value=this.cells[2].innerHTML;
		document.getElementById("bedition").value=this.cells[3].innerHTML;
		document.getElementById("bcopy").value=this.cells[4].innerHTML;
	}
}			
		};
	}
}
selectRow();
</script>
</body>
</html>