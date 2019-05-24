<?php

//Par défaut, mode ajout d'un nouveau prof
$isEdit = false;
$nom = "";
$login = "";
$isAdmin = false;
$idMatiere = 1;
$title = "Créer un nouvel enseignant";

if(isset($prof)){
    //Mode édition du profil
    $isEdit = true;
    $nom = htmlspecialchars($prof['nomPrenom']);
    $login = htmlspecialchars($prof['login']);
    $isAdmin = (bool)$prof['is_admin'];
    $idMatiere = (int)$prof['id_matiere'];
    $title = "Profil de " . $nom;
}

ob_start();

//Le header de l'utilisateur qui permet de retourner à l'accueil ou de se déconnecter (à faire)
require('view/headerUserView.php');
?>

<h1><?= $title ?></h1>

<?php include("message.php");?>

<?php
    //Affiche message d'erreur s'il y en a un
    /*if(isset($message) && trim($message) != "" ){
        echo('<br><br><h3>' . $message . '</h3><br><br>');
    }*/
?>


<form action="index.php" method="POST">
    
<?php if($isEdit) : ?>
    <input type="hidden" name="action" value="do_updateProf">
    <input type="hidden" name="idProf" value="<?= htmlspecialchars($idProf) ?>">
    
    <?php else : ?>
    <input type="hidden" name="action" value="do_createProf">

<?php endif; ?>

    <div>

        <label>Nom complet
            <input type="text" name="nomPrenom" value="<?= $nom ?>" required>
        </label>
    </div>
    <div>
        <label>E-mail (sert d'identifiant)
            <input type="text" name="login" value="<?= $login ?>" required>
        </label>
    </div>

    <div>
        <label>
            <input type="checkbox" name="isAdmin" <?= $isAdmin ? "checked" : "" ?>>
            Administrateur
        </label>
    </div>

    <div>
        <label>Matière
            <select name="idMatiere" required>
                <?php while ($row = $matieres->fetch()) : ?>
                    <option value="<?= htmlspecialchars($row['id']) ?>"<?= ($row['id'] == $idMatiere) ? " selected" : "" ?>><?= htmlspecialchars($row['libelle']) ?></option>
                <?php endwhile; ?>
            </select>
        </label>
    </div>


    <input type="submit" value="Enregistrer">

</form>

<form action="index.php" method="POST">
    <input type="hidden" name="action" value="do_deleteProf">
    <input type="hidden" name="idProf" value="<?= htmlspecialchars($idProf) ?>">
    <input type="submit" value="Supprimer cet utilisateur">
</form>



<form action="index.php" method="POST">
    <input type="hidden" name="action" value="show_listeProf">
    <input type="submit" value="Retour">
</form>






<?php
$content = ob_get_clean();
require('template.php');
?>