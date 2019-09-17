jQuery(document).ready(function(){

    // gestion de l'apparition de la navbar suivant la largeur de l'écran et suivant son statut caché/visible
    jQuery(window).resize(function () {
        var windowWidth = jQuery(window).width();
        if ((windowWidth > 780) && (jQuery("#menu-menu-principal-horizontal").is(":hidden"))) {
            jQuery("#menu-menu-principal-horizontal").css("display", "flex");
        } else if ((windowWidth < 780) && (jQuery("#menu-menu-principal-horizontal").is(":visible"))) {
            jQuery("#menu-menu-principal-horizontal").css("display", "none");
        }
    });

    // gestion de l'apparition de la navbar en mode mobile en cliquant sur le bouton burger 
    jQuery("#burgerButton").click(function(){
        if (jQuery("#menu-menu-principal-horizontal").is(":hidden")) {
            jQuery("#menu-menu-principal-horizontal").css("display", "flex");
        } else {
            jQuery("#menu-menu-principal-horizontal").css("display", "none");
        }     
    });

});