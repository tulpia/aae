<?php
$title = 'Liste des questionnaires';
ob_start();
//le HTML commence à la fin de la balise PHP

require('view/headerUserView.php');

?>


<h1>Mes modèles de questionnaire</h1>

<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Niveau</th>
            <th>Matière</th>
            <th>Créé le</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        <?php
        //Rajoute chaque questionnaire dans le tableau
        while ($row = $ListeQuestionnaires->fetch()) {
            $id = htmlspecialchars($row['id']);
            $titre = htmlspecialchars($row['titre']);
            $niveau = htmlspecialchars($row['niveau']);
            if ($niveau === "") {
                $niveau = "-";
            }
            $matiere = htmlspecialchars($row['matiere']);
            $dateCrea = htmlspecialchars($row['dateCrea']);
            ?>
            <tr>
                <td><?= $titre ?></td>
                <td><?= $niveau ?></td>
                <td><?= $matiere ?></td>
                <td><?= $dateCrea ?></td>
                <td>
                    <form action="index.php" method="post">
                        <input type="hidden" name="action" value="show_questionnaireDetail">
                        <input type="hidden" name="idQuestionnaire" value="<?= $id ?>">
                        <input type="submit" value="Editer">
                    </form>
                </td>
            </tr>
        <?php
    }
    ?>
    </tbody>
</table>

<form action="index.php" method="post">
    <input type="hidden" name="action" value="show_questionnaireNew">
    <input type="submit" value="Ajouter un nouveau questionnaire !">
</form>




<?php
//le HTML finit avant cette balise PHP et est envoyée dans $content puis inséré dans le template
$content = ob_get_clean();
require('template.php');
?>