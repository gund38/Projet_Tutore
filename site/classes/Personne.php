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
        // @TODO ajouter compteValide

        /**
         * Constructeur
         *
         * @param array $donnees Données de la personne
         */
        public function __construct(array $donnees) {
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

        //---------------Getters---------------//

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
         * Getter de $_nom
         *
         * @return string
         */
        public function getNom() {
            return $this->_nom;
        }

        /**
         * Getter de $_prenom
         *
         * @return string
         */
        public function getPrenom() {
            return $this->_prenom;
        }

        /**
         * Getter de $_email
         *
         * @return string
         */
        public function getEmail() {
            return $this->_email;
        }

        // @TODO Ajouter si nécessaire les getters de login et mdp

        //---------------Setters---------------//

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
