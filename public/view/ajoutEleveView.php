<?php
$title = 'Ajouter des élèves';
ob_start();

require('./view/headerUserView.php');
?>
<article class="title-list">
    <h1><?= $title ?></h1>
</article>

<form action="./controller/ajoutController.php" method="post" class="formulaireAjoutEleves">

    <div class="input-row">
        <label class="medium-label">Année Scolaire</label>
        <select name="anneeScolaire">

            <?php
            $currentYear = (int)date("Y");
            $years = [];

            if ((int)date("m") < 8) {
                $currentYear--;
            }
            $years = [$currentYear - 1, $currentYear, $currentYear + 1, $currentYear + 2];

            foreach ($years as $year) : ?>

                <option value="<?= $year ?>" <?= $year == $currentYear ? " selected" : "" ?>><?= $year . '-' . ($year + 1) ?></option>

            <?php endforeach ?>

        </select>
    </div>


    <div class="input-container input-file__container">
        <p>Fichier élève</p>
        <input type="file" name="fichierEleves" id="fichierEleves" accept=".csv" required />
    </div>

    <div>
        <label class="btn btn-submit">
            <input class="btn-submit--real" type="submit" value="Ajouter les élèves">
            <div class="loading-container loading-container--submit">
                <svg class="spinner" width="45px" height="45px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                    <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                </svg>
            </div>
            <div class="upload-ok">
                <p>Done !</p>
            </div>
        </label>
    </div>
        <div class="links-container">
            <p class="feedback-container"></p>
            <p>Veuillez télécharger les fichiers suivants :</p>
            <div class="links-container__links">
                <!-- <a href="">
                    <p>Output.csv</p>
                </a> -->
            </div>
        </div>
    </form>
    <div class="oh-shit__container">
        <p>Vous avez fait une erreur lors de la soumission de votre fichier .csv ? Vous voulez revenir en arrière ?<br>Cliquez sur le bouton ci-dessous.</p>
        <form action="./controller/ohShitController.php">
            <label class="btn btn-submit btn-error">
                <input type="submit" value="'oh shit' button">
                <div class="loading-container loading-container--submit">
                    <svg class="spinner" width="45px" height="45px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                        <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                    </svg>
                </div>
                <div class="upload-ok">
                    <p>Done !</p>
                </div>
                <div class="feedback-container">
                    <p></p>
                </div>
            </label>
        </form>
    </div>
    <div>
                <br><br>
                <article class="title-list">
                    <h1>Mode d'emploi</h1>
                </article>
                <br>
                <h1>Structure du fichier élèves :</h1>
                <p>Ne pas inclure la ligne d'entête : « Nom », « Prénom », etc., et la numérotation des lignes.</p>
                <br>

                <table class="data-table data-example">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Classe + Nom Classe</th>
                            <th scope="col">Option 1</th>
                            <th scope="col">Option 2</th>
                            <th scope="col">Option 3</th>
                            <th scope="col">Option 4</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td data-title="Nom">Dupond</td>
                            <td data-title="Prénom">Martine</td>
                            <td data-title="Classe + Nom Classe">06A</td>
                            <td data-title="Option 1">Allemand LV1</td>
                            <td data-title="Option 2">Anglais LV1</td>
                            <td data-title="Option 3">LCA Latin</td>
                            <td data-title="Option 4">LCR</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td data-title="Nom">Meyer</td>
                            <td data-title="Prénom">Eric</td>
                            <td data-title="Classe + Nom Classe">03A</td>
                            <td data-title="Option 1">Anglais LV1</td>
                            <td data-title="Option 2">&nbsp;</td>
                            <td data-title="Option 3">&nbsp;</td>
                            <td data-title="Option 4">&nbsp;</td>
                        </tr>       
                    </tbody>
                </table>

                <br>
                <p>Les options sont facultatives, laisser la cellule vide si l'élève n'a pas d'options</p>
                <p>Exemple de classe : 6ème B = 06B, 3ème D = 03D</p>


                <br><br><br>
                <div>
                    <h1>Valeurs possibles des différents champs :</h1>
                    <p>Respectez l'orthographe et les espaces.</p>
                    <div class="row-layout">
                        <div class="col-listing">
                            <br>
                            <h2>Classes</h2>
                            <ul>
                                <?php while ($classe = $classes->fetch()) : ?>
                                    <li><?= htmlspecialchars($classe['libelleImport']) ?></li>
                                <?php endwhile ?>
                            </ul>
                        </div>

                        <div class="col-listing">
                            <br>
                            <h2>Nom de Classe</h2>
                            <ul>
                                <?php while ($classeNom = $ClasseNoms->fetch()) : ?>
                                    <li><?= htmlspecialchars($classeNom['libelle']) ?></li>
                                <?php endwhile ?>
                            </ul>
                        </div>

                        

                        <div class="col-listing">
                            <br>
                            <h2>Options de cours</h2>
                            <ul>
                                <?php while ($option = $optionCours->fetch()) : ?>
                                    <li><?= htmlspecialchars($option['libelle']) ?></li>
                                <?php endwhile ?>
                            </ul>
                        </div>
                    </div>

                </div>

                <br><br><br>
                <h3>Pour des soucis de confidentialité aucun nom d'élève ne sera enregistré en base de données.<br>
                    À la fin de l'import vous téléchargerez un fichier contenant la correspondance entre le nom et le matricule de chaque élève.<br>
                    Ce fichier est <strong>strictement confidentiel et ne pourra jamais être réédité</strong>, gardez-le en lieu sûr.</h3>

    </div>










    <?php
    $content = ob_get_clean();
    require('template.php');
    ?>