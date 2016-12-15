$(function(){    
   
    $("form").validate({
        rules: {
            
          sltNombreMenuAdic: {
              required: true
          },            
          sltNombreGrupoAdic: {
              required: true
          }


        },
        messages: {            
                 
            sltNombreMenuAdic: "Seleccione el nombre del menú",            
            sltNombreGrupoAdic: "Seleccione el nombre del menú"            
        }
    });
    

  
    
    $("input[name=txt ]").change(function(){        
        var valor = $("#txt ").val();
        $("#divValMenu").empty();
        $("#divValMenu").load('/index.php/controladorMenu/ValidarMenu/' + valor);                
    });    
    
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
      
      var existeMenu = $('#divValMenu').is(':empty');      
      if(existeMenu === false)
        validaCampo = true;
    
        if($("#sltNombreMenuAdic").val() === "")                    
        validaCampo = true;
    
        if($("#sltNombreGrupoAdic").val() === "")                    
        validaCampo = true;
    
      
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
          if(existeUsuario === false)
            $( "#divError" ).text( "El usuario ya existe, escriba uno nuevo." ).show();             
         else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});