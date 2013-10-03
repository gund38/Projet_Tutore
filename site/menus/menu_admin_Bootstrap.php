<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="<?php echo strcmp($page, "Accueil") == 0 ? "active" : "" ?>">
            <a href="index.php">Accueil</a>
        </li>

        <li class="<?php echo strcmp($page, "Recherche_profil") == 0 ? "active" : "" ?>">
            <a href="recherche_profil.php">Rechercher un profil</a>
        </li>

        <li class="<?php echo strcmp($page, "Recherche_offres") == 0 ? "active" : "" ?>">
            <a href="recherche_offres.php">Offres d'emploi / stage</a>
        </li>

        <li class="<?php echo strcmp($page, "Ajout_offre") == 0 ? "active" : "" ?>">
            <a href="ajout_offre.php">Ajouter une offre</a>
        </li>

        <li class="dropdown<?php echo strcmp($page, "Admin") == 0 ? " active" : "" ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                Administration <b class="caret"></b>
            </a>

            <ul class="dropdown-menu">
                <li> <!-- // @TODO Utilité de la classe "active" pour le dropdown -->
                    <a href="#stats">Statistiques</a> <!-- // @TODO Sortir stats du menu admin ? -->
                </li>

                <li>
                    <a href="admin.php#valid_comptes"
                       class="liensOnglets">
                        Valider comptes
                    </a>
                </li>

                <li>
                    <a href="admin.php#valid_master"
                       class="liensOnglets">
                        Étudiants <span class="icon-arrow-right"></span> Anciens Étudiants
                    </a>
                </li>

                <li>
                    <a href="#modifier_offres"
                       class="liensOnglets">
                        Gérer offres
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    <a href="fonctions/deconnexion.php"
       class="btn btn-success navbar-btn navbar-right">
        Se déconnecter
    </a>
</div> <!-- /.navbar-collapse -->
