$(function(){       

    $("form").validate({
        rules: {
          txtCedulaVictimaAdic:{
             digits: true,
             minlength: 6
          },            
          
          sltMunicipioHechosAdic: {
              required: true
          },          
          
          sltSiglasSindicatoAdic: {
              required: true
          },                              
          
          sltTipoViolacionAdic: {
              required: true
          },
          
          sltGeneroAdic: {
              required: true
          },          
          
          sltMunicipioAdic: {
              required: true
          },                    
          
          sltDepartamentoHechosAdic: {
              required: true
          },
          
          sltDepartamentoAdic: {
              required: true
          },          
          
          txtNombreVictimaAdic:{
             required: true
          },          
          
          txtResponsablesAdic:{
             required: false
          }

          
        },
        messages: {            
            txtCedulaVictimaAdic: {                 
                digits: "Solo se permiten números",
                minlength: "Mínimo 6 digitos"
            },            
            txtNombreVictimaAdic: "Escriba un nombre", 
            sltMunicipioHechosAdic: "Seleccione un municpio",                        
            sltSiglasSindicatoAdic: "Seleccione las siglas del sindicato",                                               
            sltTipoViolacionAdic: "Seleccione el tipo de violacion",
            sltGeneroAdic: "Seleccione un genero",
            sltMunicipioAdic: "Seleccione un municpio",            
            sltDepartamentoHechosAdic: "Seleccione un departamento",            
            sltDepartamentoAdic: "Seleccione un departamento",                              
            txtResponsablesAdic: "Escriba el responsable"

        }
    });
    
    $('#txtTituloProfesiAdic').attr('disabled', 'disabled');
    
    $("#sltNivelEducativoAdic").change(function(event){
        var codBien = $("#sltNivelEducativoAdic").find(':selected').val();
        if(codBien === "NIVELEDUCATIVO")
            $('#txtTituloProfesiAdic').removeAttr('disabled');
        else
            $('#txtTituloProfesiAdic').attr('disabled', 'disabled');
    }); 
    
    $("#sltDepartamentoAdic").change(function(event){
        var id = $("#sltDepartamentoAdic").find(':selected').val();
        $("#sltMunicipioAdic").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
    
    $("#sltDepartamentoHechosAdic").change(function(event){
        var id = $("#sltDepartamentoHechosAdic").find(':selected').val();
        $("#sltMunicipioHechosAdic").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
        
    $("input[name=txtCedulaVictimaAdic]").change(function(){        
        var valor = $("#txtCedulaVictimaAdic").val();
        $("#divCedulaVal").empty();
        $("#divCedulaVal").load('/index.php/controladorVictima/ValidarCedula/' + valor);                
    });
    
    $('#txtOtroTipoViolacionAdic').attr('disabled', 'disabled');                
    
    
    $("#sltTipoViolacionAdic").change(function(event){
        var codTipoViolacion = $("#sltTipoViolacionAdic").find(':selected').val();
        if(codTipoViolacion === "152")
            $('#txtOtroTipoViolacionAdic').removeAttr('disabled');
        else
            $('#txtOtroTipoViolacionAdic').attr('disabled', 'disabled');
        });                 
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeCedula = $('#divCedulaVal').is(':empty');      
      if(existeCedula === false)
        validaCampo = true;

    
      //if($("#txtResponsablesAdic").val() === "")                    
        //validaCampo = true;        
    
      if($("#sltMunicipioHechosAdic").val() === "")                    
        validaCampo = true;       
    
      if($("#sltSiglasSindicatoAdic").val() === "")              
        validaCampo = true;               
    
      if($("#sltTipoViolacionAdic").val() === "")              
        validaCampo = true;
    
      if($("#sltGeneroAdic").val() === "")              
        validaCampo = true;    
              
      if($("#txtNombreVictimaAdic").val() === "")              
        validaCampo = true;
  
      if($("#sltDepartamentoAdic").val() === "")                    
        validaCampo = true;
      
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(existeCedula === false)
            $( "#divError" ).text( "La Cedula ya existe, escriba una nuevo." ).show();
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});