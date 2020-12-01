<?php

class Database {
    private static $user = 'admin';
    private static $password = 'root';
    private static $db = 'reddit';
    private static $host = 'localhost';
    private static $port = '3306';

    private static $postTable = 'post';
    private static $subreddit = 'subreddit';
    private static $fullname = 'fullname';

    public function __construct() {
        $this->dbConnection = $this->createDbConnection();

        if ($this->dbConnection->connect_error) {
            die("Connection failed: " . $this->dbConnection->connect_error);
        }

        $this->dbConnection->options(MYSQLI_OPT_LOCAL_INFILE, TRUE);

        $this->createFullnameTableIfNotExist();
        $this->createPostTableIfNotExist();
        $this->createSubredditTableIfNotExist();
    }

    public function getDbConnection(): \mysqli {
        return $this->dbConnection;
    }

    private function createDbConnection(): \mysqli {
        return new mysqli(
            self::$host,
            self::$user,
            self::$password,
            self::$db,
            self::$port
        );
    }

    private function createSubredditTableIfNotExist() {
        $createTable = 'CREATE TABLE IF NOT EXISTS ' . self::$subreddit . ' (
                subreddit_id VARCHAR(50),
                subreddit VARCHAR(21)
            )';

        if ($this->dbConnection->query($createTable)) {
            // TODO Add message
        } else {
            throw new \Exception("Something went wrong when trying to create todo table to database");
        }
    }

    private function createPostTableIfNotExist() {
        $createTable = 'CREATE TABLE IF NOT EXISTS ' . self::$postTable . ' (
                id VARCHAR(50),
                parent_id VARCHAR(50),
                link_id VARCHAR(50),
                author VARCHAR(21),
                body BLOB(40000),
                subreddit_id VARCHAR(50),
                score INT,
                created_utc VARCHAR(50)
        )';

        if ($this->dbConnection->query($createTable)) {
            // TODO Add message
        } else {
            throw new \Exception("Something went wrong when trying to create postTable :^) to database");
        }
    }

    private function createFullnameTableIfNotExist() {
        $createTable = 'CREATE TABLE IF NOT EXISTS ' . self::$fullname . ' (
                id VARCHAR(50),
                name VARCHAR(50)
            )';

        if ($this->dbConnection->query($createTable)) {
            // TODO Add message
        } else {
            throw new \Exception("Something went wrong when trying to create todo table to database");
        }
    }
}
