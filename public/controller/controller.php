<?php

require_once('model/QuestionnaireManager.php');
require_once('model/QuestionnaireQuestionManager.php');
require_once('model/ClasseManager.php');
require_once('model/ClasseNomManager.php');
require_once('model/MatiereManager.php');
require_once('model/OptionCoursManager.php');
require_once('model/ResultatManager.php');
//require_once('');



/**
 * Affiche la liste des Questionnaires du prof
 *
 * @param  mixed $idProf
 *
 * @return void
 */
function show_questionnairesList($idProf){
   
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
function show_questionnaireNew($idProf){
 
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
function show_questionnaireDetail($idProf, $idQuestionnaire){

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
function do_questionnaireAdd($idProf, $idClasse, $idMatiere, $titre){
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
function do_questionnaireUpdate($idQuestionnaire, $idClasse, $idMatiere, $titre){
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
function do_questionnaireDelete($idQuestionnaire){
    $Questionnaire = new QuestionnaireManager();
    $Questionnaire->deleteQuestionnaire($idQuestionnaire);
}



function show_questionNew($idQuestionnaire){
    // $Questionnaire = new QuestionnaireManager();
    // $questionnaire = $Questionnaire->getQuestionnaire($idQuestionnaire);

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
function do_questionAdd($idQuestionnaire, $libelle){
    $Question = new QuestionnaireQuestionManager();
    return $Question->insertQuestion($idQuestionnaire, $libelle);
}


function do_questionUpdate($idQuestion, $libelle){
    $Question = new QuestionnaireQuestionManager();
    return $Question->updateQuestion($idQuestion, $libelle);
}


function do_questionDelete($idQuestion){
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
function show_questionEdit($idQuestion){
    $Question = new QuestionnaireQuestionManager();
    $question = $Question->getQuestion($idQuestion);
     
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
    $matieres =$Matiere->getMatieres();

    require('view/autoEvalDistribuerView.php');
}


function do_autoEvalDistribuer($idQuestionnaire, $idMatiere, $idClasse, $idOptionCours, $dateAccessible, $titre, $isCommentairePermis, $idClasseNoms){
    $Resultat = new ResultatManager();
    $idResultat = $Resultat->insertResultat($idQuestionnaire, $idMatiere, $idClasse, $idOptionCours, $dateAccessible, $titre, $isCommentairePermis);

    
}
