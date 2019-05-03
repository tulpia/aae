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
     * Si $isAfficheUniquementEnCours === true, n'affiche que les non archivés, sinon affiche tout
     *
     * @param  mixed $idProf
     * @param  mixed $isAfficheUniquementEnCours
     * @param  mixed $nbLimit
     *
     * @return void
     */
    public function getResultatsList($idProf, $nbLimit, $isAfficheUniquementEnCours){

        $db = $this->dbConnect();
        $query = "select R.id, R.is_archive
        , R.titre, DATE_FORMAT(dateAccessible, '%d/%m/%Y') as dateAccessible
        , (select M.libelle FROM matiere as M where M.id = R.id_matiere) as matiere
        , (SELECT COUNT(id) from autoEvaluation as AE1 where AE1.id_resultat = R.id AND AE1.isRepondu = 1) as nbRepondu
        , (SELECT COUNT(id) from autoEvaluation as AE2 where AE2.id_resultat = R.id) as nbAutoEval
        , (SELECT DATE_FORMAT(MAX(AE3.dateReponse), '%d/%m/%Y') from autoEvaluation as AE3 where AE3.id_resultat = R.id) as dateDerReponse
        , (Select C.libelle from classe as C where C.id = R.id_classe) as classe
        , ( select GROUP_CONCAT(N.libelle) as classeNom
            FROM classeNom as N, cif_resultat_classeNom as C
            WHERE N.id = C.id_classeNom
            and C.id_resultat = R.id) as ClasseNom
        , (select O.libelle from optionCours as O where O.id = R.id_optionCours) as optionCours
        from resultat as R
        where id_users = ?\n";
        if((bool)$isAfficheUniquementEnCours === true){
            $query .= "and is_archive = 0\n"; 
        }
        $query .= "order by dateAccessible desc\n";
        if ((int)$nbLimit > 0) {
            $query .= "LIMIT " . (int)$nbLimit;
        }
        
        
        $resultats = $db->prepare($query);
        $resultats->execute([$idProf]);

        return $resultats;
    }



    
    /**
     * Retourne les infos générales d'un résultat 
     *
     * @param  mixed $idResultat
     *
     * @return void
     */
    public function getResultats($idResultat){

        $db = $this->dbConnect();
        $query = "select R.id, R.is_archive
        , R.titre
        , DATE_FORMAT(dateCreation, '%d/%m/%Y') as dateCreation
        , DATE_FORMAT(dateAccessible, '%d/%m/%Y') as dateAccessible
        , (select M.libelle FROM matiere as M where M.id = R.id_matiere) as matiere
        , (SELECT COUNT(id) from autoEvaluation as AE1 where AE1.id_resultat = R.id AND AE1.isRepondu = 1) as nbRepondu
        , (SELECT COUNT(id) from autoEvaluation as AE2 where AE2.id_resultat = R.id) as nbAutoEval
        , (SELECT DATE_FORMAT(MAX(AE3.dateReponse), '%d/%m/%Y') from autoEvaluation as AE3 where AE3.id_resultat = R.id) as dateDerReponse
        , (Select C.libelle from classe as C where C.id = R.id_classe) as classe
        , ( select GROUP_CONCAT(N.libelle) as classeNom
            FROM classeNom as N, cif_resultat_classeNom as C
            WHERE N.id = C.id_classeNom
            and C.id_resultat = R.id) as ClasseNom
        , (select O.libelle from optionCours as O where O.id = R.id_optionCours) as optionCours
        from resultat as R
        where id = ?\n";
                
        
        $resultats = $db->prepare($query);
        $resultats->execute([$idResultat]);

        return $resultats->fetch();
    }



    public function getStatsResultat($idResultats){
        $db = $this->dbConnect();
        $result = $db->prepare("");
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