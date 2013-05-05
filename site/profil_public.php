<?php
    /**
     * Page d'affichage du profil d'un ancien étudiant
     *
     * Cette page bénéficie d'une réécriture d'URL. Pour être valide,
     * l'URL de cette page doit être de la forme "profil_public-X.php"
     * ou "profil_public.php?id=X", où X est un nombre.
     *
     * Si l'URL n'est pas valide ou que X ne correspond pas à un profil,
     * l'utilisateur sera redirigé vers l'accueil.
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
        <link rel="stylesheet" href="css/profil.css" />

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
                <?php
                    // On tente de récupérer le profil grâce à l'identifiant passé en paramètre
                    $profilManager = new ProfilManager(ConnexionBD::getInstance()->getBDD());
                    $profil = $profilManager->getProfil($_GET['id']);

                    // S'il n'y a pas de profil, on affiche un message d'erreur et on redirige
                    if ($profil == null) {
                        echo "<h3 class=\"erreur\">Le profil auquel vous tentez d'accéder n'existe pas. Vous allez être redirigé vers l'accueil</h3>\n";
                        echo '<meta http-equiv="refresh" content="3;URL=index.php">';
                        exit;
                    }

                    // On récupère le profil complet
                    $profil->obtenirProfilComplet();
                ?>

                <div id="profil_photo">
                    <img src="images/profil/<?php echo $profil->getCheminPhoto(); ?>" alt="Photo du Profil" title="Photo du Profil" width="200px">
                </div>

                <div id="profil_description">
                    <h4><?php echo $_SESSION['personneCo']->getPrenom() . ' ' . $_SESSION['personneCo']->getNom(); ?></h4>
                </div>

                <div id="profil_general">
                    <fieldset>
                        <legend>Informations personnelles</legend>

                        <p>
                            <?php
                                echo $profil->getVisibiliteDateNaissance() ? "Date de naissance : " . $profil->getDateNaissance() : "";
                                echo "\n";
                            ?>
                        </p>

                        <p>
                            <?php
                                echo $profil->getVisibiliteEmail() ? "Email : <a id=\"lien_profil\" href=\"mailto:" . $profil->getDateNaissance() . "\">" . $profil->getDateNaissance() . "</a>" : "";
                                echo "\n";
                            ?>
                        </p>

                        <p>
                            <?php
                                echo $profil->getVisibilitePagePerso() ? "Page perso : <a id=\"lien_profil\" href=\"http://" . $profil->getPagePerso() . "\">" . $profil->getPagePerso() . "</a>" : "";
                                echo "\n";
                            ?>
                        </p>
                    </fieldset>

                    <fieldset>
                        <legend>Parcours scolaire</legend>

                        <?php
                            $diplomes = $profil->getDiplomes();

                            foreach ($diplomes as $diplomeEnCours) {
                                ?>
                                <?php
                            }
                        ?>
                    </fieldset>

                    <fieldset>
                        <legend>Parcours professionnel</legend>
                    </fieldset>
                </div>
            </div>
        </div>
    </body>
</html>