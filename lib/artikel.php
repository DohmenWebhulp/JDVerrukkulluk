<?php

class Artikel {

    private $connection;

    public function __construct($db) {
        $this->connection = $db;
    }

    public function ophalenArtikel($artikel_id) {

        $sql = "select * from artikel where id = $artikel_id";
        $result = mysqli_query($this->connection, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        //echo "<pre>";
        //var_dump($row);
        return($row);
    }

}