<?php

    /**
     * Manager de ExpPro
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class ExpProManager {

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
         * Retourne les expériences professionnelles désignées
         * par l'id du profil correspondant
         *
         * @param int $id Id du profil
         * @return array of ExpPro
         */
        public function getExpPros($id) {
            $expPros = array();

            $q = $this->_db->prepare('SELECT
                codeEP, codePe, visibilite, dateDebut, dateFin, enCours, intitule,
                entreprise, ville, departement, salaire, visibiliteSalaire
                FROM ExpPro
                WHERE codePe = :id
                ORDER BY dateDebut DESC');

            $q->execute(array(
                'id' => $id
            ));

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
                $expPros[] = new ExpPro($donnees);
            }

            return $expPros;
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
