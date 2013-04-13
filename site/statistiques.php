<?php

    // Chargement des fichiers de classes et de fonctions
    function chargerClasse($classe) {
        require_once 'class/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions.php';

    // Démarrage de la session
    session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />
        <script src="js/amcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="script_statistiques.js"></script>
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
            if (isset($_SESSION['personneCo'])) {
                require_once 'fonction_menu.php';
            } else {
                require_once 'menu_V.php';
            }
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
