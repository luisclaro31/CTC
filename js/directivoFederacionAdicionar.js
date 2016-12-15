$(function(){       
    $('#txtOtroCargoAdic').attr('disabled', 'disabled');            
    
        $("#sltCargoDirectivoAdic").change(function(event){
            var codCargo = $("#sltCargoDirectivoAdic").find(':selected').val();
            if(codCargo === "7")
                $('#txtOtroCargoAdic').removeAttr('disabled');
            else
                $('#txtOtroCargoAdic').attr('disabled', 'disabled');
        });             
        
    $("form").validate({
        rules: {            
          txtCedulaDirectivoAdic:{
             required: false,
             digits: true,
             minlength: 5
          },                    
          txtNombreApellidoAdic:{
             required: true
          },          

          sltCargoDirectivoAdic: {
              required: false
          },                    
          
          sltNivelEducativoAdic: {
              required: false
          },                    
          sltFederacionDirectivoAdic: {
              required: false
          }

        },
        messages: {                                              
            txtCedulaDirectivoAdic: { 
                required: "Escriba el numero de cedula",
                digits: "Solo se permiten números",
                minlength: "Mínimo 5 digitos"
            },
            txtNombreApellidoAdic: "Escriba el nombre de directivo",                        
            sltCargoDirectivoAdic: "Seleccione el cargo",
            sltNivelEducativoAdic: "Seleccione el nivel educativo",            
            sltFederacionDirectivoAdic: "Seleccione el federacion",                  
            txtNumeroTrabajaEmprAdic: { 
                required: "Escriba el número de empleados correspondientes",
                digits: "Solo se permiten números"
            }
        }
    });
    
    $("#sltDepartamentoAdic").change(function(event){
        var id = $("#sltDepartamentoAdic").find(':selected').val();
        $("#sltMunicipioAdic").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
        
    $("input[name=txtCedulaDirectivoAdic]").change(function(){        
        var valor = $("#txtCedulaDirectivoAdic").val();
        $("#divCedulaVal").empty();
        $("#divCedulaVal").load('/index.php/controladorDirectivoFederacion/ValidarCedula/' + valor);                
    });
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeRut = $('#divCedulaVal').is(':empty');      
      if(existeRut === false)
        validaCampo = true;
        
      //if($("#txtCedulaDirectivoAdic").val() === "")                    
        //validaCampo = false;
    
      if($("#txtNombreApellidoAdic").val() === "")                    
        validaCampo = true;    

      //if($("#sltCargoDirectivoAdic").val() === "")              
        //validaCampo = false;    
    
      //if($("#sltNivelEducativoAdic").val() === "")              
        //validaCampo = false;        
    
      //if($("#sltFederacionDirectivoAdic").val() === "")              
        //validaCampo = false;            

    
    
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(existeRut === false)
            $( "#divError" ).text( "El RUT ya existe, escriba uno nuevo." ).show();
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});