<?php

namespace DataConfig\Model\Config;

class DbConfig
{
    function getDbConnection()
    {
        $servername = "mysql";
        $username = "root";
        $password = "scandiwebDatabase#";
        $dbname = "scandiweb";

        try {
            $conn = new \PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);

            // Set the PDO error mode to exception
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
