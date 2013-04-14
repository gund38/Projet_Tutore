<?php

    // Chargement des fichiers de classes et de fonctions
    function chargerClasse($classe) {
        require_once 'classes/' . $classe . '.php';
    }

    spl_autoload_register('chargerClasse');
    require_once 'fonctions/fonctions.php';

    // Démarrage de la session
    session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
    <head>
        <title>Site des ancien étudiants</title>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
        <?php
            // Non disponible dans cette version (manque un plugin)
            //override_function('print', '$text', 'print(utf8_encode($text));');

            $bdd = ConnexionBD::getInstance()->getBDD();

            $manager = new PersonneManager($bdd);

            $personnes = $manager->getList();

            $taille = count($personnes);

            echo "<p>\n";
            for ($i = 0; $i < $taille; $i++) {
                echo "\t\t";
                $personnes[$i]->afficher();
                echo "<br />\n";
            }
            echo "\t</p>\n";


            $managerOffre = new OffreManager($bdd);
            $offres = $managerOffre->getList();
            $taille = count($offres);

            echo "<p>\n";
            for ($i = 0; $i < $taille; $i++) {
                echo "\t\t";
                $offres[$i]->afficher();
                echo "<br />\n";
            }
            echo "\t</p>\n";



            $texte = "L'âme, l'esprit et le corps sont à nous ! Will&co + #";
            $encode = utf8_encode($texte);
            $decode = utf8_decode($texte);
            $filter = filter_var($texte, FILTER_SANITIZE_STRING);//, /*FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | */FILTER_FLAG_ENCODE_AMP);
            $escape = mysql_real_escape_string($texte);
            $encodeDecode = utf8_decode($filter);
            $htmlDecode = html_entity_decode($filter);
            $encodeFilter = utf8_encode($htmlDecode);

            echo "texte = " . $texte . "<br />\n";
            echo "encode = " . $encode . "<br />\n";
            echo "decode = " . $decode . "<br />\n";
            echo "filter = " . $filter . "<br />\n";
            echo "escape = " . $escape . "<br />\n";
            echo "encodeDecode = " . $encodeDecode . "<br />\n";
            echo "htmlDecode = " . $htmlDecode . "<br />\n";
            echo "encodeFilter = " . $encodeFilter . "<br />\n";

            $mega = $texte . ' ; '
                    //. $encode . ' ; '
                    //. $decode . ' ; '
                    . "              filter = " . $filter . ' ; '
                    //. $escape. ' ; '
                    //. $encodeDecode . ' ; '
                    . $htmlDecode . ' ; '
                    . $encodeFilter;

//            $req = $bdd->prepare('INSERT INTO test (texte)
//                VALUES (:text)');
//
//            $req->execute(array(
//                'text' => $mega
//            ));
//
//            $req->closeCursor();

//            $req = $bdd->query('INSERT INTO test (texte)
////                VALUES (' . $mega . ')');
//            var_dump($req);


//            $req->closeCursor();

            $req = $bdd->query('SELECT texte
                FROM test
                WHERE id = 29');


            echo "<br /><br />";
            while ($donnees = $req->fetch()) {
                print_r($donnees['texte']);
                echo "<br />\n";
            }

//            $sql = 'SELECT texte INTO test';
        ?>
    </body>
</html>
