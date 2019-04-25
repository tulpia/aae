<?php


$idAutoEval = (int)$autoEval['id'];
$title = htmlspecialchars($autoEval['titre']);
$isCommentaire = (bool)$autoEval['is_commentairePermis'];

ob_start();

require('view/headerUserView.php');
?>

<h1><?= $title ?></h1>

<section>
    <h2>Mes questions</h2>

    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="do_ReponseEleveEnregistrer">
        <input type="hidden" name="idAutoEval" value="<?= $idAutoEval ?>">

        <table>


            <?php
            while ($question = $questions->fetch()) {
                $idQuestion = htmlspecialchars($question['id']);
                $libelle = htmlspecialchars($question['libelle']);
                $quantieme = htmlspecialchars($question['quantieme']);

                ?>

                <tr>
                    <td><?= $quantieme . " - " . $libelle ?></td>
                    <td><label><input type="radio" required name="arrayIdReponse[<?= $idQuestion ?>]" value="30">:D</label></td>
                    <td><label><input type="radio" required name="arrayIdReponse[<?= $idQuestion ?>]" value="20">:)</label></td>
                    <td><label><input type="radio" required name="arrayIdReponse[<?= $idQuestion ?>]" value="10">:|</label></td>
                    <td><label><input type="radio" required name="arrayIdReponse[<?= $idQuestion ?>]" value="0">:(</label></td>

                </tr>
            <?php
        }
        ?>
        </table>
        <div>
            <?php
            //Si commentaire permis, rajoute un input text, sinon tant met juste un hidden vide pour que la variable existe 
            if (!$isCommentaire) {
                echo ('<input type="hidden" name="commentaire" value="">');
            } else {
                ?>

                <label>Un commentaire ?
                    <input type="text" name="commentaire" minlength="3" maxlength="500" size="50">
                </label>

            <?php
        }
        ?>
        </div>

        <input type="submit" value="Valider">

    </form>


</section>

</main>








<?php
$content = ob_get_clean();
require('footerUserView.php');
require('template.php');
?>