<?php

    /**
     * Classe qui représente une offre
     *
     * @author Kévin Bélellou et Nicolas Dubois
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
            $this->hydrate($donnees);
        }

        /**
         * Permet d'hydrater l'instance de la classe,
         * c'est-à-dire d'effectuer automatiquement
         * l'attribution des valeurs aus attributs
         *
         * @param array $donnees Données de l'offre
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
            echo $this->_codeO . " "
            . $this->_codePe . " "
            . $this->_dateDepot . " "
            . $this->_type . " "
            . $this->_intitule . " "
            . $this->_entreprise . " "
            . $this->_ville . " "
            . $this->_departement . " "
            . $this->_remuneration . " "
            . $this->_cheminPDF . "<br />";
        }

        //---------------Getters---------------//

        /**
         * Getter de $_codeO
         *
         * @return int
         */
        public function getCodeO() {
            return $this->_codeO;
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
         * Getter de $_dateDepot
         *
         * @return string
         */
        public function getDateDepot() {
            return $this->_dateDepot;
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
         * Getter de $_intitule
         *
         * @return string
         */
        public function getIntitule() {
            return $this->_intitule;
        }

        /**
         * Getter de $_entreprise
         *
         * @return string
         */
        public function getEntreprise() {
            return $this->_entreprise;
        }

        /**
         * Getter de $_ville
         *
         * @return string
         */
        public function getVille() {
            return $this->_ville;
        }

        /**
         * Getter de $_departement
         *
         * @return string
         */
        public function getDepartement() {
            return $this->_departement;
        }

        /**
         * Getter de $_remuneration
         *
         * @return string
         */
        public function getRemuneration() {
            return $this->_remuneration;
        }

        /**
         * Getter de $_cheminPDF
         *
         * @return string
         */
        public function getCheminPDF() {
            return $this->_cheminPDF;
        }

        //---------------Setters---------------//

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
         * Setter de $_cheminPDF
         *
         * @param string $cheminPDF
         */
        public function setCheminPDF($cheminPDF) {
            $this->_cheminPDF = $cheminPDF;
        }

    }

?>
