<?php
require_once('ClasseManager.php');
require_once('ClasseNomManager.php');
require_once('OptionCoursManager.php');
require_once('UserManager.php');

/* TODOS :
- Generer un fichier csv qui le nom au login cree dans la bdd
- (peut etre) Checker si l'entree existe déjà dans la BDD
- Export CSV des élèves Ok et des élèves erreur
- Feedback utilisateur
- Virer la limite d'ajout de 3 users pour la mise en prod
*/

// FAITE UN BACKUP DE LA BDD AVANT D'EXECUTER CETTE FONCTION

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
    if ($k < 3) {

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

      

        //Si la classe et le nom correspondent à la BDD, bingo, on récupère les options et on créé l'élève
        //Achtung pas de vérification poussée sur les options, si elles sont fausses tant pis.
        if (isset($idClasse) && isset($idClasseNom)) {

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
                    if (strtoupper($optionBdd['libelle']) == $optionCsv){
                        $optionsEleveEnCours[] = $optionBdd['id'];
                        break;
                    }
                }
            }



            // foreach ($arrayOptions as $key => $value) {
            //     for ($l = 0; $l < count($options); $l++) {
            //         if (strtoupper($value['libelle']) == $options[$l]) {
            //             $optionsEleveEnCours[] = $value['id'];
            //             break;
            //         }
            //     }
            // }
            

            //Création de l'élève et de ses options de cours s'il en a

            //Création du nouveau login
            $NewLogin = substr($annee, 2) . '-' . ++$lastLoginEleve;

            $newEleve = new \StdClass();
            $newEleve->login = $NewLogin;
            $newEleve->name = $csvRow['1'] . ' ' . $csvRow['0'];
            array_push($elevesOkToCsv, $newEleve);
            

            $idEleve = $userManager->createEleve($annee, $NewLogin);
            $userManager->updateEleve($idEleve, $idClasse, $idClasseNom, $optionsEleveEnCours);

        }
        else{
            //Elèves en erreur
            array_push($elevesErrorToCsv, $csvRow);           
        }
    }
}

// =======================
// /!\ /!\ /!\ /!\ /!\ /!\
//TODO: Exporter un csv avec la correspondance matricule - Nom Prénom
//$elevesOkToCsv->FonctionMagiqueQuiFaitDuCsv();
// /!\ /!\ /!\ /!\ /!\ /!\
// =======================
var_dump($elevesOkToCsv);
die();

 // =======================
 // /!\ /!\ /!\ /!\ /!\ /!\
 //TODO : Récupérer les lignes CSV en erreur et les exporter en CSV
 //$elevesErrorToCsv->FonctionMagiqueQuiFaitDuCsv();
 // /!\ /!\ /!\ /!\ /!\ /!\
 // =======================

// =======================
 // /!\ /!\ /!\ /!\ /!\ /!\
 //TODO : Feedback opération terminée et télécharger les CSV
 // /!\ /!\ /!\ /!\ /!\ /!\
 // =======================

$reponse = new \StdClass();
$reponse->code = 200;

header('Content-Type: application/json');
echo json_encode($reponse);
