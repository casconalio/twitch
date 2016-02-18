<?php
//session_start();
$nick = "xianheroolz"; //user ID
$pass = "oauth:hk46xza9ye3hmjbjerod8bq86zybqa"; //password
$host = "irc.twitch.tv"; //host
$port = 6667; //port
$sock =@ fsockopen($host, $port); //open connection
//$channel = $_SESSION['channelName'];
$channel = "meteos";
echo $channel;

// when "send" was clicked

$submitted = true;
if (!$sock) { //not connected
 printf("errno: %s, errstr: %s", $errno, $errstr);
}
else { //connected
 echo "Connected.";
 echo "<br><br>";
}


fputs($sock,"PASS $pass\r\n"); // input password (has to be done first)
fputs($sock,"NICK $nick\r\n"); // input user ID
fputs($sock,"JOIN #".$channel."\r\n"); // join the channel

$cnt=0;
while ($data = fgets($sock)) {
  if(substr($data, 0, 4)=="PING"){
    fputs($sock, "PONG :tmi.twitch.tv"); // send response PONG
  }
  if ($cnt > 9) {
      echo nl2br($data);
  }
  flush();
   //Separate all data
  $exData = explode(' ', $data);
  $cnt1=0;
  foreach ($exData as $value) {
    echo $exData[$value];
  }
  echo $cnt;
  $cnt++;
}


//make sure the input is good
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}



?>
