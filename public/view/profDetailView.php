<?php

//Par défaut, mode ajout d'un nouveau prof
$isEdit = false;
$nom = "";
$login = "";
$isAdmin = false;
$idMatiere = 1;
$title = "Créer un nouvel enseignant";

if (isset($prof)) {
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
<article class="title-list">
    <h1><?= $title ?></h1>
</article>


<?php include("message.php"); ?>



<form action="index.php" method="POST">

    <?php if ($isEdit) : ?>
        <input type="hidden" name="action" value="do_updateProf">
        <input type="hidden" name="idProf" value="<?= htmlspecialchars($idProf) ?>">

    <?php else : ?>
        <input type="hidden" name="action" value="do_createProf">

    <?php endif; ?>

    <div class="input-row">
        <label class="w-100">Nom complet
            <input type="text" name="nomPrenom" value="<?= $nom ?>" required>
        </label>
    </div>
    <div class="input-row">
        <label class="w-100">E-mail (sert d'identifiant)
            <input type="text" name="login" value="<?= $login ?>" required>
        </label>
    </div>

    <div class="input-row">
        <label class="w-100">
            <input type="checkbox" name="isAdmin" <?= $isAdmin ? "checked" : "" ?>>
            Administrateur
        </label>
    </div>

    <div class="input-row">
        <label class="w-100">Matière
            <select name="idMatiere" required>
                <?php while ($row = $matieres->fetch()) : ?>
                    <option value="<?= htmlspecialchars($row['id']) ?>" <?= ($row['id'] == $idMatiere) ? " selected" : "" ?>><?= htmlspecialchars($row['libelle']) ?></option>
                <?php endwhile; ?>
            </select>
        </label>
    </div>

    <label class="btn btn-detail">
        <input type="submit" value="Enregistrer">
    </label>

</form>


<?php if ($isEdit) : ?>

    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="do_deleteProf">
        <input type="hidden" name="idProf" value="<?= htmlspecialchars($idProf) ?>">
        <label class="btn btn-detail btn-error">
            <input type="submit" value="Supprimer cet utilisateur">
        </label>
    </form>

<?php endif; ?>


<form action="index.php" method="POST">
    <input type="hidden" name="action" value="show_listeProf">
    <label class="btn btn-detail btn-back">
        <input type="submit" value="Retour">
    </label>
</form>






<?php
$content = ob_get_clean();
require('template.php');
?>