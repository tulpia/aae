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

        <table class="smiley-table">


            <?php
            while ($question = $questions->fetch()) {
                $idQuestion = htmlspecialchars($question['id']);
                $libelle = htmlspecialchars($question['libelle']);
                $quantieme = htmlspecialchars($question['quantieme']);

                ?>

                <tr>
                    <th><?= $question['quantieme'] ?></th>
                    <td><?= $question['libelle'] ?></td>

                    <td class="radio-wrapper clear">
                        <label>
                            <input type="radio" required name="arrayIdReponse[<?= $idQuestion ?>]" value="30">
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm-8-9.6c1.248,3.744,4.352,6.4,8,6.4s6.752-2.656,8-6.4Z"/></svg></span>
                        </label>
                    </td>
                    <td class="radio-wrapper">
                        <label><input type="radio" required name="arrayIdReponse[<?= $idQuestion ?>]" value="20"> 
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><g transform="translate(0)"><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm0-4a8.792,8.792,0,0,0,8.192-5.6H23.52a6.361,6.361,0,0,1-11.04,0H9.808A8.792,8.792,0,0,0,18,26.8Z"/></g></svg></span>
                        </label>
                    </td>
                    <td class="radio-wrapper">
                        <label>
                            <input type="radio" required name="arrayIdReponse[<?= $idQuestion ?>]" value="10">
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><g transform="translate(0)"><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm0-5.6a6.151,6.151,0,0,1,3.152.848c.192-.224,1.376-1.568,1.616-1.824A8.623,8.623,0,0,0,18,22.8a8.837,8.837,0,0,0-4.784,1.408c1.552,1.744.016.032,1.616,1.824A6.4,6.4,0,0,1,18,25.2Z"/></g></svg></span>
                        </label>
                    </td>
                    <td class="radio-wrapper">
                        <label>
                            <input type="radio" required name="arrayIdReponse[<?= $idQuestion ?>]" value="0">
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm0-9.6a8.792,8.792,0,0,0-8.192,5.6H12.48a6.361,6.361,0,0,1,11.04,0h2.672A8.792,8.792,0,0,0,18,21.2Z"/></svg></span>
                        </label>
                    </td>
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
        <label class="btn btn-detail">
            <input type="submit" value="Valider">
        </label>
        

    </form>


</section>

</main>








<?php
$content = ob_get_clean();
// require('footerUserView.php');
require('template.php');
?>