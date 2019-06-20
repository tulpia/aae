<?php
$title = "profil de l'élève " . htmlspecialchars($eleve['login']);
ob_start();

require('view/headerUserView.php');
$annee = (int)$eleve['anneeScolaire'];
?>

<h1><?= $title ?></h1>

<form action="index.php" method="POST">
    <input type="hidden" name="idEleve" value="<?= htmlspecialchars($eleve['id']) ?>">
    <input type="hidden" name="action" value="do_updateEleve">


    <p>Année scolaire : <?= $annee . "-" . ($annee + 1) ?></p>

    <div>
        <p>Classe</p>
        <?php while ($classe = $classes->fetch()) : ?>
            <div>
                <label>
                    <input type="radio" name="idClasse" value="<?= (int)$classe['id'] ?>" <?= ($classe['id'] == $eleve['id_classe']) ? " checked" : "" ?>>
                    <?= htmlspecialchars($classe['libelle']) ?></label>
            </div>
        <?php endwhile ?>
    </div>


    <div>
        <p>Nom de la classe</p>
        <?php while ($classeNom = $classeNoms->fetch()) : ?>
            <div>
                <label>
                    <input type="radio" name="idClasseNom" value="<?= (int)$classeNom['id'] ?>" <?= ($classeNom['id'] == $eleve['id_classeNom']) ? " checked" : "" ?>>
                    <?= htmlspecialchars($classeNom['libelle']) ?></label>
            </div>
        <?php endwhile ?>
    </div>

    <div>
        <p>Options de cours</p>
        <?php
        $optionsEleve = explode(";", htmlspecialchars($eleve['optionCours']));
        while ($option = $optionCours->fetch()) :
            ?>
            <div>
                <label>
                    <input type="checkbox" name="idOptionCours[]" value="<?= htmlspecialchars($option['id']) ?>" <?= in_array($option['id'], $optionsEleve) ? " checked" : "" ?>>
                    <?= htmlspecialchars($option['libelle']) ?></label>
            </div>
        <?php endwhile ?>
    </div>

    <input type="submit" value="Valider">

</form>

<form action="index.php" method="POST">
    <input type="hidden" name="action"  value="show_listeEleves">
    <input type="submit" value="Retour">
</form>

<form action="index.php" method="POST">
    <input type="hidden" name="idEleve" value="<?= htmlspecialchars($eleve['id']) ?>">
    <input type="hidden" name="action"  value="do_deleteEleve">
    <input type="submit" value="Supprimer cet élève">
</form>

<form action="index.php" method="POST">
    <input type="hidden" name="dateCreation" value="<?= htmlspecialchars($eleve['dateCreation']) ?>">
    <input type="hidden" name="action"  value="do_deleteEleveDate">
    <input type="submit" value="Supprimer tous les élèves
    créés le <?= htmlspecialchars($eleve['dateCreation']) ?>">
</form>



<?php
$content = ob_get_clean();
require('template.php');
?>