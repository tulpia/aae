<!-- Header user à incorporer sur quasi chaque page -->
        <div class="header-bg-blue"></div>
        <header class="header-connected">
            <div class="header-connected__img-container">
                <img src="dist/images/bg-home.jpg" alt="header-img" class="header-connected__img">
            </div>
            <section class="header-connected__btn-deconnect">
                <p class="btn-deconnect__text"><?= $_SESSION['nameUser']; ?></p>
                <form action="index.php" method="post">
                    <input type="hidden" name="action" value="do_disconnect">
                    <input type="submit" value="Déconnexion" class="btn-disconnect">
                </form>
            </section>
            <a href="index.php" class="btn-home">Accueil</a>
            </a>
        </header>