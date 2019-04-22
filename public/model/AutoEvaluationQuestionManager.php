<?php

require_once("Manager.php");


class AutoEvaluationQuestionManager extends Manager
{
    /**
     * Retourne la liste des questions d'une autoévaluation
     *
     * @param  mixed $idAutoEvaluation
     *
     * @return void
     */
    public function getAutoEvaluationQuestions($idAutoEvaluation){
        $db = $this->dbConnect();
        $list = $db->prepare("
        SELECT *
        FROM autoEvaluation_question
        where id_autoEvaluation = ?
        order by quantieme
        ");

        $list->execute([$idAutoEvaluation]);
        return $list;
    }


    /**
     * Créé une question d'autoévaluation basée sur la question du questionnaire
     *
     * @param  mixed $idAutoEvaluation
     * @param  mixed $idQuestionnaire
     *
     * @return void
     */
    public function insertBatchAutoEvaluationQuestion($idAutoEvaluation, $idQuestionnaire){

        //Récupère les questions du questionnaire pour les copier dans les questions des autoévaluations
        $Question = new QuestionnaireQuestionManager();
        $questions = $Question->getQuestions($idQuestionnaire); 


        if($questions->rowCount() > 0){
            $db = $this->dbConnect();
            $query = "INSERT INTO autoEvaluation_question(id_autoEvaluation, quantieme, libelle) VALUES";

            
            for ($i=0; $i < $questions->rowCount(); $i++) { 
                if($i > 0){
                    $query .= ", ";
                }
                $query .= "(:idAutoEvaluation, :quantieme" . $i . ", :libelle" . $i .")";
            }
            

            $insert = $db->prepare($query);
            $insert->bindParam(":idAutoEvaluation", $idAutoEvaluation);
            
            $j = 0;
            while ($row = $questions->fetch()) {
                $insert->bindParam(":quantieme".$j, $row['quantieme']);
                $insert->bindParam(":libelle".$j, $row['libelle']);

                ++$j;
            }

            $insert->execute();
        }
    }


}