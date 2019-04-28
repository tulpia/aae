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
<body>
    <!--Variable contenu du Body-->
    <main class="wrapper">
        <?= $content ?>
        <?php include('footer-general.php'); ?>
    </main>
    <script src="../dist/main.js"></script>
</body>
</html>