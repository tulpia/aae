<?php
    //Affiche message d'erreur s'il y en a un
    if(isset($message) && trim($message) != "" ){
        echo('<br><br><h2 style="color:orange;text-align:center;font-size:1.2em">' . $message . '</h2><br>');
    }
