<?php
    /**
     * Page de contact
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    // Inclusion et appel de la fonction d'en-tête
    require_once 'fonctions/header.php';
    enTete(true);
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
                <center>
                    <h3>Contact</h3>

                    <p>
                        Vous pouvez utiliser le formulaire suivant afin de contacter l'administrateur pour lui signaler une erreur, un problème ou un bug,<br />
                        ainsi que lui demander la modification ou suppression de votre compte ou tout autre chose.
                    </p>

                    <p>
                        <small>Les champs marqués par <span class="obligatoire">*</span> sont obligatoires.</small>
                    </p>

                    <p class="erreur">
                        <?php
                            if (isset($_SESSION['erreur']))
                                echo $_SESSION['erreur'];
                        ?>
                    </p>

                    <p class="sortie">
                        <?php
                            if (isset($_SESSION['info']))
                                echo $_SESSION['info'];
                        ?>
                    </p>

                    <br /><br />

                    <fieldset>
                        <legend>Formulaire de contact</legend>

                        <form action="fonctions/formulaireContact.php" method="post">
                            <table>
                                <tr>
                                    <td>
                                        <label for="label_message">Votre message&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td>
                                        <textarea name="message" id="label_message" rows="8" cols="45" placeholder="Tapez votre message"
                                                  ><?php if (isset($_POST['message'])) { echo htmlspecialchars($_POST['message']); } ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for ="label_email">Votre email&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="email" id="label_email"
                                               value="<?php if (isset($_POST['email'])) { echo htmlspecialchars($_POST['email']); } ?>"
                                               placeholder="truc@truc.truc" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <input type="submit" value="Envoyer" />
                                    </td>
                            </table>
                        </form>
                    </fieldset>
                </center>
            </div>
        </div>
    </body>
</html>
