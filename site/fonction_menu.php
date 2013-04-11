<?php
    switch ($_SESSION['personneCo']->getType()) {
        case "Enseignant":
            include("menu_enseignant.php" );
            break;
        case "Etudiant":
            include("menu_E.php" );
            break;
        case "Ancien_etudiant":
            include("menu_AE.php" );
            break;
        case "Administrateur":
            include("menu_admin.php" );
            break;
        default:
            echo "Erreur";
    }
?>
