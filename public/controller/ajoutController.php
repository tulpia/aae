<?php
require_once('../model/ClasseManager.php');
require_once('../model/ClasseNomManager.php');
require_once('../model/OptionCoursManager.php');
require_once('../model/UserManager.php');

// On enlève les notices pour éviter que le return du json ne soit pollué par celles-ci
error_reporting(E_ERROR | E_WARNING | E_PARSE);

/* TODOS :
- Après l'import : Vider l'input file, vu que le bouton d'import est Fat je les vois bien cliquer à nouveau dessus par Erreur - DONE
- Bouton "CSV Elèves ok" en Vert tape à l'oeil et rajouter des tirets entre les mots (ex: EXPORT-ELEVE-2018.CSV) - DONE
- Faire apparaître en dessous de ce bouton en ROUGE le texte suivant:
    "Pour des soucis de confidentialité aucun nom d'élève ne sera enregistré en base de données.
    Téléchargerez ce fichier contenant la correspondance entre le nom et le matricule de chaque élève
    Ce fichier est STRICTEMENT CONFIDENTIEL et ne POURRA JAMAIS ETRE REEDITE, gardez le en lieu sûr. - DONE

- Bouton "Erreur" en rouge et rajouter des tirets entre les mots
- En dessous bouton d'erreur ajouter un texte (couleur noire) :
    "Certains élèves n'ont pas pu être importés suite à une erreur sur le fichier.
    Téléchargez le fichier d'erreurs, corrigez-le et importez-le à nouveau." - DONE

- (Celui là vient de me revenir et il sera plus chiant désolé)
Trouver un moyen de virer les CSV du serveur (ou de les crééer à la volée)
Car on n'est pas censé stocker sur le serveur la correspondance
entre le matricule et le nom des élèves. - DONE JE CROIS JE SUIS PAS SUR A TESTER

- A part ça, super bon taf \^o^/

- Si import accidentel en BDD, faire la requête suivante dans PHP my Admin
    DELETE FROM users_test WHERE id > 6; DELETE FROM cif_eleve_optionCours where id_users > 6
  permet de tout virer sauf les users de test : - DONE (voir le ohShitController.php)

*/


$annee = (int)$_POST['anneeScolaire'];
$elevesOkToCsv = [];
$elevesErrorToCsv = [];

// User Manager, pour créer des utilisateurs
$userManager = new UserManager();
//Récup du dernier login élève de cette année (en enlevant le préfixe de l'année), on l'incrémentera au fur et à mesure
$lastLoginEleve = $userManager->getLastLoginEleve($annee);

//Récup des classes dans une liste
$classeManager = new ClasseManager();
$resultClasse = $classeManager->getClasses();
$arrayClasses = $resultClasse->fetchAll();

//Récup des Noms de classe dans une liste
$classeNomManager = new ClasseNomManager();
$resultClasseNom = $classeNomManager->getClasseNoms();
$arrayClassesNom = $resultClasseNom->fetchAll();

//Récup des options cours dans une liste
$optionsCoursManager = new OptionCoursManager();
$resultOptionCours = $optionsCoursManager->getOptionsCours();
$arrayOptions = $resultOptionCours->fetchAll();




//Ouverture du fichier, on le fourre dans un array
$file = $_FILES['fichierEleves'];
$csv = array_map('str_getcsv', file($file['tmp_name']));


