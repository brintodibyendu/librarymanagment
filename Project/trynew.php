<?php
function getGenre()
{
	$conn=oci_connect('BRINTO','tiger','localhost/orcl');
	$query2="SELECT * FROM GENRE";
	$result3=oci_parse($conn,$query2);
	oci_execute($result3);
			 echo "<select name=\"srch_genre\" id=\"srch_genre\">\n";
			 echo"<option value=\"\">Any Genre;</option>\n";
			  while($row3=oci_fetch_array($result3)){
				  echo "<option value=\"".$row3['GENREID']."\"";
				  getSticky(2,'srch_genre',$row3['GENREID']);
				  echo ">".$row3['GENRE']."</option>";
			  }
			 echo "</select>\n";
}
function getLanguage()
{
	$conn=oci_connect('BRINTO','tiger','localhost/orcl');
	$query2="SELECT DISTINCT UPPER(LANGUAGE) AS LANGUAGE FROM BOOKS";
	$result3=oci_parse($conn,$query2);
	oci_execute($result3);
			 echo "<select >";
			  while($row3=oci_fetch_array($result3)){
				  echo "<option>{$row3['LANGUAGE']}</option>";
			  }
			 echo "</select>\n";
}
function getAuthor()
{
	$conn=oci_connect('BRINTO','tiger','localhost/orcl');
	$query2="SELECT * FROM AUTHOR";
	$result3=oci_parse($conn,$query2);
	oci_execute($result3);
	echo "<select name=\"srch_author\" id=\"srch_genre\">\n";
	echo"<option value=\"\">Any Author;</option>\n";
			  while($row3=oci_fetch_array($result3)){
				  echo "<option value=\"".$row3['WRITER_ID']."\"";
				  getSticky(2,'srch_author',$row3['WRITER_ID']);
				  echo ">".$row3['WRITER_NAME']."</option>";
			  }
			 echo "</select>\n";
}
function getSticky($case,$par,$value="",$initial="")
{
	switch($case)
	{
		case 1://textfield
		if(isset($_GET[$par]) && $_GET[$par]!='')
		{
			echo stripcslashes($_GET[$par]);
		}
		break;
		case 2:
		if(isset($_GET[$par]) && $_GET[$par]==$value)
		{
			echo " selected=\"selected\"";
		}
		break;
	}
}
if(isset($_GET['bsearch']))
{
	$getters=array();
	$queries=array();
	if(!empty($getters))
	{
		foreach($getters as $key => $value)
		{
			${$key}=$value;
			switch($key)
			{
				case 'bsearch':
				array_push($queries,"(bk.BOOK_NAME LIKE '%$bsearch')");
				break;
				case 'srch_genre':
				array_push($queries,"bk.GENRE=$srch_genre");
				break;
			}
		}
	}
}
?>
<html>
<head></head>
<body>
<form>
<input type='text' name='bsearch' id='bsearch' value="<?php getSticky(1,'bsearch');?>"/>
<?php getGenre() ; ?>
<?php getLanguage() ; ?>
</br></br>
<?php getAuthor() ; ?>
</br></br>
<button type="submit" name='search' id='search'>SEARCH</button>
<div >
<table  id="book" border="2" class="table">
<tr>
<th style="display:none">BOOK ID</th>
<th>BOOK_NAME</th>
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
	</tr>\n";
} 
?>
</table></div></br>
</form>
</body>
</html>