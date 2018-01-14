<?php  
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
 if(isset($_POST["query"]))  
 {  
      $output = '';  
      $query = "SELECT * FROM AUTHOR WHERE LOWER(WRITER_NAME) LIKE LOWER('%".$_POST["query"]."%')";  
	  $result3=oci_parse($conn,$query);
	  oci_execute($result3);
      $output = '<ul class="list-unstyled">';  
           while($row = oci_fetch_array($result3))  
           {  
                $output .= '<li>'.$row["WRITER_NAME"].'</li>';  
           }  
      $output .= '</ul>';  
      echo $output;  
 }  
 ?>  