<?php
    //Affiche message d'erreur s'il y en a un
    if(isset($message) && trim($message) != "" ){
        echo('<br><br><h2>' . $message . '</h2><br>');
    }
