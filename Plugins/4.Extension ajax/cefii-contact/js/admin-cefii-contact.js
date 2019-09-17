jQuery(document).ready(function(){
    jQuery(".supprimer").click(function(){
        var id = jQuery(this).parents('tr').attr('id');

        if (confirm("Souhaitez-vous effacer ce contact ?")){
            deleteContact(id);
        }
    });
});

function deleteContact(id) {
    jQuery.ajax({
        type:"POST",
        dataType:"json",
        url: supprContact.ajaxurl,
        data:{
            action: supprContact.action,
            nonce: supprContact.nonce,
            id: id
        },
        success: function(data) {
            jQuery("#message").text(data[0]);
            jQuery("#wp-admin-bar-cefii-contact .ab-label").text(data[1]);
            jQuery("#"+id).fadeOut(300,function(){
            jQuery(this).remove();
            jQuery('tr:odd').css("background","#ccc");
            jQuery('tr:even').css("background","#f1f1f1");
            });
        } 
    }); 
}