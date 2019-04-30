<?php

$title = 'AAE - Identification';
ob_start();

?>
<div class="header-bg-blue"></div>
<header class="block-header">
    <div class="block-header__img-container">
        <img src="dist/images/bg-home.jpg" alt="background-home">
    </div>
    <h1 class="block-header__title">APP <span>TITRE</span></h1>
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
            <div class="input-container">
                <input type="text" name="login" placeholder="id Eleve ou Mail Prof" value="" class="input input--text">
            </div>
            <div class="input-container">
                <input type="password" name="pwd" placeholder="Password (visible uniquement quand enseignant)" value="" class="input input--text">
            </div>
            <div>
                <label><input type="radio" name="isProf" value="0" id="" checked>Je suis élève</label>
                <label><input type="radio" name="isProf" value="1" id="">Je suis enseignant</label>
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

    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="show_passwordForget">
        <input type="submit" value="Mot de passe oublié ? (visible uniquement quand enseignant)">
    </form>


    <p>
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