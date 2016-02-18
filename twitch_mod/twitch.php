<?php

session_start();

$nick = "xianheroolz"; //user ID
$pass = "oauth:hk46xza9ye3hmjbjerod8bq86zybqa"; //password
$host = "irc.twitch.tv"; //host
$port = 6667; //port
$sock =@ fsockopen($host, $port); //open connection
$channel = ""; //channel
$message = ""; //channel

$messages = ""; //chat messages
$submitted = false;



// when "send" was clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $submitted = true;
  if (!$sock) { //not connected
     printf("errno: %s, errstr: %s", $errno, $errstr);
  }
  else { //connected
     echo "Connected.";
     echo "<br><br>";
  }
  $channel = test_input($_POST["Channel"]); // getting the text in that input field
  $message = test_input($_POST["Message"]); // getting the text in that input field

  if(!isset($_SESSION['channelName'])) {
      $_SESSION['channelName'] = $channel;
  }



  fputs($sock,"PASS $pass\r\n"); // input password (has to be done first)
  fputs($sock,"NICK $nick\r\n"); // input user ID

  fputs($sock,"JOIN #".$channel."\r\n"); // join the channel

  fputs($sock, "PRIVMSG #". $channel . " :" . $message . " \n"); // send message
  $cnt=0;



  // Outputs here so that you are sure of what you did
  echo "Nick:" . $nick;
  echo "<br>";
  echo "Channel:" . $channel;
  echo "<br>";
  echo "Message:" . $message;
  echo "<br>";
  echo "message sent.";



}

//make sure the input is good
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<!--
This is the form that you are typing stuff in.
-->
<!--
<br><br>
<img src="cash.jpg" alt="Money" style="width:300px;height:300px;">
<h2><font face="impact"> Wassup young blood? </font></h2>
<form method="post" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   Channel: <input type="text" name="Channel" value="<?php //echo $channel;?>">
   <br><br>
   Meesage: <input type="text" name="Message" value="<?php //echo $message;?>">
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
<form method="post" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<div class = "chat">
  <div class = "titleBar">
    <a href="#">
      <img src="pictures/bergur.png" alt="Menu" height="20" width="20">
    </a>
    <p><input type="text" name="Channel" placeholder="Channel" value="<?php echo $channel;?>"></p>
    <hr></hr>
  </div>


  <div class = "comments">
      <?php
      if ($submitted==true) {
          echo "<iframe src='http:chat.php'></iframe>";
      }
       ?>
  </div>


  <div class = "message">
    <textarea name="Message" type="text" placeholder="Send a message" value="<?php echo $message;?>"></textarea>
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
