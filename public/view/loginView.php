<?php

$title = 'identification';
ob_start();

?>



<h1>Bienvenue</h1>
<h2>Choisissez votre interface</h2>

<!-- <div><br><br><?php //echo($errorMessage); ?><br><br></div> -->

<!-- Interface prof avec l'id_user = 4 et admin -->
<div>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="login">
        <input type="hidden" name="isProf" value="1">
        <input type="hidden" name="login" value="">
        <input type="hidden" name="pwd" value="">
        <input type="submit" value="Interface enseignant">
    </form>
</div>


<!-- Interface élève avec l'id_user = 5 -->
<div>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="login">
        <input type="hidden" name="isProf" value="0">
        <input type="hidden" name="login" value="">
        <input type="hidden" name="pwd" value="">
        <input type="submit" value="Interface élève">
    </form>
</div>

<!-- 
<div><a href="index.php?action=accueil&amp;isProf=1&amp;idUser=4&amp;isAdmin=1" rel="noopener noreferrer"></a></div>
<div><a href="index.php?action=accueil&amp;isProf=0&amp;idUser=5" rel="noopener noreferrer">Interface élève</a></div>
 -->


<?php
$content = ob_get_clean();
require('template.php');
?>