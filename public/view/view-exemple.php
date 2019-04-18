<?php
$title = 'Le titre de ma page';
ob_start();
?>

<!--Insérer ici le code HTML -->
<!--Cette partie sera tout ce que se trouve dans la balise <body> du template-->
<!--Tout le html placé entre les fonctions ob_start() et ob_get_clean() sera injecté dans la variable $content-->
<!--puis envoyé dans template.php -->
<!--Ca permet entre autres d'éviter de se retaper un !DOCTYPE et <HEADER> complet pour chaque page  -->









<?php
$content = ob_get_clean();
require('template.php');
?>