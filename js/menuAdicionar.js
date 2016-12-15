$(function(){    
   
    $("form").validate({
        rules: {
          txtNombreMenuAdic:{
             required: true
          },                    
          txtUrlAdic:{
             required: true
          },                              
          txtNivelMenuAdic:{
             required: true,
             digits: true
          },          
          txtOrdenAdic:{
             required: true,
             digits: true
          },                    
          txtIdMenuPadreAdic:{
             required: true,
             digits: true
          },                                        
          



        },
        messages: {            
            txtNivelMenuAdic: { 
                required: "Escriba el nivel de menu",
                digits: "Solo se permiten números"
            },            
            txtOrdenAdic: { 
                required: "Escriba el orden de menu",
                digits: "Solo se permiten números"
            },                        
            txtIdMenuPadreAdic: { 
                required: "Escriba el id menú padre",
                digits: "Solo se permiten números"
            },                                    
            txtNombreMenuAdic: "Escriba el nombre de menu",
            txtUrlAdic: "Escriba la url de menu",                        
            txtPasswordRepAdic: "Escriba una contraseña"
        }
    });
    

  
    
    $("input[name=txtAdic]").change(function(){        
        var valor = $("#txtAdic").val();
        $("#divValMenu").empty();
        $("#divValMenu").load('/index.php/controladorMenu/ValidarMenu/' + valor);                
    });    
    
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
      
      var existeMenu = $('#divValMenu').is(':empty');      
      if(existeMenu === false)
        validaCampo = true;
    
      if($("#txtNombNumeroresApellidosAdic").val() === "")                    
        validaCampo = true;
    
      if($("#txtNivelMenuAdic").val() === "")              
        validaCampo = true;          
    
      if($("#txtOrdenAdic").val() === "")              
        validaCampo = true;              
    
      if($("#txtIdMenuPadreAdic").val() === "")              
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