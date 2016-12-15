$(function(){    
    
        $('#txtOtraAfiliInter').attr('disabled', 'disabled');
        $('#txtOtraClasifSubSect').attr('disabled', 'disabled');

        $("#sltAfiliacionInt").change(function(event){
            var codBien = $("#sltAfiliacionInt").find(':selected').val();
            if(codBien === "OTRAAFILFEDERINT")
                $('#txtOtraAfiliInter').removeAttr('disabled');
            else
                $('#txtOtraAfiliInter').attr('disabled', 'disabled');
        });               
        
        

        $("#sltClasifSubSectCut").change(function(event){
            var codBien = $("#sltClasifSubSectCut").find(':selected').val();
            if(codBien === "OTRACLASIFSUBCUT")
                $('#txtOtraClasifSubSect').removeAttr('disabled');
            else
                $('#txtOtraClasifSubSect').attr('disabled', 'disabled');
        });                       
    
    $("form").validate({
        rules: {
          txtFecha: {
            required: false,
            date: true
          },
          txtFechaUltInscrJunDirectiva: {
            required: false,
            date: true
          },
          txtCorreo:{
             required: false,
             email: true
          },
          txtNumeroResolucion:{
             required: true,
             digits: true
          },
          txtNombSindicato:{
             required: true
          },

          sltCodDepartamento: {
              required: true
          },
          sltCodMunicipio: {
              required: true
          },
          sltPeriodoVigJuntaDirectiva: {
              required: true
          },
          txtNumeroAfiliadosEmpresa: {
              required: false,
              digits: true
          },
          txtNumeroAfiliadosActuales: {
              required: false,
              digits: true
          },
          txtNumeroAfiliadosHombres: {
              required: false,
              digits: true
          },
          txtNumeroAfiliadosMujeres: {
              required: false,
              digits: true
          },
          txtNumeroAfiliadosJovenes35: {
              required: false,
              digits: true
          },
          txtNumeroAfiliadosSectorFormal: {
              required: false,
              digits: true
          },
          txtNumeroAfiliadosSectorInformal: {
              required: false,
              digits: true
          },
          sltEstado: {
              required: true
          },          

          txtFechaUltimaActualizacion: {
            required: false,
            date: true
          }


        },
        messages: {            
            txtCorreo: "Escriba un email valido",
            txtFechaUltInscrJunDirectiva: "Escriba o seleccione una fecha valida",
            txtFecha: "Escriba o seleccione una fecha valida",
            txtNumeroResolucion: { 
                required: "Escriba un número de resolución",
                digits: "Solo se permiten números"
            },
            txtNombSindicato: "Escriba un nombre",            
            sltCodDepartamento: "Seleccione un departamento",
            sltCodMunicipio: "Seleccione un municpio",
            sltPeriodoVigJuntaDirectiva: "Seleccione un periodo de vigencia",
            txtNumeroAfiliadosEmpresa: "Solo se permiten números",
            txtNumeroAfiliadosActuales: "Solo se permiten números",
            txtNumeroAfiliadosHombres: "Solo se permiten números",
            txtNumeroAfiliadosMujeres: "Solo se permiten números",
            txtNumeroAfiliadosJovenes35: "Solo se permiten números",
            txtNumeroAfiliadosSectorFormal: "Solo se permiten números",
            txtNumeroAfiliadosSectorInformal: "Solo se permiten números",
            sltEstado: "Seleccione un estado",                        
            txtFechaUltimaActualizacion: "Escriba o seleccione una fecha valida"            
        }
    });
    
    $("#sltCodDepartamento").change(function(event){
        var id = $("#sltCodDepartamento").find(':selected').val();
        $("#sltCodMunicipio").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    });    
    
    $("#sltClasifSectCut").change(function(event){
        var id = $("#sltClasifSectCut").find(':selected').val();
        $("#sltClasifSubSectCut").load('/index.php/controladorSindicato/ObtenerClasifSectCut/' + id);
    });         
    
   $(function() {  Otras_secretaria();
   $("#chkOtraSecretaria").click(Otras_secretaria);});

    function Otras_secretaria() {
    if (this.checked || $("#chkOtraSecretaria").attr('checked')  ) {
      $('#txtOtraSecretaria').removeAttr('disabled');         
        
    } else {
      
      $('#txtOtraSecretaria').attr('disabled', 'disabled');                
          }
    }        
    
    var codBien = $("#sltBienesInmueblesProp").find(':selected').val();
    if(codBien !== "OTROSBIENESINMUEBLES")            
        $('#txtOtrosBienesInmubles').attr('disabled', 'disabled');
    
    $("#sltBienesInmueblesProp").change(function(event){
        var codBien = $("#sltBienesInmueblesProp").find(':selected').val();
        if(codBien === "OTROSBIENESINMUEBLES")
            $('#txtOtrosBienesInmubles').removeAttr('disabled');
        else
            $('#txtOtrosBienesInmubles').attr('disabled', 'disabled');
    });
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
      
      if($("#txtNumeroResolucion").val() === "")              
        validaCampo = true;      
      
      if($("#txtNombSindicato").val() === "")              
        validaCampo = true;
              
      if($("#txtRut").val() === "")                    
        validaCampo = false;
    
      if($("#sltPeriodoVigJuntaDirectiva").val() === "")                   
        validaCampo = true;    
            
      if($("#sltCodDepartamento").val() === "")                    
        validaCampo = true;
            
      if($("#sltCodMunicipio").val() === "")                    
        validaCampo = true;      
      
      if($("#sltEstado").val() === "")                   
        validaCampo = true;      
    
      
      var codEstado = $("#sltEstado").find(':selected').val();
      if(codEstado === "INACTIVO" && $("#sltCaracteristicasSindicatoInactivo").val() === "")
          validaCampo = true;
                   
     
      var codBien = $("#sltBienesInmueblesProp").find(':selected').val();
      if(codBien === "OTROSBIENESINMUEBLES" && $("#txtOtrosBienesInmubles").val() === "")
          validaCampo = true;
      
        $('#txtOtraAfiliInter').attr('disabled', 'disabled');

        $("#sltAfiliacionInt").change(function(event){
            var codBien = $("#sltAfiliacionInt").find(':selected').val();
            if(codBien === "OTRAAFILFEDERINT")
                $('#txtOtraAfiliInter').removeAttr('disabled');
            else
                $('#txtOtraAfiliInter').attr('disabled', 'disabled');
        });           
      
      if(validaCampo === false)
      {
        $( "#divErrorMod" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(codBien === "OTROSBIENESINMUEBLES" && $("#txtOtrosBienesInmubles").val() === "")
        {            
            //var idx = $('#tabAdicionar a[href="#about-content"]').parent().index();
            //$("#tabAdicionar").tabs( "option", "active", idx);
            var index = $('#tabModificar a[href="#about-contentMod"]').parent().index();
            $('#tabModificar').tabs({ active: index });
            $("#txtOtrosBienesInmubles").css({'border': "1px solid #A30000"});
            $('#txtOtrosBienesInmubles').focus();            
            $( "#divErrorMod" ).text( "Falta diligenciar el campo Otros Bienes Inmuebles de la pestaña información administrativa." ).show();
        }
        else if(codEstado === "INACTIVO" && $("#sltCaracteristicasSindicatoInactivo").val() === "")
        {   
            var index = $('#tabModificar a[href="#about-contentMod"]').parent().index();
            $('#tabModificar').tabs({ active: index });
            $("#sltCaracteristicasSindicatoInactivo").css({'border': "1px solid #A30000"});
            $('#sltCaracteristicasSindicatoInactivo').focus();            
            $( "#divErrorMod" ).text( "Falta diligenciar el campo Característica  para  Sindicato Inactivo de la pestaña información administrativa." ).show();
        }
        else
            $( "#divErrorMod" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});