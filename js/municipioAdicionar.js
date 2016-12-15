$(function(){       
    $("form").validate({
        rules: {            
          txtCodigoMunicipioAdic:{
             required: true,
             digits: true,
             minlength: 5,
             maxlength: 5
          },                    
          txtNombreMunicipioAdic:{
             required: true
          },          
          sltNombreDepartamentoAdic: {
              required: true
          }

        },
        messages: {                                              
            txtCodigoMunicipioAdic: { 
                required: "Escriba el Codigo del Municipio",
                digits: "Solo se permiten números",
                minlength: "Minimo 5 digitos",
                maxlength: "Maximo 5 digitos"
            },
            txtNombreMunicipioAdic: "Escriba un nombre de municipio",
            sltNombreDepartamentoAdic: "Seleccione el departamento"
        }
    });
    
 
        
    $("input[name=txtCodigoMunicipioAdic]").change(function(){        
        var valor = $("#txtCodigoMunicipioAdic").val();
        $("#divCodigoVal").empty();
        $("#divCodigoVal").load('/index.php/controladorMunicipio/ValidarCodigo/' + valor);                
    });
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeCodigo = $('#divCodigoVal').is(':empty');      
      if(existeCodigo === false)
        validaCampo = true;
        
      if($("#txtCodigoAdic").val() === "")                    
        validaCampo = true;
    
      if($("#txtNombreMunicipioAdic").val() === "")                    
        validaCampo = true;    
    
      if($("#sltNombreDepartamentoAdic").val() === "")                    
        validaCampo = true;    
    
    

    
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(existeCodigo === false)
            $( "#divError" ).text( "El Codigo de municipio ya existe, escriba uno nuevo." ).show();
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});