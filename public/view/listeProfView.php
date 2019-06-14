<?php
$title = 'Liste des enseignants';
ob_start();

//Le header de l'utilisateur qui permet de retourner à l'accueil ou de se déconnecter (à faire)
require('view/headerUserView.php');

?>

<section>
<article class="title-list">
    <h1><?= $title ?></h1>
</article>
   
    <br>

    <?php include("message.php"); ?>

    <?php while ($row = $listProfs->fetch()) : ?>

        <article class="question-container little">
            <div class="questions-container__title-container">
                <p class="question-container__title"><?= htmlspecialchars($row['nomPrenom']) ?></p>
                <form action="index.php" method="post" class="questions-container__btn-editer">
                    <input type="hidden" name="action" value="show_profDetailEdit">
                    <input type="hidden" name="idProf" value="<?= htmlspecialchars($row['id']) ?>">
                    <label class="btn-editer">
                        <input type="submit" value="Voir" class="btn-editer-text">
                    </label>
                </form>
            </div>
            <section class="question-container__details listing">
                <p class="details__classe"><?= htmlspecialchars($row['matiere']) ?> <span><?= (bool)$row['is_admin'] === true ? "Administrateur" : ""; ?></span></p>
                <p class="details__classe"><?= htmlspecialchars($row['login']) ?></p>
            </section>
            <br>
        </article>


    <?php endwhile; ?>

    <div>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="show_profDetailNew">
            <label class="btn btn-detail">
                <input type="submit" value="Créer un nouvel enseignant">
            </label>
        </form>
    </div>

</section>



<?php
$content = ob_get_clean();
require('template.php');
?>