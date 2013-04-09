<?php

    function echoBD($text) {
        return utf8_encode($text);
    }

    function listeDepartement() {
        $bdd = ConnexionBD::getInstance()->getBDD();

        $req = $bdd->query('SELECT codeDe, codePostal, nom
            FROM ListeDepartement
            ORDER BY codeDE');

        $liste = array();

        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $liste[] = array(
                'codeDe' => $donnees['codeDe'],
                'nom' => echoBD($donnees['codePostal'] . " - " . $donnees['nom'])
            );
        }

        return $liste;
    }

    function listeType() {
        $bdd = ConnexionBD::getInstance()->getBDD();

        $req = $bdd->query("SHOW COLUMNS
            FROM Offre
            LIKE 'type'");

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $liste = explode("','", substr(echoBD($donnees['Type']), 6, -2));

        return $liste;
    }

    function validerFloat($floatATester) {
        return preg_match('/^[0-9]+((,|.)[0-9]{1,2})?$/', $floatATester) ? $floatATester : false;
    }

    function supprimerMessageAvertissement() {
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
