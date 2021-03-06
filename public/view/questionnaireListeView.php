<?php
$title = 'Liste des questionnaires';
ob_start();
//le HTML commence à la fin de la balise PHP

require('view/headerUserView.php');

?>
<article class="title-list">
    <h1>Mes modèles de questionnaire</h1>
</article>

<section class="list-questions__container">
    <?php
    //Rajoute chaque questionnaire dans le tableau
    while ($row = $ListeQuestionnaires->fetch()) {
        $id = htmlspecialchars($row['id']);
        $titre = htmlspecialchars($row['titre']);
        $niveau = htmlspecialchars($row['niveau']);
        if ($niveau === "") {
            $niveau = "-";
        }
        $matiere = htmlspecialchars($row['matiere']);
        $dateCrea = htmlspecialchars($row['dateCrea']);
        ?>
        <article class="question-container">
            <div class="questions-container__title-container">
                <p class="question-container__title"><?= $titre; ?></p>
                <form action="index.php" method="post" class="questions-container__btn-editer">
                    <input type="hidden" name="action" value="show_questionnaireDetail">
                    <input type="hidden" name="idQuestionnaire" value="<?= $id ?>">
                    <label class="btn-editer">
                        <input type="submit" value="Editer" class="btn-editer-text">
                    </label>
                </form>
            </div>
            <section class="question-container__details">
                <p class="details__matiere"><?= $matiere; ?>, <span class="details__classe"><?= $niveau; ?></span></p>
                <p class="details__date"><?= $dateCrea; ?></p>
            </section>
        </article>
    <?php
}
?>
</section>

<form action="index.php" method="post" class="btn-add-question__container">
    <input type="hidden" name="action" value="show_questionnaireNew">
    <label class="btn-add-question">
        <input type="submit" value="Ajouter un nouveau questionnaire !">
    </label>
</form>




<?php
//le HTML finit avant cette balise PHP et est envoyée dans $content puis inséré dans le template
$content = ob_get_clean();
require('template.php');
?>