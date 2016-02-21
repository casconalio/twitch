<?php
//session_start();
$submitted = false;
if (isset($_REQUEST['c'])){
    echo "we got: ".$_REQUEST['c'];
    $channel = $_REQUEST['c'];
    echo "HERE WE GO";
    $submitted = true;
}
else{
    echo "not set";
    exit;
}

set_time_limit(0);
$nick = "xianheroolz"; //user ID
$pass = "oauth:hk46xza9ye3hmjbjerod8bq86zybqa"; //password
$host = "irc.twitch.tv"; //host
$port = 6667; //port
$sock = @fsockopen($host, $port); //open connection

//$channel = "herdyn";
echo $channel;

//set_time_limit(0);

// when "send" was clicked

if (ob_get_level() == 0)
    ob_start();


if (!$sock) { //not connected
 printf("errno: %s, errstr: %s", $errno, $errstr);
}
else { //connected
 echo " Connected.";
 echo "<br><br>";
}



//stream_set_blocking($sock, 0);


fputs($sock,"PASS $pass\r\n"); // input password (has to be done first)
fputs($sock,"NICK $nick\r\n"); // input user ID
fputs($sock,"JOIN #".$channel."\r\n"); // join the channel

//$cnt=0;

//while (true) {
  //$data = fgets($sock, 128);
  //echo nl2br($data);
  //if(substr($data, 0, 4)=="PING"){
    //fputs($sock, "PONG :tmi.twitch.tv"); // send response PONG
  //}
  //flush();
//}

$cnt = 0;

while($submitted) {
  while ($data = fgets($sock)) {
    $cnt++;
    echo $cnt." ";
    echo nl2br($data);
    ob_flush();
    flush();
    usleep(500000);
  // Separate all data
  $exData = explode(' ', $data);
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
