<?php

    /**
     * Manager d'Offre
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class OffreManager {

        /**
         *
         * @var PDO
         */
        private $_db;

        /**
         * Contructeur
         *
         * @param PDO $db
         */
        public function __construct(PDO $db) {
            $this->setDb($db);
        }

        /**
         * Retourne la liste de toutes les offres dans la BD
         *
         * @return array of Offre
         */
        public function getList() {
            $offres = array();

            $q = $this->_db->query('SELECT
                codeO, codePe, dateDepot, type, intitule, entreprise, ville,
                departement, remuneration, cheminPDF
                FROM Offre
                ORDER BY codeO');

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
                $offres[] = new Offre($donnees);
            }

            return $offres;
        }

        /**
         * Retourne l'offre désignée par son id
         *
         * @param int $id Id de l'offre à récupérer
         * @return Personne
         */
        public function getOffre($id) {
            $q = $this->_db->prepare('SELECT
                codeO, codePe, dateDepot, type, intitule, entreprise, ville,
                departement, remuneration, cheminPDF
                FROM Personne
                WHERE codeO = :id');

            $q->execute(array(
                'id' => $id
            ));

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
                $offre = new Offre($donnees);
            }

            return $offre;
        }

        /**
         * Ajoute une offre dans la BD
         *
         * @param array $donnees
         * @return boolean
         */
        public function addOffre($offre) {
            $resultat = false;

            // On vérifie que le paramètre est bien du type Offre
            if (get_class($offre) !== "Offre") {
                return $resultat;
            }

            // Création du tableau de données
            $donnees = array(
                'codePe' => $offre->getCodePe(),
                'type' => $offre->getType(),
                'intitule' => $offre->getIntitule(),
                'entreprise' => $offre->getEntreprise(),
                'ville' => $offre->getVille(),
                'departement' => $offre->getDepartement(),
                'remuneration' => $offre->getRemuneration(),
                'cheminPDF' => $offre->getCheminPDF()
            );

            $req = $this->_db->prepare('INSERT INTO
                Offre (codePe, type, intitule, entreprise, ville, departement, remuneration, cheminPDF)
                VALUES (:codePe, :type, :intitule, :entreprise, :ville, :departement, :remuneration, :cheminPDF)');

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
         * @param PDO $db
         */
        public function setDb(PDO $db) {
            $this->_db = $db;
        }

    }

?>
