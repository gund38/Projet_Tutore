<?php

    /**
     * Manager de ExpPro
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class ExpProManager {

        /**
         *
         * @var PDO
         */
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
         * Retourne les expériences professionnelles désignées
         * par l'id du profil correspondant
         *
         * @param int $id Id du profil
         * @return ExpPro[]
         */
        public function getExpPros($id) {
            $expPros = array();

            $req = $this->_db->prepare('SELECT
                codeEP, codePe, visibilite,
                DATE_FORMAT(dateDebut, \'%d/%m/%Y\') AS dateDebut,
                DATE_FORMAT(dateFin, \'%d/%m/%Y\') AS dateFin,
                enCours, intitule, entreprise, ville, departement,
                salaire, visibiliteSalaire
                FROM ExpPro
                WHERE codePe = :id
                ORDER BY dateDebut ASC');

            $req->execute(array(
                'id' => $id
            ));

            while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
                $expPros[] = new ExpPro($donnees);
            }

            return $expPros;
        }

        /**
         * Update une expériences professionnelle dans la BD
         *
         * @param ExpPro $expPro Expérience professionnelle à update
         * @return boolean
         */
        public function updateExpPro($expPro) {
            $resultat = false;

            // On vérifie que le paramètre est bien du type ExpPro
            if (get_class($expPro) !== "ExpPro") {
                return $resultat;
            }

            // Création du tableau de données
            $donneesExpPro = array(
                'codeEP' => $expPro->getCodeEP(),
                'visibilite' => $expPro->getVisibilite(),
                'dateDebut' => $expPro->getDateDebut(),
                'dateFin' => $expPro->getDateFin(),
                'enCours' => $expPro->getEnCours(),
                'intitule' => $expPro->getIntitule(),
                'entreprise' => $expPro->getEntreprise(),
                'ville' => $expPro->getVille(),
                'departement' => $expPro->getDepartement(),
                'salaire' => $expPro->getSalaire(),
                'visibiliteSalaire' => $expPro->getVisibiliteSalaire()
            );

            // Préparation de la requête
            $req = $this->_db->prepare('UPDATE ExpPro SET
                visibilite = :visibilite,
                dateDebut = STR_TO_DATE(:dateDebut, \'%d/%m/%Y\'),
                dateFin = STR_TO_DATE(:dateFin, \'%d/%m/%Y\'),
                enCours = :enCours,
                intitule = :intitule,
                entreprise = :entreprise,
                ville = :ville,
                departement = :departement,
                salaire = :salaire,
                visibiliteSalaire = :visibiliteSalaire
                WHERE codeEP = :codeEP');

            // Si la préparation a échoué
            if (!$req) {
                return $resultat;
            }

            // Exécution de la requête
            $req->execute($donneesExpPro);

            // Si la requête a réussi
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
