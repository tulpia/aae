<?php
require_once('ClasseManager.php');
require_once('ClasseNomManager.php');
require_once('OptionCoursManager.php');
require_once('UserManager.php');
// TODO : Clean up tout ca (stp david mdr)
/* TODOS :
- Faire le lien avec les matieres des eleves
- Changer le login par l'algo que David a cree
- Generer un fichier csv qui le nom au login cree dans la bdd
- (peut etre) Checker si l'entree existe déjà dans la BDD
*/

// FAITE UN BACKUP DE LA BDD AVANT D'EXECUTER CETTE FONCTION

// OPTION USER MANAGER
$userManager = new UserManager();

$optionsCours = new OptionCoursManager();
$optionCours = $optionsCours->getOptionsCours();
$arrayOptions = $optionCours->fetchAll();

$getClassesNom = new ClasseNomManager();
$classesNom = $getClassesNom->getClasseNoms();
$arrayClassesNom = $classesNom->fetchAll();

$getClasses = new ClasseManager();
$classes = $getClasses->getClasses();
$arrayClasses = $classes->fetchAll();

$file = $_FILES['fichierEleves'];
$annee = (int)$_POST['anneeScolaire'];

$csv = array_map('str_getcsv', file($file['tmp_name']));

// $db = new PDO('mysql:host=localhost;dbname=maena', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
// $db = new PDO('mysql:host=mysql-maena.alwaysdata.net;dbname=maena_autoeval', 'maena', 'maena2015', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$i = $userManager->getLastLoginEleve($annee);

foreach($csv as $k => $eleve) {
    if ($k < 3) {
        // Declaration des variables
        $idClasse = false;
        $idClasseNom = false;

        // Incrementation
        $i++;

        if (!empty($eleve[2])) {
            $classe = preg_replace('/[^0-9]/', '', $eleve[2]);
            $classeNom = preg_replace('/[0-9]/', '', $eleve[2]);
        }

        // Comparer la classe à ce qu'il y a dans la bdd

        foreach ($arrayClasses as $key => $value) {
            if ($value['libelleImport'] == $classe) {
                $idClasse = $value['id'];
                break;
            }
        }
        
        foreach ($arrayClassesNom as $key => $value) {
            if ($value['libelle'] == $classeNom) {
                $idClasseNom = $value['id'];
                break;
            }
        }

        // TODO : Remplacer le login par l'algo de David
        // $login = 'el-' . $classe . $classeNom . '-' . $k;

        // les options de l'élève sont stockées dans cette array
        // SUGGESTION : peut-être labeller les colonnes dans le fichier csv pour éviter cette loop

        $options = [];
        for ($m=3; $m < 7; $m++) { 
            if (!empty($eleve[$m])) {
                $options[] = $eleve[$m];
            }
        }
        $idOptions = [];

        foreach ($arrayOptions as $key => $value) {
            for ($l=0; $l < count($options); $l++) {
                if (strtoupper($value['libelle']) == strtoupper($options[$l])) {
                    $idOptions[] = $value['id'];
                    break;
                }
            }
        }

        var_dump($idOptions);

        if (isset($idClasse) && isset($idClasseNom)) {
            $createEleve = $userManager->createEleve($annee, $i);
            $userManager->updateEleve($createEleve, $idClasse, $idClasseNom, $idOptions);
        }

        // if ($idClasse !== false && $idClasseNom !== false) {
        // }
    }
}

$reponse = new \StdClass();
$reponse->code = 200;

header('Content-Type: application/json');
echo json_encode($reponse);