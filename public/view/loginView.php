<?php

$title = 'identification';
ob_start();

?>

 

<h1>Bienvenue</h1>
<h2>Choisissez votre interface</h2>

<div><br><br><?=$errorMessage?><br><br></div>

<div><a href="index.php?action=accueil&amp;isProf=1&amp;idUser=4&amp;isAdmin=1" rel="noopener noreferrer">Interface enseignant</a></div>
<div><a href="index.php?action=accueil&amp;isProf=0&amp;idUser=5" rel="noopener noreferrer">Interface élève</a></div>



<?php
$content = ob_get_clean();
require('template.php');
?>