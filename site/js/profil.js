// Système de changement d'onglet
function change_onglet(name) {
    document.getElementById('onglet_' + anc_onglet).className = 'onglet_0 onglet';
    document.getElementById('onglet_' + name).className = 'onglet_1 onglet';
    document.getElementById('contenu_onglet_' + anc_onglet).style.display = 'none';
    document.getElementById('contenu_onglet_' + name).style.display = 'block';

    anc_onglet = name;
}

// Désactivation du champ 'Photo de profil' si la checkbox
// 'Supprimer photo' est cochée (et vice-versa)
function checkboxDeletePhoto() {
    if (document.getElementById('supprimer_photo').checked) {
        document.getElementById('photo').disabled = 'disabled';
    } else {
        document.getElementById('photo').disabled = '';
    }
}

// Désactivation des champs 'Date de fin' si la checkbox
// 'En cours' associée est cochée (et vice-versa)
function checkboxEnCours(id) {
    if (document.getElementById('enCours' + id).checked) {
        $("#date_fin_exp" + id).datepicker("option", "disabled", true);
    } else {
        $("#date_fin_exp" + id).datepicker("option", "disabled", false);
    }
}

// Vérification de l'état des checkbox 'En cours' au chargement de la page
function verificationCheckbox() {
    var nbExpPros = document.forms.formProfil.nbExpPros.value;

    for (var i = 1; i < nbExpPros; i++) {
        checkboxEnCours(i);
    }
}

// Réinitialisation du profil
function resetFormulaire() {
    if (confirm("Réinitialiser votre profil supprimera toutes vos informations\n" +
            "(Informations personnelles, Parcours scolaire et Parcours professionnel).\n" +
            "Cette action est irréversible.\n" +
            "Êtes-vous sûr de vouloir faire ça ?")){
        //document.getElementById('formProfil').reset();
    }
}

// Affichage et configuration des checkbox style iOS
$(window).ready(function() {
    $('.colonne_visi :checkbox').iphoneStyle({
        resizeContainer: false,
        resizeHandle: false,
        checkedLabel: 'Oui',
        uncheckedLabel: 'Non'
    });
});

// Configuration des calendriers
$(function() {
    // Mettre les calendriers en français
    $.datepicker.setDefaults($.datepicker.regional[ "fr" ]);

    // Configuration calendrier "Date de naissance"
    $("#date_naiss").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        showOn: "both",
        buttonImage: "images/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Calendrier",
        defaultDate: -8395,
        minDate: new Date(1900, 1 - 1, 1),
        maxDate: 0,
        dateFormat: "dd/mm/yy"
    });

    // Configuration calendrier "Date de début - fin"
    $(".date_deb_fin").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        showOn: "both",
        buttonImage: "images/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Calendrier",
        minDate: new Date(1900, 1 - 1, 1),
        maxDate: 0,
        dateFormat: "dd/mm/yy"
    });

    // Anciens paramètres, sélection uniquement du mois et de l'année
    // Désactivés car trop ennuyeux à utiliser pour la base de données
    /* *********************
    $(".date_deb_fin").datepicker({
        changeMonth: true,
        changeYear: true,
        showOn: "both",
        buttonImage: "images/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Calendrier",
        showButtonPanel: true,
        dateFormat: 'MM yy',
        minDate: new Date(1900, 1 - 1, 1),
        maxDate: 0,
        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });

    $(".date_deb_fin").focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
        });
    });
    ********************* */
});
