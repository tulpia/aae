<?php
$title = 'Détail du questionnaire';
$isAuMoinsUneQuestion = false;

ob_start();
?>
<h1><?= $title ?></h1>

<!-- Form update du questionnaire -->
<form action="index.php?action=do_questionnaireUpdate" method="POST">
    <input type="hidden" name="idQuestionnaire" value="<?= $questionnaire['id'] ?>">

    <div>
        <label for="QuestionnaireTitre">Titre</label>
        <input type="text" name="titre" id="QuestionnaireTitre" value="<?= $questionnaire['titre'] ?>" minlength="3" maxlength="200" size="80" required>
    </div>


    <div>
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


    <div>
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


    <input type="submit" value="Enregistrer le questionnaire">


</form>


<section>
    <h2>Questions</h2>
    <table>
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
                    <form action="index.php?action=show_questionEdit" method="POST">
                        <input type="hidden" name="idQuestion" value="<?= $question['id'] ?>">
                        <input type="submit" value="Editer">
                    </form>
                </td>
                <td>
                    <!-- Bouton suppression de la question -->
                    <form action="index.php?action=do_questionDelete" method="POST">
                        <input type="hidden" name="idQuestion" value="<?= $question['id'] ?>">
                        <input type="hidden" name="idQuestionnaire" value="<?= $question['id_questionnaire'] ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                </td>
            </tr>

        <?php
    }
    ?>


    </table>

    <!-- Bouton d'ajout de nouvelle question -->
    <form action="index.php?action=show_questionNew" method="POST">
        <input type="hidden" name="idQuestionnaire" value="<?= $idQuestionnaire ?>">
        <input type="submit" value="ajouter une question">
    </form>

</section>



<div>
    <a href="javascript:history.go(-1)">Page précédente</a>
</div>





<?php
$content = ob_get_clean();
require('template.php');
?>