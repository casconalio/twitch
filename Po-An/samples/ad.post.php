<?php
$dsn = 'mysql:host=adv.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com;port=3306;dbname=AdvKeyWords';
$username = 'dbadmin';
$password = 'amazonisamazing';

$dbh = new PDO($dsn, $username, $password);

try {
    $dbh = new PDO($dsn, $username, $password);
} catch(PDOException $e) {
    die('Could not connect to the database:<br/>' . $e);
}

$dbh->query("CREATE TABLE IF NOT EXISTS popularity (ip INT);");
$ip=ip2long($_SERVER['REMOTE_ADDR']);
$dbh->query("INSERT INTO popularity(ip) VALUES(" . $ip . ");");
?>
<script type="text/javascript">
    var post = '<?=$_GET['url']?>'; // That's for a string
</script>
<?php

//$link = "<script>window.open(post)</script>";

echo $link;

?>
<form action=<?php echo $_GET['url'] ?> method='post' name='frm'>
    <?php
//    foreach ($_GET as $a => $b) {
//        echo "<input type='hidden' name='".htmlentities($a)."' value='".htmlentities($b)."'>";
//    }
    ?>
</form>
<script language="JavaScript">
    document.frm.submit();
</script>
