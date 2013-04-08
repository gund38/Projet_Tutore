<?php

    function echoBD($text) {
        echo(utf8_encode($text));
    }

    function supprimerMessageAvertissement() {
        //session_start();

        if (!empty($_POST) OR !empty($_FILES)) {
            $_SESSION['sauvegarde'] = $_POST;
            $_SESSION['sauvegardeFILES'] = $_FILES;

            $fichierActuel = $_SERVER['PHP_SELF'];
            if (!empty($_SERVER['QUERY_STRING'])) {
                $fichierActuel .= '?' . $_SERVER['QUERY_STRING'];
            }

            foreach ($_FILES as $fichier => $valeurs) {
                $nom = substr($valeurs['tmp_name'], 1);

                if ($valeurs['error'] == 0
                        && move_uploaded_file($valeurs['tmp_name'], $nom)) {
                    $_SESSION['sauvegardeFILES'][$fichier]['tmp_name'] = $nom;
                }
            }

            header('Location: ' . $fichierActuel);
            exit;
        }

        if (isset($_SESSION['sauvegarde'])) {
            $_POST = $_SESSION['sauvegarde'];
            $_FILES = $_SESSION['sauvegardeFILES'];

            unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);
        }
    }

?>
