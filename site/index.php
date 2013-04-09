<?php
    session_start();

    function chargerClasse($classe) {
        require_once 'class/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions.php';
?>
<!DOCTYPE html>
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

            $manager = new PersonneManager($bdd);

            $personnes = $manager->getList();

            $taille = count($personnes);

            echo "<p>\n";
            for ($i = 0; $i < $taille; $i++) {
                echo "\t\t";
                $personnes[$i]->afficher();
                echo "<br />\n";
            }
            echo "\t</p>\n";

            listeType();
        ?>

        <form action="connexion.php" method="post">
            <p>
                <label for="login">Login : </label><input type="text" name="login" id="login" /><br />
                <label for="mdp">Mot de passe : </label> <input type="password" name="mdp" id="mdp" /><br />

                <input type="submit" value="Envoyer" />
            </p>
        </form>

        <br />
    </body>
</html>
