<?php
include_once "DbConfig.php";

class Crud
{
    private $conn;
    public function __construct()
    {    
        $connection = new DbConfig(); 
        $this->conn = $connection->getDbConnection();
    }

    public function create($dataArray, $table)
    {
        $columns = implode(',', array_keys($dataArray));
        $placeHolders = ':' . implode(',:', array_keys($dataArray));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeHolders)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($dataArray);

        return $this->conn->lastInsertId();
    }

    public function read($sqlQuery)
    {
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($sqlQuery)
    {
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
    }

    public function update($sqlQuery)
    {
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
    }

    public function query($sqlQuery)
    {
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
    }


}
