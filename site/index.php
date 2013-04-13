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
                <p>Index.</p>
                <form action="connexion.php" method="post">
                    <p>
                        <label for="login">Login : </label><input type="text" name="login" id="login" /><br />
                        <label for="mdp">Mot de passe : </label> <input type="password" name="mdp" id="mdp" /><br />

                        <input type="submit" value="Envoyer" />
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>
