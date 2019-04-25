<?php
$title = 'Distribuer une autoévaluation';
ob_start();

require('view/headerUserView.php');
?>
<h1><?= $title ?></h1>

<form action="index.php" method="post">
    <input type="hidden" name="action" value="do_autoEvalDistribuer">
    <input type="hidden" name="idQuestionnaire" value="<?= htmlspecialchars($idQuestionnaire)?>">

    <div>
        <!-- Titre de l'autoéval : Modifiable -->
        <label>Titre</label>
        <input type="text" name="titre" id="QuestionnaireTitre" value="<?= htmlspecialchars($questionnaire['titre']) ?>" minlength="3" maxlength="200" size="80" required>
    </div>


    <!-- Choix de la matière, par défaut celle du questionnaire, mais on peut y mettre ce qu'on veut -->
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


    <div>
        <!-- Date à partir de laquelle l'autoéval sera visible par les élèves -->
        <label>Visible à partir du</label>
        <input type="date" name="dateAccessible" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
    </div>

    <div>
        <!-- Permet aux élèves de laisser un commentaire en fin d'autoéval -->
        <label><input type="checkbox" name="isCommentairePermis">Permettre aux élèves de laisser un commentaire en fin d'autoévaluation</label>
    </div>


    <div>
        <!-- Choix du niveau de la classe : Un seul niveau à chaque fois -->
        <label>Classe</label>

        <?php
        while ($classe = $classes->fetch()) {
            $id = htmlspecialchars($classe['id']);
            $libelle = htmlspecialchars($classe['libelle']);
            $checked = $id == $questionnaire['id_classe'] ? ' checked' : '';
            ?>
            <div>
                <label><input type="radio" name="idClasse" value="<?= $id ?>" <?= $checked ?> required><?= $libelle ?></label>
            </div>
        <?php
    }
    ?>
    </div>



    <div>
        <!-- Choix du nom de la classe : Il peut y en avoir plusieurs dans le cas de groupes de langue -->
        <label>Nom classe</label>
        <?php
        while ($nom = $classeNoms->fetch()) {
            $id = htmlspecialchars($nom['id']);
            $libelle = htmlspecialchars($nom['libelle']); ?>
            <div>
                <label><input type="checkbox" name="IdClasseNoms[]" value="<?= $id ?>"><?= $libelle ?></label>
            </div>

        <?php
    }
    ?>
    </div>


    <div>
        <!-- Permet de choisir les options de cours de la classe, pour ne sélectionner que les élèves allemand LV1 par exemple -->
        <label>Options de cours</label>
        
        <!-- TODO pour les Fronteux, en JS faire en sorte qu'en cochant cette case toutes les autres se décochent
    et inversement : Si on coche une des autres checkbox seule la première se décoche
Merci bisous <3  <3  <3 -->
        <div>
            <label><input type="radio" name="idOptionCours" value="0" checked><strong>Classe complète</strong></label>
        </div>
        <?php
        while ($option = $optionCours->fetch()) {
            $id = htmlspecialchars($option['id']);
            $libelle = htmlspecialchars($option['libelle']);
            ?>
            <div>
                <label><input type="radio" name="idOptionCours" value="<?= $id ?>"><?= $libelle ?></label>
            </div>


        <?php

    }

    ?>


    </div>

    <input type="submit" value="Distribuer l'auto-évaluation">

</form>

<form action="index.php" method="post">
    <input type="hidden" name="action" value="show_questionnaireDetail">
    <input type="hidden" name="idQuestionnaire" value="<?=$idQuestionnaire?>">
    <input type="submit" value="Annuler">
</form>

</main>



<?php
$content = ob_get_clean();
require('footerUserView.php');
require('template.php');
?>