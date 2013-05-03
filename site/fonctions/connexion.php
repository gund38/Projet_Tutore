<?php
    /**
     * Ce fichier permet la connexion d'un utilisateur au site
     * Les informations rentrées dans le formulaire
     * seront d'abord vérifiées et nettoyées
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    /**
     * Chargement des fichiers de classes
     *
     * @param string $classe La classe à charger
     */
    function chargerClasse($classe) {
        require_once '../classes/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions.php';

    // Démarrage de la session
    session_start();

    // Suppresion du message en cas de renvoi du formulaire
    supprimerMessageAvertissement();

    unset($_GET);
    $fichierRetour = "../login.php";
    $nbErreurs = 0;
    $_SESSION['erreurs_connexion'] = "";

    // Vérification que les variables ne soient pas vides
    /**
     * @TODO modifier ce test en test générique
     */
    if (empty($_POST['login'])) {
        $_SESSION['erreurs_connexion'] .= "Veuillez remplir le champ Login.<br />\n";
        $nbErreurs++;
    }
    if (empty($_POST['mdp'])) {
        $_SESSION['erreurs_connexion'] .= "Veuillez remplir le champ Mot de passe.<br />\n";
        $nbErreurs++;
    }

    if ($nbErreurs != 0) {
        header("Location: $fichierRetour");
        exit;
    }

    // On nettoie les variables (utile si PHP < 5.4)
    if (get_magic_quotes_gpc()) {
        $login = stripslashes($_POST['login']);
        $pass = stripslashes($_POST['mdp']);
    } else {
        $login = $_POST['login'];
        $pass = $_POST['mdp'];
    }

    // Encore un peu de nettoyage
    $filter = FILTER_SANITIZE_STRING;
    $flags = FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_ENCODE_AMP;

    $login = filter_var($login, $filter, $flags);
    $pass = filter_var($pass, $filter, $flags);

    // On supprime $_POST dont on n'a plus besoin
    unset($_POST);

    // On teste les identifiants
    $resultat = login($login, $pass);

    if (!$resultat) {
        $_SESSION['erreurs_connexion'] .= "Vos identifiants sont incorrects<br />\n";
    } else {
        unset($_SESSION['erreurs_connexion']);
    }

    header("Location: $fichierRetour");
?>
