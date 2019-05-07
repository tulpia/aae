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


$dateDerniereReponse = isset($resultatInfosBase['dateDerReponse']) ? htmlspecialchars($resultatInfosBase['dateDerReponse']) : "-";
$dateEnvoi = isset($resultatInfosBase['dateCreation']) ? htmlspecialchars($resultatInfosBase['dateCreation']) : "-";
$dateVisible = isset($resultatInfosBase['dateAccessible']) ? htmlspecialchars($resultatInfosBase['dateAccessible']) : "-";
$etatArchive = (isset($resultatInfosBase['is_archive']) && (bool)$resultatInfosBase['is_archive'] === true) ? "Archivé" : "Ouvert";
$is_commentairePermis = (isset($resultatInfosBase['is_commentairePermis']) && (bool)$resultatInfosBase['is_commentairePermis'] === true) ? "Oui" : "non";


$commentaires = "";
if (isset($resultatInfosBase['commentaires']) && trim($resultatInfosBase['commentaires']) != '') {
    $commentaires = htmlspecialchars($resultatInfosBase['commentaires']);
    $commentaires = str_replace("|", "&#013;&#010;", $commentaires);
}

?>

<h1><?= $title ?></h1>

<table>
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

<br>
<h2>Questions</h2>

<table>
    <thead>
        <tr>
            <th> </th>
            <th> </th>
            <th>:(</th>
            <th>:|</th>
            <th>:)</th>
            <th>:D</th>
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
                <td><?= $quantieme ?></td>
                <td><?= $question ?></td>
                <td><?= $moinsmoins ?></td>
                <td><?= $moins ?></td>
                <td><?= $plus ?></td>
                <td><?= $plusplus ?></td>
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
    <input type="submit" value="Retour">
</form>

<form action="index.php" method="post">
    <input type="hidden" name="action" value="do_resultatExportCsv">
    <input type="hidden" name="idResultat" value=<?= $idResultat ?>>
    <input type="submit" value="Exporter en CSV">
</form>


<form action="index.php" method="post">
    <input type="hidden" name="action" value="do_archiverResultat">
    <input type="hidden" name="idResultat" value="<?= $idResultat ?>">
    
    <?php
    if ((bool)$resultatInfosBase['is_archive'] === false) :
    ?>
    
    <input type="hidden" name="isArchive" value="1">
    <input type="submit" value="Archiver cette autoévaluation">
    
    <?php
    else:
    ?>
    
    <input type="hidden" name="isArchive" value="0">
    <input type="submit" value="Rouvrir l'autoévaluation">
    
    <?php
    endif;
    ?>
    
</form>










<?php
$content = ob_get_clean();
require('template.php');
?>