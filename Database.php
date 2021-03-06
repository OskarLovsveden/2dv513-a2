<?php

class Database {
    private static $user = 'admin';
    private static $password = 'root';
    private static $db = 'RC_2007-10';
    private static $host = 'localhost';
    private static $port = '3306';

    private static $subreddit = 'subreddit';
    private static $fullname = 'fullname';
    private static $postTable = 'post';

    public function __construct() {
        $this->createFullnameTableIfNotExist();
        $this->createSubredditTableIfNotExist();
        $this->createPostTableIfNotExist();
    }

    public function createDbConnection(): \mysqli {
        $conn = new mysqli(
            self::$host,
            self::$user,
            self::$password,
            self::$db,
            self::$port
        );

        $conn->options(MYSQLI_OPT_LOCAL_INFILE, TRUE);
        $conn->set_charset("utf8mb4");

        return $conn;
    }

    private function createSubredditTableIfNotExist() {
        $conn = $this->createDbConnection();

        $createTable = 'CREATE TABLE IF NOT EXISTS ' . self::$subreddit . ' (
                subreddit VARCHAR(21) NOT NULL UNIQUE,
                subreddit_id VARCHAR(50),
                PRIMARY KEY (subreddit_id)
            )';

        if ($conn->query($createTable)) {
            // TODO Add message
        } else {
            throw new \Exception("Something went wrong when trying to create subreddit to database");
        }
    }

    private function createPostTableIfNotExist() {
        $conn = $this->createDbConnection();

        $createTable = 'CREATE TABLE IF NOT EXISTS ' . self::$postTable . ' (
                id VARCHAR(50) NOT NULL,
                parent_id VARCHAR(50) NOT NULL,
                link_id VARCHAR(50) NOT NULL,
                author VARCHAR(21) NOT NULL,
                body BLOB(40000) NOT NULL,
                subreddit_id VARCHAR(50) NOT NULL,
                score INT NOT NULL,
                created_utc VARCHAR(50) NOT NULL,
                PRIMARY KEY (id),
                FOREIGN KEY (id) REFERENCES fullname(id),
                FOREIGN KEY (subreddit_id) REFERENCES subreddit(subreddit_id)
        )';

        if ($conn->query($createTable)) {
            // TODO Add message
        } else {
            throw new \Exception("Something went wrong when trying to create postTable :^) to database");
        }
    }

    private function createFullnameTableIfNotExist() {
        $conn = $this->createDbConnection();

        $createTable = 'CREATE TABLE IF NOT EXISTS ' . self::$fullname . '(
                id VARCHAR(50),
                name VARCHAR(50) NOT NULL,
                PRIMARY KEY (id)
        )';

        if ($conn->query($createTable)) {
            // TODO Add message
        } else {
            throw new \Exception("Something went wrong when trying to create fullname to database");
        }
    }
}

//' (
// id VARCHAR(50),
// parent_id VARCHAR(50),
// link_id VARCHAR(50),
// author VARCHAR(21),
// body BLOB(40000),
// subreddit_id VARCHAR(50),
// score INT,
// created_utc VARCHAR(50)
// )'

// ' (
// subreddit VARCHAR(21),
// subreddit_id VARCHAR(50)
// )'

// ' (
// id VARCHAR(50),
// parent_id VARCHAR(50),
// link_id VARCHAR(50),
// author VARCHAR(21),
// body BLOB(40000),
// subreddit_id VARCHAR(50),
// score INT,
// created_utc VARCHAR(50)
// )'
