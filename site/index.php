<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Site des ancien étudiants</title>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <?php

            function chargerClasse($classe) {
                require 'class/' . $classe . '.php';
            }

            spl_autoload_register('chargerClasse');
            include_once 'fonctions.php';

            // Non disponible dans cette version (manque un plugin)
            //override_function('print', '$text', 'print(utf8_encode($text));');

            $bdd = ConnexionBD::getInstance()->getBDD();

//            $_SESSION['bdd'] = $bdd;
            $manager = new PersonneManager($bdd);

            $personnes = $manager->getList();

            $taille = count($personnes);

            for ($i = 0; $i < $taille; $i++) {
                $personnes[$i]->afficher();
                echo "<br />";
            }
        ?>

        <form action="connexion.php" method="post">
            <p>
                <label for="login">Login</label> : <input type="text" name="login" id="login" /><br />
                <label for="mdp">Mot de passe</label> :  <input type="password" name="mdp" id="mdp" /><br />

                <input type="submit" value="Envoyer" />
            </p>
        </form>
    </body>
</html>
