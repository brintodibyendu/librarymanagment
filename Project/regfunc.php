<?php
$id="";
$libid="";
$username="";
$gender="";
$email="";
$nationality="";
$age="";
$location="";
$type="";
$level="";
$term="";
$designation="";
$genre="";
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
$errors=array();
if(isset($_POST['register'])){
	$id=$_POST['id'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$gender=$_POST['gender'];
	$email=$_POST['email'];
	$nationality=$_POST['nationality'];
	$age=$_POST['age'];
	$location=$_POST['location'];
	$type=$_POST['type'];
	$designation=$_POST['designation'];
	$level=$_POST['level'];
	$term=$_POST['term'];
	if(empty($id))
	{
		array_push($errors,"Id is required");
	}
	if(empty($username))
	{
		array_push($errors,"UserName is required");
	}
	if(empty($password))
	{
		array_push($errors,"Password is required");
	}
	if(empty($gender))
	{
		array_push($errors,"Gender is required");
	}
	if(empty($email))
	{
		array_push($errors,"Email is required");
	}
	if(empty($nationality))
	{
		array_push($errors,"NATIONALITY is required");
	}
	if(empty($age))
	{
		array_push($errors,"Age is required");
	}
	if(empty($location))
	{
		array_push($errors,"Location is required");
	}
	if(empty($type))
	{
		array_push($errors,"UserType is required");
	}
	if(!empty($type))
	{
		if($type=='TEACHER')
		{
			if(empty($designation)){
				array_push($errors,"DESIGNATION is required");
			}
		}
		else if($type=='STUDENT')
		{
			if(empty($level)){
				array_push($errors,"Level is required");
			}
			if(empty($term)){
				array_push($errors,"Term is required");
			}
		}
	}
	if(count($errors)==0){
		
		$query1="SELECT * FROM USER1 WHERE USER_ID='$id'";
		$result1=oci_parse($conn,$query1);
		oci_execute($result1,OCI_DEFAULT);
		$resourse1=array();
		$numrows1=oci_fetch_all($result1,$resourse1,null,null,OCI_FETCHSTATEMENT_BY_ROW);
		if($numrows1==0){
			if($type=='TEACHER'){
				$query2="INSERT INTO TEACHER(USER_ID,DESIGNATION) VALUES('$id','$designation')";
				$result3=oci_parse($conn,$query2);
				oci_execute($result3);
			}
			if($type=='STUDENT'){
				$query2="INSERT INTO STUDENT(USER_ID,LEVELS,TERMS) VALUES('$id','$level','$term')";
				$result3=oci_parse($conn,$query2);
				oci_execute($result3);
			}
            $query="INSERT INTO USER1(USERNAME,USER_ID,PASSWORD,SEX,EMAIL,NATIONALITY,AGE,LOCATION,USER_TYPE) VALUES('$username','$id','$password','$gender','$email','$nationality',$age,'$location','$type')";
            $result=oci_parse($conn,$query);
            oci_execute($result);
			$_SESSION['id']=$id;
			$_SESSION['success']="You are now logged in";
		header('LOCATION:userpage.php');
		}
		else{
			array_push($errors,"Already Registered");
		}
	}
}
if(isset($_POST['libregister']))
{
	$id=$_POST['id'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$genre=$_POST['genre'];
	$email=$_POST['email'];
	if(empty($id))
	{
		array_push($errors,"Id is required");
	}
	if(empty($username))
	{
		array_push($errors,"UserName is required");
	}
	if(empty($password))
	{
		array_push($errors,"Password is required");
	}
	if(empty($genre))
	{
		array_push($errors,"Gender is required");
	}
	if(empty($email))
	{
		array_push($errors,"Email is required");
	}
	if(count($errors)==0)
	{
        $query1="SELECT * FROM LIBUSER WHERE LIBID='$id'";
		$result1=oci_parse($conn,$query1);
		oci_execute($result1,OCI_DEFAULT);
		$resourse1=array();
		$numrows1=oci_fetch_all($result1,$resourse1,null,null,OCI_FETCHSTATEMENT_BY_ROW);
        $query2="SELECT * FROM LIBUSER WHERE GENRE=UPPER('$genre')";
		$result3=oci_parse($conn,$query2);
		oci_execute($result3,OCI_DEFAULT);
		$resourse2=array();
		$numrows2=oci_fetch_all($result3,$resourse2,null,null,OCI_FETCHSTATEMENT_BY_ROW);
		if($numrows1==0 && $numrows2==0)
		{
		$query3="INSERT INTO LIBUSER(LIBID,USERNAME,PASSWORD,GENRE,EMAIL) VALUES('$id','$username','$password','$genre','$email')";
		$result5=oci_parse($conn,$query3);
		oci_execute($result5);	
		}
		if($numrows2!=0)
		{
			array_push($errors,"Genre already exists");
		}
		if($numrows1!=0)
		{
			array_push($errors,"Allready Registered");
		}
	}
}
if(isset($_POST['login'])){
	$id=$_POST['id'];
	$password=$_POST['password'];
	if(empty($id))
	{
		array_push($errors,"UserID is required");
	}
	if(empty($password))
	{
		array_push($errors,"Password is required");
	}
	if(count($errors)==0){
		$query="SELECT * FROM USER1 WHERE USER_ID='$id' AND PASSWORD='$password'";
		$result=oci_parse($conn,$query);
		oci_execute($result,OCI_DEFAULT);
		$resourse=array();
		$numrows=oci_fetch_all($result,$resourse,null,null,OCI_FETCHSTATEMENT_BY_ROW);
		if($numrows==1){
			$_SESSION['id']=$id;
			$_SESSION['success']="You are now logged in";
			header('LOCATION:userpage.php');
		}else{
			array_push($errors,"Username/Password doesnot match");
		}
	}
}
if(isset($_POST['liblogin'])){
	$id=$_POST['id'];
	$password=$_POST['password'];
	if(empty($id))
	{
		array_push($errors,"LIBRARIAN ID is required");
	}
	if(empty($password))
	{
		array_push($errors,"Password is required");
	}
	if(count($errors)==0){
		$query="SELECT * FROM LIBUSER WHERE LIBID='$id' AND PASSWORD='$password'";
		$result=oci_parse($conn,$query);
		oci_execute($result,OCI_DEFAULT);
		$resourse=array();
		while($row=oci_fetch_array($result)){
			$genre=$row['GENRE'];
		}
		//$numrows=oci_fetch_all($result,$resourse,null,null,OCI_FETCHSTATEMENT_BY_ROW);
		if(!empty($genre)){
			$_SESSION['libid']=$id;
			$_SESSION['genre']=$genre;
			$_SESSION['success']="You are now logged in";
			header('LOCATION:libraryhome.php');
		}else{
			array_push($errors,"LIBRARIAN ID/Password doesnot match");
		}
	}
}
if(isset($_POST['book'])){
	$id=$_POST['id2'];
	$query="select WRITER_NAME from AUTHOR where WRITER_ID=any(select WRITER_ID FROM WRITES where BOOK_ID='$id')";
    $result=oci_parse($conn,$query);
    oci_execute($result);
	echo "<table><tr><th>WRITER NAME</th></tr>";
    while($row=oci_fetch_array($result)){
	echo"<tr><td>{$row['WRITER_NAME']}</td></tr>\n";
	}
	echo "</table>";
}
if(isset($_POST['wish']))
{
    $bid=$_POST['id2'];
	$uid=$_SESSION['id'];
	if(!empty($bid))
	{
		$query1="select * from wishlist where user_id='$uid' and book_id='$bid'";
		$result1=oci_parse($conn,$query1);
		oci_execute($result1,OCI_DEFAULT);
		$resourse1=array();
		$numrows1=oci_fetch_all($result1,$resourse1,null,null,OCI_FETCHSTATEMENT_BY_ROW);
		$result2=oci_num_rows($result1);
		if($result2==0)
		{
			$query="INSERT INTO WISHLIST(USER_ID,BOOK_ID) VALUES('$uid','$bid')";
			$result=oci_parse($conn,$query);
oci_execute($result);
		}
		else{
			array_push($errors,"ALREADY IN WISHLIST");
		}
	}
}
if(isset($_POST['favourite']))
{
    $bid=$_POST['id2'];
	$uid=$_SESSION['id'];
	if(!empty($bid))
	{
		$query1="select * from favouritelist where user_id='$uid' and book_id='$bid'";
		$result1=oci_parse($conn,$query1);
		oci_execute($result1,OCI_DEFAULT);
		$resourse1=array();
		$numrows1=oci_fetch_all($result1,$resourse1,null,null,OCI_FETCHSTATEMENT_BY_ROW);
		$result2=oci_num_rows($result1);
		if($result2==0)
		{
			$query="INSERT INTO FAVOURITELIST(USER_ID,BOOK_ID) VALUES('$uid','$bid')";
			$result=oci_parse($conn,$query);
			oci_execute($result);
		}
		else{
			array_push($errors,"ALREADY IN FAVOURITE LIST");
		}
	}
}
if(isset($_POST['rate']))
{
	$rate=$_POST['id3'];
	$bid=$_POST['id2'];
	$uid=$_SESSION['id'];
	if(!empty($bid))
	{
		$query="INSERT INTO RATING(USER_ID,BOOK_ID,RATING) VALUES('$uid','$bid','$rate')";
		$result=oci_parse($conn,$query);
		oci_execute($result);		
	}
}
if(isset($_POST['borrow']))
{
	$id=$_POST['id2'];
	$bor=$_POST['bor'];
	$uid=$_SESSION['id'];
	if(!empty($id))
	{
		$query="SELECT BOOK_ID,LIBID,TO_NUMBER(COPY) COPY FROM BOOKS WHERE BOOK_ID='$id'";
		$result=oci_parse($conn,$query);
		oci_execute($result);
		while($row=oci_fetch_array($result)){
			$libid=$row['LIBID'];
			$copy=$row['COPY'];
		}
		if($copy>0){
		$query1="INSERT INTO BORROW(BORROW_ID,USER_ID,BOOK_ID,LIBID) VALUES('$bor','$uid','$id','$libid')";
		$result1=oci_parse($conn,$query1);
		oci_execute($result1);
		$query2="UPDATE BOOKS SET COPY=TO_CHAR($copy-1) WHERE BOOK_ID='$id'";
		$result2=oci_parse($conn,$query2);
		oci_execute($result2);
		}
		else
		{
			array_push($errors,"Sorry There is no Copy");
		}
	}
}
?>