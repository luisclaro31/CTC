$(function(){       
    $("form").validate({
        rules: {            
          sltSindicaFirmanConvenioAdic: {
              required: true
          },
          sltEmpresaFirmaConvenioAdic: {
              required: true
          }          
        },
        messages: {                                              


            sltSindicaFirmanConvenioAdic: "Seleccione el nombre del sindicato",
            sltEmpresaFirmaConvenioAdic: "Seleccione el nombre de la  empresa"
        }
    });
    
 
        
    
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false; 
      
      if($("#sltSindicaFirmanConvenioAdic").val() === "")
          validaCampo = true;    
      
      if($("#sltEmpresaFirmaConvenioAdic").val() === "")
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