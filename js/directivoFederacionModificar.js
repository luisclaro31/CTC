$(function(){       
    
    $('#txtOtroCargo').attr('disabled', 'disabled');            
    
        $("#sltCargoDirectivo").change(function(event){
            var codCargo = $("#sltCargoDirectivo").find(':selected').val();
            if(codCargo === "7")
                $('#txtOtroCargo').removeAttr('disabled');
            else
                $('#txtOtroCargo').attr('disabled', 'disabled');
        });             
        
    $("form").validate({
        rules: {            
          txtCedulaDirectivo :{
             required: false,
             digits: true,
             minlength: 5
          },                    
          txtNombreApellido :{
             required: true
          },          

          sltCargoDirectivo : {
              required: false
          },                    
          
          sltNivelEducativo : {
              required: false
          },                    
          sltFedeacionDirectivo : {
              required: false
          }

        },
        messages: {                                              
            txtCedulaDirectivo : { 
                required: "Escriba el numero de cedula",
                digits: "Solo se permiten números",
                minlength: "Mínimo 5 digitos"
            },            
            txtNombreApellido : "Escriba el nombre de directivo",                        
            sltCargoDirectivo : "Seleccione el cargo",
            sltNivelEducativo : "Seleccione el nivel educativo",            
            sltFedeacionDirectivo : "Seleccione el federacion",                  
            txtNumeroTrabajaEmpr : { 
                required: "Escriba el número de empleados correspondientes",
                digits: "Solo se permiten números"
            }
        }
    });
    
    $("#sltDepartamento ").change(function(event){
        var id = $("#sltDepartamento ").find(':selected').val();
        $("#sltMunicipio ").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
        
    $("input[name=txtCedulaDirectivo ]").change(function(){        
        var valor = $("#txtCedulaDirectivo ").val();
        $("#divCedulaVal").empty();
        $("#divCedulaVal").load('/index.php/controladorDirectivoFederacion/ValidarCedula/' + valor);                
    });
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeRut = $('#divCedulaVal').is(':empty');      
      if(existeRut === false)
        validaCampo = true;
        
      if($("#txtCedulaDirectivo ").val() === "")                    
        validaCampo = false;
    /*
      if($("#sltCargoDirectivo ").val() === "")              
        validaCampo = false;    
    
      if($("#sltNivelEducativo ").val() === "")              
        validaCampo = false;        
    
      if($("#sltFedeacionDirectivo").val() === "")              
        validaCampo = false;            
    */
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