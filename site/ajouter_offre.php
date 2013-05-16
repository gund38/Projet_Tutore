<?php
    /**
     * Page d'ajout d'une offre d'emploi ou de stage
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
        header("Location: login.php?page=" . substr(strrchr($_SERVER['PHP_SELF'], '/'), 1));
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
                <center>
                    <h3>AJouter une offre</h3>

                    <p>Utilisez le formulaire suivant pour ajouter une offre d'emploi ou de stage.</p>

                    <br /><br />

                    <fieldset>
                        <form action="fonctions/ajouterOffre.php" method="post" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <td>
                                        <label for="intitule">Intitulé&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text" name="intitule" id="intitule" size="50%" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="entreprise">Entreprise / Organisation&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="entreprise" id="entreprise" />
                                    </td>
                                    <td>
                                        <label for="ville">Ville&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="ville" id="ville" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="departement">Département&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
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
                                        <label for="remuneration">Rémunération&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="remuneration" id="remuneration" />
                                        <select name="periodicite" id="periodicite">
                                            <option value="mois">€ / mois</option>
                                            <option value="annee">€ / an</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="type">Type&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
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
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <br />
                                        <label for="fichier">Sélectionner le fichier pdf à uploader (max&nbsp;:&nbsp;2Mo)&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="2097150" />
                                        <input type="file" name="fichier" id="fichier" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center" >
                                        <input type="submit" value="Envoyer" />
                                    </td>
                                </tr>
                            </table>
                        </form>

                        <br />

                        <p class="erreur">
                            <?php
                                // Gestion des erreurs au niveau de l'ajout d'une offre
                                if (isset($_SESSION['erreurs_ajout'])) {
                                    echo substr_count($_SESSION['erreurs_ajout'], "<br />\n") > 2 ? "Erreurs :" : "Erreur :";
                                    echo "<br />\n";
                                    echo $_SESSION['erreurs_ajout'];
                                    unset($_SESSION['erreurs_ajout']);
                                } else {
                                    echo "\n";
                                }
                            ?>
                        </p>

                        <p class="sortie">
                            <?php
                                // Gestion de la réussite de l'ajout d'une offre
                                if (isset($_SESSION['sortie_ajout'])) {
                                    echo "<br />\n";
                                    echo $_SESSION['sortie_ajout'];
                                    unset($_SESSION['sortie_ajout']);
                                } else {
                                    echo "\n";
                                }
                            ?>
                        </p>

                        <p>
                            <small>Les champs marqués par <span class="obligatoire">*</span> sont obligatoires.</small>
                        </p>
                    </fieldset>
                </center>
            </div>
        </div>
    </body>
</html>
