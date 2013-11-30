<?php
    /**
     * Ce fichier contient la fonction pour connaître
     * les id actuellement utilisés par les tables concernées.
     * Ce fichier est destiné à être appelé grâce à AJAX.
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

    // Ajout de la fonction de chargement
    spl_autoload_register('chargerClasse');

    /**
     * Retourne le dernier id utilisé par la table choisie
     *
     * @param string $table Table choisie
     * @return string
     */
    function autoIncrement($table) {
        $id = "";

        switch ($table) {
            case "Diplome":
                $id = "codeDi";
                break;
            case "ExpPro":
                $id = "codeEP";
                break;
            default:
                return "";
        }

        // Récupératon de la connexion à la BD
        $bdd = ConnexionBD::getInstance()->getBDD();

        $tab = $bdd->query("SELECT MAX($id) AS ID_MAX FROM $table")->fetch(PDO::FETCH_ASSOC);

        return $tab['ID_MAX'];
    }

    echo autoIncrement($_GET['table']);
?>