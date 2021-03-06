<?php
    /**
     * Page d'affichage des offres d'emploi et de stage
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
        <link rel="stylesheet" href="css/recherche.css" />

        <!-- Script pour le tri du tableau -->
        <script src="js/sorttable.js" type="text/javascript" charset="utf-8"></script>

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
                <center>
                    <h3>Offres d'emploi<?php echo isset($_SESSION['personneCo']) ? " et de stage" : ""; ?></h3>

                    <p>
                        Ici vous pouvez rechercher une offre d'emploi<?php echo isset($_SESSION['personneCo']) ? " ou de stage" : ""; ?> suivant différents critères.<br />
                        Vous pouvez cliquer sur les colonnes pour les trier dans l'ordre alphanumérique croissant ou décroissant.
                    </p>

                    <p class="erreur">
                        <?php
                            // Gestion des erreurs au niveau de la recherche d'offres
                            if (isset($_SESSION['erreurs_recherche_offres'])) {
                                echo "Erreur :<br />\n{$_SESSION['erreurs_recherche_offres']}";
                                unset($_SESSION['erreurs_recherche_offres']);
                            } else {
                                echo "\n";
                            }
                        ?>
                    </p>

                    <br /><br />

                    <form action="fonctions/rechercherOffres.php" method="post">
                        <table cellpadding="10px">
                            <tr>
                                <th>
                                    <label for="intitule">Intitulé&nbsp;:</label>
                                </th>
                                <td>
                                    <input type="text" name="intitule" id="intitule" />
                                </td>
                                <th>
                                    <label for="type">Type&nbsp;:</label>
                                </th>
                                <td>
                                    <select name="type" id="type">
                                        <option value="all"<?php echo isset($_SESSION['personneCo']) ? "" : " disabled"; ?>>Emploi + Stage</option>
                                        <?php
                                            // Récupération de la liste des types d'offre
                                            $listeTypes = listeTypesOffre();

                                            foreach ($listeTypes as $value) {
                                                echo "<option value=\"$value\"";
                                                echo (strcmp($value, "Stage") === 0 && !isset($_SESSION['personneCo'])) ? " disabled" : "";
                                                echo ">$value</option>\n";
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="ville">Ville&nbsp;:</label>
                                </th>
                                <td>
                                    <input type="text" name="ville" id="ville" />
                                </td>
                                <th>
                                    <label for="departement">Département&nbsp;:</label>
                                </th>
                                <td>
                                    <select name="departement" id="departement">
                                        <option value="all">Tous les départements</option>
                                        <?php
                                            // Récupération de la liste des départements
                                            $listeDep = listeDepartements();

                                            foreach ($listeDep as $value) {
                                                echo "<option value=\"{$value['codeDe']}\">{$value['nom']}</option>\n";
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">
                                    <input type="submit" value="Rechercher" />
                                </td>
                            </tr>
                        </table>
                    </form>

                    <br /><br /><br />

                    <?php
                        if (isset($_SESSION['recherche_offres'])) {
                            if (count($_SESSION['recherche_offres']) > 0) {
                    ?>
                                <fieldset class="resultat_offres">
                                    <legend>Résultats de votre recherche</legend>

                                    <table class="resultat sortable" cellpadding="10px">
                                        <thead>
                                            <tr>
                                                <th>Date de dépôt</th>
                                                <th>Type</th>
                                                <th>Intitulé du poste</th>
                                                <th>Entreprise / organisation</th>
                                                <th>Ville</th>
                                                <th>Département</th>
                                                <th>Rémunération (€&nbsp;/&nbsp;mois)</th>
                                                <th class="sorttable_nosort">Télécharger l'offre en PDF</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                                foreach ($_SESSION['recherche_offres'] as $offreEnCours) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $offreEnCours['dateDepot']; ?></td>
                                                        <td><?php echo $offreEnCours['type']; ?></td>
                                                        <td><?php echo $offreEnCours['intitule']; ?></td>
                                                        <td><?php echo $offreEnCours['entreprise']; ?></td>
                                                        <td><?php echo $offreEnCours['ville']; ?></td>
                                                        <td><?php echo "{$offreEnCours['codePostal']} - {$offreEnCours['nom']}"; ?></td>
                                                        <td><?php echo $offreEnCours['remuneration']; ?></td>
                                                        <td>
                                                            <a href="pdf/<?php echo $offreEnCours['cheminPDF']; ?>"
                                                               target="_blank"
                                                               type="application/pdf"
                                                               download="<?php echo $offreEnCours['type'] . " - " . $offreEnCours['intitule']; ?>">
                                                                <img src="images/icone-pdf.gif" alt="Icône PDF" />
                                                            </a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </fieldset>
                    <?php
                            } else {
                    ?>
                                <h4>Votre recherche n'a pas donné de résultats</h4>
                    <?php
                            }
                            unset($_SESSION['recherche_offres']);
                        }
                    ?>
                </center>
            </div>
        </div>

        <style type="text/css">
            table.sortable tbody tr:nth-child(2n+1) td {
                background: #8AAAD9;
            }
        </style>
    </body>
</html>
