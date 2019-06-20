<?php
$db = new PDO('mysql:host=mysql-maena.alwaysdata.net;dbname=maena_autoeval', 'maena', 'maena2015', null);
// $db = new PDO('mysql:host=localhost;dbname=maena', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$ohShitRequest = $db->prepare('DELETE FROM users_test WHERE id > 6 AND is_enseignant = 0; DELETE FROM cif_eleve_optionCours where id_users > 6');

$ohShitRequest->execute();

$reponse = new \StdClass();
$reponse->code = 200;
$reponse->message = 'Tout est ok.';

header('Content-Type: application/json');
echo json_encode($reponse);