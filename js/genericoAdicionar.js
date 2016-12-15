$(function(){       
    $("form").validate({
        rules: {            
          txtCodigoAdic:{
             required: true,
             maxlength: 20
          },                    
          txtDescripcionCategoriaAdic:{
             required: true
          },          
          sltNombreCategoriaAdic: {
              required: true
          }

        },
        messages: {                                              
            txtDescripcionCategoriaAdic: { 
                required: "Escriba el Codigo de la lista de categoria",
                maxlength: "Maximo 20 digitos"
            },
            txtDescripcionCategoriaAdic: "Escriba la descripción de categoria",
            sltNombreCategoriaAdic: "Seleccione el nombre de categoria"
        }
    });
    
 
        
    $("input[name=txtCodigoAdic]").change(function(){        
        var valor = $("#txtCodigoAdic").val();
        $("#divCodigoVal").empty();
        $("#divCodigoVal").load('/index.php/controladorGenerico/ValidarCodigo/' + valor);                
    });
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeCodigo = $('#divCodigoVal').is(':empty');      
      if(existeCodigo === false)
        validaCampo = true;
        
      if($("#txtCodigoAdic").val() === "")                    
        validaCampo = true;
    
      if($("#txtDescripcionCategoriaAdic").val() === "")                    
        validaCampo = true;    
    
      if($("#sltNombreCategoriaAdic").val() === "")                    
        validaCampo = true;    
    
    

    
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(existeCodigo === false)
            $( "#divError" ).text( "El Codigo para la lista de categoria ya existe, escriba uno nuevo." ).show();
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});