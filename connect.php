
<?php
    var_dump($_POST);



    $dbhost = $_SERVER['dirtybase.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com'];
    $dbport = $_SERVER['3306'];
    $dbname = $_SERVER['dirtyBase'];

    //$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
    //$username = $_SERVER['dBAdmin'];
    //$password = $_SERVER['amazonisamazing'];

    $dsn = 'mysql:host=dirtybase.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com;port=3306;dbname=dirtyBase';
    $username = 'dBAdmin';
    $password = 'amazonisamazing';



    //$dbh = new PDO($dsn, $username, $password);
    try {
        $dbh = new PDO($dsn, $username, $password);
        echo "connected!<br>";
    } catch(PDOException $e) {
        die('Could not connect to the database:<br/>' . $e);
    }
    echo "Running query...<br>";

    echo "Creating MySql commands...<br>";
    //$stmt = $dbh->prepare('SELECT * FROM words WHERE level < 2');

    //$result = $dbh->query($statement);


    echo "retrieving bad words with a level smaller than 2...";
    foreach($dbh->query('SELECT * FROM words WHERE level < 2') as $row) {
        echo "<br>";
        echo $row['level'].' '.$row['word']; //etc...

    }



?>
</pre>
