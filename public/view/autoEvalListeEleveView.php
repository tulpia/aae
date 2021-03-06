<?php
$title = 'Mes autoévaluations';

$nbAutoEval = 0;
if (isset($autoEvals)) {
    $nbAutoEval = $autoEvals->rowcount();
}

ob_start();

require('view/headerUserView.php');
?>


<section>
    <h1><?= $title ?></h1>

    <!-- Nombres d'autoéval en attente de réponse -->
    <?= "<p>" . $nbAutoEval . "</p>" ?>

    <?php
    if ($nbAutoEval < 1) {
        echo ("<p>Tu n'as pas d'auto évaluations en cours</p>");
    } else {

        while ($row = $autoEvals->fetch()) {
            $idAutoEval = (int)$row['id'];
            $titre = htmlspecialchars($row['titre']);
            $matiere = htmlspecialchars($row['matiere']);
            $prof = htmlspecialchars($row['prof']);

            $nbQuestions = (int)$row['nbQuestions'];
            $nbQuestionsText = $nbQuestions . " question" . ($nbQuestions !== 1 ? 's' : '');

            $dateVisible = new DateTime($row['dateAccessible']);
            $formatter = new IntlDateFormatter(
                'fr_FR',
                IntlDateFormatter::MEDIUM,
                IntlDateFormatter::NONE,
                'Europe/Paris',
                IntlDateFormatter::GREGORIAN,
                null
            );
            $dateText = $formatter->format($dateVisible);


            ?>

            <div>
                <h3><?= $titre ?></h3>
                <p><?= $matiere ?> - <?= $prof ?></p>
                <p><?= $dateText ?></p>
                <p><?= $nbQuestionsText ?></p>
                <form action="index.php" method="POST">
                    <input type="hidden" name="action" value="show_autoEvalQuestionsEleve">
                    <input type="hidden" name="idAutoEval" value="<?= $idAutoEval ?>">
                    <input type="submit" value="Go !">
                </form>
            </div>

        <?php
    }
}
?>

</section>

<!-- </main> -->


<?php
$content = ob_get_clean();
// require('footerUserView.php');
require('template.php');
?>