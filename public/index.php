

<?php
require_once('controller/controller.php');

$_SESSION['idProf'] = 4;


if(isset($_GET['action'])){
    
    switch ($_GET['action']){

        case "show_questionnaireDetail":
        show_questionnaireDetail($_SESSION['idProf'],$_POST['idQuestionnaire']);
        break;

        case "show_questionnaireNew":
        show_questionnaireNew($_SESSION['idProf']);
        break;

        case "do_questionnaireAdd":
        $insertedId = do_questionnaireAdd($_SESSION['idProf'], $_POST['idClasse'], $_POST['idMatiere'], $_POST['titre']);
        show_questionnaireDetail($_SESSION['idProf'], (int)$insertedId);
        break;


        case "do_questionnaireUpdate":

        break;


        case "show_questionNew":
            show_questionNew($_POST['idQuestionnaire']);
        break;


        case "show_questionEdit":
            show_questionEdit($_POST['idQuestion']);
        break;


        
        case "do_questionAdd":
        $insertedId = do_questionAdd($_POST['idQuestionnaire'], $_POST['libelle']);
        show_questionnaireDetail($_SESSION['idProf'],$_POST['idQuestionnaire']);
        break;

        case "do_questionUpdate":
        do_questionUpdate($_POST['idQuestion'],$_POST['libelle']);
        show_questionnaireDetail($_SESSION['idProf'], $_POST['idQuestionnaire']);
        break;

        case "do_questionDelete":
        do_questionDelete($_POST['idQuestion']);
        show_questionnaireDetail($_SESSION['idProf'],$_POST['idQuestionnaire']);
        break;



        default:
        show_questionnairesList($_SESSION['idProf']);
    }

    


}
else{
    //Page par défaut (pour l'instant)
    show_questionnairesList($_SESSION['idProf']);
}



