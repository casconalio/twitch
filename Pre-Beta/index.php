<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST['uname'];
	$pass = $_POST['oauth'];

	$username = trim($username);
	$pass = trim($pass);


	$host = "irc.twitch.tv"; //host
	$port = 6667; //port
	$sock = @fsockopen($host, $port); //open connection
	$channel = ""; //channel
	$message = ""; //channel

	if (isset($_REQUEST['c'])){
	    $channel = $_REQUEST['c'];
	}


	//echo $message;
	$message = " ";
	fputs($sock, "PASS $pass\r\n"); // input password (has to be done first)
	fputs($sock, "NICK $username\r\n"); // input user ID
	fputs($sock, "JOIN #" . $channel . "\r\n"); // join the channel
	if(!fputs($sock, "PRIVMSG #" . $channel . " :" . $message . " \n")) {
		echo "error!";
	}


	//make sure the input is good
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }



	$_SESSION['username'] = $username;
	$_SESSION['pass'] = $pass;

	//echo $email;
	//echo $pass;
	header('Location: http://35.9.22.102/beta/twitch/twitch.php');
}


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login to Twitch Pro</title>
<link rel="stylesheet" href="loginstyle.css" type="text/css" />
</head>
<body>
<center>

<div id="login-form">
<h3>Twitch Pro</h3>
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="uname" placeholder="Username" required /></td>
</tr>
<tr>
<td><input type="password" name="oauth" placeholder="Oauth Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-login">Sign In</button></td>
</tr>
<tr>
</tr>
</table>
</form>
<br>
<a href="https://twitchapps.com/tmi/">Get your OAuth password here</a>
</div>
</center>
</body>
</html>
