<?php
    /**
     * Ce fichier est un formulaire d'Emploi vide.
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

    // Récupération de la liste des départements
    $listeDep = listeDepartements();

    // Récupération de la liste des tranches de salaires
    $listeTranches = listeTranchesSalaire();
?>

<!-- ///// ExpPro \\\\\ -->
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
                <td class="colonne_visi" rowspan="6">
                    <label for="visi_exp"
                           class="control-label">
                        <small class="text-info">Visibilité globale</small>
                    </label>

                    <input type="checkbox" class="form-control checkboxiOS"
                           name="visi_exp"
                           id="visi_exp" />
                </td>
            </tr>

            <tr>
                <td class="formLabel">
                    <label for="date_deb_exp"
                           class="control-label">
                        Date de début&nbsp;<span class="obligatoire">*</span>
                    </label>
                </td>

                <td>
                    <div class="input-group">
                        <input type="text" class="form-control date_deb_fin"
                               name="date_deb_exp"
                               id="date_deb_exp" required />

                        <span class="input-group-addon" onclick="afficherCalendrier($(this));">
                            <i class="icon-calendar icon-border"></i>
                        </span>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="formLabel">
                    <label for="date_fin_exp"
                           class="control-label">
                        Date de fin&nbsp;<span class="obligatoire">*</span>
                    </label>
                </td>

                <td>
                    <div class="input-group">
                        <input type="text" class="form-control date_deb_fin"
                               name="date_fin_exp"
                               id="date_fin_exp" />

                        <span class="input-group-addon" onclick="afficherCalendrier($(this));">
                            <i class="icon-calendar icon-border"></i>
                        </span>
                    </div>
                </td>

                <td colspan="2">
                    <div class="checkbox">
                        <label class="control-label">
                            <input type="checkbox"  class="form-control"
                                   name="enCours_exp"
                                   id="enCours"
                                   onclick="checkboxEnCours('');" />
                            Ceci est mon poste actuel
                        </label>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="formLabel">
                    <label for="inti_exp"
                           class="control-label">
                        Intitulé&nbsp;<span class="obligatoire">*</span>
                    </label>
                </td>

                <td colspan="3">
                    <input type="text" class="form-control"
                           name="inti_exp"
                           id="inti_exp" required />
                </td>
            </tr>

            <tr>
                <td class="formLabel">
                    <label for="entre_exp"
                           class="control-label">
                        Entreprise&nbsp;<span class="obligatoire">*</span>
                    </label>
                </td>

                <td colspan="3">
                    <input type="text" class="form-control"
                           name="entre_exp"
                           id="entre_exp" required />
                </td>
            </tr>

            <tr>
                <td class="formLabel">
                    <label for="ville_exp"
                           class="control-label">
                        Ville&nbsp;<span class="obligatoire">*</span>
                    </label>
                </td>

                <td>
                    <input type="text" class="form-control"
                           name="ville_exp"
                           id="ville_exp" required />
                </td>

                <td class="formLabel">
                    <label for="dep_exp"
                           class="control-label">
                        Département&nbsp;<span class="obligatoire">*</span>
                    </label>
                </td>

                <td>
                    <select name="dep_exp"
                            id="dep_exp"
                            class="form-control" required>
                        <?php
                            foreach ($listeDep as $value) {
                                echo '<option value="' . $value['codeDe'] . '">' . $value['nom'] . "</option>\n";
                            }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td class="colonne_visi">
                    <label for="visi_salaire_exp"
                           class="control-label">
                        <small class="text-info">Visibilité salaire</small>
                    </label>

                    <input type="checkbox" class="form-control checkboxiOS"
                           name="visi_salaire_exp"
                           id="visi_salaire_exp" />
                </td>

                <td class="formLabel">
                    <label for="salaire_exp"
                           class="control-label">
                        Salaire annuel&nbsp;<span class="obligatoire">*</span>
                    </label>
                </td>

                <td>
                    <select name="salaire_exp"
                            id="salaire_exp"
                            class="form-control" required>
                        <?php
                            foreach ($listeTranches as $value) {
                                echo '<option value="' . $value . '">' . $value . "</option>\n";
                            }
                        ?>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
</div> <!-- /.well -->
