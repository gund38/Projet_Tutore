<?php
    /**
     * Ce fichier permet la sauvegarde du profil
     * Les informations rentrées dans le formulaire
     * seront d'abord vérifiées et nettoyées
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

    // Suppresion du message en cas de renvoi du formulaire
    supprimerMessageAvertissement();

    unset($_GET);
    $fichierRetour = "../profil.php";

    /**
     * Création des options pour la vérification ou
     * le nettoyage des infos soumises par l'utilisateur
     */
    $optionString = array(
        'filter' => FILTER_SANITIZE_STRING,
        'flags' => ''
    );

    $optionEmail = array(
        'filter' => FILTER_VALIDATE_EMAIL,
        'flags' => ''
    );

    $optionBoolean = array(
        'filter' => FILTER_VALIDATE_BOOLEAN,
        'flags' => ''
    );

    $optionAnnee = array(
        'filter' => FILTER_VALIDATE_INT,
        'flags' => array(
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

    $optionURL = array(
        'filter' => FILTER_CALLBACK,
        'flags' => array(
            'options' => 'validerURL'
        )
    );

    $optionDate = array(
        'filter' => FILTER_CALLBACK,
        'flags' => array(
            'options' => 'validerDateFR'
        )
    );

    // Parties de message
    $msgVideBase = "Veuillez remplir le champ";
    $msgFormat = "doit être au format dd/mm/YYYY";
    $msgDiplome = "du diplôme numéro";
    $msgExpPro = "de l'expérience professionnelle numéro";

    /**
     * Création du tableau d'options
     *
     * Ce tableau est organisé comme cela :
     *
     * [champATraiter]['filter'] : Le filtre à appliquer pour la vérification ou le nettoyage du champ
     * [champATraiter]['options'] : Les options du filtre
     * [champATraiter]['boolean'] : Indique si le champ est un booléen (= checkbox)
     * [champATraiter]['optionnel'] : Indique si le champ est optionnel
     * [champATraiter]['neDoitPasEtreVerifie'] : Indique si le champ ne doit pas être vérifié
     * [champATraiter]['msgVide'] : Message à indiquer si le champ est vide
     * [champATraiter]['msgErreur'] : Message à indiquer si le champ ne passe pas le validage
     *
     * Notes :
     * - L'option 'neDoitPasEtreVerifie' ne s'applique qu'aux champs date_fin_expX
     * et est vrai si le champ enCours_expX correspondant est à vrai
     * - Seuls les champ obligatoires (hormis les checkbox)
     * prennent un message en cas de champ vide
     * - Les champs de type texte ne prennent pas de messages d'erreur
     * car ils ne sont que nettoyés, et non pas vérifiés
     * - Les checkbox non plus car leur type est booléen
     * (Pour être exact : "on"/Ø transformé en true/false)
     */
    // On gère d'abord les infos contenues dans l'onglet 'Informations personnelles'
    $options = array(
        'idProfil' => $optionId,
        'visi_photo' => $optionBoolean,
        'supprimer_photo' => $optionBoolean,
        'visi_date_naiss' => $optionBoolean,
        'date_naiss' => $optionDate,
        'visi_email' => $optionBoolean,
        'email' => $optionEmail,
        'visi_page' => $optionBoolean,
        'page' => $optionURL,
    );

    $options['visi_photo']['booleen'] = true;

    $options['supprimer_photo']['booleen'] = true;

    $options['visi_date_naiss']['booleen'] = true;

    $options['date_naiss']['msgErreur'] = "La date de naissance $msgFormat";
    $options['date_naiss']['optionnel'] = true;

    $options['visi_email']['booleen'] = true;

    $options['email']['msgVide'] = "$msgVideBase Email";
    $options['email']['msgErreur'] = "L'email n'est pas correct";

    $options['visi_page']['booleen'] = true;

    $options['page']['msgErreur'] = "L'adresse de la page perso doit être correcte et commencer par \"http://\" ou \"https://\"";
    $options['page']['optionnel'] = true;

    // Puis les infos contenues dans l'onglet 'Parcours scolaire'
    for ($i = 1; $i <= $_POST['nbDiplomes']; $i++) {
        $options["id_dip$i"] = $optionId;

        $options["visi_dip$i"] = $optionBoolean;
        $options["visi_dip$i"]['booleen'] = true;

        $options["annee_dip$i"] = $optionAnnee;
        $options["annee_dip$i"]['msgVide'] = "$msgVideBase Année $msgDiplome $i";
        $options["annee_dip$i"]['msgErreur'] = "L'Année $msgDiplome $i doit être comprise entre 1900 et 2100";

        $options["type_dip$i"] = $optionString;
        $options["type_dip$i"]['msgVide'] = "$msgVideBase Type $msgDiplome $i";

        $options["disc_dip$i"] = $optionString;
        $options["disc_dip$i"]['msgVide'] = "$msgVideBase Discipline $msgDiplome $i";

        $options["etabli_dip$i"] = $optionString;
        $options["etabli_dip$i"]['msgVide'] = "$msgVideBase Établissement $msgDiplome $i";
    }

    // Et enfin les infos contenues dans l'onglet 'Parcours professionnel'
    for ($i = 1; $i <= $_POST['nbExpPros']; $i++) {
        $options["id_exp$i"] = $optionId;

        $options["visi_exp$i"] = $optionBoolean;
        $options["visi_exp$i"]['booleen'] = true;

        $options["date_deb_exp$i"] = $optionDate;
        $options["date_deb_exp$i"]['msgVide'] = "$msgVideBase Date de début $msgExpPro $i";
        $options["date_deb_exp$i"]['msgErreur'] = "La Date de début $msgExpPro $i $msgFormat";

        $options["date_fin_exp$i"] = $optionDate;
        $options["date_fin_exp$i"]['msgVide'] = "$msgVideBase Date de fin $msgExpPro $i";
        $options["date_fin_exp$i"]['msgErreur'] = "La Date de fin $msgExpPro $i $msgFormat";

        $options["enCours_exp$i"] = $optionBoolean;
        $options["enCours_exp$i"]['booleen'] = true;

        $options["inti_exp$i"] = $optionString;
        $options["inti_exp$i"]['msgVide'] = "$msgVideBase Intitulé $msgExpPro $i";

        $options["entre_exp$i"] = $optionString;
        $options["entre_exp$i"]['msgVide'] = "$msgVideBase Entreprise $msgExpPro $i";

        $options["ville_exp$i"] = $optionString;
        $options["ville_exp$i"]['msgVide'] = "$msgVideBase Ville $msgExpPro $i";

        $options["dep_exp$i"] = $optionString;
        $options["dep_exp$i"]['msgVide'] = "$msgVideBase Déparatement $msgExpPro $i";

        $options["visi_salaire_exp$i"] = $optionBoolean;
        $options["visi_salaire_exp$i"]['booleen'] = true;

        $options["salaire_exp$i"] = $optionString;
        $options["salaire_exp$i"]['msgVide'] = "$msgVideBase Salaire $msgExpPro $i";
    }

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

    // On détermine si on doit vérifier date_fin_expX en fonction de enCours_expX
    for ($i = 1; $i <= $_POST['nbExpPros']; $i++) {
        if ($resultat["enCours_exp$i"]) {
            $options["date_fin_exp$i"]['neDoitPasEtreVerifie'] = true;
        }
    }

    // Nombre d'erreurs et concaténation de tous les messages d'erreurs
    $nbErreurs = 0;
    $_SESSION['erreurs_profil'] = "";

    // On parcourt les champs voulus
    foreach ($options as $cle => $valeur) {
        if (!$options[$cle]['optionnel'] // Si le champ n'est pas optionnel (= obligatoire)
                && !$options[$cle]['booleen'] // Et qu'il n'est pas un booléen
                && !$options[$cle]['neDoitPasEtreVerifie'] // Et qu'il doit être vérifié
                && empty($resultat[$cle])) { // Et qu'il est vide
            $_SESSION['erreurs_profil'] .= $options[$cle]['msgVide'] . ". (1 : $cle)<br />\n";
            $nbErreurs++;
        } elseif (!$options[$cle]['booleen'] // Si le champ n'est pas un booléen
                && $resultat[$cle] === false) { // Et qu'il n'est pas valide
            $_SESSION['erreurs_profil'] .= $options[$cle]['msgErreur'] . ". (2 : $cle)<br />\n";
            $nbErreurs++;
        }
    }

    $presenceFichier = false;

    if (isset($_FILES['photo'])) {
        // Vérification du fichier uploadé
        switch ($_FILES['photo']['error']) {
            case UPLOAD_ERR_OK:
                $presenceFichier = true;
            case UPLOAD_ERR_NO_FILE:
                /**
                 * Si il n'y a pas de fichier ou que le fichier est bien uploadé,
                 * on ne fait rien
                 */
                break;

            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $_SESSION['erreurs_profil'] .= "Fichier trop grand !<br />\n";
                $nbErreurs++;
                break;

            case UPLOAD_ERR_PARTIAL:
                $_SESSION['erreurs_profil'] .= "Fichier reçu partiellement !<br />\n";
                $nbErreurs++;
                break;

            default:
                $_SESSION['erreurs_profil'] .= "Erreur avec le fichier !<br />\n";
                $nbErreurs++;
                break;
        }
    }

    // S'il y a au moins une erreur, on se redirige vers le formulaire
    if ($nbErreurs != 0) {
        header("Location: $fichierRetour");
        exit;
    }

    // Si l'utilisateur a envoyé une photo
    if ($presenceFichier) {
        // Tableau des extensions autorisées
        $extensionsAutorisees = array(
            'jpg',
            'jpeg',
            'png',
            'gif',
            'bmp'
        );

        // On extrait l'extension du fichier uploadé
        $extension_upload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));

        if (in_array($extension_upload, $extensionsAutorisees)) {
            // L'extension est bonne, on ne fait rien
        } else {
            $_SESSION['erreurs_profil'] .= "Mauvaise extension, seul les fichiers images sont acceptés (jpg, jpeg, png, gif, bmp) !<br />\n";

            // Suppression du fichier temporaire
            supprimerFichierTemp($_FILES['photo']['tmp_name'], "profil");

            // Redirection
            header("Location: $fichierRetour");
            exit;
        }

        /*
         * Préparation du nouveau nom du fichier,
         * basé sur un identifiant unique
         */
        $nom = "../images/profil/" . uniqid() . ".$extension_upload";

        if (rename($_FILES['photo']['tmp_name'], $nom)) {
            // Le renommage s'est bien passé, on ne fait rien
        } else {
            $_SESSION['erreurs_profil'] .= "Erreur lors du renommage<br />\n";

            // Suppression du fichier temporaire
            supprimerFichierTemp($_FILES['photo']['tmp_name'], "profil");

            // Redirection
            header("Location: $fichierRetour");
            exit;
        }
    }

    // Création d'un ProfilManager pour l'insertion
    $profilManager = new ProfilManager(ConnexionBD::getInstance()->getBDD());

    // Photo par défaut
    $photoDefault = "photo_profil_default.jpg";

    // Photo actuelle
    $photoActuelle = $profilManager->getProfil($resultat['idProfil'])->getCheminPhoto();

    // Choix pour la photo
    if ($presenceFichier) { // Si l'utilisateur veut changer sa photo
        // On supprime l'ancienne si elle est différente de la photo par défaut
        if (!strcmp($photoActuelle, $photoDefault) == 0) {
            unlink("../images/profil/$photoActuelle");
        }

        // On la remplace par la nouvelle
        $photo = substr(strrchr($nom, '/'), 1);
    } else if ($resultat['supprimer_photo']) { // Si l'utilisateur veut supprimer sa photo
        // On supprime l'ancienne si elle est différente de la photo par défaut
        if (!strcmp($photoActuelle, $photoDefault) == 0) {
            unlink("../images/profil/$photoActuelle");
        }

        // On la remplace par celle par défaut
        $photo = $photoDefault;
    } else { // Si l'utilisateur veut garder sa photo
        // On la garde
        $photo = $photoActuelle;
    }

    // Création du tableau de données du Profil
    $donneesProfil = array(
        'codePe' => $_SESSION['personneCo']->getCodePe(),
        'visibiliteEmail' => $resultat['visi_email'] ? 1 : 0,
        'dateNaissance' => $resultat['date_naiss'],
        'visibiliteDateNaissance' => $resultat['visi_date_naiss'] ? 1 : 0,
        'cheminPhoto' => $photo,
        'visibilitePhoto' => $resultat['visi_photo'] ? 1 : 0,
        'pagePerso' => $resultat['page'],
        'visibilitePagePerso' => $resultat['visi_page'] ? 1 : 0
    );

    // Ajout des diplômes
    $donneesDiplomes = array();
    for ($i = 1; $i <= $_POST['nbDiplomes']; $i++) {
        $donneesDiplomes[] = new Diplome(array(
            'codeDi' => $resultat["id_dip$i"],
            'visibilite' => $resultat["visi_dip$i"] ? 1 : 0,
            'annee' => $resultat["annee_dip$i"],
            'type' => $resultat["type_dip$i"],
            'discipline' => $resultat["disc_dip$i"],
            'etablissement' => $resultat["etabli_dip$i"]
        ));
    }
    $donneesProfil['diplomes'] = $donneesDiplomes;

    // Ajout des expériences professionnelles
    $donneesExpPros = array();
    for ($i = 1; $i <= $_POST['nbExpPros']; $i++) {
        $donneesExpPros[] = new ExpPro(array(
            'codeEP' => $resultat["id_exp$i"],
            'visibilite' => $resultat["visi_exp$i"] ? 1 : 0,
            'dateDebut' => $resultat["date_deb_exp$i"],
            'dateFin' => $resultat["date_fin_exp$i"],
            'enCours' => $resultat["enCours_exp$i"] ? 1 : 0,
            'intitule' => $resultat["inti_exp$i"],
            'entreprise' => $resultat["entre_exp$i"],
            'ville' => $resultat["ville_exp$i"],
            'departement' => $resultat["dep_exp$i"],
            'salaire' => $resultat["salaire_exp$i"],
            'visibiliteSalaire' => $resultat["visi_salaire_exp$i"] ? 1 : 0
        ));
    }
    $donneesProfil['expPros'] = $donneesExpPros;

    // Update des nouvelles données dans la BD
    if (!$profilManager->updateProfil(new Profil($donneesProfil))) {
        $_SESSION['erreurs_profil'] .= "Erreur de l'insertion dans la BD<br />\n";

        // Suppression du fichier temporaire
        supprimerFichierTemp($nom, "profil");

        // Redirection
        header("Location: $fichierRetour");
        exit;
    }

    // Tout s'est bien passé, message de réussite et redirection
    unset($_SESSION['erreurs_profil']);
    $_SESSION['sortie_profil'] = "La mise à jour de votre profil a été effectuée avec succès<br />\n";
    header("Location: $fichierRetour");
?>
