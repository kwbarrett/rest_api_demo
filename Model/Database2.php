<?php
class Database
{
    protected $connection = null;

    public function __construct()
    {
        try {
            $this->connection = pg_connect("host=" . DB_HOST . " dbname=" . DB_DATABASE_NAME . " user=" . DB_USERNAME . " password=" . DB_PASSWORD);
            
            if (!$this->connection) {
                throw new Exception("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function select($query = "", $params = [])
    {
        try {
            $result = $this->executeStatement($query, $params);
            $rows = pg_fetch_all($result);
            pg_free_result($result);
            return $rows;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function executeStatement($query = "", $params = [])
    {
        try {
            $result = pg_query_params($this->connection, $query, $params);
            
            if ($result === false) {
                throw new Exception("Unable to execute query: " . $query);
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>