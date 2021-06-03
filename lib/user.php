<?php

class User{

    private $connection;

    public function __construct($db){

        $this->connection = $db;

    }

    public function ophalenUser($user_id){

        $sql = "select * from user where id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        //var_dump($row);
        return($row);
    }

}