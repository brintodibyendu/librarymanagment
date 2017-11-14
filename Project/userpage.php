<?php
session_start();
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
	$conn=oci_connect('BRINTO','tiger','localhost/orcl');
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
<button type="submit" name="return" id="return">RETURN</button>
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
</script>
</body>
</html>