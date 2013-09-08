<?php
    /**
     * Page de modification du profil d'un ancien étudiant
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

        <!-- CSS checkbox iOS -->
        <link rel="stylesheet" href="css/boutons_iOS" type="text/css" media="screen" charset="utf-8" />

        <!-- CSS calendrier -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />

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

        <style type="text/css">
            .obligatoire {
                color: red;
            }

            .erreur {
                color: red;
            }

            .sortie {
                color: blue;
            }

            .iPhoneCheckContainer {
                width: 80px;
            }

            .iPhoneCheckContainer .iPhoneCheckHandle {
                width: 25px;
            }

            .colonne_visi {
                border-right: 1px dashed #000;
                width: 120px;
            }

            td {
                padding: 10px;
            }

            table {
                width: 100%;
            }

            .formLabel {
                width: 180px;
            }

            .formLabel label {
                width: 100%;
                text-align: right;
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

                        <li class="active"><a href="profil.php">Profil</a></li>

                        <li><a href="#contact">Contact</a></li>
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
                </div> <!-- /.navbar-collapse -->
            </div> <!-- /.container -->
        </div> <!-- /.navbar -->

        <div class="container theme-showcase">
            <!-- Main jumbotron for a primary marketing message or call to action -->
            <div class="jumbotron">
                <div class="row">
                    <div class="col-lg-2">
                        <img src="images/profil/5209f222cbfdb.jpg" alt="Image de profil"
                             class="img-rounded" width="150px" />
                    </div>

                    <div class="col-lg-7">
                        <h2>Kévin Bélellou</h2>

                        <p class="lead">
                            Ici c'est votre profil ! Vous pouvez modifier toutes vos informations personnelles, ainsi que vos parcours scolaire et professionnel.
                            Si vous ne voulez pas qu'un élément soit visible sur votre profil public, il vous suffit de mettre l'interrupteur correspondant sur "Non"
                        </p>

                        <p>
                            <small>Les champs marqués par <span class="obligatoire">*</span> sont obligatoires.</small>
                        </p>

                        <p class="erreur">
                            <?php
                                // Gestion des erreurs au niveau de l'ajout d'une offre
                                if (isset($_SESSION['erreurs_profil'])) {
                                    echo substr_count($_SESSION['erreurs_profil'], "<br />\n") > 1 ? "Erreurs :" : "Erreur :";
                                    echo "<br />\n";
                                    echo $_SESSION['erreurs_profil'];
                                    unset($_SESSION['erreurs_profil']);
                                } else {
                                    echo "\n";
                                }
                            ?>
                        </p>

                        <p class="sortie">
                            <?php
                                // Gestion de la réussite de l'ajout d'une offre
                                if (isset($_SESSION['sortie_profil'])) {
                                    echo "<br />\n";
                                    echo $_SESSION['sortie_profil'];
                                    unset($_SESSION['sortie_profil']);
                                } else {
                                    echo "\n";
                                }
                            ?>
                        </p>
                    </div>

                    <div class="col-lg-3 text-center">
                        <br />
                        <button type="submit" class="btn btn-success btn-lg">Sauvegarder</button>
                        <br /><br />
                        <a href="#" class="btn btn-primary btn-lg">Voir mon profil public</a>
                    </div>
                </div> <!-- /.row -->
            </div> <!-- /.jumbotron -->

            <ul class="nav nav-tabs" id="onglets">
                <li class="active"><a href="#infos" data-toggle="tab">Informations personnelles</a></li>
                <li><a href="#scol" data-toggle="tab">Parcours scolaire</a></li>
                <li><a href="#pro" data-toggle="tab">Parcours professionnel</a></li>
            </ul>

            <div id="ongletsContent" class="tab-content">
                <div id="infos" class="tab-pane fade active in">
                    <div class="well">
                        <form role="form"
                              action="" method="post">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="colonne_visi">
                                            <p class="text-info">
                                                <i class="icon-eye-open icon-2x pull-left"></i> <strong>Visibilité publique</strong>
                                            </p>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" class="form-control checkboxiOS"
                                                   name="visi_photo" id="visi_photo" />
                                        </td>

                                        <td class="formLabel">
                                            <label for="photo" class="control-label">Photo de profil (max&nbsp;:&nbsp;2&nbsp;Mo)</label>
                                        </td>

                                        <td>
                                            <input type="hidden" name="MAX_FILE_SIZE" value="2097150" />
                                            <input type="file" name="photo" id="photo" accept="image/*" />
                                        </td>

                                        <td>
                                            <div class="checkbox">
                                                <label class="control-label">
                                                    <input type="checkbox" class="form-control" />
                                                    Supprimer ma photo de profil actuelle
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" class="form-control checkboxiOS"
                                                   name="visi_date_naiss" id="visi_date_naiss" />
                                        </td>

                                        <td class="formLabel">
                                            <label for="date_naiss" class="control-label">Date de naissance</label>
                                        </td>

                                        <td>
                                            <div class="input-group">
                                                <input type="date" class="form-control"
                                                       id="date_naiss" name="date_naiss"
                                                       placeholder="" />
                                                <span class="input-group-addon" onclick="afficherCalendrier($(this));">
                                                    <i class="icon-calendar icon-border"></i>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" class="form-control checkboxiOS"
                                                   name="visi_email" id="visi_email" />
                                        </td>

                                        <td class="formLabel">
                                            <label for="email" class="control-label">Email&nbsp;<span class="obligatoire">*</span></label>
                                        </td>

                                        <td colspan="2">
                                            <input type="email" class="form-control"
                                                   id="email" name="email"
                                                   placeholder="Email" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" class="form-control checkboxiOS"
                                                   name="visi_page" id="visi_page" />
                                        </td>

                                        <td class="formLabel">
                                            <label for="page" class="control-label">Page perso</label>
                                        </td>

                                        <td colspan="2">
                                            <input type="url" class="form-control"
                                                   id="page" name="page"
                                                   placeholder="Page perso" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div> <!-- /.well -->
                </div> <!-- /.tab-pane #infos -->

                <div id="scol" class="tab-pane fade">
                    <?php
                        // Récupération complète du profil courant
                        $profilManager = new ProfilManager(ConnexionBD::getInstance()->getBDD());
                        $profil = $profilManager->getProfil($_SESSION['personneCo']->getCodePe());
                        $profil->obtenirProfilComplet();
                    ?>

                    <input type="hidden" name="nbDiplomes" id="nbDiplomes"
                           value="<?php echo count($profil->getDiplomes()); ?>" />

                    <?php
                        // Génération et affichage des formulaires des diplômes
                        require_once 'fonctions/generationFormulaireDiplomesBootstrap.php';
                    ?>
                </div> <!--/.tab-pane #scol -->

                <div id="pro" class="tab-pane fade">
                    <input type="hidden" name="nbExpPros" id="nbExpPros"
                           value="<?php echo count($profil->getExpPros()); ?>" />

                    <?php
                        // Génération et affichage des formulaires des expériences professionnelles
                        require_once 'fonctions/generationFormulaireExpProsBootstrap.php';
                    ?>
                </div> <!-- /.tab-pane #pro -->
            </div> <!-- /.tab-content -->
        </div> <!-- /.container -->

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

         <!-- JavaScript checkbox iOS -->
        <script src="js/iphone-style-checkboxes.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" charset="utf-8">
            // Affichage et configuration des checkbox style iOS
            $(window).ready(function() {
                $('.checkboxiOS').iphoneStyle({
                    resizeContainer: false,
                    resizeHandle: false,
                    checkedLabel: 'Oui',
                    uncheckedLabel: 'Non'
                });
            });
        </script>

        <!-- JavaScript calendrier -->
        <script src="js/jquery-ui.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.ui.datepicker-fr.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" charset="utf-8">
            // Configuration des calendriers
            $(function() {
                // Mettre les calendriers en français
                $.datepicker.setDefaults($.datepicker.regional[ "fr" ]);

                // Configuration calendrier "Date de naissance"
                $("#date_naiss").datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true,
                    showOn: "focus",
                    //buttonImage: "",
                    //buttonImageOnly: true,
                    //buttonText: "",
                    //defaultDate: -8395,
                    minDate: new Date(1900, 1 - 1, 1),
                    maxDate: 0,
                    dateFormat: "dd/mm/yy"
                });

                // Configuration calendrier "Date de début - fin"
                $(".date_deb_fin").datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true,
                    //showOn: "both",
                    showOn: "focus",
                    //buttonImage: "images/calendar.gif",
                    //buttonImageOnly: true,
                    //buttonText: "Calendrier",
                    minDate: new Date(1900, 1 - 1, 1),
                    maxDate: 0,
                    dateFormat: "dd/mm/yy"
                });
            });
        </script>
        <script type="text/javascript" charset="utf-8">
            // Affichage du calendrier quand clic sur l'image
            function afficherCalendrier(objet) {
                $(objet).parent().datepicker("show");
            }
        </script>
    </body>
</html>
