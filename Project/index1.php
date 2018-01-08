<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  function getStates(value)
  {
	  $.post("fetch.php",{partialStates:value},function(data){
	  $("#results").html(data);
  }
  );
  }
  </script>
  <link href="css/bootstrap.min.css" rel="stylesheet">
 </head>
 <body>
<script src="js/bootstrap.min.js"></script>
   <div id="results" >
   <script>
   getStates();
   </script>
   </div>
     <input type="text" onkeyup="getStates(this.value)"/></br>
	 <button type="submit" id="back">GO TO HOME</button>
 </body>
 </html>
 <script>
  var btn = document.getElementById('back');
btn.addEventListener('click', function() {
  document.location.href = 'userpage.php';
});
 </script>