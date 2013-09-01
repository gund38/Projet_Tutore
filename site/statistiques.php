<?php
    /**
     * Page d'affichage des statistiques
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    // Inclusion et appel de la fonction d'en-tête
    require_once 'fonctions/header.php';
    enTete(true);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8" />

        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />

        <!-- Scripts pour les statistiques -->
        <script src="js/amcharts.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/script_statistiques.js" type="text/javascript" charset="utf-8"></script>

        <!-- Scripts pour l'export -->
        <script src="js/canvg.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/rgbcolor.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/exportPNG.js" type="text/javascript" charset="utf-8"></script>

        <script type="text/javascript" charset="utf-8">
            function checkboxAll() {
                if (document.getElementById('promo_all').checked) {
                    document.getElementById('promo_deb').disabled = 'disabled';
                    document.getElementById('promo_fin').disabled = 'disabled';
                } else {
                    document.getElementById('promo_deb').disabled = '';
                    document.getElementById('promo_fin').disabled = '';
                }
            }
        </script>

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

                <br /><br />

                <form action="fonctions/generer_stats.php" method="post">
                    <table cellpadding="10px">
                        <tr>
                            <th>
                                <label for="type_stat">Type de statistique&nbsp;:</label>
                            </th>
                            <th>
                                <label for="promo_deb">Plage de promos&nbsp;:</label>
                            </th>
                            <th>
                                <label for="type_graphe">Type de graphe&nbsp;:</label>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <select name="type_stat" id="type_stat">
                                    <option value="rep_salaires">Répartition des salaires</option>
                                    <option value="rep_geo" selected>Répartition géographique</option>
                                    <option value="pour_travail">Pourcentage ayant un travail</option>
                                    <option value="pour_diplomes">Pourcentage de diplômés</option>
                                    <option value="rep_etudes">Répartition du niveau d'études final</option>
                                    <?php // @TODO Stat supplémentaire : provenance des offres (admin, enseignant, ancien étudiant) ?>
                                </select>
                            </td>
                            <td>
                                <select name="promo_deb" id="promo_deb">
                                    <?php
                                        $promos = minMaxPromos();

                                        for ($i = $promos['min']; $i <= $promos['max']; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>

                                <select name="promo_fin" id="promo_fin">
                                    <?php
                                        for ($i = $promos['min']; $i <= $promos['max']; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>

                                <input type="checkbox" name="promo_all" id="promo_all" onclick="checkboxAll();"/>

                                <label for="promo_all">Toutes les promos</label>
                            </td>
                            <td>
                                <select name="type_graphe" id="type_graphe">
                                    <option value="Camembert">Camembert</option>
                                    <option value="Histogramme">Histogramme</option>
                                </select>
                            </td>
                            <td>
                                <input type="submit" value="Générer" />
                            </td>
                        </tr>
                    </table>
                </form>

                <br /><br /><br />

                <?php
                    if (isset($_POST['type_stat'])) {
                ?>
                        <fieldset>
                            <legend>Résultat</legend>

                            <div id="camembert" style="width: 940px; height: 400px;"></div>

                            <input type="submit" value="Télécharger au format PNG"
                                   id ="bouton_submit"
                                   onclick="exportDat('camembert');" />
                            <div id='output'></div>
                        </fieldset>
                 <?php
                        unset($_POST['type_stat']);
                    }
                ?>
            </center>
        </div>
    </body>
</html>
