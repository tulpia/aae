<?php

require_once("Manager.php");


class QuestionnaireManager extends Manager{

    
    
    /**
     * Retourne un questionnaire via son id
     *
     * @param  int $id
     *
     * @return mixed
     */
    public function getQuestionnaire($id){
        $db = $this->dbConnect();
        $questionnaire = $db->prepare("select *
        from questionnaire
        where id = ?");

        $questionnaire->execute(array($id));

        return $questionnaire;
    }


    
    /**
     * Retourne tous les questionnaires liés à un prof via l'id du professeur
     * order by id_classe desc, dateCreation desc
     * 
     * @param  mixed $idProf
     *
     * @return void
     */
    public function getQuestionnaires($idProf){
        $db = $this->dbConnect();
        $questionnaires = $db->prepare("select *
        from questionnaire
        where id_users = ?
        and is_softDelete != 1
        order by id_classe desc, dateCreation desc");

        $questionnaires->execute(array($idProf));

        return $questionnaires;
    }


    
    /**
     * Créé un nouveau questionnaire et retourne son id en cas de succès.
     *
     * @param  int $idUsers
     * @param  string $titre
     * @param  int nullable $idClasse
     * @param  int nullable $idMatiere
     *
     * @return int
     */
    public function insertQuestionnaire($idUsers, $titre , $idClasse, $idMatiere){
        $db = $this->dbConnect();

        //Si pas de matière je mets par défaut l'id 1 qui correspond à la matière -aucun- (Tout est sous contrôle)
        if(!isset($idMatiere) || (int)$idMatiere < 1){
            $idMatiere = 1;
        }


        $insert = $db->prepare("INSERT INTO questionnaire(id_users, id_classe, id_matiere, dateCreation, titre, is_softDelete)
            VALUES(:id_users, :id_classe, :id_matiere, NOW(), :titre, 0");
        $insert->bindParam(":id_users", $idUsers);
        $insert->bindParam(":id_classe", $idClasse);
        $insert->bindParam(":id_matiere", $idMatiere);
        $insert->bindParam(":titre", $titre);

        $insert->execute();

        return $db->lastInsertId();
    }



    public function updateQuestionnaire(){
        //TODO : Update
    }


    public function deleteQuestionnaire(){
        //TODO : Suppression logique
    }


    private function duplicateQuestionnaire(){
        //TODO si j'ai le temps : Duppliquer le questionnaire, rajouter "copie" dans le titre et bien penser à dupliquer les questions liées à ce questionnaire
        //Achtung il est en private pasque voilà ch'uis pas encore sûr de le rajouter
    }

}