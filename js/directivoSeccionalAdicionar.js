$(function(){       
    $("form").validate({
        rules: {            
          txtCedulaDirectivoAdic:{
             required: true,
             digits: true,
             minlength: 5
          },                    
          txtNombreApellidoAdic:{
             required: true
          },          
          sltEdadCategoriasAdic: {
              required: true
          },          
          sltCargoDirectivoAdic: {
              required: true
          },                    
          
          sltNivelEducativoAdic: {
              required: true
          },                    
          sltSeccionalDirectivoAdic: {
              required: true
          },                              
          txtFechaNacimientoAdic: {
            required: true

          }


        },
        messages: {                                              
            txtCedulaDirectivoAdic: { 
                required: "Escriba el numero de cedula",
                digits: "Solo se permiten números",
                minlength: "Mínimo 5 digitos"
            },
            txtFechaNacimientoAdic: "Escriba o seleccione una fecha valida",
            txtNombreApellidoAdic: "Escriba el nombre de directivo",            
            sltEdadCategoriasAdic: "Seleccione la edad por categoria",
            sltCargoDirectivoAdic: "Seleccione el cargo",
            sltNivelEducativoAdic: "Seleccione el nivel educativo",            
            sltSeccionalDirectivoAdic: "Seleccione el seccional",                  
            txtNumeroTrabajaEmprAdic: { 
                required: "Escriba el número de empleados correspondientes",
                digits: "Solo se permiten números"
            }
        }
    });
    
    $("#sltDepartamentoAdic").change(function(event){
        var id = $("#sltDepartamentoAdic").find(':selected').val();
        $("#sltMunicipioAdic").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
        
    $("input[name=txtCedulaDirectivoAdic]").change(function(){        
        var valor = $("#txtCedulaDirectivoAdic").val();
        $("#divCedulaVal").empty();
        $("#divCedulaVal").load('/index.php/controladorDirectivoSeccional/ValidarCedula/' + valor);                
    });
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeRut = $('#divCedulaVal').is(':empty');      
      if(existeRut === false)
        validaCampo = true;
        
      if($("#txtCedulaDirectivoAdic").val() === "")                    
        validaCampo = true;


      if($("#sltEdadCategoriasAdic").val() === "")              
        validaCampo = true;    

      if($("#sltCargoDirectivoAdic").val() === "")              
        validaCampo = true;    
    
      if($("#sltNivelEducativoAdic").val() === "")              
        validaCampo = true;        
    
      if($("#sltSeccionalDirectivoAdic").val() === "")              
        validaCampo = true;            
    
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(existeRut === false)
            $( "#divError" ).text( "El Cedula ya existe, escriba uno nuevo." ).show();
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});