<?php
    /**
     * Page de connexion
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    // Inclusion et appel de la fonction d'en-tête
    require_once 'fonctions/header.php';
    enTete(false);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Bootstrap core CSS -->
        <link href="dist/css/bootstrap.css" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="dist/css/bootstrap-theme.min.css" rel="stylesheet">
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

        <title>Site Web des Anciens Étudiants du Master TI</title>

        <style type="text/css">
            body {
                padding-top: 70px;
                padding-bottom: 30px;
            }

            .theme-dropdown .dropdown-menu {
                display: block;
                position: static;
                margin-bottom: 20px;
            }

            .theme-showcase > p > .btn {
                margin: 5px 0;
            }
        </style>
    </head>

    <body>
        <!-- Fixed navbar -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="index.php">SWAGMaster</a>
                </div>

                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Accueil</a></li>

                        <li><a href="profil.php">Profil</a></li>

                        <li><a href="#contact">Contact</a></li>

                        <!--<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>-->
                    </ul>

                    <form class="navbar-form navbar-right" action="">
                        <div class="form-group">
                            <input type="text" placeholder="Email" class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="password" placeholder="Password" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">Se connecter</button>

                        <button class="btn btn-primary">S'inscrire</button>
                    </form>
                </div> <!--/.navbar-collapse -->
            </div> <!--/.container -->
        </div> <!--/.navbar -->

        <div class="container theme-showcase">

            <?php print_r($_SESSION); echo isset($_SESSION['personneCo']) ? "oui" : "non"; ?>

            <p class="sortie">
                <?php
                    // Message si l'utilisateur est déjà connecté
                    if (!isset($_SESSION['erreur_droits'])
                            && isset($_SESSION['personneCo'])) {
                        echo "Vous êtes déjà connecté :)<br /><br />\n";
                    }
                ?>
            </p>

            <p class="erreur">
                <?php
                    // Gestion des erreurs au niveau des droits d'accès aux pages
                    if (isset($_SESSION['erreur_droits'])) {
                        if (isset($_SESSION['personneCo'])) {
                            echo "Vous n'avez pas le droit d'accéder à cette page !";
                        } else {
                            echo "Vous devez vous connecter pour accéder à cette page";
                        }
                        echo "<br /><br />\n";
                        unset($_SESSION['erreur_droits']);
                    } else {
                        echo "\n";
                    }
                ?>
            </p>

            <p class="erreur">
                <?php
                    // Gestion des erreurs au niveau de la connexion
                    if (isset($_SESSION['erreurs_connexion'])) {
                        echo substr_count($_SESSION['erreurs_connexion'], "<br />\n") > 1 ? "Erreurs :" : "Erreur :";
                        echo "<br />\n";
                        echo $_SESSION['erreurs_connexion'];
                        unset($_SESSION['erreurs_connexion']);
                    } else {
                        echo "\n";
                    }
                ?>
            </p>
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
