$(function(){       
    $("form").validate({
        rules: {            
          txtRutAdic:{
             required: true,
             digits: true,
             minlength: 6
          },                    
          txtNombreEmpresaAdic:{
             required: true
          },          
          sltClasificacionEconAdic: {
              required: false
          },
          sltDepartamentoAdic: {
              required: true
          },
          sltMunicipioAdic: {
              required: true
          },          
          sltGrupoEconomAdic: {
              required: true
          },      
          sltEmpresaSegOriCapAdic: {  
              required: false
          },          
          sltEmpresaSegCapAdic: {
              required: false
          },
          txtCorreoAdic:{
             required: false,
             email: true
          }
        },
        messages: {                                              
            txtRutAdic: { 
                required: "Escriba el RUT",
                digits: "Solo se permiten números",
                minlength: "Mínimo 6 digitos"
            },
            txtNombreEmpresaAdic: "Escriba un nombre",
            txtCorreoAdic: "Escriba un email valido",
            txtFechaUltInscrJunDirectivaAdic: "Escriba o seleccione una fecha valida",
            txtFechaAdic: "Escriba o seleccione una fecha valida",
            txtNumeroAfiliadosPorEmpresaAdic: "Solo se permiten números",                        
            sltClasificacionEconAdic: "Seleccione una clasificacion economica",
            sltDepartamentoAdic: "Seleccione un departamento",
            sltMunicipioAdic: "Seleccione un municpio",
            sltGrupoEconomAdic: "Seleccione un grupo economico",
            sltEmpresaSegOriCapAdic: "Seleccione el tipo de capital",
            sltEmpresaSegCapAdic: "Seleccione capital de la empresa"

        }
    });
    
    $("#sltDepartamentoAdic").change(function(event){
        var id = $("#sltDepartamentoAdic").find(':selected').val();
        $("#sltMunicipioAdic").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
        
    $("input[name=txtRutAdic]").change(function(){        
        var valor = $("#txtRutAdic").val();
        $("#divRutVal").empty();
        $("#divRutVal").load('/index.php/controladorEmpresa/ValidarRut/' + valor);                
    });
    
    $('#txtOtroTipoEmpresaAdic').attr('disabled', 'disabled');                
    
    $("#sltEmpresaTipEstAdic").change(function(event){
        var codTipoViolacion = $("#sltEmpresaTipEstAdic").find(':selected').val();
        if(codTipoViolacion === "153")
            $('#txtOtroTipoEmpresaAdic').removeAttr('disabled');
        else
            $('#txtOtroTipoEmpresaAdic').attr('disabled', 'disabled');
        });                     
 
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeRut = $('#divRutVal').is(':empty');      
      if(existeRut === false)
        validaCampo = true;
        
      if($("#txtRutAdic").val() === "")                    
        validaCampo = true;
    
      if($("#txtNombreEmpresaAdic").val() === "")                    
        validaCampo = true;    
    
      if($("#sltDepartamentoAdic").val() === "")                    
        validaCampo = true;
            
      if($("#sltMunicipioAdic").val() === "")                    
        validaCampo = true;          
              
      if($("#sltClasificacionEconAdic").val() === "")                    
        validaCampo = false;
          
      if($("#sltGrupoEconomAdic").val() === "")                    
        validaCampo = true;                    
    
      if($("#sltEmpresaSegOriCapAdic").val() === "")                    
        validaCampo = false;                        
    
      if($("#sltEmpresaSegCapAdic").val() === "")                    
        validaCampo = false;                            
    
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(existeRut === true)
            $( "#divError" ).text( "El RUT ya existe, escriba uno nuevo." ).show();
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});