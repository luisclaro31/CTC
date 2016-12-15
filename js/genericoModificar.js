$(function(){       
    $("form").validate({
        rules: {            
          txtCodigo:{
             required: true,
             maxlength: 20
          },                    
          txtDescripcionCategoria:{
             required: true
          },          
          sltNombreCategoria: {
              required: true
          }

        },
        messages: {                                              
            txtDescripcionCategoria: { 
                required: "Escriba el Codigo de la lista de categoria",
                maxlength: "Maximo 20 digitos"
            },
            txtDescripcionCategoria: "Escriba la descripción de categoria",
            sltNombreCategoria: "Seleccione el nombre de categoria"
        }
    });
    
 
        
    
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            

        
      if($("#txtCodigo").val() === "")                    
        validaCampo = true;
    
      if($("#txtDescripcionCategoria").val() === "")                    
        validaCampo = true;    
    
      if($("#sltNombreCategoria").val() === "")                    
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