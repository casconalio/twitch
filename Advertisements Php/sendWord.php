<?php
//session_start();
$submitted = false;
$keyword;
$channel;

if (isset($_REQUEST['k'])){
    $keyword = $_REQUEST['k'];
}

if (isset($_REQUEST['c'])){
    $channel = $_REQUEST['c'];
}

else{
    echo "not set";
    exit;
}

echo "message ".$keyword."<br>";
echo "channel ".$channel."<br>";

$dsn = 'mysql:host=adv.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com;port=3306;dbname=AdvKeyWords';
$username = 'dbadmin';
$password = 'amazonisamazing';

$dbh = new PDO($dsn, $username, $password);

try {
    $dbh = new PDO($dsn, $username, $password);
    //echo "connected!<br>";
} catch(PDOException $e) {
    die('Could not connect to the database:<br/>' . $e);
}

$dbh->query("CREATE TABLE IF NOT EXISTS ".$channel." (
	timeSent TIMESTAMP,
    word VARCHAR(128) PRIMARY KEY,
    frequency INT
)");

$dbh->query("INSERT INTO ".$channel." (timeSent, word, frequency) VALUES (NOW(), '".$keyword."', 1) ON duplicate key update frequency = frequency + '1'");

/*
foreach($dbh->query('SELECT * FROM'.$message) as $row) {
    echo "<br>";
    echo $row['timeSent'].' '.$row['message'].' '.$row['likes'].' '.$row['username']; //etc...
}
*/
?>
