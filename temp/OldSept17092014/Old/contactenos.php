<?php 
include("config/codes/functions.php");

$titulo = "Contactenos";
$item = 3;

Cabecera($titulo, $item)
?>

<script type="text/javascript">

  $(document).ready(function () {

//validacion formulario

function maximaLongitud(texto,maxlong)
{
var int_value, out_value;

if (texto.value.length > maxlong)
{
int_value = texto.value;
out_value = int_value.substring(0,maxlong);
texto.value = out_value;
alert("La longitud maxima es de " + maxlong + " caracteres");
return false;
}
return true;
}

//Validar dirección de correo electronico
function validarEmail(valor) {
    if (/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/.test(valor)){
        return valor;
    }
    else {
        return false;
    }
}
//

$("#nombres").focus(function () {
    if($(this).val() == "Nombres:")
         $(this).val("");             
    $(this).css("color","#000");
    $(this).css("background-color","#fff");
});

$("#nombres").blur(function () {
    if($(this).val() == ""){
         $(this).val("Nombres:");
         $(this).css("color","#787878");
    }
});

$("#email").focus(function () {
    if($(this).val() == "E-mail:")
         $(this).val("");
    $(this).css("color","#000");    
    $(this).css("background-color","#fff");
});

$("#email").blur(function () {
    if($(this).val() == ""){
         $(this).val("E-mail:");
         $(this).css("color","#787878");
    }
});

$("#comentarios").focus(function () {
    if($(this).val() == "Comentarios")
         $(this).val("");
    $(this).css("color","#000");
    $(this).css("background-color","#fff");
});

$("#comentarios").blur(function () {
    if($(this).val() == ""){
         $(this).val("Comentarios");
         $(this).css("color","#787878");
    }
});

$("#ciu").focus(function () {
    if($(this).val() == "Ubicacion:")
         $(this).val("");
    $(this).css("color","#000");
    $(this).css("background-color","#fff");
});

$("#ciu").blur(function () {
    if($(this).val() == ""){
         $(this).val("Ubicacion:");
         $(this).css("color","#787878");
    }
});


  $("#validacion").css("display", "none");

$("#env").click(function(){

        if($("#nombres").val() == "" || $("#nombres").val() == "Nombres:" || $("#email").val() == "E-mail:" || validarEmail($("#email").val()) == false
            || $("#ciu").val() == "" || $("#ciu").val() == "Ubicación:"
            || $("#comentarios").val() == "" || $("#comentarios").val() == "Comentarios"){
            
            if($("#nombres").val() == "" || $("#nombres").val() == "Nombres:"){
                $("#nombres").css("background-color","#CDAEAE");
                $("#nombres").css("color","#fff");
            }
            if($("#email").val() == "" || validarEmail($("#email").val()) == false){
                $("#email").css("background-color","#CDAEAE");
                $("#email").css("color","#fff");
            }
            if($("#comentarios").val() == "" || $("#comentarios").val() == "Comentarios"){
                $("#comentarios").css("background-color","#CDAEAE");
                $("#comentarios").css("color","#fff");
            }
            if($("#ciu").val() == "" || $("#ciu").val() == "Ubicación:"){
                $("#ciu").css("background-color","#CDAEAE");
                $("#ciu").css("color","#fff");
            }

            return false;
        }
        else{         
         location.reload();
         document.enviar_comentarios.submit();
        }
    });

});    
</script>
         
<div style="width: 100%; height: 100%;background-image: url('/config/images/fondo-b.jpg');padding-top: 10px;padding-bottom: 10px">
        	
        <div style="-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;CCborderRadius: 5px;width: 80%; background-color: #E9E9E9;border: 2px solid #A1A1A1;text-align: justify;">

                <div style="float: left;font-weight: bold;font-size: 18px;margin-top: 14px;margin-bottom: 10px;width: 100%;margin-left: 25px;"><p>Cont&aacute;ctenos</p></div>
                <div style="clear: both;"></div> 
                <div style="border-top: 1px dashed #666668;padding-top: 25px;padding-left: 45px;">

                <div class="forma" style="float:left;background-color: #ddd;border: 1px solid #B7B7B7;padding: 15px;">
                    <form name="enviar_comentarios" id="enviar_comentarios" action="env.php" target="_blank" method="post">
                    Nombres <b style="color: #C43636;">*</b>
                    <br/>
                    <input type="text" name="nombres" id="nombres" val="" size="35"/>
                    <br/><br/>
                    E-mail <b style="color: #C43636;">*</b>
                    <br/>
                    <input type="text" name="email" id="email" val="" size="35"/>
                    <br/><br/>
                    Ubicaci&oacute;n <b style="color: #C43636;">*</b>
                    <br/>
                    <input type="text" name="ciu" id="ciu" val="" size="35"/>
                    <br/><br/>
                    Mensaje <b style="color: #C43636;">*</b>
                    <br/>
                    <textarea cols="60" rows="10" name="comentarios" id="comentarios"></textarea>
                    <br/><br/>
                    <div align="center">
                        <input type="button" value="Enviar" name="env" id="env" style="width: 120px; height: 25px;" />
                    </div>
                    </form>

            </div>

            <div style="float:left;">
                <div class="forma" style="background-color: #ddd;border: 1px solid #B7B7B7;padding: 15px;margin-left: 15px;width: 330px;">

                    <b style="margin-right: 17px;">Direcci&oacute;n:</b> Cra 18 N. 86A - 14.
                    <br/>
                    <b style="font-weight: normal;margin-left: 85px;">Bogot&aacute;, Colombia.</b>
                    <br/><br/>
                    <b style="margin-right: 50px;">Web:</b> <b style="color: #122ACC;"><a href="index.php" style="color: #122ACC;">www.excellentiam.co</a></b>
                    <br/><br/>
                    <b style="margin-right: 57px;">Tel:</b> 57 1 638 6031 / 3124498231
                    <br/><br/>
                    <b style="margin-right: 37px;">E-mail:</b> <address><a href="mailto:contacto@excellentiam.co"><b style="color: #122ACC;margin-left: 83px;margin-top: -50px;">contacto@excellentiam.co</b></a>
                </div>

                <div class="forma" style="background-color: #ddd;border: 1px solid #B7B7B7;padding: 15px;margin-left: 15px;width: 330px;margin-top: 25px;text-align: center;">
                    Encuentranos en:
                    <br/><br/>
                    <a href="https://www.facebook.com/excellentiam.solucionesempresariales" target="_blank"><img src="/config/images/face.png" width="127" height="65" style="margin-right: 25px;"/></a>
                    <a href="https://twitter.com/excellentiam" target="_blank"><img src="/config/images/twi.png" width="127" height="65"/></a>
                </div>
                </div>


                <div style="clear: both;"></div>

        </div>
                <div style="clear: both;margin-top: 15px;"></div>
                <div style="margin-top: 15px;">&nbsp;&nbsp;&nbsp;</div>       	
        </div>        	
</div>

<?php Fin() ?>