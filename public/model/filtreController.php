<?php
require("ResultatManager.php");

$AutoEvalManager = new ResultatManager();
$results = $AutoEvalManager->getResultatsList($_POST['idProf'], $_POST['nbLimit'], $_POST['isAfficheUniquementEnCours']);


$reponse = new \StdClass();
$reponse->code = 200;
$reponse->items = $results->fetchAll();

header('Content-Type: application/json');
echo json_encode($reponse);