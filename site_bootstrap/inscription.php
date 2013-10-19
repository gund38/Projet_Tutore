<?php
    /**
     * Page d'inscription
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

        <!-- CSS checkbox iOS -->
        <link href="css/boutons_iOS.css" type="text/css" rel="stylesheet" />

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

            .alert {
                max-width: 450px;
                padding: 15px;
                padding-right: 35px;
                margin: 0 auto;
                text-align: center;
            }
        </style>

        <style type="text/css">
            .password_strength_container {

                height: 10px;
                margin-top: 2px;
                position: relative;
                width: 100%;
            }

            .password_strength {
                background-color: #C81818;
                height: 4px;
                left: 0;
                position: absolute;
                width: 0;
            }

            .password_strength_bg {
                /*background-color: #E8E8E8;*/
                background-color: #CCCCCC;
                height: 4px;
                left: 0;
                position: absolute;
                width: 100%;
            }

            .password_strength_separator {
                background-color: #FFFFFF;
                height: 4px;
                left: 0;
                position: absolute;
                width: 2px;
            }

            .password_strength_desc {
                float: right;
                line-height: 16px;
                margin-top: 6px;
            }

            .password_strength_icon {
                float: right;
                margin-left: 3px;
                margin-top: 5px;
            }
        </style>
    </head>

    <body>
        <?php
            // Affichage menu
            $page = "Inscription";
            require_once 'menus/menuBootstrap.php';

            // Récupération année courante
            $dateCourante = getdate();
            $anneeCourante = $dateCourante['year'];
        ?>

        <div class="container" role="main">
            <div class="jumbotron">
                <h1>S'inscrire</h1>

                <p class="lead">
                    Utilisez le formulaire suivant pour vous inscrire au site.
                </p>

                <p>
                    <small>Les champs marqués par <span class="obligatoire">*</span> sont obligatoires.</small>
                </p>

                <?php
                    // Gestion des erreurs au niveau de l'inscription
                    if (isset($_SESSION['erreurs_inscription'])) {
                ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                            <small><?php echo $_SESSION['erreurs_inscription']; ?></small>
                        </div> <!-- /.alert -->
                <?php
                        unset($_SESSION['erreurs_inscription']);
                    }

                    // Gestion de la réussite de l'inscription
                    if (isset($_SESSION['sortie_inscription'])) {
                ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                            <small><?php echo $_SESSION['sortie_inscription']; ?></small>
                        </div> <!-- /.alert -->
                <?php
                        unset($_SESSION['sortie_inscription']);
                    }
                ?>
            </div> <!-- /.jumbotron -->

            <div class="well">
                <form role="form" action="fonctions/inscrire.php"
                      method="post"
                      name="formInscription" id="formInscription">
                    <div id="formulaire">
                        <table>
                            <tr>
                                <th>
                                    <label for="type">
                                        Type d'utilisateur&nbsp;<span class="obligatoire">*</span>
                                    </label>
                                </th>

                                <td>
                                    <select name="type" id="type" class="form-control">
                                        <option value="Ancien_etudiant">Ancien Étudiant</option>
                                        <option value="Etudiant">Étudiant</option>
                                        <option value="Enseignant">Enseignant</option>
                                    </select>
                                </td>

                                <th>
                                    <label for="nom" class="control-label">
                                        Nom&nbsp;<span class="obligatoire">*</span>
                                    </label>
                                </th>

                                <td>
                                    <input type="text" name="nom" id="nom"
                                           class="form-control" placeholder="Prenom" />
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="prenom" class="control-label">
                                        Prénom&nbsp;<span class="obligatoire">*</span>
                                    </label>
                                </th>

                                <td>
                                    <input type="text" name="prenom" id="prenom"
                                           class="form-control" placeholder="Prénom" />
                                </td>

                                <th>
                                    <label for="email" class="control-label">
                                        Email&nbsp;<span class="obligatoire">*</span>
                                    </label>
                                </th>

                                <td>
                                    <input type="email" name="email" id="email"
                                           class="form-control" placeholder="Email" />
                                </td>
                            </tr>

                            <tr id="reserveAE">
                                <th>
                                    <label for="promo" class="control-label">
                                        Promotion&nbsp;<span class="obligatoire">*</span>
                                    </label>
                                </th>

                                <td>
                                    <input type="number" name="promo" id="promo" max="<?php echo $anneeCourante; ?>"
                                           class="form-control" />
                                </td>

                                <th>
                                    <label for="master_valide" class="control-label">
                                        Master validé&nbsp;?&nbsp;<span class="obligatoire">*</span>
                                    </label>
                                </th>

                                <td>
                                    <input type="checkbox" name="master_valide" id="master_valide"
                                           class="checkboxiOS" />
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="mdp1" class="control-label">
                                        Mot de passe&nbsp;<span class="obligatoire">*</span>
                                    </label>
                                </th>

                                <td>
                                    <input type="password" name="mdp1" id="mdp1"
                                           class="form-control" placeholder="Mot de passe" />

                                    <div class="password_strength_container">
                                        <div class="password_strength_bg"></div>
                                        <div class="password_strength"></div>
                                        <div class="password_strength_separator" style="left: 25%;"></div>
                                        <div class="password_strength_separator" style="left: 50%;"></div>
                                        <div class="password_strength_separator" style="left: 75%;"></div>
                                        <div class="password_strength_desc">&nbsp;</div>
                                    </div>
                                </td>

                                <th>
                                    <label for="mdp2" class="control-label">
                                        Répétez le mot de passe&nbsp;<span class="obligatoire">*</span>
                                    </label>
                                </th>

                                <td>
                                    <input type="password" name="mdp2" id="mdp2"
                                           class="form-control" placeholder="Répétez le mot de passe" />
                                </td>
                            </tr>
                        </table>
                    </div> <!-- /#formulaire -->

                    <input type="submit" class="btn btn-success btn-lg btn-submit" value="Valider" />
                </form>
            </div> <!-- /.well -->
        </div> <!-- /.container -->

        <!-- ================================================== -->

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

        <!-- JavaScript checkbox iOS -->
        <script src="js/iphone-style-checkboxes.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            // Affichage et configuration des checkbox style iOS
            $(window).ready(function() {
                $(".checkboxiOS").iphoneStyle({
                    checkedLabel: 'Oui',
                    uncheckedLabel: 'Non'
                });
            });
        </script>

        <!-- Affichage des inputs 'Promo' et 'Master validé' ssi utilisateur = Ancient Étudiant -->
        <script type="text/javascript">
            $(window).load(function() {
                $("#type").change(function affichageInputs() {
                    $("#reserveAE").css("display", $("#type").prop("value") === "Ancien_etudiant" ? "" : "none");

                    $("#reserveAE input").prop("disabled", $("#type").prop("value") !== "Ancien_etudiant");

                    $("#type").prop("value") === "Ancien_etudiant" ?
                        $("#reserveAE .iPhoneCheckContainer").removeClass("iPhoneCheckDisabled") :
                        $("#reserveAE .iPhoneCheckContainer").addClass("iPhoneCheckDisabled");
                }).change();
            });
        </script>

        <!-- zxcvbn.js, password meter -->
        <script src="js/zxcvbn-async.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            // Appel du password meter dès qu'une touche est appuyée dans l'input mdp1
            $(window).load(function() {
                var couleurs = [
                    "",
                    "#C81818",
                    "#FFAC1D",
                    "#A6C060",
                    "#27B30F"
                ];

                var messages = [
                    ["",        "Insuffisant"],
                    ["#C81818", "Faible"],
                    ["#E28F00", "Moyen"],
                    ["#8AA050", "Bon"],
                    ["#27B30F", "Excellent !"]
                ];

                $("#mdp1").keyup(function forceMDP() {
                    if (!window.zxcvbn) {
                        return 0;
                    }

                    var result = zxcvbn($(this).val());
                    var score = result.score;

                    $(".password_strength").css("backgroundColor", couleurs[score]);
                    $(".password_strength").css("width", (score * 25) + "%");

                    $(".password_strength_desc").css("color", messages[score][0]);
                    $(".password_strength_desc").html(messages[score][1]);
                }).keyup();
            });
        </script>
    </body>
</html>
