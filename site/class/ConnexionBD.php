<?php

    /**
     * Classe singleton pour la connexion à la BD
     */
    class ConnexionBD {

        private static $_instance = null;
        private $_bdd;

        /**
         * Constructeur
         */
        private function __construct() {
            try {
                $this->_bdd = new PDO('mysql:host=localhost;dbname=projet_tutore', 'gund38', 'gund38');
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }

        /**
         * Getter de $_instance
         *
         * @return ConnexionBD
         */
        public static function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Getter de $_bdd
         *
         * @return PDO
         */
        public function getBDD() {
            return $this->_bdd;
        }

    }

?>