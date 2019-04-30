<?php
$title = 'Renvoyer un nouveau mot de passe';
ob_start();
?>

<a href="index.php">Retour à l'accueil</a>

<?php
if (isset($message) && $message !== "") {
    echo ("<br><br><p>" . htmlspecialchars($message) . "</p><br><br>");
}
?>


<form action="index.php" method="POST">
    <p>Saisissez votre e-mail de connexion et validez, vous recevrez votre nouveau mot de passe</p>
    <input type="hidden" name="action" value="do_sendPasswordResetMail">
        <div class="input-container">
            <input type="text" name="eMail" placeholder="saisissez votre e-mail ce connexion" value="" class="input input--text" required>
        </div>
        <label class="btn btn-submit">
                <input type="submit" value="Envoyer">
            </label>
</form>









<?php
$content = ob_get_clean();
require('template.php');
?>