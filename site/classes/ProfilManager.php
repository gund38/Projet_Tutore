<?php

    /**
     * Manager de Profil
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class ProfilManager {

        /**
         *
         * @var PDO
         */
        private $_db;

        /**
         * Contructeur
         *
         * @param PDO $db Base de données
         */
        public function __construct(PDO $db) {
            $this->setDb($db);
        }

        /**
         * Retourne la liste de tous les profils
         *
         * @return Profil[]
         */
        public function getList() {
            $profils = array();

            $req = $this->_db->query('SELECT
                pr.codePe, pe.nom, pe.prenom, pr.promo,
                pr.diplomeMaster, pe.email, pr.visibiliteEmail,
                DATE_FORMAT(pr.dateNaissance, \'%d/%m/%Y\') AS dateNaissance,
                pr.visibiliteDateNaissance, pr.cheminPhoto, pr.visibilitePhoto,
                pr.pagePerso, pr.visibilitePagePerso
                FROM Profil AS pr, Personne AS pe
                WHERE pr.codePe = pe.codePe
                ORDER BY pr.codePe');

            while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
                $profils[] = new Profil($donnees);
            }

            return $profils;
        }

        /**
         * Retourne le profil désigné par son id
         *
         * @param int $id Id du profil à récupérer
         * @return Profil
         */
        public function getProfil($id) {
            $profil = null;

            $req = $this->_db->prepare('SELECT
                pr.codePe, pe.nom, pe.prenom, pr.promo,
                pr.diplomeMaster, pe.email, pr.visibiliteEmail,
                DATE_FORMAT(pr.dateNaissance, \'%d/%m/%Y\') AS dateNaissance,
                pr.visibiliteDateNaissance, pr.cheminPhoto, pr.visibilitePhoto,
                pr.pagePerso, pr.visibilitePagePerso
                FROM Profil AS pr, Personne AS pe
                WHERE pr.codePe = pe.codePe
                AND pr.codePe = :id');

            $req->execute(array(
                'id' => $id
            ));

            while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
                $profil = new Profil($donnees);
            }

            return $profil;
        }

        /**
         * Update un profil (et ses diplômes et/ou expériences professionnelles)
         * dans la BD
         *
         * @param Profil $profil Profil à update
         * @return boolean
         */
        public function updateProfil($profil) {
            $resultat = false;

            // On vérifie que le paramètre est bien du type Profil
            if (get_class($profil) !== "Profil") {
                return $resultat;
            }

            // Création du tableau de données du Profil
            $donneesProfil = array(
                'codePe' => $profil->getCodePe(),
                'visibiliteEmail' => $profil->getVisibiliteEmail(),
                'dateNaissance' => $profil->getDateNaissance(),
                'visibiliteDateNaissance' => $profil->getVisibiliteDateNaissance(),
                'cheminPhoto' => $profil->getCheminPhoto(),
                'visibilitePhoto' => $profil->getVisibilitePhoto(),
                'pagePerso' => $profil->getPagePerso(),
                'visibilitePagePerso' => $profil->getVisibilitePagePerso()
            );

            // Préparation de la requête pour le Profil
            $req = $this->_db->prepare('UPDATE Profil SET
                visibiliteEmail = :visibiliteEmail,
                dateNaissance = STR_TO_DATE(:dateNaissance, \'%d/%m/%Y\'),
                visibiliteDateNaissance = :visibiliteDateNaissance,
                cheminPhoto = :cheminPhoto,
                visibilitePhoto = :visibilitePhoto,
                pagePerso = :pagePerso,
                visibilitePagePerso = :visibilitePagePerso
                WHERE codePe = :codePe');

            // Si la préparation a échoué
            if (!$req) {
                return $resultat;
            }

            // Exécution de la requête
            $req->execute($donneesProfil);

            // Si la requête a echoué
            if (!$req) {
                return $resultat;
            }

            // On met à jour les diplômes s'il y en a
            $diplomes = $profil->getDiplomes();
            $diplomeManager = new DiplomeManager($this->_db);
            foreach ($diplomes as $diplomeEnCours) {
                if (!$diplomeManager->updateDiplome($diplomeEnCours)) {
                    return $resultat;
                }
            }

            // On met à jour les expériences professionnelles s'il y en a
            $expPros = $profil->getExpPros();
            $expProManager = new ExpProManager($this->_db);
            foreach ($expPros as $expProEnCours) {
                if (!$expProManager->updateExpPro($expProEnCours)) {
                    return $resultat;
                }
            }

            $resultat = true;
            return $resultat;
        }

        /**
         * Ajoute un profil dans la BD
         *
         * @param Profil $profil Profil à ajouter
         * @return boolean
         */
        public function addProfil($profil) {
            $resultat = false;

            // On vérifie que le paramètre est bien du type Profil
            if (get_class($profil) !== "Profil") {
                return $resultat;
            }

            // Création du tableau de données
            $donnees = array(
                'codePe' => $profil->getCodePe(),
                'promo' => $profil->getPromo(),
                'diplomeMaster' => $profil->getDiplomeMaster(),
                'visibiliteEmail' => false,
                'visibiliteDateNaissance' => false,
                'visibilitePhoto' => false,
                'visibilitePagePerso' => false,
            );

            // Préparation de la requête
            $req = $this->_db->prepare('INSERT INTO
                Profil (codePe, promo, diplomeMaster, visibiliteEmail, visibiliteDateNaissance, visibilitePhoto, visibilitePagePerso)
                VALUES (:codePe, :promo, :diplomeMaster, :visibiliteEmail, :visibiliteDateNaissance, :visibilitePhoto, :visibilitePagePerso)');

            if (!$req) {
                return $resultat;
            }

            // Exécution de la requête
            $req->execute($donnees);

            if ($req) {
                $resultat = true;
            }

            return $resultat;
        }

        /**
         * Setter de $_db
         *
         * @param PDO $db Base de données
         */
        public function setDb(PDO $db) {
            $this->_db = $db;
        }

    }

?>
