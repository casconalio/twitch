
<!--
This is the form that you are typing stuff in.
-->
<!--
<br><br>
<img src="cash.jpg" alt="Money" style="width:300px;height:300px;">
<h2><font face="impact"> Wassup young blood? </font></h2>
<form method="post" action="">
   Channel: <input type="text" name="Channel" value="">
   <br><br>
   Meesage: <input type="text" name="Message" value="">
   <br><br>
   <input type="submit" name="send" value="Send">
</form>
-->

<!DOCTYPE html>
<html>
<head>
<title>Chat</title>
<link rel="stylesheet" type="text/css" href="css/chatstyle.css">
</head>

<header>
</header>

<body>
<form method="post" action="">
<div class = "chat">
  <div class = "titleBar">
    <a href="#">
      <img src="pictures/bergur.png" alt="Menu" height="20" width="20">
    </a>
    <p><input type="text" name="Channel" placeholder="Channel" value=""></p>
    <hr></hr>
  </div>


  <div class = "comments">
        </div>


  <div class = "message">
    <textarea name="Message" type="text" placeholder="Send a message" value=""></textarea>
  </div>

  <div class="sendButton">
    <a href="">
      <div class="send">
        <input type="submit" name="send" value="Chat">
      </div>
    </a>
  </div>
  <div class = "settings">
  </div>
</div>

</form>

</body>

<footer>
</footer>


</html>
