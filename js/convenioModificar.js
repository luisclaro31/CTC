$(function(){    
    
    $("#datepickerMayor2" ).change(function() {      

        if($("#datepicker6").val() != null)
        {
            var fechainicio = $("#datepicker6").val();            
            var fechaFin = $("#datepickerMayor2").val();
			var fecha1 = new Date(fechainicio);
			var fecha2 = new Date(fechaFin);
			var diasDif = fecha2.getTime() - fecha1.getTime();
			var dias = Math.round(diasDif/(1000 * 60 * 60 * 24));
            $("#txtTiemVigenConvenio").val(dias);            
        }        
        else
            fechainicio = $("#datepickerMayor2").val();
 
     });
     
    $("#txtNumeroTrabaBenefi" ).change(function() {      

        if($("#txtNumeroTrabaEmpr").val() != null)
        {
            var numeroUno = $("#txtNumeroTrabaEmpr").val();            
            var numeroDos = $("#txtNumeroTrabaBenefi").val();
            
            var numeroTotal = numeroUno - numeroDos;
            $("#txtNumeroTrabaNoBenefi").val(numeroTotal);            
        }        
        else
            numeroUno = $("#txtNumeroTrabaBenefi").val();
 
     });          
    
   
    $("form").validate({
        rules: {
          sltEmpresaFirmaConvenio:{
             required: true
          },                    
          txtFechaInicioConvenio: {
            required: true,
            date: true
          },
          txtFechaFinalizConvenio: {
            required: true,
            date: true
          },
          sltConvenioAcuerdoLaboEstatal:{
             required: true
          },
          txtTiemVigenConvenio:{
             required: false,
             digits: true
          },  
          sltCodDepartamento: {
              required: true
          },
          sltCodMunicipio: {
              required: true
          },
          txtCorreoAdic:{
             required: false,
             email: true
          },                    
          txtFechaConvocaTribArbi: {
              required: false,
              date: true
          },          
          txtFechaResolTribArbiArbi: {
            required: false,
            date: true
          },
          sltPeriodoFirmaConvenAdic: {
              required: true
          },   
          txtNumeroTrabaBenefi:{
              required: false,
              digits: true
          },
          txtNumeroTrabaNoBenefi: {
              required: false,
              digits: true
          },
          txtMesesDuracTribuArbitraAdic: {
              required: false,
              digits: true
          },

          txtValorIncreModaAnyoVigencia: {
              required: false,
              digits: true
          },
          txtMontoCuantiAuxCentr: {
              required: false,
              digits: true
          }
        },
        messages: {            
            sltEmpresaFirmaConvenio: "Seleccione una empresa.",                                    
            txtFechaInicioConvenioAdic: { 
                required: "Escriba una fecha",
                date: "Escriba una fecha valida"
            },               
            txtFechaFinalizConvenioAdic: { 
                required: "Escriba una fecha",
                date: "Escriba una fecha valida"
            },
            txtFechaConvocaTribArbiAdic: { 
                required: "Escriba una fecha",
                date: "Escriba una fecha valida"
            },
            txtFechaResolTribArbiAdic: { 
                required: "Escriba una fecha",
                date: "Escriba una fecha valida"
            },
            sltConvenioAcuerdoLaboEstatal: "Seleccione un acuerdo",            
            txtTiemVigenConvenio: { 
                required: "Escriba el tiempo de vigencia",
                digits: "Solo se permiten números"
            },
            sltCodDepartamento: "Seleccione un departamento",
            sltCodMunicipio: "Seleccione un municpio",
            txtCorreoAdic: "Escriba un email valido",         
            txtNumeroTrabaBenefi: "Solo se permiten números",            
            txtNumeroTrabaNoBenefi: "Solo se permiten números",          
            sltPeriodoFirmaConvenAdic: "Seleccione un periodo",
            sltBienesInmueblesPropAdic: "Seleccione un bien inmueble",
            txtFechaUltActualizacionInfAdic: "Escriba o seleccione una fecha valida",
            txtMesesDuracTribuArbitraAdic: "Solo se permiten números",                        
            txtValorIncreModaAnyoVigencia: "Solo se permiten números",
            txtMontoCuantiAuxCentr: "Solo se permiten números"            
            
        }
    });
    
    var idCon = $("#sltEmpresaFirmaConvenio").find(':selected').val();        
    $("#divInformacionEmpresaMod").load('/index.php/controladorConvenioColectivo/ConsultarEmpresaPorRut/' + idCon);
    
    $("#sltCodDepartamento").change(function(event){
        var id = $("#sltCodDepartamento").find(':selected').val();
        $("#sltCodMunicipio").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
    
    $("#sltEmpresaFirmaConvenio").change(function(){        
        $("#divInformacionEmpresa").empty();
        var id = $("#sltEmpresaFirmaConvenio").find(':selected').val();        
        $("#divInformacionEmpresaMod").load('/index.php/controladorConvenioColectivo/ConsultarEmpresaPorRut/' + id);
    }); 
            
    $('#txtOtroPorcAcuerLaboral').attr('disabled', 'disabled');
    
    $("#sltPorcAcuerLaboral").change(function(event){
        var codBien = $("#sltPorcAcuerLaboral").find(':selected').val();        
        if(codBien === "ARTICULOOTROCUAL")
            $('#txtOtroPorcAcuerLaboral').removeAttr('disabled');
        else
            $('#txtOtroPorcAcuerLaboral').attr('disabled', 'disabled');
    });                      
    
    $('#txtNombreDirectorDireccionTerritorial').attr('disabled', 'disabled');
    
    $("#sltDireccTerri").change(function(event){
        var cod = $("#sltDireccTerri").val();                        
        if(cod != null || cod == "")
            $('#txtNombreDirectorDireccionTerritorial').removeAttr('disabled');
        else
            $('#txtNombreDirectorDireccionTerritorial').attr('disabled', 'disabled');
    });                  
    
    $('#txtOtroTipoConvenioColectivo').attr('disabled', 'disabled');            
    
        $("#sltConvenioAcuerdoLaboEstatal").change(function(event){
            var codCargo = $("#sltConvenioAcuerdoLaboEstatal").find(':selected').val();
            if(codCargo === "154")
                $('#txtOtroTipoConvenioColectivo').removeAttr('disabled');
            else
                $('#txtOtroTipoConvenioColectivo').attr('disabled', 'disabled');
        });                 
            
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
      
      if($("#sltEmpresaFirmaConvenio").val() === "")                    
        validaCampo = true;
    
      if($("#sltConvenioAcuerdoLaboEstatal").val() === "")              
        validaCampo = true;      
      
      if($("#txtFechaFinalizConvenio").val() === "")              
        validaCampo = true;
              
      if($("#sltCodDepartamento").val() === "")                    
        validaCampo = true;
            
      if($("#sltCodMunicipio").val() === "")                    
        validaCampo = true;      
      
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
         $( "#divErrorMod" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});