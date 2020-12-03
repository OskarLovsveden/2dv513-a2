<?php
set_time_limit(0);

require_once('Database.php');
require_once('TableExporter.php');

echo "helllo world";

try {
    $db = new \Database();
    $tableExporter = new \TableExporter($db);

    // WHEN WE NEED TO UPLOAD STUFF
    $tableExporter->uploadToDb();
} catch (\Throwable $th) {
    echo $th;
}
