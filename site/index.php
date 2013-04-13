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
                afficherMenu();
            ?>
            <div id="contenu">
                <p>Index.</p>
                <form action="fonctions/connexion.php" method="post">
                    <table>
                        <tr>
                            <td>
                                <label for="login">Login : </label>
                            </td>
                            <td>
                                <input type="text" name="login" id="login" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="mdp">Mot de passe : </label>
                            </td>
                            <td>
                                <input type="password" name="mdp" id="mdp" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" value="Envoyer" />
                                <br /><br />
                                <label id="erreur">
                                    <?php
                                        if (isset($_SESSION['erreurs_connexion'])) {
                                            echo substr_count($_SESSION['erreurs_connexion'], "<br />\n") > 1 ? "Erreurs :" : "Erreur :";
                                            echo "<br />\n";
                                            echo $_SESSION['erreurs_connexion'];
                                            unset($_SESSION['erreurs_connexion']);
                                        } else {
                                            echo "\n";
                                        }
                                    ?>
                                </label>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>
