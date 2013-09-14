<?php
    /**
     * Page de recherche des offres d'emploi et de stage
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

            table {
                width: 75%;
            }

            td {
                padding: 10px;
            }

            th label, .col-lg-2 label {
                width: 100%;
                text-align: right;
            }

            .col-lg-2 label {
                text-align: right;
            }

            .jumbotron {
                margin-bottom: 0px;
            }
        </style>
    </head>

    <body>
        <?php
            $page = "Recherche_offres";
            require_once 'menus/menuBootstrap.php';
        ?>

        <div class="container" role="main">
            <div class="jumbotron">
                <h1>Offres d'emploi<?php echo isset($_SESSION['personneCo']) ? " et de stage" : ""; ?></h1>

                <p>
                    Ici vous pouvez rechercher une offre d'emploi<?php echo isset($_SESSION['personneCo']) ? " ou de stage" : ""; ?> suivant différents critères.<br />
                    Vous pouvez cliquer sur les colonnes pour les trier dans l'ordre alphanumérique croissant ou décroissant.
                </p>
            </div>

            <div class="well">
                <form role="form" action="fonctions/rechercherOffres.php"
                      method="post"
                      name="formReOffres" id="formReOffres">
                    <center>
                        <table>
                            <tr>
                                <th>
                                    <label for="intitule" class="control-label">Intitulé</label>
                                </th>

                                <td>
                                    <input type="text" name="intitule" id="intitule" class="form-control" />
                                </td>

                                <th>
                                    <label for="type" class="control-label">Type</label>
                                </th>

                                <td>
                                    <select name="type" id="type" class="form-control">
                                        <option value="all"<?php echo isset($_SESSION['personneCo']) ? "" : " disabled"; ?>>Emploi + Stage</option>
                                        <?php
                                            // Récupération de la liste des types d'offre
                                            $listeTypes = listeTypesOffre();

                                            foreach ($listeTypes as $value) {
                                                echo "<option value=\"$value\"";
                                                echo (strcmp($value, "Stage") === 0 && !isset($_SESSION['personneCo'])) ? " disabled" : "";
                                                echo ">$value</option>\n";
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="ville" class="control-label">Ville</label>
                                </th>

                                <td>
                                    <input type="text" name="ville" id="ville" class="form-control" />
                                </td>

                                <th>
                                    <label for="departement" class="control-label">Département</label>
                                </th>

                                <td>
                                    <select name="departement" id="departement" class="form-control">
                                        <option value="all">Tous les départements</option>
                                        <?php
                                            // Récupération de la liste des départements
                                            $listeDep = listeDepartements();

                                            foreach ($listeDep as $value) {
                                                echo "<option value=\"{$value['codeDe']}\">{$value['nom']}</option>\n";
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" align="center">
                                    <input type="submit" class="btn btn-primary btn-lg" value="Rechercher" />
                                </td>
                            </tr>
                        </table>
                    </center>
                </form>
            </div> <!-- /.well -->

            <?php
                if (isset($_SESSION['recherche_offres'])) {
            ?>
                    <div class="well">
            <?php
                    if (count($_SESSION['recherche_offres']) > 0) {
            ?>
                        <h3 class="text-primary">Résultats de votre recherche</h3>

                        <table class="table table-striped sortable" cellpadding="10px">
                            <thead>
                                <tr>
                                    <th>Date de dépôt</th>
                                    <th>Type</th>
                                    <th>Intitulé du poste</th>
                                    <th>Entreprise / organisation</th>
                                    <th>Ville</th>
                                    <th>Département</th>
                                    <th>Rémunération (€&nbsp;/&nbsp;mois)</th>
                                    <th class="sorttable_nosort">Télécharger l'offre en PDF</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    foreach ($_SESSION['recherche_offres'] as $offreEnCours) {
                                ?>
                                        <tr>
                                            <td><?php echo $offreEnCours['dateDepot']; ?></td>
                                            <td><?php echo $offreEnCours['type']; ?></td>
                                            <td><?php echo $offreEnCours['intitule']; ?></td>
                                            <td><?php echo $offreEnCours['entreprise']; ?></td>
                                            <td><?php echo $offreEnCours['ville']; ?></td>
                                            <td><?php echo "{$offreEnCours['codePostal']} - {$offreEnCours['nom']}"; ?></td>
                                            <td><?php echo $offreEnCours['remuneration']; ?></td>
                                            <td>
                                                <a href="pdf/<?php echo $offreEnCours['cheminPDF']; ?>"
                                                   target="_blank"
                                                   type="application/pdf"
                                                   download="<?php echo $offreEnCours['type'] . " - " . $offreEnCours['intitule']; ?>">
                                                    <img src="images/icone-pdf.gif" alt="Icône PDF" />
                                                </a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
            <?php
                    } else {
            ?>
                        <h3 class="text-danger">Votre recherche n'a pas donné de résultats</h3>
            <?php
                    }
            ?>
                    </div> <!-- /.well -->
            <?php
                    unset($_SESSION['recherche_offres']);
                }
            ?>
        </div> <!-- /.container -->

        <!-- ================================================== -->

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

        <!-- Script tri tableau -->
        <script src="js/sorttable.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>