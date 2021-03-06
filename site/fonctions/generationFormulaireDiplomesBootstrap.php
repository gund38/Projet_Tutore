<?php
    /**
     * Ce fichier permet la génération des
     * formulaires de diplômes pour Bootstrap
     *
     * @author Kévin Bélellou et Nicolas Dubois
     */

    // Récupération de la liste des types de diplôme
    $listeTypes = listeTypesDiplome();

    $diplomes = $profil->getDiplomes();

    $i = 0;
    foreach ($diplomes as $diplomeEnCours) {
        $i++;
?>
        <!-- ///// Diplôme <?php echo $i; ?> \\\\\ -->
        <input type="hidden" name="id_dip<?php echo $i; ?>" id="id_dip<?php echo $i; ?>"
               value="<?php echo $diplomeEnCours->getCodeDi(); ?>" />

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
                            <label for="visi_dip<?php echo $i; ?>"
                                   class="control-label">
                                <small class="text-info">Visibilité globale</small>
                            </label>

                            <input type="checkbox" class="form-control checkboxiOS"
                                   name="visi_dip<?php echo $i; ?>"
                                   id="visi_dip<?php echo $i; ?>"
                                   <?php echo $diplomeEnCours->getVisibilite() ? "checked" : ""; ?> />
                        </td>
                    </tr>

                    <tr>
                        <td class="formLabel">
                            <label for="annee_dip<?php echo $i; ?>"
                                   class="control-label">
                                Année d'obtention&nbsp;<span class="obligatoire">*</span>
                            </label>
                        </td>

                        <td colspan="3">
                            <input type="text" class="form-control"
                                   name="annee_dip<?php echo $i; ?>"
                                   id="annee_dip<?php echo $i; ?>"
                                   maxlength="4" required
                                   value="<?php echo $diplomeEnCours->getAnnee(); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <td class="formLabel">
                            <label for="type_dip<?php echo $i; ?>"
                                   class="control-label">
                                Diplôme obtenu&nbsp;<span class="obligatoire">*</span>
                            </label>
                        </td>

                        <td>
                            <select name="type_dip<?php echo $i; ?>"
                                    id="type_dip<?php echo $i; ?>"
                                    class="form-control" required>
                                <?php
                                    foreach ($listeTypes as $value) {
                                        echo "<option value=\"" . $value . "\"";
                                        echo strcmp($value, $diplomeEnCours->getType()) == 0 ? " selected" : "";
                                        echo ">" . $value . "</option>\n";
                                    }
                                ?>
                            </select>
                        </td>

                        <td class="formLabel">
                            <label for="disc_dip<?php echo $i; ?>"
                                   class="control-label">
                                Discipline&nbsp;<span class="obligatoire">*</span>
                            </label>
                        </td>

                        <td>
                            <input type="text" class="form-control"
                                   name="disc_dip<?php echo $i; ?>"
                                   id="disc_dip<?php echo $i; ?>" required
                                   value="<?php echo $diplomeEnCours->getDiscipline(); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <td class="formLabel">
                            <label for="etabli_dip<?php echo $i; ?>"
                                   class="control-label">
                                Établissement&nbsp;<span class="obligatoire">*</span>
                            </label>
                        </td>

                        <td colspan="3">
                            <input type="text" class="form-control"
                                   name="etabli_dip<?php echo $i; ?>"
                                   id="etabli_dip<?php echo $i; ?>" required
                                   value="<?php echo $diplomeEnCours->getEtablissement(); ?>" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> <!-- /.well -->
<?php
    }
?>
