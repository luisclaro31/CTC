$(function(){    
   
    $("form").validate({
        rules: {
          txtRutAdic:{
             required: true,
             digits: true,
             minlength: 6
          },
          txtDigitoVerificacionAdic:{
             required: true,
             digits: true,
             maxlength: 1
          },                                        
          txtNumeroResolucionAdic:{
             required: true

          },            
          txtFechaAdic: {
            required: false,
            date: true
          },
          txtNombreFederacionAdic:{
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
          sltBienesInmueblesPropAdic: {
              required: true
          },
          txtFechaUltActualizacionInfAdic: {
            required: false,
            date: true
          },
          sltAfiliacionIntAdic:{
              required: true   
          },
          txtTelefonoAdic: { 
              minlength: 7,               
              number: true              
          },          
          txtCelularAdic: { 
              minlength: 10,               
              number: true              
          },          
          txtFaxAdic: { 
              minlength: 7,               
              number: true              
          }                    

        },
        messages: {            
            txtRutAdic: { 
                required: "Escriba el RUT",
                digits: "Solo se permiten números",
                minlength: "Mínimo 6 digitos"
            },
            txtDigitoVerificacionAdic: { 
                required: "Escriba el Digito de Verificación ",
                digits: "Solo se permiten números",
                maxlength: "Maximo 1 digitos"
            },                        
            txtNumeroResolucionAdic: { 
                required: "Escriba un número de resolución"
            },                        
            txtFechaAdic: "Escriba o seleccione una fecha valida",            
            txtNombreFederacionAdic: "Escriba un nombre",
            sltDepartamentoAdic: "Seleccione un departamento",
            sltMunicipioAdic: "Seleccione un municpio",
            txtCorreoAdic: "Escriba un email valido",
            sltTipoFederacionAdic: "Seleccione un tipo",            
            txtFechaUltInscrJunDirectivaAdic: "Escriba o seleccione una fecha valida",                                               
            sltPeriodoVigJuntaDirectivaAdic: "Seleccione un periodo de vigencia",
            sltBienesInmueblesPropAdic: "Seleccione un bien inmueble",
            txtFechaUltActualizacionInfAdic: "Escriba o seleccione una fecha valida",
            sltAfiliacionIntAdic: "Selecciona una afiliación",
            txtTelefonoAdic : { 
                minlength: "El número de teléfono introducido no es correcto.",
                number: "Solo se permiten números"
            },
            txtCelularAdic : { 
                minlength: "El número de Celular introducido no es correcto.",
                number: "Solo se permiten números"
            },
            txtFaxAdic : { 
                minlength: "El número de Fax introducido no es correcto.",
                number: "Solo se permiten números"
            }            
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
    
   $(function() {  OtrosBienesInmuebles();
   $("#chkOtrosBienesInmueblesAdic").click(OtrosBienesInmuebles);});

    function OtrosBienesInmuebles() {
    if (this.checked) {
        
        $('#txtOtrosBienesInmueblesAdic').removeAttr('disabled');
        
    } else {
      
        $('#txtOtrosBienesInmueblesAdic').attr('disabled', 'disabled');
          }
    }           
    
   $(function() {  Otras_secretaria();
   $("#chkOtraSecretariaAdic").click(Otras_secretaria);});

    function Otras_secretaria() {
    if (this.checked) {
        
        $('#txtOtraSecretariaAdic').removeAttr('disabled');
        
    } else {
      
        $('#txtOtraSecretariaAdic').attr('disabled', 'disabled');
          }
    }

    
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
    
      if($("#txtDigitoVerificacionAdic").val() === "")                    
        validaCampo = true;        
              
      if($("#sltDepartamentoAdic").val() === "")                    
        validaCampo = true;
            
      if($("#sltMunicipioAdic").val() === "")                    
        validaCampo = true;      
      
      if($("#sltTipoFederacionAdic").val() === "")              
        validaCampo = true;
    
      if($("#sltPeriodoVigJuntaDirectivaAdic").val() === "")                    
        validaCampo = true;
                         
      if($("#sltBienesInmueblesPropAdic").val() === "")                    
        validaCampo = true;
      
      var codBien = $("#sltBienesInmueblesPropAdic").find(':selected').val();
      if(codBien === "OTROSBIENESINMUEBLES" && $("#txtOtrosBienesInmueblesAdic").val() === "")
          validaCampo = true;
                  
      if($("#sltAfiliacionIntAdic").val() === "")                    
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
            $( "#divError" ).text( "Falta diligenciar el campo Otros Bienes Inmuebles de la pestaña información administrativa." ).show();
        }
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});