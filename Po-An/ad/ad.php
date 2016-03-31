
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
$pop = $dbh->query('SELECT COUNT(DISTINCT ip) FROM popularity')

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>AD</title>
    <link href="ad.css" type="text/css" rel="stylesheet" />
</head>
<meta http-equiv="refresh" content="10">
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
    //foreach($dbh->query('SELECT * FROM channel ORDER BY frequency DESC LIMIT 1') as $row) {
        //$search = $row['word'];
    //}
    foreach($dbh->query('SELECT Keyword FROM mlg LIMIT 1') as $row) {
        $search = $row[0];
    }

}

//the category could also come from a GET if you wanted.
$category = "All";

define('AWS_API_KEY', 'AKIAJU3VVP2BZIY3Q7PQ');
define('AWS_API_SECRET_KEY', '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');
define('AWS_ASSOCIATE_ID', 't0f44b-20');

require 'lib/AmazonECS.class.php';

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


/*
echo '<div class="ad-container">';
echo '<h2>';
echo '<form method="post" action="test.php">
<p>
    <input type="text" name="search" id = "search">
    <input type="submit" value="Search">
</p>
</form><br>';
if (isset($response['Items']['Item']) ) {
    //var_dump($response['Items']['Item'][0]['DetailPageURL']);
    //var_dump($response['Items']['Item'][0]['SmallImage']['URL']);
    //var_dump($response['Items']['Item'][0]['ItemAttributes']['Title']);
    //echo "<a target='_Blank' href='" . $response['Items']['Item'][0]['DetailPageURL'] . "'>";
    //echo "<img class='shadow' style=' margin: auto; margin-left: auto; border: 1px solid black; max-height: 200px;' align='center' src='" . $response['Items']['Item'][0]['LargeImage']['URL'] . "'>";
//echo "<img class='shadow' src='". $response['Items']['Item'][0]['SmallImage']['URL'] ."'>";
    //echo "<p class='word' style=' margin: auto 1111px auto auto; border: 1px solid black;'>" . $response['Items']['Item'][0]['ItemAttributes']['Title'] . "<p/> <a/>";
//echo $response['Items']['Item'][0]['EditorialReviews']['EditorialReview']['Content'];

    //var_dump($response['Items']['Item'][0]['CurrencyCode']['FormattedPrice']);



    echo '<p>Search Keyword: ' . $search . '</p><br>';
    echo '<a href="' . $response['Items']['Item'][0]['DetailPageURL'] . '" target="_blank">' . $response['Items']['Item'][0]['ItemAttributes']['Title'];
    echo '</h2>';
    if(isset($response['Items']['Item'][0]['LargeImage']['URL'])){
        echo '<img src="'. $response['Items']['Item'][0]['LargeImage']['URL'] .'">';
    }
    if(isset($response['Items']['Item'][0]['ItemAttributes']['ListPrice']['FormattedPrice'])){
        echo '<h3>Price: ' . $response['Items']['Item'][0]['ItemAttributes']['ListPrice']['FormattedPrice'] . '</h3>' ;
    }
    echo '</a>';

}
echo '</div>';
//echo '<iframe src="http://webdev.cse.msu.edu/~tsaipoan/test/samples/test.php" name="targetframe" width="500" height="500" style="border:none" >
//    </iframe>';
//var_dump($response['Items']['Item'][0]);
//if (isset($response['Items']['Item']) ) {
//
//    //loop through each item
//    foreach ($response['Items']['Item'] as $result) {
//
//        //check that there is a ASIN code - for some reason, some items are not
//        //correctly listed. Im sure there is a reason for it, need to check.
//        if (isset($result['ASIN'])) {
//
//            //store the ASIN code in case we need it
//            $asin = $result['ASIN'];
//
//            //check that there is a URL. If not - no need to bother showing
//            //this one as we only want linkable items
//            if (isset($result['DetailPageURL'])) {
//
//                //set up a container for the details - this could be a DIV
//                //echo "<p style='". IE_BACKGROUND . ";min-height: 60px; font-size: 90%;'>";
//
//                //create the URL link
//                echo "<a target='_Blank' href='" . $result['DetailPageURL'] ."'>";
//
//                //if there is a small image - show it
//                if (isset($result['SmallImage']['URL'] )) {
//                    echo "<img class='shadow' style=' margin: 0px; margin-left: 10px; border: 1px solid black; max-height: 55px;' align='right' src='". $result['SmallImage']['URL'] ."'>";
//                }
//
//                // if there is a title - show it
//                if (isset($result['ItemAttributes']['Title'])) {
//                    echo $result['ItemAttributes']['Title'] . "<br/>";
//                }
//
//                //close the paragraph
//                echo "</p>";
//
//            }
//        }
//    }
//
//} else {
//
//    //display that nothing was found - should no results be found
//    //echo "<p  style='". IE_BACKGROUND . "'>No Amazon suggestions found</p>";
//
//}



*/


?>
<div class="ad-container">
<form method="post" action="ad.php">
    <p>
        <input type="text" name="search" id = "search">
        <input type="submit" value="Search">
    </p>
</form><br>
    <?php
    echo '<p>Search Keyword: ' . $search . '</p><br>';
    ?>
<form action='ad.post.php' method='POST'>
    <input type='hidden' name='search' value=<?php echo $search ?>>
    <input type='hidden' name='url' value=<?php echo $response['Items']['Item'][0]['DetailPageURL'] ?>>
    <button>
        <?php

        if (isset($response['Items']['Item']) ) {

            if(isset($response['Items']['Item'][0]['LargeImage']['URL'])){
                echo '<img src="'. $response['Items']['Item'][0]['LargeImage']['URL'] .'"/>';
            }
            echo '<p class="title">' . $response['Items']['Item'][0]['ItemAttributes']['Title'] . '</p>';


            if(isset($response['Items']['Item'][0]['ItemAttributes']['ListPrice']['FormattedPrice'])){
                echo '<div class="price">';
                echo '<p class="title">' . 'Price: ' . $response['Items']['Item'][0]['ItemAttributes']['ListPrice']['FormattedPrice'] . '</p>' ;
                echo '</div>';
            }


        }
        ?>
    </button>
</form>
    <p>Popularity: <?php foreach($pop as $row){ echo $row[0]; }?></p>
</div>
<br>
</body>
</html>
