<?php

    /**
     * Classe qui représente un diplôme
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class Diplome {

        private $_codeDi;
        private $_codePe;
        private $_visibilite;
        private $_annee;
        private $_type;
        private $_discipline;
        private $_etablissement;

        /**
         * Constructeur
         *
         * @param array $donnees Données du diplôme
         */
        public function __construct(array $donnees) {
            $this->hydrate($donnees);
        }

        /**
         * Permet d'hydrater l'instance de la classe,
         * c'est-à-dire d'effectuer automatiquement
         * l'attribution des valeurs aus attributs
         *
         * @param array $donnees Données du diplôme
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
         * Getter de $_codeDi
         *
         * @return int
         */
        public function getCodeDi() {
            return $this->_codeDi;
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
         * Getter de $_annee
         *
         * @return int
         */
        public function getAnnee() {
            return $this->_annee;
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
         * Getter de $_discipline
         *
         * @return string
         */
        public function getDiscipline() {
            return $this->_discipline;
        }

        /**
         * Getter de $_etablissement
         *
         * @return string
         */
        public function getEtablissement() {
            return $this->_etablissement;
        }

        //---------------Setters---------------//

        /**
         * Setter de $_codeDi
         *
         * @param int $codeDi
         */
        public function setCodeDi($codeDi) {
            $this->_codeDi = $codeDi;
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
         * Setter de $_annee
         *
         * @param int $annee
         */
        public function setAnnee($annee) {
            $this->_annee = $annee;
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
         * Setter de $_discipline
         *
         * @param string $discipline
         */
        public function setDiscipline($discipline) {
            $this->_discipline = $discipline;
        }

        /**
         * Setter de $_etablissement
         *
         * @param string $etablissement
         */
        public function setEtablissement($etablissement) {
            $this->_etablissement = $etablissement;
        }

    }

?>
