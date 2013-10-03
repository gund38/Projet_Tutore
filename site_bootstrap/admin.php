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
            }

            .resultat_valid {
                width: auto;
                margin: 0 auto;
                margin-bottom: 30px;
            }

            .resultat_valid label {
                font-weight: normal;
            }

            .resultat_valid th, .resultat_valid td {
                padding: 8px 30px !important;
            }

            #promo {
                width: auto;
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
                <li class="active" role="tab">
                    <a href="#valid_comptes" data-toggle="tab">Validation comptes</a>
                </li>

                <li role="tab">
                    <a href="#valid_master" data-toggle="tab">Étudiants <span class="icon-arrow-right"></span> Anciens Étudiants</a>
                </li>

                <li role="tab">
                    <a href="#gestion_comptes" data-toggle="tab">Gestion comptes</a>
                </li>

                <li role="tab">
                    <a href="#gestion_offres" data-toggle="tab">Gestion offres</a>
                </li>
            </ul>

            <?php
                // Récupération connexion BD
                $bdd = ConnexionBD::getInstance()->getBDD();
            ?>

            <div id="ongletsContent" class="tab-content">
                <div id="valid_comptes" class="tab-pane fade active in" role="tabpanel">
                    <div class="well">
                        <form role="form" action="#"
                              method="post"
                              name="formValidComptes" id="formValidComptes">
                            <fieldset>
                                <legend>Liste de tous les comptes non validés</legend>

                                <table class="table table-striped sortable resultat_valid">
                                    <thead>
                                        <tr>
                                            <th>
                                                Nom Prénom
                                            </th>
                                            <th>
                                                Type d'utilisateur
                                            </th>
                                            <th class="colonneCheckbox">
                                                <input type="checkbox"
                                                       class="checkboxAll"
                                                       id="ValidComptes" />
                                                Tout sélectionner
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            // Récupération des comptes non validés
                                            // Création de la requête
                                            $requete = 'SELECT p.codePe, p.nom, p.prenom, p.type
                                                FROM Personne AS p
                                                WHERE p.compteValide = 0
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
                                                        <input type="checkbox" class="checkboxValidComptes form-control"
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
                        <form role="form" action="#"
                              method="post"
                              name="formValidMaster" id="formValidMaster">
                            <fieldset>
                                <legend>Liste de tous les Étudiants</legend>

                                <table class="table table-striped sortable resultat_valid">
                                    <thead>
                                        <tr>
                                            <th>
                                                Nom Prénom
                                            </th>
                                            <th>
                                                <input type="checkbox"
                                                       class="checkboxAll"
                                                       id="ValidMaster" />
                                                Tout sélectionner
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            // Récupération des comptes Étudiants
                                            // Création de la requête
                                            $requete = 'SELECT p.codePe, p.nom, p.prenom
                                                FROM Personne AS p
                                                WHERE p.type = "Etudiant"
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
                                                        <input type="checkbox" class="checkboxValidMaster form-control"
                                                               id="<?php echo $compteEnCours['codePe']; ?>"
                                                               name="<?php echo $compteEnCours['codePe']; ?>" />
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>

                                <input type="text" class="form-control"
                                       maxlength="4"
                                       id="promo" name="promo"
                                       placeholder="Promotion" required />

                                <button type="submit" class="btn btn-primary">Étudiants sélectionnés <span class="icon-arrow-right"></span> Anciens Étudiants</button>
                            </fieldset>
                        </form>
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

        <!-- Script onglets -->
        <script type="text/javascript">
            // Permet d'afficher directement l'onglet voulu depuis un lien externe
            $(window).load(function() {
                $('#onglets a[href="' + $(location).prop("hash") + '"]').tab("show");
            });

            // Permet d'afficher directement l'onglet voulu depuis un lien interne
            $(window).load(function() {
                $(".liensOnglets").click(function() {
                    $('#onglets a[href="' + $(this).prop("hash") + '"]').tab("show");
                });
            });

            // Permet la modification de l'adresse selon l'onglet choisi
            $(window).load(function() {
                $("#onglets a").click(function() {
                    $(location).prop("hash", $(this).prop("hash"));
                });
            });
        </script>

        <!-- Script checkboxes "Tout sélectionner" -->
        <script type="text/javascript">
            $(".checkboxAll").change(function() {
                $(".checkbox" + $(this).prop("id")).prop("checked", $(this).prop("checked"));
            }).change();
        </script>
    </body>
</html>
