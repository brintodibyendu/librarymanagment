<?php  
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
 $number = count($_POST["name"]);  
 if($number > 0)  
 {  
      for($i=0; $i<$number; $i++)  
      {  
           if(trim($_POST["name"][$i] != ''))  
           {
			   $query="INSERT INTO AUTHOR(WRITER_NAME) VALUES($_POST['name'][$i]))";
			   $result=oci_parse($conn,$query);
			   oci_execute($result);
           }  
      }  
      echo "Data Inserted";  
 }  
 else  
 {  
      echo "Please Enter Name";  
 }  
 ?> 