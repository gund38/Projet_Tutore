<?php

    /**
     * Manager d'Offre
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class OffreManager {

        private $_db;

        /**
         * Contructeur
         *
         * @param PDO $db Base de données
         */
        public function __construct(PDO $db) {
            $this->setDb($db);
        }

        /**
         * Retourne la liste de toutes les offres dans la BD
         *
         * @return Offre[]
         */
        public function getList() {
            $offres = array();

            $req = $this->_db->query('SELECT
                o.codeO, o.codePe,
                DATE_FORMAT(o.dateDepot, \'%d/%m/%Y\') AS dateDepot,
                o.type, o.intitule, o.entreprise, o.ville
                o.departement, o.remuneration, o.cheminPDF
                FROM Offre AS o
                ORDER BY o.codeO');

            while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
                $offres[] = new Offre($donnees);
            }

            return $offres;
        }

        /**
         * Retourne l'offre désignée par son id
         *
         * @param int $id Id de l'offre à récupérer
         * @return Offre
         */
        public function getOffre($id) {
            $req = $this->_db->prepare('SELECT
                o.codeO, o.codePe,
                DATE_FORMAT(o.dateDepot, \'%d/%m/%Y\') AS dateDepot,
                o.type, o.intitule, o.entreprise, o.ville
                o.departement, o.remuneration, o.cheminPDF
                FROM Offre AS o
                WHERE o.codeO = :id');

            $req->execute(array(
                'id' => $id
            ));

            while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
                $offre = new Offre($donnees);
            }

            return $offre;
        }

        /**
         * Ajoute une offre dans la BD
         *
         * @param Offre $offre Offre à ajouter
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

            // Préparation de la requête
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
         * @param PDO $db Base de données
         */
        public function setDb(PDO $db) {
            $this->_db = $db;
        }

    }

?>
