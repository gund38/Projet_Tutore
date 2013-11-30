<?php
    /**
     * Ce fichier est un formulaire de Diplôme vide.
     * Il est récupéré en AJAX.
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    /**
     * Chargement des fichiers de classes
     *
     * @param string $classe La classe à charger
     */
    function chargerClasse($classe) {
        require_once '../classes/' . $classe . '.php';
    }

    // Ajout de la fonction de chargement
    spl_autoload_register('chargerClasse');

    // Inclusion de fonctions.php
    require_once '../fonctions/fonctions.php';

    // Récupération de la liste des types de diplôme
    $listeTypes = listeTypesDiplome();
?>

<!-- ///// Diplôme \\\\\ -->
<div class="well">
    <table>
        <thead>
            <tr>
                <th class="colonne_visi">
                    <span class="text-info">
                        <i class="icon-eye-open icon-2x pull-left"></i> <strong>Visibilité publique</strong>
                    </span>
                </th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="colonne_visi" rowspan="4">
                    <label for="visi_dip"
                           class="control-label">
                        <small class="text-info">Visibilité globale</small>
                    </label>

                    <input type="checkbox" class="form-control checkboxiOS"
                           name="visi_dip"
                           id="visi_dip" />
                </td>
            </tr>

            <tr>
                <td class="formLabel">
                    <label for="annee_dip"
                           class="control-label">
                        Année d'obtention&nbsp;<span class="obligatoire">*</span>
                    </label>
                </td>

                <td colspan="3">
                    <input type="text" class="form-control"
                           name="annee_dip"
                           id="annee_dip"
                           maxlength="4" required />
                </td>
            </tr>

            <tr>
                <td class="formLabel">
                    <label for="type_dip"
                           class="control-label">
                        Diplôme obtenu&nbsp;<span class="obligatoire">*</span>
                    </label>
                </td>

                <td>
                    <select name="type_dip"
                            id="type_dip"
                            class="form-control" required>
                                <?php
                                    foreach ($listeTypes as $value) {
                                        echo '<option value="' . $value . '">' . $value . "</option>\n";
                                    }
                                ?>
                    </select>
                </td>

                <td class="formLabel">
                    <label for="disc_dip"
                           class="control-label">
                        Discipline&nbsp;<span class="obligatoire">*</span>
                    </label>
                </td>

                <td>
                    <input type="text" class="form-control"
                           name="disc_dip"
                           id="disc_dip" required />
                </td>
            </tr>

            <tr>
                <td class="formLabel">
                    <label for="etabli_dip"
                           class="control-label">
                        Établissement&nbsp;<span class="obligatoire">*</span>
                    </label>
                </td>

                <td colspan="3">
                    <input type="text" class="form-control"
                           name="etabli_dip"
                           id="etabli_dip" required />
                </td>
            </tr>
        </tbody>
    </table>
</div> <!-- /.well -->
