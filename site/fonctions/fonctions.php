<?php
    /**
     * Ce fichier contient une grande partie de
     * toutes les fonctions utilisées par le site
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    /**
     * Retourne la liste des départements depuis la BD
     *
     * @return array
     */
    function listeDepartements() {
        // Récupératon de la connexion à la BD
        $bdd = ConnexionBD::getInstance()->getBDD();

        $req = $bdd->query('SELECT codeDe, codePostal, nom
            FROM Departement
            ORDER BY codeDE');

        $liste = array();

        // On ajoute les données récupérées au tableau
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $liste[] = array(
                'codeDe' => $donnees['codeDe'],
                'nom' => $donnees['codePostal'] . " - " . $donnees['nom']
            );
        }

        return $liste;
    }

    /**
     * Retourne les infos du département souhaité
     *
     * @param int $codeDe Le code du département souhaité
     * @return array
     */
    function infosDepartement($codeDe) {
        // Récupératon de la connexion à la BD
        $bdd = ConnexionBD::getInstance()->getBDD();

        $requete = 'SELECT codePostal, nom
            FROM Departement
            WHERE codeDe = :codeDe';

        $req = $bdd->prepare($requete);
        $req->execute(array(
            'codeDe' => $codeDe
        ));

        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        return $resultat;
    }

    /**
     * Retourne la liste des types de diplôme depuis la BD
     *
     * @return array
     */
    function listeTypesDiplome() {
        // Récupératon de la connexion à la BD
        $bdd = ConnexionBD::getInstance()->getBDD();

        $req = $bdd->query("SHOW COLUMNS
            FROM Diplome
            LIKE 'type'");

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        /*
         * La chaîne reçue est de la forme "enum('Licence','Master',...)"
         * On enlève donc les 6 premiers et les 2 derniers caractères
         * avant de découper la chaîne selon le caratère ','
         */
        $liste = explode("','", substr($donnees['Type'], 6, -2));

        return $liste;
    }

    /**
     * Retourne la liste des tranches de salaire depuis la BD
     *
     * @return array
     */
    function listeTranchesSalaire() {
        // Récupératon de la connexion à la BD
        $bdd = ConnexionBD::getInstance()->getBDD();

        $req = $bdd->query("SHOW COLUMNS
            FROM ExpPro
            LIKE 'salaire'");

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        /*
         * La chaîne reçue est de la forme "enum('< 25000 €','Entre 25000 € et 30000 €',...)"
         * On enlève donc les 6 premiers et les 2 derniers caractères
         * avant de découper la chaîne selon le caratère ','
         */
        $liste = explode("','", substr($donnees['Type'], 6, -2));

        return $liste;
    }

    /**
     * Retourne la liste des types d'offre depuis la BD
     *
     * @return array
     */
    function listeTypesOffre() {
        // Récupératon de la connexion à la BD
        $bdd = ConnexionBD::getInstance()->getBDD();

        $req = $bdd->query("SHOW COLUMNS
            FROM Offre
            LIKE 'type'");

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        /*
         * La chaîne reçue est de la forme "enum('Emploi','Stage')"
         * On enlève donc les 6 premiers et les 2 derniers caractères
         * avant de découper la chaîne selon le caratère ','
         */
        $liste = explode("','", substr($donnees['Type'], 6, -2));

        return $liste;
    }

    /**
     * Retourne le min et le max des promos
     *
     * @return array
     */
    function minMaxPromos() {
        // Récupératon de la connexion à la BD
        $bdd = ConnexionBD::getInstance()->getBDD();

        $req = $bdd->query("SELECT MIN(promo) AS min, MAX(promo) AS max
            FROM Profil");

        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        return $resultat;
    }

    /**
     * Expression régulière pour vérifier les nombres entiers
     * ou décimaux à 1 ou 2 décimales positifs
     *
     * @param mixed $floatATester Présumé float ou int à tester
     * @return float|int|false float ou int si $floatATester est correct, false sinon
     */
    function validerFloat($floatATester) {
        return preg_match('/^[0-9]+((,|.)[0-9]{1,2})?$/', $floatATester) ? $floatATester : false;
    }

    /**
     * Fonction pour vérifier les dates
     * au format français (dd/mm/YYYY)
     *
     * @param string $dateATester Présumée date à tester
     * @return string|false string si $dateATester est correcte, false sinon
     */
    function validerDateFR($dateATester) {
        if (empty ($dateATester)) {
            return $dateATester;
        }

        if (!preg_match('#^([0-9]{2}/){2}[0-9]{4}$#', $dateATester)) {
            return false;
        }

        $dateParsed = strptime($dateATester, "%d/%m/%Y");

        if (!$dateParsed) {
            return false;
        }

        if (!checkdate($dateParsed['tm_mon'] + 1, $dateParsed['tm_mday'], $dateParsed['tm_year'] + 1900)) {
            return false;
        }

        return $dateATester;
    }

    /**
     * Fonction pour vérifier les URL (HTTP ou HTTPS)
     *
     * @param string $URLATester Présumée URL à tester
     * @return string|false string si $URLATester est correcte, false sinon
     */
    function validerURL($URLATester) {
        if (empty ($URLATester)) {
            return $URLATester;
        }

        if (!preg_match('#^http://#', $URLATester) &&
                !preg_match('#^https://#', $URLATester)) {
            return false;
        }

        if (!filter_var($URLATester, FILTER_VALIDATE_URL)) {
            return false;
        }

        return $URLATester;
    }

    /**
     * Teste les identifiants et retourne vrai s'ils existent,
     * faux sinon
     *
     * @param type $login Login de la personne
     * @param type $pass Mot de passe de la personne
     * @return boolean
     */
    function login($login, $pass) {
        // Récupération de la connexion à la BD
        $bdd = ConnexionBD::getInstance()->getBDD();

        // Préparation de la requête
        $req = $bdd->prepare('SELECT codePe
            FROM Personne
            WHERE login = :login AND mdp = :mdp');

        // Exécution de la requête
        $req->execute(array(
            'login' => $login,
            'mdp' => $pass
        ));

        $reponse = false;

        // Création du managerPersonne
        $manager = new PersonneManager($bdd);

        // S'il y a un résultat, on enregistre la Personne
        while ($donnees = $req->fetch()) {
            $_SESSION['personneCo'] = $manager->getPersonne($donnees['codePe']);

            $reponse = true;
        }

        return $reponse;
    }

    /**
     * Fonction de suppression du fichier temporaire uploadé
     *
     * @param string $fichier Chemin du fichier à supprimer
     * @param string $fonction Fonction qui a appelée celle-ci
     */
    function supprimerFichierTemp($fichier, $fonction) {
        if (unlink($fichier)) {
            // La suppression s'est bien passé, on ne fait rien
        } else {
            $_SESSION["erreurs_$fonction"] .= "Erreur lors de la suppression du fichier temporaire<br />\n";
        }
    }

    /**
     * Affiche le menu correspondant à l'indentité de l'utilisateur
     */
    function afficherMenu() {
        if (!isset($_SESSION['personneCo'])) {
            require_once 'menus/menu_V.php';
        } else {
            switch ($_SESSION['personneCo']->getType()) {
                case "Enseignant":
                    require_once 'menus/menu_enseignant.php';
                    break;
                case "Etudiant":
                    require_once 'menus/menu_E.php';
                    break;
                case "Ancien_etudiant":
                    require_once 'menus/menu_AE.php';
                    break;
                case "Administrateur":
                    require_once 'menus/menu_admin.php';
                    break;
                default:
                    echo "Erreur lors de l'inclusion du menu";
            }
        }
    }

    /**
     * Vérifie qu'un utilisateur a le droit d'accéder à une page
     *
     * @param string $scriptName Le nom du script qui doit être vérifié
     * @return boolean
     */
    function verifierAcces($scriptName) {
        // On récupère le nom de la page appelante
        $scriptName = substr(strrchr($scriptName, '/'), 1);

        /**
         * On récupère l'identité de l'utilisateur
         * Si celui-ci n'est pas connecté, c'est un Visiteur
         */
        if (isset($_SESSION['personneCo'])) {
            $identite = $_SESSION['personneCo']->getType();
        } else {
            $identite = "Visiteur";
        }

        /**
         * Tableau des droits
         *
         * NOTE : Certaines pages ne sont pas indiquées,
         * notamment index.php (car tout le monde y a accès),
         * login.php (car c'est la page vers laquelle on est redirigé)
         * et les pages de fonctions (comme connexion.php ou deconnexion.php,
         * qui ne sont pas soumises à cette vérification)
         */
        $scriptsAutorises = array(
            'Visiteur' => array(
                'recherche_offres.php',
                'contact.php'
            ),
            'Etudiant' => array(
                'recherche_profil.php',
                'profil_public.php',
                'recherche_offres.php',
                'contact.php'
            ),
            'Ancien_etudiant' => array(
                'profil.php',
                'recherche_profil.php',
                'profil_public.php',
                'recherche_offres.php',
                'ajout_offre.php',
                'contact.php'
            ),
            'Enseignant' => array(
                'recherche_profil.php',
                'profil_public.php',
                'recherche_offres.php',
                'ajout_offre.php',
                'statistiques.php',
                'contact.php'
            ),
            'Administrateur' => array(
                'admin.php',
                'recherche_profil.php',
                'profil_public.php',
                'recherche_offres.php',
                'ajout_offre.php',
                'statistiques.php'
            )
        );

        $autorise = false;

        /**
         * On parcourt le tableau pour savoir si l'utilisateur a les droits
         * Si oui, on sort de la boucle
         */
        foreach ($scriptsAutorises[$identite] as $value) {
            if (strcmp($scriptName, $value) === 0) {
                $autorise = true;
                break;
            }
        }

        return $autorise;
    }

    /**
     * Supprime l'avertissement du navigateur
     * lors du renvoi d'un formulaire
     */
    function supprimerMessageAvertissement() {
        // S'il y a des infos dans $_POST ou $_FILES
        if (!empty($_POST) OR !empty($_FILES)) {
            // Sauvegarde des infos
            $_SESSION['sauvegarde'] = $_POST;
            $_SESSION['sauvegardeFILES'] = $_FILES;

            // Copie de l'URL
            $fichierActuel = $_SERVER['PHP_SELF'];
            if (!empty($_SERVER['QUERY_STRING'])) {
                $fichierActuel .= '?' . $_SERVER['QUERY_STRING'];
            }

            /*
             * Pour éviter que les fichiers uploadés ne soient détruits,
             * on les sauvegarde dans un dossier temporaire
             */
            foreach ($_FILES as $fichier => $valeurs) {
                $nom = '../tmp/' . substr(strrchr($valeurs['tmp_name'], '/'), 1);

                if ($valeurs['error'] == 0
                        && move_uploaded_file($valeurs['tmp_name'], $nom)) {
                    $_SESSION['sauvegardeFILES'][$fichier]['tmp_name'] = $nom;
                }
            }

            // Redirection
            header("Location: $fichierActuel");
            exit;
        }

        // S'il y a des données sauvegardées, restauration de celles-ci
        if (isset($_SESSION['sauvegarde'])) {
            $_POST = $_SESSION['sauvegarde'];
            $_FILES = $_SESSION['sauvegardeFILES'];

            unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);
        }
    }

    /**
     * Fonction de pagination
     *
     * @param int $page Page courante
     * @param int $total_page Nb total de pages
     * @return string
     */
    function pagination($pageCourante, $total_pages) {
        $autour = 1;
        $intervalle = '[...]';
        $html = '<ul class="pagination">' . "\n";
        $intervalleDebut = $intervalleFin = false;
        $tab_autour = array();

        // Préparation des balises HTML
        $baliseDebut = "\t" . '<li class="';
        $baliseMilieu = '"><a href="';
        $baliseFin = "</a></li>\n";

        // Préparation de la requête des liens
        $requeteOriginale = str_replace("&", "&amp;", $_SERVER['QUERY_STRING']);
        $emplacementPage = strpos($requeteOriginale, "&amp;page=");
        $requeteNettoyee = $requeteOriginale;
        if ($emplacementPage !== false) {
            $requeteNettoyee = substr($requeteOriginale, 0, $emplacementPage);
        }

        // Tableau des pages autour
        for ($i = $pageCourante - $autour; $i <= $pageCourante + $autour; $i++) {
            $tab_autour[] = $i;
        }

        // Ajout du lien "précedent"
        if ($pageCourante - 1 >= 1) {
            $html .= $baliseDebut . $baliseMilieu . '?' . "$requeteNettoyee&amp;page=" . ($pageCourante - 1) . '">' . "&laquo;" . $baliseFin;
        }

        // Création des liens
        for ($j = 1; $j <= $total_pages; $j++) {
            if ($j == $pageCourante) { // Si c'est la page courante
                $html .= $baliseDebut . 'active' . $baliseMilieu . '#">' . $j . $baliseFin;

            } elseif ($j == 1 || $j == $total_pages || in_array($j, $tab_autour)) { // Si c'est la première, la dernière ou une des pages du tableau
                $html .= $baliseDebut . $baliseMilieu . '?' . "$requeteNettoyee&amp;page=" . $j . '">' . $j . $baliseFin;

            } elseif ($j < $pageCourante && !$intervalleDebut) { // Intervalle de début
                $html .= $baliseDebut . 'disabled' . $baliseMilieu . '#">' . $intervalle . $baliseFin;
                $intervalleDebut = true;

            } elseif ($j > $pageCourante && !$intervalleFin) { // Intervalle de fin
                $html .= $baliseDebut . 'disabled' . $baliseMilieu . '#">' . $intervalle . $baliseFin;
                $intervalleFin = true;
            }
        }

        // Ajout du lien "suivant"
        if ($pageCourante + 1 <= $total_pages) {
            $html .= $baliseDebut . $baliseMilieu . '?' . "$requeteNettoyee&amp;page=" . ($pageCourante + 1) . '">' . "&raquo;" . $baliseFin;
        }

        $html .= "</ul>\n";

        return $html;
    }
?>
