<?php

require_once("Manager.php");


class OptionCoursManager extends Manager{
    
    /**
     * Retourne la liste des options de cours
     *
     * @return void
     */
    public function getOptionsCours(){
        
        $db = $this->dbConnect();
        $optionsCours = $db->prepare(
            "select id, libelle
            from optionCours
            where is_softDelete = 0
            order by libelle"
        );

        $optionsCours->execute();
        return $optionsCours;
    }


  
}