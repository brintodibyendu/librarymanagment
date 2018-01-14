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
if(isset($_POST['addevent']))
{
	$evname=$_POST['evname'];
	$evdate=$_POST['evdate'];
	$evdes=$_POST['evdes'];
	$libid=$_SESSION['libid'];
	if(empty($evname))
	{
		array_push($errors,"event name is empty");
	}
	if(empty($evdate))
	{
		array_push($errors,"event date is empty");
	}
	if(empty($evdes))
	{
		array_push($errors,"event description is empty");
	}
	if(count($errors)==0)
	{
	    $query2="INSERT INTO EVENTS(EVENT_NAME,EVENT_DATE,EVENT_DES,LIBID) VALUES('$evname',TO_DATE('$evdate','YYYY-MM-DD'),'$evdes','$libid')";
		$result2=oci_parse($conn,$query2);
		oci_execute($result2,OCI_DEFAULT);
	}
}
if(isset($_POST['updateevent']))
{
	$evid=$_POST['evid'];
	$evname=$_POST['evname'];
	$evdate=$_POST['evdate'];
	$evdes=$_POST['evdes'];
	$libid=$_SESSION['libid'];
	if(empty($evname))
	{
		array_push($errors,"event name is empty");
	}
	if(empty($evdate))
	{
		array_push($errors,"event date is empty");
	}
	if(empty($evdes))
	{
		array_push($errors,"event description is empty");
	}
	if(count($errors)==0)
	{
	    $query2="UPDATE EVENTS SET EVENT_NAME='$evname',EVENT_DATE=TO_DATE('$evdate','YYYY-MM-DD'),EVENT_DES='$evdes' WHERE EVENT_ID='$evid'";
		$result2=oci_parse($conn,$query2);
		oci_execute($result2,OCI_DEFAULT);
	}
}
if(isset($_POST['deleteevent']))
{
	$evid=$_POST['evid'];
	$evname=$_POST['evname'];
	$evdate=$_POST['evdate'];
	$evdes=$_POST['evdes'];
	$libid=$_SESSION['libid'];
	if(empty($evname))
	{
		array_push($errors,"event name is empty");
	}
	if(empty($evdate))
	{
		array_push($errors,"event date is empty");
	}
	if(empty($evdes))
	{
		array_push($errors,"event description is empty");
	}
	if(count($errors)==0)
	{
	    $query2="DELETE FROM EVENTS WHERE EVENT_ID='$evid'";
		$result2=oci_parse($conn,$query2);
		oci_execute($result2,OCI_DEFAULT);
	}
}?>
<html>
<head>
<title> Events </title>
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
  max-width: 50em;
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
<h2>Events Management</h2>
  </div>
</div>
</br></br>
</center>

<div class="container-fluid">
<div class="row content">
    <div class="col-sm-3 sidenav">
      <ul class="nav nav-pills nav-stacked">
        <li><a href="bleh.php">Home</a></li>
        <li><a href="book_manage.php">Books Management</a></li>
        <li><a href="borrow_confirm.php">Borrow Requests</a></li>
        <li class="active"><a href="events.php">Events Management</a></li>
		<li ><a href="librarian.php">Back</a></li></br>
		<li><button type="submit" class="btn btn-success" name="report">CREATE REPORT</button></li></br></br>
		<a href="liblogin.php?logout='1'" class="btn btn-danger navbar-btn" role="button">Log Out</a>
		</ul>
</div>
<form method="POST" action="events.php">
<div class="col-sm-9">
<div class="container">
<table id="event" class="table" border="2">
<tr class="danger"><th style="display:none"> EVENT ID  </th> <th>EVENT NAME  </th><th>EVENT DATE  </th><th>EVENT DESCRIPTION  </th></tr>
<?php
$libid=$_SESSION['libid'];
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
$query="SELECT * FROM EVENTS WHERE LIBID='$libid'";
$result=oci_parse($conn,$query);
oci_execute($result);
while($row=oci_fetch_array($result))
{
	$newDate = date("Y-m-d", strtotime($row['EVENT_DATE']));
	echo "<tr><td style='display:none'>{$row['EVENT_ID']}</td>
	<td>{$row['EVENT_NAME']}</td>
	<td>{$newDate}</td>
	<td>{$row['EVENT_DES']}</td>
	</tr>\n";
}
?>
</table></br>
<input type="text" name="evid" id="evid" style="display:none"/>
<input type="text" name="evname" id="evname"/><p> EVENT NAME </p>
<input type="date" name="evdate" id="evdate"/> <p> EVENT DATE </p>
<input type="text" name="evdes" id="evdes"/> <p> EVENT DESCRIPTION </p>
</br></br><button type="submit" name="addevent" class="btn btn-primary" id="addevent">ADD</button>
<button type="submit" name="updateevent" class="btn btn-success" id="updateevent">UPDATE</button>
<button type="submit" name="deleteevent" class="btn btn-danger" id="deleteevent">DELETE</button></br></br>
</form>
</div>
</div>
</div>
</div>
<script>
	var tab2=document.getElementById("event"),rindex2;
for(var i=1;i<tab2.rows.length;i++)
{
	tab2.rows[i].onclick=function()
	{
		rindex2=this.rowIndex;
		console.log(rindex2);
		document.getElementById("evid").value=this.cells[0].innerHTML;
		document.getElementById("evname").value=this.cells[1].innerHTML;
		document.getElementById("evdate").value=this.cells[2].innerHTML;
		document.getElementById("evdes").value=this.cells[3].innerHTML;
	}
}
</script>

</body>
</html>