$(function(){    
$("form").validate({
        rules: {          
          txtNumeroResolucion:{
             required: true,
             digits: true
          },            
          txtFecha: {
            required: false,
            date: true
          },
          txtNombreFederacion:{
             required: true
          },
          sltCodDepartamento: {
              required: true
          },
          sltCodMunicipio: {
              required: true
          },
          txtCorreo:{
             required: false,
             email: true
          },                    
          sltTipoFederacion: {
              required: true
          },          
          txtFechaUltimaInscJunta: {
            required: false,
            date: true
          },
          sltPeriodoVigJuntaDirectiva: {
              required: true
          },
          txtFechaUltActualizacionInfAdic: {
            required: false,
            date: true
          }
        },
        messages: {                        
            txtNumeroResolucion: { 
                required: "Escriba un número de resolución",
                digits: "Solo se permiten números"
            },                        
            txtFecha: "Escriba o seleccione una fecha valida",            
            txtNombreFederacion: "Escriba un nombre",
            sltCodDepartamento: "Seleccione un departamento",
            sltCodMunicipio: "Seleccione un municpio",
            txtCorreo: "Escriba un email valido",
            sltTipoFederacion: "Seleccione un tipo",            
            txtFechaUltimaInscJunta: "Escriba o seleccione una fecha valida",                                               
            sltPeriodoVigJuntaDirectiva: "Seleccione un periodo de vigencia",            
            txtFechaUltActualizacionInfAdic: "Escriba o seleccione una fecha valida"
            
        }
    });
    
    $("input[name=txtRut]").change(function(){        
        var valor = $("#txtRut").val();
        $("#divRutVal").empty();
        $("#divRutVal").load('/index.php/controladorFederacion/ValidarRut/' + valor);                
    });
    
    $("#sltCodDepartamento").change(function(event){
        var id = $("#sltCodDepartamento").find(':selected').val();
        $("#sltCodMunicipio").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
    
   $(function() {  Otras_secretaria();
   $("#chkOtraSecretaria").click(Otras_secretaria);});
   
    $('#txtOtraAfiliacionInternacional').attr('disabled', 'disabled');                       
    $("#sltAfiliacionInt").change(function(event){
        var codTipoViolacion = $("#sltAfiliacionInt").find(':selected').val();
        if(codTipoViolacion === "OTRAAFILFEDERINT")
            $('#txtOtraAfiliacionInternacional').removeAttr('disabled');
        else
            $('#txtOtraAfiliacionInternacional').attr('disabled', 'disabled');
        });                                     

    function Otras_secretaria() {
    if (this.checked || $("#chkOtraSecretaria").attr('checked')  ) {
      $('#txtOtraSecretaria').removeAttr('disabled');         
        
    } else {
      
      $('#txtOtraSecretaria').attr('disabled', 'disabled');                
          }
    }    
    
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
       
      if($("#txtNumeroResolucion").val() === "")              
        validaCampo = true;      
      
      if($("#txtNombreFederacion").val() === "")              
        validaCampo = true;
              
      if($("#sltCodDepartamento").val() === "")                    
        validaCampo = true;
            
      if($("#sltCodMunicipio").val() === "")                    
        validaCampo = true;      
      
      if($("#sltTipoFederacion").val() === "")              
        validaCampo = true;
    
      if($("#sltPeriodoVigJuntaDirectiva").val() === "")                    
        validaCampo = true;
                         
      if($("#sltEstado").val() === "")                   
        validaCampo = true;      
      
      var codEstado = $("#sltEstado").find(':selected').val();
      if(codEstado === "INACTIVO" && $("#sltCaracteristicasFederacionInactivo").val() === "")
          validaCampo = true;
      
      if(validaCampo === false)
      {
        $( "#divErrorMod" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(codBien === "OTROSBIENESINMUEBLES" && $("#txtOtrosBienesInmubles").val() === "")
        {            
            var index = $('#tabModificar a[href="#about-contentMod"]').parent().index();
            $('#tabModificar').tabs({ active: index });
            $("#txtOtrosBienesInmubles").css({'border': "1px solid #A30000"});
            $('#txtOtrosBienesInmubles').focus();            
            $( "#divErrorMod" ).text( "Falta diligenciar el campo Otros Bienes Inmuebles de la pestaña información administrativa." ).show();
        }
        else if(codEstado === "INACTIVO" && $("#sltCaracteristicasFederacionInactivo").val() === "")
        {   
            var index = $('#tabModificar a[href="#about-contentMod"]').parent().index();
            $('#tabModificar').tabs({ active: index });
            $("#sltCaracteristicasFederacionInactivo").css({'border': "1px solid #A30000"});
            $('#sltCaracteristicasFederacionInactivo').focus();            
            $( "#divErrorMod" ).text( "Falta diligenciar el campo Característica  para  Sindicato Inactivo de la pestaña información administrativa." ).show();
        }
        else
            $( "#divErrorMod" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });    
});