<?php
    /**
     * Ce fichier permet la déconnexion d'un utilisateur
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    session_start();

    unset($_SESSION['PersonneCo']);

    session_destroy();

    header("Location: ../index.php");
?>
