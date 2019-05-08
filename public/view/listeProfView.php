<?php
$title = 'Liste des enseigants';
ob_start();

//Le header de l'utilisateur qui permet de retourner à l'accueil ou de se déconnecter (à faire)
require('view/headerUserView.php');
?>

<h1>Cette page n'est pas encore développée</h1>









<?php
$content = ob_get_clean();
require('template.php');
?>