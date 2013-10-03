<?php
    /**
     * Page pour la recherche d'un profil
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    // Inclusion et appel de la fonction d'en-tête
    require_once 'fonctions/header.php';
    enTete(true);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <!-- Bootstrap core CSS -->
        <link href="dist/css/bootstrap.css" type="text/css" rel="stylesheet" />

        <!-- Bootstrap theme -->
        <link href="dist/css/bootstrap-theme.min.css" type="text/css" rel="stylesheet" />

        <!-- Font Awesome CSS -->
        <link href="font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

        <title>Site Web des Anciens Étudiants du Master TI</title>

        <style type="text/css">
            body {
                padding-top: 70px;
                padding-bottom: 30px;
            }

            table {
                width: 75%;
                margin: 0 auto;
            }

            table.resultat_profil {
                width: 50%;
            }

            td {
                padding: 10px;
            }

            th label {
                width: 100%;
                text-align: right;
            }

            .jumbotron {
                margin-bottom: 0px;
            }

            .pagination {
                display: table;
                margin: 20px auto;
            }
        </style>
    </head>

    <body>
        <?php
            // Affichage menu
            $page = "Recherche_profil";
            require_once 'menus/menuBootstrap.php';

            // Active la recherche si les paramètres sont présents
            require_once 'fonctions/rechercherProfilBootstrap.php';
            if (isset($_GET['nomPrenom'], $_GET['promo'])) {
                rechercherProfilBootstrap();
            }
        ?>

        <div class="container" role="main">
            <div class="jumbotron">
                <h1>Recherche de profil</h1>

                <p>
                    Ici vous pouvez rechercher vos collègues ou vos aînés par leur nom et/ou leur année de promotion.<br />
                    Une fois la recherche effectuée, il vous suffit de cliquer sur le nom d'une personne pour consulter son profil public.<br />
                    Vous pouvez cliquer sur les colonnes pour les trier dans l'ordre alphanumérique croissant ou décroissant.
                </p>
            </div> <!-- /.jumbotron -->

            <div class="well">
                <form role="form" action="recherche_profil.php"
                      method="get"
                      name="formReProfil" id="formReProfil">
                    <table>
                        <tr>
                            <th>
                                <label for="nomPrenom" class="control-label">Nom et/ou prénom</label>
                            </th>

                            <td>
                                <!-- // @TODO Utilité du placeholder si label ? -->
                                <input type="text" name="nomPrenom" id="nomPrenom"
                                       class="form-control" placeholder="Nom et/ou Prénom"
                                       <?php echo isset($_GET['nomPrenom']) ? 'value="' . $_GET['nomPrenom'] . '"' : "" ?> />
                            </td>

                            <th>
                                <label for="promo" class="control-label">Promotion</label>
                            </th>

                            <td>
                                <select name="promo" id="promo" class="form-control">
                                    <option value="all">Toutes les promotions</option>
                                    <?php
                                        // Récupération du min et du max pour les promos
                                        $promos = minMaxPromos();

                                        $promoPresente = isset($_GET['promo']);

                                        // Affichage de la liste
                                        for ($i = $promos['max']; $i >= $promos['min']; $i--) {
                                            echo "<option value=\"$i\"";
                                            echo ($promoPresente && strcmp($_GET['promo'], $i) == 0) ? " selected" : "";
                                            echo ">$i</option>\n";
                                        }
                                    ?>
                                </select>
                            </td>

                            <td>
                                <input type="submit" class="btn btn-primary btn-lg btn-submit" value="Rechercher" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div> <!-- /.well -->

            <?php
                // Si on a effectué une recherche
                if (isset($_SESSION['recherche_profil'])) {
            ?>
                    <div class="well">
            <?php
                    // S'il y a eu des résultats
                    if (count($_SESSION['recherche_profil']) > 0) {
            ?>
                        <h3 class="text-primary">Résultats de votre recherche</h3>

                        <table class="table table-striped sortable resultat_profil">
                            <thead>
                                <tr>
                                    <th>Prénom & Nom</th>
                                    <th>Promotion</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    // Affichage des résultats
                                    foreach ($_SESSION['recherche_profil'] as $profilEnCours) {
                                ?>
                                        <tr>
                                            <td class="nom">
                                                <!-- // @TODO Remettre l'édition des liens avec réécriture d'URL -->
                                                <a href="profil_public.php?id=<?php echo $profilEnCours['codePe']; ?>">
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
            <?php
                        // Paramètres de la pagination
                        $page = 1;
                        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                            $page = $_GET['page'];
                        }

                        $nb_pages = $_SESSION['nb_pages'];
                        unset($_SESSION['nb_pages']);

                        // Affichage de la pagination
                        // @TODO Inconvénient de la pagination : le tri sur colonnes ne marche que pour les résultats affichés
                        echo pagination($page, $nb_pages);
                    } else {
                        // S'il n'y a pas eu de résultats
            ?>
                        <h3 class="text-danger">Votre recherche n'a pas donné de résultats</h3>
            <?php
                    }
            ?>
                    </div> <!-- /.well -->
            <?php
                    unset($_SESSION['recherche_profil']);
                }
            ?>
        </div> <!-- /.container -->

        <!-- ================================================== -->

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="dist/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

        <!-- Script tri tableau -->
        <script src="js/sorttable.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
