<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body></body>

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
    $nbErreurs = 0;
    $_SESSION['erreurs_connexion'] = "";

    // Vérification que les variables ne soient pas vides
    /**
     * @TODO modifier ce test en test générique
     */
//    if (empty($_POST['login'])) {
//        $_SESSION['erreurs_connexion'] .= "Veuillez remplir le champ Login.<br />\n";
//        $nbErreurs++;
//    }
//    if (empty($_POST['mdp'])) {
//        $_SESSION['erreurs_connexion'] .= "Veuillez remplir le champ Mot de passe.<br />\n";
//        $nbErreurs++;
//    }

    /**
     * Création des options pour la vérification et
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

    // Création du tableau d'options
    $options = array(
        'visi_photo' => $optionBoolean,
        'visi_date_naiss' => $optionBoolean,
        'date_naiss' => $optionDate,
        'visi_email' => $optionBoolean,
        'email' => $optionEmail,
        'visi_page' => $optionBoolean,
        'page' => $optionURL,
    );

    for ($i = 1; $i <= $_POST['nbDiplomes']; $i++) {
        $options["visi_dip$i"] = $optionBoolean;
        $options["annee_dip$i"] = $optionAnnee;
        $options["type_dip$i"] = $optionString;
        $options["disc_dip$i"] = $optionString;
        $options["etabli_dip$i"] = $optionString;
    }

    for ($i = 1; $i <= $_POST['nbExpPros']; $i++) {
        $options["visi_exp$i"] = $optionBoolean;
        $options["date_deb_exp$i"] = $optionDate;
        $options["date_fin_exp$i"] = $optionDate;
        $options["enCours_exp$i"] = $optionBoolean;
        $options["inti_exp$i"] = $optionString;
        $options["entre_exp$i"] = $optionString;
        $options["ville_exp$i"] = $optionString;
        $options["dep_exp$i"] = $optionString;
        $options["visi_salaire_exp$i"] = $optionBoolean;
        $options["salaire_exp$i"] = $optionString;
    }

    /*
     * Application des options pour chaque champ du formulaire
     *
     * Note : on pourrait utiliser la fonction filter_var_array(),
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


//$nbErreurs++;

    if ($nbErreurs != 0) {
        header("Location: $fichierRetour");
        exit;
    }

    foreach ($_POST as $key => $value) {
        echo "$key = $value<br />\n";
    }

    echo "<br /><br />\n\n\n";
    foreach ($resultat as $key => $value) {
        echo "$key = $value<br />\n";
    }

    echo "<br /><br />\n\n\n";
    var_dump($resultat);
?>
