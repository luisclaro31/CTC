$(function(){    
   
    $("form").validate({
        rules: {
          txtNombreMenu :{
             required: true
          },                    
          txtUrl :{
             required: true
          },                              
          txtNivelMenu :{
             required: true,
             digits: true
          },          
          txtOrden :{
             required: true,
             digits: true
          },                    
          txtIdMenuPadre :{
             required: true,
             digits: true
          }


        },
        messages: {            
            txtNivelMenu : { 
                required: "Escriba el nivel de menu",
                digits: "Solo se permiten números"
            },            
            txtOrden : { 
                required: "Escriba el orden de menu",
                digits: "Solo se permiten números"
            },                        
            txtIdMenuPadre : { 
                required: "Escriba el id menú padre",
                digits: "Solo se permiten números"
            },                                    
            txtNombreMenu : "Escriba el nombre de menu",
            txtUrl : "Escriba la url de menu",                        
            txtPasswordRep : "Escriba una contraseña"
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
    
      if($("#txtNombNumeroresApellidos ").val() === "")                    
        validaCampo = true;
    
      if($("#txtNivelMenu ").val() === "")              
        validaCampo = true;          
    
      if($("#txtOrden ").val() === "")              
        validaCampo = true;              
    
      if($("#txtIdMenuPadre ").val() === "")              
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