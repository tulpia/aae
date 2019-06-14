<?php
$title = 'Nouveau Questionnaire';
ob_start();

require('view/headerUserView.php');
?>
<article class="title-list">
    <h1><?= $title ?></h1>
</article>


<form action="index.php" method="post">
    <input type="hidden" name="action" value="do_questionnaireAdd">

    <div class="input-row">
        <label for="QuestionnaireTitre">Titre</label>
        <input type="text" name="titre" id="QuestionnaireTitre" minlength="3" maxlength="200" size="80" required>
    </div>


    <div class="input-row">
        <label for="questionnaireClasse">Classe</label>
        <select name="idClasse" id="questionnaireClasse">
            <option value="0">- Aucune -</option>

            <?php
            while ($row = $classes->fetch()) {
                $id = htmlspecialchars($row['id']);
                $libelle = htmlentities($row['libelle']);
                echo ('<option value="' . $id . '">' . $row['libelle'] . '</option>');
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
                echo ('<option value="' . $id . '">' . $libelle . '</option>');
            }

            ?>


        </select>
    </div>

    <label class="btn btn-detail">
        <input type="submit" value="Enregistrer">
    </label>

</form>



<form action="index.php" method="post">
    <input type="hidden" name="action" value="show_questionnaireList">
    <label class="btn btn-supr">
        <input type="submit" value="Annuler">
    </label>
</form>




<?php
$content = ob_get_clean();
require('template.php');
?>