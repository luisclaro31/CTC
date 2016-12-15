$(function(){    
   
    $("form").validate({
        rules: {
          txtNombresApellidos:{
             required: true
          },                    
          txtCorreo: {
            required: false,
            email: true
          },
          sltGrupoUsuario: {
            required: true
          },
          txtUsuario:{
             required: true
          },
          txtPassword:{
             required: true
          },  
          txtPasswordRep: {
              required: true
          }
        },
        messages: {            
            txtNombresApellidos: "Escriba los nombres y apellidos",
            txtCorreo: "Escriba un email valido",            
            sltGrupoUsuario: "Seleccione un grupo",            
            txtUsuario: "Escriba un nombre de usuario de sesión",                        
            txtPassword: "Solo se permiten números",            
            txtPasswordRep: "Solo se permiten números"
        }
    });
    
    $("input[name=txtPasswordRep]").change(function(){        
        var valor = $("#txtPasswordRep").val();
        $("#divValContrasenyaMod").empty();
        
        if(valor !== $("#txtPassword").val())
        {
            $("#divValContrasenyaMod").text('Las contraseñas no coinciden.');
            $("#txtPasswordRep").focus();
        }
    });
    
    $("input[name=txtPasswordRep]").focusout(function() {
        if($("#txtPasswordRep").val() !== $("#txtPassword").val())
        {
            $("#divValContrasenyaMod").text('Las contraseñas no coinciden.');
            $("#txtPasswordRep").focus();
        }
    });    
    
    $("input[name=txtUsuario]").change(function(){        
        var valor = $("#txtUsuario").val();
        $("#divValUsuarioMod").empty();
        
        if(valor !== $("#txtUsuarioAnt").val())
            $("#divValUsuarioMod").load('/index.php/controladorUsuario/ValidarUsuario/' + valor);                
    }); 
    
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
      
      var existeUsuario = $('#divValUsuarioMod').is(':empty');      
      if(existeUsuario === false)
        validaCampo = true;
      
      if($("#txtNombresApellidos").val() === "")                    
        validaCampo = true;
    
      if($("#sltGrupoUsuario").val() === "")              
        validaCampo = true;      
      
      if($("#txtUsuario").val() === "")              
        validaCampo = true;
    
      if($("#txtPassword").val() === "")              
        validaCampo = true;
              
      if($("#txtPasswordRep").val() === "")                    
        validaCampo = true;
            
      if($("#txtPassword").val() !== $("#txtPasswordRep").val())
        validaCampo = true;      
      
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
         if($("#txtPassword").val() !== $("#txtPasswordRep").val())
             $( "#divErrorMod" ).text( "Las contraseñas no coinciden." ).show();
         else if(existeUsuario === false)
            $( "#divErrorMod" ).text( "El usuario ya existe, escriba uno nuevo." ).show();             
         else
            $( "#divErrorMod" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});