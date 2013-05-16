<?php

    /**
     * Classe qui représente un profil
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class Profil {

        private $_codePe;
        private $_promo;
        private $_visibiliteEmail;
        private $_dateNaissance;
        private $_visibiliteDateNaissance;
        private $_cheminPhoto;
        private $_visibilitePhoto;
        private $_pagePerso;
        private $_visibilitePagePerso;
/** @TODO Rajouter booléen diplômé et tutti fruti */
        private $_diplomes;
        private $_expPros;

        /**
         * Constructeur
         *
         * @param array $donnees Données du profil
         */
        public function __construct(array $donnees) {
            $this->hydrate($donnees);
        }

        /**
         * Permet d'hydrater l'instance de la classe,
         * c'est-à-dire d'effectuer automatiquement
         * l'attribution des valeurs aus attributs
         *
         * @param array $donnees Données du profil
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
         * Permet d'obtenir, pour ce profil, la liste
         * des diplômes et des expériences professionnelles
         */
        public function obtenirProfilComplet() {
            $bdd = ConnexionBD::getInstance()->getBDD();
            $diplomeManager = new DiplomeManager($bdd);
            $expProManager = new ExpProManager($bdd);

            $this->_diplomes = $diplomeManager->getDiplomes($this->_codePe);
            $this->_expPros = $expProManager->getExpPros($this->_codePe);
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
         * Getter de $_promo
         *
         * @return int
         */
        public function getPromo() {
            return $this->_promo;
        }

        /**
         * Getter de $_visibiliteEmail
         *
         * @return boolean
         */
        public function getVisibiliteEmail() {
            return $this->_visibiliteEmail;
        }

        /**
         * Getter de $_dateNaissance
         *
         * @return string
         */
        public function getDateNaissance() {
            return $this->_dateNaissance;
        }

        /**
         * Getter de $_visibiliteDateNaissance
         *
         * @return boolean
         */
        public function getVisibiliteDateNaissance() {
            return $this->_visibiliteDateNaissance;
        }

        /**
         * Getter de $_cheminPhoto
         *
         * @return string
         */
        public function getCheminPhoto() {
            return $this->_cheminPhoto;
        }

        /**
         * Getter de $_visibilitePhoto
         *
         * @return boolean
         */
        public function getVisibilitePhoto() {
            return $this->_visibilitePhoto;
        }

        /**
         * Getter de $_pagePerso
         *
         * @return string
         */
        public function getPagePerso() {
            return $this->_pagePerso;
        }

        /**
         * Getter de $_visibilitePagePerso
         *
         * @return boolean
         */
        public function getVisibilitePagePerso() {
            return $this->_visibilitePagePerso;
        }

        /**
         * Getter de $_diplomes
         *
         * @return array of Diplome
         */
        public function getDiplomes() {
            return $this->_diplomes;
        }

        /**
         * Getter de $_expPros
         *
         * @return array of ExpPro
         */
        public function getExpPros() {
            return $this->_expPros;
        }

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
         * Setter de $_promo
         *
         * @param int $promo
         */
        public function setPromo($promo) {
            $this->_promo = $promo;
        }

        /**
         * Setter de $_visibiliteEmail
         *
         * @param boolean $visibiliteEmail
         */
        public function setVisibiliteEmail($visibiliteEmail) {
            $this->_visibiliteEmail = $visibiliteEmail;
        }

        /**
         * Setter de $_dateNaissance
         *
         * @param string $dateNaissance
         */
        public function setDateNaissance($dateNaissance) {
            $this->_dateNaissance = $dateNaissance;
        }

        /**
         * Setter de $_visibiliteDateNaissance
         *
         * @param boolean $visibiliteDateNaissance
         */
        public function setVisibiliteDateNaissance($visibiliteDateNaissance) {
            $this->_visibiliteDateNaissance = $visibiliteDateNaissance;
        }

        /**
         * Setter de $_cheminPhoto
         *
         * @param string $cheminPhoto
         */
        public function setCheminPhoto($cheminPhoto) {
            $this->_cheminPhoto = $cheminPhoto;
        }

        /**
         * Setter de $_visibilitePhoto
         *
         * @param boolean $visibilitePhoto
         */
        public function setVisibilitePhoto($visibilitePhoto) {
            $this->_visibilitePhoto = $visibilitePhoto;
        }

        /**
         * Setter de $_pagePerso
         *
         * @param string $pagePerso
         */
        public function setPagePerso($pagePerso) {
            $this->_pagePerso = $pagePerso;
        }

        /**
         * Setter de $_visibilitePagePerso
         *
         * @param boolean $visibilitePagePerso
         */
        public function setVisibilitePagePerso($visibilitePagePerso) {
            $this->_visibilitePagePerso = $visibilitePagePerso;
        }

        /**
         * Setter de $_diplomes
         *
         * @param Diplome[] $diplomes
         */
        public function setDiplomes($diplomes) {
            $this->_diplomes = $diplomes;
        }

        /**
         * Setter de $_expPros
         *
         * @param ExpPro[] $expPros
         */
        public function setExpPros($expPros) {
            $this->_expPros = $expPros;
        }

    }

?>
