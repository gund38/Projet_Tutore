<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle"
                    data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="index.php">SWAGMaster</a>
        </div>

        <?php
            // Afichage du bon menu selon l'identité de l'utilisateur
            if (!isset($_SESSION['personneCo'])) {
                require_once 'menus/menu_V_Bootstrap.php';
            } else {
                switch ($_SESSION['personneCo']->getType()) {
                    case "Enseignant":
                        require_once 'menus/menu_enseignant_Bootstrap.php';
                        break;
                    case "Etudiant":
                        require_once 'menus/menu_E_Bootstrap.php';
                        break;
                    case "Ancien_etudiant":
                        require_once 'menus/menu_AE_Bootstrap.php';
                        break;
                    case "Administrateur":
                        require_once 'menus/menu_admin_Bootstrap.php';
                        break;
                    default:
                        echo "Erreur lors de l'inclusion du menu";
                }
            }
        ?>
    </div> <!--/.container -->
</div> <!--/.navbar -->
