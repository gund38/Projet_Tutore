<?php
    session_start();

    function chargerClasse($classe) {
        require_once 'class/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />
        <title>Site Web des Anciens Étudiants du Master TI</title>
    </head>

        <div id="global">
            <div id="entete">
                <h1>Site Web des Anciens Étudiants du Master TI</h1>
            </div>
            <div id="navigation">
                <h1>MENU</h1>
                <hr/>
                <ul id="sous_menu">
                    <li>
                        <a href="index.html">Accueil</a>
                    </li>
                    <li>
                        <a href="profil.html">Mon Profil</a>
                    </li>
                    <li>
                        <a href="recherche_profil.html">Rechercher un profil</a>
                    </li>
                    <li>
                        <a href="offres.html">Offres Emplois/Stage</a>
                    </li>
                    <li>
                        <a href="ajouter_offre.php">Ajouter une offre</a>
                    </li>
                    <li>
                        <a href="statistiques.html">Statistiques</a>
                    </li>
                </ul>
            </div>
            <div id="contenu">
                <p>Ajouter une offre.</p>

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
                                    ?>l
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
            </div>
        </div>
    </body>
</html>
