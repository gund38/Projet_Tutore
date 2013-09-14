<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="<?php echo strcmp($page, "Accueil") == 0 ? "active" : "" ?>">
            <a href="index.php">Accueil</a>
        </li>

        <li class="<?php echo strcmp($page, "Recherche_profil") == 0 ? "active" : "" ?>">
            <a href="#recherche_profil">Rechercher un profil</a>
        </li>

        <li class="<?php echo strcmp($page, "Offres") == 0 ? "active" : "" ?>">
            <a href="#offres">Offres d'emploi / stage</a>
        </li>

        <li class="<?php echo strcmp($page, "Contact") == 0 ? "active" : "" ?>">
            <a href="#contact">Contact</a>
        </li>
    </ul>

    <a href="fonctions/deconnexion.php"
       class="btn btn-success navbar-btn navbar-right">
        Se déconnecter
    </a>
</div> <!--/.navbar-collapse -->
