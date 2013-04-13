<?php
    switch ($_SESSION['personneCo']->getType()) {
        case "Enseignant":
            require_once 'menu_enseignant.php';
            break;
        case "Etudiant":
            require_once 'menu_E.php';
            break;
        case "Ancien_etudiant":
            require_once 'menu_AE.php';
            break;
        case "Administrateur":
            require_once 'menu_admin.php';
            break;
        default:
            echo "Erreur";
    }
?>
