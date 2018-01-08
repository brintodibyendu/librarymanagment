<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
</head>
<body>
<h4>Search</h4>
<table  id="book_table" border="2" class="table">
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
?> 
<tr class='select'>
	<td style='display:none'><?php echo $row['BOOK_ID']?></td>
	<td><?php echo $row['BOOK_NAME']?></td>
	<td><?php echo $row['BOOK_ID']?></td>
	<td><?php echo $row['LANGUAGE']?></td>
	<td><?php echo $row['EDITION']?></td>
	<td><button type='submit' name='book'>SHOW</button></td>
	</tr>
<?php
}
?>
</table> </br>
<div>
<input type="text" name="search" id="search"/>
</div>
</body>
</html>
<script>
$(document).ready(function(){
$('#search').keyup(function(){
	search_table($(this).val());
});
function search_table(value){
	$('#book_table tr').each(function(){
		var found='false';
		$(this).each(function(){
			if($(this).text().toLowerCase().indexOf(value.toLowerCase())>=0)
			{
				found='true';
			}
		});
		if(found=='true')
		{
			$(this).show();
		}
		else{
			$(this).hide();
		}
	});
}
});
var tab=document.getElementById("book_table"),rindex;
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
</script>