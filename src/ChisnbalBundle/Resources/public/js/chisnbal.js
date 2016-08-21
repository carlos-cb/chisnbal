$(function(){
    $(".form-control").keyup(function(){
        $("table tbody tr")
            .hide()
            .filter(":contains('"+( $(this).val() )+"')")
            .show();
    }).keyup();
})

$(document).ready(function() {

    $(".fancybox").fancybox();

});