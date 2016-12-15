$(function(){    
   
    $("form").validate({
        rules: {
          txtUsuario:{
             required: true
          },                    
          txtPassword: {
            required: true
          }
        },
        messages: {            
            txtUsuario: "Escriba un usuario.",
            txtPassword: "Digite una contraseña"
        }
    });     
});