<?php

    /**
     * Classe qui représente une personne
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class Personne {

        private $_codePe;
        private $_type;
        private $_nom;
        private $_prenom;
        private $_email;
        private $_login;
        private $_mdp;

        /**
         * Constructeur
         *
         * @param array $donnees Données de la personne
         */
        public function __construct(array $donnees) {
            //require_once '../fonctions/fonctions.php';

            $this->hydrate($donnees);
        }

        /**
         * Permet d'hydrater l'instance de la classe,
         * c'est-à-dire d'effectuer automatiquement
         * l'attribution des valeurs aus attributs
         *
         * @param array $donnees Données de la personne
         */
        public function hydrate(array $donnees) {
            foreach ($donnees as $key => $value) {
                // On récupère le nom du setter correspondant à l'attribut.
                $method = 'set' . ucfirst($key);

                // Si le setter correspondant existe.
                if (method_exists($this, $method)) {
                    // On appelle le setter.
                    $this->$method($value);
                } else {
                    echo 'Erreur avec ' . $method . "<br />";
                }
            }
        }

        /**
         * Affiche les infos de la personne
         */
        public function afficher() {
            echo $this->_codePe . " "
                    . $this->_type . " "
                    . $this->_nom . " "
                    . $this->_prenom . " "
                    . $this->_email . " "
                    . $this->_login . " "
                    . $this->_mdp . "<br />";
        }

        /**
         * Getter de $_codePe
         *
         * @return int
         */
        public function getCodePe() {
            return $this->_codePe;
        }

        /**
         * Getter de $_type
         *
         * @return string
         */
        public function getType() {
            return $this->_type;
        }

        /**
         * Setter de $_codePe
         *
         * @param int $codePe
         */
        public function setCodePe($codePe) {
            $this->_codePe = $codePe;
        }

        /**
         * Setter de $_type
         *
         * @param string $type
         */
        public function setType($type) {
            $this->_type = $type;
        }

        /**
         * Setter de $_nom
         *
         * @param string $nom
         */
        public function setNom($nom) {
            $this->_nom = $nom;
        }

        /**
         * Setter de $_prenom
         *
         * @param string $prenom
         */
        public function setPrenom($prenom) {
            $this->_prenom = $prenom;
        }

        /**
         * Setter de $_email
         *
         * @param string $email
         */
        public function setEmail($email) {
            $this->_email = $email;
        }

        /**
         * Setter de $_login
         *
         * @param string $login
         */
        public function setLogin($login) {
            $this->_login = $login;
        }

        /**
         * Setter de $_mdp
         *
         * @param string $mdp
         */
        public function setMdp($mdp) {
            $this->_mdp = $mdp;
        }

    }

?>
