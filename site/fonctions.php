<?php

    function connexionBD() {
        $bdd = null;

        try {
            $bdd = new PDO('mysql:host=localhost;dbname=projet_tutore', 'gund38', 'gund38');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        return $bdd;
    }

    function echoBD($text) {
        echo(utf8_encode($text));
    }

?>
