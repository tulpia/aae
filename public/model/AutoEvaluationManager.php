<?php

require_once("Manager.php");


class AutoEvaluationManager extends Manager{

    /**
     * Récupère toutes les autoévaluations des élèves pour un résultat donné
     * Cette fonction est utilisée du côté professeur
     *
     * @param  mixed $idResultat
     *
     * @return void
     */
    public function getAutoEvaluations($idResultat){

        $db = $this->dbConnect();
        $autoEvaluations = $db->prepare("
            select *
            from autoEvaluation
            WHERE id_resultat = ?
            ORDER BY id
        ");

        $autoEvaluations->execute([$idResultat]);

        return $autoEvaluations;
    }


    /**
     * Retourne les infos de bases de l'autoeval id, titre et is_commentairePermis
     *
     * @param  mixed $idAutoEvaluation
     *
     * @return string
     */
    public function getAutoEvaluationInfosBase($idAutoEvaluation){
        $db = $this->dbConnect();
        $infosBase = $db->prepare("
            SELECT A.id
            , R.titre
            , R.is_commentairePermis
            from autoEvaluation as A, resultat as R
            WHERE A.id = ?
            and R.id = A.id_resultat
        ");

        $infosBase->execute([$idAutoEvaluation]);

        return $infosBase->fetch();
    }


    /**
     * Récupère toutes les autoévaluations ouvertes pour un élève
     *
     * @param  int $idEleve
     *
     * @return void
     */
    public function getAutoEvaluationsEleve(int $idEleve){
        $db = $this->dbConnect();
        $autoEvals = $db->prepare("
        SELECT A.id, A.id_resultat, A.isRepondu, A.dateReponse, R.titre
        , (select M.libelle from matiere as M where M.id = R.id_matiere) as matiere
        , (select P.nomPrenom from users_test as P where P.id = R.id_users) as prof
        , (select COUNT(*) FROM autoEvaluation_question as Q where Q.id_autoEvaluation = A.id) as nbQuestions
        , R.dateAccessible
        FROM autoEvaluation as A
        join resultat as R on R.id = A.id_resultat
        where A.id_users = ?
        and R.dateAccessible <= NOW()
        ");

        $autoEvals->execute([$idEleve]);

        return $autoEvals;
    }




    /**
     * Créé une autoEvaluation liée à l'élève
     *
     * @param  mixed $idEleve
     * @param  mixed $idResultat
     *
     * @return void
     */
    public function insertAutoEvaluation($idEleve, $idResultat){
        $db = $this->dbConnect();
        $insert = $db->prepare("
        INSERT INTO autoEvaluation(id_users, id_resultat, commentaire, isRepondu)
        VALUES(?, ?, '', 0)
        ");

        $insert->execute([$idEleve, $idResultat]);

        return $db->lastInsertId();
    }



    /**
     * Clôture l'autoévaluation après que l'élève a répondu à toutes les questions
     *
     * @param  mixed $idAutoEval
     * @param  mixed $commentaire
     *
     * @return void
     */
    public function updateAutoEvalTerminee($idAutoEval, $commentaire){
        $db = $this->dbConnect();
        $update = $db->prepare("
        UPDATE autoEvaluation
        SET commentaire = ?, isRepondu = b'1', dateReponse = NOW()
        where id = ?
        ");

        $update->execute([$commentaire, $idAutoEval]);
    }

}