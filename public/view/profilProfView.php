<?php
$title = 'mon profil';
ob_start();

//Le header de l'utilisateur qui permet de retourner à l'accueil ou de se déconnecter (à faire)
require('view/headerUserView.php');
?>

<h1><?= $title ?></h1>


<div>

    <?php require('view/message.php'); ?>

    <form method="post" action="index.php">
        <input type="hidden" name="action" value="do_updateProf">
        <input type="hidden" name="nextAction" value="show_profilProf">
        <input type="hidden" name="idProf" value="<?= htmlspecialchars($prof['id']) ?>">
        <input type="hidden" name="isAdmin" value="<?= htmlspecialchars($prof['is_admin']) ?>">


        <div>
            <label>E-mail (sert d'identifiant)
                <input type="email" name="login" value="<?= $prof['login'] ?>" required>
            </label>
        </div>

        <div>
            <label>Prénom et nom
                <input type="text" name="nomPrenom" value="<?= $prof['nomPrenom'] ?>" required>
            </label>
        </div>

        <div>
            <label>Matière
                <select name="idMatiere">
                    <?php while ($matiere = $matieres->fetch()) : ?>
                        <option value="<?= htmlspecialchars($matiere['id']) ?>" <?= $matiere['id'] == $prof["id_matiere"] ? " selected" : "" ?>><?= htmlspecialchars($matiere['libelle']) ?></option>
                    <?php endwhile ?>
                </select>
            </label>
        </div>       

        <input type="submit" value="Modifier">

    </form>

</div>




<div>
    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="do_updatePassword">
        <input type="hidden" name="idProf" value="<?= htmlspecialchars($prof['id']) ?>">
        <br>
        <p>Changer de mot de passe</p>

        <?php if (isset($messagePassword) && trim($messagePassword) != "") : ?>
            <br><br><h2><?= $messagePassword ?></h2><br>
        <?php endif; ?>

        <div>
            <label>Ancien mot de passe
                <input type="password" name="currentPassword" required>
            </label>
        </div>

        <div>
            <label>Nouveau mot de passe
                <input type="password" name="newPassword" required>
            </label>
        </div>

        <div>
            <label>Réécrire nouveau mot de passe
                <input type="password" name="newPasswordConfirm" required>
            </label>
        </div>

        <input type="submit" value="Modifier">

    </form>

</div>




<?php
$content = ob_get_clean();
require('template.php');
?>