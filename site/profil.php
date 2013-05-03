<?php
    /**
     * Page d'affichage du profil d'un ancien étudiant
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    /**
     * Chargement des fichiers de classes
     *
     * @param string $classe La classe à charger
     */
    function chargerClasse($classe) {
        require_once 'classes/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions/fonctions.php';

    // Démarrage de la session
    session_start();

    // On vérifie si l'on a le droit d'accéder à cette page
    if (!verifierAcces(__FILE__)) {
        $_SESSION['erreur_droits'] = true;
        header("Location: login.php");
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />
        <link rel="stylesheet" href="css/profil.css" />
        <link rel="stylesheet" href="css/onglet.css" />

        <!-- CSS et scripts pour les checkbox iOS -->
        <link rel="stylesheet" href="css/boutons_iOS" type="text/css" media="screen" charset="utf-8" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
        <script src="js/iphone-style-checkboxes.js" type="text/javascript" charset="utf-8"></script>

        <!-- CSS et scripts pour les calendriers -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
        <!--<script src="http://code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>-->
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" type="text/javascript"></script>
        <script src="js/jquery.ui.datepicker-fr.min.js" type="text/javascript"></script>

        <title>Site Web des Anciens Étudiants du Master TI</title>

        <script type="text/javascript">
            //<![CDATA[
            // Fonction pour la configuration du calendrier
            $(function() {
                // Mettre les calendriers en français
                $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );

                // Configuration calendrier "Date de naissance"
                $( "#date_naiss" ).datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true,
                    showOn: "both",
                    buttonImage: "images/calendar.gif",
                    buttonImageOnly: true,
                    buttonText: "Calendrier",
                    defaultDate: -8395,
                    minDate: new Date(1900, 1 - 1, 1),
                    maxDate: 0
                });

                // Configuration calendrier "Date de début - fin"
                $( ".date_deb_fin" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "both",
                    buttonImage: "images/calendar.gif",
                    buttonImageOnly: true,
                    buttonText: "Calendrier",
                    showButtonPanel: true,
                    dateFormat: 'MM yy',
                    minDate: new Date(1900, 1 - 1, 1),
                    maxDate: 0,
                    onClose: function(dateText, inst) {
                        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).datepicker('setDate', new Date(year, month, 1));
                    }
                });

                $(".date_deb_fin").focus(function () {
                    $(".ui-datepicker-calendar").hide();
                    $("#ui-datepicker-div").position({
                        my: "center top",
                        at: "center bottom",
                        of: $(this)
                    });
                });
            });
            //]]>
        </script>

        <script type="text/javascript">
            //<![CDATA[
            // Fonction pour le système de changement d'onglet
            function change_onglet(name) {
                document.getElementById('onglet_'+anc_onglet).className = 'onglet_0 onglet';
                document.getElementById('onglet_'+name).className = 'onglet_1 onglet';
                document.getElementById('contenu_onglet_'+anc_onglet).style.display = 'none';
                document.getElementById('contenu_onglet_'+name).style.display = 'block';
                anc_onglet = name;
            }
            //]]>
        </script>

        <script type="text/javascript" charset="utf-8">
            //<![CDATA[
            // Affichage et configuration des checkbox style iOS
            $(window).ready(function() {
                $('.colonne_visi :checkbox').iphoneStyle({
                    resizeContainer: false,
                    resizeHandle: false,
                    checkedLabel: 'Oui',
                    uncheckedLabel: 'Non'
                });
            });
            //]]>
        </script>
    </head>
    <body>
        <div id="global">
            <div id="entete">
                <h1>Site Web des Anciens Étudiants du Master TI</h1>
            </div>

            <?php
                // Appel dynamique du menu selon l'identité de la personne
                afficherMenu();
            ?>
            <div id="contenu">
                <?php
                    $profilManager = new ProfilManager(ConnexionBD::getInstance()->getBDD());

                    $profil = $profilManager->getProfil($_SESSION['personneCo']->getCodePe());
                ?>

                <div id="profil_photo">
                    <img src="images/photo_profil.png" alt="Photo du Profil" title="Photo du Profil" width="200px">
                </div>

                <div id="profil_description">
                    <h4>Ramoloss -> <?php echo $_SESSION['personneCo']->getPrenom() . ' ' . $_SESSION['personneCo']->getNom(); ?></h4>
                    <p>
                        Très lent et endormi, il lui faut 5 secondes pour ressentir la douleur d'une attaque.
                        Lent et stupide, il aime se la couler douce en observant l'activité autour de lui.
                        Un Pokémon crétin constamment dans la lune qui aime pêcher avec sa queue. Endormi ou éveillé, il n'y a aucune différence.
                        Il est tellement paresseux, qu'il lui faut une journée pour remarquer qu'on lui mord la queue.
                        Une sève sucrée coule du bout de sa queue. Peu nutritive, elle reste agréable a mâchouiller.
                        Il est tellement paresseux qu'il lui faut une journée pour remarquer qu'on lui mord la queue.
                    </p>
                </div>

                <div id="profil_bouton">
                    <table>
                        <tr><td> <a href="#" onclick="document.formProfil.submit();">Sauvegarder</a> </td></tr>
                        <tr><td> <a href="#">Voir mon profil public</a> </td></tr>
                        <tr><td> <a href="#">Réinitialiser mon profil</a> </td></tr>
                    </table>
                </div>

                <div id="profil_general">
                    <form action="fonctions/sauvegarderProfil.php" method="post" enctype="multipart/form-data" name="formProfil">
                        <div class="systeme_onglets">
                            <span class="onglet_0 onglet" id="onglet_infos" onclick="javascript:change_onglet('infos');">Informations personnelles</span>
                            <span class="onglet_0 onglet" id="onglet_diplomes" onclick="javascript:change_onglet('diplomes');">Parcours scolaire</span>
                            <span class="onglet_0 onglet" id="onglet_exppros" onclick="javascript:change_onglet('exppros');">Vie active</span>
                        </div>

                        <div class="contenu_onglet" id="contenu_onglet_infos">
                            <fieldset>
                                <table>
                                    <tr>
                                        <th class="colonne_visi">Visibilité publique</th>
                                    </tr>
                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" name="visi_photo" id="visi_photo" />
                                        </td>
                                        <td>
                                            <label for="photo">Photo de profil&nbsp;:</label>
                                        </td>
                                        <td>
                                            <input type="hidden" name="MAX_FILE_SIZE" value="2097150" />
                                            <input type="file" name="photo" id="photo" accept="image/*" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" name="visi_date_naiss" id="visi_date_naiss" />
                                        </td>
                                        <td>
                                            <label for="date_naiss">Date de naissance&nbsp;:</label>
                                        </td>
                                        <td>
                                            <input type="text" name="date_naiss" id="date_naiss" size="10%" style="min-width: 120px" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" name="visi_email" id="visi_email" />
                                        </td>
                                        <td>
                                            <label for="email">Email&nbsp;:</label>
                                        </td>
                                        <td>
                                            <input type="email" name="email" id="email" size="30%" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" name="visi_page" id="visi_page" />
                                        </td>
                                        <td>
                                            <label for="page">Page perso&nbsp;:</label>
                                        </td>
                                        <td>
                                            <input type="email" name="page" id="page" size="30%" />
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </div>

                        <div class="contenu_onglet" id="contenu_onglet_diplomes">
                            <fieldset>
                                <!--<legend>Master</legend>-->

                                <table>
                                    <tr>
                                        <th class="colonne_visi">Visibilité publique</th>
                                    </tr>
                                    <tr>
                                        <td class="colonne_visi" rowspan="4">
                                            <input type="checkbox" name="visi_dip1" id="visi_dip1" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="annee_dip1">Année d'obtention&nbsp;:</label>
                                        </td>
                                        <td colspan="3">
                                            <input type="text" name="annee_dip1" id="annee_dip1" maxlength="4" size="5%" style="min-width: 60px" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="type_dip1">Diplôme obtenu&nbsp;:</label>
                                        </td>
                                        <td>
                                            <select name="type_dip1" id="type_dip1">
                                                <?php
                                                    // Récupération de la liste des types de diplôme
                                                    $listeTypes = listeTypesDiplome();

                                                    foreach ($listeTypes as $value) {
                                                        echo "<option value=\"" . $value
                                                        . "\">" . $value
                                                        . "</option>\n";
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <label for="disc_dip1">Discipline&nbsp;:</label>
                                        </td>
                                        <td>
                                            <input type="text" name="disc_dip1" id="disc_dip1" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="etabli_dip1">Établissement&nbsp;:</label>
                                        </td>
                                        <td colspan="3">
                                            <input type="text" name="etabli_dip1" id="etabli_dip1" size="30%" />
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </div>

                        <div class="contenu_onglet" id="contenu_onglet_exppros">
                            <fieldset>
                                <!--<legend></legend>-->

                                <table>
                                    <tr>
                                        <th class="colonne_visi">Visibilité publique</th>
                                    </tr>
                                    <tr>
                                        <td class="colonne_visi" rowspan="6">
                                            <input type="checkbox" name="visi_exp1" id="visi_exp1" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="annee_deb_exp1">Date de début&nbsp;:</label>
                                        </td>
                                        <td>
                                            <input type="text" name="annee_deb_exp1" id="annee_deb_exp1" class="date_deb_fin" size="10%" style="min-width: 140px" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="annee_fin_exp1">Date de fin&nbsp;:</label>
                                        </td>
                                        <td colspan="3">
                                            <input type="text" name="annee_fin_exp1" id="annee_fin_exp1" class="date_deb_fin" size="10%" style="min-width: 140px" />
                                            <input type="checkbox" name="enCours_exp1" id="enCours" />
                                            <label for="enCours_exp1">Ceci est mon poste actuel</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="inti_exp1">Intitulé&nbsp;:</label>
                                        </td>
                                        <td colspan="3">
                                            <input type="text" name="inti_exp1" id="inti_exp1" size="50%" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="entre_exp1">Entreprise&nbsp;:</label>
                                        </td>
                                        <td colspan="3">
                                            <input type="text" name="entre_exp1" id="entre_exp1" size="50%" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="ville_exp1">Ville&nbsp;:</label>
                                        </td>
                                        <td>
                                            <input type="text" name="ville_exp1" id="ville_exp1" size="15%" />
                                        </td>
                                        <td>
                                            <label for="dep_exp1">Département&nbsp;:</label>
                                        </td>
                                        <td>
                                            <select name="dep_exp1" id="dep_exp1">
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
                                    </tr>
                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" name="visi_salaire_exp1" id="visi_salaire_exp1" />
                                        </td>
                                        <td>
                                            <label for="salaire_exp1">Salaire annuel&nbsp;:</label>
                                        </td>
                                        <td>
                                            <select name="salaire_exp1" id="salaire_exp1">
                                                <?php
                                                    // Récupération de la liste des types de diplôme
                                                    $listeTranches = listeTranchesSalaire();

                                                    foreach ($listeTranches as $value) {
                                                        echo "<option value=\"" . $value
                                                        . "\">" . $value
                                                        . "</option>\n";
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>

                            <!--<hr width=1 size=500 style="background-color:black;" align="left" />-->
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            //<![CDATA[
            var anc_onglet = 'infos';
            change_onglet(anc_onglet);
            //]]>
        </script>
    </body>
</html>
