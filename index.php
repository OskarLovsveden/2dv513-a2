<?php
set_time_limit(0);
// ignore_user_abort(1);
// ini_set('mysql.connect_timeout', -1);
// ini_set('default_socket_timeout', -1);

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

