<?php
    /**
     * Ce fichier permet la recherche parmi les offres
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
    $fichierRetour = "../recherche_offres.php";

    /**
     * Création du tableau d'options pour la vérification ou
     * le nettoyage des infos soumises par l'utilisateur
     */
    $options = array(
        'intitule' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => ''
        ),
        'type' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => ''
        ),
        'ville' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => ''
        ),
        'departement' => array(
            'filter' => FILTER_VALIDATE_INT,
            'flags' => array(
                'min_range' => '1',
                'max_range' => '101'
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
    $requete = 'SELECT o.codeO, DATE_FORMAT(o.dateDepot, \'%d/%m/%Y\') AS dateDepot,
        o.type, o.intitule, o.entreprise, o.ville, d.nom, d.codePostal,
        o.remuneration, o.cheminPDF
        FROM Offre AS o, Departement AS d
        WHERE o.departement = d.codeDe';


    // Création du tableau de données
    $donnees = array();

    // Si le champ 'intitule' a été renseigné
    // @TODO Revoir algo recherche pour intitule incluant la découpe des mots
    if (!empty($resultat['intitule'])) {
        $requete .= ' AND o.intitule LIKE :intitule';

        $donnees['intitule'] = "%" . $resultat['intitule'] . "%";
    }

    // Le champ type est forcément renseigné mais on vérifie par quoi
    switch ($resultat['type']) {
        case "Emploi":
        case "Stage":
            $requete .= ' AND o.type = :type';

            $donnees['type'] = $resultat['type'];
            break;
        default:
            break;
    }

    // Si le champ 'ville' a été renseigné
    if (!empty($resultat['ville'])) {
        $requete .= ' AND o.ville LIKE :ville';

        $donnees['ville'] = "%" . $resultat['ville'] . "%";
    }

    // Si le champ 'departement' a été renseigné
    if ($resultat['departement']) {
        $requete .= ' AND o.departement = :departement';

        $donnees['departement'] = $resultat['departement'];
    }

    // Ajout du ORDER BY
    $requete .= ' ORDER BY o.dateDepot DESC';

    // Préparation de la requête
    $req = $bdd->prepare($requete);

    // Si la préparation a échoué
    if (!$req) {
        $_SESSION['erreurs_recherche_offres'] = "La recherche n'a pas fonctionné (préparation), veuillez réessayer.<br />\n";
        header("Location: $fichierRetour");
        exit;
    }

    // Exécution de la requête
    $req->execute($donnees);

    // Si la requête a échoué
    if (!$req) {
        $_SESSION['erreurs_recherche_offres'] = "La recherche n'a pas fonctionné (exécution), veuillez réessayer.<br />\n";
        header("Location: $fichierRetour");
        exit;
    }

    $_SESSION['recherche_offres'] = $req->fetchAll(PDO::FETCH_ASSOC);
    header("Location: $fichierRetour");
?>
