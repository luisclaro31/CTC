$(function(){       
    $("form").validate({
        rules: {

          txtFechaIngresoEmpresa: {
            required: false,
            date: true
          },
          txtFechaIngresoSindi: {
            required: false,
            date: true
          },
          txtCorreo:{
             required: false,
             email: true
          },

          txtNombreAfliliado:{
             required: false
          },

          txtFondoPensiones:{
             required: true
          },                    
          txtFondoCesantias:{
             required: true
          },                              
          txtArl:{
             required: true
          },                                        
          txtCajaCompensacion:{
             required: true
          },                                                  
             
          sltDepartamento: {
              required: true
          },
          sltDepartamentoResi: {
              required: true
          },
          sltDepartamentoLabora: {
              required: true
          },          
          sltMunicipio: {
              required: true
          },
          sltMunicipioResi: {
              required: true
          },          
          sltMunicipioLabora: {
              required: true
          },                    
          txtNumeroPreescolar: {
              required: false,
              digits: true
          },
          txtNumeroPrimaria: {
              required: false,
              digits: true
          },
          txtNumeroSecundaria: {
              required: false,
              digits: true
          },
          txtNumerotecnica: {
              required: false,
              digits: true
          },
          txtNumeroTecnologia: {
              required: false,
              digits: true
          },
          txtNumeroUniversidad: {
              required: false,
              digits: true
          },
          txtNumeropersonasCargo: {
              required: false,
              digits: true
          },
          txtNumeroHorasTrabajo: {
              required: false,
              digits: true
          },          
          txtPorcentajeCuotaSindical: {
              required: false,
              digits: true
          },                    
          txtSalarioBasico: {
              required: false,
              digits: true
          },                              
          txtFechaRetiroSindi: {
            required: false,
            date: true
          },

          sltTipoAfiliado: {
              required: false
          },
          sltEmpresaDondeLabora: {
              required: true
          },
          sltModalidadContrato:{
              required: false
          },

          sltSalarioRangos: {
              required: false
          },          
          sltOrganizacionSocial: {
              required: false
          },                    
          sltMiembroJuntaDirectiva: {
              required: false
          },                    
          sltCondicionAfiliacion: {
              required: false
          }
          
        },
        messages: {            
            txtCorreo: "Escriba un email valido",
            txtFechaIngresoSindi: "Escriba o seleccione una fecha valida",
            txtFechaIngresoEmpresa: "Escriba o seleccione una fecha valida",
            txtNombreAfliliado: "Escriba un nombre",            
            txtFondoPensiones: "Escriba un nombre de Fondo Pensione",
            txtFondoCesantias: "Escriba un nombre de Fondo Cesantias",
            txtArl: "Escriba un nombre de Aseguradora Riesgos Laborales ",
            txtCajaCompensacion: "Escriba un nombre de la Caja de Compensación",            
            sltDepartamento: "Seleccione un departamento",
            sltDepartamentoResi: "Seleccione un departamento",
            sltDepartamentoLabora: "Seleccione un departamento",
            sltMunicipio: "Seleccione un municpio",
            sltMunicipioResi: "Seleccione un municpio",
            sltMunicipioLabora: "Seleccione un municpio",            
            txtNumeroPreescolar: "Solo se permiten números",
            txtNumeroPrimaria: "Solo se permiten números",
            txtNumeroSecundaria: "Solo se permiten números",
            txtNumerotecnica: "Solo se permiten números",
            txtNumeroTecnologia: "Solo se permiten números",
            txtNumeroUniversidad: "Solo se permiten números",
            txtNumeropersonasCargo: "Solo se permiten números",            
            txtNumeroHorasTrabajo: "Solo se permiten números",
            txtPorcentajeCuotaSindical: "Solo se permiten números",
            txtSalarioBasico: "Solo se permiten números",            
            txtFechaRetiroSindi: "Escriba o seleccione una fecha valida",            
            sltTipoAfiliado: "Seleccione el tipo de afiliado",
            sltEmpresaDondeLabora: "Seleccione la empresa donde labora",                        
            sltModalidadContrato: "Seleccione la modalidad de contrato",                   
            sltSalarioRangos: "Seleccione el salario basico por rango",            
            sltOrganizacionSocial: "Seleccione si pertenencia a otra organización social",                         
            sltCondicionAfiliacion: "Seleccione la condicion de afiliacion",            
            sltMiembroJuntaDirectiva: "Seleccione miembro junta directiva",                        
        }
    });
    
    $('#txtTituloProfesi').attr('disabled', 'disabled');
    
    $("#sltNivelEducativo").change(function(event){
        var codBien = $("#sltNivelEducativo").find(':selected').val();
        if(codBien === "NIVELEDUCATIVO")
            $('#txtTituloProfesi').removeAttr('disabled');
        else
            $('#txtTituloProfesi').attr('disabled', 'disabled');
    }); 
    
    $("#sltDepartamento").change(function(event){
        var id = $("#sltDepartamento").find(':selected').val();
        $("#sltMunicipio").load('/index.php/controladorAfiliado/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
    
    $("#sltDepartamentoResi").change(function(event){
        var id = $("#sltDepartamentoResi").find(':selected').val();
        $("#sltMunicipioResi").load('/index.php/controladorAfiliado/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
    
    $("#sltDepartamentoLabora").change(function(event){
        var id = $("#sltDepartamentoLabora").find(':selected').val();
        $("#sltMunicipioLabora").load('/index.php/controladorAfiliado/ObtenerMunicipiosPorDepartamento/' + id);
    });     
    
    $('#txtOtraModalidadContrato').attr('disabled', 'disabled');
    
    $("#sltModalidadContrato").change(function(event){
        var codBien = $("#sltModalidadContrato").find(':selected').val();                
        if(codBien === "OTROMDADCONTRATO")
            $('#txtOtraModalidadContrato').removeAttr('disabled');
        else
            $('#txtOtraModalidadContrato').attr('disabled', 'disabled');
    });                      
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeCedula = $('#divCedulaVal').is(':empty');      
      if(existeCedula === false)
        validaCampo = true;
     /* 
      if($("#txtNombreAfliliado").val() === "")              
        validaCampo = true;
    
      if($("#txtFondoPensiones").val() === "")              
        validaCampo = true;    
    
      if($("#txtFondoCesantias").val() === "")              
        validaCampo = true;        
    
      if($("#txtArl").val() === "")              
        validaCampo = true;            
    
      if($("#txtCajaCompensacion").val() === "")              
        validaCampo = true;                
    */
            
      if($("#sltDepartamento").val() === "")                    
        validaCampo = true;
    
      if($("#sltDepartamentoResi").val() === "")                    
        validaCampo = true;    
            
      if($("#sltMunicipio").val() === "")                    
        validaCampo = true;      
    
      if($("#sltMunicipioResi").val() === "")                    
        validaCampo = true;          
      
      var codBien = $("#sltNivelEducativo").find(':selected').val();
      if(codBien === "NIVELEDUCATIVO" && $("#txtTituloProfesi").val() === "")
          validaCampo = true;
      /*
            
      if($("#sltTipoAfiliado").val() === "")                    
        validaCampo = true;
            
      if($("#sltEmpresaDondeLabora").val() === "")                    
        validaCampo = true;      
      
      if($("#sltModalidadContrato").val() === "")                    
        validaCampo = true;
    
      if($("#sltSalarioRangos").val() === "")                    
        validaCampo = true;          
    
      if($("#sltOrganizacionSocial").val() === "")                    
        validaCampo = true;              

      if($("#sltMiembroJuntaDirectiva").val() === "")                    
        validaCampo = true;          
    
      if($("#sltCondicionAfiliacion").val() === "")                    
        validaCampo = true;              
       */
       
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(existeCedula === false)
            $( "#divError" ).text( "La Cedula ya existe, escriba una nuevo." ).show();
        else if(codBien === "NIVELEDUCATIVO" && $("#txtTituloProfesi").val() === "")
        {            
            //var idx = $('#tabionar a[href="#about-content"]').parent().index();
            //$("#tabionar").tabs( "option", "active", idx);
            var index = $('#tabionar a[href="#about-content"]').parent().index();
            $('#tabionar').tabs({ active: index });
            $("#txtTituloProfesi").css({'border': "1px solid #A30000"});
            $('#txtTituloProfesi').focus();            
            $( "#divError" ).text( "Falta diligenciar el campo Titulo Profesional de la pestaña información personal." ).show();
        }
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});