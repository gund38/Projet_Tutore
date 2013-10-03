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

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <!-- Bootstrap core CSS -->
        <link href="dist/css/bootstrap.css" type="text/css" rel="stylesheet" />

        <!-- Bootstrap theme -->
        <link href="dist/css/bootstrap-theme.min.css" type="text/css" rel="stylesheet" />

        <!-- Font Awesome CSS -->
        <link href="font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

        <title>Site Web des Anciens Étudiants du Master TI</title>

        <style type="text/css">
            body {
                padding-top: 70px;
                padding-bottom: 30px;
                background-color: #eee;
            }

            .form-signin, .alert {
                max-width: 330px;
                padding: 15px;
                margin: 0 auto;
            }

            .alert {
                padding-right: 35px;
            }

            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }

            .form-signin .checkbox {
                font-weight: normal;
            }

            .form-signin .form-control {
                position: relative;
                font-size: 16px;
                height: auto;
                padding: 10px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            .form-signin .form-control:focus {
                z-index: 2;
            }

            .form-signin input[type="text"] {
                margin-bottom: -1px;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }

            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        </style>
    </head>

    <body>
        <?php
            // Affichage menu
            $page = "Login";
            require_once 'menus/menuBootstrap.php';
        ?>

        <div class="container" role="main">
            <form class="form-signin" role="form"
                  action="fonctions/connexion.php?<?php echo str_replace("&", "&amp;", (isset($_GET['page']) ? $_SERVER['QUERY_STRING'] : "page=" . substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1))); ?>"
                  method="post" name="formConnexionLogin" id="formConnexionLogin">
                <h2 class="form-signin-heading">Se connecter</h2>

                <input type="text" class="form-control" placeholder="Email" autofocus
                       name="login" id="login" />

                <input type="password" class="form-control" placeholder="Mot de passe"
                       name="mdp" id="mdp" />

                <!--<label class="checkbox">
                    <input type="checkbox" value="remember-me"> Remember me
                </label>-->

                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>

            <?php
                // Message si l'utilisateur est déjà connecté
                if (!isset($_SESSION['erreur_droits'])
                        && isset($_SESSION['personneCo'])) {
            ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        <p>Vous êtes déjà connecté :)</p>
                    </div>
            <?php
                }

                // Gestion des erreurs au niveau des droits d'accès aux pages
                if (isset($_SESSION['erreur_droits'])) {
                    if (isset($_SESSION['personneCo'])) {
            ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        <p>Vous n'avez pas le droit d'accéder à cette page !</p>
                    </div>
            <?php
                    } else {
            ?>
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        <p>Vous devez vous connecter pour accéder à cette page</p>
                    </div>
            <?php
                    }
                    unset($_SESSION['erreur_droits']);
                }

                // Gestion des erreurs au niveau de la connexion
                if (isset($_SESSION['erreurs_connexion'])) {
            ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        <p>
                            <?php
                                echo substr_count($_SESSION['erreurs_connexion'], "<br />\n") > 1 ? "Erreurs :" : "Erreur :";
                                echo "<br />\n";
                                echo $_SESSION['erreurs_connexion'];
                            ?>
                        </p>
                    </div>
            <?php
                    unset($_SESSION['erreurs_connexion']);
                }
            ?>
        </div> <!-- /.container -->


        <!-- ================================================== -->

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
