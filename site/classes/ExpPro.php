<?php

    /**
     * Classe qui représente une expérience professionnelle
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class ExpPro {

        private $_codeEP;
        private $_codePe;
        private $_visibilite;
        private $_dateDebut;
        private $_dateFin;
        private $_enCours;
        private $_intitule;
        private $_entreprise;
        private $_ville;
        private $_departement;
        private $_salaire;
        private $_visibiliteSalaire;

        /**
         * Constructeur
         *
         * @param array $donnees Données de l'expérience professionnelle
         */
        public function __construct(array $donnees) {
            $this->hydrate($donnees);
        }

        /**
         * Permet d'hydrater l'instance de la classe,
         * c'est-à-dire d'effectuer automatiquement
         * l'attribution des valeurs aus attributs
         *
         * @param array $donnees Données de l'expérience professionnelle
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

        //---------------Getters---------------//

        /**
         * Getter de $_codeEP
         *
         * @return int
         */
        public function getCodeEP() {
            return $this->_codeEP;
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
         * Getter de $_visibilite
         *
         * @return boolean
         */
        public function getVisibilite() {
            return $this->_visibilite;
        }

        /**
         * Getter de $_dateDebut
         *
         * @return string
         */
        public function getDateDebut() {
            return $this->_dateDebut;
        }

        /**
         * Getter de $_dateFin
         *
         * @return string
         */
        public function getDateFin() {
            return $this->_dateFin;
        }

        /**
         * Getter de $_enCours
         *
         * @return boolean
         */
        public function getEnCours() {
            return $this->_enCours;
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
         * Getter de $_salaire
         *
         * @return string
         */
        public function getSalaire() {
            return $this->_salaire;
        }

        /**
         * Getter de $_visibiliteSalaire
         *
         * @return boolean
         */
        public function getVisibiliteSalaire() {
            return $this->_visibiliteSalaire;
        }

        //---------------Setters---------------//

        /**
         * Setter de $_codeEP
         *
         * @param int $codeEP
         */
        public function setCodeEP($codeEP) {
            $this->_codeEP = $codeEP;
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
         * Setter de $_visibilite
         *
         * @param boolean $visibilite
         */
        public function setVisibilite($visibilite) {
            $this->_visibilite = $visibilite;
        }

        /**
         * Setter de $_dateDebut
         *
         * @param string $dateDebut
         */
        public function setDateDebut($dateDebut) {
            $this->_dateDebut = $dateDebut;
        }

        /**
         * Setter de $_dateFin
         *
         * @param string $dateFin
         */
        public function setDateFin($dateFin) {
            $this->_dateFin = $dateFin;
        }

        /**
         * Setter de $_enCours
         *
         * @param boolean $enCours
         */
        public function setEnCours($_enCours) {
            $this->_enCours = $_enCours;
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
         * Setter de $_salaire
         *
         * @param string $salaire
         */
        public function setSalaire($salaire) {
            $this->_salaire = $salaire;
        }

        /**
         * Setter de $_visibiliteSalaire
         *
         * @param string $visibiliteSalaire
         */
        public function setVisibiliteSalaire($visibiliteSalaire) {
            $this->_visibiliteSalaire = $visibiliteSalaire;
        }

    }

?>
