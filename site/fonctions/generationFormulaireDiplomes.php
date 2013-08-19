<?php
    /**
     * Ce fichier permet la génération des
     * formulaires de diplômes
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

        <!-- ///// Diplome <?php echo $i; ?> \\\\\ -->
        <input type="hidden" name="id_dip<?php echo $i; ?>" id="id_dip<?php echo $i; ?>"
               value="<?php echo $diplomeEnCours->getCodeDi(); ?>" />
        <fieldset>
            <table>
                <tr>
                    <th class="colonne_visi">Visibilité publique</th>
                </tr>
                <tr>
                    <td class="colonne_visi" rowspan="4">
                        <label for="visi_dip<?php echo $i; ?>">
                            <center>
                                <small>Visibilité globale</small>
                            </center>
                        </label>
                        <input type="checkbox"
                               name="visi_dip<?php echo $i; ?>"
                               id="visi_dip<?php echo $i; ?>"
                               <?php echo $diplomeEnCours->getVisibilite() ? "checked" : ""; ?> />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="annee_dip<?php echo $i; ?>">Année d'obtention&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                    </td>
                    <td colspan="3">
                        <input type="text"
                               name="annee_dip<?php echo $i; ?>"
                               id="annee_dip<?php echo $i; ?>"
                               maxlength="4" size="5%" style="min-width: 60px"
                               value="<?php echo $diplomeEnCours->getAnnee(); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="type_dip<?php echo $i; ?>">Diplôme obtenu&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                    </td>
                    <td>
                        <select name="type_dip<?php echo $i; ?>"
                                id="type_dip<?php echo $i; ?>">
                            <?php
                                foreach ($listeTypes as $value) {
                                    echo "<option value=\"" . $value . "\"";
                                    echo strcmp($value, $diplomeEnCours->getType()) == 0 ? " selected" : "";
                                    echo ">" . $value . "</option>\n";
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <label for="disc_dip<?php echo $i; ?>">Discipline&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                    </td>
                    <td>
                        <input type="text"
                               name="disc_dip<?php echo $i; ?>"
                               id="disc_dip<?php echo $i; ?>"
                               value="<?php echo $diplomeEnCours->getDiscipline(); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="etabli_dip<?php echo $i; ?>">Établissement&nbsp;<span class="obligatoire">*</span>&nbsp;:</label>
                    </td>
                    <td colspan="3">
                        <input type="text"
                               name="etabli_dip<?php echo $i; ?>"
                               id="etabli_dip<?php echo $i; ?>"
                               size="30%"
                               value="<?php echo $diplomeEnCours->getEtablissement(); ?>" />
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
?>
