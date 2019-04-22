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
     * Retourne la liste des Autoévaluations à faire d'un élève si la date de visibilité est validée
     *
     * @param  mixed $idEleve
     *
     * @return void
     */
    public function getAutoEvaluationOuvertesEleve($idEleve){

        $db = $this->dbConnect();
        $list = $db->prepare("
        SELECT *
        from autoEvaluation
        where id_users = ?
        and isRepondu = 0
        and dateVisible <= NOW()");

        $list->execute([$idEleve]);

        return $list();
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

}