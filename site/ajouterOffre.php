<?php
    session_start();

    function chargerClasse($classe) {
        require_once 'class/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions.php';

    supprimerMessageAvertissement();
    $fichierRetour = "ajouter_offre.php";
    $nbTabs = 5;
    $nbRetours = 1;

//    print_r($_FILES);
//    echo "<br />";
//    print_r($_POST);
//    echo "<br /><br />";

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

//    $resultat = filter_input_array(INPUT_POST, $options);
    foreach ($options as $cle => $valeur) {
        $resultat[$cle] = filter_var($_POST[$cle], $valeur['filter'], $valeur['flags']);
    }

//    print_r($resultat);
//    echo "<br /><br />";
//

    $messageErreur = array(
        'intitule' => "",
        'entreprise' => "",
        'ville' => "",
        'remuneration' => "Le salaire doit être un entier ou un nombre à 1 ou 2 décimales positif (le séparateur peut être une virgule ou un point)"
    );

    $nbrErreurs = 0;
    $_SESSION['erreurs'] = "";

    foreach ($options as $cle => $valeur) { //Parcourir tous les champs voulus.
        if (empty($_POST[$cle])) { //Si le champ est vide.
            $_SESSION['erreurs'] .= indenter("Veuillez remplir le champ " . $cle . ".<br />", $nbTabs, $nbRetours);
            $nbrErreurs++;
        } elseif ($resultat[$cle] === false) { //S'il n'est pas valide.
            $_SESSION['erreurs'] .= indenter($messageErreur[$cle] . "<br />", $nbTabs, $nbRetours);
            $nbrErreurs++;
        }
    }

//        echo $_FILES['fichier']['error'];
    switch ($_FILES['fichier']['error']) {
        case UPLOAD_ERR_OK:
//                echo "Upload OK !<br />";
            break;

        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $_SESSION['erreurs'] .= indenter("Fichier trop grand !<br />", $nbTabs, $nbRetours);
//                die();
            $nbrErreurs++;
            break;

        case UPLOAD_ERR_PARTIAL:
            $_SESSION['erreurs'] .= indenter("Fichier reçu partiellement !<br />", $nbTabs, $nbRetours);
//                die();
            $nbrErreurs++;
            break;

        case UPLOAD_ERR_NO_FILE:
            $_SESSION['erreurs'] .= indenter("Pas de fichier !<br />", $nbTabs, $nbRetours);
//                die();
            $nbrErreurs++;
            break;

        default:
            $_SESSION['erreurs'] .= indenter("Erreur avec le fichier !<br />", $nbTabs, $nbRetours);
//                die();
            $nbrErreurs++;
            break;
    }

    if ($nbrErreurs != 0) {
        header("Location: $fichierRetour");
        die();
    }

    $extension_upload = strtolower(substr(strrchr($_FILES['fichier']['name'], '.'), 1));

    if (strcmp($extension_upload, "pdf") == 0) {
//        echo "Extension OK !<br />";
    } else {
        $_SESSION['erreurs'] .= indenter("Mauvaise extension, seul les fichiers PDF sont acceptés !<br />", $nbTabs, $nbRetours);
        supprimerFichierTemp();
        header("Location: $fichierRetour");
        die();
    }

    $nom = "pdf/" . uniqid() . ".pdf";

    if (rename($_FILES['fichier']['tmp_name'], $nom)) {
//        echo "Rename réussi<br />";
    } else {
        $_SESSION['erreurs'] .= indenter("Fail du rename<br />", $nbTabs, $nbRetours);
        supprimerFichierTemp();
        header("Location: $fichierRetour");
        die();
    }

    echo "Si je m'affiche, c'est que tout est OK !!!";

    function supprimerFichierTemp() {
        if (unlink($_FILES['fichier']['tmp_name'])) {
//            echo "Suppression réussie<br />";
        } else {
            $_SESSION['erreurs'] .= indenter("Fail de la suppression<br />", 5, 1);
            header("Location: ajouter_offre.php");
            die();
        }
    }

?>
