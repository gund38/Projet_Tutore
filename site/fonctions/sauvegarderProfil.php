<?php
    /**
     * Ce fichier permet la sauvegarde du profil
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
    $fichierRetour = "../profil.php";
    $nbErreurs = 0;
    $_SESSION['erreurs_connexion'] = "";

    // Vérification que les variables ne soient pas vides
    /**
     * @TODO modifier ce test en test générique
     */
//    if (empty($_POST['login'])) {
//        $_SESSION['erreurs_connexion'] .= "Veuillez remplir le champ Login.<br />\n";
//        $nbErreurs++;
//    }
//    if (empty($_POST['mdp'])) {
//        $_SESSION['erreurs_connexion'] .= "Veuillez remplir le champ Mot de passe.<br />\n";
//        $nbErreurs++;
//    }

//$nbErreurs++;

    if ($nbErreurs != 0) {
        header("Location: $fichierRetour");
        exit;
    }
?>
