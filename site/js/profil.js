// Fonction pour le système de changement d'onglet
function change_onglet(name) {
    document.getElementById('onglet_' + anc_onglet).className = 'onglet_0 onglet';
    document.getElementById('onglet_' + name).className = 'onglet_1 onglet';
    document.getElementById('contenu_onglet_' + anc_onglet).style.display = 'none';
    document.getElementById('contenu_onglet_' + name).style.display = 'block';
    anc_onglet = name;
}

// Fonction qui désactive les champs 'Date de fin' si la checkbox
// 'En cours' associée est cochée (et vice-versa)
function checkboxEnCours(id) {
    if (document.getElementById('enCours' + id).checked){
        $("#date_fin_exp" + id).datepicker("option", "disabled", true);
    } else {
        $("#date_fin_exp" + id).datepicker("option", "disabled", false);
    }
}

// Fonction pour la réinitialisation du profil
function resetFormulaire() {
    if (confirm("Réinitialiser votre profil supprimera toutes vos informations\n" +
            "(Informations personnelles, Parcours scolaire et Parcours professionnel).\n" +
            "Cette action est irréversible.\n" +
            "Êtes-vous sûr de vouloir faire ça ?")){
        //document.getElementById('formProfil').reset();
    }
}
