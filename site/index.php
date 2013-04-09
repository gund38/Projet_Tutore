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
                require_once 'class/' . $classe . '.php';
            }

            spl_autoload_register('chargerClasse');
            require_once 'fonctions.php';

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

        <form action="ajouterOffre.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <label for="intitule">Intitulé : </label>
                        <input type="text" name="intitule" id="intitule" />
                    </td>
                    <td>
                        <label for="entreprise">Entreprise / Organisation : </label>
                        <input type="text" name="entreprise" id="entreprise" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="ville">Ville : </label>
                        <input type="text" name="ville" id="ville" />
                    </td>
                    <td>
                        <label for="departement">Département : </label>
                        <select name="departement" id="departement">
                            <?php
                                $listeDep = listeDepartement();
                                $first = true;

                                foreach ($listeDep as $value) {
                                    if ($first) {
                                        $first = false;
                                        echo "\t";
                                    } else {
                                        echo "\t\t\t\t";
                                    }

                                    echo "<option value=\"" . $value['codeDe']
                                    . "\">" . $value['nom']
                                    . "</option>\n";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="remuneration">Rémunération : </label>
                        <input type="text" name="remuneration" id="remuneration" />
                        <select name="periodicite" id="pericodicite">
                            <option value="mois">€ / mois</option>
                            <option value="annee">€ / an</option>
                        </select>
                    </td>
                    <td>
                        <label for="type">Type : </label>
                        <select name="type" id="type">
                            <?php
                                $listeType = listeType();
                                $bool = true;

                                foreach ($listeType as $value) {
                                    if ($bool) {
                                        $bool = false;
                                        echo "\t";
                                    } else {
                                        echo "\t\t\t\t";
                                    }

                                    echo "<option value=\"" . $value
                                    . "\">" . $value
                                    . "</option>\n";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br />
                        <label for="fichier">Sélectionner le fichier pdf à uploader (max : 2Mo) : </label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="2097150" />
                        <input type="file" name="fichier" id="fichier" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Envoyer" />
                        <label id="erreur" style="color: red">
                            <?php
                                echo isset($_SESSION['erreurs']) ? $_SESSION['erreurs'] : "";
                                unset($_SESSION['erreurs'])
                            ?>
                        </label>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
