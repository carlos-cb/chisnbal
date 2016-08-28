$(document).ready(function(){
    $("a.various").fancybox({
        beforeShow: function(){
            $(".fancybox-skin").css("backgroundColor","transparent");
        },
        closeBtn: false
    });
});