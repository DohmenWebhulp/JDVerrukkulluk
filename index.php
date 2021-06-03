<?php

    require_once("./vendor/autoload.php");

    

    $loader = new \Twig\Loader\FilesystemLoader("./templates");

    $twig = new \Twig\Environment($loader, ["debug" => true ]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());

    require_once("lib/database.php");
    require_once("lib/artikel.php");
    require_once("lib/gerecht_info.php");
    require_once("lib/recept.php");
    require_once("lib/keukentype.php");
    require_once("lib/ingredient.php");
    require_once("lib/user.php");
    require_once("lib/boodschappen.php");
    
    $db = new database();
    $rece = new Recept($db->getConnection());
    $schap = new Boodschappen($db->getConnection());
    $ginfo = new GerechtInfo($db->getConnection());
    $ingred = new Ingredient($db->getConnection());

    $recept_id = isset($_GET['id']) ? $_GET['id'] : null;
    $action = isset($_GET['action']) ? $_GET['action'] : 'homepage';
    $gebruiker = isset($_GET['user_id']) ? $_GET['user_id'] : 1;

    switch($action){

        case 'homepage': 
            
            $data = $rece->ophalenRecept();
            $template = 'homepage.html.twig';
            $title = "homepage";
            //echo "<pre>";
            //var_dump($data); 
            break;

        case 'detailpage':

            $data = $rece->ophalenRecept($recept_id);
            $template = 'detailpage.html.twig';
            $title = "detailpage";
            //echo "<pre>";
            //var_dump($data); 
            break;

        case 'boodschappenlijst':

            $schap->addToList($recept_id, $gebruiker);
            $data1 = $schap->ophalenBoodschappen($gebruiker); //Andere user_id dan degene die het recept gemaakt heeft
            $data2 = $ingred->ophalenIngredient($recept_id);
            for($i = 0; $i < count($data1); $i++){
                $data[$i] = array_merge($data1[$i], $data2[$i]);
            }
            $template = 'boodschappenlijst.html.twig';
            $title = 'boodschappenlijst';
            //echo "<pre>";
            //var_dump($data);
            break;

        case 'favorietLeeg':

            $ginfo->addFavoriet($recept_id, $gebruiker, date('Y/m/d', time()));
            $dat = $rece->ophalenRecept($recept_id);
            echo "<pre>";
            var_dump($dat); break;

        case 'favorietVol':

            $ginfo->removeFavoriet($recept_id, $gebruiker, date('Y/m/d', time()));
            $dat = $rece->ophalenRecept($recept_id);
            echo "<pre>";
            var_dump($dat); break;

        case 'waardering':

            $ginfo->addWaardering($recept_id, $_POST['waarde'], date('Y/m/d', time()));
            $dat = $rece->ophalenRecept($recept_id);
            var_dump($dat); break;
        
    }

    $template = $twig->load($template);
    echo $template->render(["title" => $title, "data" => $data]);



    /*
    if(empty($_GET['id'])){

        //Homepage

        $data = $rece->ophalenRecept();
        var_dump($data);

    }else{

        //Detailpagina

        $data = $rece->ophalenRecept($_GET['id']);
        $gerecht = $data[0];
        echo "<pre>";
        var_dump($data);
        if($_GET){
            $schap->addToList($gerecht['id'], $data[0]['user_id']);
            $grocs = $schap->ophalenBoodschappen($data['user_id']); //Andere user_id dan degene die het recept gemaakt heeft
            var_dump($grocs);
        }
        if(clickOnHeart($u)){
            if(heartIsFull()){
                $ginfo->addFavoriet($i, $u, $datum); 
            }else{
                $ginfo->removeFavoriet($i, $u);
            }
        }
    }

    echo "GET variables usable";

    //$schap = new Boodschappen($db->getConnection());
    //$dataa = $schap->addToList(1, 1);

    //$dataa = $schap->ophalenBoodschappen(1);

    $user = new User($db->getConnection());
    $dataaa = $user->ophalenUser(1);
    echo "<pre>";
    var_dump($data);*/

?>