<?php
    /**
     * Page d'accueil du site
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <!-- Bootstrap core CSS -->
        <link href="dist/css/bootstrap.css" rel="stylesheet" />

        <!-- Bootstrap theme -->
        <link href="dist/css/bootstrap-theme.min.css" rel="stylesheet" />

        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" />

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
            $page = "Accueil";
            require_once 'menus/menuBootstrap.php';
        ?>

        <div class="container" role="main">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-lg-9">
                        <h1>Site Web des Anciens Étudiants du Master TI</h1>
                    </div> <!-- /.col-lg-9 -->

                    <div class="col-lg-3">
                        <img src="images/logo_uppa.jpg" alt="Logo UPPA"
                             class="img-rounded"
                             width="202px" height="187px" />
                    </div> <!-- /.col-lg-3 -->
                </div> <!-- /.row -->

                <p>
                    Ce site a plusieurs objectifs :
                </p>

                <ul class="icons-ul">
                    <li>
                        <i class="icon-li icon-ok"></i>
                        La création d'un annuaire des Anciens Étudiants du Master TI (Technologie de l'Internet) de Pau
                    </li>

                    <li>
                        <i class="icon-li icon-ok"></i>
                        La centralisation des offres d'emploi et de stage qui sont envoyés au département informatique
                    </li>

                    <li>
                        <i class="icon-li icon-ok"></i>
                        La récupération et le recoupement d'informations sur les Anciens Étudiants afin de générer des statistiques anonymes à destination de l'équipe enseignante
                    </li>
                </ul>

                <p>
                    <a class="btn btn-primary btn-lg">En savoir plus &raquo;</a>
                </p>
            </div> <!--/.jumbotron -->

            <div class="page-header">
                <h1>Les 5 dernières offres d'emploi<?php echo isset($_SESSION['personneCo']) ? "&nbsp;/&nbsp;stage" : ""; ?> ajoutées&nbsp;:</h1>
            </div> <!-- /.page-header -->

            <div class="well">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date de dépôt</th>
                            <th>Type</th>
                            <th>Intitulé du poste</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            // Récupération connexion BD
                            $bdd = ConnexionBD::getInstance()->getBDD();

                            // Création de la requête
                            $requete = 'SELECT DATE_FORMAT(o.dateDepot, \'%d/%m/%Y\') AS dateDepot,
                                o.type, o.intitule
                                FROM Offre AS o';
                            $requete .= isset($_SESSION['personneCo']) ? "" : " WHERE o.type = \"Emploi\"";
                            $requete .= ' ORDER BY o.dateDepot DESC LIMIT 5';

                            // Éxécution de la requête
                            $req = $bdd->query($requete);

                            // Extraction des résultats
                            $resultats = $req->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($resultats as $offreEnCours) {
                        ?>
                        <tr>
                            <td><?php echo $offreEnCours['dateDepot']; ?></td>
                            <td><?php echo $offreEnCours['type']; ?></td>
                            <td><?php echo $offreEnCours['intitule']; ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>

                <button class="btn btn-info">En voir plus...</button>
            </div> <!--/.well -->
        </div> <!-- /.container -->

        <!-- ================================================== -->

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
