<?php

require_once("Manager.php");


class QuestionnaireQuestionManager extends Manager
{
    public function getQuestion($idQuestion)
    {
        $db = $this->dbConnect();
        $question = $db->prepare("select *
        from questionnaire_question
        where id = ?
        and is_softDelete = 0");

        $question->execute(array($idQuestion));

        return $question->fetch();
    }


    public function getQuestions($idQuestionnaire)
    {
        $db = $this->dbConnect();
        $questions = $db->prepare(
            "select *
        from questionnaire_question
        where id_questionnaire = ?
        and is_softDelete = 0
        order by quantieme"
        );

        $questions->execute(array($idQuestionnaire));
        return $questions;
    }

    /**
     * Retourne le dernier numéro de question de ce questionnaire, si aucune question, retourne 0
     *
     * @param  mixed $idQuestionnaire
     *
     * @return int
     */
    protected function getLastQuantieme($idQuestionnaire)
    {
        $db = $this->dbConnect();
        $statementQuantieme = $db->prepare("SELECT MAX(quantieme) as maxQt
        from questionnaire_question
        where is_SoftDelete = 0
        AND id_Questionnaire = ?");
        $statementQuantieme->execute(array($idQuestionnaire));

        $result = $statementQuantieme->fetch();

        if ($result !== false) {
            return (int)$result['maxQt'];
        } else {
            return 0;
        }
    }



    public function insertQuestion($idQuestionnaire, $libelle)
    {

        //définit d'abord le quantième s'il y a des questions qui ont été créées avant.
        $quantieme = $this->getLastQuantieme($idQuestionnaire) + 1;
        $libelle = trim($libelle);

        $db = $this->dbConnect();

        $insert = $db->prepare("INSERT INTO questionnaire_question(id_questionnaire, quantieme, libelle, is_softDelete)
        VALUES(:id_questionnaire, :quantieme, :libelle, 0)");
        $insert->bindParam(":id_questionnaire", $idQuestionnaire);
        $insert->bindParam(":quantieme", $quantieme);
        $insert->bindParam(":libelle", $libelle);

        $insert->execute();
        return $db->lastInsertId();
    }




    


    /**
     * Met à jour le libellé de la question
     *
     * @param  mixed $idQuestion
     * @param  mixed $libelle
     *
     * @return void
     */
    public function updateQuestion($idQuestion, $libelle)
    {
        $db = $this->dbConnect();
        $libelle = trim($libelle);

        $update  = $db->prepare("UPDATE questionnaire_question
        SET libelle = :libelle
        WHERE id = :id");
        $update->bindParam(":id", $idQuestion);
        $update->bindParam(":libelle", $libelle);

        $update->execute();
    }






    
    /**
     * Supprime logiquement la question et redéfinit tous les quantièmes des questions existantes
     *
     * @param  mixed $idQuestion
     *
     * @return void
     */
    public function deleteQuestion($idQuestion)
    {
        $idQuestion = (int)$idQuestion;

        $db = $this->dbConnect();
        $update = $db->prepare("UPDATE questionnaire_question
        SET is_softDelete = b'1'
        where id = ?");
        $update->execute(array($idQuestion));

        

        //Reconstruit tous les quantièmes de question

        //Récupère toutes les questions liées
        $questionsLiees = $db->prepare(
            "Select id from questionnaire_question
            where is_softDelete = 0
            and id_questionnaire = (SELECT Q2.id_questionnaire from questionnaire_question as Q2 where Q2.id = ?)
            order by quantieme, id"
        );
        $questionsLiees->execute(array($idQuestion));


        $index = 0;

        
        $when = "";
        $in = "";

        //Construit une requête BULK pour mettre à jour le quantieme de toutes les questions
        while ($row = $questionsLiees->fetch()) {
            $questionId = (int)$row['id'];

            //Construit la partie "IN" de la requête
            if ($index > 0) {
                $in .= ", ";
            }
            $in .= $questionId;

            //Construit la partie "WHEN" de la requête
            $when .= "\nWHEN " . $questionId . " THEN " . ++$index;
        }

        //Execute le bulk de la requête si on a bien trouvé d'autres lignes 
        if($index > 0){
            $bulk = "UPDATE questionnaire_question\n";
            $bulk .= "SET quantieme =\n";
            $bulk .= "(CASE id";
            $bulk .= $when;
            $bulk .= "\nEND)\n";
            $bulk .= "WHERE id in (" . $in . ")";

            $queryBulk = $db->prepare($bulk);
            $queryBulk->execute();
        }


    }






}
