<?php

require_once('model/QuestionnaireManager.php');
require_once('model/QuestionnaireQuestionManager.php');
require_once('model/ClasseManager.php');
require_once('model/ClasseNomManager.php');
require_once('model/MatiereManager.php');
require_once('model/OptionCoursManager.php');
require_once('model/ResultatManager.php');

require_once('model/AutoEvaluationManager.php');
require_once('model/AutoEvaluationQuestionManager.php');
require_once('model/CifResultatClasseNomManager.php');
require_once('model/UserManager.php');


//require_once('');


/**
 * Vérifie Login et mdp, si ok retourne true et définit les variables de session isProf, idUser, nameUser et isAdmin
 *
 * @param  mixed $login
 * @param  mixed $pwd
 * @param  mixed $isProf
 *
 * @return void
 */
function do_login($login, $pwd, $isProf)
{

    $isLogged = false;

    $User = new UserManager();
    $user = $User->getAuthentifiedUser($login, $pwd, $isProf);

    if ($user !== false) {
        if (isset($user['id']) && isset($user['nomPrenom']) && isset($user['is_enseignant'])) {
            $_SESSION['isProf'] = (bool)$user['is_enseignant'];
            $_SESSION['idUser'] = (int)$user['id'];
            $_SESSION['nameUser'] = htmlspecialchars($user['nomPrenom']);

            if ((bool)$user['is_enseignant'] === true && isset($user['is_admin'])) {
                $_SESSION['isAdmin'] = (bool)$user['is_admin'];
            } else {
                $_SESSION['isAdmin'] = false;
            }
            $isLogged = true;
        }
    }

    return $isLogged;
}



function do_disconnect()
{
    try {
        session_unset();
        session_destroy();
    } catch (\Throwable $th) {
        //throw $th;
    }
}

function show_login($message)
{
    require('view/loginView.php');
}


/**
 * Affiche la liste des Questionnaires du prof
 *
 * @param  mixed $idProf
 *
 * @return void
 */
function show_questionnairesList($idProf, $message)
{

    $QuestionnaireManager = new QuestionnaireManager();
    $ListeQuestionnaires = $QuestionnaireManager->getQuestionnaires($idProf);

    require('view/questionnaireListeView.php');
}



/**
 * Affiche la page de création d'un nouveau questionnaire
 *
 * @param  mixed $idProf
 *
 * @return void
 */
function show_questionnaireNew($idProf)
{

    //Récupère les classes
    $ClasseManager = new ClasseManager();
    $classes = $ClasseManager->getClasses();

    //Récupère les matières
    $MatiereManager = new MatiereManager();
    $matieres = $MatiereManager->getMatieres();

    require('view/questionnaireNewView.php');
}




/**
 * Affiche le détail d'un questionnaire et permet de l'éditer
 *
 * @param  mixed $idQuestionnaire
 *
 * @return void
 */
function show_questionnaireDetail($idProf, $idQuestionnaire, $message)
{

    //Récupère les infos du questionnaire
    $QuestionnaireManager = new QuestionnaireManager();
    $questionnaire = $QuestionnaireManager->getQuestionnaire($idQuestionnaire);

    //Récupère les questions du questionnaire
    $QuestionManager = new QuestionnaireQuestionManager();
    $questions = $QuestionManager->getQuestions($idQuestionnaire);

    //Récupère les classes
    $ClasseManager = new ClasseManager();
    $classes = $ClasseManager->getClasses();

    //Récupère les matières
    $MatiereManager = new MatiereManager();
    $matieres = $MatiereManager->getMatieres();

    require('view/questionnaireDetailView.php');
}


/**
 * Enregistre un nouveau questionnaire (sans questions) et redirige vers l'édition de ce questionnaire
 *
 * @param  mixed $idProf
 * @param  mixed $idClasse
 * @param  mixed $idMatiere
 * @param  mixed $titre
 *
 * @return id
 */
function do_questionnaireAdd($idProf, $idClasse, $idMatiere, $titre)
{
    $Questionnaire = new QuestionnaireManager();
    return $Questionnaire->insertQuestionnaire($idProf, $titre, $idClasse, $idMatiere);
}



