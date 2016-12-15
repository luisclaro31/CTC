$(function(){    
   
    $("form").validate({
        rules: {
          txtNombresApellidosAdic:{
             required: true
          },                    
          txtCorreoAdic: {
            required: false,
            email: true
          },
          sltGrupoUsuarioAdic: {
            required: true
          },
          txtUsuarioAdic:{
             required: true
          },
          txtPasswordAdic:{
             required: true,
             minlength: 6
          },  
          txtPasswordRepAdic: {
              required: true
          }
        },
        messages: {            
            txtNombresApellidosAdic: "Escriba los nombres y apellidos",
            txtCorreoAdic: "Escriba un email valido",            
            sltGrupoUsuarioAdic: "Seleccione un grupo",            
            txtUsuarioAdic: "Escriba un nombre de usuario de sesión",                                    
            txtPasswordAdic: { 
                required: "Escriba una contraseña",
                minlength: "Mínimo 6 caracteres."
            },
            txtPasswordRepAdic: "Escriba una contraseña"
        }
    });
    
    $("input[name=txtPasswordRepAdic]").change(function(){        
        var valor = $("#txtPasswordRepAdic").val();
        $("#divValContrasenya").empty();
        
        if(valor !== $("#txtPasswordAdic").val())
        {
            $("#divValContrasenya").text('Las contraseñas no coinciden.');
            $("#txtPasswordRepAdic").focus();
        }
    });
    
    $("input[name=txtPasswordRepAdic]").focusout(function() {
        if($("#txtPasswordRepAdic").val() !== $("#txtPasswordAdic").val())
        {
            $("#divValContrasenya").text('Las contraseñas no coinciden.');
            $("#txtPasswordRepAdic").focus();
        }
    });    
    
    $("input[name=txtUsuarioAdic]").change(function(){        
        var valor = $("#txtUsuarioAdic").val();
        $("#divValUsuario").empty();
        $("#divValUsuario").load('/index.php/controladorUsuario/ValidarUsuario/' + valor);                
    });    
    
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
      
      var existeUsuario = $('#divValUsuario').is(':empty');      
      if(existeUsuario === false)
        validaCampo = true;
    
      if($("#txtNombresApellidosAdic").val() === "")                    
        validaCampo = true;
    
      if($("#sltGrupoUsuarioAdic").val() === "")              
        validaCampo = true;      
      
      if($("#txtUsuarioAdic").val() === "")              
        validaCampo = true;
    
      if($("#txtPasswordAdic").val() === "")              
        validaCampo = true;
              
      if($("#txtPasswordRepAdic").val() === "")                    
        validaCampo = true;
            
      if($("#txtPasswordAdic").val() !== $("#txtPasswordRepAdic").val())
        validaCampo = true;      
      
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
         if($("#txtPasswordAdic").val() !== $("#txtPasswordRepAdic").val())
             $( "#divError" ).text( "Las contraseñas no coinciden." ).show();
         else if(existeUsuario === false)
            $( "#divError" ).text( "El usuario ya existe, escriba uno nuevo." ).show();             
         else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});