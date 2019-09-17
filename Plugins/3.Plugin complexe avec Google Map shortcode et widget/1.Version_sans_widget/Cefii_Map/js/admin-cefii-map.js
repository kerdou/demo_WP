jQuery(document).ready(function(){

    /* au clic à la création d'une carte */
    jQuery("#bt-map").click(function(){
        var titre = jQuery("#Cm-title").val().trim();
        var lat = jQuery("#Cm-latitude").val().trim();
        var long = jQuery("#Cm-longitude").val().trim();

        if(titre==""){
            jQuery("#Cm-title-error").show();
        }else{
            jQuery("#Cm-title-error").hide();
        }

        if((lat=="") || isNaN(lat)){
            jQuery("#Cm-lat-error").show();
        }else{
            jQuery("#Cm-lat-error").hide();
        }

        if((long=="") || isNaN(long)){
            jQuery("#Cm-long-error").show();
        }else{
            jQuery("#Cm-long-error").hide();
        }

        if((titre!='') && (lat!='') && (long!='') && !isNaN(lat) && !isNaN(long)){
            jQuery('#formMap').submit();
        }
    });

    /* au clic du bouton de suppression d'une carte */
    jQuery("#suppr-map").click(function(){
        if(confirm("Souhaitez-vous vraiment supprimer cette carte ?")){
            jQuery('#formSuppr').submit();
        }
    });

    /* au clic sur le champ du shortcode son contenu est automatiquement selectionné */
    jQuery("#placecode input").click(function(){
        jQuery(this).select();
    });

});