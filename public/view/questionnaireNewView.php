<?php
$title = 'Nouveau Questionnaire';
ob_start();
?>

<h1><?= $title?></h1>

<form action="index.php?action=do_questionnaireAdd" method="post">

    <div>
        <label for="QuestionnaireTitre">Titre</label>
        <input type="text" name="titre" id="QuestionnaireTitre" minlength="3" maxlength="200" size="80" required>
    </div>


    <div>
        <label for="questionnaireClasse">Classe</label>
        <select name="idClasse" id="questionnaireClasse">
            <option value="0">- Aucune -</option>
        
            <?php
            while ($row = $classes->fetch()) {
                $id = htmlspecialchars($row['id']);
                $libelle = htmlspecialchars($row['libelle']);
                echo('<option value="'. $id .'">' . $libelle . '</option>');
            }
            ?>
        
        </select>
    </div>


    <div>
        <label for="questionnaireMatiere">Matière</label>
        <select name="idMatiere" id="questionnaireMatiere">

            <?php 
            while ($row = $matieres->fetch()) {
                $id = htmlspecialchars($row['id']);
                $libelle = htmlspecialchars($row['libelle']);
                echo('<option value="'. $id .'">' . $libelle . '</option>');
            }
            
            ?>


        </select>
    </div>


    <input type="submit" value="Enregistrer">

</form>








<?php
$content = ob_get_clean();
require('template.php');
?>