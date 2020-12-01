<?php
set_time_limit(300);
require_once('./Database.php');

$db = new \Database();
$dbConn = $db->getDbConnection();

echo "helllo world";

$file = __DIR__ . "/jsonData/RC_2007-10.bz2";
// Ta grejer från fil

$bz = bzopen($file, "r");
$start = microtime(true);
$count = 0;
$arrayen = array();

$lineStart = 'xxx_csv_start';

// Read bz2
while (!feof($bz)) {
    $line = fgets($bz);
    $obj = json_decode($line);

    $arrayen[] = array(
        // $lineStart . $obj->id,
        $obj->id,
        $obj->parent_id,
        $obj->link_id,
        $obj->author,
        $obj->body,
        $obj->subreddit_id,
        $obj->score,
        $obj->created_utc
    );
    $count++;
}
bzclose($bz);

$posts = __DIR__ . "/jsonData/posts.csv";
$postTable = 'post';

// $fullname = __DIR__ . "/jsonData/fullname.csv";
// $fullnameTable = 'fullname';

// $subreddit = __DIR__ . "/jsonData/subreddit.csv";
// $subredditTable = 'subreddit';

$fp = fopen($posts, "w");
foreach ($arrayen as $fields) {
    fputcsv($fp, $fields);
}
fclose($fp);

if (!$dbConn->query(
    "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($dbConn, $posts) . "' INTO TABLE $postTable FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"'"
    // "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($dbConn, $posts) . "' INTO TABLE $postTable FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES STARTING BY '$lineStart'"
)) {
    echo $dbConn->error;
}

$time_elapsed_secs = microtime(true) - $start;
/* echo $count;
echo "</br>";
echo $time_elapsed_secs; */


// JsonToSQLstuff

// create post

// insert (post)

//  insert int