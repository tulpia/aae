<!-- Header user à incorporer sur quasi chaque page -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../dist/styles.css">
    <!--Variable titre de la page-->
    <title><?= $title ?></title>
</head>
<main class="wrapper">
<header>
    <a href="index.php">retour à l'acceuil</a>

    <form action="index.php" method="post">
        <input type="hidden" name="action" value="do_disconnect">
        <input type="submit" value="Se déconnecter">
    </form>
</header>