<?php
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
        <fieldset>
            <table>
                <tr>
                    <th class="colonne_visi">Visibilité publique</th>
                </tr>
                <tr>
                    <td class="colonne_visi" rowspan="6">
                        <input type="checkbox"
                               name="visi_exp<?php echo $i; ?>"
                               id="visi_exp<?php echo $i; ?>"
                               <?php echo $expProEnCours->getVisibilite() ? "checked" : ""; ?> />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="date_deb_exp<?php echo $i; ?>">Date de début&nbsp;:</label>
                    </td>
                    <td>
                        <input type="text"
                               name="date_deb_exp<?php echo $i; ?>"
                               id="date_deb_exp<?php echo $i; ?>"
                               class="date_deb_fin"
                               size="10%" style="min-width: 140px"
                               value="<?php echo $expProEnCours->getDateDebut(); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="date_fin_exp<?php echo $i; ?>">Date de fin&nbsp;:</label>
                    </td>
                    <td colspan="3">
                        <input type="text"
                               name="date_fin_exp<?php echo $i; ?>"
                               id="date_fin_exp<?php echo $i; ?>"
                               class="date_deb_fin"
                               size="10%" style="min-width: 140px"
                               value="<?php echo $expProEnCours->getDateFin(); ?>" />
                        <input type="checkbox"
                               name="enCours_exp<?php echo $i; ?>"
                               id="enCours<?php echo $i; ?>"
                               <?php echo $expProEnCours->getEnCours() ? "checked" : ""; ?> />
                        <label for="enCours_exp<?php echo $i; ?>">Ceci est mon poste actuel</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="inti_exp<?php echo $i; ?>">Intitulé&nbsp;:</label>
                    </td>
                    <td colspan="3">
                        <input type="text"
                               name="inti_exp<?php echo $i; ?>"
                               id="inti_exp<?php echo $i; ?>"
                               size="50%"
                               value="<?php echo $expProEnCours->getIntitule(); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="entre_exp<?php echo $i; ?>">Entreprise&nbsp;:</label>
                    </td>
                    <td colspan="3">
                        <input type="text"
                               name="entre_exp<?php echo $i; ?>"
                               id="entre_exp<?php echo $i; ?>"
                               size="50%"
                               value="<?php echo $expProEnCours->getEntreprise(); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="ville_exp<?php echo $i; ?>">Ville&nbsp;:</label>
                    </td>
                    <td>
                        <input type="text"
                               name="ville_exp<?php echo $i; ?>"
                               id="ville_exp<?php echo $i; ?>"
                               size="15%"
                               value="<?php echo $expProEnCours->getVille(); ?>" />
                    </td>
                    <td>
                        <label for="dep_exp<?php echo $i; ?>">Département&nbsp;:</label>
                    </td>
                    <td>
                        <select name="dep_exp<?php echo $i; ?>"
                                id="dep_exp<?php echo $i; ?>">
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
                        <input type="checkbox"
                               name="visi_salaire_exp<?php echo $i; ?>"
                               id="visi_salaire_exp<?php echo $i; ?>"
                               <?php echo $expProEnCours->getVisibiliteSalaire() ? "checked" : ""; ?> />
                    </td>
                    <td>
                        <label for="salaire_exp<?php echo $i; ?>">Salaire annuel&nbsp;:</label>
                    </td>
                    <td>
                        <select name="salaire_exp<?php echo $i; ?>"
                                id="salaire_exp<?php echo $i; ?>">
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
            </table>
        </fieldset>
        <?php
    }
?>