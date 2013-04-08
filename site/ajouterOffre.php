<?php

    session_start();

    function chargerClasse($classe) {
        require 'class/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    include_once 'fonctions.php';
    supprimerMessageAvertissement();

    print_r($_FILES);
    echo "<br />";

    if (isset($_POST['intitule']) && isset($_POST['ville'])) {
        switch ($_FILES['fichier']['error']) {
            case UPLOAD_ERR_OK:
                echo "Upload OK !<br />";
                break;

            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "Fichier trop grand !<br />";
                die();
                break;

            case UPLOAD_ERR_PARTIAL:
                echo "Fichier reçu partiellement !<br />";
                die();
                break;

            case UPLOAD_ERR_NO_FILE:
                echo "Pas de fichier !<br />";
                die();
                break;

            default:
                echo "Erreur avec le fichier !<br />";
                die();
                break;
        }

        $extension_upload = strtolower(substr(strrchr($_FILES['fichier']['name'], '.'), 1));

        if (strcmp($extension_upload, "pdf") == 0) {
            echo "Extension OK !<br />";
        } else {
            echo "Mauvaise extension, seul les fichiers PDF sont accept&eacute;s !<br />";
            supprimerFichierTemp();
            die();
        }

        $nom = "pdf/" . uniqid() . ".pdf";

        if (rename($_FILES['fichier']['tmp_name'], $nom)) {
            echo "Rename r&eacute;ussi<br />";
        } else {
            echo "Fail du rename<br />";
            supprimerFichierTemp();
            die();
        }
    } else {
        header("Location: index.php");
    }

    function supprimerFichierTemp() {
        if (unlink($_FILES['fichier']['tmp_name'])) {
            echo "Suppression r&eacute;ussie<br />";
        } else {
            echo "Fail de la suppression<br />";
        }
    }
?>
