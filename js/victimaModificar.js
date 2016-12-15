$(function(){       
    $("form").validate({
        rules: {
          txtCedulaVictima:{
             digits: true,
             minlength: 6
          },            
          
          sltMunicipioHechos: {
              required: true
          },          

          sltSiglasSindicato: {
              required: true
          },                              
          
          sltTipoViolacion: {
              required: true
          },
          
          sltGenero: {
              required: true
          },          
          
          sltMunicipio: {
              required: true
          },                    
          
          sltDepartamentoHechos: {
              required: true
          },
          
          sltDepartamento: {
              required: true
          },          
          
          txtNombreVictima:{
             required: true
          },          
          
          txtResponsables:{
             required: false
          }

          
        },
        messages: {            
            txtCedulaVictima : {                 
                digits: "Solo se permiten números",
                minlength: "Mínimo 6 digitos"
            },            
            txtNombreVictima : "Escriba un nombre", 
            sltMunicipioHechos : "Seleccione un municpio",                                   
            sltSiglasSindicato : "Seleccione las siglas del sindicato",                                                      
            sltTipoViolacion : "Seleccione el tipo de violacion",
            sltGenero : "Seleccione un genero",
            sltMunicipio : "Seleccione un municpio",            
            sltDepartamentoHechos : "Seleccione un departamento",            
            sltDepartamento : "Seleccione un departamento",                             
            txtResponsables : "Escriba el responsable"

        }
    });
    
    $('#txtTituloProfesi ').attr('disabled', 'disabled');
    
    $("#sltNivelEducativo ").change(function(event){
        var codBien = $("#sltNivelEducativo ").find(':selected').val();
        if(codBien === "NIVELEDUCATIVO")
            $('#txtTituloProfesi ').removeAttr('disabled');
        else
            $('#txtTituloProfesi ').attr('disabled', 'disabled');
    }); 
    
    $("#sltDepartamento ").change(function(event){
        var id = $("#sltDepartamento ").find(':selected').val();
        $("#sltMunicipio ").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
    
    $("#sltDepartamentoHechos ").change(function(event){
        var id = $("#sltDepartamentoHechos ").find(':selected').val();
        $("#sltMunicipioHechos ").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
        
    $("input[name=txtCedulaVictima ]").change(function(){        
        var valor = $("#txtCedulaVictima ").val();
        $("#divCedulaVal").empty();
        $("#divCedulaVal").load('/index.php/controladorVictima/ValidarCedula/' + valor);                
    });
    
    $('#txtOtroTipoViolacion').attr('disabled', 'disabled');                
    
    
    $("#sltTipoViolacion").change(function(event){
        var codTipoViolacion = $("#sltTipoViolacion").find(':selected').val();
        if(codTipoViolacion === "152")
            $('#txtOtroTipoViolacion').removeAttr('disabled');
        else
            $('#txtOtroTipoViolacion').attr('disabled', 'disabled');
        });                    
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeCedula = $('#divCedulaVal').is(':empty');      
      if(existeCedula === false)
        validaCampo = true;
    
      //if($("#txtResponsables ").val() === "")                    
        //validaCampo = true;        

      if($("#sltMunicipioHechos ").val() === "")                    
        validaCampo = true;       
    
      if($("#sltSiglasSindicato ").val() === "")              
        validaCampo = true;               
    
      if($("#sltTipoViolacion ").val() === "")              
        validaCampo = true;
    
      if($("#sltGenero ").val() === "")              
        validaCampo = true;    
              
      if($("#txtNombreVictima ").val() === "")              
        validaCampo = true;
  
      if($("#sltDepartamento ").val() === "")                    
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