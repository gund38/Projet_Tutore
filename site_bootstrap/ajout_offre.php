<?php
    /**
     * Page d'ajout d'une offre d'emploi ou de stage
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

        <title>Site Web des Anciens Étudiants du Master TI</title>

        <style type="text/css">
            body {
                padding-top: 70px;
                padding-bottom: 30px;
            }

            .jumbotron small {
                font-size: 75%;
            }

            .obligatoire {
                color: red;
            }

            table {
                margin: 0 auto;
            }

            td {
                padding: 10px;
            }

            th label, .row label {
                width: 100%;
                text-align: right;
            }

            .btn-submit {
                display: table;
                margin: 20px auto;
            }

            .row {
                margin-left: 0px;
            }

            .col-lg-5, .col-lg-7 {
                padding-left: 0px;
            }
        </style>
    </head>

    <body>
        <?php
            // Affichage menu
            $page = "Ajout_offre";
            require_once 'menus/menuBootstrap.php';
        ?>

        <div class="container" role="main">
            <div class="jumbotron">
                <h1>Ajouter une offre</h1>

                <p class="lead">
                    Utilisez le formulaire suivant pour ajouter une offre d'emploi ou de stage.
                </p>

                <p>
                    <small>Les champs marqués par <span class="obligatoire">*</span> sont obligatoires.</small>
                </p>

                <?php
                    // Gestion des erreurs au niveau de l'ajout d'une offre
                    if (isset($_SESSION['erreurs_ajout'])) {
                ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                            <small><?php echo $_SESSION['erreurs_ajout']; ?></small>
                        </div>
                <?php
                        unset($_SESSION['erreurs_ajout']);
                    }

                    // Gestion de la réussite de l'ajout d'une offre
                    if (isset($_SESSION['sortie_ajout'])) {
                ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                            <small><?php echo $_SESSION['sortie_ajout']; ?></small>
                        </div>
                <?php
                        unset($_SESSION['sortie_ajout']);
                    }
                ?>
            </div> <!-- /.jumbotron -->

            <div class="well">
                <form role="form" action="fonctions/ajouterOffre.php"
                      method="post" enctype="multipart/form-data"
                      name="formAjoutOffre" id="formAjoutOffre">
                    <table>
                        <tr>
                            <th>
                                <label for="intitule" class="control-label">
                                    Intitulé&nbsp;<span class="obligatoire">*</span>
                                </label>
                            </th>

                            <td colspan="3">
                                <input type="text" name="intitule" id="intitule"
                                       class="form-control" placeholder="Intitulé" />
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="entreprise" class="control-label">
                                    Entreprise / Organisation&nbsp;<span class="obligatoire">*</span>
                                </label>
                            </th>

                            <td>
                                <input type="text" name="entreprise" id="entreprise"
                                       class="form-control" placeholder="Entreprise" />
                            </td>

                            <th>
                                <label for="ville" class="control-label">
                                    Ville&nbsp;<span class="obligatoire">*</span>
                                </label>
                            </th>

                            <td>
                                <input type="text" name="ville" id="ville"
                                       class="form-control" placeholder="Ville" />
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="departement" class="control-label">
                                    Département&nbsp;<span class="obligatoire">*</span>
                                </label>
                            </th>

                            <td>
                                <select name="departement" id="departement" class="form-control">
                                    <?php
                                        // Récupération de la liste des départements
                                        $listeDep = listeDepartements();

                                        foreach ($listeDep as $value) {
                                            echo "<option value=\"" . $value['codeDe']
                                            . "\">" . $value['nom']
                                            . "</option>\n";
                                        }
                                    ?>
                                </select>
                            </td>

                            <th>
                                <label for="remuneration" class="control-label">
                                    Rémunération&nbsp;<span class="obligatoire">*</span>
                                </label>
                            </th>

                            <td>
                                <div class="row">
                                    <div class="col-lg-7">
                                        <input type="number" name="remuneration" id="remuneration"
                                               class="form-control" min="0" />
                                    </div>

                                    <div class="col-lg-5">
                                        <select name="periodicite" id="periodicite" class="form-control">
                                            <option value="mois">€ / mois</option>
                                            <option value="annee">€ / an</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="type" class="control-label">
                                    Type&nbsp;<span class="obligatoire">*</span>
                                </label>
                            </th>

                            <td>
                                <select name="type" id="type" class="form-control">
                                    <?php
                                        // Récupération de la liste des types d'offre
                                        $listeTypes = listeTypesOffre();

                                        foreach ($listeTypes as $value) {
                                            echo "<option value=\"" . $value
                                            . "\">" . $value
                                            . "</option>\n";
                                        }
                                    ?>
                                </select>
                            </td>

                            <td colspan="2">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="fichier" class="control-label">
                                            Sélectionner le fichier PDF à ajouter (max&nbsp;:&nbsp;2Mo)&nbsp;<span class="obligatoire">*</span>
                                        </label>
                                    </div>

                                    <div class="col-lg-8">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="2097150" />

                                        <input type="file" name="fichier" id="fichier" />
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <input type="submit" class="btn btn-success btn-lg btn-submit" value="Valider" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div> <!-- /.well -->
        </div> <!-- /.container -->

        <!-- ================================================== -->

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