/**
 * Met à jour l'entête du questionnaire
 *
 * @param  mixed $idQuestionnaire
 * @param  mixed $idClasse
 * @param  mixed $idMatiere
 * @param  mixed $titre
 *
 * @return void
 */
function do_questionnaireUpdate($idQuestionnaire, $idClasse, $idMatiere, $titre)
{
    $Questionnaire = new QuestionnaireManager();
    $Questionnaire->updateQuestionnaire($idQuestionnaire, $titre, $idClasse, $idMatiere);
}


/**
 * Suppression logique du questionnaire.
 *
 * @param  mixed $idQuestionnaire
 *
 * @return void
 */
function do_questionnaireDelete($idQuestionnaire)
{
    $Questionnaire = new QuestionnaireManager();
    $Questionnaire->deleteQuestionnaire($idQuestionnaire);
}



function show_questionNew($idQuestionnaire, $message)
{

    //Récupère les questions du questionnaire
    $QuestionManager = new QuestionnaireQuestionManager();
    $questions = $QuestionManager->getQuestions($idQuestionnaire);

    $isEdit = false;
    require('view/questionDetailView.php');
}


/**
 * Insère une nouvelle ligne de question dans le questionnaire et retourne l'id créé
 *
 * @param  mixed $idQuestionnaire
 * @param  mixed $libelle
 *
 * @return void
 */
function do_questionAdd($idQuestionnaire, $libelle)
{
    $Question = new QuestionnaireQuestionManager();
    return $Question->insertQuestion($idQuestionnaire, $libelle);
}


function do_questionUpdate($idQuestion, $libelle)
{
    $Question = new QuestionnaireQuestionManager();
    return $Question->updateQuestion($idQuestion, $libelle);
}


function do_questionDelete($idQuestion)
{
    $Question = new QuestionnaireQuestionManager();
    $Question->deleteQuestion($idQuestion);
}


/**
 * Ouvre le détail de la question en mode édition
 *
 * @param  mixed $idQuestion
 * @param  mixed $libelle
 *
 * @return void
 */
function show_questionEdit($idQuestion, $idQuestionnaire)
{
    $Question = new QuestionnaireQuestionManager();
    $question = $Question->getQuestion($idQuestion);

    //Récupère les questions du questionnaire
    $QuestionManager = new QuestionnaireQuestionManager();
    $questions = $QuestionManager->getQuestions($idQuestionnaire);

    $isEdit = true;
    require('view/questionDetailView.php');
}





/**
 * Ouvre la fenêtre permettant de convertir le questionnaire en autoévaluation qu'on distribuera aux élèves
 *
 * @param  mixed $idQuestionnaire
 *
 * @return void
 */
function show_autoEvalDistribuer($idQuestionnaire)
{
    $Questionnaire = new QuestionnaireManager();
    $questionnaire = $Questionnaire->getQuestionnaire($idQuestionnaire);

    $Classe = new ClasseManager();
    $classes = $Classe->getClasses();

    $ClasseNom = new ClasseNomManager();
    $classeNoms = $ClasseNom->getClasseNoms();

    $Option = new OptionCoursManager();
    $optionCours = $Option->getOptionsCours();

    $Matiere = new MatiereManager();
    $matieres = $Matiere->getMatieres();

    require('view/autoEvalDistribuerView.php');
}





/**
 * Prend un questionnaire et en distribue une copie sous forme d'autoévaluation à chaque élève concerné
 * Créé aussi une ligne de Résultat que le professeur pourra consulter pour voir les stats des réponses.
 *
 * @param  mixed $idQuestionnaire
 * @param  mixed $idProf
 * @param  mixed $idMatiere
 * @param  mixed $idClasse
 * @param  mixed $idOptionCours
 * @param  mixed $dateAccessible
 * @param  mixed $titre
 * @param  mixed $isCommentairePermis
 * @param  mixed $idClasseNoms
 *
 * @return void
 */
