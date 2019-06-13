<!-- Header user à incorporer sur quasi chaque page -->

<!-- //// Ca j'ai viré - David //// -->
<!-- <header class="header-connected"> -->
<header class="entire-header-container">
    <div class="header-connected__img-container">
        <img src="./view/dist/images/bg-home.jpg" alt="header-img" class="header-connected__img">
    </div>
    <div class="btn-home">
        <a href="index.php"></a>
    </div>
    <section class="account-container">
        <p class="account-title"><?= $_SESSION['nameUser']; ?></p>
        <div class="account-view">
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
    
            </div>
    </section>
    <div class="header-connected">
        <section class="header-connected__btn-deconnect">
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="do_disconnect">
                <input type="submit" value="Déconnexion" class="btn-disconnect">
            </form>
        </section>
    </div>
</header>