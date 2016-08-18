$(document).ready(function(){
    $("a.various").fancybox({
        beforeShow: function(){
            $(".fancybox-skin").css("backgroundColor","transparent");
        },
        closeBtn: false
    });
    $("div.login").click(function(){
        var path = $(this).attr("data-path");
        window.location.replace(path);
    })
});