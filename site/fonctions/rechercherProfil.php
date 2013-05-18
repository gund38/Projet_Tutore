<?php
    /**
     * Ce fichier permet la recherche parmi les profil
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
    $requete = 'SELECT pe.prenom, pe.nom, pr.promo
        FROM Personne AS pe, Profil AS pr
        WHERE pe.codePe = pr.codePe';

    /**
     * Création du tableau de données
     *
     * NOTE : On a mis 2 marqueurs différents pour le nom et le prénom
     * car nous n'avons pas le droit de mettre plus d'une fois
     * le même marqueur dans une requête.
     */
    $donnees = array();

    // Si le champ 'Nom Prénom' a été renseigné
    if (!empty($resultat['nomPrenom'])) {
        $requete .= ' AND (pe.prenom LIKE :prenom OR pe.nom LIKE :nom)';
        $donnees['prenom'] = $donnees['nom'] = "%" . $resultat['nomPrenom'] . "%";
    }

    // Si le champ 'Promo' a été renseigné
    if ($resultat['promo']) {
        $requete .= ' AND pr.promo = :promo';
        $donnees['promo'] = $resultat['promo'] ? $resultat['promo'] : "";
    }

    // Préparation de la requête
    $req = $bdd->prepare($requete);

    // Si la préparation a échoué
    if (!$req) {
        echo "fail preparation<br />\n";
    }

    // Exécution de la requête
    $req->execute($donnees);

    // Si la requête a réussi
    if ($req) {
        echo "requete reussie<br />\n";
    }

    while ($reponse = $req->fetch(PDO::FETCH_ASSOC)) {
        var_dump($reponse);
        echo "<br />\n";
    }
?>
