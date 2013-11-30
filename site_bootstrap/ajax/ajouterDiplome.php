<?php
    /**
     * Ce fichier permet l'ajout d'un diplôme dans un profil.
     * Il est utilisé via AJAX.
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

    // Ajout de la fonction de chargement
    spl_autoload_register('chargerClasse');

    /**
     * Création des options pour la vérification ou
     * le nettoyage des infos soumises par l'utilisateur
     */
    $optionString = array(
        'filter' => FILTER_SANITIZE_STRING,
        'flags' => ''
    );

    $optionBoolean = array(
        'filter' => FILTER_VALIDATE_BOOLEAN,
        'flags' => ''
    );

    $optionAnnee = array(
        'filter' => FILTER_VALIDATE_INT,
        'flags' => array( // @TODO réfléchir utilité de ce paramètre
            'min_range' => '1900',
            'max_range' => '2100'
        )
    );

    $optionId = array(
        'filter' => FILTER_VALIDATE_INT,
        'flags' => array(
            'min_range' => '0'
        )
    );

    // Parties de message
    $msgVideBase = "Veuillez remplir le champ";

    // Création du tableau d'options
    $options = array();

    $options["codePe"] = $optionId;

    $options["visi_dip"] = $optionBoolean;
    $options["visi_dip"]['booleen'] = true;

    $options["annee_dip"] = $optionAnnee;
    $options["annee_dip"]['msgVide'] = "$msgVideBase Année";
    $options["annee_dip"]['msgErreur'] = "L'Année doit être comprise entre 1900 et 2100";

    $options["type_dip"] = $optionString;
    $options["type_dip"]['msgVide'] = "$msgVideBase Type";

    $options["disc_dip"] = $optionString;
    $options["disc_dip"]['msgVide'] = "$msgVideBase Discipline";

    $options["etabli_dip"] = $optionString;
    $options["etabli_dip"]['msgVide'] = "$msgVideBase Établissement";

    // Application des options pour chaque champ du formulaire
    $resultat = array();
    foreach ($options as $cle => $valeur) {
        $resultat[$cle] = filter_input(INPUT_POST, $cle, $valeur['filter'], $valeur['flags']);

        // Un autre nettoyage des variables pour éviter tout problème
        if (get_magic_quotes_gpc()) {
            $resultat[$cle] = stripslashes($resultat[$cle]);
        }
    }

    // Nombre d'erreurs et concaténation de tous les messages d'erreurs
    $nbErreurs = 0;
    $erreurs = "";

    // On parcourt les champs
    foreach ($options as $cle => $valeur) {
        if (!$options[$cle]['booleen'] // Si le champ n'est pas un booléen
                && empty($resultat[$cle])) { // Et qu'il est vide
            $erreurs .= $options[$cle]['msgVide'] . "<br />\n";
            $nbErreurs++;
        } elseif (!$options[$cle]['booleen'] // Si le champ n'est pas un booléen
                && $resultat[$cle] === false) { // Et qu'il n'est pas valide
            $erreurs .= $options[$cle]['msgErreur'] . "<br />\n";
            $nbErreurs++;
        }
    }

    // S'il y a au moins une erreur, on les affiche et on quitte
    if ($nbErreurs != 0) {
//        header("Location: $fichierRetour");
        echo $erreurs;
        exit;
    }

    // Création du Diplome
    $diplome = new Diplome(array(
        'codePe' => $resultat["codePe"],
        'visibilite' => $resultat["visi_dip"] ? 1 : 0,
        'annee' => $resultat["annee_dip"],
        'type' => $resultat["type_dip"],
        'discipline' => $resultat["disc_dip"],
        'etablissement' => $resultat["etabli_dip"]
    ));

    // Création d'un DiplomeManager pour l'insertion
    $diplomeManager = new DiplomeManager(ConnexionBD::getInstance()->getBDD());

    // Ajout du Diplome dans la BD
    if (!$diplomeManager->addDiplome($diplome)) {
        $erreurs .= "Erreur de l'insertion dans la BD. Veuillez réessayer<br />\n";

        echo $erreurs;
        exit;
    }

    // Si tout s'est bien passé, message de réussite
    echo "OK";
?>
