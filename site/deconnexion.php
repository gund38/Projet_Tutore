<?php
    session_start();

    unset($_SESSION['PersonneCo']);

    session_destroy();

    header("Location: index.php");
?>
