<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="<?php echo strcmp($page, "Accueil") == 0 ? "active" : "" ?>">
            <a href="index.php">Accueil</a>
        </li>

        <li class="<?php echo strcmp($page, "Recherche_offres") == 0 ? "active" : "" ?>">
            <a href="recherche_offres.php">Offres d'emploi</a>
        </li>

        <li class="<?php echo strcmp($page, "Contact") == 0 ? "active" : "" ?>">
            <a href="contact.php">Contact</a>
        </li>
    </ul>

    <a href="inscription.php"
       class="btn btn-primary navbar-btn navbar-right">
        S'inscrire
    </a>

    <form class="navbar-form navbar-right" role="form"
          action="fonctions/connexion.php?<?php echo str_replace("&", "&amp;", (isset($_GET['page']) ? $_SERVER['QUERY_STRING'] : "page=" . substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1))); ?>"
          method="post" name="formConnexion" id="formConnexion">
        <div class="form-group">
            <label class="sr-only" for="login">Email</label>

            <input type="text" placeholder="Email" class="form-control"
                   name="login" id="login" />
        </div>

        <div class="form-group">
            <label class="sr-only" for="mdp">Mot de passe</label>

            <input type="password" placeholder="Mot de passe" class="form-control"
                   name="mdp" id="mdp" />
        </div>

        <input type="submit" class="btn btn-success" value="Se connecter" />
    </form>
</div> <!-- /.navbar-collapse -->
