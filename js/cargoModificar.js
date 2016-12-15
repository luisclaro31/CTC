$(function(){       
    $("form").validate({
        rules: {            

          txtNombreCargo:{
             required: true
          }


        },
        messages: {                                              

            txtNombreCargo: "Escriba el nombre del cargo"

        }
    });

        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
    
      if($("#txtNombreCargo").val() === "")                    
        validaCampo = true;    
    

      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(existeCodigo === false)

            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});