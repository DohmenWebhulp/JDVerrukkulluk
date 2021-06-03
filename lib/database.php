<?php


class database {

    private $connection;

    public function __construct() {
       $this->connection =  mysqli_connect('127.0.0.1', 
                                           'root', 
                                           ini_get("mysqli.default_pw") , 
                                           'verruk');
    }

    public function getConnection() {
        return($this->connection);
    }

}