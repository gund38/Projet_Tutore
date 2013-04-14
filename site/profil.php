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
        <link rel="stylesheet" href="css/onglet.css" /> <!-- CSS pour le système d'onglet -->
        <title>Site Web des Anciens Étudiants du Master TI</title>
        <script type="text/javascript">
            //<!--
            function change_onglet(name)
            {
            document.getElementById('onglet_'+anc_onglet).className = 'onglet_0 onglet';
            document.getElementById('onglet_'+name).className = 'onglet_1 onglet';
            document.getElementById('contenu_onglet_'+anc_onglet).style.display = 'none';
            document.getElementById('contenu_onglet_'+name).style.display = 'block';
            anc_onglet = name;
            }
            //-->
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
                <div id="profil_photo">
                    <IMG SRC="images/photo_profil.png" ALT="Photo du Profil" TITLE="Photo du Profil" width="200px">
                </div>
                <div id="profil_description">
                    <h4>Ramoloss</h4>
                    <p>
                        Très lent et endormi, il lui faut 5 secondes pour ressentir la douleur d'une attaque.
                        Lent et stupide, il aime se la couler douce en observant l'activité autour de lui.
                        Un Pokémon crétin constamment dans la lune qui aime pêcher avec sa queue. Endormi ou éveillé, il 						n'y a aucune différence.
                        Il est tellement paresseux, qu'il lui faut une journée pour remarquer qu'on lui mord la queue.
                        Une sève sucrée coule du bout de sa queue. Peu nutritive, elle reste agréable a mâchouiller.
                        Il est tellement paresseux qu'il lui faut une journée pour remarquer qu'on lui mord la queue.
                    </p>
                </div>
                <div id="profil_bouton">
                    <table>
                        <tr><td> <a href="#">Sauvegarder</a> </td><td>
                        <tr><td> <a href="#">Voir mon profil public</a> </td><td>
                        <tr><td> <a href="#">Réinitialiser mon profil</a> </td><td>
                    </table>
                </div>
                <div id="profil_general">
                    <div class="systeme_onglets">

                        <span class="onglet_0 onglet" id="onglet_info" onclick="javascript:change_onglet('info');">Informations personnelles</span>
                        <span class="onglet_0 onglet" id="onglet_diplome" onclick="javascript:change_onglet('diplome');">Parcours scolaires</span>
                        <span class="onglet_0 onglet" id="onglet_prof" onclick="javascript:change_onglet('prof');">Vie active</span>
                    </div>

                    <div class="contenu_onglet" id="contenu_onglet_info">
                        <p>BRA BRA BRA.</p>
                    </div>

                    <div class="contenu_onglet" id="contenu_onglet_diplome">
                        <p>BRA BRA BRA.</p>
                    </div>

                    <div class="contenu_onglet" id="contenu_onglet_prof">
                        <p>BRA BRA BRA.</p>
                        <HR width=1 size=500 style="background-color:black;">
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            //<!--
            var anc_onglet = 'info';
            change_onglet(anc_onglet);
            //-->
        </script>
    </body>
</html>
