<?php

class TableExporter {
    private $connection;

    private static $path = '/tmp/php';
    private static $prefix = 'csv';
    private static $mode = 'w';

    private static $id = 'id';
    private static $name = 'name';
    private static $parentId = 'parent_id';
    private static $linkId = 'link_id';
    private static $author = 'author';
    private static $body = 'body';
    private static $subredditId = 'subreddit_id';
    private static $subreddit = 'subreddit';
    private static $score = 'score';
    private static $createdUtc = 'created_utc';

    public function __construct(\Database $database) {
        $this->connection = $database->getDbConnection();
    }

    public function exportToDB($name) {
        // $name = tempnam(self::$path, self::$prefix);
        // $fp = fopen($name, self::$mode);

        // $titles = array(
        //     self::$id,
        //     self::$name,
        //     self::$parentId,
        //     self::$linkId,
        //     self::$author,
        //     self::$body,
        //     self::$subredditId,
        //     self::$subreddit,
        //     self::$score,
        //     self::$createdUtc
        // );

        // fputcsv($fp, $titles);

        // foreach ($toBeExported as $field) {
        //     fputcsv($fp, $field);
        // }

        // Close file
        // fclose($fp);

        if (!$this->connection->query(
            "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($this->connection, $name) . "' INTO TABLE post FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' IGNORE 1 LINES (id,  @dummy, parent_id, link_id, author, body, subreddit_id, @dummy, score, created_utc)"
        )) {
            echo $this->connection->error;
        }

        if (!$this->connection->query(
            "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($this->connection, $name) . "' INTO TABLE fullname FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' IGNORE 1 LINES (id, name, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)"
        )) {
            echo $this->connection->error;
        }

        if (!$this->connection->query(
            "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($this->connection, $name) . "' INTO TABLE subreddit FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' IGNORE 1 LINES (@dummy,  @dummy, @dummy, @dummy, @dummy, @dummy, subreddit_id, subreddit, @dummy, @dummy)"
        )) {
            echo $this->connection->error;
        }

        // Remove file
        // unlink($name);
    }
}
