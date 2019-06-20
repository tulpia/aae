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
        $query = "SELECT R.id, R.is_archive, R.titre, DATE_FORMAT(dateAccessible, '%d/%m/%Y') as dateAccessible
        , CONCAT(anneeScolaire, '-',anneeScolaire +1) as anneeScolaire
        , (select M.libelle FROM matiere as M where M.id = R.id_matiere) as matiere
        , (SELECT COUNT(id) from autoEvaluation as AE1 where AE1.id_resultat = R.id AND AE1.isRepondu = 1) as nbRepondu
        , (SELECT COUNT(id) from autoEvaluation as AE2 where AE2.id_resultat = R.id) as nbAutoEval
        , (SELECT DATE_FORMAT(MAX(AE3.dateReponse), '%d/%m/%Y') from autoEvaluation as AE3 where AE3.id_resultat = R.id) as dateDerReponse
        , (SELECT C.libelle from classe as C where C.id = R.id_classe) as classe
        , ( SELECT GROUP_CONCAT(N.libelle) as classeNom
            FROM classeNom as N, cif_resultat_classeNom as C
            WHERE N.id = C.id_classeNom
            and C.id_resultat = R.id) as ClasseNom
        , ( SELECT O.libelle from optionCours as O where O.id = R.id_optionCours) as optionCours
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
    public function getResultatInfosBase($idResultat){

        $db = $this->dbConnect();
        $resultat = $db->prepare(
            "SELECT R.id, R.is_archive
            , R.titre, R.is_commentairePermis
            , DATE_FORMAT(dateCreation, '%d/%m/%Y') as dateCreation
            , DATE_FORMAT(dateAccessible, '%d/%m/%Y') as dateAccessible
            , CONCAT(anneeScolaire, '-',anneeScolaire +1) as anneeScolaire
            , (select M.libelle FROM matiere as M where M.id = R.id_matiere) as matiere
            , (SELECT COUNT(id) from autoEvaluation as AE1 where AE1.id_resultat = R.id AND AE1.isRepondu = 1) as nbRepondu
            , COUNT(AE.id) as nbAutoEval
            , DATE_FORMAT(MAX(AE.dateReponse), '%d/%m/%Y') as dateDerReponse
            , (Select C.libelle from classe as C where C.id = R.id_classe) as classe
            , ( select GROUP_CONCAT(N.libelle SEPARATOR ' ') as classeNom
            FROM classeNom as N, cif_resultat_classeNom as C
            WHERE N.id = C.id_classeNom
            and C.id_resultat = R.id) as ClasseNom
            , (select O.libelle from optionCours as O where O.id = R.id_optionCours) as optionCours
            , GROUP_CONCAT(AE.commentaire SEPARATOR '<br>') as commentaires
            from resultat as R
            join autoEvaluation as AE ON R.id = AE.id_resultat
            where R.id = ?");
                      
        $resultat->execute([$idResultat]);

        return $resultat->fetch();
    }



    /**
     * Retourne les stats d'un résultat, moyenne incluse
     *
     * @param  mixed $idResultat
     *
     * @return void
     */
    public function getStatsResultat($idResultat){
        $db = $this->dbConnect();

        //Récupère le nombre d'autoévaluation répondues pour ce résultat afin d'alléger la requête suivante
        $count = $db->prepare("SELECT COUNT(id) FROM autoEvaluation WHERE isRepondu = 1 AND id_resultat = ?");
        $count->execute([(int)$idResultat]);

        $nbRepondu = $count->fetch();
        $nbRepondu = (int)$nbRepondu[0] > 0 ? (int)$nbRepondu[0] : 1;
        
        $count->closeCursor();



        //Récupère les lignes de stat et fait un UNION pour récupérer dans la même requête la moyenne des résultats
        //Attention ne prend en compte que les répondus, les pourcentages ne compatbilisent pas les non répondus
        $stats = $db->prepare(
            "SELECT Q.quantieme, Q.libelle
            , (COUNT(CASE WHEN Q.reponse = 0 THEN 1 END) * 100) / :nbRepondu AS MoinsMoins
            , (COUNT(CASE WHEN Q.reponse = 10 THEN 1 END) * 100) / :nbRepondu AS Moins
            , (COUNT(CASE WHEN Q.reponse = 20 THEN 1 END) * 100) / :nbRepondu AS Plus
            , (COUNT(CASE WHEN Q.reponse = 30 THEN 1 END) * 100) / :nbRepondu AS PlusPlus
            FROM autoEvaluation as AE
            join autoEvaluation_question as Q on Q.id_autoEvaluation = AE.id
            WHERE AE.id_resultat = :idResultat
            group by Q.quantieme, Q.libelle
            
            UNION
            
            SELECT '' as id, 'Moyenne' as libelle
            , (COUNT(CASE WHEN Q.reponse = 0 THEN 1 END) * 100) / :nbRepondu / MAX(Q.quantieme) AS MoinsMoins
            , (COUNT(CASE WHEN Q.reponse = 10 THEN 1 END) * 100) / :nbRepondu / MAX(Q.quantieme) AS Moins
            , (COUNT(CASE WHEN Q.reponse = 20 THEN 1 END) * 100) / :nbRepondu / MAX(Q.quantieme) AS Plus
            , (COUNT(CASE WHEN Q.reponse = 30 THEN 1 END) * 100) / :nbRepondu / MAX(Q.quantieme) AS PlusPlus
            from autoEvaluation_question as Q
            join autoEvaluation as AE on AE.id = Q.id_autoEvaluation AND AE.id_resultat = :idResultat"
            );

            $stats->bindParam(":idResultat", $idResultat);
            $stats->bindParam(":nbRepondu", $nbRepondu);

            $stats->execute();

            return $stats;

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
    public function insertResultat($idQuestionnaire, $idMatiere, $idProf, $idClasse, $idOptionCours, $dateAccessible, $titre, $isCommentairePermis, $anneeScolaire){
        
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
            "INSERT INTO resultat(id_questionnaire, id_users, id_matiere, id_classe, id_optionCours, dateCreation, dateAccessible, titre, is_archive, is_commentairePermis, is_softDelete, anneeScolaire)
            VALUES(:id_questionnaire, :id_user, :id_matiere, :id_classe, :id_optionCours, NOW(), :dateAccessible, :titre, 0, :is_commentairePermis, 0, :anneeScolaire)"
        );

        $insert->bindParam(":id_questionnaire", $idQuestionnaire);
        $insert->bindParam(":id_user", $idProf);
        $insert->bindParam(":id_matiere", $idMatiere);      
        $insert->bindParam(":id_classe", $idClasse);
        $insert->bindParam(":anneeScolaire", $anneeScolaire);
        
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




    /**
     * Archive ou desarchive le le résultat
     *
     * @param  mixed $idResultat
     *
     * @return void
     */
    public function changeArchiverResultat($idResultat, $isArchive){
        $isArchive = (bool)$isArchive;
        $db = $this->dbConnect();
        $update = $db->prepare("UPDATE resultat SET is_archive = :bool WHERE id = :id");
        $update->bindParam(":bool", $isArchive);
        $update->bindParam(":id", $idResultat);         
        $update->execute();
    }




    public function statExportCsv($idResultat){

        $entete = $this->getResultatInfosBase($idResultat);
        $stats = $this->getStatsResultat($idResultat);
        $now = new DateTime();
        $filename = $now->format('ymd-His') . '-' . trim(substr($entete['titre'],0,50)) . '.csv';
        //$filename = "erixxxel.csv";

        
        $file = fopen('php://output','w');
        
        fputcsv($file, ["Informations générales"]);
        fputcsv($file, [""]);
        fputcsv($file, ["Titre", $entete['titre']]);
        fputcsv($file, ["Année scolaire", $entete['anneeScolaire']]);
        fputcsv($file, ["Matière", $entete['matiere']]);
        fputcsv($file, ["Classe", $entete['classe'] . ' ' . $entete['ClasseNom'] . ' ' . $entete['optionCours']]);
        fputcsv($file, ["Réponse", $entete['nbRepondu'] . '/' . $entete['nbAutoEval']]);
        fputcsv($file, ["Envoyé le", $entete['dateCreation']]);
        fputcsv($file, ["Visible le", $entete['dateAccessible']]);
        fputcsv($file, ["Dernière réponse", $entete['dateDerReponse']]);
        fputcsv($file, ["Etat", (bool)$entete['is_archive'] === true ? "Archivé" : "Ouvert"]);
        fputcsv($file, [""]);
        fputcsv($file, [""]);
        fputcsv($file, ["","","","Statistiques"]);
        fputcsv($file, ["","","","",":(",":|",":)",":D"]);
        //fputcsv($file, ["", $entete['']]);

        while ($row = $stats->fetch()) {
            fputcsv($file, ["","", $row['quantieme'], $row['libelle'], round((float)$row['MoinsMoins'], 2), round((float)$row['Moins'], 2), round((float)$row['Plus'], 2), round((float)$row['PlusPlus'], 2)]);
        }



        header("Content-type: text/csv");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="' . $filename .'"');

        fclose($file);
        
    

    }


}