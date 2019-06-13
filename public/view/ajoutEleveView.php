<?php
$title = 'Ajouter des élèves';
ob_start();

require('./view/headerUserView.php');
?>

<h1><?= $title ?></h1>
<br>

<!-- <form action="./controller/ajoutController.php" method="post" class="formulaireAjoutEleves"> -->
<form action="index.php" method="post" class="formulaireAjoutEleves">
    <input type="hidden" name="action" value="do_ajouterElevesBulk">

    <div>
        <p>Année Scolaire</p>
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


    <div>
        <br>
        <p>Fichier élève</p>
        <input type="file" name="fichierEleves" id="fichierEleves" accept=".csv" required />
    </div>

    <br>
    <div>
        <input type="submit" value="Ajouter les élèves">
        <span style="color: red;"><- Have Fun Alec ;)</span>
    </div>
</form>



<div>
                <br><br>
                <h2>Mode d'emploi</h2>
                <br>
                <p>Structure du fichier élèves :</p>
                <p>(ne pas inclure la ligne d'entête : Nom, Prénom, etc ...)</p>
                <br>
                <Table>
                    <thead>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Classe + Nom Classe</th>
                        <th>Option 1</th>
                        <th>Option 2</th>
                        <th>Option 3</th>
                        <th>Option 4</th>
                    </thead>
                    <tr>
                        <td>Dupond</td>
                        <td>Martine</td>
                        <td>06A</td>
                        <td>Allemand LV1</td>
                        <td>Anglais LV1</td>
                        <td>LCA Latin</td>
                        <td>LCR</td>
                    </tr>
                    <tr>
                        <td>Meyer</td>
                        <td>Eric</td>
                        <td>03A</td>
                        <td>Anglais LV1</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </Table>


                <br>
                <p>Les options sont facultatives, laisser la cellule vide si l'élève n'a pas d'options</p>
                <p>Exemple de classe : 6ème B = 06B, 3ème D = 03D</p>


                <br><br><br>
                <div>
                    <p>Valeurs possibles des différents champs :</p>
                    <p>(Respectez l'orthographe et les espaces)</p>

                    <div>
                        <br>
                        <p>Classes</p>
                        <ul>
                            <?php while ($classe = $classes->fetch()) : ?>
                                <li><?= htmlspecialchars($classe['libelleImport']) ?></li>
                            <?php endwhile ?>
                        </ul>
                    </div>

                    <div>
                        <br>
                        <p>Nom de Classe</p>
                        <ul>
                            <?php while ($classeNom = $ClasseNoms->fetch()) : ?>
                                <li><?= htmlspecialchars($classeNom['libelle']) ?></li>
                            <?php endwhile ?>
                        </ul>
                    </div>



                    <div>
                        <br>
                        <p>Options de cours</p>
                        <ul>
                            <?php while ($option = $optionCours->fetch()) : ?>
                                <li><?= htmlspecialchars($option['libelle']) ?></li>
                            <?php endwhile ?>
                        </ul>
                    </div>

                </div>

                <br><br><br>
                <h3>Pour des soucis de confidentialité aucun nom d'élève ne sera enregistré en base de données.<br>
                    A la fin de l'import vous téléchargerez un fichier contenant la correspondance entre le nom et le matricule de chaque élève<br>
                    Ce fichier est <strong>strictement confidentiel et ne pourra jamais être réédité</strong>, gardez le en lieu sûr.</h3>

    </div>










    <?php
    $content = ob_get_clean();
    require('template.php');
    ?>