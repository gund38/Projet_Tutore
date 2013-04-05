<?php
    class PersonneManager
    {
        private $_db; // Instance de PDO

        public function __construct($db) {
            $this->setDb($db);
        }

        public function getList() {
            $persos = array();

            $q = $this->_db->query('SELECT codePe, type, nom, prenom, email, login, mdp FROM Personne ORDER BY nom');

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
                $persos[] = new Personne($donnees);
            }

            return $persos;
        }

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

        public function setDb(PDO $db) {
            $this->_db = $db;
        }
    }
?>
