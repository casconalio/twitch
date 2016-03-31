<?php



if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST['uname'];
	$pass = $_POST['oauth'];

	$username = trim($username);
	$pass = trim($pass);


	//echo $email;
	//echo $pass;
}


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login to Twitch Pro</title>
<link rel="stylesheet" href="style.css" type="text/css" />
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
