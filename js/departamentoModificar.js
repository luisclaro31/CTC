$(function(){       
    $("form").validate({
        rules: {            
          txtCodigoDepartamento:{
             required: true,
             digits: true,
             minlength: 2,
             maxlength: 2
          },                    
          txtNombreDepartamento:{
             required: true
          }


        },
        messages: {                                              
            txtCodigoDepartamento: { 
                required: "Escriba el Codigo del departamento",
                digits: "Solo se permiten números",
                minlength: "Minimo 2 digitos",
                maxlength: "Maximo 2 digitos"
            },
            txtNombreDepartamento: "Escriba un nombre de departamento"
           
        }
    });
    
 
        
    $("input[name=txtCodigoDepartamento]").change(function(){        
        var valor = $("#txtCodigoDepartamento").val();
        $("#divCodigoVal").empty();
        $("#divCodigoVal").load('/index.php/controladorDepartamento/ValidarCodigo/' + valor);                
    });
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeCodigo = $('#divCodigoVal').is(':empty');      
      if(existeCodigo === false)
        validaCampo = true;
        
      if($("#txtCodigoDepartamento").val() === "")                    
        validaCampo = true;
    
      if($("#txtNombreDepartamento").val() === "")                    
        validaCampo = true;        
    

    
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(existeCodigo === false)
            $( "#divError" ).text( "El Codigo de departamento ya existe, escriba uno nuevo." ).show();
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});