<?php

class Recept{

    private $connection;

    public function __construct($db){

        $this->connection = $db;

    }

    public function ophalenRecept($recept_id = null){

        $tot_recept = [];
        $sql = "select * from recept";

        if(!is_null($recept_id)){
            //$sql .= "where id = $recept_id";
            $sql = "select * from recept where id = $recept_id";
        }

        $result = mysqli_query($this->connection, $sql);
        if(is_null($recept_id)){
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

                $user = $this->ophalenUser_r($row['user_id']);
                $keuken = $this->ophalenKeuken_r($row['keuken_id']);
                $type = $this->ophalenType_r($row['type_id']);
                $ingr = $this->ophalenIngredient_r($row['ID']);
        
                $bereid = $this->ophalenBereiding_r($row['ID']);
                $waarde = $this->ophalenWaardering_r($row['ID']);
                $opm = $this->ophalenOpmerkingen_r($row['ID']);
                $favo = $this->ophalenFavorieten_r($row['ID']);
        
                $calos = $this->calculateCalories($row['ID']);
                $prijs = $this->calculatePrice($row['ID']);
                $avgw = $this->calculateAvgWaardering($row['ID']);
                $recept = [
        
                    'id' => $row['ID'],
                    'Naam' => $row['titel'],
                    'Datum' => $row['datum'],
                    'korteOmschrijving' => $row['korte_omschrijving'],
                    'langeOmschrijving' => $row['lange_omschrijving'],
                    'foto' => $row['foto'],
                    'Type_Keuken' => $keuken,
                    'Type_Voedsel' => $type,
                    'Gebruikersinfo' => $user,
                    'Ingrediënten' => $ingr,
                    'Opmerkingen' => $opm,
                    'Bereiding' => $bereid,
                    'Waardering' => $waarde,
                    'Favorieten' => $favo,
                    'Totaal_Calorieën' => $calos,
                    'Totale_Prijs' => $prijs,
                    'Gemiddelde_Waardering' => $avgw
                ];
        
                $tot_recept[] = $recept;
            }
        }else{
            
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $user = $this->ophalenUser_r($row['user_id']);
            $keuken = $this->ophalenKeuken_r($row['keuken_id']);
            $type = $this->ophalenType_r($row['type_id']);
            $ingr = $this->ophalenIngredient_r($row['ID']);
    
            $bereid = $this->ophalenBereiding_r($row['ID']);
            $waarde = $this->ophalenWaardering_r($row['ID']);
            $opm = $this->ophalenOpmerkingen_r($row['ID']);
            $favo = $this->ophalenFavorieten_r($row['ID']);
    
            $calos = $this->calculateCalories($row['ID']);
            $prijs = $this->calculatePrice($row['ID']);
            $avgw = $this->calculateAvgWaardering($row['ID']);
            $recept = [
    
                'id' => $row['ID'],
                'Naam' => $row['titel'],
                'Datum' => $row['datum'],
                'korteOmschrijving' => $row['korte_omschrijving'],
                'langeOmschrijving' => $row['lange_omschrijving'],
                'foto' => $row['foto'],
                'Type_Keuken' => $keuken,
                'Type_Voedsel' => $type,
                'Gebruikersinfo' => $user,
                'Ingrediënten' => $ingr,
                'Opmerkingen' => $opm,
                'Bereiding' => $bereid,
                'Waardering' => $waarde,
                'Favorieten' => $favo,
                'Totaal_Calorieën' => $calos,
                'Totale_Prijs' => $prijs,
                'Gemiddelde_Waardering' => $avgw
            ];
            $tot_recept = $recept;
        }

        return($tot_recept);
    }

    private function ophalenUser_r($user_id){
        
        $user = new User($this->connection);
        $data = $user->ophalenUser($user_id);
        
        return($data);
    }

    private function ophalenKeuken_r($keuken_id){

        $keuken = new KeukenType($this->connection);
        $kkn = $keuken->ophalenKeukenType($keuken_id);
        
        return($kkn);
    }

    private function ophalenType_r($type_id){
        
        $type = new KeukenType($this->connection);
        $typ = $type->ophalenKeukenType($type_id);
        
        return($typ);
    }

    private function ophalenIngredient_r($recept_id){
        
        $ingr = new Ingredient($this->connection);
        $data = $ingr->ophalenIngredient($recept_id);
        
        return($data);
    }

    private function ophalenBereiding_r($recept_id){
        
        $user = new GerechtInfo($this->connection);
        $data = $user->ophalenBOWF($recept_id, 'B');
        
        return($data);
    }

    private function ophalenWaardering_r($recept_id){
        
        $user = new GerechtInfo($this->connection);
        $data = $user->ophalenBOWF($recept_id, 'W');
        
        return($data);
    }

    private function ophalenFavorieten_r($recept_id){
        
        $user = new GerechtInfo($this->connection);
        $data = $user->ophalenBOWF($recept_id, 'F');
        
        return($data);
    }

    private function ophalenOpmerkingen_r($recept_id){

        $user = new GerechtInfo($this->connection);
        $data = $user->ophalenBOWF($recept_id, 'O');
        
        return($data);
    }

    private function calculateCalories($recept_id){

        //Number of calories depends on hoeveelheid.

        $ingr = $this->ophalenIngredient_r($recept_id);
        $calo = array_column($ingr, 'Calorieën');
        $hoev = array_column($ingr, 'Hoeveelheid');
        $sum = 0;
        for($i = 0; $i<count($calo); $i++){
            $sum = $sum + ($calo[$i]*$hoev[$i])/1000;
        }

        return($sum);
    }

    private function calculatePrice($recept_id){

        //Price does not depend on hoeveelheid. You can't buy 1.5 bags.

        $ingr = $this->ophalenIngredient_r($recept_id);

        $sum = 0;

        foreach($ingr as $row){
            if($row['Hoeveelheid'] % $row['Verpakking'] == 0){
                $sumel = intdiv($row['Hoeveelheid'], $row['Verpakking']);
            }else{
                $sumel = intdiv($row['Hoeveelheid'], $row['Verpakking']) + 1;
            }
            $sum += $sumel * $row['prijs'];
        }

        return($sum);
    }

    private function calculateAvgWaardering($recept_id){

        $ward = $this->ophalenWaardering_r($recept_id);
        $aant = array_column($ward, 'stap_of_aantal');
        $sum = array_sum($aant);

        if(count($aant) > 0){
            $avg = $sum/count($aant);
        }else{
            $avg = 0;
        }
        
        return($avg);
    }
}