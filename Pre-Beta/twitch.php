<?php

session_start();
define("TWITCH_SESSION", 'twitch');
unset($_SESSION['channelName']);
//exit;
$nick = "xianheroolz"; //user ID
$pass = "oauth:hk46xza9ye3hmjbjerod8bq86zybqa"; //password
$host = "irc.twitch.tv"; //host
$port = 6667; //port
$sock =@ fsockopen($host, $port); //open connection
$channel = ""; //channel
$message = ""; //channel
$blnChannelSet = false;

if(isset($_SESSION['channelName'])) {
    $channel = test_input($_SESSION['channelName']); // getting the text in that input field
}
else if(isset($_REQUEST['c'])){
    $channel = strip_tags($_REQUEST['c']);
    $blnChannelSet = true;
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

function get_url_contents($url){
    $crl = curl_init();
    $timeout = 5;
    curl_setopt ($crl, CURLOPT_URL,$url);
    curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
    $ret = curl_exec($crl);
    curl_close($crl);
    return $ret;
}

function post_url_contents($url, $fields) {

    foreach($fields as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
    rtrim($fields_string, '&');

    $crl = curl_init();
    $timeout = 5;

    curl_setopt($crl, CURLOPT_URL,$url);
    curl_setopt($crl,CURLOPT_POST, count($fields));
    curl_setopt($crl,CURLOPT_POSTFIELDS, $fields_string);

    curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
    $ret = curl_exec($crl);
    curl_close($crl);
    return $ret;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script type=text/javascript>
        var chans;
        function setChannel(i) {
            chans = "";
            var channelName = document.getElementById("Channel").value;
            chans = channelName;
            window.localStorage.setItem("Chans", chans);
        }
    </script>

    <title>Chat</title>
    <link rel="stylesheet" type="text/css" href="chatstyle.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <meta http-Equiv="Cache-Control" Content="no-cache">
    <meta http-Equiv="Pragma" Content="no-cache">
    <meta http-Equiv="Expires" Content="0">
</head>

<header>
</header>

<body>
<div class="purple">
</div>
    <span class="banner">
    <?php
    if(isset($_SESSION['channelName']) || isset($_REQUEST['c'])) {
        $viewers = 0;
        $summary = "https://api.twitch.tv/kraken/streams?channel=" . $channel;
        $json = get_url_contents($summary);
        $json = json_decode($json, true);
        $info = $json["streams"][0];
        $viewers = $info["viewers"];
        //echo "viewers: ".$viewers;
        //echo ", game: ".$info["game"];
        //echo ", status: ".$info["channel"]["status"];
        //echo ", name: ".$info["channel"]["display_name"];
        echo '<img src="'.$info["channel"]["logo"].'" alt="channel_logo">';
        echo '<p class="title">'.$info["channel"]["status"].'</p>';
        echo '<p class="info">'.$info["channel"]["display_name"]." playing ".$info["game"].'</p>';
    }
    ?>
    </span>
    <iframe name="vid"
        <?php echo 'src="http://player.twitch.tv/?channel='.$channel.'"'; ?>
            frameborder="0"
            scrolling="no"
            allowfullscreen="true">
    </iframe>
    <span class="toolbar">
    <?php
    if(isset($_SESSION['channelName']) || isset($_REQUEST['c'])) {
        echo "<p> ".$viewers."&nbsp<i class=\"fa fa-eye\"></i> &nbsp&nbsp&nbsp".$info["channel"]["views"]."&nbsp<i class=\"fa fa-group\"></i>&nbsp&nbsp&nbsp ".$info["channel"]["followers"]." &nbsp<i class=\"fa fa-heart\"></i> </p>";

    }
    ?>
    </span>
    <div class="main">

        <form method="post">
            <div class="topComments">
                <p>Top Comments</p>
                <iframe id='topCmts' name='topCmts' src="topComments.php">
                </iframe>
            </div>

            <div class="ad">
                <iframe name='ads'
                    <?php
                    if(isset($_SESSION['channelName']) || isset($_REQUEST['c'])) {
                        echo 'src="http://35.9.22.102/new_ad/test.php"';
                    }else{
                        echo 'src="http://35.9.22.102/new_ad/test.php"';
                    }
                    ?>
                        scrolling="no">
                </iframe>
            </div>

            <div class = "mychat">
                <div class = "titleBar">
                    <hr>
                    <a href="#">
                        <input type="image" src="images/PowerIcon.png" alt="Menu" height="20" width="20" onclick="setChannel(true)">
                        <script src="main.js"></script>
                    </a>
                    <p><input type="text" id="Channel" name="Channel" placeholder="Channel" value="<?php echo $channel;?>"></p>
                    <hr>
                </div>

                <?php
                $url = "index.html";
                if($blnChannelSet){
                    echo '<script type="text/javascript">setChannel(false)</script>';
                }
                ?>

                <div class = "comments">
                    <?php
                    if (isset($_SESSION['channelName']) || isset($_REQUEST['c'])) {
                        echo "<iframe id='cmtns' name='cmnts' src=$url scrolling='auto'></iframe>";
                        unset($_SESSION['channelName']);
                    }
                    else{
                        echo " Please input a channel...";
                        unset($_SESSION['channelName']);
                    }
                    ?>
                </div>

                <div class="send-message">
                    <?php $url = 'send.php?c='.$channel;
                    echo "<iframe name='msg' src=$url width='375' height='61'></iframe>";
                    ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
