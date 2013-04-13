<?php

    /**
     * Manager de Personne
     */
    class PersonneManager {

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
         * Retourne la liste de toutes les personnes dans la BD
         *
         * @return array of Personne
         */
        public function getList() {
            $persos = array();

            $q = $this->_db->query('SELECT codePe, type, nom, prenom, email, login, mdp FROM Personne ORDER BY nom');

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
                $persos[] = new Personne($donnees);
            }

            return $persos;
        }

        /**
         * Retourne la personne désignée par son id
         *
         * @param int $id Id de la personne à récupérer
         * @return Personne
         */
        public function getPersonne($id) {
            $q = $this->_db->prepare('SELECT codePe, type, nom, prenom, email, login, mdp FROM Personne WHERE codePe = :id');
            $q->execute(array(
                'id' => $id
            ));

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
                $personne = new Personne($donnees);
            }

            return $personne;
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
