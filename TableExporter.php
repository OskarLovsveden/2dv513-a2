<?php

class TableExporter {
    private $connection;
    // private $db;

    // Use csv file
    // private static $path = "posts.csv";

    // Use temp file with csv prefix
    private static $path = '/tmp/php';
    private static $prefix = 'csv';
    private static $mode = 'w';

    public function __construct(\Database $database) {
        $this->connection = $database->getDbConnection();
        // $this->db = $database;
    }

    public function exportToDB(array $toBeExported, string $table) {
        // $conn = $this->db->createDbConnection();
        // $conn->options(MYSQLI_OPT_LOCAL_INFILE, TRUE);

        $name = tempnam(self::$path, self::$prefix);
        $fp = fopen($name, self::$mode);

        foreach ($toBeExported as $field) {
            fputcsv($fp, $field);
        }

        // Close file
        fclose($fp);

        if (!$this->connection->query(
            "LOAD DATA LOCAL INFILE '" . mysqli_escape_string($this->connection, $name) . "' INTO TABLE $table FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"'"
        )) {
            echo $this->connection->error;
        }

        // Remove file
        unlink($name);
    }
}
