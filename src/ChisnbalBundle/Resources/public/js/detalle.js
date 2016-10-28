$('label').click(function() {
    $(this).parent('li').toggleClass('active');
});

$(function() {
    $("button#buy").click(function () {
        var path = $(this).attr("data-path");
        var productid = $("div.productid").text();
        var productunit = $("div.productunit").text();
        var hunzhuang = $("div.ishunzhuang").text();
        if(hunzhuang){
            var color = "Mezclado";
            $.ajax({
                type: 'POST',
                url: path,
                data: {unit: productunit, id: productid, color: color},
                success: function(){
                    var numselected = $("span.badge").text();
                    $("span.badge").html(parseInt(numselected) + 1);
                    alert("Ya ha añadido en tu carrito.");
                },
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    alert('Error: ' +  errorThrown);
                }
            });
        }else{
            var t = $("ul#colorselect").find("li.active");
            if(t.length > 0){
                var info = new Array(t.length);
                for(var i=0; i<t.length; i++){
                    info[i] = $(t[i]).find("div.colorid").text();
                }
                $.ajax({
                    type: 'POST',
                    url: path,
                    data: {unit: productunit, id: productid, info: info},
                    success: function(){
                        var numselected = $("span.badge").text();
                        var numselect = t.length;
                        $("span.badge").html(parseInt(numselected) + numselect);
                        alert("Ya ha añadido en tu carrito.");
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        alert('Error: ' +  errorThrown);
                    }
                });
            }else{
                alert("Hay que seleccionar por lo menos un color.");
            }
        }
    });
});

window.onload = function(){
    var docH = $(document).height();
    var clientH = document.documentElement.clientHeight;
    var category = document.getElementById('category');
    var column = document.getElementById('purchase-column');
    var fixH = category.offsetHeight;
    var columnH = column.offsetHeight;
    var clientW = document.documentElement.clientWidth;
    var docW = $(document).width();

    function box1(){
        var chazhi = clientH - 250 - fixH;
        var st = $(document).scrollTop();
        if(chazhi >= 0){
            if(st >= 250){
                var sTop = (clientH/docH)*st+250;
                $(".sidebar").css('position','fixed').css('top', '0');
            }else{
                $(".sidebar").css('position','absolute').css('top', '250px')
            }
        }else{
            if(st >= (200-chazhi)){
                $(".sidebar").css('position','fixed').css('bottom', '200px').css('top', 'auto');
            }
            else{
                $(".sidebar").css('position','absolute').css('top', '250px').css('bottom', null);
            }
        }

    }
    function box2(){
        var chazhi2 = clientH - 230 - columnH;
        var st2 = $(document).scrollTop();
        if(chazhi2 >= 0){
            if(st2 >= 230){
                var sTop = (clientH/docH)*st2+230;
                $(".purchase-column").css('position','fixed').css('top', '0');
            }else{
                $(".purchase-column").css('position','absolute').css('top', '230px')
            }
        }else{
            if(st2 >= (100-chazhi2)){
                $(".purchase-column").css('position','fixed').css('bottom', '200px').css('top', 'auto');
            }
            else{
                $(".purchase-column").css('position','absolute').css('top', '230px').css('bottom', null);
            }
        }

    }
    function imgfix(){
        if(clientW >= 1200)
        {
            var ff = $('div.imgdiv').find('img#imgzoom');
            for(var j=0; j<ff.length; j++)
            {
                if((750-$(ff[j]).height()) > 0)
                {
                    var top = (750-$(ff[j]).height())/2;
                    $(ff[j]).css('margin-top',top+'px');
                }
            }
        }

    }
    box1();
    box2();
    imgfix();
    window.onscroll = function (e) {
        box1();
        box2();
    }
};