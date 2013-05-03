<?php
    /**
     * Page de connexion
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
                <p>Se connecter au site</p>
                <label id="erreur">
                    <?php
                        // Gestion des erreurs au niveau des droits d'accès aux pages
                        if (isset($_SESSION['erreur_droits'])) {
                            if (isset($_SESSION['personneCo'])) {
                                echo "Vous n'avez pas le droit d'accéder à cette page !";
                            } else {
                                echo "Vous devez vous connecter pour accéder à cette page";
                            }
                            echo "<br /><br />\n";
                            unset($_SESSION['erreur_droits']);
                        } else {
                            echo "\n";
                        }
                    ?>
                </label>
                <form action="fonctions/connexion.php" method="post">
                    <table>
                        <tr>
                            <td>
                                <label for="login">Login&nbsp;:</label>
                            </td>
                            <td>
                                <input type="text" name="login" id="login" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="mdp">Mot de passe&nbsp;:</label>
                            </td>
                            <td>
                                <input type="password" name="mdp" id="mdp" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" value="Envoyer" />
                            </td>
                        </tr>
                    </table>
                </form>
                <br />
                <label id="erreur">
                    <?php
                        // Gestion des erreurs au niveau de la connexion
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
            </div>
        </div>
    </body>
</html>
