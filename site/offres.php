<?php
    /**
     * Page d'affichage des offres d'emploi et de stage
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
                <h3 align="center">Offres d'emploi<?php echo isset($_SESSION['personneCo']) ? " et de stage" : "" ?></h3>

                <p align="center">Ici vous pouvez rechercher une offre d'emploi ou de stage suivant différents critères.</p>

                <br /><br />

                <table align="center">
                    <tr>
                        <th>
                            <label for="intitule">Intitulé&nbsp;:</label>
                        </th>
                        <th>
                            <label for="type">Type&nbsp;:</label>
                        </th>
                        <th>
                            <label for="ville">Ville&nbsp;:</label>
                        </th>
                        <th>
                            <label for="departement">Département&nbsp;:</label>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="intitule" id="intitule" />
                        </td>
                        <td>
                            <select name="type" id="type">
                                <?php
                                    // Récupération de la liste des types d'offre
                                    $listeTypes = listeTypesOffre();

                                    foreach ($listeTypes as $value) {
                                        echo "<option value=\"" . $value
                                        . "\">" . $value
                                        . "</option>\n";
                                    }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="ville" id="ville" />
                        </td>
                        <td>
                            <select name="departement" id="departement">
                                <?php
                                    // Récupération de la liste des départements
                                    $listeDep = listeDepartements();

                                    foreach ($listeDep as $value) {
                                        echo "<option value=\"" . $value['codeDe']
                                        . "\">" . $value['nom']
                                        . "</option>\n";
                                    }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="submit" value="Rechercher" />
                        </td>
                    </tr>
                </table>

                <br /><br /><br /><br />

                <style type="text/css">
                    #recherche td, #recherche th {
                        border: 1px solid #000;
                    }
                </style>

                <fieldset>
                    <legend>Résultat de votre recherche</legend>

                    <table id="recherche" align="center" cellpadding="10px"
                           style="text-align: center; border: 1px solid #000; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>Date de dépôt</th>
                                <th>Type</th>
                                <th>Intitulé du poste</th>
                                <th>Entreprise / organisation</th>
                                <th>Ville</th>
                                <th>Département</th>
                                <th>Rémunération (€ / mois)</th>
                                <th>Télécharger l'offre en PDF</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $bdd = ConnexionBD::getInstance()->getBDD();

                                $managerOffre = new OffreManager($bdd);
                                $offres = $managerOffre->getList();

                                $impair = true;

                                foreach ($offres as $offreEnCours) {
                                    ?>
                                    <tr<?php echo $impair ? ' class="impair"' : ""; $impair = !$impair; ?>>
                                        <td><?php echo $offreEnCours->getDateDepot(); ?></td>
                                        <td><?php echo $offreEnCours->getType(); ?></td>
                                        <td><?php echo $offreEnCours->getIntitule() ?></td>
                                        <td><?php echo $offreEnCours->getEntreprise() ?></td>
                                        <td><?php echo $offreEnCours->getVille() ?></td>
                                        <td><?php echo $offreEnCours->getDepartement() ?></td>
                                        <td><?php echo $offreEnCours->getRemuneration() ?></td>
                                        <td>
                                            <a href="pdf/<?php echo $offreEnCours->getCheminPDF() ?>"
                                               type="application/octet-stream">
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
            </div>
        </div>
    </body>
</html>
