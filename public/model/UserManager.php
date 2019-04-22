<?php

require_once("Manager.php");


class UserManager extends Manager{

public function getElevesFromOptions($idClasse, $arrayIdClasseNoms, $idOptionCours, $anneeScolaire, $isReturnOnlyId){

   

    //L'option cours est facultative, c'est la granularité la plus fine, sinon prend toute la classe
    if(!isset($idOptionCours) || (int)$idOptionCours < 1){
        $idOptionCours = 0;
    }

     //Il peut y avoir plusieurs noms de classes (ex. les cours de langues, qui sont composées de 2+ classes avec la même option langue)
     $inIdClasseNom = "";
     $isFirstIndex = true;
     foreach ($arrayIdClasseNoms as $idClasseNom) {
         if(!$isFirstIndex){
             $inIdClasseNom .= ",";
         }else{
             $isFirstIndex = false;
         }
 
         $inIdClasseNom .= (int)$idClasseNom;
     }
  


    $db = $this->dbConnect();


    $query = "Select " . ($isReturnOnlyId ? "U.id " : "* ");
    $query .= "FROM users_test as U
    where U.is_eleve = 1
    and U.id_classe = :idClasse
    and id_classeNom in(" .  $inIdClasseNom . ")
    and is_softDelete = 0
    and anneeScolaire = :annee";

     if($idOptionCours > 0){
         $query .= " AND EXISTS(SELECT O.ID FROM cif_eleve_optionCours as O where O.id_users = U.id and id_optionCours = :idOptionCours)";
     }

    $idEleves = $db->prepare($query);
    $idEleves->bindParam(":idClasse", $idClasse);
    //$idEleves->bindParam(":inIdClasseNom", $inIdClasseNom);
    $idEleves->bindParam(":annee", $anneeScolaire);
    if($idOptionCours > 0){
        $idEleves->bindParam(":idOptionCours", $idOptionCours);
    }

    $idEleves->execute();

    return $idEleves;

}



}