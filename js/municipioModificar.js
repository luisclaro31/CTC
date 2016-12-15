$(function(){       
    $("form").validate({
        rules: {            
          txtCodigoMunicipio:{
             required: true,
             digits: true,
             minlength: 5,
             maxlength: 5
          },                    
          txtNombreMunicipio:{
             required: true
          },          
          sltNombreDepartamento: {
              required: true
          }

        },
        messages: {                                              
            txtCodigoMunicipio: { 
                required: "Escriba el Codigo del Municipio",
                digits: "Solo se permiten números",
                minlength: "Minimo 5 digitos",
                maxlength: "Maximo 5 digitos"
            },
            txtNombreMunicipio: "Escriba un nombre de municipio",
            sltNombreDepartamento: "Seleccione el departamento"
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
        
      if($("#txtCodigo").val() === "")                    
        validaCampo = true;
    
      if($("#txtNombreMunicipio").val() === "")                    
        validaCampo = true;    
    
      if($("#sltNombreDepartamento").val() === "")                    
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