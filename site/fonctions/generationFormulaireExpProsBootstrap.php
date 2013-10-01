<?php
    /**
     * Ce fichier permet la génération des
     * formulaires d'expériences professionnelles
     * pour Bootstrap
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    // Récupération de la liste des départements
    $listeDep = listeDepartements();

    // Récupération de la liste des types de diplôme
    $listeTranches = listeTranchesSalaire();

    $expPros = $profil->getExpPros();

    $i = 0;
    foreach ($expPros as $expProEnCours) {
        $i++;
?>
        <!-- ///// ExpPro <?php echo $i; ?> \\\\\ -->
        <input type="hidden" name="id_exp<?php echo $i; ?>" id="id_exp<?php echo $i; ?>"
               value="<?php echo $expProEnCours->getCodeEP(); ?>" />

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
                            <label for="visi_exp<?php echo $i; ?>"
                                   class="control-label">
                                <small class="text-info">Visibilité globale</small>
                            </label>

                            <input type="checkbox" class="form-control checkboxiOS"
                                   name="visi_exp<?php echo $i; ?>"
                                   id="visi_exp<?php echo $i; ?>"
                                   <?php echo $expProEnCours->getVisibilite() ? "checked" : ""; ?> />
                        </td>
                    </tr>

                    <tr>
                        <td class="formLabel">
                            <label for="date_deb_exp<?php echo $i; ?>"
                                   class="control-label">
                                Date de début&nbsp;<span class="obligatoire">*</span>
                            </label>
                        </td>

                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control date_deb_fin"
                                       name="date_deb_exp<?php echo $i; ?>"
                                       id="date_deb_exp<?php echo $i; ?>"
                                       value="<?php echo $expProEnCours->getDateDebut(); ?>" />

                                <span class="input-group-addon" onclick="afficherCalendrier($(this));">
                                    <i class="icon-calendar icon-border"></i>
                                </span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="formLabel">
                            <label for="date_fin_exp<?php echo $i; ?>"
                                   class="control-label">
                                Date de fin&nbsp;<span class="obligatoire">*</span>
                            </label>
                        </td>

                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control date_deb_fin"
                                       name="date_fin_exp<?php echo $i; ?>"
                                       id="date_fin_exp<?php echo $i; ?>"
                                       value="<?php echo $expProEnCours->getDateFin(); ?>" />

                                <span class="input-group-addon" onclick="afficherCalendrier($(this));">
                                    <i class="icon-calendar icon-border"></i>
                                </span>
                            </div>
                        </td>

                        <td colspan="2">
                            <div class="checkbox">
                                <label class="control-label">
                                    <input type="checkbox"  class="form-control"
                                           name="enCours_exp<?php echo $i; ?>"
                                           id="enCours<?php echo $i; ?>"
                                           onclick="checkboxEnCours(<?php echo $i; ?>);"
                                           <?php echo $expProEnCours->getEnCours() ? "checked" : ""; ?> />
                                    Ceci est mon poste actuel
                                </label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="formLabel">
                            <label for="inti_exp<?php echo $i; ?>"
                                   class="control-label">
                                Intitulé&nbsp;<span class="obligatoire">*</span>
                            </label>
                        </td>

                        <td colspan="3">
                            <input type="text" class="form-control"
                                   name="inti_exp<?php echo $i; ?>"
                                   id="inti_exp<?php echo $i; ?>"
                                   value="<?php echo $expProEnCours->getIntitule(); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <td class="formLabel">
                            <label for="entre_exp<?php echo $i; ?>"
                                   class="control-label">
                                Entreprise&nbsp;<span class="obligatoire">*</span>
                            </label>
                        </td>

                        <td colspan="3">
                            <input type="text" class="form-control"
                                   name="entre_exp<?php echo $i; ?>"
                                   id="entre_exp<?php echo $i; ?>"
                                   value="<?php echo $expProEnCours->getEntreprise(); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <td class="formLabel">
                            <label for="ville_exp<?php echo $i; ?>"
                                   class="control-label">
                                Ville&nbsp;<span class="obligatoire">*</span>
                            </label>
                        </td>

                        <td>
                            <input type="text" class="form-control"
                                   name="ville_exp<?php echo $i; ?>"
                                   id="ville_exp<?php echo $i; ?>"
                                   value="<?php echo $expProEnCours->getVille(); ?>" />
                        </td>

                        <td class="formLabel">
                            <label for="dep_exp<?php echo $i; ?>"
                                   class="control-label">
                                Département&nbsp;<span class="obligatoire">*</span>
                            </label>
                        </td>

                        <td>
                            <select name="dep_exp<?php echo $i; ?>"
                                    id="dep_exp<?php echo $i; ?>"
                                    class="form-control">
                                <?php
                                    foreach ($listeDep as $value) {
                                        echo "<option value=\"" . $value['codeDe'] . "\"";
                                        echo strcmp($value['codeDe'], $expProEnCours->getDepartement()) == 0 ? " selected" : "";
                                        echo ">" . $value['nom'] . "</option>\n";
                                    }
                                    ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="colonne_visi">
                            <label for="visi_salaire_exp<?php echo $i; ?>"
                                   class="control-label">
                                <small class="text-info">Visibilité salaire</small>
                            </label>

                            <input type="checkbox" class="form-control checkboxiOS"
                                   name="visi_salaire_exp<?php echo $i; ?>"
                                   id="visi_salaire_exp<?php echo $i; ?>"
                                   <?php echo $expProEnCours->getVisibiliteSalaire() ? "checked" : ""; ?> />
                        </td>

                        <td class="formLabel">
                            <label for="salaire_exp<?php echo $i; ?>"
                                   class="control-label">
                                Salaire annuel&nbsp;<span class="obligatoire">*</span>
                            </label>
                        </td>

                        <td>
                            <select name="salaire_exp<?php echo $i; ?>"
                                    id="salaire_exp<?php echo $i; ?>"
                                    class="form-control">
                                <?php
                                    foreach ($listeTranches as $value) {
                                        echo "<option value=\"" . $value . "\"";
                                        echo strcmp($value, $expProEnCours->getSalaire()) == 0 ? " selected" : "";
                                        echo ">" . $value . "</option>\n";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
<?php
    }
?>
