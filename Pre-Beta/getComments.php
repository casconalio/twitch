

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
<meta http-Equiv="Cache-Control" Content="no-cache">
<meta http-Equiv="Pragma" Content="no-cache">
<meta http-Equiv="Expires" Content="0">
<style>
html, body, header, footer, nav, article, section, figure,
figcaption, h1, h2, h3, ul, li, body, div, p, img {
    margin: 0;
    padding: 0;
    font-size: 100%;
    vertical-align: baseline;
    border: 0;
}


.top1 {
  color: #6441a5;
  padding-left: 0.5em;
  font-family: "arial";
  font-size: 1em;
}

.top2 {
  color: #7556af;
  padding-left: 0.5em;
  font-family: "arial";
  font-size: 1em;
}

.top3 {
  color: #866bb9;
  padding-left: 0.5em;
  font-family: "arial";
  font-size: 1em;
}

.top4 {
  color: #9780c3;
  padding-left: 0.5em;
  font-family: "arial";
  font-size: 1em;
}

.top5 {
  color: #a895cd;
  padding-left: 0.5em;
  font-family: "arial";
  font-size: 1em;
}

p {
  padding-left: 0.5em;
  font-family: "arial";
  font-size: 1em;
}

</style>
</head>

<body>
<div class="topComments">
    <?php
    
    $i = 0;
    $dbh->query('DELETE FROM '.$channel.' WHERE timeSent < NOW()-INTERVAL 20 SECOND and message<>""');
    //$res = $dbh->query('SELECT * FROM '.$channel.' ORDER BY likes DESC LIMIT 5');
    $result = array();

    foreach($dbh->query('SELECT * FROM '.$channel.' ORDER BY likes DESC LIMIT 5') as $row) {
        $i++;
        echo '<div class = top'.$i.'><p>'.$i.'. '.$row['username'].': '.$row['message'].'   ('.$row['likes'].' likes'.')</p></div>'; //etc...
        //array_push($result, array("message" => $row['message']));


    }

    //echo json_encode($result);
    ?>
</div>
</body>
</html>
