jQuery(document).ready(function(){

    // le raccourci $('') n'est pas utilisé dans les seleceteurs pour éviter d'éventuels
    // incompatibilités avec d'autres bibliothéques
    // à la place on utilise jQuery('')
    jQuery("#bt-map").click(function(){
        var titre =jQuery("#Cm-title").val().trim();
        var lat =jQuery("#Cm-latitude").val().trim();
        var long =jQuery("#Cm-longitude").val().trim();

        if (titre == ""){
            jQuery("#Cm-title-error").show();
        } else {
            jQuery("#Cm-title-error").hide();
        }

        if ( (lat == "") || isNaN(lat) ){
            jQuery("#Cm-lat-error").show();
        } else {
            jQuery("#Cm-lat-error").hide();
        }

        if ( (long == "") || isNaN(long) ){
            jQuery("#Cm-long-error").show();
        } else {
            jQuery("#Cm-long-error").hide();
        }

        if ( (titre != '') && (lat != '') && (long != '') && !isNaN(lat) && !isNaN(long) ){
            jQuery('#formMap').submit();
        }
    });

    /* bouton de suppression des maps */
    jQuery("#suppr-map").click(function(){
        if(confirm(textJs.confirmation)){
            jQuery('#formSuppr').submit();
        }
    });

    /* selection du shortcode rien qu'en cliquant sur lui */
    jQuery("#placecode input").click(function(){
        jQuery(this).select();
    });    
});