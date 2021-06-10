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
    
        return($row);
    }

    public function ophalenUsers($user_id = NULL){

        $users = [];
        $sql = "select * from user";

        if(!is_null($user_id)){
            $sql = "select * from user where id = $user_id";
        }
        
        $result = mysqli_query($this->connection, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $users[] = $row;
        }
    
        return($users);
    }

    public function addUser($gnaam, $email){

        //New user is not allowed same username OR email-adres as one found in database.
        //User only gets added if not already found in database.

        $users = $this->ophalenUsers();

        $bool = FALSE;

        foreach($users as $user){

            if(($user['Gebruikersnaam'] == $gnaam) or ($user['Emailadres'] == $email)){

                $bool = TRUE;
                $uid = $user['ID'];
                
            }
        }

        if(!$bool){

            $new_id = count($users) + 1;

            $sql = "INSERT INTO user (ID, Gebruikersnaam, Wachtwoord, Emailadres)
            VALUES ($new_id, '$gnaam', '$gnaam', '$email')";
            $result = mysqli_query($this->connection, $sql);
            var_dump($result);
            return($new_id);

        }else{

            return($uid);
        }
    }

}