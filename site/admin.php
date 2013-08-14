<?php
    /**
     * Page d'aministration
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
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />
        <link rel="stylesheet" href="css/onglet.css" />
        <link rel="stylesheet" href="css/recherche.css" />

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
                    <h3>
                        Administration
                    </h3>

                </center>

                <div id="onglets">
                    <div class="systeme_onglets">
                        <span class="onglet_0 onglet" id="onglet_validation_comptes" onclick="javascript:change_onglet('validation_comptes');">Validation des comptes</span>
                        <span class="onglet_0 onglet" id="onglet_validation_master" onclick="javascript:change_onglet('validation_master');">Validation Master</span>
                        <span class="onglet_0 onglet" id="onglet_gestion" onclick="javascript:change_onglet('gestion');">Gestion comptes</span>
                    </div>

                    <div class="contenu_onglet" id="contenu_onglet_validation_comptes">
                        <fieldset>
                            <legend>Liste de tous les comptes non validés</legend>

                            <table class="resultat sortable" cellpadding="10px">
                                <thead align="center">
                                    <tr>
                                        <th>
                                            Nom Prénom
                                        </th>
                                        <th>
                                            Type d'utilisateur
                                        </th>
                                        <th>
                                            Tout sélectionner
                                            <input type="checkbox" id="all" name="all"
                                                   onclick="tout_selectionner();"/>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody align="center">
                                    <?php
                                        // Récupération connexion BD
                                        $bdd = ConnexionBD::getInstance()->getBDD();

                                        // Création de la requête
                                        $requete = 'SELECT codePe, nom, prenom, type
                                            FROM Personne
                                            WHERE compteValide = 0';

                                        // Éxécution de la requête
                                        $req = $bdd->query($requete);

                                        // Extraction des résultats
                                        $resultats = $req->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($resultats as $compteEnCours) {
                                    ?>
                                    <tr>
                                        <td>
                                            <label for="<?php echo $compteEnCours['codePe']; ?>"><?php echo $compteEnCours['nom'] . " " . $compteEnCours['prenom']; ?></label>
                                        </td>
                                        <td>
                                            <label for="<?php echo $compteEnCours['codePe']; ?>"><?php echo $compteEnCours['type']; ?></label>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="checkbox"
                                                   id="<?php echo $compteEnCours['codePe']; ?>"
                                                   name="<?php echo $compteEnCours['codePe']; ?>" />
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </fieldset>
                    </div>

                    <div class="contenu_onglet" id="contenu_onglet_validation_master">
                        <p>
                            Onglet 2
                        </p>
                    </div>

                    <div class="contenu_onglet" id="contenu_onglet_gestion">
                        <p>
                            Onglet 3
                        </p>
                    </div>
                </div>
            </div>

            <style type="text/css">
                table.sortable tbody tr:nth-child(2n) td {
                    background: #C4D4ED;
                }

                table.sortable tbody tr:nth-child(2n+1) td {
                    background: #8AAAD9;
                }
            </style>

            <script type="text/javascript" charset="utf-8">
                //<![CDATA[
                // Système de changement d'onglet
                function change_onglet(name) {
                    document.getElementById('onglet_' + anc_onglet).className = 'onglet_0 onglet';
                    document.getElementById('onglet_' + name).className = 'onglet_1 onglet';
                    document.getElementById('contenu_onglet_' + anc_onglet).style.display = 'none';
                    document.getElementById('contenu_onglet_' + name).style.display = 'block';

                    anc_onglet = name;
                }

                // Onglet activé par défaut
                var anc_onglet = 'validation_comptes';
                change_onglet(anc_onglet);
                //]]>
            </script>

            <script type="text/javascript" charset="utf-8">
                //<![CDATA[
                // Tout sélectionner
                function tout_selectionner() {
                    if (document.getElementById('all').checked) {
                        forEach(document.getElementsByClassName('checkbox'), function(checkbox) {
                            checkbox.checked = true;
                        });
                    } else {
                        forEach(document.getElementsByClassName('checkbox'), function(checkbox) {
                            checkbox.checked = false;
                        });
                    }
                }
                //]]>
            </script>
        </div>
    </body>
</html>
