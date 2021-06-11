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
    $use = new User($db->getConnection());

    $recept_id = isset($_GET['id']) ? $_GET['id'] : 1;
    $action = isset($_GET['action']) ? $_GET['action'] : 'homepage';
    $gebruiker = isset($_POST['user_id']) ? $_POST['user_id'] : 2;
    $rating = isset($_POST['waarde']) ? $_POST['waarde'] : 1;
    $keyw = isset($_POST['term']) ? $_POST['term'] : "Ketjap";
    $email = isset($_POST['email']) ? $_POST['email'] : "aa@heerlijk.com";
    $naam = isset($_POST['gebruiker']) ? $_POST['gebruiker'] : "Arie Appel";

    switch($action){

        case 'homepage': 
            
            $data = $rece->ophalenRecept();
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;

        case 'detailpage':

            $data = $rece->ophalenRecept($recept_id);
            $template = 'detailpage.html.twig';
            $title = "detailpage";
            break;

        case 'boodschappenlijst':

            $schap->addToList($recept_id, $gebruiker);
            $data = $schap->ophalenBoodschappen($gebruiker); //Andere user_id dan degene die het recept gemaakt heeft
            $template = 'boodschappenlijst.html.twig';
            $title = 'boodschappenlijst';
            break;

        case 'favorietLeeg':

            header('Content-Type: application/json');
            $ginfo->addFavoriet($recept_id, $gebruiker, date('Y/m/d', time()));
            $favo = array($gebruiker, 1);
            echo json_encode($favo);
            die();
            break;

        case 'favorietVol':

            header('Content-Type: application/json');
            $ginfo->removeFavoriet($recept_id, $gebruiker);
            $favo = array($gebruiker, 0);
            echo json_encode($favo);
            die();
            break;

        case 'waardering':

            header('Content-Type: application/json');
            $ginfo->addWaardering($recept_id, $rating, date('Y/m/d', time()));
            $data = $rece->ophalenRecept($recept_id);
            $ward = array($data['id'], $rating, $data[0]['Gemiddelde_Waardering']);
            echo json_encode($ward);
            die();
            break;

        case 'zoekFunctie':

            $data = $rece->zoeken($keyw);
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;

        case 'userStore':

            $valid = validation($email);
            if($valid){

                $usid = $use->addUser($naam, $email);
                $data = $use->ophalenUser($usid);
                
            }else{

                $usid = 0;
                $data = 0;
            }

            $template = 'userpage.html.twig';
            $title = 'userpage';
            break;
        
    }

    $template = $twig->load($template);
    echo $template->render(["title" => $title, "data" => $data]);

    function validation($email){

        $bool = TRUE;

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $bool = FALSE;
        }

        return($bool);

    }

?>