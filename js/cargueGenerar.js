$(function(){       
    $("form").validate({
        rules: {                        

          archivo: {
              required: true
          }          
        },
        messages: {                                              

            archivo: "Adjunte el archivo para generar el cargue"           
        }
    });    

            
    $( "form" ).submit(function( event ) {
      var validaCampo = false;        

    
      if($("#archivo").val() === "")                    
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