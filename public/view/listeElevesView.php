<?php
$title = 'Liste des élèves';
ob_start();

//Le header de l'utilisateur qui permet de retourner à l'accueil ou de se déconnecter (à faire)
require('view/headerUserView.php');
?>

<h1><?= $title ?></h1>


<!-- Partie filtres -->
<form action="index.php" method="post">
    <input type="hidden" name="action" value="show_listeElevesFilter">
    <p>Filtres</p>
    <div>
        <label>Identifiant
            <input type="text" name="login" max="200" value="<?=$filterLogin?>">
        </label>
    </div>

    <div>
        <label>Année Scolaire
            <select name="anneeScolaire">
                <?php
                while ($annee = $listAnneeScolaire->fetch()) :
                    ?>
                    <option value="<?= htmlspecialchars($annee['valueYear']) ?>" <?= $annee['valueYear'] == $filterAnneScolaire ? " selected" : "" ?>><?= htmlspecialchars($annee['displayYear']) ?></option>
                <?php endwhile; ?>
            </select>
        </label>
    </div>


    <div>
        <label>Classe
            <select name="idclasse">
                <option value="0">- Toutes -</option>
                <?php
                while ($classe = $listClasse->fetch()) :
                    ?>
                    <option value="<?= htmlspecialchars($classe['id']) ?>" <?= $classe['id'] == $filterIdClasse ? " selected" : "" ?>><?= htmlspecialchars($classe['libelle']) ?></option>
                <?php endwhile; ?>
            </select>
        </label>
    </div>

    <div>
        <label>Nom de la classe
            <select name="idclasseNom">
                <option value="0">- Tous -</option>
                <?php
                while ($classeNom = $listClasseNom->fetch()) :
                    ?>
                    <option value="<?= htmlspecialchars($classeNom['id']) ?>" <?= $classeNom['id'] == $filterIdClasseNom ? " selected" : "" ?>><?= htmlspecialchars($classeNom['libelle']) ?></option>
                <?php endwhile; ?>
            </select>
        </label>
    </div>

    <div>
        <label>Option de cours
            <select name="idOptionCours">
                <option value="0">- Toutes -</option>
                <?php
                while ($option = $listOptionCours->fetch()) :
                    ?>
                    <option value="<?= htmlspecialchars($option['id']) ?>" <?= $option['id'] == $filterIdOptionCours ? " selected" : "" ?>><?= htmlspecialchars($option['libelle']) ?></option>
                <?php endwhile; ?>
            </select>
        </label>
    </div>

    <div>
        <label>Date de création
            <select name="dateCreation">
                <option value="1900-01-01">- Toutes -</option>
                <?php
                while ($dateCrea = $listDateCreation->fetch()) :
                    ?>
                    <option value="<?= htmlspecialchars($dateCrea['valueDate']) ?>" <?= $dateCrea['valueDate'] == $filterDateCreation ? " selected" : "" ?>><?= htmlspecialchars($dateCrea['displayDate']) ?></option>
                <?php endwhile; ?>
            </select>
        </label>
    </div>


    <input type="submit" value="Rechercher">

</form>


<div>
    <p><?= $listEleve->rowCount() . " élève" . ($listEleve->rowCount() !== 1 ? "s" : "") ?></p>

    <table>
        <thead>
            <th>Identifiant</th>
            <th>Classe</th>
            <th>Option de cours</th>
            <th>Année scolaire</th>
            <th>Créé le</th>
            <th></th>
        </thead>

        <?php while ($eleve = $listEleve->fetch()) :
            $idEleve = htmlspecialchars($eleve['id']);
            $identifiant = htmlspecialchars($eleve['login']);
            $classeText = htmlspecialchars($eleve['classe']);
            $optionCoursText = htmlspecialchars($eleve['optionCours']);
            $anneeScolaireText = htmlspecialchars($eleve['anneeScolaire']);
            $dateCreaText = htmlspecialchars($eleve['dateCreation']);
            ?>

            <tr>
                <td><?=$identifiant?></td>
                <td><?=$classeText?></td>
                <td><?=$optionCoursText?></td>
                <td><?=$anneeScolaireText?></td>
                <td><?=$dateCreaText?></td>
                <td>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="show_detailEleve">
                        <input type="hidden" name="idEleve" value="<?=$idEleve?>">
                        <input type="submit" value="Voir">
                    </form>
                </td>
            </tr>

        <?php endwhile; ?>

    </table>
</div>







<?php
$content = ob_get_clean();
require('template.php');
?>