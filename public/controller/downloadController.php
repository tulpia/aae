<?php
require_once('../model/ResultatManager.php');


if (isset($_POST['idResultat']) && isset($_POST['action'])) {

    switch ($_POST['action']) {
        case "do_resultatExportCsv":
        $resultatManager = new ResultatManager();
        $resultatManager->statExportCsv($_POST['idResultat']);
            break;
        
        default:
            # code...
            break;
    }
}
