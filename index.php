<?php
set_time_limit(300);

require_once('Database.php');
require_once('TableMaker.php');
require_once('TableExporter.php');

echo "helllo world";

$db = new \Database();
$tableMaker = new \TableMaker();
$tableExporter = new \TableExporter($db);

// Data
$file = __DIR__ . "/jsonData/RC_2007-10.bz2";

// Start time
$start = microtime(true);

// Open bz2 file in "read-mode"
$bz = bzopen($file, "r");

// Read bz2
while (!feof($bz)) {
    $line = fgets($bz);
    $obj = json_decode($line);

    // Pass PHP object to TableMaker to be filtered
    $tableMaker->addToPostFields($obj);
    $tableMaker->addToFullnameFields($obj);
    $tableMaker->addToSubredditFields($obj);
}

// Close bz2 file
bzclose($bz);

// Get arrays of fields
$posts = $tableMaker->getPostFields();
$fullnames = $tableMaker->getFullnameFields();
$subreddits = $tableMaker->getSubredditFields();

// Export tables into DB via TableExporter
$tableExporter->exportToDB($posts, 'post');
$tableExporter->exportToDB($fullnames, 'fullname');
$tableExporter->exportToDB($subreddits, 'subreddit');

// Calculate time
$time_elapsed_secs = microtime(true) - $start;
// echo $time_elapsed_secs;