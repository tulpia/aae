<?php
session_start();
require_once('controller/controller.php');



try {
    $isActionDefinie = isset($_POST['action']);

    if ($isActionDefinie) {
        switch ($_POST['action']) {

            case "login":
                do_login($_POST['login'], $_POST['pwd'], $_POST['isProf']);
                header("Location: " . $_SERVER['PHP_SELF']);
                break;


            case "do_disconnect":
                do_disconnect();
                show_login();
                break;


            case "show_questionnaireDetail":
                show_questionnaireDetail($_SESSION['idUser'], $_POST['idQuestionnaire']);
                break;


            case "show_questionnaireNew":
                show_questionnaireNew($_SESSION['idUser']);
                break;


            case "do_questionnaireAdd":
                $insertedId = do_questionnaireAdd($_SESSION['idUser'], $_POST['idClasse'], $_POST['idMatiere'], $_POST['titre']);
                show_questionnaireDetail($_SESSION['idUser'], (int)$insertedId);
                break;


            case "do_questionnaireUpdate":
                do_questionnaireUpdate($_POST['idQuestionnaire'], $_POST['idClasse'], $_POST['idMatiere'], $_POST['titre']);
                if (isset($_POST['saveAndOpenNew'])) {
                    show_questionnaireNew($_SESSION['idUser']);
                } else {
                    show_questionnairesList($_SESSION['idUser']);
                }

                break;


            case "do_questionnaireDelete":
                do_questionnaireDelete($_POST['idQuestionnaire']);
                show_questionnairesList($_SESSION['idUser']);
                break;


            case "show_questionNew":
                show_questionNew($_POST['idQuestionnaire']);
                break;


            case "show_questionEdit":
                show_questionEdit($_POST['idQuestion']);
                break;


            case "do_questionAdd":
                $insertedId = do_questionAdd($_POST['idQuestionnaire'], $_POST['libelle']);
                if (isset($_POST['saveAndOpenNew'])) {
                    show_questionNew($_POST['idQuestionnaire']);
                } else {
                    show_questionnaireDetail($_SESSION['idUser'], $_POST['idQuestionnaire']);
                }
                break;


            case "do_questionUpdate":
                do_questionUpdate($_POST['idQuestion'], $_POST['libelle']);
                if (isset($_POST['saveAndOpenNew'])) {
                    show_questionNew($_POST['idQuestionnaire']);
                } else {
                    show_questionnaireDetail($_SESSION['idUser'], $_POST['idQuestionnaire']);
                }
                break;


            case "do_questionDelete":
                do_questionDelete($_POST['idQuestion']);
                show_questionnaireDetail($_SESSION['idUser'], $_POST['idQuestionnaire']);
                break;


            case "show_autoEvalDistribuer":
                show_autoEvalDistribuer($_POST['idQuestionnaire']);
                break;


            case "do_autoEvalDistribuer":
                $isCommentairePermis = isset($_POST['isCommentairePermis']);
                do_autoEvalDistribuer($_POST['idQuestionnaire'], $_SESSION['idUser'], $_POST['idMatiere'], $_POST['idClasse'], $_POST['idOptionCours'], $_POST['dateAccessible'], $_POST['titre'], $isCommentairePermis, $_POST['IdClasseNoms']);
                show_questionnairesList($_SESSION['idUser']);
                break;


            case "show_autoEvalListEleve":
                show_autoEvalListEleve($_SESSION['idUser']);
                break;


            case "show_autoEvalQuestionsEleve":
                show_autoEvalQuestionsEleve($_POST['idAutoEval']);
                break;


            case "do_ReponseEleveEnregistrer":
                do_ReponseEleveEnregistrer($_POST['idAutoEval'], $_POST['commentaire'], $_POST['arrayIdReponse']);
                show_autoEvalListEleve($_SESSION['idUser']);
                break;


            default:
                $isActionDefinie = false;
        }
    }



    //Si pas trouvé d'action en POST
    if (!$isActionDefinie) {
        //Affichage des fenêtres par défaut pour le prof ou l'élève
        if (isset($_SESSION['idUser'])) {
            if ((bool)$_SESSION['isProf'] === true) {
                show_questionnairesList($_SESSION['idUser']);
            } else {
                show_autoEvalListEleve($_SESSION['idUser']);
            }
        } else {
            //Sinon déconnexion
            do_disconnect();
            show_login();
        }
    }



} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
    echo ('<br><br><br><br><a href="index.php">Retour à l\'accueil</a>');
}
