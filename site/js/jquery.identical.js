;(function($, window, document, undefined) {
    $.identical = function(settings) {
        var config = {
            // Variables
            'mdpBase'       :   '#mdpBase',
            'mdpVerif'      :   '#mdpVerif',
            'resultat'      :   '#resultat',

            // Messages
            'ok'            :   'Les mots de passe sont identiques',
            'pasOk'         :   'Les mots de passe ne sont pas identiques',

            // Couleurs
            'couleurOk'     :   '#23FA0F',
            'couleurPasOk'  :   '#FF0000'
        };

        if (settings) {
            settings = jQuery.extend(config, settings);
        }

        // Variables
        var mdpBase = jQuery(settings.mdpBase);
        var mdpVerif = jQuery(settings.mdpVerif);
        var resultat = jQuery(settings.resultat);

        jQuery(mdpVerif).keyup(function() {
            jQuery(resultat.html(checkIdentical(jQuery(mdpVerif).val(), jQuery(mdpBase).val())));
        });

        function checkIdentical(verif, base) {
            // Si les 2 mdp sont identiques
            if (verif == base) {
                jQuery(mdpVerif).css('background', settings.couleurOk);
                return settings.ok;
            } else {
                jQuery(mdpVerif).css('background', settings.couleurPasOk);
                return settings.pasOk;
            }
        }

        return this;
    };
})(jQuery, window, document);