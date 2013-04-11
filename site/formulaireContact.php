<?php
    session_start();

    $_SESSION['erreur'] = NULL; //pour evite un bug lorsque tous champs sont remplies, on rentre pas dans le else
    $_SESSION['info'] = NULL;

    // adresse email jetable => http://www.yopmail.com/ pseudo => admin_masterti
    // On teste si la variable email et message sont vide
    if (!empty($_POST['email']) AND !empty($_POST['message'])) {
        extract($_POST); //transforme $_POST['email'] en $email, pareil pour message

        if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
            $email = htmlspecialchars(addslashes($email)); // htmlspecialchars et addslashes pour protéger les variables
            $message = htmlspecialchars(addslashes($message));
            $destinataire = "admin_masterti@yopmail.com";
            $sujet = "Formulaire de contact";
            $entete = 'From : ' . $email . '';
            $message = '' . "\n" . ' Site : Anciens Etudiants  ' . "\n" . ' Message : ' . $message . '';

            //mail($destinataire, $sujet, $message, $entete);
            $_SESSION['info'] = "Votre email à été envoyé";
            unset($_POST, $message, $email);
        } else {
            $_SESSION['erreur'] = "Adresse email invalide";
        }

        header("Location: contact.php");
        exit;
    }
    //Si les champs n'ont pas été correctement remplie, on envoie un message d'erreur
    else {
        $_SESSION['erreur'] = "Veuillez remplir tous les champs";
        header("Location: contact.php");
        exit;
    }
?>
