<?php

    session_start();

    function chargerClasse($classe) {
        require 'class/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    include_once 'fonctions.php';

    unset($_GET);

    if (isset($_POST['login']) && isset($_POST['mdp'])) {
        if (get_magic_quotes_gpc()) {
            $login = stripslashes($_POST['login']);
            $pass = stripslashes($_POST['mdp']);
        } else {
            $login = $_POST['login'];
            $pass = $_POST['mdp'];
        }

        $bdd = ConnexionBD::getInstance()->getBDD();
        unset($_POST);

        $kid = login($bdd, $login, $pass);
        if ($kid == -1) {
            error(3);
        } else {
            printf("");
            $_SESSION['personneCo']->afficher();
        }
    }

    function error($ec) {
        printf("erreur : $ec");
        die();
    }

    function login($bdd, $login, $pass) {
        //$fixedlogin = mysql_real_escape_string($login);
        //$fixedpass  = mysql_real_escape_string($pass);

        $req = $bdd->prepare('SELECT codePe
            FROM Personne
            WHERE login = :login AND mdp = :mdp');

        $req->execute(array(
            'login' => $login,
            'mdp' => $pass
        ));

        $reponse = -1;

        while ($donnees = $req->fetch()) {
            echo "OK : " . $donnees['codePe'];

            $manager = new PersonneManager($bdd);
            $_SESSION['personneCo'] = $manager->getPersonne($donnees['codePe']);

            $reponse = 0;
        }

        return $reponse;
    }

?>
