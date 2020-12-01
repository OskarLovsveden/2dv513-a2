<?php
set_time_limit(300);
require_once('./Database.php');

$db = new \Database();
$dbConn = $db->getDbConnection();

echo "helllo world";

$file = __DIR__ . "/jsonData/RC_2007-10.bz2";

$start = microtime(true);

// Array for saving fields as data
$fields = array();

// Open bz2 file in "read-mode"
$bz = bzopen($file, "r");

// Read and convert bz2 to json
while (!feof($bz)) {
    $line = fgets($bz);
    $obj = json_decode($line);

    $fields[] = array(
        $obj->id,
        $obj->parent_id,
        $obj->link_id,
        $obj->author,
        $obj->body,
        $obj->subreddit_id,
        $obj->score,
        $obj->created_utc
    );
}

// Close bz2 file
bzclose($bz);

// Use csv file
// $path = "posts.csv";
// $fp = fopen($path, "w");

// Use temp file with csv prefix
$path = tempnam('/tmp/php', 'csv');
$fp = fopen($path, 'w');

foreach ($fields as $field) {
    fputcsv($fp, $field);
}

// Close file
fclose($fp);

if (!$dbConn->query(
    "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($dbConn, $path) . "' INTO TABLE post FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"'"
)) {
    echo $dbConn->error;
}

// Remove file if using csv file
// unlink($path);

// Remove temp file with csv prefix
unlink($path);

$time_elapsed_secs = microtime(true) - $start;
// echo $time_elapsed_secs;