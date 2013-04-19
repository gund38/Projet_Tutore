<?php

    // Chargement des fichiers de classes et de fonctions
    function chargerClasse($classe) {
        require_once 'classes/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions/fonctions.php';

    // Démarrage de la session
    session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
    <head>
        <title>Site des ancien étudiants</title>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
        <?php
            // Non disponible dans cette version (manque un plugin)
            //override_function('print', '$text', 'print(utf8_encode($text));');

            $bdd = ConnexionBD::getInstance()->getBDD();
            echo "BD OK<br/>\n";

            $profilManager = new ProfilManager($bdd);
            echo "ProfilManager OK<br/>\n";

            $listeProfils = $profilManager->getList();
            echo "getList() OK<br/>\n";

            print_r($listeProfils);
            echo "<br/>\n";

            $profil =$profilManager->getProfil(4);

            print_r($profil);
            echo "<br/>\n";
        ?>
    </body>
</html>
