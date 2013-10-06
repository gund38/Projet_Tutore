<?php
    /**
     * Page de contact
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

            .obligatoire {
                color: red;
            }

            table {
                width: 50%;
                margin: 0 auto;
            }

            td {
                padding: 10px;
            }

            th label {
                width: 100%;
                text-align: right;
            }

            .btn-submit {
                display: table;
                margin: 20px auto;
            }
        </style>
    </head>

    <body>
        <?php
            // Affichage menu
            $page = "Contact";
            require_once 'menus/menuBootstrap.php';
        ?>

        <div class="container" role="main">
            <div class="jumbotron">
                <h1>Contacter l'administrateur</h1>

                <p>
                    Vous pouvez utiliser le formulaire suivant afin de contacter l'administrateur pour lui signaler une erreur, un problème ou un bug,<br />
                    ainsi que pour lui demander la modification ou suppression de votre compte ou tout autre chose.
                </p>

                <p>
                    <small>Les champs marqués par <span class="obligatoire">*</span> sont obligatoires.</small>
                </p>

                <?php
                    // Gestion des erreurs au niveau de l'ajout d'une offre
                    if (isset($_SESSION['erreurs_contact'])) {
                ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                            <small><?php echo $_SESSION['erreurs_contact']; ?></small>
                        </div> <!-- /.alert -->
                <?php
                        unset($_SESSION['erreurs_contact']);
                    }

                    // Gestion de la réussite de l'ajout d'une offre
                    if (isset($_SESSION['sortie_contact'])) {
                ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                            <small><?php echo $_SESSION['sortie_contact']; ?></small>
                        </div> <!-- /.alert -->
                <?php
                        unset($_SESSION['sortie_contact']);
                    }
                ?>
            </div> <!-- /.jumbotron -->

            <div class="well">
                <form role="form" action=""
                      method="get"
                      name="formContact" id="formContact">
                    <table>
                        <tr>
                            <th>
                                <label for="email" class="control-label">
                                    Email&nbsp;<span class="obligatoire">*</span>
                                </label>
                            </th>

                            <td>
                                <input type="email" name="email" id="email"
                                       class="form-control" placeholder="Email"
                                       value="<?php echo isset($_SESSION['personneCo']) ? $_SESSION['personneCo']->getEmail() : ""; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="message" class="control-label">
                                    Votre message&nbsp;<span class="obligatoire">*</span>
                                </label>
                            </th>

                            <td>
                                <textarea name="message" id="message" class="form-control"
                                          rows="8" cols="45" placeholder="Votre message"></textarea>
                            </td>
                        </tr>
                    </table>

                    <?php
                        if (isset($_SESSION['personneCo'])) {
                    ?>
                        <input type="hidden" name="codePe" id="codePe" value="<?php echo $_SESSION['personneCo']->getCodePe(); ?>" />
                    <?php
                        }
                    ?>
                </form>
            </div> <!-- /.well -->
        </div> <!-- /.container -->

        <!-- ================================================== -->

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
