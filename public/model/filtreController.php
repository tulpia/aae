<?php
require_once("ResultatManager.php");
require_once("QuestionnaireManager.php");


$isActionDefinie = isset($_POST['action']);

if ($isActionDefinie) {
    switch ($_POST['action']) {

        case "refreshResultats":
            $AutoEvalManager = new ResultatManager();
            $results = $AutoEvalManager->getResultatsList($_POST['idProf'], $_POST['nbLimit'], isset($_POST['isAfficheUniquementEnCours']));

            $reponse = new \StdClass();
            $reponse->code = 200;
            $reponse->items = $results->fetchAll();

            header('Content-Type: application/json');
            echo json_encode($reponse);
            break;


        case "refreshQuestionnaires":
            $QuestionnaireManager = new QuestionnaireManager();
            $results = $QuestionnaireManager->getQuestionnaires($_POST['idProf'], $_POST['nbLimit']);

            $reponse = new \StdClass();
            $reponse->code = 200;
            $reponse->items = $results->fetchAll();

            header('Content-Type: application/json');
            echo json_encode($reponse);
            break;

        default:
            $isActionDefinie = false;
            
    }
}


if(!$isActionDefinie){
    header("Location: " . $_SERVER['PHP_SELF']);
}