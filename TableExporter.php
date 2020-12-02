<?php

class TableExporter {
    private $db;

    public function __construct(\Database $database) {
        $this->db = $database;
    }

    public function exportToDB($name) {

        // NR 1
        $conn1 = $this->db->createDbConnection();
        if (!$conn1->query(
            "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($conn1, $name) . "' INTO TABLE post FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' IGNORE 1 LINES (id,  @dummy, parent_id, link_id, author, body, subreddit_id, @dummy, score, created_utc)"
        )) {
            echo $conn1->error;
        }
        mysqli_close($conn1);

        // NR 2
        $conn2 = $this->db->createDbConnection();
        if (!$conn2->query(
            "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($conn2, $name) . "' INTO TABLE fullname FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' IGNORE 1 LINES (id, name, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)"
        )) {
            echo $conn2->error;
        }
        mysqli_close($conn2);

        // NR 3
        $conn3 = $this->db->createDbConnection();
        if (!$conn3->query(
            "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($conn3, $name) . "' INTO TABLE subreddit FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' IGNORE 1 LINES (@dummy,  @dummy, @dummy, @dummy, @dummy, @dummy, subreddit_id, subreddit, @dummy, @dummy)"
        )) {
            echo $conn3->error;
        }
        mysqli_close($conn3);
    }
}
