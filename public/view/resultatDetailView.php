<?php
$title = "Résultat de l'autoévaluation";
ob_start();

//Le header de l'utilisateur qui permet de retourner à l'accueil ou de se déconnecter (à faire)
require('view/headerUserView.php');


$titre = "[sans titre]";
if (isset($resultatInfosBase['titre']) && trim($resultatInfosBase['titre']) != '') {
    $titre = htmlspecialchars($resultatInfosBase['titre']);
}


$classe = '';
if (isset($resultatInfosBase['classe']) && trim($resultatInfosBase['classe']) != '') {
    $classe = htmlspecialchars($resultatInfosBase['classe']);
}
$classeNom = '';
if (isset($resultatInfosBase['ClasseNom']) && trim($resultatInfosBase['ClasseNom']) != '') {
    $classeNom = htmlspecialchars($resultatInfosBase['ClasseNom']);
}
$optionCours = '';
if (isset($resultatInfosBase['optionCours']) && trim($resultatInfosBase['optionCours']) != '') {
    $optionCours = htmlspecialchars($resultatInfosBase['optionCours']);
}
$classeComplet = trim($classe . ' ' . $classeNom . ' ' . $optionCours);


$nbRepondu = isset($resultatInfosBase['nbRepondu']) ? (int)$resultatInfosBase['nbRepondu'] : 0;
$nbAutoEval = isset($resultatInfosBase['nbAutoEval']) ? (int)$resultatInfosBase['nbAutoEval'] : 0;
$nbReponses = $nbRepondu . ' / ' . $nbAutoEval;

$anneeScolaire = htmlSpecialChars($resultatInfosBase['anneeScolaire']);

$dateDerniereReponse = isset($resultatInfosBase['dateDerReponse']) ? htmlspecialchars($resultatInfosBase['dateDerReponse']) : "-";
$dateEnvoi = isset($resultatInfosBase['dateCreation']) ? htmlspecialchars($resultatInfosBase['dateCreation']) : "-";
$dateVisible = isset($resultatInfosBase['dateAccessible']) ? htmlspecialchars($resultatInfosBase['dateAccessible']) : "-";
$etatArchive = (isset($resultatInfosBase['is_archive']) && (bool)$resultatInfosBase['is_archive'] === true) ? "Archivé" : "Ouvert";
$is_commentairePermis = (isset($resultatInfosBase['is_commentairePermis']) && (bool)$resultatInfosBase['is_commentairePermis'] === true) ? "Oui" : "non";


$commentaires = "";
if (isset($resultatInfosBase['commentaires']) && trim($resultatInfosBase['commentaires']) != '') {
    $commentaires = htmlspecialchars($resultatInfosBase['commentaires']);
    $commentaires = str_replace("|", "&#13;&#10;", $commentaires);
}

?>
<article class="title-list">
    <h1><?= $title ?></h1>
</article>

<?php include("message.php"); ?>


<table class="aae-table info-table">
    <tr>
        <td>Titre</td>
        <td><?= $titre ?></td>
    </tr>
    <tr>
        <td>Classe</td>
        <td><?= $classeComplet ?></td>
    </tr>
    <tr>
        <td>Nombre de réponses</td>
        <td><?= $nbReponses ?></td>
    </tr>
    <tr>
        <td>Année scolaire</td>
        <td><?= $anneeScolaire ?></td>
    </tr>
    <tr>
        <td>Créé le</td>
        <td><?= $dateEnvoi ?></td>
    </tr>
    <tr>
        <td>Visible le</td>
        <td><?= $dateVisible ?></td>
    </tr>
    <tr>
        <td>Dernière réponse</td>
        <td><?= $dateDerniereReponse ?></td>
    </tr>

    <tr>
        <td>Etat</td>
        <td><?= $etatArchive ?></td>
    </tr>

    <tr>
        <td>Commentaires autorisés</td>
        <td><?= $is_commentairePermis ?></td>
    </tr>
</table>

<div class="input-blank"></div>

<section>
    <h1>Questions</h1>
    <table class="data-table result-table">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col" data-title="Résultats"></th>
                <th scope="col" class="icon-cell very-dissatisfied"></th>
                <th scope="col" class="icon-cell dissatisfied"></th>
                <th scope="col" class="icon-cell satisfied"> </th>
                <th scope="col" class="icon-cell very-satisfied"></th>
            </tr>
        </thead>

        <tbody>

            <?php
            while ($row = $resultatStats->fetch()) :
                $quantieme = isset($row['quantieme']) ? htmlspecialchars($row['quantieme']) : '';
                $question = isset($row['libelle']) ? trim(htmlspecialchars($row['libelle'])) : "-";
                $moinsmoins = isset($row['MoinsMoins']) ? round((float)$row['MoinsMoins'], 2) . '%' : '0%';
                $moins = isset($row['Moins']) ? round((float)$row['Moins'], 2) . '%' : '0%';
                $plus = isset($row['Plus']) ? round((float)$row['Plus'], 2) . '%' : '0%';
                $plusplus = isset($row['PlusPlus']) ? round((float)$row['PlusPlus'], 2) . '%' : '0%';
                ?>

                <tr>
                    <th scope="row"><?=$quantieme?></th>
                    <th scope="row" class="question" data-num="<?=$quantieme?>"><?=$question?></th>
                    <td data-title="very-dissatisfied"><?= $moinsmoins ?></td>
                    <td data-title="dissatisfied"><?= $moins ?></td>
                    <td data-title="satisfied"><?= $plus ?></td>
                    <td data-title="very-satisfied"><?= $plusplus ?></td>
                </tr>

            <?php
        endwhile;
        ?>

        </tbody>
    </table>

    <?php
    if ((bool)$resultatInfosBase['is_commentairePermis'] === true) :
        ?>

        <section>
            <h2>Commentaires</h2>
            <textarea name="" id="" cols="30" rows="10"><?= $commentaires ?></textarea>
        </section>

    <?php
    endif;
    ?>


    <form action="index.php" method="post">
        <label class="btn btn-detail btn-back">
            <input type="submit" value="Retour">
        </label>
    </form>

    <!-- Peite entorse à la règle, ne passe pas par l'index.php sinon exporte le code HTML de la page
    dans le csv, obligé de rediriger vers une page vierge de HTML -->
    <form action="controller/downloadController.php" method="post">
        <input type="hidden" name="action" value="do_resultatExportCsv">
        <input type="hidden" name="idResultat" value=<?= $idResultat ?>>
        <label class="btn btn-detail">
            <input type="submit" value="Exporter en CSV">
        </label>
    </form>

    <form action="index.php" method="post">
        <input type="hidden" name="action" value="do_archiverResultat">
        <input type="hidden" name="idResultat" value="<?= $idResultat ?>">
        
        <?php
        if ((bool)$resultatInfosBase['is_archive'] == false) :
        ?>
        
        <input type="hidden" name="isArchive" value="1">
        
        <label class="btn btn-detail btn-back">
            <input type="submit" value="Archiver cette autoévaluation">
        </label>


        <?php
        else:
        ?>
        
        <input type="hidden" name="isArchive" value="0">
        <label class="btn btn-detail">
            <input type="submit" value="Rouvrir l'autoévaluation">
        </label>
        
        <?php
        endif;
        ?>
        
    </form>
</section>
<!-- // -->







<?php
$content = ob_get_clean();
require('template.php');
?>