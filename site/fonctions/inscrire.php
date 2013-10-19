<?php
    /**
     * Ce fichier permet l'inscription d'un nouvel utilisateur
     *
     * @TODO Renforcer sécurité, fonction par défaut actuellement
     * @author Kévin Bélellou et Nicolas Dubois
     */

    /**
     * Chargement des fichiers de classes
     *
     * @param string $classe La classe à charger
     */
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
    $fichierRetour = "../inscription.php";

    // Récupération année courante
    $dateCourante = getdate();
    $anneeCourante = $dateCourante['year'];

    /*
     * Création du tableau d'options pour la vérification et
     * le nettoyage des infos soumises par l'utilisateur
     */
    $options = array(
        'type' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => ''
        ),
        'nom' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => ''
        ),
        'prenom' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => ''
        ),
        'email' => array(
            'filter' => FILTER_VALIDATE_EMAIL,
            'flags' => ''
        ),
        'promo' => array(
            'filter' => FILTER_VALIDATE_INT,
            'flags' => array(
                'min_range' => 1970,
                'max_range' => $anneeCourante
            ),
            'neDoitPasEtreVerifie' => strcmp($_POST['type'], "ancien_etudiant") !== 0 ? true : false
        ),
        'master_valide' => array(
            'filter' => FILTER_VALIDATE_BOOLEAN,
            'flags' => '',
            'booleen' => true,
            'neDoitPasEtreVerifie' => strcmp($_POST['type'], "ancien_etudiant") !== 0 ? true : false
        ),
        'mdp1' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => ''
        ),
        'mdp2' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => ''
        )
    );

    /*
     * Application des options pour chaque champ du formulaire
     *
     * Note : on pourrait utiliser la fonction filter_input(),
     * mais l'utilisation de la fonction supprimerMessageAvertissement()
     * nous en empêche. En effet, le 'vrai' tableau $_POST est détruit
     * et est remplacé par notre version sauvegardée puis restaurée.
     */
    $resultat = array();
    foreach ($options as $cle => $valeur) {
        $resultat[$cle] = filter_var($_POST[$cle], $valeur['filter'], $valeur['flags']);

        // Un autre nettoyage des variables pour éviter tout problème
        if (get_magic_quotes_gpc()) {
            $resultat[$cle] = stripslashes($resultat[$cle]);
        }
    }

    /*
     * Préparation des messages d'erreurs
     *
     * (Les champs texte ne prennent pas de messages d'erreurs
     * car ils ne sont que nettoyés, et non pas vérifiés)
     */
    $messageErreur = array(
        'type' => "a",
        'nom' => "b",
        'prenom' => "c",
        'email' => "L'email doit être un email valide",
        'promo' => "L'année de promotion doit être comprise entre 1970 et $anneeCourante",
        'master_valide' => "d",
        'mdp1' => "e",
        'mdp2' => "f"
    );

    // Nombre d'erreurs et concaténation de tous les messages d'erreurs
    $nbErreurs = 0;
    $_SESSION['erreurs_inscription'] = "";

    // On parcourt les champs voulus
    foreach ($options as $cle => $valeur) {
        if (!$options[$cle]['booleen'] && // Si le champ n'est pas un booléen
                !$options[$cle]['neDoitPasEtreVerifie'] && // Et qu'il doit être vérifié
                empty($resultat[$cle])) { // Et qu'il est vide
            $_SESSION['erreurs_inscription'] .= "Veuillez remplir le champ " . ucfirst($cle) . ".<br />\n";
            $nbErreurs++;
        } elseif (!$options[$cle]['booleen'] && // Si le champ n'est pas un booléen
                !$options[$cle]['neDoitPasEtreVerifie'] && // Et qu'il doit être vérifié
                $resultat[$cle] === false) { // Et qu'il n'est pas valide
            $_SESSION['erreurs_inscription'] .= $messageErreur[$cle] . "<br />\n";
            $nbErreurs++;
        }
    }

    // S'il y a au moins une erreur, on se redirige vers le formulaire
    if ($nbErreurs != 0) {
        header("Location: $fichierRetour");
        exit;
    }

    // Création d'un PersonneManager pour l'insertion
    $personneManager = new PersonneManager(ConnexionBD::getInstance()->getBDD());

    // Horreur
    $login = uniqid();

    // Création du tableau de données de la Personne
    $donnees = array(
        'codePe' => NULL,
        'type' => $resultat['type'],
        'compteValide' => 0,
        'nom' => $resultat['nom'],
        'prenom' => $resultat['prenom'],
        'email' => $resultat['email'],
        'login' => $login,
        'mdp' => $resultat['mdp1']
    );

    // Ajout de la Personne dans la BD
    $ajout = $personneManager->addPersonne(new Personne($donnees));

    if ($ajout === false) {
        $_SESSION['erreurs_inscription'] .= "Erreur de l'insertion dans la BD.Veuillez réessayer<br />\n";

        // Redirection
        header("Location: $fichierRetour");
        exit;
    }

    // Ajout du Profil dans la BD si type = Ancien Étudiant
    if (strcmp($donnees['type'], "Ancien_etudiant") == 0) {
        /**
         * @TODO Code le plus dégueu que j'ai jamais fait
         * Remplacer par l'email lors de la suppression du login
         * Exporter fonctions SQL dans les Manager
         */
        $req = ConnexionBD::getInstance()->getBDD()->prepare("SELECT pe.codePe FROM Personne AS pe WHERE pe.login = :login");
        $req->execute(array('login' => $login));
        $res = $req->fetch(PDO::FETCH_ASSOC);

        // Création d'un ProfilManager pour l'insertion
        $profilManager = new ProfilManager(ConnexionBD::getInstance()->getBDD());

        // Création du tableau de données du Profil
        $donnees = array(
            'codePe' => $res['codePe'],
            'promo' => $resultat['promo'],
            'diplomeMaster' => $resultat['master_valide']
        );

        // Ajout du Profil dans la BD
        $ajout = $profilManager->addProfil(new Profil($donnees));

        if ($ajout === false) {
            $_SESSION['erreurs_inscription'] .= "Erreur de l'insertion du profil dans la BD.Veuillez réessayer<br />\n";

            // Redirection
            header("Location: $fichierRetour");
            exit;
        }
    }

    /*
     * Si tout s'est bien passé, on prépare un message de succès
     * et on se redirige vers le formulaire
     */
    unset($_SESSION['erreurs_inscription']);
    $_SESSION['sortie_inscription'] = "Votre inscription s'est bien passée !<br />" .
            "Mais votre compte doit encore être approuvé par l'administrateur, ce qui ne devrait pas prendre longtemps <i class=\"icon-smile icon-2x\"></i><br />" .
            "Vous serez averti par mail dès que cela sera fait.<br />\n";
    header("Location: $fichierRetour");
?>
