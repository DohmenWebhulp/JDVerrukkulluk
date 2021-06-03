<?php

class GerechtInfo{

    private $connection;
    
    public function __construct($db){

        $this->connection = $db;

    }

    public function ophalenBOWF($recept_id, $rec_type){

        $info = [];
        $sql = "select * from gerecht_info where recept_id = $recept_id and record_type = '$rec_type' ";
        $result = mysqli_query($this->connection, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            if($rec_type == 'O' or $rec_type == 'F'){
                $user = $this->ophalenUser_info($row['user_id']);
                $info[] = array_merge($row, $user);
            }else{
                $info[] = $row;
            }
            
        }

        return($info);
    }

    private function ophalenUser_info($user_id){

        $user = new User($this->connection);
        $data = $user->ophalenUser($user_id);
        
        return($data);
    }

    public function addFavoriet($recept_id, $user_id, $datum){

        //user_id must not already be in database system with record_type 'F'.

        $favo = $this->ophalenBOWF($recept_id, 'F');
        $colmn = array_column($favo, 'user_id');
        $bool = FALSE;

        foreach($colmn as $value){

            if($value == $user_id){
                $bool = TRUE;
            }
        }

        if(!$bool){
            $sql = "INSERT INTO gerecht_info (record_type, recept_id, user_id, datum)
            VALUES ('F', $recept_id, $user_id, '$datum')";
            $result = mysqli_query($this->connection, $sql);
            echo "User stored in database";
        }else{
            echo "User already in database";
        }
    }

    public function removeFavoriet($recept_id, $user_id){

        //user_id must be inside the database with record_type 'F'.

        $favo = $this->ophalenBOWF($recept_id, 'F');
        $colmn = array_column($favo, 'user_id');
        $bool = FALSE;

        foreach($colmn as $value){

            if($value == $user_id){
                $bool = TRUE;
            }
        }

        if($bool){
            $sql = "DELETE FROM gerecht_info WHERE record_type = 'F' and user_id = $user_id";
            $result = mysqli_query($this->connection, $sql);
            echo "User removed from database";
        }else{
            echo "User not found in database";
        }
    }

    public function addWaardering($recept_id, $waarde, $datum){

        $sql = "INSERT INTO gerecht_info (record_type, recept_id, datum, stap_of_aantal)
        VALUES ('W', $recept_id, '$datum', $waarde)";
        $result = mysqli_query($this->connection, $sql);
        echo "Rating stored in database";

        return($result);

    }
}