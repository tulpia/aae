<?php
$title = 'Résultats';
ob_start();

//Le header de l'utilisateur qui permet de retourner à l'accueil ou de se déconnecter (à faire)
require('view/headerUserView.php');
?>


<form action="index.php" method="post" class="filtreFormulaire">
    <input type="hidden" name="action" value="show_resultatsList">
    <input type="hidden" name="idProf" value="<?= $idProf ?>">

    <label>
        <select name="nbLimit">
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="0">Tous les</option>
        </select> derniers résultats
    </label>

    <label>
        <input type="checkbox" name="isAfficheUniquementEnCours" checked>
        Masquer les résultats archivés
    </label>

    <input type="submit" value="Afficher">

</form>







<?php
$content = ob_get_clean();
require('template.php');
?>