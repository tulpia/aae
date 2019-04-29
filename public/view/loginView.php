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
<!-- <div><br><br><?php //echo($errorMessage); ?><br><br></div> -->

<!-- Interface élève avec l'id_user = 5 -->
<section class="block-login">
    <section class="block-login__block-etudiant">
        <form action="index.php" method="post" class="block-etudiant__form-container">
            <input type="hidden" name="action" value="login">
            <input type="hidden" name="isProf" value="0">
            <div class="input-container">
                <input type="text" name="login" placeholder="id Eleve" value="" class="input input--text">
            </div>
            <input type="hidden" name="pwd" value="">
            <label class="btn btn-submit">
                <input type="submit" value="Connexion">
            </label>
        </form>
    </section>

    <!-- Interface prof avec l'id_user = 4 et admin -->
    <section class="block-login__block-prof">
        <form action="index.php" method="post" class="block-prof__form-container">
            <input type="hidden" name="action" value="login">
            <input type="hidden" name="isProf" value="1">
            <input type="hidden" name="login" value="">
            <input type="hidden" name="pwd" value="">
            <label class="btn btn-prof">
                <input type="submit" value="Interface enseignant">
            </label>
        </form>
    </section>
</section>
<!-- 
<div><a href="index.php?action=accueil&amp;isProf=1&amp;idUser=4&amp;isAdmin=1" rel="noopener noreferrer"></a></div>
<div><a href="index.php?action=accueil&amp;isProf=0&amp;idUser=5" rel="noopener noreferrer">Interface élève</a></div>
 -->


<?php
$content = ob_get_clean();
require('template.php');
?>