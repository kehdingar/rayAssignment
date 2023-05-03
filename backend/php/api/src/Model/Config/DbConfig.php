<?php

namespace DataConfig\Model\Config;

require '../../vendor/autoload.php';

$path = '../../../php_variables.env';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__,$path);
$dotenv->load();

class DbConfig
{
    function getDbConnection()
    {
        $servername = $_ENV['DB_SERVERNAME'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        $dbname = $_ENV['DB_NAME'];
        
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
