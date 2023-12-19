<?php

require_once PROJECT_ROOT_PATH . '/Model/Database.php';

class UserModel extends Database{
    public function getUsers( $limit ){
        return $this->select(
            "SELECT *
            FROM
                users
            ORDER BY
                user_id ASC LIMIT ?" , [ "i", $limit ]
        );
    }

    public function getUser( $id ){
        return $this->select(
            "
            SELECT *
            FROM
                users
            WHERE
                user_id = ${id}
            "
            
        );
    }

    public function getUsers2(){
        $query = "SELECT *
            FROM users
            ORDER BY user_id ASC
            LIMIT $1";
        $params = array($limit);

        $result = pg_query_params($your_postgres_connection, $query, $params);
    }
}

?>