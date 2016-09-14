function check(){
    var Vcode=parseInt(document.fos_user_registration_form.Vcode.value);
    if(Vcode!='123'){
        alert("El código es incorrecto, por favor, póngase en contacto con el administrador");
        return false;
    }else{
        return true;
    }
}

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
    var qianiva = qianinicial * 1.21;
    $("span#preciofinaliva").html(qianiva.toFixed(2));
    $("span#preciofinalzuizhong").html(qianiva.toFixed(2));
    var qian = 0;
    var yunshufei = 0;
    //读取运输方式
    $("input[name='radio-group']").change(function () {
        if($(this).val() == 1) {
            yunshufei = 0;
        }
        if($(this).val() == 2) {
            yunshufei = 10;
        }
        if($(this).val() == 3) {
            yunshufei = 15;
        }
        var jj1 = $('select#paytype').children('option:selected').val();
        if(jj1 == 3){
            var jj2 = parseFloat($("span#preciofinaliva").text())*1.05 + yunshufei;
        }else{
            var jj2 = parseFloat($("span#preciofinaliva").text()) + yunshufei;
        }
        $("span#preciofinalzuizhong").html(jj2.toFixed(2));
        setgerenshui()
    });
    //最终价格
    $('select#paytype').change(function () {
        var p1 = $(this).children('option:selected').val();//这就是selected的值
        if(p1 == 1)
        {
            qian = qianiva + yunshufei;
        }
        if(p1 == 2)
        {
            qian = qianiva + yunshufei;
        }
        if(p1 == 3)
        {
            qian = qianiva*1.05 + yunshufei;
        }
        $("span#preciofinalzuizhong").html(qian.toFixed(2));
        setgerenshui()
    });
    $("input#gerenshui").change(function(){
        setgerenshui();
    });
    setgerenshui();
    function setgerenshui(){
        var n = $("input#gerenshui:checked").length;
        if(n){
            var h = parseFloat($("span#preciofinalzuizhong").text())*1.052;
            $("span#preciofinalzuizhong").html(h.toFixed(2));
        }
    }
    
});