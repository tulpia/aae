<?php
$title = 'Mon profil';
ob_start();

//Le header de l'utilisateur qui permet de retourner à l'accueil ou de se déconnecter (à faire)
require('view/headerUserView.php');
?>
<article class="title-list">
    <h1><?= $title ?></h1>
</article>



<div>

    <?php require('view/message.php'); ?>

    <form method="post" action="index.php">
        <input type="hidden" name="action" value="do_updateProf">
        <input type="hidden" name="nextAction" value="show_profilProf">
        <input type="hidden" name="idProf" value="<?= htmlspecialchars($prof['id']) ?>">
        <input type="hidden" name="isAdmin" value="<?= htmlspecialchars($prof['is_admin']) ?>">


        <div class="input-row">
            <label>E-mail d'identification</label>
            <input type="email" name="login" value="<?= $prof['login'] ?>" required>
        </div>

        <div class="input-row">
            <label>Prénom et nom</label>
            <input type="text" name="nomPrenom" value="<?= $prof['nomPrenom'] ?>" required>
        </div>

        <div class="input-row">
            <label>Matière</label>
            <select name="idMatiere">
                    <?php while ($matiere = $matieres->fetch()) : ?>
                        <option value="<?= htmlspecialchars($matiere['id']) ?>" <?= $matiere['id'] == $prof["id_matiere"] ? " selected" : "" ?>><?= htmlspecialchars($matiere['libelle']) ?></option>
                    <?php endwhile ?>
            </select>
        </div>       
        <label class="btn btn-detail">
            <input type="submit" value="Enregistrer les modifications">
        </label>

    </form>

</div>




<div>
    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="do_updatePassword">
        <input type="hidden" name="idProf" value="<?= htmlspecialchars($prof['id']) ?>">
        <br>
        <article class="title-list">
            <h1>Changer de mot de passe</h1>
        </article>
       

        <?php if (isset($messagePassword) && trim($messagePassword) != "") : ?>
            <br><br><h2><?= $messagePassword ?></h2><br>
        <?php endif; ?>

        <div class="input-row">
            <label>Ancien mot de passe</label>
            <input type="password" name="currentPassword" required>
        </div>

        <div class="input-row">
            <label>Nouveau mot de passe</label>
            <input type="password" name="newPassword" required>
        </div>

        <div class="input-row">
            <label>Réécrire le nouveau mot de passe</label>
            <input type="password" name="newPasswordConfirm" required>
        </div>
        <label class="btn btn-detail">
            <input type="submit" value="Enregistrer les modifications">
        </label>

    </form>

</div>




<?php
$content = ob_get_clean();
require('template.php');
?>