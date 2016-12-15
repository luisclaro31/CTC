$(function(){    
    
    $("#datepickerMayor" ).change(function() {      

        if($("#datepicker").val() != null)
        {
            var fechainicio = $("#datepicker").val();            
            var fechaFin = $("#datepickerMayor").val();
			
			var fecha1 = new Date(fechainicio);
			var fecha2 = new Date(fechaFin);
			var diasDif = fecha2.getTime() - fecha1.getTime();
			var dias = Math.round(diasDif/(1000 * 60 * 60 * 24));
            $("#txtTiemVigenConvenioAdic").val(dias);            
        }        
        else
            fechainicio = $("#datepickerMayor").val();
 
     });
     
    $("#txtNumeroTrabaBenefiAdic" ).change(function() {      

        if($("#txtNumeroTrabaEmprAdic").val() != null)
        {
            var numeroUno = $("#txtNumeroTrabaEmprAdic").val();            
            var numeroDos = $("#txtNumeroTrabaBenefiAdic").val();
            
            var numeroTotal = numeroUno - numeroDos;
            $("#txtNumeroTrabaNoBenefiAdic").val(numeroTotal);            
        }        
        else
            numeroUno = $("#txtNumeroTrabaBenefiAdic").val();
 
     });     
   
    $("form").validate({
        rules: {
          sltEmpresaFirmaConvenioAdic:{
             required: true
          },                    
          txtFechaInicioConvenioAdic: {
            required: true,
            date: true
          },
          txtFechaFinalizConvenioAdic: {
            required: true,
            date: true
          },
          sltConvenioAcuerdoLaboEstatalAdic:{
             required: true
          },
          txtTiemVigenConvenioAdic:{
             required: false,
             digits: true
          },  
          sltDepartamentoAdic: {
              required: true
          },
          sltMunicipioAdic: {
              required: true
          },
          txtCorreoAdic:{
             required: false,
             email: true
          },                    
          txtFechaConvocaTribArbiAdic: {
              required: false,
              date: true
          },          
          txtFechaResolTribArbiAdic: {
            required: false,
            date: true
          },
          sltPeriodoFirmaConvenAdic: {
              required: true
          },          
          txtNumeroTrabaEmprAdic: {
            required: false,
            digits: true
          },
          txtNumeroTrabaBenefiAdic:{
              required: false,
              digits: true
          },
          txtNumeroTrabaNoBenefiAdic: {
              required: false,
              digits: true
          },
          txtMesesDuracTribuArbitraAdic: {
              required: false,
              digits: true
          },

          txtValorIncreModaAnyoVigenciaAdic: {
              required: false,
              digits: true
          },
          txtMontoCuantiAuxCentrAdic: {
              required: false,
              digits: true
          }
          
        },
        messages: {            
            sltEmpresaFirmaConvenioAdic: "Seleccione una empresa.",                                    
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
            sltConvenioAcuerdoLaboEstatalAdic: "Seleccione un acuerdo",            
            txtTiemVigenConvenioAdic: { 
                required: "Escriba el tiempo de vigencia",
                digits: "Solo se permiten números"
            },
            sltDepartamentoAdic: "Seleccione un departamento",
            sltMunicipioAdic: "Seleccione un municpio",
            txtCorreoAdic: "Escriba un email valido",
            txtNumeroTrabaEmprAdic: "Solo se permiten números",            
            txtNumeroTrabaBenefiAdic: "Solo se permiten números",            
            txtNumeroTrabaNoBenefiAdic: "Solo se permiten números",          
            sltPeriodoFirmaConvenAdic: "Seleccione un periodo",
            sltBienesInmueblesPropAdic: "Seleccione un bien inmueble",
            txtFechaUltActualizacionInfAdic: "Escriba o seleccione una fecha valida",
            txtMesesDuracTribuArbitraAdic: "Solo se permiten números",                        
            txtValorIncreModaAnyoVigenciaAdic: "Solo se permiten números",
            txtMontoCuantiAuxCentrAdic: "Solo se permiten números"            
            
        }
    });
     
    $("#sltDepartamentoAdic").change(function(event){
        var id = $("#sltDepartamentoAdic").find(':selected').val();
        $("#sltMunicipioAdic").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
    
    $("#sltEmpresaFirmaConvenioAdic").change(function(){        
        $("#divInformacionEmpresa").empty();
        var id = $("#sltEmpresaFirmaConvenioAdic").find(':selected').val();        
        $("#divInformacionEmpresa").load('/index.php/controladorConvenioColectivo/ConsultarEmpresaPorRut/' + id);
    }); 
    
    $('#txtOtroPorcAcuerLaboralAdic').attr('disabled', 'disabled');
    
    $("#sltPorcAcuerLaboralAdic").change(function(event){
        var codBien = $("#sltPorcAcuerLaboralAdic").find(':selected').val();        
        if(codBien === "ARTICULOOTROCUAL")
            $('#txtOtroPorcAcuerLaboralAdic').removeAttr('disabled');
        else
            $('#txtOtroPorcAcuerLaboralAdic').attr('disabled', 'disabled');
    });          
    
    $('#txtNombreDirectorDireccionTerritorialAdic').attr('disabled', 'disabled');
    
    $("#sltDireccTerriAdic").change(function(event){
        var cod = $("#sltDireccTerriAdic").val();                
        if(cod != null || cod == "")
            $('#txtNombreDirectorDireccionTerritorialAdic').removeAttr('disabled');
        else
            $('#txtNombreDirectorDireccionTerritorialAdic').attr('disabled', 'disabled');
    });              
    
    $('#txtOtroTipoConvenioColectivoAdic').attr('disabled', 'disabled');            
    
        $("#sltConvenioAcuerdoLaboEstatalAdic").change(function(event){
            var codCargo = $("#sltConvenioAcuerdoLaboEstatalAdic").find(':selected').val();
            if(codCargo === "154")
                $('#txtOtroTipoConvenioColectivoAdic').removeAttr('disabled');
            else
                $('#txtOtroTipoConvenioColectivoAdic').attr('disabled', 'disabled');
        });                     
        
    
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
      
      if($("#sltEmpresaFirmaConvenioAdic").val() === "")                    
        validaCampo = true;
    
      if($("#sltConvenioAcuerdoLaboEstatalAdic").val() === "")              
        validaCampo = true;      
      
      if($("#txtFechaInicioConvenioAdic").val() === "")              
        validaCampo = true;
    
      if($("#txtFechaFinalizConvenioAdic").val() === "")              
        validaCampo = true;
              
      if($("#sltDepartamentoAdic").val() === "")                    
        validaCampo = true;
            
      if($("#sltMunicipioAdic").val() === "")                    
        validaCampo = true;      
      
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
         $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});