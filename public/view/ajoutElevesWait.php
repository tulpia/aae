<?php
$title = 'Ajout des élèves en cours';
ob_start();

//Le header de l'utilisateur qui permet de retourner à l'accueil ou de se déconnecter (à faire)
require('view/headerUserView.php');
?>

<div>
    <h1>Ajout des élèves en cours<br>Merci de patienter !</h1>
    <h3>Cela peut prendre plusieurs dizaines de secondes</h3>

    <!-- <div>
        <img src="./view/dist/images/loader.gif" alt="chargement">
    </div> -->


</div>


<?php
$content = ob_get_clean();
require('template.php');
?>