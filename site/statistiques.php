<?php
    /**
     * Page d'affichage des statistiques
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

    // On vérifie si l'on a le droit d'accéder à cette page
    if (!verifierAcces(__FILE__)) {
        $_SESSION['erreur_droits'] = true;
        header("Location: login.php");
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8" />

        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />

        <script src="js/amcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/script_statistiques.js"></script>

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
            afficherMenu();
        ?>

        <div id="contenu">
            <center>
            <h3>Statistiques</h3>
            <br />

            <table>
                <tr>
                    <th>Types de statistique</th>
                    <th colspan="3">Plage de promos</th>
                    <th>Type de graphe</th>
                </tr>
                <tr>
                    <td>
                        <select name="type" id="type">
                            <option value="">Répartition des salaires</option>
                            <option value="">Pourcentage de diplômés</option>
                            <option value="">Répartition géographique</option>
                            <option value="">Pourcentage ayant un travail</option>
                            <option value="">Répartition du niveau d'études final</option>
                        </select>
                    </td>
                    <td>
                        <select name="type" id="type">
                            <option value="">2012</option>
                            <option value="">2011</option>
                            <option value="">2010</option>
                            <option value="">2009</option>
                            <option value="">2008</option>
                            <option value="">2007</option>
                        </select>
                    </td>
                    <td>
                        <select name="type" id="type">
                            <option value="">2012</option>
                            <option value="">2011</option>
                            <option value="">2010</option>
                            <option value="">2009</option>
                            <option value="">2008</option>
                            <option value="">2007</option>
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" name="visi_dip" id="" />
                        <label for="enCours_exp">Toutes les promos</label>
                    </td>
                    <td>
                        <select name="type" id="type">
                            <option value="">Camembert</option>
                            <option value="">Histogramme</option>
                            <option value="">Carte</option>
                        </select>
                    </td>
                    <td>
                        <input type="submit" value="Générer" />
                    </td>
                </tr>
            </table>
            <br /><br />

            <style type="text/css">
                fieldset {
                    border: solid 1px #222;
                }

                fieldset legend {
                    padding: 0 10px;
                    border-left: #222 1px solid;
                    border-right: #222 1px solid;
                    font-size: 1.2em;
                    color: #222;
                }
            </style>

            <fieldset style="width: 700px; height: 450px;">
                <legend>Résultat</legend>


                <div id="camembert" align="center" style="width: 640px; height: 400px;"></div>


                <input align="center" type="submit" value="Télécharger au format JPG" />
            </fieldset>
            </center>
        </div>
    </body>
</html>