//Itération sur chaque ligne du fichier
foreach ($csv as $k => $csvRow) {
    // Declaration des variables
    $idClasse = false;
    $idClasseNom = false;


    if (!empty($csvRow[2])) {
        $classe = preg_replace('/[^0-9]/', '', $csvRow[2]);
        $classeNom = preg_replace('/[0-9]/', '', $csvRow[2]);
    }

    //Vérifie si classe du fichier correspond avec la BDD -> retourne son id
    foreach ($arrayClasses as $key => $value) {
        if (strtoupper($value['libelleImport']) == strtoupper($classe)) {
            $idClasse = $value['id'];
            break;
        }
    }

    //Vérifie si ClasseNom du fichier correspond à la BDD -> retourne son id
    foreach ($arrayClassesNom as $key => $value) {
        if (strtoupper($value['libelle']) == strtoupper($classeNom)) {
            $idClasseNom = $value['id'];
            break;
        }
    }





    //Récupère les options en toutes lettres du csv dans cet array
    $options = [];
    for ($m = 3; $m < 7; $m++) {
        if (!empty($csvRow[$m])) {
            $options[] = strtoupper($csvRow[$m]);
        }
    }

    //Vérifie les options cours du CSV et les compare avec la BDD -> insère leur Id dans le tableau  
    $optionsEleveEnCours = [];
    foreach ($options as $optionCsv) {
        foreach ($arrayOptions as $optionBdd) {
            if (strtoupper($optionBdd['libelle']) == $optionCsv) {
                $optionsEleveEnCours[] = $optionBdd['id'];
                break;
            }
        }
    }
    //Compare la longueur des 2 tableaux, si la même on a tout trouvé en BDD, sinon erreur
    $isOptionsOk = (count($optionsEleveEnCours) === count($options));






    //Si la classe et le nom correspondent à la BDD, bingo, on récupère les options et on créé l'élève
    if ($idClasse !== false && $idClasseNom !== false && $isOptionsOk) {




        //Création de l'élève et de ses options de cours s'il en a

        //Création du nouveau login
        $loginPlus = strval(++$lastLoginEleve);
        while (strlen($loginPlus) < 4) {
            $loginPlus = "0" . $loginPlus;
        }
        $NewLogin = substr($annee, 2) . '-' . $loginPlus;

        $newEleve = new \StdClass();
        $newEleve->login = $NewLogin;
        $newEleve->name = $csvRow['1'] . ' ' . $csvRow['0'];
        array_push($elevesOkToCsv, $newEleve);


        $userManager->createEleve($annee, $NewLogin, $idClasse, $idClasseNom, $optionsEleveEnCours);
        //$userManager->updateEleve($idEleve, $idClasse, $idClasseNom, $optionsEleveEnCours);
    } else {
        $errorMsg = "";
        if(!$idClasse){
            $errorMsg = "La classe est erronée"; 
        }elseif(!$idClasseNom){
            $errorMsg = "Le nom de la classe est faux";
        }elseif(!$isOptionsOk){
            $errorMsg = "Une des options est erronée";
        }

        //Elèves en erreur
        $newError = new \StdClass();
        $newError->nom = $csvRow[0];
        $newError->prenom = $csvRow[1];
        $newError->classe = $csvRow[2];
        $newError->optA = $csvRow[3];
        $newError->optB = $csvRow[4];
        $newError->optC = $csvRow[5];
        $newError->optD = $csvRow[6];
        $newError->msg = $errorMsg;
        array_push($elevesErrorToCsv, $newError);
    }
}

// Setup des headers pour le return de la requête ajax (feedback principalement)
$reponse = new \StdClass();
$reponse->code = 200;
$reponse->links = [];

// =======================
// Exportation d'un csv avec la correspondance matricule - Nom Prénom

// Ouverture et création d'un fichier csv dans le dossier public
// ATTENTION : Enlever la ligne public au moment de la mise en ligne

$fileNameEleve = 'EXPORT-ELEVES-' . $annee . '.csv';
$fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/' . $fileNameEleve, 'w');
$messageFileEleve = 'Pour des soucis de confidentialité aucun nom d\'élève ne sera enregistré en base de données. Téléchargerez ce fichier contenant la correspondance entre le nom et le matricule de chaque élève. Ce fichier est STRICTEMENT CONFIDENTIEL et ne POURRA JAMAIS ETRE REEDITE, gardez le en lieu sûr.';

// Boucle sur l'array des élèves
foreach ($elevesOkToCsv as $fields) {
    fputcsv($fp, get_object_vars($fields));
}
fclose($fp);

$arrayTempEleve = [
    'name'  =>  $fileNameEleve,
    'message'   =>  $messageFileEleve,
    'error' =>  false
];

$fileRejet = $_SERVER['DOCUMENT_ROOT']  . '/' . $fileNameEleve;

// Fonction pour retirer le csv du serveur
$filesCsv = glob($_SERVER['DOCUMENT_ROOT'] . "*.csv");
$now   = time();

foreach ($filesCsv as $file) {
  if (is_file($file)) {
    if ($now - filemtime($file) >= 60 * 60 * 24 * 2) { // 2 days
      unlink($file);
    }
  }
}

// Ajout du path du fichier dans la reponse json renvoyée
$reponse->links[] = $arrayTempEleve;

// =======================
// Exportation d'un csv avec les erreurs
if (count($elevesErrorToCsv) > 1) {
    $fileNameErrors = 'EXPORT-ERRORS' . $annee . '.csv';
    $fileError = fopen($_SERVER['DOCUMENT_ROOT']  . '/' . $fileNameErrors, 'w');
    $messageFileErrors = "Certains élèves n'ont pas pu être importés suite à une erreur sur le fichier.
    Téléchargez le fichier d'erreurs, corrigez-le et importez-le à nouveau.";
    
    // Boucle sur l'array des erreurs
    foreach ($elevesErrorToCsv as $fields) {
        fputcsv($fileError, get_object_vars($fields));
    }
    fclose($fileError);

    $arrayTempErrors = [
        'name'  =>  $fileNameErrors,
        'message'   =>  $messageFileErrors,
        'error' =>  true
    ];
    
    // Ajout du path du fichier dans la reponse json renvoyée
    $reponse->links[] = $arrayTempErrors;
}

$msgFeedback = "Terminé ! " . count($elevesOkToCsv) . ' élèves importés correctement, ' . count($elevesErrorToCsv) . ' élèves en erreur';

// =======================
// Feedback opération terminée et télécharger les CSV
$reponse->message = $msgFeedback;
header('Content-Type: application/json');
echo json_encode($reponse);