<?php

class Database
{
    protected $connection = null;

    public function __construct()
    {
        try {
            $dsn = "pgsql:host=" . DB_HOST . ";dbname=" . DB_DATABASE_NAME;
            $this->connection = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Could not connect to database: " . $e->getMessage());
        }
    }

    public function select($query = "", $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function executeStatement($query = "", $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            
            if ($stmt === false) {
                throw new Exception("Unable to prepare statement: " . $query);
            }

            if ($params) {
                foreach ($params as $param) {
                    $stmt->bindParam($param['name'], $param['value'], $param['type']);
                }
            }

            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
