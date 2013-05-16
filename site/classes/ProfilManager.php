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

            $q = $this->_db->query('SELECT
                codePe, promo, visibiliteEmail,
                DATE_FORMAT(dateNaissance, \'%d/%m/%Y\') AS dateNaissance,
                visibiliteDateNaissance, cheminPhoto, visibilitePhoto,
                pagePerso, visibilitePagePerso
                FROM Profil
                ORDER BY codePe');

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
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
            $q = $this->_db->prepare('SELECT
                codePe, promo, visibiliteEmail,
                DATE_FORMAT(dateNaissance, \'%d/%m/%Y\') AS dateNaissance,
                visibiliteDateNaissance, cheminPhoto, visibilitePhoto,
                pagePerso, visibilitePagePerso
                FROM Profil
                WHERE codePe = :id');

            $q->execute(array(
                'id' => $id
            ));

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
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

            $resultat = true;

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
