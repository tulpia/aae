<?php
    //Affiche message d'erreur s'il y en a un
    if(isset($message) && trim($message) != "" ){
        echo('<br><br><h3>' . $message . '</h3><br><br>');
    }
