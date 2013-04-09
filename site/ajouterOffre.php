<?php
    // Démarrage de la session et chargement des fichiers utiles
    session_start();

    function chargerClasse($classe) {
        require_once 'class/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions.php';

    // Suppresion du message en cas de renvoi du formulaire
    supprimerMessageAvertissement();

    $fichierRetour = "ajouter_offre.php";
    $nbTabs = 5;
    $nbRetours = 1;

    /*
     * Création du tableau d'options pour la vérification et
     * le nettoyage des infos soumises par l'utilisateur
     */
    $options = array(
        'intitule' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_ENCODE_AMP
        ),
        'entreprise' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_ENCODE_AMP
        ),
        'ville' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_ENCODE_AMP
        ),
        'remuneration' => array(
            'filter' => FILTER_CALLBACK,
            'flags' => array(
                'options' => 'validerFloat'
            )
        )
    );

    /*
     * Application des options pour chaque champ du formulaire
     *
     * Note : on pourrait utiliser la fonction filter_var_array(),
     * mais l'utilisation de la fonction supprimerMessageAvertissement()
     * nous en empêche. En effet, le 'vrai' tableau $_POST est détruit
     * et est remplacé par notre version sauvegardée puis restaurée.
     */
    foreach ($options as $cle => $valeur) {
        $resultat[$cle] = filter_var($_POST[$cle], $valeur['filter'], $valeur['flags']);
    }

    /*
     * Préparation des messages d'erreurs
     *
     * (Les champs texte ne prennent pas de messages d'erreurs
     * car ils ne sont que nettoyés, et non pas vérifiés)
     */
    $messageErreur = array(
        'intitule' => "",
        'entreprise' => "",
        'ville' => "",
        'remuneration' => "Le salaire doit être un entier ou un nombre à 1 ou 2 décimales positif (le séparateur peut être une virgule ou un point)"
    );

    // Nombre d'erreurs et concaténation de tous les messages d'erreurs
    $nbErreurs = 0;
    $_SESSION['erreurs'] = "";

    // On parcourt les champs voulus
    foreach ($options as $cle => $valeur) {
        // Si le champ est vide
        if (empty($_POST[$cle])) {
            $_SESSION['erreurs'] .= indenter("Veuillez remplir le champ " . $cle . ".<br />", $nbTabs, $nbRetours);
            $nbErreurs++;
        } elseif ($resultat[$cle] === false) { // S'il n'est pas valide
            $_SESSION['erreurs'] .= indenter($messageErreur[$cle] . "<br />", $nbTabs, $nbRetours);
            $nbErreurs++;
        }
    }

    // Vérification du fichier uploadé
    switch ($_FILES['fichier']['error']) {
        case UPLOAD_ERR_OK:
            // Le fichier est bien uploadé, on ne fait rien
            break;

        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $_SESSION['erreurs'] .= indenter("Fichier trop grand !<br />", $nbTabs, $nbRetours);
            $nbErreurs++;
            break;

        case UPLOAD_ERR_PARTIAL:
            $_SESSION['erreurs'] .= indenter("Fichier reçu partiellement !<br />", $nbTabs, $nbRetours);
            $nbErreurs++;
            break;

        case UPLOAD_ERR_NO_FILE:
            $_SESSION['erreurs'] .= indenter("Pas de fichier !<br />", $nbTabs, $nbRetours);
            $nbErreurs++;
            break;

        default:
            $_SESSION['erreurs'] .= indenter("Erreur avec le fichier !<br />", $nbTabs, $nbRetours);
            $nbErreurs++;
            break;
    }

    // S'il y a au moins une erreur, on se redirige vers le formulaire
    if ($nbErreurs != 0) {
        header("Location: $fichierRetour");
        die();
    }

    // On extrait l'extension du fichier uploadé
    $extension_upload = strtolower(substr(strrchr($_FILES['fichier']['name'], '.'), 1));

    if (strcmp($extension_upload, "pdf") == 0) {
        // L'extension est bonne, on ne fait rien
    } else {
        $_SESSION['erreurs'] .= indenter("Mauvaise extension, seul les fichiers PDF sont acceptés !<br />", $nbTabs, $nbRetours);

        // Suppression du fichier temporaire
        supprimerFichierTemp();

        // Redirection
        header("Location: $fichierRetour");
        die();
    }

    /*
     * Préparation du nouveau nom du fichier,
     * basé sur un identifiant unique
     */
    $nom = "pdf/" . uniqid() . ".pdf";

    if (rename($_FILES['fichier']['tmp_name'], $nom)) {
        // Le renommage s'est bien passé, on ne fait rien
    } else {
        $_SESSION['erreurs'] .= indenter("Fail du rename<br />", $nbTabs, $nbRetours);

        // Suppression du fichier temporaire
        supprimerFichierTemp();

        // Redirection
        header("Location: $fichierRetour");
        die();
    }

    /*
     * Si tout s'est bien passé, on prépare un message de succès
     * et on se redirige vers le formulaire
     */
    unset($_SESSION['erreurs']);
    $_SESSION['sortie'] = indenter("L'offre a été ajoutée !<br />", $nbTabs, $nbRetours);
    header("Location: $fichierRetour");

    /**
     * Fonction de suppression du fichier temporaire uploadé
     */
    function supprimerFichierTemp() {
        if (unlink($_FILES['fichier']['tmp_name'])) {
            // La suppression s'est bien passé, on ne fait rien
        } else {
            $_SESSION['erreurs'] .= indenter("Fail de la suppression<br />", 5, 1);
            header("Location: ajouter_offre.php");
            die();
        }
    }

?>
