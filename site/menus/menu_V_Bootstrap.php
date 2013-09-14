<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="<?php echo strcmp($page, "Accueil") == 0 ? "active" : "" ?>">
            <a href="index.php">Accueil</a>
        </li>

        <li class="<?php echo strcmp($page, "Offres") == 0 ? "active" : "" ?>">
            <a href="#offres">Offres d'emploi</a>
        </li>

        <li class="<?php echo strcmp($page, "Contact") == 0 ? "active" : "" ?>">
            <a href="#contact">Contact</a>
        </li>
    </ul>

    <a href="#inscription"
       class="btn btn-primary navbar-btn navbar-right">
        S'inscrire
    </a>

    <form class="navbar-form navbar-right" role="form"
          action="fonctions/connexion.php" method="post"
          name="formConnexion" id="formConnexion">
        <div class="form-group">
            <input type="text" placeholder="Email" class="form-control"
                   name="login" id="login" />
        </div>

        <div class="form-group">
            <input type="password" placeholder="Mot de passe" class="form-control"
                   name="mdp" id="mdp" />
        </div>

        <input type="submit" class="btn btn-success" value="Se connecter" />
    </form>
</div> <!--/.navbar-collapse -->
