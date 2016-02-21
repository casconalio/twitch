<?php

session_start();
define("TWITCH_SESSION", 'twitch');
//unset($_SESSION['channelName']);
//exit;
$nick = "xianheroolz"; //user ID
$pass = "oauth:hk46xza9ye3hmjbjerod8bq86zybqa"; //password
$host = "irc.twitch.tv"; //host
$port = 6667; //port
$sock =@ fsockopen($host, $port); //open connection
$channel = ""; //channel
$message = ""; //channel

if(isset($_SESSION['channelName'])) {
    $channel = test_input($_SESSION['channelName']); // getting the text in that input field
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $channel = test_input($_POST["Channel"]); // getting the text in that input field
    $message = test_input($_POST["Message"]); // getting the text in that input field

    if (!isset($_SESSION['channelName'])) {
        $_SESSION['channelName'] = $channel;
    }

    fputs($sock, "PASS $pass\r\n"); // input password (has to be done first)
    fputs($sock, "NICK $nick\r\n"); // input user ID
    fputs($sock, "JOIN #" . $channel . "\r\n"); // join the channel
    fputs($sock, "PRIVMSG #" . $channel . " :" . $message . " \n"); // send message
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
<link rel="stylesheet" type="text/css" href="chatstyle.css">
<meta http-Equiv="Cache-Control" Content="no-cache">
<meta http-Equiv="Pragma" Content="no-cache">
<meta http-Equiv="Expires" Content="0">
</head>

<header>
</header>

<body>
<iframe class="video"
    <?php echo 'src="http://player.twitch.tv/?channel='.$channel.'"'; ?>
    height="720"
    width="1280"
    frameborder="0"
    scrolling="no"
    allowfullscreen="true">
</iframe>
<form method="post">
<div class = "chat">
  <div class = "titleBar">
    <a href="#">
      <input type="image" src="PowerIcon.png" alt="Menu" height="20" width="20">
    </a>
    <p><input type="text" name="Channel" placeholder="Channel" value="<?php echo $channel;?>"></p>
  </div>
<?php $url = 'fasterChat.php?c='.$channel; ?>
<hr>
  <div class = "comments">
      <?php
      if (isset($_SESSION['channelName'])) {
          echo "<iframe src=$url width='375' height='740' scrolling='yes'></iframe>";
          unset($_SESSION['channelName']);
      }
      else{
          echo "no iframe";
          unset($_SESSION['channelName']);
      }
       ?>
  </div>

  <?php $url = 'send.php?c='.$channel;
  echo "<iframe src=$url width='375'></iframe>";
  ?>

</div>

</form>

</body>

<footer>
</footer>


</html>
