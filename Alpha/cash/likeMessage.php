<?php
//session_start();
$submitted = false;
$message;
$channel;
$user;
if (isset($_REQUEST['m'])){
    $message = $_REQUEST['m'];
}

if (isset($_REQUEST['c'])){
    $channel = $_REQUEST['c'];
}

if (isset($_REQUEST['u'])){
    $user = $_REQUEST['u'];
}

else{
    echo "not set";
    exit;
}

echo "message ".$message."<br>";
echo "channel ".$channel."<br>";
echo "user ".$user."<br>";




$dbhost = $_SERVER['messagebase.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com'];
$dbport = $_SERVER['3306'];
$dbname = $_SERVER['messageBase'];

//$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
//$username = $_SERVER['dBAdmin'];
//$password = $_SERVER['amazonisamazing'];

$dsn = 'mysql:host=messagebase.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com;port=3306;dbname=messageBase';
$username = 'dBAdmin';
$password = 'amazonisamazing';



$dbh = new PDO($dsn, $username, $password);

try {
    $dbh = new PDO($dsn, $username, $password);
    //echo "connected!<br>";
} catch(PDOException $e) {
    die('Could not connect to the database:<br/>' . $e);
}


$cmd = "CREATE TABLE IF NOT EXISTS ".$channel."(
	timeSent TIMESTAMP,
    message VARCHAR(128) PRIMARY KEY,
    likes INT,
    username VARCHAR(45)
)";



$dbh->query("CREATE TABLE IF NOT EXISTS ".$channel." (
	timeSent TIMESTAMP,
    message VARCHAR(128) PRIMARY KEY,
    likes INT,
    username VARCHAR(45)
)");

$dbh->query("INSERT INTO ".$channel." (timeSent, message, likes, username) VALUES (NOW(), '".$message."', 1, '".$user."') ON duplicate key update likes = likes + '1'");

/*
foreach($dbh->query('SELECT * FROM'.$message) as $row) {
    echo "<br>";
    echo $row['timeSent'].' '.$row['message'].' '.$row['likes'].' '.$row['username']; //etc...
}
*/
?>
