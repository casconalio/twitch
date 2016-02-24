

<?php
$dsn = 'mysql:host=messagebase.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com;port=3306;dbname=messageBase';
$username = 'dBAdmin';
$password = 'amazonisamazing';

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
<meta http-equiv="refresh" content="5">
</head>

<body>
<div class="topComments">
  <p>
    <?php
    foreach($dbh->query('SELECT * FROM likedMessages') as $row) {
        echo "<br>";
        echo "<p>".$row['ID'].' '.$row['message']."</p>"; //etc...
    }

    ?>

  </p>
</div>
</body>
</html>
