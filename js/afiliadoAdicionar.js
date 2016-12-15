$(function(){       
    $("form").validate({
        rules: {
          txtCedulaAdic:{
             required: false,
             digits: true,
             minlength: 6
          },            
          txtFechaIngresoEmpresaAdic: {
            required: false,
            date: true
          },
          txtFechaIngresoSindiAdic: {
            required: false,
            date: true
          },
          txtCorreoAdic:{
             required: false,
             email: true
          },

          txtNombreAfliliadoAdic:{
             required: false
          },
         
          sltDepartamentoAdic: {
              required: true
          },
          sltDepartamentoResiAdic: {
              required: true
          },
          sltDepartamentoLaboraAdic: {
              required: true
          },          
          sltMunicipioAdic: {
              required: true
          },
          sltMunicipioResiAdic: {
              required: true
          },          
          sltMunicipioLaboraAdic: {
              required: true
          },                    
          txtNumeroPreescolarAdic: {
              required: false,
              digits: true
          },
          txtNumeroPrimariaAdic: {
              required: false,
              digits: true
          },
          txtNumeroSecundariaAdic: {
              required: false,
              digits: true
          },
          txtNumerotecnicaAdic: {
              required: false,
              digits: true
          },
          txtNumeroTecnologiaAdic: {
              required: false,
              digits: true
          },
          txtNumeroUniversidadAdic: {
              required: false,
              digits: true
          },
          txtNumeropersonasCargoAdic: {
              required: false,
              digits: true
          },
          txtNumeroHorasTrabajoAdic: {
              required: false,
              digits: true
          },          
          txtPorcentajeCuotaSindicalAdic: {
              required: false,
              digits: true
          },                    
          txtSalarioBasicoAdic: {
              required: false,
              digits: true
          },                              

          txtFechaRetiroSindiAdic: {
            required: false,
            date: true
          },
          sltTipoAfiliadoAdic: {
              required: false
          },
          sltEmpresaDondeLaboraAdic: {
              required: true
          },

          sltModalidadContratoAdic:{
              required: false
          },

          sltSalarioRangosAdic: {
              required: false
          },          
          sltOrganizacionSocialAdic: {
              required: false
          },                    

          sltMiembroJuntaDirectivaAdic: {
              required: false
          },                    
          sltCondicionAfiliacionAdic: {
              required: false
          }
          
        },
        messages: {            
            txtCorreoAdic: "Escriba un email valido",
            txtFechaIngresoSindiAdic: "Escriba o seleccione una fecha valida",
            txtFechaIngresoEmpresaAdic: "Escriba o seleccione una fecha valida",
            txtCedulaAdic: { 
                required: "Escriba la Cedula",
                digits: "Solo se permiten números",
                minlength: "Mínimo 6 digitos"
            },
            txtNombreAfliliadoAdic: "Escriba un nombre",                                                                        
            sltDepartamentoAdic: "Seleccione un departamento",
            sltDepartamentoResiAdic: "Seleccione un departamento",
            sltDepartamentoLaboraAdic: "Seleccione un departamento",
            sltMunicipioAdic: "Seleccione un municpio",
            sltMunicipioResiAdic: "Seleccione un municpio",
            sltMunicipioLaboraAdic: "Seleccione un municpio",            
            txtNumeroPreescolarAdic: "Solo se permiten números",
            txtNumeroPrimariaAdic: "Solo se permiten números",
            txtNumeroSecundariaAdic: "Solo se permiten números",
            txtNumerotecnicaAdic: "Solo se permiten números",
            txtNumeroTecnologiaAdic: "Solo se permiten números",
            txtNumeroUniversidadAdic: "Solo se permiten números",
            txtNumeropersonasCargoAdic: "Solo se permiten números",            
            txtNumeroHorasTrabajoAdic: "Solo se permiten números",
            txtPorcentajeCuotaSindicalAdic: "Solo se permiten números",
            txtSalarioBasicoAdic: "Solo se permiten números",            
            txtFechaRetiroSindiAdic: "Escriba o seleccione una fecha valida",            
            sltTipoAfiliadoAdic: "Seleccione el tipo de afiliado",
            sltEmpresaDondeLaboraAdic: "Seleccione la empresa donde labora",                        
            sltModalidadContratoAdic: "Seleccione la modalidad de contrato",                    
            sltSalarioRangosAdic: "Seleccione el salario basico por rango",            
            sltOrganizacionSocialAdic: "Seleccione si pertenencia a otra organización social",                                   
            sltCondicionAfiliacionAdic: "Seleccione la condicion de afiliacion",            
            sltMiembroJuntaDirectivaAdic: "Seleccione miembro junta directiva"
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
        $("#sltMunicipioAdic").load('/index.php/controladorAfiliado/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
    
    $("#sltDepartamentoResiAdic").change(function(event){
        var id = $("#sltDepartamentoResiAdic").find(':selected').val();
        $("#sltMunicipioResiAdic").load('/index.php/controladorAfiliado/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
    
    $("#sltDepartamentoLaboraAdic").change(function(event){
        var id = $("#sltDepartamentoLaboraAdic").find(':selected').val();
        $("#sltMunicipioLaboraAdic").load('/index.php/controladorAfiliado/ObtenerMunicipiosPorDepartamento/' + id);
    });     
        
    $("input[name=txtCedulaAdic]").change(function(){        
        var valor = $("#txtCedulaAdic").val();
        $("#divCedulaVal").empty();
        $("#divCedulaVal").load('/index.php/controladorAfiliado/ValidarCedula/' + valor);                
    });
    
    $('#txtOtraModalidadContratoAdic').attr('disabled', 'disabled');
    
    $("#sltModalidadContratoAdic").change(function(event){
        var codBien = $("#sltModalidadContratoAdic").find(':selected').val();                
        if(codBien === "OTROMDADCONTRATO")
            $('#txtOtraModalidadContratoAdic').removeAttr('disabled');
        else
            $('#txtOtraModalidadContratoAdic').attr('disabled', 'disabled');
    });              
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeCedula = $('#divCedulaVal').is(':empty');      
      if(existeCedula === false)
        validaCampo = true;
     /*
      if($("#txtNombreAfliliadoAdic").val() === "")              
        validaCampo = false;
              
      if($("#txtCedulaAdic").val() === "")                    
        validaCampo = false;        
       */
      
      if($("#sltDepartamentoAdic").val() === "")                    
        validaCampo = true;
    
      if($("#sltDepartamentoResiAdic").val() === "")                    
        validaCampo = true;    
            
      if($("#sltMunicipioAdic").val() === "")                    
        validaCampo = true;      
    
      if($("#sltMunicipioResiAdic").val() === "")                    
        validaCampo = true;          
      
      var codBien = $("#sltNivelEducativoAdic").find(':selected').val();
      if(codBien === "NIVELEDUCATIVO" && $("#txtTituloProfesiAdic").val() === "")
          validaCampo = true;
      /*      
      if($("#sltTipoAfiliadoAdic").val() === "")                    
        validaCampo = false;
            
      if($("#sltEmpresaDondeLaboraAdic").val() === "")                    
        validaCampo = true;      
      
      if($("#sltModalidadContratoAdic").val() === "")                    
        validaCampo = false;
    
      if($("#sltSalarioRangosAdic").val() === "")                    
        validaCampo = false;          
    
      if($("#sltOrganizacionSocialAdic").val() === "")                    
        validaCampo = false;              

      if($("#sltMiembroJuntaDirectivaAdic").val() === "")                    
        validaCampo = false;          
    
      if($("#sltCondicionAfiliacionAdic").val() === "")                    
        validaCampo = false;              
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
        else if(codBien === "NIVELEDUCATIVO" && $("#txtTituloProfesiAdic").val() === "")
        {            
            //var idx = $('#tabAdicionar a[href="#about-content"]').parent().index();
            //$("#tabAdicionar").tabs( "option", "active", idx);
            var index = $('#tabAdicionar a[href="#about-content"]').parent().index();
            $('#tabAdicionar').tabs({ active: index });
            $("#txtTituloProfesiAdic").css({'border': "1px solid #A30000"});
            $('#txtTituloProfesiAdic').focus();            
            $( "#divError" ).text( "Falta diligenciar el campo Titulo Profesional de la pestaña información personal." ).show();
        }
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});