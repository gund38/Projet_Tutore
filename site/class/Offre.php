<?php

    /**
     * Classe qui représente une offre
     */
    class Offre {

        private $_codeO;
        private $_codePe;
        private $_dateDepot;
        private $_type;
        private $_intitule;
        private $_entreprise;
        private $_ville;
        private $_departement;
        private $_remuneration;
        private $_cheminPDF;

        /**
         * Constructeur
         *
         * @param array $donnees Données de l'offre
         */
        public function __construct(array $donnees) {
            require_once 'fonctions.php';
            $this->hydrate($donnees);
        }

        /**
         * Permet d'hydrater l'instance de la classe,
         * c'est-à-dire d'effectuer automatiquement
         * l'attribution des valeurs aus attributs
         *
         * @param array $donnees Données de l'a personne'offre
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
         * Affiche les infos de l'offre
         */
        public function afficher() {
            echo echoBD($this->_codeO . " "
                    . $this->_codePe . " "
                    . $this->_dateDepot . " "
                    . $this->_type . " "
                    . $this->_intitule . " "
                    . $this->_entreprise . " "
                    . $this->_ville . " "
                    . $this->_departement . " "
                    . $this->_remuneration . " "
                    . $this->_cheminPDF . "<br />");
        }

        /**
         * Setter de $_codeO
         *
         * @param int $codeO
         */
        public function setCodeO($codeO) {
            $this->_codeO = $codeO;
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
         * Setter de $_dateDepot
         *
         * @param string $dateDepot
         */
        public function setDateDepot($dateDepot) {
            $this->_dateDepot = $dateDepot;
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
         * Setter de $_intitule
         *
         * @param string $intitule
         */
        public function setIntitule($intitule) {
            $this->_intitule = $intitule;
        }

        /**
         * Setter de $_entreprise
         *
         * @param string $entreprise
         */
        public function setEntreprise($entreprise) {
            $this->_entreprise = $entreprise;
        }

        /**
         * Setter de $_ville
         *
         * @param string $ville
         */
        public function setVille($ville) {
            $this->_ville = $ville;
        }

        /**
         * Setter de $_departement
         *
         * @param string $departement
         */
        public function setDepartement($departement) {
            $this->_departement = $departement;
        }

        /**
         * Setter de $_remuneration
         *
         * @param string $remuneration
         */
        public function setRemuneration($remuneration) {
            $this->_remuneration = $remuneration;
        }

        /**
         * Setter de $_remuneration
         *
         * @param string $remuneration
         */
        public function setCheminPDF($cheminPDF) {
            $this->_cheminPDF = $cheminPDF;
        }

    }

?>
