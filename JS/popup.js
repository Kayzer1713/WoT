
$(document).ready(function(){


  window.setTimeout(function() {
    jQuery(".alert").fadeTo(500, 0).slideUp(500, function(){
        jQuery(this).remove();
    });
}, 4000);
});
