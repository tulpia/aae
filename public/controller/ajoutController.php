<?php
require_once('../model/ClasseManager.php');
require_once('../model/ClasseNomManager.php');
require_once('../model/OptionCoursManager.php');
require_once('../model/UserManager.php');

/* TODOS :
- Export CSV des élèves Ok et des élèves erreur (j'ai préparé des array) - DONE 
- Bloquer fenêtre pour éviter double clic quand import en cours (ça m'est arrivé faute de feedback) - DONE
- Feedback utilisateur : Ajout en cours et ajout terminé - DONE
- Une fois fini, navigation auto vers la liste des élèves - NOT POSSIBLE
- Si import accidentel en BDD, faire la requête suivante dans PHP my Admin
    DELETE FROM users_test WHERE id > 6; DELETE FROM cif_eleve_optionCours where id_users > 6
  permet de tout virer sauf les users de test :

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
        //Elèves en erreur
        array_push($elevesErrorToCsv, $csvRow);
    }
}

// Setup des headers pour le return de la requête ajax (feedback principalement)
$reponse = new \StdClass();
$reponse->code = 200;
$reponse->links = [];

// =======================
// Exportation d'un csv avec la correspondance matricule - Nom Prénom

// Ouverture et création d'un fichier csv dans le dossier public
$fileNameEleve = 'exportEleve' . $annee . '.csv';
$fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/public' . '/' . $fileNameEleve, 'w');

// Boucle sur l'array des élèves
foreach ($elevesOkToCsv as $fields) {
    fputcsv($fp, get_object_vars($fields));
}
fclose($fp);

// Ajout du path du fichier dans la reponse json renvoyée
$reponse->links[] = $fileNameEleve;

// =======================
// Exportation d'un csv avec les erreurs
if (count($elevesErrorToCsv) > 1) {
    $fileNameErrors = 'exportEleveErrors.csv';
    $fileError = fopen($_SERVER['DOCUMENT_ROOT'] . '/public' . '/' . $fileNameErrors, 'w');
    
    // Boucle sur l'array des erreurs
    foreach ($elevesErrorToCsv as $fields) {
        fputcsv($fileError, get_object_vars($fields));
    }
    fclose($fileError);
    
    // Ajout du path du fichier dans la reponse json renvoyée
    $reponse->links[] = $fileNameErrors;
}

$msgFeedback = "Terminé ! " . count($elevesOkToCsv) . ' élèves importés correctement, ' . count($elevesErrorToCsv) . ' élèves en erreur';

// =======================
// Feedback opération terminée et télécharger les CSV
$reponse->message = $msgFeedback;
header('Content-Type: application/json');
echo json_encode($reponse);