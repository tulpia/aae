<?php
session_start();
require_once('controller/controller.php');


try {
    $isActionDefinie = isset($_POST['action']);

    if ($isActionDefinie) {
        switch ($_POST['action']) {

            case "do_login":
                if (do_login($_POST['login'], $_POST['pwd'], $_POST['isProf'])) {
                    header("Location: " . $_SERVER['PHP_SELF']);
                } else {
                    show_login("Login ou mot de passe incorrect");
                }
                break;


            case "do_disconnect":
                do_disconnect();
                show_login("");
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
                $message = isset($_POST['message']) ? $_POST['message'] : "" ;
                show_autoEvalListEleve($_SESSION['idUser'], $message);
                break;


            case "show_autoEvalQuestionsEleve":
                show_autoEvalQuestionsEleve($_POST['idAutoEval']);
                break;


            case "do_ReponseEleveEnregistrer":
                $message = isset($_POST['message']) ? $_POST['message'] : "" ;
                do_ReponseEleveEnregistrer($_POST['idAutoEval'], $_POST['commentaire'], $_POST['arrayIdReponse']);
                show_autoEvalListEleve($_SESSION['idUser'], $message);
                break;



            case "show_passwordForget":
                show_passwordForget("");
                break;


            case "do_sendPasswordResetMail":
                if (do_sendPasswordResetMail($_POST['eMail'])) {
                    show_login("Le mail de réinitialisation a bien été envoyé à l'adresse " . $_POST['eMail'] . "<br>Pensez à regarder vos Spams");
                } else {
                    show_passwordForget("Mail invalide ou ne correspondant à aucun utilisateur dans l'application");
                }
                break;


            case "show_resultatDetail":
                show_resultatDetail($_POST['idResultat']);
                break;


            case "do_archiverResultat":
                do_archiverResultat($_POST['idResultat'], $_POST['isArchive']);
                show_resultatDetail($_POST['idResultat']);
                break;


            case "show_profilProf":
                show_profilProf($_SESSION['idUser'], "", "");
                break;


            case "show_profilEleve":
                show_profilEleve($_SESSION['idUser']);
                break;


            case "show_listeProf":
                show_listeProf();
                break;


            case "show_listeEleves":
                show_listeEleves();
                break;

            case "show_listeElevesFilter":
                show_listeElevesFilter($_POST['anneeScolaire'], $_POST['login'], $_POST['idclasse'], $_POST['idclasseNom'], $_POST['idOptionCours'], $_POST['dateCreation']);
                break;


            case "show_detailEleve":
                show_detailEleve($_POST['idEleve']);
                break;


            case "show_profDetailEdit":
                show_profDetailEdit($_POST['idProf']);
                break;

            case "show_profDetailNew":
                show_profDetailNew();
                break;


            case "do_updateProf":
                $message = do_updateProf($_POST['idProf'], $_POST['nomPrenom'], $_POST['login'], isset($_POST['isAdmin']), $_POST['idMatiere']);

                if (isset($_POST['nextAction']))
                    if ($_POST['nextAction'] == 'show_profilProf') {
                        show_profilProf($_POST['idProf'], $message, "");
                    } else {
                        show_profDetailEdit($_POST['idProf'], $message);
                    }

                break;

            case "do_createProf":
                do_createProf($_POST['nomPrenom'], $_POST['login'], isset($_POST['isAdmin']), $_POST['idMatiere']);
                break;

            case "do_deleteProf":
                do_deleteProf($_POST['idProf']);
                show_listeProf("L'utilisateur a bien été supprimé");
                break;


            case "do_updateEleve":
                $arrayIdOptionCours = [];
                if (isset($_POST['idOptionCours'])) {
                    $arrayIdOptionCours = (array)$_POST['idOptionCours'];
                }

                do_updateEleve($_POST['idEleve'], $_POST['idClasse'], $_POST['idClasseNom'], $arrayIdOptionCours);
                show_listeEleves();
                break;

            case "do_deleteEleve":
                do_deleteEleve($_POST['idEleve']);
                show_listeEleves();
                break;


            case "show_ajoutEleves":
                show_ajoutEleves();
                break;

                
            case "do_updatePassword":
                $messagePassword = do_updatePassword($_POST['idProf'], $_POST['currentPassword'], $_POST['newPassword'], $_POST['newPasswordConfirm']);
                show_profilProf($_POST['idProf'], "", $messagePassword);
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
                show_autoEvalListEleve($_SESSION['idUser'], "");
            }
        } else {
            //Sinon déconnexion
            do_disconnect();
            show_login("");
        }
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
    echo ('<br><br><br><br><a href="index.php">Retour à l\'accueil</a>');
}
