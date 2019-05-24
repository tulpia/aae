<?php
$title = 'Liste des enseignants';
ob_start();

//Le header de l'utilisateur qui permet de retourner à l'accueil ou de se déconnecter (à faire)
require('view/headerUserView.php');

?>

<section>
    <h1><?= $title ?></h1>
    <br>

    <?php include("message.php"); ?>

    <?php while ($row = $listProfs->fetch()) : ?>

        <article>
            <div>
                <p><?= htmlspecialchars($row['nomPrenom']) ?></p>
                <form action="index.php" method="post">
                    <input type="hidden" name="action" value="show_profDetailEdit">
                    <input type="hidden" name="idProf" value="<?= htmlspecialchars($row['id']) ?>">
                    <label>
                        <input type="submit" value="Voir">
                    </label>
                </form>
            </div>
            <section>
                <p><?= htmlspecialchars($row['matiere']) ?> <span><?= (bool)$row['is_admin'] === true ? "Administrateur" : ""; ?></span></p>
                <p><?= htmlspecialchars($row['login']) ?></p>
            </section>
            <br>
        </article>


    <?php endwhile; ?>

    <div>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="show_profDetailNew">
            <input type="submit" value="Créer un nouvel enseignant">
        </form>
    </div>

</section>



<?php
$content = ob_get_clean();
require('template.php');
?>