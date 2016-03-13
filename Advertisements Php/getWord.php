<?php

// http://getWord.php?c=
// add channel name behind the link above

$dsn = 'mysql:host=adv.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com;port=3306;dbname=AdvKeyWords';
$username = 'dbadmin';
$password = 'amazonisamazing';
$channel;

if (isset($_REQUEST['c'])){
    $channel = $_REQUEST['c'];
}

$dbh = new PDO($dsn, $username, $password);

try {
    $dbh = new PDO($dsn, $username, $password);
} catch(PDOException $e) {
    die('Could not connect to the database:<br/>' . $e);
}


//the query below gets the most popular word
foreach($dbh->query('SELECT * FROM '.$channel.' ORDER BY frequency DESC LIMIT 1') as $row) {
    echo "<br>";
    echo $row['word'];
}
?>
