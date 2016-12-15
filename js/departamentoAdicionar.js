$(function(){       
    $("form").validate({
        rules: {            
          txtCodigoDepartamentoAdic:{
             required: true,
             digits: true,
             minlength: 2,
             maxlength: 2
          },                    
          txtNombreDepartamentoAdic:{
             required: true
          }


        },
        messages: {                                              
            txtCodigoDepartamentoAdic: { 
                required: "Escriba el Codigo del departamento",
                digits: "Solo se permiten números",
                minlength: "Minimo 2 digitos",
                maxlength: "Maximo 2 digitos"
            },
            txtNombreDepartamentoAdic: "Escriba un nombre de departamento"
           
        }
    });
    
 
        
    $("input[name=txtCodigoDepartamentoAdic]").change(function(){        
        var valor = $("#txtCodigoDepartamentoAdic").val();
        $("#divCodigoVal").empty();
        $("#divCodigoVal").load('/index.php/controladorDepartamento/ValidarCodigo/' + valor);                
    });
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeCodigo = $('#divCodigoVal').is(':empty');      
      if(existeCodigo === false)
        validaCampo = true;
        
      if($("#txtCodigoDepartamentoAdic").val() === "")                    
        validaCampo = true;
    
      if($("#txtNombreDepartamentoAdic").val() === "")                    
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