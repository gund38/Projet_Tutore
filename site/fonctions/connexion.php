<?php

    // Chargement des fichiers de classes et de fonctions
    function chargerClasse($classe) {
        require_once '../classes/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions.php';

    // Démarrage de la session
    session_start();

    // Suppresion du message en cas de renvoi du formulaire
    supprimerMessageAvertissement();

    unset($_GET);
    $fichierRetour = "../index.php";
    $nbErreurs = 0;
    $_SESSION['erreurs_connexion'] = "";

    if (empty($_POST['login'])) {
        $_SESSION['erreurs_connexion'] .= "Veuillez remplir le champ Login.<br />\n";
        $nbErreurs++;
    }
    if (empty($_POST['mdp'])) {
        $_SESSION['erreurs_connexion'] .= "Veuillez remplir le champ Mot de passe.<br />\n";
        $nbErreurs++;
    }

    if ($nbErreurs != 0) {
        header("Location: $fichierRetour");
        exit;
    }

    if (isset($_POST['login']) && isset($_POST['mdp'])) {
        // On nettoie les variables (utile si PHP < 5.4)
        if (get_magic_quotes_gpc()) {
            $login = stripslashes($_POST['login']);
            $pass = stripslashes($_POST['mdp']);
        } else {
            $login = $_POST['login'];
            $pass = $_POST['mdp'];
        }

        // Encore un peu de nettoyage
        $filter = FILTER_SANITIZE_STRING;
        $flags = FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_ENCODE_AMP;

        $login = filter_var($login, $filter, $flags);
        $pass = filter_var($pass, $filter, $flags);

        $login = addslashes($login);
        $pass = addslashes($pass);

        // On supprime $_POST dont on n'a plus besoin
        unset($_POST);

        // On teste les identifiants
        $resultat = login($login, $pass);

        if (!$resultat) {
            $_SESSION['erreurs_connexion'] .= "Vos identifiants sont incorrects<br />\n";
        } else {
            unset($_SESSION['erreurs_connexion']);
        }

        header("Location: $fichierRetour");
    } else {
        header("Location: $fichierRetour");
    }

    /**
     * Teste les identifiants et retourne vrai s'ils existent,
     * faux sinon
     *
     * @param type $login Login de la personne
     * @param type $pass Mot de passe de la personne
     * @return boolean
     */
    function login($login, $pass) {
        // Récupération de la connexion à la BD
        $bdd = ConnexionBD::getInstance()->getBDD();

        // Préparation de la requête
        $req = $bdd->prepare('SELECT codePe
            FROM Personne
            WHERE login = :login AND mdp = :mdp');

        // Exécution de la requête
        $req->execute(array(
            'login' => $login,
            'mdp' => $pass
        ));

        $reponse = false;

        // Création du managerPersonne
        $manager = new PersonneManager($bdd);

        // S'il y a un résultat, on enregistre la Personne
        while ($donnees = $req->fetch()) {
            $_SESSION['personneCo'] = $manager->getPersonne($donnees['codePe']);

            $reponse = true;
        }

        return $reponse;
    }

?>
