<?php
$title = 'Le titre de ma page';
ob_start();

//Le header de l'utilisateur qui permet de retourner à l'accueil ou de se déconnecter (à faire)
require('view/headerUserView.php');
?>

<p>Thank you mario !<br>But this page is in another Castle</p>




<?php
$content = ob_get_clean();
require('template.php');
?>