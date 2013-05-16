<?php

    /**
     * Manager de Diplome
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */
    class DiplomeManager {

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
         * Retourne les diplômes désignés par l'id du profil correspondant
         *
         * @param int $id Id du profil
         * @return Diplome[]
         */
        public function getDiplomes($id) {
            $diplomes = array();

            $req = $this->_db->prepare('SELECT
                codeDi, codePe, visibilite, annee, type, discipline, etablissement
                FROM Diplome
                WHERE codePe = :id
                ORDER BY annee DESC');

            $req->execute(array(
                'id' => $id
            ));

            while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
                $diplomes[] = new Diplome($donnees);
            }

            return $diplomes;
        }

        /**
         * Update un diplôme dans la BD
         *
         * @param Diplome $diplome Diplôme à update
         * @return boolean
         */
        public function updateDiplome($diplome) {
            $resultat = false;

            // On vérifie que le paramètre est bien du type Diplome
            if (get_class($diplome) !== "Diplome") {
                return $resultat;
            }

            // Création du tableau de données
            $donneesDiplome = array(
                'codeDi' => $diplome->getCodeDi(),
                'visibilite' => $diplome->getVisibilite(),
                'annee' => $diplome->getAnnee(),
                'type' => $diplome->getType(),
                'discipline' => $diplome->getDiscipline(),
                'etablissement' => $diplome->getEtablissement()
            );

            // Préparation de la requête
            $req = $this->_db->prepare('UPDATE Diplome SET
                visibilite = :visibilite,
                annee = :annee,
                type = :type,
                discipline = :discipline,
                etablissement = :etablissement
                WHERE codeDi = :codeDi');

            // Si la préparation a échoué
            if (!$req) {
                return $resultat;
            }

            // Exécution de la requête
            $req->execute($donneesDiplome);

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
