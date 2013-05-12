<?php
    /**
     * Page d'accueil du site
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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8" />

        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />

        <title>Site Web des Anciens Étudiants du Master TI</title>

        <style type="text/css">
            h2 {
                font-size: 3em;
            }
            p, .objectifs li {
                font-size: 1.2em;
            }
        </style>
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
                <table cellpadding="20px">
                    <tr>
                        <td>
                            <h2>Bienvenue sur le site des Anciens Étudiants<br /> du Master TI (Technologie de l'Internet) de Pau !</h2>
                        </td>
                        <td>
                            <img src="images/logo_uppa.jpg" alt="Logo UPPA" width="253" height="234" />
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                Ce site a plusieurs objectifs :
                            </p>
                            <ul class="objectifs">
                                <li>
                                    La création d'un annuaire des Anciens Étudiants du Master TI de Pau
                                </li>
                                <li>
                                    La centralisation des offres d'emploi et de stage qui sont envoyés au département informatique
                                </li>
                                <li>
                                    La récupération et le recoupement d'informations sur les Anciens Étudiants afin de générer des statistiques anonymes à destination de l'équipe enseignante
                                </li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
