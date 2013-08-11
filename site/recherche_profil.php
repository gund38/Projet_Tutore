<?php
    /**
     * Page pour la recherche d'un profil
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
                    <h3>Recherche de profil</h3>

                    <p>
                        Ici vous pouvez rechercher vos collègues ou vos aînés par leur nom et/ou leur année de promotion.<br />
                        Une fois la recherche effectuée, il vous suffit de cliquer sur le nom d'une personne pour consulter son profil public.
                    </p>

                    <br /><br/>

                    <form action="fonctions/rechercherProfil.php" method="post">
                        <table cellpadding="10px">
                            <tr>
                                <th>
                                    <label for="nomPrenom">Nom et/ou prénom&nbsp;:</label>
                                </th>
                                <th>
                                    <label for="promo">Promotion&nbsp;:</label>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="nomPrenom" id="nomPrenom" placeholder="Marco Polo">
                                </td>
                                <td>
                                    <select name="promo" id="promo">
                                        <option value="all">Toutes les promotions</option>
                                        <option value="2014">2014</option>
                                        <option value="2013">2013</option>
                                        <option value="2012">2012</option>
                                        <option value="2011">2011</option>
                                        <option value="2010">2010</option>
                                        <option value="2009">2009</option>
                                        <option value="2008">2008</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="submit" value="Rechercher">
                                </td>
                            </tr>
                        </table>
                    </form>

                    <br /><br /><br />

                    <?php
                        if (isset($_SESSION['recherche_profil'])) {
                            if (count($_SESSION['recherche_profil']) > 0) {
                    ?>
                                <fieldset class="resultat_profil">
                                    <legend>Résultats de votre recherche</legend>

                                    <table class="resultat sortable" cellpadding="10px">
                                        <thead>
                                            <tr>
                                                <th>Prénom & Nom</th>
                                                <th>Promotion</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                                foreach ($_SESSION['recherche_profil'] as $profilEnCours) {
                                            ?>
                                                    <tr>
                                                        <td class="nom">
                                                            <a href="profil_public-<?php echo $profilEnCours['codePe']; ?>.php">
                                                                <?php echo "{$profilEnCours['prenom']} {$profilEnCours['nom']}"; ?>
                                                            </a>
                                                        </td>
                                                        <td class="promo"><?php echo $profilEnCours['promo']; ?></td>
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
                            unset($_SESSION['recherche_profil']);
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
