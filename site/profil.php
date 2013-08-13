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
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/iphone-style-checkboxes.js" type="text/javascript" charset="utf-8"></script>

        <!-- CSS et scripts pour les calendriers -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.ui.datepicker-fr.min.js" type="text/javascript" charset="utf-8"></script>

        <!-- Scripts pour le profil -->
        <script src="js/profil.js" type="text/javascript" charset="utf-8"></script>

        <title>Site Web des Anciens Étudiants du Master TI</title>
    </head>

    <body onload="verificationCheckbox();">
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
                    // Récupération complète du profil courant
                    $profilManager = new ProfilManager(ConnexionBD::getInstance()->getBDD());
                    $profil = $profilManager->getProfil($_SESSION['personneCo']->getCodePe());
                    $profil->obtenirProfilComplet();
                ?>

                <div id="profil_photo">
                    <img src="images/profil/<?php echo $profil->getCheminPhoto(); ?>" alt="Photo du Profil" title="Photo du Profil" width="150px">
                </div>

                <div id="profil_description">
                    <h4><?php echo $_SESSION['personneCo']->getPrenom() . ' ' . $_SESSION['personneCo']->getNom(); ?></h4>

                    <p>
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

                <div id="profil_bouton">
                    <table>
                        <tr>
                            <td>
                                <a href="#" onclick="document.forms.formProfil.submit();">Sauvegarder</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="profil_public-<?php echo $profil->getCodePe(); ?>.php">Voir mon profil public</a>
                            </td>
                        </tr>
<!--                        <tr>
                            <td>
                                <a href="#" onclick="resetFormulaire();">Réinitialiser mon profil</a>
                            </td>
                        </tr>-->
                    </table>
                </div>

                <div id="profil_general">
                    <form action="fonctions/sauvegarderProfil.php" method="post" enctype="multipart/form-data" name="formProfil" id="formProfil">
                        <div class="systeme_onglets">
                            <span class="onglet_0 onglet" id="onglet_infos" onclick="javascript:change_onglet('infos');">Informations personnelles</span>
                            <span class="onglet_0 onglet" id="onglet_diplomes" onclick="javascript:change_onglet('diplomes');">Parcours scolaire</span>
                            <span class="onglet_0 onglet" id="onglet_exppros" onclick="javascript:change_onglet('exppros');">Parcours professionnel</span>
                        </div>

                        <div class="contenu_onglet" id="contenu_onglet_infos">
                            <input type="hidden" name="idProfil" id="idProfil"
                                   value="<?php echo $profil->getCodePe(); ?>" />
                            <?php /** @TODO Remplacer les id et les nb par $_SESSION pour éviter modifications */ ?>
                            <fieldset>
                                <table>
                                    <tr>
                                        <th class="colonne_visi">Visibilité publique</th>
                                    </tr>
                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" name="visi_photo" id="visi_photo"
                                                    <?php echo $profil->getVisibilitePhoto() ? "checked" : ""; ?> />
                                        </td>
                                        <td>
                                            <label for="photo">Photo de profil (max&nbsp;:&nbsp;2Mo)&nbsp;:</label>
                                        </td>
                                        <td>
                                            <input type="hidden" name="MAX_FILE_SIZE" value="2097150" />
                                            <input type="file" name="photo" id="photo" accept="image/*" />
                                        </td>
                                        <td>
                                            <input type="checkbox" name="supprimer_photo" id="supprimer_photo"
                                                   onclick="checkboxDeletePhoto();"/>
                                            <label for="supprimerPhoto">Supprimer ma photo de profil actuelle</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" name="visi_date_naiss" id="visi_date_naiss"
                                                   <?php echo $profil->getVisibiliteDateNaissance() ? "checked" : ""; ?> />
                                        </td>
                                        <td>
                                            <label for="date_naiss">Date de naissance&nbsp;:</label>
                                        </td>
                                        <td>
                                            <input type="text" name="date_naiss" id="date_naiss" size="10%" style="min-width: 120px"
                                                   value="<?php echo $profil->getDateNaissance(); ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" name="visi_email" id="visi_email"
                                                   <?php echo $profil->getVisibiliteEmail() ? "checked" : ""; ?> />
                                        </td>
                                        <td>
                                            <label for="email">Email&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                        </td>
                                        <td>
                                            <input type="email" name="email" id="email" size="30%"
                                                   value="<?php echo $_SESSION['personneCo']->getEmail(); ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="colonne_visi">
                                            <input type="checkbox" name="visi_page" id="visi_page"
                                                   <?php echo $profil->getVisibilitePagePerso() ? "checked" : ""; ?> />
                                        </td>
                                        <td>
                                            <label for="page">Page perso&nbsp;:</label>
                                        </td>
                                        <td>
                                            <input type="url" name="page" id="page" size="30%"
                                                   value="<?php echo $profil->getPagePerso(); ?>" />
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </div>

                        <div class="contenu_onglet" id="contenu_onglet_diplomes">
                            <input type="hidden" name="nbDiplomes" id="nbDiplomes"
                                   value="<?php echo count($profil->getDiplomes()); ?>" />

                            <?php
                                // Génération et affichage des formulaires des diplômes
                                require_once 'fonctions/generationFormulaireDiplomes.php';
                            ?>

                            <p align="center">
                                <a href="#">Ajouter un autre diplôme</a>
                            </p>
                        </div>

                        <div class="contenu_onglet" id="contenu_onglet_exppros">
                            <input type="hidden" name="nbExpPros" id="nbExpPros"
                                   value="<?php echo count($profil->getExpPros()); ?>" />

                            <?php
                                // Génération et affichage des formulaires des expériences professionnelles
                                require_once 'fonctions/generationFormulaireExpPros.php';
                            ?>

                            <p align="center">
                                <a href="#">Ajouter une autre expérience professionnelle</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script type="text/javascript" charset="utf-8">
            //<![CDATA[
            // Onglet activé par défaut
            var anc_onglet = 'infos';
            change_onglet(anc_onglet);
            //]]>
        </script>
    </body>
</html>
