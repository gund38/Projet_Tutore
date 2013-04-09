<?php

    session_start();

    function chargerClasse($classe) {
        require_once 'class/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions.php';

    supprimerMessageAvertissement();

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
        'remuneration' => "Le salaire doit &ecirc;tre un entier ou un nombre &agrave; 1 ou 2 d&eacute;cimales positif (le s&eacute;parateur peut &ecirc;tre une virgule ou un point)"
    );

    $nbrErreurs = 0;
    $_SESSION['erreurs'] = "";

    foreach ($options as $cle => $valeur) { //Parcourir tous les champs voulus.
        if (empty($_POST[$cle])) { //Si le champ est vide.
            $_SESSION['erreurs'] .= "Veuillez remplir le champ " . $cle . ".<br/>";
            $nbrErreurs++;
        } elseif ($resultat[$cle] === false) { //S'il n'est pas valide.
            $_SESSION['erreurs'] .= $messageErreur[$cle] . "<br />";
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
            $_SESSION['erreurs'] .= "Fichier trop grand !<br />";
//                die();
            $nbrErreurs++;
            break;

        case UPLOAD_ERR_PARTIAL:
            $_SESSION['erreurs'] .= "Fichier reçu partiellement !<br />";
//                die();
            $nbrErreurs++;
            break;

        case UPLOAD_ERR_NO_FILE:
            $_SESSION['erreurs'] .= "Pas de fichier !<br />";
//                die();
            $nbrErreurs++;
            break;

        default:
            $_SESSION['erreurs'] .= "Erreur avec le fichier !<br />";
//                die();
            $nbrErreurs++;
            break;
    }

    if ($nbrErreurs != 0) {
        header("Location: index.php");
        die();
    }

    $extension_upload = strtolower(substr(strrchr($_FILES['fichier']['name'], '.'), 1));

    if (strcmp($extension_upload, "pdf") == 0) {
//        echo "Extension OK !<br />";
    } else {
        $_SESSION['erreurs'] .= "Mauvaise extension, seul les fichiers PDF sont accept&eacute;s !<br />";
        supprimerFichierTemp();
        header("Location: index.php");
        die();
    }

    $nom = "pdf/" . uniqid() . ".pdf";

    if (rename($_FILES['fichier']['tmp_name'], $nom)) {
//        echo "Rename r&eacute;ussi<br />";
    } else {
        $_SESSION['erreurs'] .= "Fail du rename<br />";
        supprimerFichierTemp();
        header("Location: index.php");
        die();
    }

    echo "Si je m'affiche, c'est que tout est OK !!!";

    function supprimerFichierTemp() {
        if (unlink($_FILES['fichier']['tmp_name'])) {
//            echo "Suppression r&eacute;ussie<br />";
        } else {
            $_SESSION['erreurs'] .= "Fail de la suppression<br />";
            header("Location: index.php");
            die();
        }
    }

?>
