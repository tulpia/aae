<?php
$title = "Profil de l'élève " . htmlspecialchars($eleve['login']);
ob_start();

require('view/headerUserView.php');
$annee = (int)$eleve['anneeScolaire'];
?>

<article class="title-list">
    <h1><?= $title ?></h1>
</article>

<form action="index.php" method="POST">
    <input type="hidden" name="idEleve" value="<?= htmlspecialchars($eleve['id']) ?>">
    <input type="hidden" name="action" value="do_updateEleve">


    <p>Année scolaire : <?= $annee . "-" . ($annee + 1) ?></p>

<!-- <<<<<<<<<<<<<<<<<<<<<<<<<<<< Control group -->
    <div class="container">
        <div class="control-group">
            <h2>Classe</h2>
            <?php while ($classe = $classes->fetch()) : ?>
            <label class="control control--radio"><?= htmlspecialchars($classe['libelle']) ?>
                <input type="radio" name="idClasse" value="<?= (int)$classe['id'] ?>" <?= ($classe['id'] == $eleve['id_classe']) ? " checked" : "" ?>>                    
                <div class="control__indicator"></div>
            </label>
            <?php endwhile ?>
        </div>

        <div class="control-group">
            <h2>Nom de la classe</h2> 
            <?php while ($classeNom = $classeNoms->fetch()) : ?>
            <label class="control control--radio"><?= htmlspecialchars($classeNom['libelle']) ?>
                <input type="radio" name="idClasseNom" value="<?= (int)$classeNom['id'] ?>" <?= ($classeNom['id'] == $eleve['id_classeNom']) ? " checked" : "" ?>>
                <div class="control__indicator"></div>
            </label>
            <?php endwhile ?>
        </div>

        <div class="control-group">
            <h2>Options de cours</h2>
            <?php
            $optionsEleve = explode(";", htmlspecialchars($eleve['optionCours']));
            while ($option = $optionCours->fetch()) :
                ?>
                <!-- <div> -->
                <label class="control control--checkbox"><?= htmlspecialchars($option['libelle']) ?>
                    <input type="checkbox" name="idOptionCours[]" value="<?= htmlspecialchars($option['id']) ?>" <?= in_array($option['id'], $optionsEleve) ? " checked" : "" ?>>
                    <div class="control__indicator"></div>
                </label>
               <!--  </div> -->
            <?php endwhile ?>
        </div>
    </div>

    <!-- <<<<<<<<<<<<<<<<<<<<<<<<<<<< Control group -->
    <label class="btn btn-detail">
        <input type="submit" value="Valider">
    </label>
</form>

<form action="index.php" method="POST">
    <input type="hidden" name="action"  value="show_listeEleves">    
    <label class="btn btn-back btn-detail">
        <input type="submit" value="Retour">
    </label>
</form>

<form action="index.php" method="POST">
    <br><br><br>
    <input type="hidden" name="idEleve" value="<?= htmlspecialchars($eleve['id']) ?>">
    <input type="hidden" name="action"  value="do_deleteEleve">    
    <label class="btn btn-detail btn-error">
        <input type="submit" value="Supprimer cet élève">
    </label>
</form>

<form action="index.php" method="POST">
    <input type="hidden" name="dateCreation" value="<?= htmlspecialchars($eleve['dateCreation']) ?>">
    <input type="hidden" name="action"  value="do_deleteEleveDate">
    <label class="btn btn-detail btn-error btn-delete">
        <input type="submit" value="Supprimer tous les élèves créés &#10; le <?= htmlspecialchars($eleve['dateCreation']) ?>">
    </label>
</form>



<?php
$content = ob_get_clean();
require('template.php');
?>