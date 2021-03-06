<?php
$title = $isEdit? "Editer la question" : "Ajouter une question";

ob_start();

require('view/headerUserView.php');
?>
<h1><?=$title?></h1>


<?php
//Mode édition de la question
    if($isEdit){
?>
<form action="index.php" method="POST">
    <input type="hidden" name="action" value="do_questionUpdate">
    <input type="hidden" name="idQuestion" value="<?=$question['id']?>">
    <input type="hidden" name="idQuestionnaire" value="<?=$question['id_questionnaire']?>">
    <input type="text" name="libelle" id="" minlength="3" maxlength="200" size="80" value="<?=$question['libelle']?>" required>
    <input type="submit" value="Enregistrer">
    <input type="submit" value="Enregistrer et nouvelle question" name="saveAndOpenNew">
</form>

<?php
    }
    //Mode ajout d'une nouvelle question
    else{
?>
<form action="index.php" method="POST">
    <input type="hidden" name="action" value="do_questionAdd">
    <input type="hidden" name="idQuestionnaire" value="<?=$idQuestionnaire?>">
    <input type="text" name="libelle" id="" minlength="3" maxlength="200" size="80" required>
    <input type="submit" value="Enregistrer">
    <input type="submit" value="Enregistrer et nouvelle question" name="saveAndOpenNew">
</form>

<?php
    }
?>



<form action="index.php" method="post">
    <input type="hidden" name="action" value="show_questionnaireDetail">
    <input type="hidden" name="idQuestionnaire" value="<?= $isEdit?$question['id_questionnaire']:$idQuestionnaire?>">
    <input type="submit" value="Retour au questionnaire">
</form>










<?php
$content = ob_get_clean();
require('template.php');
?>