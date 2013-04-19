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
         * @param PDO $db
         */
        public function __construct(PDO $db) {
            $this->setDb($db);
        }

        /**
         * Retourne la liste de tous les profils
         *
         * @return array of Profil
         */
        public function getList() {
            $profils = array();

            $q = $this->_db->query('SELECT
                codePe, promo, visibiliteEmail, dateNaissance,
                visibiliteDateNaissance, cheminPhoto, visibilitePhoto, pagePerso
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
                codePe, promo, visibiliteEmail, dateNaissance,
                visibiliteDateNaissance, cheminPhoto, visibilitePhoto, pagePerso
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
         * Setter de $_db
         *
         * @param PDO $db
         */
        public function setDb(PDO $db) {
            $this->_db = $db;
        }

    }

?>
