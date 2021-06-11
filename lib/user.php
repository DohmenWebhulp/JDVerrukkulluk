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

        //User only gets added if not already found in database.
        //New user is not allowed same username OR email-adres as one found in database.
        //If both are the same, the existing user is returned.
        //If both are not the same, the new user is added to the database and his last position in the databse is returned.

        $users = $this->ophalenUsers();

        $bool = FALSE;

        foreach($users as $user){

            if(($user['Gebruikersnaam'] == $gnaam) and ($user['Emailadres'] == $email)){

                $bool = TRUE;
                $uid = $user['ID'];
                
            }elseif((($user['Gebruikersnaam'] == $gnaam) and ($user['Emailadres'] != $email)) or (($user['Gebruikersnaam'] != $gnaam) and ($user['Emailadres'] == $email))){

                $bool = TRUE;
                $uid = 0;
            }
            //else{

                //$bool = TRUE;
                //$uid = -1;
            //}
        }

        if(!$bool){

            $new_id = count($users) + 1;

            $sql = "INSERT INTO user (ID, Gebruikersnaam, Wachtwoord, Emailadres)
            VALUES ($new_id, '$gnaam', '$gnaam', '$email')";
            $result = mysqli_query($this->connection, $sql);
            return($new_id);

        }else{

            return($uid);
        }
    }

}