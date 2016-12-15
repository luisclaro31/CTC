$(function(){
$("form").validate({
        rules: {          
          txtNumeroResolucion:{
             required: true
          },            
          txtFecha: {
            required: false,
            date: true
          },
          txtNombreSeccional:{
             required: true
          },
          sltCodDepartamento: {
              required: true
          },
          sltCodMunicipio: {
              required: true
          },
          sltEstado: {
              required: true
          },            
          txtCorreo:{
             required: false,
             email: true
          },                    
          sltTipoSeccional: {
              required: true
          },          
          txtFechaUltimaInscJunta: {
            required: false,
            date: true
          },
          sltPeriodoVigJuntaDirectiva: {
              required: true
          },
          sltBienesInmueblesPropAdic: {
              required: true
          },
          txtFechaUltActualizacionInfAdic: {
            required: false,
            date: true
          },
          sltAfiliacionInt:{
              required: true   
          },
          txtTelefono : { 
              minlength: 7,               
              number: true              
          },          
          txtCelular : { 
              minlength: 10,               
              number: true              
          },          
          txtFax : { 
              minlength: 7,               
              number: true              
          }                              
          
        },
        messages: {                        
            txtNumeroResolucion: { 
                required: "Escriba un n�mero de resoluci�n"
            },                        
            txtFecha: "Escriba o seleccione una fecha valida",            
            txtNombreSeccional: "Escriba un nombre",
            sltCodDepartamento: "Seleccione un departamento",
            sltCodMunicipio: "Seleccione un municpio",
            txtCorreo: "Escriba un email valido",
            sltTipoSeccional: "Seleccione un tipo",            
            txtFechaUltimaInscJunta: "Escriba o seleccione una fecha valida",                                               
            sltPeriodoVigJuntaDirectiva: "Seleccione un periodo de vigencia",
            sltBienesInmueblesPropAdic: "Seleccione un bien inmueble",
            sltEstado: "Seleccione un estado",                        
            txtFechaUltActualizacionInfAdic: "Escriba o seleccione una fecha valida",
            sltAfiliacionInt: "Selecciona una afiliaci�n",
            txtTelefono : { 
                minlength: "El n�mero de tel�fono introducido no es correcto.",
                number: "Solo se permiten n�meros"
            },
            txtCelular : { 
                minlength: "El n�mero de Celular introducido no es correcto.",
                number: "Solo se permiten n�meros"
            },
            txtFax : { 
                minlength: "El n�mero de Fax introducido no es correcto.",
                number: "Solo se permiten n�meros"
            }                                           
        }
    });
    
    $("input[name=txtRutAdic]").change(function(){        
        var valor = $("#txtRutAdic").val();
        $("#divRutVal").empty();
        $("#divRutVal").load('/index.php/controladorSeccional/ValidarRut/' + valor);                
    });
    
    $("#sltCodDepartamento").change(function(event){
        var id = $("#sltCodDepartamento").find(':selected').val();
        $("#sltCodMunicipio").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 

   $(function() {  OtrosBienesInmuebles();
   $("#chkOtrosBienesInmuebles").click(OtrosBienesInmuebles);});

    function OtrosBienesInmuebles() {
    if (this.checked || $("#chkOtrosBienesInmuebles").attr('checked')  ) {
      $('#txtOtrosBienesInmubles').removeAttr('disabled');         
        
    } else {
      
      $('#txtOtrosBienesInmubles').attr('disabled', 'disabled');                
          }
    }    
    
   $(function() {  Otras_secretaria();
   $("#chkOtraSecretaria").click(Otras_secretaria);});

    function Otras_secretaria() {
    if (this.checked || $("#chkOtraSecretaria").attr('checked')  ) {
      $('#txtOtraSecretaria').removeAttr('disabled');         
        
    } else {
      
      $('#txtOtraSecretaria').attr('disabled', 'disabled');                
          }
    }
    
    $(function() {  Estado();
    $("#sltEstado").click(Estado);});
    
    function Estado() {
    if($("#sltEstado").val() === "INACTIVO") {
        
        $('#sltCaracteristicasSeccionalInactivo').removeAttr('disabled');
        
    } else {
      
        $('#sltCaracteristicasSeccionalInactivo').attr('disabled', 'disabled');
          }
    } 
    
    $(function() {  Fusionado();
    $("#sltCaracteristicasSeccionalInactivo").click(Fusionado);});
    
    function Fusionado() {
    if($("#sltCaracteristicasSeccionalInactivo").val() === "SECCIONALFUSIONADA") {
        
        $('#txtNombreSeccionalFusiona').removeAttr('disabled');
        
    } else {
      
        $('#txtNombreSeccionalFusiona').attr('disabled', 'disabled');
          }
    }               
    
    $('#txtFechaUltimaActualizacion').attr('disabled', 'disabled');  
    
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
       
      if($("#txtNumeroResolucion").val() === "")              
        validaCampo = true;      
      
      if($("#txtNombreSeccional").val() === "")              
        validaCampo = true;
              
      if($("#sltCodDepartamento").val() === "")                    
        validaCampo = true;
            
      if($("#sltCodMunicipio").val() === "")                    
        validaCampo = true;      
      
      if($("#sltTipoSeccional").val() === "")              
        validaCampo = true;
    
      if($("#sltPeriodoVigJuntaDirectiva").val() === "")                    
        validaCampo = true;
                         
      if($("#sltEstado").val() === "")                   
        validaCampo = true;      
      
      var codEstado = $("#sltEstado").find(':selected').val();
      if(codEstado === "INACTIVO" && $("#sltCaracteristicasSeccionalInactivo").val() === "")
          validaCampo = true;
      
      if($("#sltBienesInmueblesProp").val() === "")                    
        validaCampo = true;
      
      var codBien = $("#sltBienesInmueblesPropAdic").find(':selected').val();
      if(codBien === "OTROSBIENESINMUEBLES" && $("#txtOtrosBienesInmubles").val() === "")
          validaCampo = true;
                  
      if($("#sltAfiliacionInt").val() === "")                    
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
            $( "#divErrorMod" ).text( "Falta diligenciar el campo Otros Bienes Inmuebles de la pesta�a informaci�n administrativa." ).show();
        }
        else if(codEstado === "INACTIVO" && $("#sltCaracteristicasSeccionalInactivo").val() === "")
        {   
            var index = $('#tabModificar a[href="#about-contentMod"]').parent().index();
            $('#tabModificar').tabs({ active: index });
            $("#sltCaracteristicasSeccionalInactivo").css({'border': "1px solid #A30000"});
            $('#sltCaracteristicasSeccionalInactivo').focus();            
            $( "#divErrorMod" ).text( "Falta diligenciar el campo Caracter�stica  para  Sindicato Inactivo de la pesta�a informaci�n administrativa." ).show();
        }
        else
            $( "#divErrorMod" ).text( "Falta diligenciar campos obligatorios, revisar todas las pesta�as." ).show();
        
        event.preventDefault();        
      }
    });    
});