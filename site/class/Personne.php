<?php

    class Personne {

        private $_codePe;
        private $_type;
        private $_nom;
        private $_prenom;
        private $_email;
        private $_login;
        private $_mdp;

        public function __construct(array $donnees) {
            include_once 'fonctions.php';
            $this->hydrate($donnees);
        }

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

        public function afficher() {
//            echo "éàùô ";
//            $txt = "éàùô ";
//            echo $txt;

            echo echoBD($this->_codePe . " "
                    . $this->_type . " "
                    . $this->_nom . " "
                    . $this->_prenom . " "
                    . $this->_email . " "
                    . $this->_login . " "
                    . $this->_mdp . "<br />");
//            echoBD("<br />" . $this->_nom);
        }

        public function setCodePe($codePe) {
            $this->_codePe = $codePe;
        }

        public function setType($type) {
            $this->_type = $type;
        }

        public function setNom($nom) {
            $this->_nom = $nom;
        }

        public function setPrenom($prenom) {
            $this->_prenom = $prenom;
        }

        public function setEmail($email) {
            $this->_email = $email;
        }

        public function setLogin($login) {
            $this->_login = $login;
        }

        public function setMdp($mdp) {
            $this->_mdp = $mdp;
        }

        public function degats() {
            return $this->_degats;
        }

    }

?>
