<?php


$idAutoEval = (int)$autoEval['id'];
$title = htmlspecialchars($autoEval['titre']);
$isCommentaire = (bool)$autoEval['is_commentairePermis'];

ob_start();
?>

<h1><?= $title ?></h1>

<section>
    <h2>Mes questions</h2>

    <form action="index.php?action=do_ReponseEleveEnregistrer" method="POST">
        <input type="hidden" name="idAutoEval" value="<?= $idAutoEval ?>">


        <?php
        while ($question = $questions->fetch()) {
            $idQuestion = htmlspecialchars($question['id']);
            $libelle = htmlspecialchars($question['libelle']);
            $quantieme = htmlspecialchars($question['quantieme']);
            
            ?>
            

            <div><?= $quantieme . " - " . $libelle?>
                <label><input type="radio" required name="arrayIdReponse[<?=$idQuestion?>]" value="30">:D</label>
                <label><input type="radio" required name="arrayIdReponse[<?=$idQuestion?>]" value="20">:)</label>
                <label><input type="radio" required name="arrayIdReponse[<?=$idQuestion?>]" value="10">:|</label>
                <label><input type="radio" required name="arrayIdReponse[<?=$idQuestion?>]" value="0">:(</label>
            </div>
        <?php
    }
    ?>
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








<?php
$content = ob_get_clean();
require('template.php');
?>