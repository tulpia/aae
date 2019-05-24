<?php
$title = 'Détail du questionnaire';
$isAuMoinsUneQuestion = false;

ob_start();

require('view/headerUserView.php');
?>
<article class="title-list">
    <h1><?= $title ?></h1>
</article>

<!-- Form update du questionnaire -->
<form action="index.php" method="POST">
    <input type="hidden" name="action" value="do_questionnaireUpdate">
    <input type="hidden" name="idQuestionnaire" value="<?= $questionnaire['id'] ?>">

    <div class="input-row">
        <label for="QuestionnaireTitre">Titre</label>
        <input type="text" name="titre" id="QuestionnaireTitre" value="<?= $questionnaire['titre'] ?>" minlength="3" maxlength="200" size="80" required>
    </div>


    <div class="input-row">
        <label for="questionnaireClasse">Classe</label>
        <select name="idClasse" id="questionnaireClasse">
            <option value="0">- Aucune -</option>

            <?php
            while ($row = $classes->fetch()) {
                $id = htmlspecialchars($row['id']);
                $libelle = htmlspecialchars($row['libelle']);
                $selected = $id == $questionnaire['id_classe'] ? ' selected' : '';

                echo ('<option value="' . $id . '" ' . $selected . '>' . $libelle . '</option>
                ');
            }
            ?>

        </select>
    </div>


    <div class="input-row">
        <label for="questionnaireMatiere">Matière</label>
        <select name="idMatiere" id="questionnaireMatiere">

            <?php
            while ($row = $matieres->fetch()) {
                $id = htmlspecialchars($row['id']);
                $libelle = htmlspecialchars($row['libelle']);
                $selected = $id == $questionnaire['id_matiere'] ? ' selected' : '';

                echo ('<option value="' . $id . '" ' . $selected . '>' . $libelle . '</option>
                ');
            }

            ?>
        </select>
    </div>
<div class="input-blank"></div>

    <label class="btn btn-detail">
        <input type="submit" value="Enregistrer le questionnaire">
    </label>
    <label class="btn btn-detail">
        <input type="submit" value="Enregistrer et créer un nouveau questionnaire" name="saveAndOpenNew">
    </label>
</form>


<!-- Suppression du questionnaire  -->
<form action="index.php" method="POST">
    <input type="hidden" name="action" value="do_questionnaireDelete">
    <input type="hidden" name="idQuestionnaire" value="<?= $questionnaire['id'] ?>">
    <label class="btn btn-detail btn-supr">
        <input type="submit" value="Supprimer ce questionnaire">
    </label>
</form>

<div class="input-blank"></div>

<section>
    <h1>Questions</h1>
    <table class="aae-table">
        <?php
        while ($question = $questions->fetch()) {
            //Au moins une question dans le tableau, on fait apparaître le bouton
            //pour créer une autoévaluation.
            $isAuMoinsUneQuestion = true;
            ?>
            <tr>
                <td><?= $question['quantieme'] ?></td>
                <td><?= $question['libelle'] ?></td>
                <td>
                    <!-- Bouton d'édition de la question -->
                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="show_questionEdit">
                        <input type="hidden" name="idQuestion" value="<?= $question['id'] ?>">
                        <label class="btn-question-edit">
                            <input type="submit" value="Editer">
                         </label>
                    </form>
                </td>
                <td>
                    <!-- Bouton suppression de la question -->
                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="do_questionDelete">
                        <input type="hidden" name="idQuestion" value="<?= $question['id'] ?>">
                        <input type="hidden" name="idQuestionnaire" value="<?= $question['id_questionnaire'] ?>">
                        <label class="btn-question-edit">
                            <input type="submit" value="Supprimer">
                        </label>
                    </form>
                </td>
            </tr>

        <?php
    }
    ?>


    </table>

    <!-- Bouton d'ajout de nouvelle question -->
    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="show_questionNew">
        <input type="hidden" name="idQuestionnaire" value="<?= $idQuestionnaire ?>">
        <label class="btn btn-detail">
            <input type="submit" value="ajouter une question">
        </label>
    </form>

</section>

<?php
if ($isAuMoinsUneQuestion) {
    ?>
    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="show_autoEvalDistribuer">
        <input type="hidden" name="idQuestionnaire" value="<?= $idQuestionnaire ?>">
        <label class="btn btn-detail">
            <input type="submit" value="Distribuer ce questionnaire">
        </label>
    </form>
<?php
}
?>



<form action="index.php" method="post">
    <input type="hidden" name="action" value="show_questionnaireList">
    <label class="btn btn-detail btn-back">
        <input type="submit" value="Retour à la liste">
    </label>
</form>





<?php
$content = ob_get_clean();
require('template.php');
?>