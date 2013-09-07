<?php
    /**
     * Ce fichier contient l'en-tête de la plupart
     * des pages du site
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    /**
     * Fonction d'en-tête
     *
     * @param boolean $verifAcces Définit si l'on doit verifier les droits
     */
    function enTete($verifAcces) {
        error_reporting(E_ALL | E_STRICT);

        /**
         * Chargement des fichiers de classes
         *
         * @param string $classe La classe à charger
         */
        function chargerClasse($classe) {
            require_once 'classes/' . $classe . '.php';
        }

        // Ajout de la fonction de chargement
        spl_autoload_register('chargerClasse');

        // Inclusion de fonctions.php
        require_once 'fonctions/fonctions.php';

        // Démarrage de la session
        session_start();

        if ($verifAcces) {
            // On vérifie si l'on a le droit d'accéder à cette page
            if (!verifierAcces($_SERVER['PHP_SELF'])) {
                $_SESSION['erreur_droits'] = true;
                header("Location: login.php?page=" . substr(strrchr($_SERVER['PHP_SELF'], '/'), 1));
            }
        }
    }
?>