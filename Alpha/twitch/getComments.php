

<?php
$dsn = 'mysql:host=messagebase.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com;port=3306;dbname=messageBase';
$username = 'dBAdmin';
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


?>



<!DOCTYPE html>
<html>
<head>
<script type=text/javascript>
    function scroll(){
        var a = document.getElementById('cmnts').contentWindow;
        a.scrollTo(0,200);
    }
</script>
<title>Chat</title>
<link rel="stylesheet" type="text/css" href="topCmtStyle.css">
<meta http-Equiv="Cache-Control" Content="no-cache">
<meta http-Equiv="Pragma" Content="no-cache">
<meta http-Equiv="Expires" Content="0">
<meta http-equiv="refresh" content="0.00001">
</head>

<body>
<div class="topComments">
    <?php
    echo '<br>';
    $i = 0;
    $dbh->query('DELETE FROM '.$channel.' WHERE timeSent < NOW()-INTERVAL 20 SECOND and message<>""');
    foreach($dbh->query('SELECT * FROM '.$channel.' ORDER BY likes DESC LIMIT 5') as $row) {
        $i++;
        echo '<div class = top'.$i.'><p>'.$i.'. '.$row['username'].': '.$row['message'].'   ('.$row['likes'].' likes'.')</p></div>'; //etc...
    }
    ?>
</div>
</body>
</html>
