<?php
// TODO : Clean up tout ca (stp david mdr)
/* TODOS :
- Faire le lien avec les matieres des eleves
- Changer le login par l'algo que David a cree
- Generer un fichier csv qui le nom au login cree dans la bdd
- (peut etre) Checker si l'entree existe déjà dans la BDD
*/

// FAITE UN BACKUP DE LA BDD AVANT D'EXECUTER CETTE FONCTION


$file = $_FILES['fichierEleves'];
$annee = (int)$_POST['anneeScolaire'];

$csv = array_map('str_getcsv', file($file['tmp_name']));

// $db = new PDO('mysql:host=localhost;dbname=maena', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$db = new PDO('mysql:host=mysql-maena.alwaysdata.net;dbname=maena_autoeval', 'maena', 'maena2015', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$insertEleve = $db->prepare(
    "INSERT INTO users_test
    (nomPrenom, login, is_softDelete, id_classe, id_classeNom, anneeScolaire, is_enseignant, dateCreation)
    VALUES
    (:nomPrenom, :login, :is_softDelete, :id_classe, :id_classeNom, :anneeScolaire, :is_enseignant, NOW())"
);

foreach($csv as $k => $eleve) {
    // J'imagine qu'on a pas besoin de ces deux variables :
    // $nom = $eleve[0];
    // $prenom = $eleve[1];

    $classe = preg_replace('/[^1-9]/', '', $eleve[2]);
    $classeNom = preg_replace('/[0-9]/', '', $eleve[2]);

    switch ($classeNom) {
        case 'A':
            $classeNom = 1;
            break;

        case 'B':
            $classeNom = 2;
            break;

        case 'C':
            $classeNom = 3;
            break;

        case 'D':
            $classeNom = 4;
            break;

        default:
            # code...
            break;
    }

    // TODO : Remplacer le login par l'algo de David
    $login = 'el-' . $classe . $classeNom . '-' . $k;

    // les options de l'élève sont stockées dans cette array
    // SUGGESTION : peut-être labeller les colonnes dans le fichier csv pour éviter cette loop

    $optionCours = [];
    for ($i=3; $i < 7; $i++) { 
        if (!empty($eleve[$i])) {
            $optionCours[] = $eleve[$i];
        }
    }

    $insertEleve->execute(array(
        ":nomPrenom" => $login,
        ":login" => $login,
        ":is_softDelete" => false,
        ":id_classe" => !empty($classe) ? $classe : null,
        ":id_classeNom" => !empty($classeNom) ? $classeNom : null,
        ":anneeScolaire" => $annee,
        ":is_enseignant" => false
    ));
}

$reponse = new \StdClass();
$reponse->code = 200;

header('Content-Type: application/json');
echo json_encode($reponse);