function do_autoEvalDistribuer($idQuestionnaire, $idProf, $idMatiere, $idClasse, $idOptionCours, $dateAccessible, $titre, $isCommentairePermis, $idClasseNoms, $anneeScolaire)
{


    //Créé une ligne de résultat que le prof pourra consulter pour avoir ses statistiques
    $Resultat = new ResultatManager();
    $idResultat = $Resultat->insertResultat($idQuestionnaire, $idProf, $idMatiere, $idClasse, $idOptionCours, $dateAccessible, $titre, $isCommentairePermis, $anneeScolaire);

    //Créé les lignes de Cif_Resultat_classeNom pour savoir quels noms de classes sont concernés par cette autoévaluation
    $Cif = new CifResultatClasseNomManager();
    foreach ($idClasseNoms as $idClasseNom) {
        $Cif->insertCifResultatClasseNom($idResultat, $idClasseNom);
    }



    //Récupère aussi l'année de la rentrée scolaire des élèves pour savoir à qui s'adresser.
    //On part sur la date d'accessibilité de l'autoévaluation
    //de septembre à Décembre on garde la date telle quelle
    //de janvier à août inclus on fait année - 1
    // $castDate = new DateTime($dateAccessible);
    // $anneeScolaire = (int)($castDate->format('Y'));
    // $mois = (int)($castDate->format('m'));
    // if ($mois < 9) {
    //     --$anneeScolaire;
    // }

    //Récupère les id des élèves concernés
    $Users = new UserManager();
    $idEleves = $Users->getElevesFromOptions($idClasse, $idClasseNoms, $idOptionCours, $anneeScolaire, true);



    $AutoEval = new AutoEvaluationManager();
    $AutoEvalQuestion = new AutoEvaluationQuestionManager();

    //Pour chaque élève, créé une autoévaluation et y copie les questions qui proviennent du modèle de questionnaire
    foreach ($idEleves as $row) {
        $idEleve = $row['id'];

        $idAutoEval = $AutoEval->insertAutoEvaluation($idEleve, $idResultat);
        $AutoEvalQuestion->insertBatchAutoEvaluationQuestion($idAutoEval, $idQuestionnaire);
    }


    //Fête du slip !
}






/**
 * Affiche la liste des autoévaluations en cours pour l'élève concerné
 *
 * @param  mixed $idUser
 *
 * @return void
 */
function show_autoEvalListEleve($idUser, $message)
{
    $AutoEval = new AutoEvaluationManager();
    $autoEvals = $AutoEval->getAutoEvaluationsEleve($idUser);

    require('view/autoEvalListeEleveView.php');
}


/**
 * Affiche la liste des questions de l'autoevaluation
 *
 * @param  int $idAutoEval
 *
 * @return void
 */
function show_autoEvalQuestionsEleve($idAutoEval)
{

    $AutoEval = new AutoEvaluationManager();
    $autoEval = $AutoEval->getAutoEvaluationInfosBase($idAutoEval);

    $Question = new AutoEvaluationQuestionManager();
    $questions = $Question->getAutoEvaluationQuestions($idAutoEval);

    require('view/autoevalQuestionsEleveView.php');
}


/**
 * Enregistre les réponses de l'élève et clôture l'autoévaluation
 *
 * @param  mixed $idAutoEval
 * @param  mixed $commentaire
 * @param  mixed $arrayIdReponse
 *
 * @return void
 */
function do_ReponseEleveEnregistrer($idAutoEval, $commentaire, $arrayIdReponse)
{
    $Question = new AutoEvaluationQuestionManager();
    $Question->updateBatchAutoEvaluationQuestion($arrayIdReponse);

    $AutoEval = new AutoEvaluationManager();
    $AutoEval->updateAutoEvalTerminee($idAutoEval, $commentaire);
}



/**
 * la page permettant d'envoyer un mail de réinitialisation de mot de passe à l'utilisateur
 *
 * @param  mixed $Message
 *
 * @return void
 */
function show_passwordForget($message)
{
    require('view/passwordForgetView.php');
}

/**
 * Créé un nouveau password, l'envoie par mail au user et l'insère hashé en base de données
 *
 * @param  mixed $eMail
 *
 * @return void
 */
function do_sendPasswordResetMail($eMail)
{
    $UserManager = new UserManager();
    return $UserManager->sendPasswordResetMail($eMail);
}



/**
 * Affiche le détail du résultat
 *
 * @param  mixed $idResultat
 *
 * @return void
 */
function show_resultatDetail($idResultat, $message)
{
    $idResultat = (int)$idResultat;

    $resultatManager = new ResultatManager();
    $resultatInfosBase = $resultatManager->getResultatInfosBase($idResultat);
    $resultatStats = $resultatManager->getStatsResultat($idResultat);
    require('view/resultatDetailView.php');
}



