<?php

    // Chargement des fichiers de classes et de fonctions
    function chargerClasse($classe) {
        require_once 'class/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions.php';

    // Démarrage de la session
    session_start();

    if (!verifierAcces(__FILE__)) {
        header("Location: index.php");
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />
        <title>Site Web des Anciens Étudiants du Master TI</title>
    </head>

    <body>
        <div id="global">
            <div id="entete">
                <h1>Site Web des Anciens Étudiants du Master TI</h1>
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
                <p>Consulter les offres.</p>
                <?php
                    $bdd = ConnexionBD::getInstance()->getBDD();

                    $managerOffre = new OffreManager($bdd);
                    $offres = $managerOffre->getList();
                    $taille = count($offres);

                    echo "<p>\n";
                    for ($i = 0; $i < $taille; $i++) {
                        echo "\t\t";
                        $offres[$i]->afficher();
                        echo "<br />\n";
                    }
                    echo "\t</p>\n";
                ?>
            </div>
        </div>
    </body>
</html>
