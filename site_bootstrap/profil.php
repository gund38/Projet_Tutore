<?php
    /**
     * Page de modification du profil d'un ancien étudiant
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

        <!-- CSS calendrier -->
        <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" />

        <title>Site Web des Anciens Étudiants du Master TI</title>

        <style type="text/css">
            body {
                padding-top: 70px;
                padding-bottom: 30px;
            }

            .obligatoire {
                color: red;
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

            table {
                width: 100%;
            }

            td {
                padding: 10px;
            }

            .formLabel {
                width: 180px;
            }

            .formLabel label {
                width: 100%;
                text-align: right;
            }

            .input-group-addon {
                cursor: pointer;
            }

            .jumbotron small {
                font-size: 75%;
            }

            .modal-dialog {
                width: 900px;
            }
        </style>
    </head>

    <body>
        <?php
            // Affichage menu
            $page = "Profil";
            require_once 'menus/menuBootstrap.php';
        ?>

        <div class="container" role="main">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-lg-2">
                        <img src="images/profil/5209f222cbfdb.jpg" alt="Image de profil"
                             class="img-rounded" width="150" />
                    </div> <!-- /.col-lg-2 -->

                    <div class="col-lg-7">
                        <h2>Kévin Bélellou</h2>

                        <p class="lead">
                            Ici c'est votre profil ! Vous pouvez modifier toutes vos informations personnelles, ainsi que vos parcours scolaire et professionnel.
                            Si vous ne voulez pas qu'un élément soit visible sur votre profil public, il vous suffit de mettre l'interrupteur correspondant sur "Non"
                        </p>

                        <p>
                            <small>Les champs marqués par <span class="obligatoire">*</span> sont obligatoires.</small>
                        </p>

                        <?php
                            // Gestion des erreurs au niveau de la sauvegarde du profil
                            if (isset($_SESSION['erreurs_profil'])) {
                        ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                                    <small><?php echo $_SESSION['erreurs_profil']; ?></small>
                                </div> <!-- /.alert -->
                        <?php
                                unset($_SESSION['erreurs_profil']);
                            }

                            // Gestion de la réussite de la sauvegarde du profil
                            if (isset($_SESSION['sortie_profil'])) {
                        ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                                    <small><?php echo $_SESSION['sortie_profil']; ?></small>
                                </div> <!-- /.alert -->
                        <?php
                                unset($_SESSION['sortie_profil']);
                            }
                        ?>
                    </div> <!-- /.col-lg-7 -->

                    <div class="col-lg-3 text-center">
                        <br />

                        <button class="btn btn-success btn-lg"
                                onclick="document.forms.formProfil.submit();">
                            Sauvegarder
                        </button>

                        <br /><br />

                        <a href="profil_public.php?id=<?php echo $_SESSION['personneCo']->getCodePe(); ?>" class="btn btn-primary btn-lg">Voir mon profil public</a>
                    </div> <!-- /.col-lg-3 -->
                </div> <!-- /.row -->
            </div> <!-- /.jumbotron -->

            <ul class="nav nav-tabs" id="onglets" role="tablist">
                <li class="active" role="tab">
                    <a href="#infos" data-toggle="tab">Informations personnelles</a>
                </li>

                <li role="tab">
                    <a href="#scol" data-toggle="tab">Parcours scolaire</a>
                </li>

                <li role="tab">
                    <a href="#pro" data-toggle="tab">Parcours professionnel</a>
                </li>
            </ul>

            <form role="form" action="fonctions/sauvegarderProfil.php"
                  method="post" enctype="multipart/form-data"
                  name="formProfil" id="formProfil">
                <div id="ongletsContent" class="tab-content">
                    <div id="infos" class="tab-pane fade active in" role="tabpanel">
                        <div class="well">
                            <?php
                                // Récupération complète du profil courant
                                $profilManager = new ProfilManager(ConnexionBD::getInstance()->getBDD());
                                $profil = $profilManager->getProfil($_SESSION['personneCo']->getCodePe());
                                $profil->obtenirProfilComplet();
                            ?>

                            <input type="hidden" name="idProfil" id="idProfil"
                                   value="<?php echo $profil->getCodePe(); ?>" />

                            <table>
                                <thead>
                                    <tr>
                                        <th class="colonne_visi">
                                            <span class="text-info">
                                                <i class="icon-eye-open icon-2x pull-left"></i> <strong>Visibilité publique</strong>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" class="form-control checkboxiOS"
                                                   name="visi_photo" id="visi_photo"
                                                   <?php echo $profil->getVisibilitePhoto() ? "checked" : ""; ?> />
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
                                                    <input type="checkbox" class="form-control"
                                                           name="supprimer_photo" id="supprimer_photo"
                                                           onclick="checkboxDeletePhoto();" />
                                                    Supprimer ma photo de profil actuelle
                                                </label>
                                            </div> <!-- /.checkbox -->
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" class="form-control checkboxiOS"
                                                   name="visi_date_naiss" id="visi_date_naiss"
                                                   <?php echo $profil->getVisibiliteDateNaissance() ? "checked" : ""; ?> />
                                        </td>

                                        <td class="formLabel">
                                            <label for="date_naiss" class="control-label">Date de naissance</label>
                                        </td>

                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                       id="date_naiss" name="date_naiss"
                                                       value="<?php echo $profil->getDateNaissance(); ?>" />

                                                <span class="input-group-addon" onclick="afficherCalendrier($(this));">
                                                    <i class="icon-calendar icon-border"></i>
                                                </span>
                                            </div> <!-- /.input-group -->
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" class="form-control checkboxiOS"
                                                   name="visi_email" id="visi_email"
                                                   <?php echo $profil->getVisibiliteEmail() ? "checked" : ""; ?> />
                                        </td>

                                        <td class="formLabel">
                                            <label for="email" class="control-label">Email&nbsp;<span class="obligatoire">*</span></label>
                                        </td>

                                        <td colspan="2">
                                            <input type="email" class="form-control"
                                                   id="email" name="email"
                                                   placeholder="Email" required
                                                   value="<?php echo $_SESSION['personneCo']->getEmail(); ?>" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" class="form-control checkboxiOS"
                                                   name="visi_page" id="visi_page"
                                                   <?php echo $profil->getVisibilitePagePerso() ? "checked" : ""; ?> />
                                        </td>

                                        <td class="formLabel">
                                            <label for="page" class="control-label">Page perso</label>
                                        </td>

                                        <td colspan="2">
                                            <input type="url" class="form-control"
                                                   id="page" name="page"
                                                   placeholder="Page perso"
                                                   value="<?php echo $profil->getPagePerso(); ?>" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> <!-- /.well -->
                    </div> <!-- /.tab-pane #infos -->

                    <div id="scol" class="tab-pane fade" role="tabpanel">
                        <input type="hidden" name="nbDiplomes" id="nbDiplomes"
                               value="<?php echo count($profil->getDiplomes()); ?>" />

                        <?php
                            // Génération et affichage des formulaires des diplômes
                            require_once 'fonctions/generationFormulaireDiplomesBootstrap.php';
                        ?>

                        <div class="well" id="ajout_diplome" style="text-align: center">
                            <!--<a href="#ajout_diplome" onclick="ajoutDiplome();">Ajouter un nouveau Diplôme</a>-->

                            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal_diplome">
                                Ajouter un nouveau Diplôme
                            </button>

                            <div class="modal fade" id="modal_diplome" tabindex="-1" role="dialog" aria-labelledby="modalLabel_diplome" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                                            <h4 class="modal-title" id="modalLabel_diplome">Ajouter un nouveau Diplôme</h4>
                                        </div> <!-- /.modal-header -->

                                        <div class="modal-body">
                                            <div class="alert alert-danger hidden" id="erreurs_saveDiplome">
                                            </div> <!-- /.alert -->
                                        </div> <!-- /.modal_body -->

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>

                                            <button type="button" id="btn_saveDiplome" class="btn btn-primary" onclick="save('Diplome');">
                                                <i class="icon-check"></i>
                                                Sauvegarder
                                            </button>
                                        </div> <!-- /.modal-footer -->
                                    </div> <!-- /.modal-content -->
                                </div> <!-- /.modal-dialog -->
                            </div> <!-- /.modal -->
                        </div> <!-- /.well #ajout_diplome -->
                    </div> <!-- /.tab-pane #scol -->

                    <div id="pro" class="tab-pane fade" role="tabpanel">
                        <input type="hidden" name="nbExpPros" id="nbExpPros"
                               value="<?php echo count($profil->getExpPros()); ?>" />

                        <?php
                            // Génération et affichage des formulaires des expériences professionnelles
                            require_once 'fonctions/generationFormulaireExpProsBootstrap.php';
                        ?>

                        <div class="well" id="ajout_emploi" style="text-align: center">
                            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal_emploi">
                                Ajouter un nouvel Emploi
                            </button>

                            <div class="modal fade" id="modal_emploi" tabindex="-1" role="dialog" aria-labelledby="modalLabel_diplome" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                                            <h4 class="modal-title" id="modalLabel_emploi">Ajouter un nouvel Emploi</h4>
                                        </div> <!-- /.modal-header -->

                                        <div class="modal-body">
                                            <div class="alert alert-danger hidden" id="erreurs_saveEmploi">
                                            </div> <!-- /.alert -->
                                        </div> <!-- /.modal_body -->

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>

                                            <button type="button" id="btn_saveEmploi" class="btn btn-primary" onclick="save('Emploi');">
                                                <i class="icon-check"></i>
                                                Sauvegarder
                                            </button>
                                        </div> <!-- /.modal-footer -->
                                    </div> <!-- /.modal-content -->
                                </div> <!-- /.modal-dialog -->
                            </div> <!-- /.modal -->
                        </div> <!-- /.well #ajout_emploi -->
                    </div> <!-- /.tab-pane #pro -->
                </div> <!-- /.tab-content -->
            </form>
        </div> <!-- /.container -->

        <!-- ================================================== -->

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

        <!-- JavaScript checkbox iOS -->
        <script src="js/iphone-style-checkboxes.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            // Affichage et configuration des checkbox style iOS
            function checkboxiOS() {
                $(".checkboxiOS").iphoneStyle({
                    resizeContainer: false,
                    resizeHandle: false,
                    checkedLabel: 'Oui',
                    uncheckedLabel: 'Non'
                });
            }
            $(window).ready(checkboxiOS());
        </script>

        <!-- JavaScript calendrier -->
        <script src="js/jquery-ui.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.ui.datepicker-fr.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            // Configuration des calendriers
            function confCalendrier() {
                // Mettre les calendriers en français
                $.datepicker.setDefaults($.datepicker.regional["fr"]);

                // Configuration calendrier "Date de naissance"
                $("#date_naiss").datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true,
                    showOn: "focus",
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
                    showOn: "focus",
                    minDate: new Date(1980, 1 - 1, 1),
                    maxDate: 0,
                    dateFormat: "dd/mm/yy"
                });
            }
            $(window).ready(confCalendrier());

            // Affichage du calendrier quand clic sur l'image
            function afficherCalendrier(objet) {
                $(objet).parent().datepicker("show");
            }
        </script>

        <!-- JavaScript checkbox -->
        <script type="text/javascript">
            // Désactivation du champ 'Photo de profil' si la checkbox
            // 'Supprimer photo' est cochée (et vice-versa)
            function checkboxDeletePhoto() {
                $("#photo").prop("disabled", $("#supprimer_photo").prop("checked"));
            }

            // Désactivation des champs 'Date de fin' si la checkbox
            // 'En cours' associée est cochée (et vice-versa)
            function checkboxEnCours(id) {
                if ($("#enCours" + id).prop("checked")) {
                    $("#date_fin_exp" + id).datepicker("option", "disabled", true);
                    $("#date_fin_exp" + id).parent().children(".input-group-addon").css('cursor', 'not-allowed');
                } else {
                    $("#date_fin_exp" + id).datepicker("option", "disabled", false);
                    $("#date_fin_exp" + id).parent().children(".input-group-addon").css('cursor', 'pointer');
                }
            }

            // Vérification de l'état des checkbox 'En cours' au chargement de la page
            $(window).load(function verificationCheckbox() {
                for (var i = 1; i <= $("#nbExpPros").attr("value"); i++) {
                    checkboxEnCours(i);
                }
            });
        </script>

        <!-- Ajouts et sauvegardes dynamiques -->
        <script type="text/javascript">
            // Récupération en AJAX des formulaires
            // Puis lancement fonctions de configuration (checkbox et calendrier)
            $(window).load(function() {
                // Récupération formulaire diplôme
                $.ajax({
                    dataType: "html",
                    url: "ajax/formulaireDiplome.php"
                }).done(function(htmlDiplome) {
                    $("#modal_diplome div.modal-body").append(htmlDiplome);
                    checkboxiOS();
                });

                // Récupération formulaire emploi
                $.ajax({
                    dataType: "html",
                    url: "ajax/formulaireEmploi.php"
                }).done(function(htmlEmploi) {
                    $("#modal_emploi div.modal-body").append(htmlEmploi);
                    checkboxiOS();
                    confCalendrier();
                });
            });

            // Fonction de sauvegarde des formulaires
            function save(objet) {
                var bouton, url, modal, donnees;

                // On attribue les variables selon le type de formulaire
                switch (objet) {
                    case "Diplome":
                        bouton = $("#btn_saveDiplome i");
                        url = "ajax/ajouterDiplome.php";
                        modal = $("#erreurs_saveDiplome");

                        donnees = {
                            codePe: $("#idProfil").val(),
                            visi_dip: $("#visi_dip").prop("checked"),
                            annee_dip: $("#annee_dip").val(),
                            type_dip: $("#type_dip").val(),
                            disc_dip: $("#disc_dip").val(),
                            etabli_dip: $("#etabli_dip").val()
                        };
                        break;
                    case "Emploi":
                        bouton = $("#btn_saveEmploi i");
                        url = "ajax/ajouterEmploi.php";
                        modal = $("#erreurs_saveEmploi");

                        donnees = {

                        };
                        break;
                    default:
                        return false;
                }

                // Ajout d'une icône d'attente (utile si la sauvegarde prends du temps)
                bouton.removeClass("icon-check").addClass("icon-spin icon-spinner");

                // Appel en AJAX de la fonction de sauvegarde
                $.ajax({
                    async: false,
                    cache: false,
                    data: donnees,
                    dataType: "html",
                    type: "POST",
                    url: url
                }).done(function(reponse){
                    if (reponse === "OK") { // Si tout est bon (sauvegarde effectuée)
                        $(document.forms.formProfil).submit();
                    } else { // Sinon
                        // Suppresion de l'icône d'attente
                        bouton.removeClass("icon-spin icon-spinner").addClass("icon-check");

                        // On affiche les erreurs
                        modal.empty().append(reponse);
                        modal.removeClass("hidden").addClass("show");
                    }
                });
            }
        </script>
    </body>
</html>
