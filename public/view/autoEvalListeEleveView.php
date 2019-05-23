<?php
$title = 'Mes autoévaluations';

$nbAutoEval = 0;
if (isset($autoEvals)) {
    $nbAutoEval = $autoEvals->rowcount();
}
$arrayOld = [];

ob_start();

require('view/headerUserView.php');
?>


<section class="autoeval-container">
    <article class="title-list">
        <h1><?= $title ?></h1>
    </article>

    <section class="autoeval__new-questions">
        <?php
        if ($nbAutoEval < 1) {
            echo ("<p>Tu n'as pas d'auto évaluations en cours</p>");
        } else {

            while ($row = $autoEvals->fetch()) {
                $idAutoEval = (int)$row['id'];
                $titre = htmlspecialchars($row['titre']);
                $matiere = htmlspecialchars($row['matiere']);
                $prof = htmlspecialchars($row['prof']);
                $isRepondu = (int)$row['isRepondu'];

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
                <?php if ($isRepondu === 0) {
                ?>
                <article class="question-container auto-eval">
                    <div class="questions-container__title-container">
                        <p class="question-container__title"><?= $titre; ?></p>
                        <form action="index.php" method="post" class="questions-container__btn-editer">
                            <input type="hidden" name="action" value="show_autoEvalQuestionsEleve">
                            <input type="hidden" name="idAutoEval" value="<?= $idAutoEval ?>">
                            <label class="btn-editer">
                                <input type="submit" value="Go !" class="btn-editer-text">
                            </label>
                        </form>
                    </div>
                    <section class="question-container__details">
                        <p class="details__matiere"><?= $matiere; ?>, <?= $prof; ?></p>
                        <p class="details__date"><?= $dateText; ?></p>
                    </section>
                </article>
                <?php
                } else {
                    $arrayOld[] = $row;
                } ?>
            <?php
        }
    }
    ?>
    </section>

    <section class="autoeval__old-questions">
        <div class="old-questions__separateur">
            <p>Antérieur</p>
        </div>
        <?php foreach($arrayOld as $question) {
            $titre = htmlspecialchars($question['titre']);
            $dateReponseRaw = new DateTime($question['dateReponse']);
            $dateReponse = $dateReponseRaw->format('d/m/Y');
            ?>
            <article class="question-container expired">
                <div class="questions-container__title-container">
                    <p class="question-container__title"><?= $titre; ?></p>
                    <form action="index.php" method="post" class="questions-container__btn-editer">
                        <input type="hidden" name="action" value="show_autoEvalQuestionsEleve">
                        <input type="hidden" name="idAutoEval" value="<?= $idAutoEval ?>">
                        <label class="btn-editer">
                            <input type="submit" value="Go !" class="btn-editer-text">
                        </label>
                    </form>
                </div>
                <section class="question-container__details">
                    <p class="details__matiere">Réponse enregistrée le <?= $dateReponse; ?></p>
                </section>
            </article>
        <?php } ?>
    </section>
</section>

<!-- </main> -->


<?php
$content = ob_get_clean();
// require('footerUserView.php');
require('template.php');
?>