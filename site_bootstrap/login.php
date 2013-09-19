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
        </style>
    </head>

    <body>
        <?php
            $page = "Login";
            require_once 'menus/menuBootstrap.php';
        ?>

        <div class="container" role="main">
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
        </div> <!-- /.container -->


        <!-- ================================================== -->

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
