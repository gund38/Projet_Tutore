<?php

    // Chargement des fichiers de classes et de fonctions
    function chargerClasse($classe) {
        require_once 'class/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions.php';

    // Démarrage de la session
    session_start();

    supprimerMessageAvertissement();

    unset($_GET);
    $_SESSION['msg'] = "";

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
//            printf("");
//            $_SESSION['personneCo']->afficher();
            $_SESSION['msg'] .= "Connexion reussie";
            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: index.php");
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
//            echo "OK : " . $donnees['codePe'];

            $manager = new PersonneManager($bdd);
            $_SESSION['personneCo'] = $manager->getPersonne($donnees['codePe']);


            $_SESSION['msg'] .= get_class($_SESSION['personneCo']);
            //include "fonction_menu.php";

            $reponse = 0;
        }

        return $reponse;
    }

?>
