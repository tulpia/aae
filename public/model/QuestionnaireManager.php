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

        return $questionnaire->fetch();
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
        $questionnaires = $db->prepare("
        select id, titre
        ,(select C.libelle from classe as C where C.id = Q.id_classe) as niveau
        ,(select M.libelle from matiere as M where M.id = Q.id_matiere) as matiere
        ,DATE_FORMAT(Q.dateCreation, '%d-%m-%Y') as dateCrea
        from questionnaire as Q
        where id_users = ?
        and is_softDelete = 0
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
        else{
            $idMatiere = (int)$idMatiere;
        }

        if(!isset($idClasse) || (int)$idClasse < 1){
            $idClasse = 0;
        }
        else{
            $idClasse = (int)$idClasse;
        }


        $insert = $db->prepare("INSERT INTO questionnaire (id_users, id_classe, id_matiere, dateCreation, titre, is_softDelete)
            VALUES(:id_users, :id_classe, :id_matiere, NOW(), :titre, 0)");
        $insert->bindParam(":id_users", $idUsers);
        
        if($idClasse > 0){
            $insert->bindParam(":id_classe", $idClasse);
        }
        else{
            //Technique de ragondin pour insérer des null dans un champs int
            $insert->bindValue(':id_classe', null, PDO::PARAM_INT);
        }
        
        $insert->bindParam(":id_matiere", $idMatiere);
        $insert->bindParam(":titre", $titre);

        $insert->execute();

        return $db->lastInsertId();
    }



    
    /**
     * Met à jour l'entête du questionnaire
     *
     * @param  mixed $id
     * @param  mixed $idUsers
     * @param  mixed $titre
     * @param  mixed $idClasse
     * @param  mixed $idMatiere
     *
     * @return void
     */
    public function updateQuestionnaire($id, $idUsers, $titre , $idClasse, $idMatiere){
        $db = $this->dbConnect();

        $update  = $db->prepare("UPDATE questionnaire
        SET id_users = :id_users, id_classe = :id_classe, id_matiere = :id_matiere, titre = :titre
        WHERE id = :id");
        $update->bindParam(":id", $id);
        $update->bindParam(":id_users", $idUsers);
        $update->bindParam(":titre", $titre);
        $update->bindParam(":id_classe", $idClasse);
        $update->bindParam(":id_matiere", $idMatiere);

        $update->execute();

    }


    /**
     * Suppression logique du questionnaire
     *
     * @return void
     */
    public function deleteQuestionnaire($id){
        
        $db = $this->dbConnect();

        $update  = $db->prepare("UPDATE questionnaire
        SET is_softDelete = 1
        WHERE id = :id");
        $update->bindParam(":id", $id);
        $update->execute();
    }


    private function duplicateQuestionnaire(){
        //TODO si j'ai le temps : Duppliquer le questionnaire, rajouter "copie" dans le titre et bien penser à dupliquer les questions liées à ce questionnaire
        //Achtung il est en private pasque voilà ch'uis pas encore sûr de le rajouter
        return false;
    }

}