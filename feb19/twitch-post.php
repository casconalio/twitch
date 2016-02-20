<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/20/16
 * Time: 2:03 PM
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nick = "xianheroolz"; //user ID
    $pass = "oauth:hk46xza9ye3hmjbjerod8bq86zybqa"; //password
    $host = "irc.twitch.tv"; //host
    $port = 6667; //port
    $sock =@ fsockopen($host, $port); //open connection
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
    echo "message sent." ;
}

//make sure the input is good
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

header('Location: twitch.php');

exit;