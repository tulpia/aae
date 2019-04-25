<?php

require_once("Manager.php");


class ClasseNomManager extends Manager{
    
    /**
     * Retourne la liste des noms de classe
     *
     * @return void
     */
    public function getClasseNoms(){
        
        $db = $this->dbConnect();
        $classeNoms = $db->prepare(
            "select id, libelle
            from classeNom
            where is_softDelete = 0
            order by id"
        );

        $classeNoms->execute();
        return $classeNoms;
    }
}