<?php
$title = 'Liste des questionnaires';
ob_start();
//le HTML commence à la fin de la balise PHP

require('view/headerUserView.php');

?>


<form action="index.php" method="post" class="btn-add-question__container">
    <input type="hidden" name="action" value="show_questionnaireNew">
    <label class="btn-add-question">
        <input type="submit" value="Ajouter un nouveau questionnaire !">
    </label>
</form>
<article class="prof-onglets__container">
    <div class="btn-onglet" data-name="questionnaire">
        <p class="btn-onglet__texte">Questionnaires</p>
    </div>
    <div class="btn-onglet" data-name="resultats">
        <p class="btn-onglet__texte">Résultats</p>
    </div>
</article>

<section class="prof-content__container">
    <section class="questionnaires sec-onglet" data-name="questionnaire">

        <?php include("message.php"); ?>

        <article class="title-list">
            <h1>Mes modèles de questionnaire</h1>
        </article>

        <section class="filtre-questionnaire__container filtre-questionnaire">
            <form action="./model/filtreController.php" method="post" class="filtre-questionnaire__formulaire filtreFormulaireQuestionnaires">
                <input type="hidden" name="action" class="refreshQuestionnaires" value="refreshQuestionnaires">
                <input type="hidden" name="idProf" value="<?= $idProf ?>">

                <label class="formulaire__choix-quantite">
                    <select name="nbLimit">
                        <!-- <option disabled selected>Derniers résultats</option> -->
                        <option value="25">25 derniers questionnaires</option>
                        <option value="50">50 derniers questionnaires</option>
                        <option value="100">100 derniers questionnaires</option>
                        <option value="0">Tous</option>
                    </select>
                </label>

                <!-- <label class="formulaire__archive">
                    <input type="checkbox" name="isAfficheUniquementEnCours">
                    <span class="checkmark"></span>
                    Masquer les résultats archivés
                </label> -->

                <label class="btn-submit--form">
                    <input type="submit" value="Afficher" class="submit">
                </label>
            </form>

            <section class="filtre-questionnaire__content">
                <div class="loading-container loading-container--questionnaires">
                    <svg class="spinner" width="45px" height="45px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                        <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                    </svg>
                </div>
                <section class="content__list-questions content__list-questions--questionnaires list-questions__container">

                </section>
            </section>
        </section>

        <section class="list-questions__container">
            <?php
            //Rajoute chaque questionnaire dans le tableau
            while ($row = $ListeQuestionnaires->fetch()) {
                $id = htmlspecialchars($row['id']);
                $titre = htmlspecialchars($row['titre']);
                $niveau = htmlspecialchars($row['niveau']);
                if ($niveau === "") {
                    $niveau = "-";
                }
                $matiere = htmlspecialchars($row['matiere']);
                $dateCrea = htmlspecialchars($row['dateCrea']);
                ?>
                <article class="question-container">
                    <div class="questions-container__title-container">
                        <p class="question-container__title"><?= $titre; ?></p>
                        <form action="index.php" method="post" class="questions-container__btn-editer">
                            <input type="hidden" name="action" value="show_questionnaireDetail">
                            <input type="hidden" name="idQuestionnaire" value="<?= $id ?>">
                            <label class="btn-editer">
                                <input type="submit" value="Editer" class="btn-editer-text">
                            </label>
                        </form>
                    </div>
                    <section class="question-container__details">
                        <p class="details__matiere"><?= $matiere; ?>, <span class="details__classe"><?= $niveau; ?></span></p>
                        <p class="details__date"><?= $dateCrea; ?></p>
                    </section>
                </article>
            <?php
        }
        ?>
        </section>
    </section>

    <!-- section résultat -->
    <section class="resultats sec-onglet" data-name="resultats">
        <article class="title-list">
            <h1>Mes résultats d'autoévaluation</h1>
        </article>
        <section class="filtre-questionnaire__container">
            <form action="./model/filtreController.php" method="post" class="filtre-questionnaire__formulaire filtreFormulaireResultats">
                <input type="hidden" name="action" value="refreshResultats">
                <input type="hidden" name="idProf" value="<?= $idProf ?>">

                <label class="formulaire__choix-quantite">
                    <select name="nbLimit">
                        <!-- <option disabled selected>Derniers résultats</option> -->
                        <option value="25">25 derniers résultats</option>
                        <option value="50">50 derniers résultats</option>
                        <option value="100">100 derniers résultats</option>
                        <option value="0">Tous</option>
                    </select>
                </label>

                <label class="formulaire__archive">
                    <input type="checkbox" name="isAfficheUniquementEnCours" checked>
                    <span class="checkmark"></span>
                    Masquer les résultats archivés
                </label>

                <label class="btn-submit--form">
                    <input type="submit" value="Afficher" class="submit">
                </label>
            </form>

            <section class="filtre-questionnaire__content">
                <div class="loading-container loading-container--resultats">
                    <svg class="spinner" width="45px" height="45px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                        <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                    </svg>
                </div>
                <section class="content__list-questions--resultats list-questions__container">

                </section>
            </section>
        </section>
    </section>
</section>
<?php
//le HTML finit avant cette balise PHP et est envoyée dans $content puis inséré dans le template
$content = ob_get_clean();
require('template.php');
?>