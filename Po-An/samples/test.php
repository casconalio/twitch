
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

$dbh->query("CREATE TABLE IF NOT EXISTS popularity (ip INT)");
$ip=$_SERVER['REMOTE_ADDR'];
$dbh->query("INSERT INTO popularity(ip) VALUES(" . $ip . ")");
$pop = $dbh->query('SELECT COUNT(DISTINCT ip) FROM popularity');
$pop_num = 0;
foreach ($pop as $row) {
    $pop_num = $row[0];
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>AD</title>
    <link href="ad.css" type="text/css" rel="stylesheet" />
</head>
<meta http-equiv="refresh" content="1">
<body>
<?php
//find what we are searching for using GET
if(isset($_POST['search']) && $_POST['search'] != '')
{
    $search = $_POST['search'];
}
else
{
    //$search = 'HyperX headset';
    $search = 'fire';
    $channel;
    if (isset($_REQUEST['c'])){
        $channel = $_REQUEST['c'];
    }
    try {
        $dbh = new PDO($dsn, $username, $password);
    } catch(PDOException $e) {
        die('Could not connect to the database:<br/>' . $e);
    }
//the query below gets the most popular word
//    foreach($dbh->query('SELECT * FROM channel ORDER BY frequency DESC LIMIT 1') as $row) {
//        $search = $row['word'];
//    }
//    foreach($dbh->query('SELECT Keyword FROM mlg LIMIT 1') as $row) {
//        $search = $row[0];
//    }

//    foreach($dbh->query('SELECT * FROM channel ORDER BY RAND() DESC LIMIT 1') as $row) {
//        $search = $row['word'];
//    }

    foreach($dbh->query('SELECT Keyword FROM trumpsc LIMIT 1') as $row) {
        $search = $row[0];
    }

    $dbh->query('UPDATE trumpsc SET popularity=' . $pop_num . ' WHERE Keyword="' . $search . '"');
    
    

}

//the category could also come from a GET if you wanted.
$category = "All";

define('AWS_API_KEY', 'AKIAJU3VVP2BZIY3Q7PQ');
define('AWS_API_SECRET_KEY', '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');
define('AWS_ASSOCIATE_ID', 't0f44b-20');

require '../lib/AmazonECS.class.php';

//declare the amazon ECS class
$amazonEcs = new AmazonECS(AWS_API_KEY, AWS_API_SECRET_KEY, 'com', AWS_ASSOCIATE_ID);
$amazonEcs->page(1);
//tell the amazon class that we want an array, not an object
$amazonEcs->setReturnType(AmazonECS::RETURN_TYPE_ARRAY);

///create the amazon object (array)
//$response = $amazonEcs->category($category)->responseGroup('Small,Images,Offers')->search($search);
//$client = new AmazonECS('YOUT API KEY', 'YOUR SECRET KEY', 'DE', 'YOUR ASSOCIATE TAG');

//$response  = $amazonEcs->page(1)->category('Books')->responseGroup('Large,Images,Offers')->search('PHP 5');
$response = $amazonEcs->category($category)->responseGroup('Large')->search($search);
//check that there are items in the response

?>


<div class="ad-container">
    <div class="popularity">
        <?php
        if (isset($response['Items']['Item']) ) {
            echo '<img class="thumb" src="../pic/thumbsUp.png">';

            $dark_pos = 20 - $pop_num;
            for ($i = 1; $i <= 20; $i++) {
                if ($i <= $dark_pos) {
                    echo '<img class="light" src="../pic/lightOvalSmall.png" style="position: relative; top: -' . 10 * $i . 'px">';
                } else {
                    echo '<img class="light" src="../pic/darkOvalSmall.png" style="position: relative; top: -' . 10 * $i . 'px">';
                }
            }
        }
        ?>
    </div>
    <?php
    if (isset($response['Items']['Item']) ) {
        echo '<a target="_blank" href="ad.post.php?search=<?php echo $search ?>&url=' . $response['Items']['Item'][0]['DetailPageURL'] . '">';
    }
    ?>
        <div class="ad">
            <div class="pic">
                <?php
                if (isset($response['Items']['Item']) ) {
                    if (isset($response['Items']['Item'][0]['LargeImage']['URL'])) {
                        echo '<img class="ad-pic" src="' . $response['Items']['Item'][0]['LargeImage']['URL'] . '"/>';
                    }
                }
                ?>
            </div>
            <div class="text">
                <div class="title">
                    <?php
                    if (isset($response['Items']['Item']) ) {
                        echo '' . $response['Items']['Item'][0]['ItemAttributes']['Title'] . '';
                    }
                    ?>
                </div>
                <div class="price">
                    <?php
                    if (isset($response['Items']['Item']) ) {
                        if (isset($response['Items']['Item'][0]['ItemAttributes']['ListPrice']['FormattedPrice'])) {
                            echo '' . 'Price: ' . $response['Items']['Item'][0]['ItemAttributes']['ListPrice']['FormattedPrice'] . '';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    if (isset($response['Items']['Item']) ) {
        echo '</a>';
    }
    ?>
</div>

</body>
</html>
