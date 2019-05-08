<?php

require_once("Manager.php");


class UserManager extends Manager
{

    public function getElevesFromOptions($idClasse, $arrayIdClasseNoms, $idOptionCours, $anneeScolaire, $isReturnOnlyId)
    {


        //L'option cours est facultative, c'est la granularité la plus fine, sinon prend toute la classe
        if (!isset($idOptionCours) || (int)$idOptionCours < 1) {
            $idOptionCours = 0;
        }

        //Il peut y avoir plusieurs noms de classes (ex. les cours de langues, qui sont composées de 2+ classes avec la même option langue)
        $inIdClasseNom = "";
        $isFirstIndex = true;
        foreach ($arrayIdClasseNoms as $idClasseNom) {
            if (!$isFirstIndex) {
                $inIdClasseNom .= ",";
            } else {
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

        if ($idOptionCours > 0) {
            $query .= " AND EXISTS(SELECT O.ID FROM cif_eleve_optionCours as O where O.id_users = U.id and id_optionCours = :idOptionCours)";
        }

        $idEleves = $db->prepare($query);
        $idEleves->bindParam(":idClasse", $idClasse);
        //$idEleves->bindParam(":inIdClasseNom", $inIdClasseNom);
        $idEleves->bindParam(":annee", $anneeScolaire);
        if ($idOptionCours > 0) {
            $idEleves->bindParam(":idOptionCours", $idOptionCours);
        }

        $idEleves->execute();

        return $idEleves;
    }


    public function getAuthentifiedUser($login, $password, $isProf)
    {
        // $prout = password_hash($password,PASSWORD_DEFAULT);
        // echo($prout);
        $isProf = (bool)$isProf;

        $db = $this->dbConnect();
        $query = "
    Select *
    from users_test
    where login = ?
    and is_enseignant = ?";
        $users = $db->prepare($query);
        $users->execute([$login, $isProf]);

        $user = false;

        if ($isProf) {
            while ($row = $users->fetch()) {
                if (password_verify($password, $row['password'])) {
                    $user = $row;
                    break;
                }
            }
        } else {
            $user = $users->fetch();
        }

        return $user;
    }



    /**
     * Retourne le 1er id de l'utilisateur actif lié à cette adresse mail
     *
     * @param  mixed $eMail
     *
     * @return void
     */
    public function getidUserFromMail($eMail)
    {
        $db = $this->dbConnect();
        $user = $db->prepare("
        Select id
        from users_test
        where is_softDelete = b'0'
        and login = ?
        ORDER BY id
        LIMIT 1");

        $user->execute([$eMail]);

        if ($user->rowCount() > 0) {
            $id = $user->fetch();
            return (int)$id['id'];
        } else {
            return 0;
        }
    }


    // Generates a strong password of N length containing at least one lower case letter,
    // one uppercase letter, one digit, and one special character. The remaining characters
    // in the password are chosen at random from those four sets.
    //
    // The available characters in each set are user friendly - there are no ambiguous
    // characters such as i, l, 1, o, 0, etc. This, coupled with the $add_dashes option,
    // makes it much easier for users to manually type or speak their passwords.
    //
    // Note: the $add_dashes option will increase the length of the password by
    // floor(sqrt(N)) characters.
    public function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if (strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if (strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if (strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if (strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach ($sets as $set) {
                $password .= $set[array_rand(str_split($set))];
                $all .= $set;
            }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if (!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
                $dash_str .= substr($password, 0, $dash_len) . '-';
                $password = substr($password, $dash_len);
            }
        $dash_str .= $password;
        return $dash_str;
    }





    /**
     * Hashe le password et l'update en base de données
     *
     * @param  mixed $idUser
     * @param  mixed $password
     *
     * @return void
     */
    public function updateAndHashPassword($idUser, $password)
    {
        $db = $this->dbConnect();
        $insert = $db->prepare("
    UPDATE users_test
    SET password = ?
    WHERE id = ?");

        $insert->execute([password_hash($password, PASSWORD_DEFAULT), $idUser]);
    }


    /**
     * Envoie un mail avec le nouveau mot de passe
     *
     * @param  mixed $eMail
     * @param  mixed $password
     *
     * @return void
     */
    public function sendPasswordMail($eMail, $password, $isPasswordForgot){

        $subject ="";
        $message ="";

        if ($isPasswordForgot) {
            $subject = "Collège Saint Joseph de Matzenheim - Votre nouveau mot de passe";
            $message = "Voici votre nouveau mot de passe pour l'application d'auto évaluation " . $password;
        }
        else{
            $subject = "Collège Saint Joseph de Matzenheim - Votre compte a été créé";
            $message = "Vous avez désormais un compte pour l'application d'auto évaluation du collège Saint-Joseph de Matzenheim. 
            La présente adresse mail vous servira de login et voici votre mot de passe : " . $password . "  Vous pourrez le changer
            à tout moment depuis votre profil." ;
        }


        $headers = "From : christian.bachmann@college-matzenheim.fr";
        try {
            return mail($eMail, $subject, $message, $headers);
        } catch (\Throwable $th) {
            return false;
        }
    }


/**
 * Créé un nouveau password, l'envoie par mail au user et l'insère hashé en base de données
 *
 * @param  mixed $eMail
 *
 * @return void
 */
public function sendPasswordResetMail($eMail){
    $isOk = false;

    if(filter_var($eMail, FILTER_VALIDATE_EMAIL)){
        
        $idUser = $this->getidUserFromMail($eMail);
        
        if($idUser > 0){
            $randomPassword = $this->generateStrongPassword(9,false,'luds');

            if($this->sendPasswordMail($eMail,$randomPassword, true)){
                $this->updateAndHashPassword($idUser,$randomPassword);
                $isOk = true;
            }            
        }
    }

    return $isOk;

}



/**
 * Retourne la liste des enseignants
 *
 * @return void
 */
public function getListProf(){
    $db = $this->dbConnect();
    $profs = $db->prepare(
        "SELECT id, nomPrenom, login,is_admin
        , (SELECT libelle FROM matiere as M where M.id = U.id_matiere) as matiere
        FROM users_test as U
        WHERE is_softDelete = 0
        AND is_enseignant = 1
        ORDER BY nomPrenom");

    $profs->execute(); 

    return $profs;
}

/**
 * Retourne les infos du prof
 *
 * @param  mixed $idProf
 *
 * @return void
 */
public function getProf($idProf){
    $db = $this->dbConnect();
    $profs = $db->prepare(
        "SELECT id, nomPrenom, login, is_admin, U.id_matiere
        FROM users_test as U
        WHERE is_softDelete = 0
        AND is_enseignant = 1
        AND id = ?");

    $profs->execute([$idProf]);
    
    return $profs->fetch();
}



/**
 * Retourne la liste des élèves d'une année scolaire donnée
 *
 * @param  mixed $anneeScolaire
 *
 * @return void
 */
public function getListEleves($anneeScolaire){
    $db = $this->dbConnect();
    $eleves = $db->prepare(
        "SELECT U.id, U.login
        , CONCAT(C.libelle, ' ', CN.libelle) as classe
        , ( SELECT GROUP_CONCAT(O.libelle)
            FROM optionCours as O, cif_eleve_optionCours as C
            where C.id_optionCours = O.id
            AND C.id_users = U.id) as optionCours
        FROM users_test as U
        JOIN classe as C on C.id = U.id_classe
        JOIN classeNom as CN on CN.id = U.id_classeNom
        WHERE U.is_softDelete = 0
        AND U.is_enseignant = 0
        AND U.anneeScolaire = ?
        ORDER BY login"
    );

    $eleves->execute([$anneeScolaire]);
    return $eleves;

}


/**
 * Retourne les infos d'un élève
 *
 * @param  mixed $idEleve
 *
 * @return void
 */
public function getEleve($idEleve){
    
    $db = $this->dbConnect();
    $eleves = $db->prepare(
        "SELECT U.id, U.login, U.id_classe, U.id_classeNom
        , ( SELECT GROUP_CONCAT(C.id_optionCours SEPARATOR ';')
            FROM cif_eleve_optionCours as C
            where  = C.id_users = U.id) as optionCours
        FROM users_test as U
        WHERE U.is_softDelete = 0
        AND U.is_enseignant = 0");

    $eleves->execute([$idEleve]);

    return $eleves;
}



/**
 * Retourne toutes les années scolaires où des élèves ont été enregistrés, avec l'année en cours comme valeur par défaut
 *
 * @return void
 */
public function getAnneeScolaireEleves(){
    $db = $this->dbConnect();
    $years = $db->prepare(
        "SELECT DISTINCT anneeScolaire
        FROM users_test
        WHERE is_softDelete = 0
        AND anneeScolaire > 0
        
        UNION
        
        SELECT YEAR(NOW()) as anneeScolaire
        
        ORDER BY anneeScolaire");

        return $years->execute();
}



/**
 * Met à jour le profil professeur
 *
 * @param  mixed $idProf
 * @param  mixed $nomPrenom
 * @param  mixed $login
 * @param  mixed $isAdmin
 * @param  mixed $idMatiere
 *
 * @return void
 */
public function updateProf($idProf,$nomPrenom, $login, $isAdmin, $idMatiere){
    
    $db = $this->dbConnect();
    $update = $db->prepare(
        "UPDATE users_test
        SET nomPrenom = :nomPrenom
        , login = :login
        , is_admin = :isAdmin
        , id_matiere = :idMatiere
        WHERE id = :id"
    );

    $update->bindParam(":nomPrenom", $nomPrenom);
    $update->bindParam(":login", $login);
    $update->bindParam(":isAdmin", $isAdmin);
    $update->bindParam(":idMatiere", $idMatiere);
    $update->bindParam(":id", $idProf);

    $update->execute();
}



/**
 * Créé un nouveau profil de prof
 *
 * @param  mixed $nomPrenom
 * @param  mixed $login
 * @param  mixed $isAdmin
 * @param  mixed $idMatiere
 *
 * @return void
 */
public function insertProf($nomPrenom, $login, $isAdmin, $idMatiere, $password){
    

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $db = $this->dbConnect();
    $insert = $db->prepare(
        "INSERT INTO users_test
        (nomPrenom, login, password, is_softDelete, is_enseignant, id_matiere, is_admin,dateCreation)
        VALUES
        (:nomPrenom, :login, :password, :is_softDelete, :is_enseignant, :id_matiere, :is_admin, NOW())"
    );

    $isSoftDelete = false;
    $isEnseignant = true;

    $insert->bindParam(":nomPrenom", $nomPrenom);
    $insert->bindParam(":login", $login);
    $insert->bindParam(":password", $hashedPassword);
    $insert->bindParam(":is_softDelete", $isSoftDelete);
    $insert->bindParam(":is_enseignant", $isEnseignant);
    $insert->bindParam(":id_matiere", $idMatiere);
    $insert->bindParam(":is_admin", $isAdmin);

    $insert->execute();

    return $db->lastInsertId();
}




/**
 * Vérifie si le login n'a pas de doublon
 * si $idUserExclu est renseigné, exclut l'utilisateur de la recherche
 *
 * @param  mixed $login
 * @param  mixed $idUserExclu
 *
 * @return void
 */
public function isLoginLibre($login, $idUserExclu = 0){
    $db = $this->dbConnect();
    $doublons = $db->prepare(
        "SELECT count(id) as nbDoublons
        FROM users_test as U
        WHERE login = :login
        AND U.is_softDelete = 0
        AND is_enseignant = 1
        AND id != :idUserExclu"
    );

    if(isset($idUserExclu) && (int)$idUserExclu > 0){
        $idUserExclu = (int)$idUserExclu;
    }
    else{
        $idUserExclu = 0;
    }
    
    $doublons->bindParam(":login", $login);
    $doublons->bindParam(":idUserExclu", $idUserExclu);

    $doublons->execute();

    $result = $doublons->fetch();
    $nbDoublons = (int)$result[0];

    return ($nbDoublons === 0);

}


/**
 * Suppression logique de l'utilisateur
 *
 * @param  mixed $idUser
 *
 * @return void
 */
public function deleteUser($idUser){
    $db = $this->dbConnect();
    $update = $db->prepare(
        "UPDATE users_test
        SET is_softDelete = 1
        where id = ?"
    );

    $update->execute([$idUser]);
}

}
