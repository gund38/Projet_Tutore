<!DOCTYPE html>
<html lang="fr" dir="ltr" class="client-nojs">
    <head>
        <title>Site des ancien étudiants</title>
        <meta charset="UTF-8" />
    </head>
    <body>
        <?php
        
            function chargerClasse($classe) {
                require 'class/'. $classe . '.php';
            }
            
            spl_autoload_register('chargerClasse');
            
            //override_function('print', '$text', 'print(utf8_encode($text));');

            try {
                $bdd = new PDO('mysql:host=localhost;dbname=projet_tutore', 'gund38', 'gund38');
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            
            $manager = new PersonneManager($bdd);
            
            $personnes = $manager->getList();
            
            $taille = count($personnes);
            
            for($i = 0; $i < $taille; $i++) {
                $personnes[$i]->afficher();
                echo "<br />";
            }
        ?>
    </body>
</html>
