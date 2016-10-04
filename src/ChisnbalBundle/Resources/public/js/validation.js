
function checkform(){
    var name = document.orderinfo.name.value;
    var phonenumber = document.orderinfo.phonenumber.value;
    var province = document.orderinfo.email.value;
    var city = document.orderinfo.city.value;
    var address = document.orderinfo.address.value;
    var postcode = document.orderinfo.postcode.value;
    if(name.length == 0 || phonenumber.length == 0 || province.length == 0 || city.length == 0 || address.length == 0 || postcode.length == 0){
        alert("Por favor, rellene este formulario.");
        return false;
    }else{
        return true;
    }
}
$(document).ready(function() {
    var qianinicial = parseFloat($("span#preciofinal").text());
    var qianiva = qianinicial * 0.21;
    var k3 = $("input#shipfee").val();
    $("span#preciofinaliva").html(qianiva.toFixed(2));
    //读取运输方式
    $("input[name='radio-group']").change(function () {
        k3 = parseInt($(this).val());
        $("input#shipfee").val(k3);
        setAll();
    });
    $('select#paytype').change(function () {
        setAll();
    });
    $("input#gerenshui").change(function(){
        setAll();
    });
    function setAll(){
        var k1 = $('select#paytype').children('option:selected').val();
        var k2 = $("input#gerenshui:checked").length;
        if(k1 == 3){
            v1 = 1.03;
        }else{
            v1 = 1;
        }

        if(k2 == 1){
            v2 = 1.052;
        }else{
            v2 = 1;
        }
        switch(k3)
        {
            case 2:
                v3 = 10;
                break;
            case 3:
                v3 = 15;
                break;
            default:
                v3 = 0;
        }
        var f00 = qianinicial * 1.21;
        var f0 = f00 * v2;
        var f1 = f0 * v1;
        var f2 = f1 + v3;
        $("span#preciore").html((f0 - f00).toFixed(2));
        $("span#preciogasto").html((f2 - f0).toFixed(2));
        $("span#preciofinalzuizhong").html(f2.toFixed(2));
    }
    setAll();
});