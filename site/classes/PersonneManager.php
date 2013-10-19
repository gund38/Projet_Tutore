<?php

    /**
     * Manager de Personne
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class PersonneManager {

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
         * Retourne la liste de toutes les personnes dans la BD
         *
         * @return Personne[]
         */
        public function getList() {
            $persos = array();

            $req = $this->_db->query('SELECT
                p.codePe, p.type, p.compteValide, p.nom,
                p.prenom, p.email, p.login, p.mdp
                FROM Personne AS p
                ORDER BY p.nom');

            while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
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
            $req = $this->_db->prepare('SELECT
                p.codePe, p.type, p.compteValide, p.nom,
                p.prenom, p.email, p.login, p.mdp
                FROM Personne AS p
                WHERE p.codePe = :id');

            $req->execute(array(
                'id' => $id
            ));

            while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
                $personne = new Personne($donnees);
            }

            return $personne;
        }

        /**
         * Ajoute une personne dans la BD
         *
         * @param Personne $personne Personne à ajouter
         * @return boolean
         */
        public function addPersonne($personne) {
            $resultat = false;

            // On vérifie que le paramètre est bien du type Personne
            if (get_class($personne) !== "Personne") {
                return $resultat;
            }

            // Création du tableau de données
            $donnees = array(
                'codePe' => $personne->getCodePe(),
                'type' => $personne->getType(),
                'compteValide' => $personne->getCompteValide(),
                'nom' => $personne->getNom(),
                'prenom' => $personne->getPrenom(),
                'email' => $personne->getEmail(),
                'login' => $personne->getLogin(),
                'mdp' => $personne->getMdp()
            );

            // Préparation de la requête
            $req = $this->_db->prepare('INSERT INTO
                Personne (codePe, type, compteValide, nom, prenom, email, login, mdp)
                VALUES (:codePe, :type, :compteValide, :nom, :prenom, :email, :login, :mdp)');

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
