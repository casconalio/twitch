<?php
//session_start();
$submitted = false;
if (isset($_REQUEST['c'])){
    $channel = $_REQUEST['c'];
    //echo "HERE WE GO";
    $submitted = true;
}
else{
    echo "channel not set";
    //$channel = "n0m4dtv";
    //$submitted = true;
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

}

set_time_limit(0);
$nick = "xianheroolz"; //user ID
$pass = "oauth:hk46xza9ye3hmjbjerod8bq86zybqa"; //password
$host = "irc.twitch.tv"; //host
$port = 6667; //port
$sock = @fsockopen($host, $port); //open connection
echo $channel;

// when "send" was clicked

if (ob_get_level() == 0)
    ob_start();


if (!$sock) { //not connected
 printf("errno: %s, errstr: %s", $errno, $errstr);
}
else { //connected
 echo " connected.";
 echo "<br><br>";
}


fputs($sock,"PASS $pass\r\n"); // input password (has to be done first)
fputs($sock,"NICK $nick\r\n"); // input user ID
fputs($sock,"JOIN #".$channel."\r\n"); // join the channel

$cnt = 0;

?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
    setInterval('window.scroll(0, Math.pow(10,10))', 100);
</script>
<title>Chat</title>
<link rel="stylesheet" type="text/css" href="chatstyle.css">
</head>
<body id="main">
<form method="post">
<?php
while($submitted) {
  while ($data = fgets($sock)) {
    if(substr($data, 0, 4)=="PING"){
      fputs($sock, "PONG :tmi.twitch.tv"); // send response PONG
      continue;
    }
    $cnt++;
    if ($cnt > 10){
      $exData = explode(' ', $data); //seperate by spaces, place in array

      $usr = substr($exData[0], 1, (strpos($exData[0],"!")-1)); //get username
      $rm = array($exData[0], $exData[1], $exData[2]);
      $msg = array_diff($exData, $rm); //get comment
      $msg = substr(implode(" ", $msg), 1); //remove leading : from msg
      echo "<input type='image' src='images/arrowUp.png' name='up' value='Upvote'><div class='usr'>".$usr."</div>: <div class='msg'>".$msg."</div><br>"; //print usrname: comment
      echo "<script type='text/javascript'>
        if(){ scroll(); }
      </script>";
    }
    //echo $cnt." ";
    //echo nl2br($data);
    ob_flush();
    flush();
    //usleep(250000); //sleep .25 s
  // Separate all data
  }
}

//make sure the input is good
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>
</form>
</body>
</html>