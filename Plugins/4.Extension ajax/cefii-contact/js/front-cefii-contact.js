jQuery(document).ready(function(){
    jQuery("#cefiiContactSubmit").click(function() {

        var nomContact = jQuery("#cefii_contact_nom").val();
        var telContact = jQuery("#cefii_contact_tel").val();
        var expReg = /^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/;

        // vérification du contenu des champs
        if((nomContact=="")||(telContact=="")){
            jQuery("#messageWidgetCefiiContact").html('<span style="color:red;">Veuillez entrer un nom et un numéro de téléphone !</span>');
        } else if (expReg.test(telContact) == false ){
            jQuery("#messageWidgetCefiiContact").html('<span style="color:red;">Votre téléphone n\'est pas valide.</span>');
        } else {
            ajaxContact(nomContact,telContact);
        }
    });
});

function ajaxContact(nom,tel) {
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: cefiicontact.ajaxurl,
        data: {
            action: cefiicontact.action,
            nonce: cefiicontact.nonce,
            nom: nom,
            tel: tel},
        success: function(message) {
            jQuery("#messageWidgetCefiiContact").html(message);
            jQuery("#cefii_contact_nom").val("");
            jQuery("#cefii_contact_tel").val(""); 
        }
    });
}
