<?php

    // Chargement des fichiers de classes et de fonctions
    function chargerClasse($classe) {
        require_once 'classes/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions/fonctions.php';

    // Démarrage de la session
    session_start();

    if (!verifierAcces(__FILE__)) {
        header("Location: index.php");
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
    <?php
//        include 'formulaire.php';
        /*         * ************ //Design pour formulaire de contact
          label {
          display:block;
          width:150px;
          float:left;
          text-align:left;
          padding-right:5px;
          margin-bottom:2px;
          }
          fieldset
          {
          border: solid 1px #222;
          }
          fieldset legend
          {
          padding: 0 10px;
          border-left: #222 1px solid;
          border-right: #222 1px solid;
          font-size: 1.2em;
          color: #222;
          }
          #formulaire_contact textarea
          {
          width:180px;
          height:150px;
          }
         */
    ?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />
        <link rel="stylesheet" href="css/contact.css" />
        <title>Site Web des Anciens Étudiants du Master TI</title>
    </head>

    <body>
        <div id="global">
            <div id="entete">
                <h1>Site Web des Anciens Étudiants du Master TI</h1>
            </div>
            <?php
                // Appel dynamique du menu selon l'identité de la personne
                afficherMenu();
            ?>
            <div id="contenu">

                <form  action="fonctions/formulaireContact.php" method="post">

                    <fieldset>

                        <legend>Formulaire de contact</legend>
                        </br>
                        <label for="label_message">Votre message :</label>
                        <textarea name="message" rows="8" cols="45" id="label_message" placeholder="Taper votre texte.">
                            <?php
                                if (isset($_POST['message']))
                                    echo htmlspecialchars($_POST['message']);
                            ?>
                        </textarea>
                        <br />
                        <label for ="label_email">Votre email :</label>
                        <input type="text" name="email" id="label_email"
                               value="
                               <?php
                                   if (isset($_POST['email']))
                                       echo htmlspecialchars($_POST['email']);
                               ?>"
                               placeholder="truc@truc.truc"/>
                        <br />
                        <br />
                        <input type="submit" value="Envoyer" />
                        <span style="color:red;">
                            <?php
                                if (isset($_SESSION['erreur']))
                                    echo $_SESSION['erreur'];
                            ?>
                        </span>
                        <span style="color:green">
                            <?php
                                if (isset($_SESSION['info']))
                                    echo $_SESSION['info'];
                            ?>
                        </span>

                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>
