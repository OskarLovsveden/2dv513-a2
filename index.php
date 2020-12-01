<?php
set_time_limit(300);
require_once('./Database.php');

$db = new \Database();
$dbConn = $db->getDbConnection();

echo "helllo world";

$file = __DIR__."/jsonData/RC_2007-10.bz2";
// Ta grejer från fil

$bz = bzopen($file, "r");
$start = microtime(true);
$count = 0;
$arrayen = array();
// Read bz2
while (!feof($bz)) {
    $line = fgets($bz);
    $obj = json_decode($line);

    $arrayen[] = array(
        $obj->id,
        $obj->name
    );
    $count++;
}
bzclose($bz);

$csv = __DIR__."/jsonData/posts.csv";
echo $csv;

/* $fp = fopen($csv, "w");
foreach ($arrayen as $fields) {
    fputcsv($fp, $fields);
} */
/* 
$obj->parent_id,
$obj->link_id,
$obj->author,
$obj->body,
$obj->subreddit_id,
$obj->score,
$obj->created_utc */
/* fclose($fp); */

if (!$dbConn->query(
    "LOAD DATA LOCAL INFILE '". mysqli_escape_string($dbConn, $csv) ."' INTO TABLE fullname FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n'"
)) 
{
    echo $dbConn->error . " HEJ";
}

$time_elapsed_secs = microtime(true) - $start;
/* echo $count;
echo "</br>";
echo $time_elapsed_secs; */


// JsonToSQLstuff

// create post

// insert (post)

//  insert int