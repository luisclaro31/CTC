$(function(){       
    $("form").validate({
        rules: {            
          txtCodigo:{
             required: true,
             maxlength: 20
          },                    
          txtDescripcionEstado:{
             required: true
          },          
          sltNombreEstado: {
              required: true
          }

        },
        messages: {                                              
            txtCodigo: { 
                required: "Escriba el Codigo de la lista de estado",
                maxlength: "Maximo 20 digitos"
            },
            txtDescripcionEstado: "Escriba la descripción de estado",
            sltNombreEstado: "Seleccione el nombre de estado"
        }
    });
    
 
        
    
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            

        
      if($("#txtCodigo").val() === "")                    
        validaCampo = true;
    
      if($("#txtDescripcionEstado").val() === "")                    
        validaCampo = true;    
    
      if($("#sltNombreEstado").val() === "")                    
        validaCampo = true;    
    
    

    
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {

            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
}); 