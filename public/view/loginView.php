<?php

$title = 'AAE - Identification';
ob_start();

?>
<header class="block-header">
    <div class="block-header__img-container">
        <img src="./view/dist/images/bg-home.jpg" alt="background-home">
    </div>
    <h1 class="block-header__title">Bienvenue sur l'application <span>d'auto évaluation</span></h1>
</header>

<?php
    if(isset($message) && $message != ''){
        echo("<p><br><br>" . $message . "<br><br></p>");
    }
?>




<!-- Saisie login-MDP -->
<section class="block-login">
    <section class="block-login__block-etudiant">
        <form action="index.php" method="post" class="block-etudiant__form-container">
            <input type="hidden" name="action" value="do_login">
            <input type="hidden" name="isProf" value="0">
            <div class="aae-radio">
                <input type="radio" name="isProf" value="0" id="isprof0" checked><label for="isprof0">Je suis élève</label>
                <input type="radio" name="isProf" value="1" id="isprof1"><label for="isprof1">Je suis enseignant</label>
            </div>
            <div class="input-container login">
                <input type="text" name="login" placeholder="id Eleve ou Mail Prof" value="" class="input input--text">
            </div>
            <div class="input-container pwd">
                <input type="password" name="pwd" placeholder="Password (visible uniquement quand enseignant)" value="" class="input input--text">
            </div>
            <label class="btn btn-submit">
                <input type="submit" value="Connexion">
            </label>
        </form>
    </section>

    <!-- Interface prof avec l'id_user = 4 et admin -->
    <!-- <section class="block-login__block-prof">
        <form action="index.php" method="post" class="block-prof__form-container">
            <input type="hidden" name="action" value="login">
            <input type="hidden" name="isProf" value="1">
            <input type="hidden" name="login" value="">
            <input type="hidden" name="pwd" value="">
            <label class="btn btn-prof">
                <input type="submit" value="Interface enseignant">
            </label>
        </form>
    </section>-->

    <form action="index.php" method="POST" class="right_content">
        <input type="hidden" name="action" value="show_passwordForget">
        <label class="btn-link">
            <input type="submit" value="Mot de passe oublié ? (visible uniquement quand enseignant)">
        </label>
    </form>


    <p class="card">
        <br><br>
        Hey Salut ! C'est moi la balise dégueu !<br>
        Voilà les id de test pour se connecteur<br><br>

        Prof 01<br>
        Login : sayhelloroger@gmail.com  /  pwd : 1234<br><br>

        Prof 02<br>
        Login : david.klein.fr@protonmail.com  /  pwd : 1234<br><br>

        Elève 01<br>
        Login : 18-0001 <br><br>

        Elève 02<br>
        Login : 18-0002<br><br>

    </p>

</section>




<?php
$content = ob_get_clean();
require('template.php');
?>