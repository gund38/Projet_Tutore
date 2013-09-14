<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="<?php echo strcmp($page, "Accueil") == 0 ? "active" : "" ?>">
            <a href="index.php">Accueil</a>
        </li>

        <li class="<?php echo strcmp($page, "Recherche_profil") == 0 ? "active" : "" ?>">
            <a href="#recherche_profil">Rechercher un profil</a>
        </li>

        <li class="<?php echo strcmp($page, "Recherche_offres") == 0 ? "active" : "" ?>">
            <a href="recherche_offres.php">Offres d'emploi / stage</a>
        </li>

        <li class="<?php echo strcmp($page, "Ajout_offre") == 0 ? "active" : "" ?>">
            <a href="#ajout_offre">Ajouter une offre</a>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                Administration <b class="caret"></b>
            </a>

            <ul class="dropdown-menu">
                <li class="active"> <?php // @TODO Utilité de la classe "active" pour le dropdown ?>
                    <a href="#stats">Statistiques</a>
                </li>

                <li>
                    <a href="#valider_comptes">Valider comptes</a>
                </li>

                <li>
                    <a href="#supprimer_comptes">Supprimer comptes</a>
                </li>

                <li>
                    <a href="#modifier_offres">Gérer offres</a>
                </li>
            </ul>
        </li>
    </ul>

    <a href="fonctions/deconnexion.php"
       class="btn btn-success navbar-btn navbar-right">
        Se déconnecter
    </a>
</div> <!--/.navbar-collapse -->
