<?php
set_time_limit(0);
// ignore_user_abort(1);
// ini_set('mysql.connect_timeout', -1);
// ini_set('default_socket_timeout', -1);

require_once('Database.php');
require_once('TableExporter.php');

echo "helllo world";

$db = new \Database();
$tableExporter = new \TableExporter($db);

// Data
$file = __DIR__ . "/jsonData/RC_2011-07.bz2";

// Start time
$start = microtime(true);

// TEST
$titles = array(
    'id',
    'name',
    'parent_id',
    'link_id',
    'author',
    'body',
    'subreddit_id',
    'subreddit',
    'score',
    'created_utc'
);

// Create and open tempfile
$name = tempnam('/tmp/php', 'csv');
$fp = fopen($name, 'w');

// Write titles
fputcsv($fp, $titles);

// Open bz2 file in "read-mode"
$bz = bzopen($file, "r");

// Read bz2
while (!feof($bz)) {
    $line = fgets($bz);

    // TEST
    $obj = json_decode($line);

    $arr = array(
        $obj->id,
        $obj->name,
        $obj->parent_id,
        $obj->link_id,
        $obj->author,
        $obj->body,
        $obj->subreddit_id,
        $obj->subreddit,
        $obj->score,
        $obj->created_utc
    );

    fputcsv($fp, $arr);
}

// CLOSE TEST
fclose($fp);

// Close bz2 file
bzclose($bz);

// TEST
$tableExporter->exportToDB($name);

// UNLINK TEST
unlink($name);

// Calculate time
$time_elapsed_secs = microtime(true) - $start;
echo $time_elapsed_secs;
