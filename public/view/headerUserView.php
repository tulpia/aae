<!-- Header user à incorporer sur quasi chaque page -->
<div class="header-bg-blue"></div>

<!-- //// Ca j'ai viré - David //// -->
<!-- <header class="header-connected"> -->
<header>
    <!-- //// Ca j'ai rajouté - David //// -->
    <div class="header-connected">
        <div class="header-connected__img-container">
            <img src="./view/dist/images/bg-home.jpg" alt="header-img" class="header-connected__img">
        </div>
        <section class="header-connected__btn-deconnect">
            <p class="btn-deconnect__text"><?= $_SESSION['nameUser']; ?></p>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="do_disconnect">
                <input type="submit" value="Déconnexion" class="btn-disconnect">
            </form>
        </section>
    </div>


    <div>

        <?php if ($_SESSION['isProf'] == true) : ?>
            <!-- Accès mon profil (enseignant)  -->
            <div>
                <form action="index.php" method="POST">
                    <input type="hidden" name="action" value="show_profilProf">
                    <input type="submit" value="Mon profil (Prof)">
                </form>
            </div>


            <?php if ($_SESSION['isAdmin'] == true) : ?>
                <!-- Accès liste des enseignants (admin)  -->
                <div>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="show_listeProf">
                        <input type="submit" value="Liste des enseignants">
                    </form>
                </div>

                <!-- Accès liste des élève (admin)  -->
                <div>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="show_listeEleves">
                        <input type="submit" value="Liste des élèves">
                    </form>
                </div>

            <?php endif; ?>

        <?php else : ?>
            <!-- Accès mon profil (élève)  -->
            <div>
                <form action="index.php" method="POST">
                    <input type="hidden" name="action" value="show_profilEleve">
                    <input type="submit" value="Mon profil (élève)">
                </form>
            </div>
        <?php endif; ?>


        <div>
            <a href="index.php" class="btn-home">Accueil</a>
        </div>

        </div>


</header>