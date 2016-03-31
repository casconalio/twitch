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

<!DOCTYPE html>
<html>
<head>
<script type=text/javascript>
    function scroll(){
        var a = document.getElementById('cmnts').contentWindow;
        a.scrollTo(0,200);
    }
</script>
<title>Chat</title>
<link rel="stylesheet" type="text/css" href="chatstyle.css">
<meta http-Equiv="Cache-Control" Content="no-cache">
<meta http-Equiv="Pragma" Content="no-cache">
<meta http-Equiv="Expires" Content="0">
</head>

<header>
</header>

<body>
    <iframe name="vid"
        <?php echo 'src="http://player.twitch.tv/?channel='.$channel.'"'; ?>

            frameborder="0"
            scrolling="no"
            allowfullscreen="true">
    </iframe>
    <iframe src="http://35.9.22.102/Po-An/samples/test.php" name="ads" scrolling="no">
    </iframe>
<div class="main">


<form method="post">
  <div class="topComments">
    <p>Top Comments</p>
    <iframe id='topCmts' name='topCmts' src="getComments.php">
    </iframe>
  </div>

<div class = "chat">

  <div class = "titleBar">
      <hr>
    <a href="#">
      <input type="image" src="images/PowerIcon.png" alt="Menu" height="20" width="20">
    </a>
    <p><input type="text" name="Channel" placeholder="Channel" value="<?php echo $channel;?>"></p>
    <hr>
  </div>
<?php $url = "index.html"; ?>

  <div class = "comments">
      <?php
      if (isset($_SESSION['channelName'])) {
          echo "<iframe id='cmtns' name='cmnts' src=$url scrolling='auto'></iframe>";
          unset($_SESSION['channelName']);
      }
      else{
          echo " Please input a channel...";
          unset($_SESSION['channelName']);
      }
       ?>
  </div>

  <?php $url = 'send.php?c='.$channel;
  echo "<iframe name='msg' src=$url width='375' height='65'></iframe>";
  ?>
</div>
</form>
</div>
</body>
</html>
