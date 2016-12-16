$(function(){    
   
    $("form").validate({
        rules: {
          txtRutAdic:{
             required: false,
             digits: true,
             minlength: 6
          },
          txtNumeroResolucionAdic:{
             required: false,
             digits: true
          },            
          txtFechaAdic: {
            required: false,
            date: true
          },
          txtNombreFederacionAdic:{
             required: true
          },
            txtSiglaAdic: {
                required: true
            },
          sltDepartamentoAdic: {
              required: true
          },
          sltMunicipioAdic: {
              required: true
          },
          txtCorreoAdic:{
             required: false,
             email: true
          },                    
          sltTipoFederacionAdic: {
              required: true
          },          
          txtFechaUltInscrJunDirectivaAdic: {
            required: false,
            date: true
          },
          sltPeriodoVigJuntaDirectivaAdic: {
              required: true
          },

          txtFechaUltActualizacionInfAdic: {
            required: false,
            date: true
          }
        },
        messages: {            
            txtRutAdic: { 
                required: "Escriba el RUT",
                digits: "Solo se permiten n�meros",
                minlength: "M�nimo 6 digitos"
            },
            txtNumeroResolucionAdic: { 
                required: "Escriba un n�mero de resoluci�n",
                digits: "Solo se permiten n�meros"
            },                        
            txtFechaAdic: "Escriba o seleccione una fecha valida",            
            txtNombreFederacionAdic: "Escriba un nombre",
            sltDepartamentoAdic: "Seleccione un departamento",
            sltMunicipioAdic: "Seleccione un municpio",
            txtCorreoAdic: "Escriba un email valido",
            sltTipoFederacionAdic: "Seleccione un tipo",            
            txtFechaUltInscrJunDirectivaAdic: "Escriba o seleccione una fecha valida",                                               
            sltPeriodoVigJuntaDirectivaAdic: "Seleccione un periodo de vigencia",            
            txtFechaUltActualizacionInfAdic: "Escriba o seleccione una fecha valida"
            
        }
    });
     
    $("input[name=txtRutAdic]").change(function(){        
        var valor = $("#txtRutAdic").val();
        $("#divRutVal").empty();
        $("#divRutVal").load('/index.php/controladorFederacion/ValidarRut/' + valor);                
    });
    
    $("#sltDepartamentoAdic").change(function(event){
        var id = $("#sltDepartamentoAdic").find(':selected').val();
        $("#sltMunicipioAdic").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
    
    $(function() {  Otras_secretaria();
   $("#chkOtraSecretariaAdic").click(Otras_secretaria);});

    function Otras_secretaria() {
    if (this.checked) {
        
        $('#txtOtraSecretariaAdic').removeAttr('disabled');
        
    } else {
      
        $('#txtOtraSecretariaAdic').attr('disabled', 'disabled');
          }
    }
        
    $('#txtOtrosBienesInmueblesAdic').attr('disabled', 'disabled');
    
    $('#txtOtraAfiliacionInternacionalAdic').attr('disabled', 'disabled');                    
    
    $("#sltAfiliacionIntAdic").change(function(event){
        var codTipoViolacion = $("#sltAfiliacionIntAdic").find(':selected').val();
        if(codTipoViolacion === "OTRAAFILFEDERINT")
            $('#txtOtraAfiliacionInternacionalAdic').removeAttr('disabled');
        else
            $('#txtOtraAfiliacionInternacionalAdic').attr('disabled', 'disabled');
        });                             
    
    
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
      
      var existeRut = $('#divRutVal').is(':empty');      
      if(existeRut === false)
        validaCampo = true;
    
      if($("#txtRutAdic").val() === "")                    
        validaCampo = true;
    
      if($("#txtNumeroResolucionAdic").val() === "")              
        validaCampo = true;      
      
      if($("#txtNombreFederacionAdic").val() === "")              
        validaCampo = true;
              
      if($("#sltDepartamentoAdic").val() === "")                    
        validaCampo = true;
            
      if($("#sltMunicipioAdic").val() === "")                    
        validaCampo = true;      
      
      if($("#sltTipoFederacionAdic").val() === "")              
        validaCampo = true;
    
      if($("#sltPeriodoVigJuntaDirectivaAdic").val() === "")                    
        validaCampo = true;

      
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
          if(existeRut === false)
            $( "#divError" ).text( "El RUT ya existe, escriba uno nuevo." ).show();
        else if(codBien === "OTROSBIENESINMUEBLES" && $("#txtOtrosBienesInmueblesAdic").val() === "")
        {            
            //var idx = $('#tabAdicionar a[href="#about-content"]').parent().index();
            //$("#tabAdicionar").tabs( "option", "active", idx);
            var index = $('#tabAdicionar a[href="#about-content"]').parent().index();
            $('#tabAdicionar').tabs({ active: index });
            $("#txtOtrosBienesInmueblesAdic").css({'border': "1px solid #A30000"});
            $('#txtOtrosBienesInmueblesAdic').focus();            
            $( "#divError" ).text( "Falta diligenciar el campo Otros Bienes Inmuebles de la pesta�a informaci�n administrativa." ).show();
        }
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pesta�as." ).show();
        
        event.preventDefault();        
      }
    });
});