/**
 * Archive ou rouvre une autoévaluation
 *
 * @param  mixed $idResultat
 * @param  mixed $isArchive
 *
 * @return void
 */
function do_archiverResultat($idResultat, $isArchive)
{
    $resultatManager = new ResultatManager();
    $resultatManager->changeArchiverResultat($idResultat, $isArchive);
}


/**
 * Affiche le profil de l'enseignant
 *
 * @param  mixed $idUser
 *
 * @return void
 */
function show_profilProf($idUser, $message, $messagePassword)
{
    $matiereManager = new MatiereManager();
    $matieres = $matiereManager->getMatieres();

    $userManager = new UserManager();
    $prof = $userManager->getProf($idUser);

    require('view/profilProfView.php');
}


/**
 * Vérifie et met jour le password
 *
 * @param  mixed $idProf
 * @param  mixed $currentPassword
 * @param  mixed $newPassword
 * @param  mixed $newPasswordConfirm
 *
 * @return string
 */
function do_updatePassword($idProf, $currentPassword, $newPassword, $newPasswordConfirm)
{

    $userManager = new UserManager();

    $messagePassword = "";
    $isError = false;


    //Verif Ancien Password
    if ($userManager->isPasswordMatch($idProf, $currentPassword) === false) {
        $isError = true;
        $messagePassword .= "L'ancien mot de passe est érroné";
    } // Vérif 8 caractères minimum
    elseif (strlen(trim($newPassword)) < 8) {
        $isError = true;
        $messagePassword .= "Le nouveau mot de passe doit faire 8 caractères minimum";
    } // Confirmation du nouveau password
    elseif ($newPassword != $newPasswordConfirm) {
        $isError = true;
        $messagePassword .= "Mauvaise confirmation du nouveau mot de passe";
    }

    if (!$isError) {
        $userManager->updateAndHashPassword($idProf, $newPassword);
        $messagePassword = "Mise à jour effectuée";
    }
    return $messagePassword;
}




/**
 * affiche le profil de l'élève
 *
 * @param  mixed $idUser
 *
 * @return void
 */
function show_profilEleve($idUser)
{
    require('view/profilEleve.php');
}


/**
 * Affiche la liste des professeurs
 *
 * @return void
 */
function show_listeProf($message = "")
{
    $userManager = new UserManager();
    $listProfs = $userManager->getListProf();
    require('view/listeProfView.php');
}






/**
 * Affiche la liste des élèves filtrés
 *
 * @return void
 */
function show_listeElevesFilter($filterAnneScolaire, $filterLogin, $filterIdClasse, $filterIdClasseNom, $filterIdOptionCours, $filterDateCreation, $message)
{
    $classeManager = new ClasseManager();
    $listClasse = $classeManager->getClasses();

    $classeNomManager = new classeNomManager();
    $listClasseNom = $classeNomManager->getClasseNoms();

    $optioCoursManager = new OptionCoursManager();
    $listOptionCours = $optioCoursManager->getOptionsCours();

    $userManager = new UserManager();
    $listAnneeScolaire = $userManager->getAnneeScolaireEleves();
    $listDateCreation = $userManager->getDatesCreationEleves();

    //Charge la liste des élèves uniquement filtrée par l'année scolaire en cours
    $listEleve = $userManager->getListEleves($filterAnneScolaire, $filterLogin, $filterIdClasse, $filterIdClasseNom, $filterIdOptionCours, $filterDateCreation);

    require('view/listeElevesView.php');
}

/**
 * Affiche la liste des élèves avec les valeurs de filtre par défaut
 *
 * @return void
 */
function show_listeEleves($message)
{
    $filterLogin = "";
    $filterIdClasse = 0;
    $filterIdClasseNom = 0;
    $filterIdOptionCours = 0;
    $filterDateCreation = "1900-01-01";

    //Si mois < juillet, sélectionne par défaut l'année précédent
    $Now = new DateTime();
    $filterAnneScolaire = (int)$Now->format('Y');
    if ((int)$Now->format('m') < 7) {
        $filterAnneScolaire--;
    }


    show_listeElevesFilter($filterAnneScolaire, $filterLogin, $filterIdClasse, $filterIdClasseNom, $filterIdOptionCours, $filterDateCreation, $message);
}


