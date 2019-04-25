<?php

require_once("Manager.php");


class CifResultatClasseNomManager extends Manager{


    /**
     * Retourne les Id et nom de classe liés à une ligne de résultat
     *
     * @param  mixed $idResultat
     *
     * @return void
     */
    public function getCifResultatClasseNom($idResultat){

        $db = $this->dbConnect();
        $cif = $db->prepare(
            "select *, (select CN.libelle from classeNom as  CN where CN.id = id_classeNom) as classeNom
            from cif_resultat_classeNom
            where id_resultat = ?
            order by id_classeNom"
        );


        $cif->execute([$idResultat]);
        
        return $cif;
    }


    /**
     * Créé une ligne de CIF liant un ou plusieurs noms de classe à un résultat
     *
     * @param  mixed $idResultat
     * @param  mixed $idClasseNom
     *
     * @return void
     */
    public function insertCifResultatClasseNom($idResultat, $idClasseNom){
        $db = $this->dbConnect();
        $insert = $db->prepare("
        INSERT INTO cif_resultat_classeNom(id_resultat, id_classeNom)
        VALUES(?,?)
        ");

        $insert->execute([$idResultat, $idClasseNom]);
        return $db->lastInsertId();
    }


    

    
}