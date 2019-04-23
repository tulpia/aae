<?php
$title = 'Mes autoévaluations';

$nbAutoEval = 0;
if(isset($autoEvals)){
    $nbAutoEval = $autoEvals->rowcount();
}

ob_start();
?>

<div><br><a href="index.php" rel="noopener noreferrer">Se déconnecter</a><br></div>


<section>

    <!-- Nombres d'autoéval en attente de réponse -->
    <?= "<p>" . $nbAutoEval . "</p>" ?>

    <?php
        if($nbAutoEval < 1 ){
            echo("<p>Tu n'as pas d'auto évaluations en cours</p>");
        }
        else{

            while ($row = $autoEvals->fetch()) {
                $idAutoEval = (int)$row['id'];
                $titre = htmlspecialchars($row['titre']);
                $matiere = htmlspecialchars($row['matiere']);
                $prof = htmlspecialchars($row['prof']);
                
                $nbQuestions = (int)$row['nbQuestions']; 
                $nbQuestionsText = $nbQuestions . " question" . ($nbQuestions !== 1 ? 's' : '');

                $dateVisible = new DateTime($row['dateAccessible']);
                $formatter = new IntlDateFormatter(
                    'fr_FR',
                    IntlDateFormatter::MEDIUM,
                    IntlDateFormatter::NONE,
                    'Europe/Paris',
                    IntlDateFormatter::GREGORIAN,null);
                $dateText = $formatter->format($dateVisible);
               
                
            ?>

<div>
        <h3><?=$titre?></h3>
        <p><?=$matiere?> - <?=$prof?></p>
        <p><?=$dateText?></p>
        <p><?=$nbQuestionsText?></p>
        <form action="index.php?action=show_autoEvalQuestions">
            <input type="hidden" name="idAutoEval" value="<?=$idAutoEval?>">
            <input type="submit" value="Go !">
        </form>
    </div>

    <?php
            }
        }
    ?>

</section>


<?php
$content = ob_get_clean();
require('template.php');
?>