<?php
    /**
     * Page d'aministration
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
            }

            table.resultat_valid_comptes {
                width: 75%;
                margin: 0 auto;
            }

            table.resultat_valid_comptes label {
                font-weight: normal;
            }

            button {
                margin-top: 30px;
            }
        </style>
    </head>

    <body>
        <?php
            // Affichage menu
            $page = "Admin";
            require_once 'menus/menuBootstrap.php';
        ?>

        <div class="container" role="main">
            <div class="jumbotron">
                <h1>Administration</h1>
            </div> <!-- /.jumbotron -->

            <ul class="nav nav-tabs" id="onglets" role="tablist">
                <li class="active">
                    <a href="#valid_comptes" data-toggle="tab">Validation comptes</a>
                </li>

                <li>
                    <a href="#valid_master" data-toggle="tab">Validation Master</a>
                </li>

                <li>
                    <a href="#gestion_comptes" data-toggle="tab">Gestion comptes</a>
                </li>

                <li>
                    <a href="#gestion_offres" data-toggle="tab">Gestion offres</a>
                </li>
            </ul>

            <div id="ongletsContent" class="tab-content">
                <div id="valid_comptes" class="tab-pane fade active in" role="tabpanel">
                    <div class="well">
                        <form role="form" action="#"
                              method="post"
                              name="formValidComptes" id="formValidComptes">
                            <fieldset>
                                <legend>Liste de tous les comptes non validés</legend>

                                <table class="table table-striped sortable resultat_valid_comptes">
                                    <thead>
                                        <tr>
                                            <th>
                                                Nom Prénom
                                            </th>
                                            <th>
                                                Type d'utilisateur
                                            </th>
                                            <th>
                                                <input type="checkbox" id="all"/>
                                                Tout sélectionner
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            // Récupération connexion BD
                                            $bdd = ConnexionBD::getInstance()->getBDD();

                                            // Création de la requête
                                            $requete = 'SELECT p.codePe, p.nom, p.prenom, p.type
                                                FROM Personne AS p
                                                WHERE compteValide = 0
                                                ORDER BY p.nom';

                                            // Exécution de la requête
                                            $req = $bdd->query($requete);

                                            // Extraction des résultats
                                            $resultats = $req->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($resultats as $compteEnCours) {
                                        ?>
                                                <tr>
                                                    <td>
                                                        <label for="<?php echo $compteEnCours['codePe']; ?>"><?php echo $compteEnCours['nom'] . " " . $compteEnCours['prenom']; ?></label>
                                                    </td>
                                                    <td>
                                                        <label for="<?php echo $compteEnCours['codePe']; ?>"><?php echo $compteEnCours['type']; ?></label>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="checkbox form-control"
                                                               id="<?php echo $compteEnCours['codePe']; ?>"
                                                               name="<?php echo $compteEnCours['codePe']; ?>" />
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-primary">Valider les comptes sélectionnés</button>
                            </fieldset>
                        </form>
                    </div> <!-- /.well -->
                </div> <!-- /.tab-pane #valid_comptes -->

                <div id="valid_master" class="tab-pane fade" role="tabpanel">
                    <div class="well">
                        <p>
                            Valid_master
                        </p>
                    </div> <!-- /.well -->
                </div> <!-- /.tab-pane #valid_master -->

                <div id="gestion_comptes" class="tab-pane fade" role="tabpanel">
                    <div class="well">
                        <p>
                            Gestion_comptes
                        </p>
                    </div> <!-- /.well -->
                </div> <!-- /.tab-pane #gestion_comptes -->

                <div id="gestion_offres" class="tab-pane fade" role="tabpanel">
                    <div class="well">
                        <p>
                            Gestion_offres
                        </p>
                    </div> <!-- /.well -->
                </div> <!-- /.tab-pane #gestion_offres -->
            </div> <!-- /.tab-content -->
        </div> <!-- /.container -->

        <!-- ================================================== -->

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

        <!-- Script tri tableau -->
        <script src="js/sorttable.js" type="text/javascript" charset="utf-8"></script>

        <script type="text/javascript">
            $("#all").change(function() {
                $(".checkbox").prop("checked", $(this).prop("checked"));
            }).change();
        </script>
    </body>
</html>
