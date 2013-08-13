<?php
    /**
     * Page d'accueil du site
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    // Inclusion et appel de la fonction d'en-tête
    require_once 'fonctions/header.php';
    enTete(false);
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

            #dernieres_offres {
                border-collapse: collapse;
            }

            #dernieres_offres th {
                padding-top: 5px;
                padding-bottom: 10px;
            }

            #dernieres_offres tbody td {
                border: 1px solid black;
                padding-top: 5px;
                padding-bottom: 5px;
                vertical-align: middle;
            }

            #dernieres_offres tfoot td {
                padding-top: 15px;
            }

            #dernieres_offres a {
                color: mediumblue;
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
                            <h2>Bienvenue sur le site des Anciens Étudiants du Master TI (Technologie de l'Internet) de Pau !</h2>
                        </td>
                        <td>
                            <img src="images/logo_uppa.jpg" alt="Logo UPPA" width="253" height="234" />
                        </td>
                        <td rowspan="2">
                            <table id="dernieres_offres">
                                <thead>
                                    <tr>
                                        <th colspan="3">
                                            <h4>
                                                Les 5 dernières offres d'emploi<?php echo isset($_SESSION['personneCo']) ? "&nbsp;/&nbsp;stage" : ""; ?> ajoutées&nbsp;:
                                            </h4>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Date de dépôt</th>
                                        <th>Type</th>
                                        <th>Intitulé du poste</th>
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    <?php
                                        // Récupération connexion BD
                                        $bdd = ConnexionBD::getInstance()->getBDD();

                                        // Création de la requête
                                        $requete = 'SELECT DATE_FORMAT(o.dateDepot, \'%d/%m/%Y\') AS dateDepot,
                                            o.type, o.intitule
                                            FROM Offre AS o';

                                        $requete .= isset($_SESSION['personneCo']) ? "" : " WHERE o.type = \"Emploi\"";

                                        $requete .= ' ORDER BY o.dateDepot DESC LIMIT 5';

                                        // Préparation de la requête
                                        $req = $bdd->prepare($requete);

                                        // Si la préparation a échoué
                                        if (!$req) {
                                            echo "La requête n'a pas fonctionné (préparation), veuillez réessayer.<br />\n";
                                            exit;
                                        }

                                        // Exécution de la requête
                                        $req->execute();

                                        // Si la requête a échoué
                                        if (!$req) {
                                            echo "La requête n'a pas fonctionné (exécution), veuillez réessayer.<br />\n";
                                            exit;
                                        }

                                        $resultats = $req->fetchAll(PDO::FETCH_ASSOC);

                                        //print_r($resultats);

                                        foreach ($resultats as $offreEnCours) {
                                    ?>
                                    <tr>
                                        <td><?php echo $offreEnCours['dateDepot']; ?></td>
                                        <td><?php echo $offreEnCours['type']; ?></td>
                                        <td><?php echo $offreEnCours['intitule']; ?></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                                <tfoot align="center">
                                    <tr>
                                        <td colspan="3">
                                            <a href="#" onclick="document.forms.voir_plus.submit();">En voir plus...</a>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <form action="fonctions/rechercherOffres.php" method="post" name="voir_plus">
                                <?php
                                    if (!isset($_SESSION['personneCo'])) {
                                ?>
                                <input type="hidden" name="type" id="type" value="Emploi" />
                                <?php
                                    }
                                ?>
                            </form>
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
