<?php
if(isset($_POST['back']))
{
	header('LOCATION:libraryhome.php');
}
function fetch_data()
{
	$output='';
	$userid=$_POST['userid'];
	$conn=oci_connect('BRINTO','tiger','localhost/orcl');
	$query="SELECT B.BOOK_NAME AS BOOK_NAME,R.START_DATE AS START_DATE,R.END_DATE AS END_DATE,L.USERNAME AS USER_NAME FROM RETURN R JOIN BOOKS B ON(B.BOOK_ID=R.BOOK_ID) JOIN LIBUSER L ON(R.LIBID=L.LIBID) WHERE R.USER_ID='$userid'";
	$result=oci_parse($conn,$query);
	oci_execute($result);
	while($row=oci_fetch_array($result)){
	$output.='<tr>
	<td>'.$row['BOOK_NAME'].'</td>
	<td>'.$row['START_DATE'].'</td>
	<td>'.$row['END_DATE'].'</td>
	<td>'.$row['USER_NAME'].'</td>
	</tr>';
	}
	return $output; 
}
if(isset($_POST['pdf']))
{
	require_once("tcpdf/tcpdf.php");
	$obj_pdf=new TCPDF('P',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
	$obj_pdf->SetCreator(PDF_CREATOR);
	$obj_pdf->SetTitle("Export HTML Table");
	$obj_pdf->SetHeaderData('','',PDF_HEADER_TITLE,PDF_HEADER_STRING);
	$obj_pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
	$obj_pdf->SetFooterFont(Array(PDF_FONT_NAME_DATA,'',PDF_FONT_SIZE_DATA));
	$obj_pdf->SetDefaultMonospacedFont('helvetica');
	$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$obj_pdf->SetMargins(PDF_MARGIN_LEFT,'5',PDF_MARGIN_RIGHT);
	$obj_pdf->setPrintHeader(false);
	$obj_pdf->setPrintFooter(false);
	$obj_pdf->SetAutoPageBreak(TRUE,10);
	$obj_pdf->SetFont('helvetica','',12);
	$obj_pdf->AddPage();
	$content='';
	$content.='<center><h2>USER REPORT</h2></center></br>';
	$content .='
	<table id="rbook" border="2" cellspacing="0" cellpadding="3" >
<tr><th>BOOK NAME</th><th>START DATE</th><th>END DATE</th><th>LIBRARIAN NAME</th></tr>';
$content.=fetch_data();
$content.='</table>';
$obj_pdf->writeHTML($content);
$obj_pdf->Output("sample.pdf","I");
}
?>
<html>
<head></head>
<body>
<form method="post" action="userreport.php">
<h2>USER REPORT</h2>
<input type="text"  name="userid" value="<?php if(isset($_POST['userid'])){echo $_POST['userid'];}?>"></br></br>
<button type="submit" name="show">SHOW REPORT</button></br></br>
<table id="rbook" border=2 >
<tr>
<th>BOOK NAME</th><th>START DATE</th><th>END DATE</th><th>LIBRARIAN NAME</th>
</tr>
<?php
if(isset($_POST['show']))
{
	echo fetch_data();
}
?>
</table>
<button type="submit" name="pdf">GET PDF</button></br>
<button type="submit" name="back">BACK</button>
</form>
</body>
</html>