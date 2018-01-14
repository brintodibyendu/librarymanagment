<?php 
session_start();
$errors=array();
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
if(!isset($_SESSION['libid'])){
	$_SESSION['msg']="You must login first";
	header('LOCATION:liblogin.php');
}
if(isset($_POST['submit']))
{
	$bid="";
	$wid="";
	$bname=$_POST['bname'];
	$language=$_POST['blang'];
	$edition=$_POST['bedition'];
	$copy=$_POST['bcopy'];
	$genre=$_SESSION['genre'];
	$libid=$_SESSION['libid'];
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
	    $query2="INSERT INTO BOOKS(BOOK_NAME,GENRE,LANGUAGE,EDITION,LIBID,COPY) VALUES('$bname','$genre','$language','$edition','$libid','$copy')";
		$result2=oci_parse($conn,$query2);
		oci_execute($result2,OCI_DEFAULT);
		$query6="SELECT BOOK_ID FROM BOOKS WHERE BOOK_NAME='$bname' AND GENRE='$genre' AND LANGUAGE='$language'";
		$result6=oci_parse($conn,$query6);
		oci_execute($result6,OCI_DEFAULT);
		while($row=oci_fetch_array($result6))
		{
			$bid=$row['BOOK_ID'];
		}
		$number = count($_POST["name"]);  
		if($number > 0)
		{
			for($i=0; $i<$number; $i++)
			{
				if(trim($_POST["name"][$i] != ''))
				{
					$wid="";
					$query="INSERT INTO AUTHOR(WRITER_NAME) VALUES('".$_POST['name'][$i]."')";
					$result=oci_parse($conn,$query);
					oci_execute($result);
					$query8="SELECT WRITER_ID FROM AUTHOR WHERE WRITER_NAME='".$_POST['name'][$i]."' ";
					$result4=oci_parse($conn,$query8);
					oci_execute($result4,OCI_DEFAULT);
					while($row=oci_fetch_array($result4))
					{
						$wid=$row['WRITER_ID'];
					}
					$query="INSERT INTO WRITES(WRITER_ID,BOOK_ID) VALUES('$wid','$bid')";
					$result5=oci_parse($conn,$query);
					oci_execute($result5,OCI_DEFAULT);
				}
			}
			echo "Data Inserted";
		}
		else
		{
			echo "Please Enter Name";
		}  
	}
}
?>
<html>
<head>

<title>Add Book</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <style>

body {
  padding: 1em;
  font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 15px;
  // font-size: 1vw;
  background-color: #e3e3e3;
}
h2
{
	color: #0F6CC9;
}
.container {
  max-width: 38em;
  padding: 1em 3em 2em 3em;
  margin: 0em auto;
  background-color: #fff;
  border-radius: @br * 1.4;
  box-shadow: 0px 3px 10px -2px rgba(0,0,0,0.2);
}
.hero-image {
  background-image: url("images/g.jpg");
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
    <h1 style="font-size:40px">ADD BOOK</h1>
  </div>
</div>
</center>
<form id="addwrite" name="addwrite" method="POST">
<center>
<div class="alert alert-danger">
  <strong> <?php include('errors.php'); ?></strong>
</div>
</center>
</br>

<div class="container">
<br>
<div class="form-group has-success has-feedback">
<input type="text" name="bname" class="form-control" placeholder="Enter BOOK NAME" aria-describedby="Success2Status">
<span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
  <span id="Success2Status" class="sr-only">(success)</span>  
</div>  
<div class="form-group has-success has-feedback">
<input type="text" name="blang" class="form-control" placeholder="Enter Book Language" aria-describedby="Success2Status">
<span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
  <span id="Success2Status" class="sr-only">(success)</span>  
</div>  
<div class="form-group has-error has-feedback">
<input type="text" name="bedition" class="form-control" placeholder="Enter Book Edition" aria-describedby="Error2Status">
 <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
    <span id="Error2Status" class="sr-only">(error)</span>    
  </div>
  <div class="form-group has-warning has-feedback">
<input type="text" name="bcopy" class="form-control" placeholder="Enter Number of copy" aria-describedby="Warning2Status">
<span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>
    <span id="Warning2Status" class="sr-only">(warning)</span>
      </div></br>
</br></br>
<input type="text" id="genre" name="genre" style="display:none"/>   
<table class="table table-bordered" id="dynamic_field">  
<tr>  
<td><input type="text" name="name[]" placeholder="Enter Writer Name" class="form-control name_list" /></td>  
<td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
</tr>  
</table>  
<input type="submit" name="submit" id="submit" class="btn btn-info" value="submit" />  
<br>
<a href="book_manage.php">BACK?</a></p>
</form>
<script>
	$(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"addbook.php",  
                method:"POST",  
                data:$('#addwrite').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#addwrite')[0].reset();  
                }  
           });  
      });  
 });  
</script>
</body>
</html>