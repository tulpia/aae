<?php

require_once("Manager.php");


class MatiereManager extends Manager{
    /**
     * Retourne la liste des matières
     *
     * @return void
     */
    public function getMatieres(){
        
        $db = $this->dbConnect();
        $Matieres = $db->prepare(
            "select id, libelle
            from matiere
            where is_softDelete = 0
            order by libelle"
        );

        $Matieres->execute();
        return $Matieres;
    }
}