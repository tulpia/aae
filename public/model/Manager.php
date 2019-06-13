<?php



class Manager
{
    
    /**
     * Retourne un PDO connecté à la BDD
     *
     * @return PDO
     */
    protected function dbConnect()
    {
        //Le PDO, super Objet qui fait la liaison avec la base de données.
        //le dernier paramètre permet de remonter les messages d'erreur liés aux requêtes.

        $db = new PDO('mysql:host=mysql-maena.alwaysdata.net;dbname=maena_autoeval', 'maena', 'maena2015', null);
        // $db = new PDO('mysql:host=localhost;dbname=maena', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $db;
    }


}
