<?php
if(isset($_POST['makelib']))
{
header("LOCATION:libsignup.php");	
}
if(isset($_POST['updatelibrary']))
{
	$libbid=$_POST['id'];
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
?>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<form method="POST">
<input type="submit" id="makelib" name="makelib" value="ADD LIBRARIAN"/>
<table  id="library">
<thead>
<tr class="danger">
<th style="display:none">LIBID</th>
<th>USERNAME</th>
<th>PASSWORD</th>
<th>GENRE</th>
<th>EMAIL</th>
<th>SELECT</th>
</tr>
</thead>
<?php 
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
$query="SELECT * FROM LIBUSER";
$result=oci_parse($conn,$query);
oci_execute($result);
while($row=oci_fetch_array($result)){
	echo
	"<tr class='select'>
	<td style='display:none'>{$row['LIBID']}</td>
	<td>{$row['USERNAME']}</td>
	<td>{$row['PASSWORD']}</td>
	<td>{$row['GENRE']}</td>
	<td>{$row['EMAIL']}</td>
	<td><input type='radio' name='sss'></td>
	</tr>\n";
} 
?>
</table></br>
<input type="text" name="libid" id="libid" style="display:none"/>
<input type="text" name="libname" id="libname"/>
<p>USER Name</p>
<input type="text" name="libpass" id="libpass"/>
<p>PASSWORD</p>
<input type="text" name="libgenre" id="libgenre"/>
<p>GENRE</p>
<input type="EMAIL" name="libmail" id="libmail"/>
<p>E-MAIL</p></br></br>
<button type="submit" class="btn btn-success" name="updatelibrary" id="updatelibrary">UPDATE INFORMATION</button>
<button type="submit" class="btn btn-danger" name="deletelibrary" id="deletelibrary">DELETE LIBRARIAN</button></br>
<div class="card text-white bg-success mb-3" style="max-width: 18rem;">
  <div class="card-header">Header</div>
  <div class="card-body">
    <h5 class="card-title">Success card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
</div>
</form>
</body>
</html>
<script>
function selectRow()
{
	var radios=document.getElementsByName("sss");
	for(var k=0;k<radios.length;k++)
	{
		radios[k].onclick=function(){
			var tab=document.getElementById("library"),rindex;
for(var i=1;i<tab.rows.length;i++)
{
	tab.rows[i].onclick=function()
	{
		rindex=this.rowIndex;
		console.log(rindex);
		document.getElementById("libid").value=this.cells[0].innerHTML;
	}
}
		};
	}
}
selectRow();
</script>