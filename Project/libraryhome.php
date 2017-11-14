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
	unset($_SESSION['id']);
	header("LOCATION:liblogin.php");
}
if(isset($_POST['addbook']))
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
		$query1="SELECT * FROM BOOKS WHERE BOOK_ID='$bid'";
		$result1=oci_parse($conn,$query1);
		oci_execute($result1,OCI_DEFAULT);
		$resourse1=array();
		$numrows1=oci_fetch_all($result1,$resourse1,null,null,OCI_FETCHSTATEMENT_BY_ROW);
		if($numrows1==0)
		{
	    $query2="INSERT INTO BOOKS(BOOK_ID,BOOK_NAME,GENRE,LANGUAGE,EDITION,LIBID,COPY) VALUES('$bid','$bname','$genre','$language','$edition','$libid','$copy')";
		$result2=oci_parse($conn,$query2);
		oci_execute($result2,OCI_DEFAULT);
		}
	}
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
if(isset($_POST['confirm']))
{
	$id=$_POST['b'];
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$confirm=$_POST['id2'];
	$copy="";
    if($confirm=="NO")
	{
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
</head>
<body>
<?php
echo "{$_SESSION['libid']}</br>";
echo "{$_SESSION['genre']}</br>";
?>
<form method="POST" action="libraryhome.php">
<table id="book" border="2">
<tr>
<th>BOOK ID</th>
<th>BOOK_NAME</th>
<th>LANGUAGE</th>
<th>EDITION</th>
<th>COPY</th>
<th>WRITER</th>
</tr>
<?php 
$gen=$_SESSION['genre'];
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
$query="SELECT BOOK_ID,BOOK_NAME,LANGUAGE,EDITION,COPY FROM BOOKS B WHERE LOWER(B.GENRE)=ANY(SELECT LOWER(GENRE) FROM LIBUSER L WHERE LOWER(L.GENRE)=LOWER('$gen'))";
$result=oci_parse($conn,$query);
oci_execute($result);
while($row=oci_fetch_array($result)){
	echo
	"<tr class='select'>
	<td>{$row['BOOK_ID']}</td>
	<td>{$row['BOOK_NAME']}</td>
	<td>{$row['LANGUAGE']}</td>
	<td>{$row['EDITION']}</td>
	<td>{$row['COPY']}</td>
	<td><button type='submit' name='book'>SHOW</button></td>
	</tr>\n";
} 
?>
</table></br>
<input type="text" name="bid" id="bid"/>
<input type="text" name="bname" id="bname"/></br>
<input type="text" name="blang" id="blang"/>
<input type="text" name="bedition" id="bedition"/></br>
<input type="text" name="bcopy" id="bcopy"/></br></br>
<button type="submit" name="addbook" id="addbook">ADD</button>
<button type="submit" name="updatebook" id="updatebook">UPDATE</button>
<button type="submit" name="deletebook" id="deletebook">DELETE</button></br>
<table border="2" id="issue">
<tr>
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
<button type="submit" name="confirm" id="confirm">CONFIRM</button>
</form>
<p><a href="userpage.php?logout='1'">Logout</a></p>
<script>
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