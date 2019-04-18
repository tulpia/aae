<?php

require_once("Manager.php");


class ClasseManager extends Manager{

    
    /**
     * Retourne la liste des classes
     *
     * @return void
     */
    public function getClasses(){
        
        $db = $this->dbConnect();
        $classes = $db->prepare(
            "select id, libelle
            from classe
            where is_softDelete = 0
            order by id DESC"
        );

        $classes->execute();
        return $classes;
    }

}