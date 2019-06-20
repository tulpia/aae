<?php
$title = $isEdit ? "Editer la question" : "Ajouter une question";

ob_start();

require('view/headerUserView.php');
?>
<article class="title-list">
    <h1><?= $title ?></h1>
</article>

<?php include("message.php"); ?>

<?php
//Mode édition de la question
if ($isEdit) {
    ?>
    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="do_questionUpdate">
        <input type="hidden" name="idQuestion" value="<?= $question['id'] ?>">
        <input type="hidden" name="idQuestionnaire" value="<?= $question['id_questionnaire'] ?>">
        <input type="text" name="libelle" id="" minlength="3" maxlength="200" size="80" value="<?= $question['libelle'] ?>" required>
        <figure>
            <br>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm-8-9.6c1.248,3.744,4.352,6.4,8,6.4s6.752-2.656,8-6.4Z"/></svg></span>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><g transform="translate(0)"><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm0-4a8.792,8.792,0,0,0,8.192-5.6H23.52a6.361,6.361,0,0,1-11.04,0H9.808A8.792,8.792,0,0,0,18,26.8Z"/></g></svg></span>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><g transform="translate(0)"><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm0-5.6a6.151,6.151,0,0,1,3.152.848c.192-.224,1.376-1.568,1.616-1.824A8.623,8.623,0,0,0,18,22.8a8.837,8.837,0,0,0-4.784,1.408c1.552,1.744.016.032,1.616,1.824A6.4,6.4,0,0,1,18,25.2Z"/></g></svg></span>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm0-9.6a8.792,8.792,0,0,0-8.192,5.6H12.48a6.361,6.361,0,0,1,11.04,0h2.672A8.792,8.792,0,0,0,18,21.2Z"/></svg></span>
            <figcaption style="font-size:0.7em">L'élève répondra par l'un de ces 4 pictos</figcaption>
            <br>
        </figure>
        <label class="btn btn-detail">
            <input type="submit" value="Enregistrer">
        </label>
        <label class="btn btn-detail">
            <input type="submit" value="Enregistrer et nouvelle question" name="saveAndOpenNew">
        </label>
    </form>

<?php
}
//Mode ajout d'une nouvelle question
else {
    ?>
    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="do_questionAdd">
        <input type="hidden" name="idQuestionnaire" value="<?= $idQuestionnaire ?>">
        <input type="text" name="libelle" id="" minlength="3" maxlength="200" size="80" placeholder="Ma question" required>
        <figure>
            <br>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm-8-9.6c1.248,3.744,4.352,6.4,8,6.4s6.752-2.656,8-6.4Z"/></svg></span>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><g transform="translate(0)"><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm0-4a8.792,8.792,0,0,0,8.192-5.6H23.52a6.361,6.361,0,0,1-11.04,0H9.808A8.792,8.792,0,0,0,18,26.8Z"/></g></svg></span>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><g transform="translate(0)"><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm0-5.6a6.151,6.151,0,0,1,3.152.848c.192-.224,1.376-1.568,1.616-1.824A8.623,8.623,0,0,0,18,22.8a8.837,8.837,0,0,0-4.784,1.408c1.552,1.744.016.032,1.616,1.824A6.4,6.4,0,0,1,18,25.2Z"/></g></svg></span>
            <span><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><style>.a{fill:none;}.b{fill:#91cbfc;}</style></defs><path class="a" d="M0,0H36V36H0Z"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(22 12.571)"/><circle class="b" cx="1.5" cy="1.5" r="1.5" transform="translate(11 12.571)"/><path class="b" d="M17.984,2A16,16,0,1,0,34,18,15.992,15.992,0,0,0,17.984,2ZM18,30.8A12.8,12.8,0,1,1,30.8,18,12.8,12.8,0,0,1,18,30.8Zm0-9.6a8.792,8.792,0,0,0-8.192,5.6H12.48a6.361,6.361,0,0,1,11.04,0h2.672A8.792,8.792,0,0,0,18,21.2Z"/></svg></span>
            <figcaption style="font-size:0.7em">L'élève répondra par l'un de ces 4 pictos</figcaption>
            <br>
        </figure>            
        <label class="btn btn-detail">
            <input type="submit" value="Enregistrer">
        </label>
        <label class="btn btn-detail">
            <input type="submit" value="Enregistrer et nouvelle question" name="saveAndOpenNew">
        </label>
    </form>

<?php
}
?>



<form action="index.php" method="post">
    <input type="hidden" name="action" value="show_questionnaireDetail">
    <input type="hidden" name="idQuestionnaire" value="<?= $isEdit ? $question['id_questionnaire'] : $idQuestionnaire ?>">
    <label class="btn btn-back btn-detail">
        <input type="submit" value="Retour au questionnaire">
    </label>
</form>


<article class="title-list">
    <h1>Questions</h1>
    <table class="aae-table">
        <?php while ($question = $questions->fetch()): ?>
            <tr>
                <td><?= $question['quantieme'] ?></td>
                <td><?= $question['libelle'] ?></td>
            </tr>
        <?php endwhile ?>
    </table>
</article>










<?php
$content = ob_get_clean();
require('template.php');
?>