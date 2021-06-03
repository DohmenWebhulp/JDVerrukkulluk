<?php
 
//comment

class Ingredient{

    private $connection;

    public function __construct($db){

        $this->connection = $db;

    }

    public function ophalenIngredient($recept_id){

        $retu = [];

        $sql = "select * from ingredient where recept_id = $recept_id";
        $result = mysqli_query($this->connection, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $art = $this->ophalenArtikel_ing($row['artikel_id']);
            $retu[] = array_merge($row, $art);
        }

        return($retu);
    }

    private function ophalenArtikel_ing($art_id){
        
        $artikel = new Artikel($this->connection);
        $data = $artikel->ophalenArtikel($art_id);
        
        return($data);

    }

}
//Loop over ingrediënten onder private function in klasse Recept?