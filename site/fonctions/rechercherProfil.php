<?php
    /**
     * Ce fichier permet la recherche parmi les profils
     *
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

    unset($_GET);
    $fichierRetour = "../recherche_profil.php";

    /**
     * Création du tableau d'options pour la vérification ou
     * le nettoyage des infos soumises par l'utilisateur
     */
    $options = array(
        'nomPrenom' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => ''
        ),
        'promo' => array(
            'filter' => FILTER_VALIDATE_INT,
            'flags' => array(
                'min_range' => '1900',
                'max_range' => '2100'
            )
        )
    );

    /*
     * Application des options pour chaque champ du formulaire
     */
    $resultat = array();
    foreach ($options as $cle => $valeur) {
        $resultat[$cle] = filter_input(INPUT_POST, $cle, $valeur['filter'], $valeur['flags']);

        // Un autre nettoyage des variables pour éviter tout problème
        if (get_magic_quotes_gpc()) {
            $resultat[$cle] = stripslashes($resultat[$cle]);
        }
    }

    // Récupération connexion BD
    $bdd = ConnexionBD::getInstance()->getBDD();

    // Création de la requête
    $requete = 'SELECT pe.codePe, pe.prenom, pe.nom, pr.promo
        FROM Personne AS pe, Profil AS pr
        WHERE pe.codePe = pr.codePe
        AND pe.type = \'Ancien_etudiant\''; // @TODO Ajouter condition compte validé

    /**
     * Création du tableau de données
     *
     * NOTE : On a mis 2 marqueurs différents pour le nom et le prénom
     * car nous n'avons pas le droit de mettre plus d'une fois
     * le même marqueur dans une requête.
     */
    $donnees = array();

    // Si le champ 'Nom Prénom' a été renseigné
    // @TODO Revoir algo recherche pour nom/prénom incluant la découpe des mots
    if (!empty($resultat['nomPrenom'])) {
        $requete .= ' AND (pe.prenom LIKE :prenom OR pe.nom LIKE :nom)';

        $donnees['prenom'] = $donnees['nom'] = "%" . $resultat['nomPrenom'] . "%";
    }

    // Si le champ 'Promo' a été renseigné
    if ($resultat['promo']) {
        $requete .= ' AND pr.promo = :promo';

        $donnees['promo'] = $resultat['promo'] ? $resultat['promo'] : "";
    }

    // Ajout du ORDER BY
    $requete .= ' ORDER BY pe.nom';

    // Préparation de la requête
    $req = $bdd->prepare($requete);

    // Si la préparation a échoué
    if (!$req) {
        $_SESSION['erreurs_recherche_profil'] = "La recherche n'a pas fonctionné (préparation), veuillez réessayer.<br />\n";
        header("Location: $fichierRetour");
        exit;
    }

    // Exécution de la requête
    $req->execute($donnees);

    // Si la requête a échoué
    if (!$req) {
        $_SESSION['erreurs_recherche_profil'] = "La recherche n'a pas fonctionné (exécution), veuillez réessayer.<br />\n";
        header("Location: $fichierRetour");
        exit;
    }

    $_SESSION['recherche_profil'] = $req->fetchAll(PDO::FETCH_ASSOC);
    header("Location: $fichierRetour");
?>
