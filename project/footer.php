<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <link href="css/lmi-styles.css" rel="stylesheet">
	  <link href="css/popup.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
 
  <div id="dli-footer" class="row">
  <div class="col-xs-12">
    <div class="row">
      <div class="col-xs-3">
        <div id="news-list" class="row">
          <div class="col-xs-12">
            <div class="row footer-heading">
              <div class="col-xs-9">
                <h4>Library Hours</h4>
              </div>
              <div class="col-xs-3 text-right">  </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <ul>
                  <li>
                    <p>
General library</br>
Saturday-Wednesday: 9am-5pm</br></br>
Reading Room</br>
1. Saturday-Wednesday: 9am-10pm</br>
2. Thursday : 9am-9pm</br><br>
Browsing Room</br>
Saturday-Thursday: 9am-9pm
</p>
                     
                  </li>
                </ul>
        
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-3">
        <div id="news-list" class="row">
          <div class="col-xs-12">
            <div class="row footer-heading">
              <div class="col-xs-9">
                <h4>Latest News</h4>
              </div>
              <div class="col-xs-3 text-right"> <a class="btn btn-xs" href="/news.php">View All</a> </div>
            </div>
            <div class="row">
              <div class="col-xs-12" style="height: 180px; overflow-y:scroll;">
                <ul>
                  <li>
                    <h5> <a href=""></a> </h5>
                    <span class="text-muted">Release Date:  <span class="glyphicon glyphicon-calendar"></span></span> </li>
                  <li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-3">
        <div class="row">
          <div class="col-xs-12">
            <h4>Contact</h4>
            <h5>Head Librarian</h5>
            <address>
            Library of ' ' <br>
            address...., Dhaka-1207<br>
            &#9742 (88)-02-8181268<br>
            Fax: (88)-02-8181509<br>
            &#9993 kabir.ddd@gmail.com
            </address>
          </div>
        </div>
      </div>
      <div class="col-xs-3">
        <h4>Quick Contact</h4>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" id="form" method="post" name="form">
          <input id="msgname" name="msgname" placeholder="Name..." type="text" required>
          <input id="email" name="email" placeholder="Email..." type="email" required>
          <input id="subject" name="subject" placeholder="Subject..." type="text" required>
          <textarea id="msg" name="msg" row="4" placeholder="Message..." required></textarea>
          <input type="submit" id="submit" value="Send" class="btn btn-success">
        </form>
      </div>
    </div>
  </div>
</div>
<div id="sub-footer" class="row">
  <div class="col-xs-12 text-center">
    <p>© 2015 Online Library of Bangladesh</p>
  </div>
</div>
  <div class="clear"></div>
<div id="template-footer-wrapper">
  <footer id="template-footer">
    <ul id="template-footer-nav">
      <li><a href="#" title="Privacy &amp; Security Policy" target="_blank">Privacy &amp; Security</a></li>
      <li><a href="#" title="Accessibility">Accessibility</a></li>
    </ul>
  </footer>
</div>
</html> 
  