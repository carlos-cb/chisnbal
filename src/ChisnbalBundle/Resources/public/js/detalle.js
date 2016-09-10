$('label').click(function() {
    $(this).parent('li').toggleClass('active');
});

$(function() {
    $("button#buy").click(function () {
        var t = $("ul#colorselect").find("li.active");
        if(t.length > 0){
            var info = new Array(t.length);
            for(var i=0; i<t.length; i++){
                info[i] = $(t[i]).find("h4#colorname").text();
            }
            var path = $(this).attr("data-path");
            var productid = $("div.productid").text();
            var productunit = $("div.productunit").text();
            $.ajax({
                type: 'POST',
                url: path,
                data: {unit: productunit, id: productid, info: info},
                success: function(){
                    alert('success');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    alert('Error: ' +  errorThrown);
                }
            });
        }else{
            alert("Hay que seleccionar por lo menos un color.");
        }
    });
});
