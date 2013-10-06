<?php
    /**
     * Page d'affichage du profil d'un ancien étudiant
     *
     * Cette page bénéficie d'une réécriture d'URL. Pour être valide,
     * l'URL de cette page doit être de la forme "profil_public-X.php"
     * ou "profil_public.php?id=X", où X est un nombre.
     *
     * Si l'URL n'est pas valide ou que X ne correspond pas à un profil,
     * l'utilisateur sera redirigé vers l'accueil.
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    // Inclusion et appel de la fonction d'en-tête
    require_once 'fonctions/header.php';
    enTete(true);
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

        <!-- CSS checkbox iOS -->
        <link href="css/boutons_iOS.css" type="text/css" rel="stylesheet" />

        <title>Site Web des Anciens Étudiants du Master TI</title>

        <style type="text/css">
            body {
                padding-top: 70px;
                padding-bottom: 30px;
            }

            .alert {
                max-width: 330px;
                margin: 0 auto;
                text-align: center;
            }

            fieldset {
                padding-bottom: 20px;
            }
        </style>
    </head>

    <body>
        <?php
            // Affichage menu
            $page = "Profil_public";
            require_once 'menus/menuBootstrap.php';

            // On tente de récupérer le profil grâce à l'identifiant passé en paramètre
            $profilManager = new ProfilManager(ConnexionBD::getInstance()->getBDD());
            $profil = $profilManager->getProfil($_GET['id']);

            // S'il n'y a pas de profil, on affiche un message d'erreur et on redirige
            if ($profil == null) {
        ?>
                <div class="alert alert-danger">
                    <h3>Le profil auquel vous tentez d'accéder n'existe pas.<br />Vous allez être redirigé vers l'accueil</h3>

                    <script type="text/javascript">
                        setTimeout(function() {
                            window.location = "index.php";
                        }, 3000);
                    </script>
                </div> <!-- /.alert -->
        <?php
            }

            // On récupère le profil complet
            $profil->obtenirProfilComplet();
        ?>

        <div class="container" role="main">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-lg-2">
                        <img src="images/profil/<?php echo $profil->getVisibilitePhoto() ? $profil->getCheminPhoto() : "photo_profil_default.jpg"; ?>"
                              alt="Photo du Profil" title="Photo du Profil" width="150px">
                    </div> <!-- /.col-lg-2 -->

                    <div class="col-lg-7">
                        <h1><?php echo $profil->getPrenom() . ' ' . $profil->getNom(); ?></h1>
                    </div> <!-- /.col-lg-7 -->
                </div> <!-- /.row -->
            </div> <!-- /.jumbotron -->

            <div class="well">
                <fieldset id="infos">
                    <legend>Informations personnelles</legend>

                    <p>
                        <?php
                            echo $profil->getVisibiliteDateNaissance() ? "Date de naissance : " . $profil->getDateNaissance() : "";
                            echo "\n";
                        ?>
                    </p>

                    <p>
                        <?php
                            echo $profil->getVisibiliteEmail() ? 'Email : <a id="lien_profil" href="mailto:' . $profil->getEmail() . '">' . $profil->getEmail() . "</a>" : "";
                            echo "\n";
                        ?>
                    </p>

                    <p>
                        <?php
                            echo $profil->getVisibilitePagePerso() ? 'Page perso : <a id="lien_profil" href="' . $profil->getPagePerso() . '" target="_blank">' . $profil->getPagePerso() . "</a>" : "";
                            echo "\n";
                        ?>
                    </p>
                </fieldset> <!-- /fieldset #infos -->

                <fieldset id="scol">
                    <legend>Parcours scolaire</legend>

                    <?php
                        $diplomes = $profil->getDiplomes();

                        foreach ($diplomes as $diplomeEnCours) {
                            if ($diplomeEnCours->getVisibilite()) {
                                echo "<p>\n";
                                echo $diplomeEnCours->getAnnee() . " : " . $diplomeEnCours->getType() . " "
                                        . $diplomeEnCours->getDiscipline() . " à " . $diplomeEnCours->getEtablissement();
                                echo "\n</p>\n";
                            }
                        }
                    ?>
                </fieldset> <!-- /fieldset #scol -->

                <fieldset id="pro">
                    <legend>Parcours professionnel</legend>

                    <?php
                        $expPros = $profil->getExpPros();

                        foreach ($expPros as $expProEnCours) {
                            if ($expProEnCours->getVisibilite()) {
                                $codeDepartement = infosDepartement($expProEnCours->getDepartement());
                                $codeDepartement = $codeDepartement['codePostal'];

                                echo "<p>\n";
                                echo $expProEnCours->getDateDebut() . " - " . ($expProEnCours->getEnCours() ? "maintenant" : $expProEnCours->getDateFin())
                                        . " : " . $expProEnCours->getIntitule() . " chez " . $expProEnCours->getEntreprise()
                                        . ", " . $expProEnCours->getVille() . " ($codeDepartement)";
                                // @TODO Réfléchir à l'utilité de l'affichage du salaire
                                echo "\n</p>\n";
                            }
                        }
                    ?>
                </fieldset> <!-- /fieldset #pro -->
            </div> <!-- /.well -->
        </div> <!-- /.container -->

        <!-- ================================================== -->

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
