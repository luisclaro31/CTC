$(function(){       
    $("form").validate({
        rules: {            
          txtCodigoAdic:{
             required: true,
             maxlength: 20
          },                    
          txtDescripcionEstadoAdic:{
             required: true
          },          
          sltNombreEstadoAdic: {
              required: true
          }

        },
        messages: {                                              
            txtDescripcionCategoriaAdic: { 
                required: "Escriba el Codigo de la lista de estado",
                maxlength: "Maximo 20 digitos"
            },
            txtDescripcionEstadoAdic: "Escriba la descripción de estado",
            sltNombreEstadoAdic: "Seleccione el nombre de estado"
        }
    });
    
 
        
    $("input[name=txtCodigoAdic]").change(function(){        
        var valor = $("#txtCodigoAdic").val();
        $("#divCodigoVal").empty();
        $("#divCodigoVal").load('/index.php/controladorEstado/ValidarCodigo/' + valor);                
    });
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeCodigo = $('#divCodigoVal').is(':empty');      
      if(existeCodigo === false)
        validaCampo = true;
        
      if($("#txtCodigoAdic").val() === "")                    
        validaCampo = true;
    
      if($("#txtDescripcionEstadoAdic").val() === "")                    
        validaCampo = true;    
    
      if($("#sltNombreEstadoAdic").val() === "")                    
        validaCampo = true;    
    
    

    
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(existeCodigo === false)
            $( "#divError" ).text( "El Codigo para la lista de estado ya existe, escriba uno nuevo." ).show();
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});