<?php

session_start();

//unset($_SESSION['channelName']);
//exit;
set_time_limit(0);
$nick = "xianheroolz"; //user ID
$pass = "oauth:hk46xza9ye3hmjbjerod8bq86zybqa"; //password
$host = "irc.twitch.tv"; //host
$port = 6667; //port
$sock = @fsockopen($host, $port); //open connection
$channel = ""; //channel
$message = "shit"; //channel

if (isset($_REQUEST['c'])){
    $channel = $_REQUEST['c'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
echo $message;
$message = test_input($_POST["Message"]); // getting the text in that input field
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
<form method="post">
  <div class = "message">
    <textarea name="Message" type="text" placeholder="Send a message" value="<?php echo $channel;?>"></textarea>
  </div>

  <div class="sendButton">
      <div class="send">
        <input type="submit" name="send" value="Chat">
      </div>
  </div>

</form>

</body>

<footer>
</footer>


</html>
