<?php
    /**
     * Ce fichier permet la génération des statistiques
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    // Démarrage de la session
    session_start();

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

    // Suppresion du message en cas de renvoi du formulaire
//    supprimerMessageAvertissement();

    $fichierRetour = "../statistiques.php";

    $promos = minMaxPromos();

    /*
     * Création du tableau d'options pour la vérification et
     * le nettoyage des infos soumises par l'utilisateur
     */
    $options = array(
        'type_stat' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => ''
        ),
        'promo_deb' => array(
            'filter' => FILTER_VALIDATE_INT,
            'flags' => array(
                'min_range' => $promos['min'],
                'max_range' => $promos['max']
            )
        ),
        'promo_fin' => array(
            'filter' => FILTER_VALIDATE_INT,
            'flags' => array(
                'min_range' => $promos['min'],
                'max_range' => $promos['max']
            )
        ),
        'promo_all' => array(
            'filter' => FILTER_VALIDATE_BOOLEAN,
            'flags' => ''
        ),
        'type_graphe' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => ''
        )
    );

    print_r($options);
    echo "<br /><br />\n";

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

    print_r($resultat);
    echo "<br /><br />\n";

    // Sélection de la requête
    // @TODO Réfléchir sur condition 'enCours = 1'
    $requete = "";
    switch ($resultat['type_stat']) {
        default:
        case "rep_salaires":
            $requete = "SELECT salaire
                FROM ExpPro
                WHERE enCours = 1";
            break;

        case "rep_geo":
            $requete = "SELECT d.codePostal, d.nom
                FROM Departement AS d, ExpPro AS e
                WHERE d.codeDe = e.departement
                AND enCours = 1";
            break;
    }

    print_r($requete);
    echo "<br /><br />\n";

    $bdd = ConnexionBD::getInstance()->getBDD();

    $req = $bdd->query($requete);

//    print_r($req->fetchAll(PDO::FETCH_ASSOC));
//    echo "<br /><br />\n";
//
//    print_r($req->rowCount());
//    echo "<br /><br />\n";

    $resultats = array();
    while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
        $resultats[] = $donnees;
    }

    print_r($resultats);
    echo "<br /><br />\n";

    print_r(json_encode($resultats));
    echo "<br /><br />\n";
?>
