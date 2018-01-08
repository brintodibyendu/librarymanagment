<?php
//fetch.php
$conn = oci_connect('BRINTO','tiger','localhost/orcl');
$output = '';
if(isset($_POST["partialStates"]))
{
 $search = $_POST["partialStates"];
 $query = "
  SELECT  BOOK_ID,BOOK_NAME,GENRE,LANGUAGE,EDITION FROM BOOKS 
  WHERE LOWER(BOOK_NAME) LIKE LOWER('%".$search."%')
  OR LOWER(GENRE) LIKE LOWER('%".$search."%') 
  OR LOWER(LANGUAGE) LIKE LOWER('%".$search."%') 
 ";
}
else
{
 $query = "
 SELECT  BOOK_ID,BOOK_NAME,GENRE,LANGUAGE,EDITION FROM BOOKS 
 ";
}
$output.='
<table id="book">
   <tr>
   <th>BOOK NAME</th><th>BOOK ID</th><th>EDITION</th><th>EDITION</th>
   </tr>";
';
$result=oci_parse($conn,$query);
oci_execute($result);
$resourse1=array();
//$numrows1=oci_fetch_all($result,$resourse1,null,null,OCI_FETCHSTATEMENT_BY_ROW);


 while($row = oci_fetch_array($result))
 {
  $output .= '
   <tr>
    <td style="display:none">'.$row["BOOK_ID"].'</td>
    <td>'.$row["BOOK_NAME"].'</td>
    <td>'.$row["GENRE"].'</td>
    <td>'.$row["LANGUAGE"].'</td>
    <td>'.$row["EDITION"].'</td>
   </tr>
  ';
 }
 echo $output;
?>
<script>

</script>