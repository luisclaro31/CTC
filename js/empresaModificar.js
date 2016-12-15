$(function(){    
    $("form").validate({
        rules: {
          txtNombreEmpresa:{
             required: true
          },          
          sltClasificacionEcon: {
              required: false
          },
          sltDepartamento: {
              required: true
          },
          sltCodMunicipio: {
              required: true
          },
          sltGrupoEconom: {
              required: true
          },
          sltEmpresaSegOriCap: {
              required: false
          },          
          sltEmpresaSegCap: {
              required: false
          },          
          txtCorreo:{
             required: false,
             email: true
          }
        },
        messages: { 
            txtCorreo: "Escriba un email valido",            
            txtNombreEmpresa: "Escriba un nombre",            
            sltClasificacionEcon: "Seleccione una clasificacion economica",
            sltDepartamento: "Seleccione un departamento",
            sltMunicipio: "Seleccione un municpio",
            sltGrupoEconom: "Seleccione un grupo economico",
            sltEmpresaSegOriCap: "Seleccione el tipo de capital",
            sltEmpresaSegCap: "Seleccione capital de la empresa"
                                         }
    });
    
    
    
    $("#sltCodDepartamento").change(function(event){
        var id = $("#sltCodDepartamento").find(':selected').val();
        $("#sltCodMunicipio").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    });        
    
    $('#txtOtroTipoEmpresa').attr('disabled', 'disabled');                
    
    $("#sltEmpresaTipEst").change(function(event){
        var codTipoViolacion = $("#sltEmpresaTipEst").find(':selected').val();
        if(codTipoViolacion === "153")
            $('#txtOtroTipoEmpresa').removeAttr('disabled');
        else
            $('#txtOtroTipoEmpresa').attr('disabled', 'disabled');
        });                         
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
     
      if($("#txtNombreEmpresa").val() === "")              
        validaCampo = true;
              
      if($("#txtRut").val() === "")                    
        validaCampo = true;
          
      if($("#sltClasificacionEcon").val() === "")              
        validaCampo = false;
            
      if($("#sltCodDepartamento").val() === "")                    
        validaCampo = true;
            
      if($("#sltCodMunicipio").val() === "")                    
        validaCampo = true;      
      
      if($("#sltEmpresaSegOriCap").val() === "")                   
          validaCampo = false;      
      
      if($("#sltGrupoEconom").val() === "")                    
        validaCampo = true;
            
      if($("#sltEmpresaSegCap").val() === "")                    
        validaCampo = false;
      
      if(validaCampo === false)
      {
        $( "#divErrorMod" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {        
         $( "#divErrorMod" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
         event.preventDefault();        
      }
    });
});