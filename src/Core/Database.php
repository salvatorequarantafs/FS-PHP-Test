<?php

namespace App\Core;

class Database extends \PDO 
{
    protected $config;

    public function __construct()
    {
        try {
            if (!file_exists(CONFIG_DIR . "/database.php")) {
                throw new \PDOException('Database config file missing');
            }

            $this->configs = require(CONFIG_DIR . "/database.php");

            $dsn = 
                $this->configs['engine'] .
                ":host=" . $this->configs['host'] .
                ";dbname=" . $this->configs['dbname'];

            parent::__construct($dsn, $this->configs['username'], $this->configs['password']);
            $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            header("HTTP/1.1 500 Internal Server Error");
            die("An error has occurred while connecting to the database.");
        }
    }
}