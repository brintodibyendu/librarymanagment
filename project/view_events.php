<?php
session_start();
?>
<html>
<head>
<title> Events </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
body {
  padding: 1em;
  font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 15px;
  // font-size: 1vw;
  background-color: #f9f9f9;
}

h3
{
	color: #0F6CC9;
	font-size: 40px;
}
.container {
  max-width: 50em;
  padding: 1em;
  margin: 0em auto;
  background-color: #fff;
  border-radius: @br * 1.4;
  box-shadow: 0px 3px 10px -2px rgba(0,0,0,0.2);
}

	
.hero-image {
  background-image: url("images/event.jpg");
  height: 20%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}


</style>
</head>
<body>
<center>
<div class="hero-image">
  </div>
  <h3>Events Management</h3>
</br></br>
</center>
<div class="container">
<table id="event" class="table" border="2">
<tr class="danger"><th style="display:none"> EVENT ID  </th> <th>EVENT NAME  </th><th>EVENT DATE  </th><th>EVENT DESCRIPTION  </th></tr>
<?php
$conn=oci_connect('BRINTO','tiger','localhost/orcl');
$query="SELECT * FROM EVENTS";
$result=oci_parse($conn,$query);
oci_execute($result);
while($row=oci_fetch_array($result))
{
	
	echo "<tr><td style='display:none'>{$row['EVENT_ID']}</td>
	<td>{$row['EVENT_NAME']}</td>
	<td>{$row['EVENT_DATE']}</td>
	<td>{$row['EVENT_DES']}</td>
	</tr>\n";
}
?>
</table></br>
</div>
</br></br>
<center>
<a href="bleh.php"> Go back to Home </a>
</center>
</body>
</html>

