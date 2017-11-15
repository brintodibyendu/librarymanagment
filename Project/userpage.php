<?php
session_start();
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
$errors=array();
if(!isset($_SESSION['id'])){
	$_SESSION['msg']="You must login first";
	header('LOCATION:login.php');
}
if(isset($_GET['logout'])){
	session_destroy();
	unset($_SESSION['id']);
	header("LOCATION:login.php");
}
if(isset($_POST['show']))
{
	header('LOCATION:book.php');
}
if(isset($_POST['return']))
{
	$id=$_POST['r'];
	$query3="SELECT B.COPY COPY,B.BOOK_ID BOOK_ID FROM BOOKS B WHERE B.BOOK_ID=(SELECT C.BOOK_ID FROM BORROW C WHERE BORROW_ID='$id')";
	$result3=oci_parse($conn,$query3);
	oci_execute($result3);
	while($row=oci_fetch_array($result3))
	{
		$copy=$row['COPY'];
		$id2=$row['BOOK_ID'];
	}
	$query4="UPDATE BOOKS SET COPY='$copy'+1 WHERE BOOK_ID='$id2'";
	$result4=oci_parse($conn,$query4);
	oci_execute($result4);
	$query5="DELETE FROM BORROW WHERE BORROW_ID='$id'";
	$result5=oci_parse($conn,$query5);
	oci_execute($result5);
}
if(isset($_POST['addpaper']))
{
	$pname=$_POST['papername'];
	$pdes=$_POST['paperdes'];
	$pdate=$_POST['paperdate'];
	$uid=$_SESSION['id'];
	if(empty($pname))
	{
		array_push($errors,"paper name is empty");
	}
	if(empty($pdes))
	{
		array_push($errors,"paper description is empty");
	}
	if(empty($pdate))
	{
		array_push($errors,"paper date is empty");
	}
	if(count($errors)==0)
	{
	    $query2="INSERT INTO PAPER(PAPER_NAME,PAPER_DES,PAPER_DATE) VALUES('$pname','$pdes',TO_DATE('$pdate','YYYY-MM-DD'))";
		$result2=oci_parse($conn,$query2);
		oci_execute($result2,OCI_DEFAULT);
		 $query3="INSERT INTO RESEARCH(USER_ID) VALUES('$uid')";
		$result3=oci_parse($conn,$query3);
		oci_execute($result3,OCI_DEFAULT);
	}
}
if(isset($_POST['updatepaper']))
{
	$pid=$_POST['paperid'];
	$pname=$_POST['papername'];
	$pdes=$_POST['paperdes'];
	$pdate=$_POST['paperdate'];
	if(empty($pname))
	{
		array_push($errors,"paper name is empty");
	}
	if(empty($pdes))
	{
		array_push($errors,"paper description is empty");
	}
	if(empty($pdate))
	{
		array_push($errors,"paper date is empty");
	}
	if(count($errors)==0)
	{
	    $query2="UPDATE PAPER SET PAPER_NAME='$pname',PAPER_DES='$pdes',PAPER_DATE=TO_DATE('$pdate','YYYY-MM-DD') WHERE PAPER_ID='$pid'";
		$result2=oci_parse($conn,$query2);
		oci_execute($result2,OCI_DEFAULT);
	}
}
?>
<html>
<head></head>
<body>
<center>
<h2>Home Page</h2>
<?php if(isset($_SESSION['success'])): ?>
<h3> <?php 
echo $_SESSION['success'];
unset($_SESSION['success']);
?></h3>
<?php endif ?>
<?php if(isset($_SESSION["id"])): ?>
<p> Welcome <?php echo $_SESSION['id'];?></p>
<?php endif ?>
<form method="post" action="userpage.php">
<button type="submit" name="show">SHOW BOOK</button>
</br></br>
<table border="2">
<tr><th>WISH LIST</th></tr>
<?php
$id=$_SESSION['id'];
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
$query="select b.book_name from books b where b.book_id=any(select w.book_id from wishlist w where w.user_id='$id')";
$result=oci_parse($conn,$query);
oci_execute($result);
while($row=oci_fetch_array($result)){
	echo
	"<tr>
	<td>{$row['BOOK_NAME']}</td></tr>\n";
}
?>
</table></br></br>
<table border="2" id="borrow">
<tr><th>BOOK NAME</th><th>START DATE</th><th>FINISH DATE</th></tr>
<?php
$id=$_SESSION['id'];
$conn1=oci_connect('BRINTO','tiger','localhost/orcl');
$query1="SELECT C.BORROW_ID,B.BOOK_NAME,C.START_DATE,C.FINISH_DATE FROM BOOKS B JOIN BORROW C ON (B.BOOK_ID=C.BOOK_ID) WHERE C.USER_ID='$id' AND C.STATUS='YES'";
$result1=oci_parse($conn1,$query1);
oci_execute($result1);
while($row=oci_fetch_array($result1)){
	echo
	"<tr>
	<td style='display:none'>{$row['BORROW_ID']}</td>
	<td>{$row['BOOK_NAME']}</td>
	<td>{$row['START_DATE']}</td>
	<td>{$row['FINISH_DATE']}</td></tr>
	\n";
}
?>
</table></br></br>
<input type="text" id="r" name="r"/>
<button type="submit" name="return" id="return">RETURN</button></br></br>
<?php
$id=$_SESSION['id'];
if($_SESSION['type']=="TEACHER")
{
echo "<table border='2' id='paper'><tr><th style='display:none'>PAPER ID</th><th>PAPER NAME</th><th>DESCRIPTION</th><th>DATE</th></tr>";
$conn1=oci_connect('BRINTO','tiger','localhost/orcl');
$query1="SELECT * FROM PAPER WHERE PAPER_ID=ANY(SELECT PAPER_ID FROM RESEARCH WHERE USER_ID='$id')";
$result1=oci_parse($conn1,$query1);
oci_execute($result1);
while($row=oci_fetch_array($result1)){
	$newDate = date("Y-m-d", strtotime($row['PAPER_DATE']));
	echo "<tr><td style='display:none'>{$row['PAPER_ID']}</td><td>{$row['PAPER_NAME']}</td><td>{$row['PAPER_DES']}</td><td>{$newDate}</td></tr>\n";
}
echo "</table></br>";
echo"<input type='text' name='paperid' id='paperid' style='display:none'/>
<input type='text' name='papername' id='papername' placeholder='enter paper name'/>
<input type='text' name='paperdes' id='paperdes' placeholder='enter paper description'/></br>
<input type='date' name='paperdate' id='paperdate' placeholder='enter paper date'/></br>";
echo "
<button type='submit' name='addpaper' id='addpaper'>ADD</button>
<button type='submit' name='updatepaper' id='updatepaper'>UPDATE</button>
<button type='submit' name='deletepaper' id='deletepaper'>DELETE</button></br>";
}
?>
</form>
<p><a href="userpage.php?logout='1'">Logout</a></p>
</br></br>
</center>
<script>
var tab=document.getElementById("borrow"),rindex;
for(var i=1;i<tab.rows.length;i++)
{
	tab.rows[i].onclick=function()
	{
		rindex=this.rowIndex;
		console.log(rindex);
		document.getElementById("r").value=this.cells[0].innerHTML;	
	}
}
var tab1=document.getElementById("paper"),rindex1;
for(var i=1;i<tab1.rows.length;i++)
{
	tab1.rows[i].onclick=function()
	{
		rindex1=this.rowIndex;
		console.log(rindex1);
		document.getElementById("paperid").value=this.cells[0].innerHTML;
		document.getElementById("papername").value=this.cells[1].innerHTML;	
		document.getElementById("paperdes").value=this.cells[2].innerHTML;	
		document.getElementById("paperdate").value=this.cells[3].innerHTML;	;	
	}
}
</script>
</body>
</html>