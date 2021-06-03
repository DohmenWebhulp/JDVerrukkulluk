<?php

class KeukenType{

    private $connection;

    public function __construct($db){

        $this->connection = $db;

    }

    public function ophalenKeukenType($keukentype_id){

        $sql = "select * from keukentype where id = $keukentype_id";
        $result = mysqli_query($this->connection, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($row);
    }

}