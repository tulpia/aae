<?php
$title = $isEdit? "Editer la question" : "Ajouter une question";
ob_start();
?>
<h1><?=$title?></h1>


<?php
//Mode édition de la question
    if($isEdit){
?>
<form action="index.php?action=do_questionUpdate" method="POST">
    <input type="hidden" name="idQuestion" value="<?=$question['id']?>">
    <input type="hidden" name="idQuestionnaire" value="<?=$question['id_questionnaire']?>">
    <input type="text" name="libelle" id="" minlength="3" maxlength="200" size="80" value="<?=$question['libelle']?>" required>
    <input type="submit" value="Enregistrer">
</form>

<?php
    }
    //Mode ajout d'une nouvelle question
    else{
?>
<form action="index.php?action=do_questionAdd" method="POST">
    <input type="hidden" name="idQuestionnaire" value="<?=$idQuestionnaire?>">
    <input type="text" name="libelle" id="" minlength="3" maxlength="200" size="80" required>
    <input type="submit" value="Enregistrer">
</form>

<?php
    }
?>



<a href="javascript:history.go(-1)">Annuler</a>










<?php
$content = ob_get_clean();
require('template.php');
?>