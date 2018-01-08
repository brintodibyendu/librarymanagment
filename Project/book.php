<?php
session_start();
include('regfunc.php');
?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UAUCompatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<script src="js/bootstrap.min.js"></script>
<?php
include('errors.php');
?>
<form method="POST">
<div >
<table  id="book" border="2" class="table">
<tr>
<th style="display:none">BOOK ID</th>
<th>BOOK_NAME</th>
<th>GENRE NAME</th>
<th>LANGUAGE</th>
<th>EDITION</th>
<th>WRITER</th>
</tr>
<?php 
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
$query="SELECT BOOK_ID,BOOK_NAME,GENRE,LANGUAGE,EDITION FROM BOOKS";
$result=oci_parse($conn,$query);
oci_execute($result);
while($row=oci_fetch_array($result)){
	echo
	"<tr class='select'>
	<td style='display:none'>{$row['BOOK_ID']}</td>
	<td>{$row['BOOK_NAME']}</td>
	<td>{$row['GENRE']}</td>
	<td>{$row['LANGUAGE']}</td>
	<td>{$row['EDITION']}</td>
	<td><button type='submit' name='book'>SHOW</button></td>
	</tr>\n";
} 
?>
</table></div></br>
<div>
</div>
<input type="text" id="id" name="id2" style="display:none" />
<input type="text" id="id3" name="id3" style="display:none"/>
<?php
if(isset($_SESSION['id']))
{
	echo"<button type='submit' id='borrow' name='borrow'>BORROW THIS</button></br>";
	echo "<button type='submit' id='wish' name='wish'>ADD TO WISHLIST</button></br>";
	echo "<button type='submit' id='favourite' name='favourite'>ADD TO FAVOURITE</button></br></br>";
	echo "
	<select id='rate'>
	<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
	</select> 
	<button type='submit' name='rate'>RATE THIS BOOK</button>";
}
?>
</form>
<button type="submit" id="back">GO TO HOME</button>
</body>
</html>
<script>
var tab=document.getElementById("book"),rindex;
for(var i=1;i<tab.rows.length;i++)
{
	tab.rows[i].onclick=function()
	{
		rindex=this.rowIndex;
		console.log(rindex);
		document.getElementById("id").value=this.cells[0].innerHTML;
		var e = document.getElementById("rate");
		e.onclick=function()
		{
		var strUser = e.options[e.selectedIndex].text;
		document.getElementById("id3").value=strUser;	
		}
	}
}
var btn = document.getElementById('back');
btn.addEventListener('click', function() {
  document.location.href = 'userpage.php';
});
</script>