<?php
    /**
     * Page d'affichage des statistiques
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

        <script src="js/amcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/script_statistiques.js"></script>

        <title>Site Web des Anciens Étudiants du Master TI</title>
    </head>

    <body>
        <div id="global">
            <div id="entete">
                <h1>Site Web des Anciens Étudiants du Master TI</h1>
            </div>
        </div>

        <?php
            // Appel dynamique du menu selon l'identité de la personne
            afficherMenu();
        ?>

        <div id="contenu">
            <h2>Exemples de statistiques</h2>

            <h3>Camembert :</h3>

            <div id="camembert" style="width: 640px; height: 400px;"></div>

            <h3>Classique :</h3>

            <div id="classique" style="width: 640px; height: 400px;"></div>
        </div>
    </body>
</html>
