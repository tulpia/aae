<?php
$title = 'Distribuer une autoévaluation';
ob_start();
?>
<h1><?= $title ?></h1>

<form action="index.php?action=do_autoEvalDistribuer" method="post">

    <div>
        <!-- Titre de l'autoéval : Modifiable -->
        <label>Titre</label>
        <input type="text" name="titre" id="QuestionnaireTitre" value="<?= $questionnaire['titre'] ?>" minlength="3" maxlength="200" size="80" required>
    </div>

    <div>
        <!-- Date à partir de laquelle l'autoéval sera visible par les élèves -->
        <label>Visible à partir du</label>
        <input type="date" name="dateAccessible" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
    </div>

    <div>
        <!-- Permet aux élèves de laisser un commentaire en fin d'autoéval -->
        <label><input type="checkbox" name="isCommentaire">Permettre aux élèves de laisser un commentaire en fin d'autoévaluation</label>
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
                <label><input type="checkbox" name="idClasseNom[]" value="<?= $id ?>" required><?= $libelle ?></label>
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
            <label><input type="checkbox" name="idOptionCours[]" value="0" required checked><strong>Classe complète</strong></label>
        </div>
        <?php
        while ($option = $optionCours->fetch()) {
            $id = htmlspecialchars($option['id']);
            $libelle = htmlspecialchars($option['libelle']);
            ?>
            <div>
                <label><input type="checkbox" name="idOptionCours[]" value="<?= $id ?>" required><?= $libelle ?></label>
            </div>


        <?php

    }

    ?>


    </div>

    <input type="submit" value="Distribuer l'auto-évaluation">

</form>

<form action="index.php?action=show_questionnaireDetail" method="post">
    <input type="hidden" name="idQuestionnaire" value="<?=$idQuestionnaire?>">
    <input type="submit" value="Annuler">
</form>





<?php
$content = ob_get_clean();
require('template.php');
?>