function show_profDetailNew($message = "")
{
    $matiereManager = new MatiereManager();
    $matieres = $matiereManager->getMatieres();
    require('view/profDetailView.php');
}


function show_profDetailEdit($idProf, $message = "")
{
    $userManager = new UserManager();
    $prof = $userManager->getProf($idProf);
    $matiereManager = new MatiereManager();
    $matieres = $matiereManager->getMatieres();

    require('view/profDetailView.php');
}


/**
 * Met à jour le profil d'un enseignant après avoir
 *
 * @param  mixed $idProf
 * @param  mixed $nomPrenom
 * @param  mixed $login
 * @param  mixed $isAdmin
 * @param  mixed $idMatiere
 *
 * @return void
 */
function do_updateProf($idProf, $nomPrenom, $login, $isAdmin, $idMatiere)
{
    $isError = false;
    $message = "";

    $login = strtolower($login);

    $userManager = new UserManager();

    //Verif si adresse mail valide
    if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $message = "Merci de saisir une adresse mail valide";
        $isError = true;
    } elseif (!$userManager->isLoginLibre($login, $idProf)) {
        $message = "Il existe déjà un compte " . $login;
        $isError = true;
    }

    //Là tout s'est bien passé, on update les infos
    if (!$isError) {
        $userManager->updateProf($idProf, $nomPrenom, $login, $isAdmin, $idMatiere);
        $message = "Mise à jour effectuée";
    }

    return $message;
}


function do_createProf($nomPrenom, $login, $isAdmin, $idMatiere)
{

    $isError = false;
    $message = "";

    $login = strtolower($login);

    $userManager = new UserManager();

    //Verif si adresse mail valide
    if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $message = "Merci de saisir une adresse mail valide";
        $isError = true;
    } elseif (!$userManager->isLoginLibre($login)) {
        $message = "Il existe déjà un compte " . $login;
        $isError = true;
    }

    //Là tout s'est bien passé, Passe à la suite
    if (!$isError) {
        //Génère un password aléatoire fort
        $password = $userManager->generateStrongPassword();
        //$password = "1234";

        //L'envoie par mail à l'utilisateur
        $userManager->sendPasswordMail($login, $password, false);
        //Créé le prof en BDD
        $idProf = $userManager->insertProf($nomPrenom, $login, $isAdmin, $idMatiere, $password);

        //Affiche la page
        show_profDetailEdit($idProf, "Le profil de " . $nomPrenom . " a bien été créé");
    } else {
        show_profDetailNew($message);
    }
}


function do_deleteProf($idProf)
{
    $userManager = new UserManager();
    $userManager->deleteUser($idProf);
}



function do_updateEleve($idEleve, $idClasse, $idClasseNom, array $arrayidOptionCours)
{
    $userManager = new UserManager();
    $userManager->updateEleve($idEleve, $idClasse, $idClasseNom, $arrayidOptionCours);
}

function do_deleteEleve($idEleve)
{
    $userManager = new UserManager();
    $userManager->deleteEleve($idEleve);
}


function do_deleteEleveDate($dateCreation)
{
    $userManager = new UserManager();
    $userManager->deleteEleveFromDate($dateCreation);
}


function show_detailEleve($idEleve)
{

    $userManager = new UserManager();
    $eleve = $userManager->getEleve($idEleve);

    $classeManager = new ClasseManager();
    $classes = $classeManager->getClasses();

    $classeNomManager = new ClasseNomManager();
    $classeNoms = $classeNomManager->getClasseNoms();

    $optioCoursManager = new OptionCoursManager();
    $optionCours = $optioCoursManager->getOptionsCours();

    require('view/detailEleveView.php');
}


function show_ajoutEleves()
{

    $classeManager = new ClasseManager();
    $classes = $classeManager->getClasses();

    $classeNomManager = new ClasseNomManager();
    $ClasseNoms = $classeNomManager->getClasseNoms();

    $optioCoursManager = new OptionCoursManager();
    $optionCours = $optioCoursManager->getOptionsCours();

    require('view/ajoutEleveView.php');
}

