<?php

class TableExporter {
    private $db;
    private static $file = __DIR__ . "/jsonData/RC_2011-07.bz2";
    private static $titles = array(
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

    public function __construct(\Database $database) {
        $this->db = $database;
    }

    public function uploadToDb() {
        $start = microtime(true);

        $name = tempnam('/tmp/php', 'csv');
        $fp = fopen($name, 'w');

        fputcsv($fp, self::$titles);

        $bz = bzopen(self::$file, "r");

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

        fclose($fp);
        bzclose($bz);

        // TEST
        $this->exportToDB($name);

        // UNLINK TEST
        unlink($name);

        // Calculate time
        $time_elapsed_secs = microtime(true) - $start;
        echo $time_elapsed_secs;
    }

    private function exportToDB($name) {

        // NR 2
        $conn1 = $this->db->createDbConnection();
        if (!$conn1->query(
            "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($conn1, $name) . "' INTO TABLE fullname FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES (id, name, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)"
        )) {
            echo $conn1->error;
        }
        mysqli_close($conn1);

        // NR 2
        $conn2 = $this->db->createDbConnection();
        if (!$conn2->query(
            "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($conn2, $name) . "' INTO TABLE subreddit FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES (@dummy,  @dummy, @dummy, @dummy, @dummy, @dummy, subreddit_id, subreddit, @dummy, @dummy)"
        )) {
            echo $conn2->error;
        }
        mysqli_close($conn2);

         // NR 1
         $conn3 = $this->db->createDbConnection();
         if (!$conn3->query(
             "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($conn3, $name) . "' INTO TABLE post FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 3 LINES (id,  @dummy, parent_id, link_id, author, body, subreddit_id, @dummy, score, created_utc)"
         )) {
             echo $conn3->error;
         }
         mysqli_close($conn3);
    }
}
