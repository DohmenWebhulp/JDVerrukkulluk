<?php

class Boodschappen{

    private $connection;

    private $rest;

    public function __construct($db){

        $this->connection = $db;

    }

    public function ophalenBoodschappen($user_id){

        $sql = "select * from boodschappen where user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $bdsp[] = $row;
        }
    
        return($bdsp);
    }

    public function addToList($recept_id, $user_id){

        $ingr = new Ingredient($this->connection);
        $data = $ingr->ophalenIngredient($recept_id);

        foreach($data as $value){
            $schap = $this->controlArtikel($value['artikel_id'], $user_id);
            if($schap){
                $this->editArtikel($value, $user_id, $value['Hoeveelheid'], $schap);
                //echo "Article edited in grocery list";
            }else{
                $this->addArtikel($value, $user_id, $value['Hoeveelheid']);
                //echo "Article added to grocery list";
            }
        }
    }

    private function controlArtikel($art_id, $user_id){

        //Compare existing groceries with groceries to be added or not for a specific user.

        $schap = $this->ophalenBoodschappen($user_id);

        foreach($schap as $value){
            if($value['artikel_id'] == $art_id){
                return($value);
            }
        }
        return(FALSE);
    }

    private function addArtikel($artikel, $user_id, $hoev){

        $verp = $artikel['Verpakking'];
        $art_id = $artikel['artikel_id'];
        $foto = $artikel['foto'];
        $naam = $artikel['naam'];
        $prijs = $artikel['prijs'];
        $omschr = $artikel['omschrijving'];

        $aantal = 0;

        if($hoev % $verp == 0){
            $aantal += intdiv($hoev, $verp);
        }else{
            $aantal += intdiv($hoev, $verp) + 1;
        }
        
        $sql = "INSERT INTO boodschappen (artikel_id, user_id, aantal, foto, prijs, naam, omschrijving)
        VALUES ($art_id, $user_id, $aantal, $foto, $naam, $prijs, $omschr)";
        $result = mysqli_query($this->connection, $sql);
    }

    private function editArtikel($artikel, $user_id, $hoev, $schap){

        $verp = $artikel['Verpakking'];
        $art_id = $artikel['artikel_id'];
        $aantal = $schap['aantal'];

        if($hoev % $verp == 0){
            $antl = intdiv($hoev, $verp) - $aantal;
        }else{
            $antl = intdiv($hoev, $verp) - $aantal + 1;
        }

        $sql = "UPDATE boodschappen
        SET aantal = aantal + $antl
        WHERE artikel_id = $art_id and user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);

    }

}