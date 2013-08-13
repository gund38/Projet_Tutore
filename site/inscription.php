<?php
    /**
     * Page d'inscription
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    // Inclusion et appel de la fonction d'en-tête
    require_once 'fonctions/header.php';
    enTete(false);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8" />

        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/design.css" />

        <!-- Scripts pour la vérification de la force et de l'exactitude du mdp -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.passMeter.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.identical.js" type="text/javascript" charset="utf-8"></script>

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
                    <h3>S'inscrire sur le site</h3>

                    <p>Utilisez ce formulaire pour vous inscrire sur le site.</p>

                    <p>
                        <small>Les champs marqués par <span class="obligatoire">*</span> sont obligatoires.</small>
                    </p>

                    <br /><br />

                    <fieldset style="width: 900px;">
                        <legend>Inscription</legend>

                        <form action="" method="post">
                            <table cellpadding="10px">
                                <tr align="center">
                                    <td>
                                        <label for="prenom">Prénom&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="prenom" id="prenom" />
                                    </td>
                                    <td>
                                        <label for="nom">Nom&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="nom" id="nom" />
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td>
                                        <label for="email">Email&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="email" id="email" />
                                    </td>
                                    <td>
                                        <label for="login">Login&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="login" id="login" />
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td>
                                        <label for="mdp">Mot de passe&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td>
                                        <input type="password" name="mdp" id="mdp" />
                                        <div id="result">Force du mot de passe : -</div>
                                    </td>
                                    <td>
                                        <label for="mdp2">Répétez le mot de passe&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                                    </td>
                                    <td>
                                        <input type="password" name="mdp2" id="mdp2" />
                                        <div id="resultat">Les mots de passe ne sont pas identiques</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: center;">
                                        <input type="submit" value="S'inscrire" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                </center>
            </div>
        </div>
        <script type="text/javascript" charset="utf-8">
            $.passMeter({
                // Config local
                'inputPass'     :   '#mdp',
                'localResult'   :   '#result',
                // Msg level pass
                'veryLow'   :   'Très faible',
                'low'       :   'Faible',
                'good'      :   'Bon',
                'strong'    :   'Fort'
            });
        </script>
        <script type="text/javascript" charset="utf-8">
            $.identical({
                // Champs
                'mdpBase'       :   '#mdp',
                'mdpVerif'      :   '#mdp2'
            });
        </script>
    </body>
</html>
