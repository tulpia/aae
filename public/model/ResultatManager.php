<?php

require_once("Manager.php");


class ResultatManager extends Manager{

    /**
     * Retourne une ligne de résultat, selon son id
     *
     * @param  mixed $idResultat
     *
     * @return void
     */
    public function getResultat($idResultat){
        $db = $this->dbConnect();
        $resultat = $db->prepare(
            "select *
            from resultat
            where id = ?"
        );

        $resultat->execute([$idResultat]);
        return $resultat->fetch();
    }



    /**
     * Retourne la liste des résultats des autoévaluations d'un professeur
     * Si $isAfficheArchives == false, n'affiche que les non archivés, sinon affiche tout
     *
     * @param  mixed $idProf
     * @param  mixed $isAfficheArchives
     *
     * @return void
     */
    public function getResultats($idProf, $isAfficheArchives){

        $db = $this->dbConnect();
        $query = "select *
        from resultat
        where id_user = ?\n";
        if(!$isAfficheArchives){
            $query .= "and is_archive = 0"; 
        }
        $query .= "order by titre";
        
        
        $resultats = $db->prepare($query);
        $resultats->execute([$idProf]);

        return $resultats;
    }



    
    /**
     * Créé une ligne de résultat
     *
     * @param  mixed $idQuestionnaire
     * @param  mixed $idMatiere
     * @param  mixed $idClasse
     * @param  mixed $idOptionCours
     * @param  mixed $dateAccessible
     * @param  mixed $titre
     * @param  mixed $isCommentairePermis
     *
     * @return void
     */
    public function insertResultat($idQuestionnaire, $idMatiere, $idProf, $idClasse, $idOptionCours, $dateAccessible, $titre, $isCommentairePermis){
        
        //Champs Nullable
        if(!isset($idMatiere) || (int)$idMatiere < 1){
            $idMatiere = 1;
        }
        else{
            $idMatiere = (int)$idMatiere;
        }

        //Champs Nullable
        if(!isset($idOptionCours) || (int)$idOptionCours < 1){
            $idOptionCours = 0;
        }
        else{
            $idOptionCours = (int)$idOptionCours;
        }




                
        $db = $this->dbConnect();
        $insert = $db->prepare(
            "INSERT INTO resultat(id_questionnaire, id_users, id_matiere, id_classe, id_optionCours, dateCreation, dateAccessible, titre, is_archive, is_commentairePermis, is_softDelete)
            VALUES(:id_questionnaire, :id_user, :id_matiere, :id_classe, :id_optionCours, NOW(), :dateAccessible, :titre, 0, :is_commentairePermis, 0)"
        );

        $insert->bindParam(":id_questionnaire", $idQuestionnaire);
        $insert->bindParam(":id_user", $idProf);
        $insert->bindParam(":id_matiere", $idMatiere);      
        $insert->bindParam(":id_classe", $idClasse);
        
        if($idOptionCours > 0){
            $insert->bindParam(":id_optionCours", $idOptionCours);
        }
        else{
            $insert->bindValue(':id_optionCours', null, PDO::PARAM_INT); //Insert null dans un champs int
        }
        $insert->bindParam(":dateAccessible", $dateAccessible);
        $insert->bindParam(":titre", $titre);
        $insert->bindParam(":is_commentairePermis", $isCommentairePermis);

        
        $insert->execute();

        return $db->lastInsertId();

    }



}