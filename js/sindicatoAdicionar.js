$(function(){       
    $("form").validate({
        rules: {
          txtFechaAdic: {
            required: false,
            date: true
          },
          txtFechaUltInscrJunDirectivaAdic: {
            required: false,
            date: true
          },
          txtCorreoAdic:{
             required: false,
             email: true
          },
          txtNumeroResolucionAdic:{
             required: true,
             digits: true
          },
          txtRutAdic:{
             required: false,
             digits: true,
             minlength: 6
          },
          txtNombreSindicatoAdic:{
             required: true
          },          
          
          sltDepartamentoAdic: {
              required: true
          },
          sltMunicipioAdic: {
              required: true
          },
          sltPeriodoVigJuntaDirectivaAdic: {
              required: true
          },
          txtNumeroAfiliadosPorEmpresaAdic: {
              required: false,
              digits: true
          },
          txtNumeroAfiliadoActualesAdic: {
              required: false,
              digits: true
          },
          txtNumeroAfiliadosHombresAdic: {
              required: false,
              digits: true
          },
          txtNumeroAfiliadosMujeresAdic: {
              required: false,
              digits: true
          },
          txtNumeroAfiliadosJovenesMenor35Adic: {
              required: false,
              digits: true
          },

          txtNumeroAfiliadosSectorFormalAdic: {
              required: false,
              digits: true
          },
          txtNumeroAfiliadosSectorInformalAdic: {
              required: false,
              digits: true
          },

          txtFechaUltActualizacionInfAdic: {
            required: false,
            date: true
          }
          
        },
        messages: {            
            txtCorreoAdic: "Escriba un email valido",
            txtFechaUltInscrJunDirectivaAdic: "Escriba o seleccione una fecha valida",
            txtFechaAdic: "Escriba o seleccione una fecha valida",
            txtNumeroResolucionAdic: { 
                required: "Escriba un número de resolución",
                digits: "Solo se permiten números"
            },
            txtRutAdic: { 
                required: "Escriba el RUT",
                digits: "Solo se permiten números",
                minlength: "Mínimo 6 digitos"
            },
            txtNombreSindicatoAdic: "Escriba un nombre",
            sltDepartamentoAdic: "Seleccione un departamento",
            sltMunicipioAdic: "Seleccione un municpio",
            sltPeriodoVigJuntaDirectivaAdic: "Seleccione un periodo de vigencia",
            txtNumeroAfiliadosPorEmpresaAdic: "Solo se permiten números",
            txtNumeroAfiliadoActualesAdic: "Solo se permiten números",
            txtNumeroAfiliadosHombresAdic: "Solo se permiten números",
            txtNumeroAfiliadosMujeresAdic: "Solo se permiten números",
            txtNumeroAfiliadosJovenesMenor35Adic: "Solo se permiten números",
            txtNumeroAfiliadosSectorFormalAdic: "Solo se permiten números",
            txtNumeroAfiliadosSectorInformalAdic: "Solo se permiten números",                        
            txtFechaUltActualizacionInfAdic: "Escriba o seleccione una fecha valida"
            
        }
    });
    
   $(function() {  Otras_secretaria();
   $("#chkOtraSecretariaAdic").click(Otras_secretaria);});

    function Otras_secretaria() {
    if (this.checked) {
        
        $('#txtOtraSecretariaAdic').removeAttr('disabled');
        
    } else {
      
        $('#txtOtraSecretariaAdic').attr('disabled', 'disabled');
          }
    }        
    
    $('#txtOtrosBienesInmueblesAdic').attr('disabled', 'disabled');
    
    $("#sltBienesInmueblesPropAdic").change(function(event){
        var codBien = $("#sltBienesInmueblesPropAdic").find(':selected').val();
        if(codBien === "OTROSBIENESINMUEBLES")
            $('#txtOtrosBienesInmueblesAdic').removeAttr('disabled');
        else
            $('#txtOtrosBienesInmueblesAdic').attr('disabled', 'disabled');
    }); 
    
    $('#txtOtraAfiliInterAdic').attr('disabled', 'disabled');
    
    $("#sltAfiliacionIntAdic").change(function(event){
        var codBien = $("#sltAfiliacionIntAdic").find(':selected').val();
        if(codBien === "OTRAAFILFEDERINT")
            $('#txtOtraAfiliInterAdic').removeAttr('disabled');
        else
            $('#txtOtraAfiliInterAdic').attr('disabled', 'disabled');
    });     
    
        $('#txtOtraClasifSubSectAdic').attr('disabled', 'disabled');

        $("#sltClasifSubSectCutAdic").change(function(event){
            var codBien = $("#sltClasifSubSectCutAdic").find(':selected').val();
            if(codBien === "OTRACLASIFSUBCUT")
                $('#txtOtraClasifSubSectAdic').removeAttr('disabled');
            else
                $('#txtOtraClasifSubSectAdic').attr('disabled', 'disabled');
        });                        
    
    $("#sltDepartamentoAdic").change(function(event){
        var id = $("#sltDepartamentoAdic").find(':selected').val();
        $("#sltMunicipioAdic").load('/index.php/controladorSindicato/ObtenerMunicipiosPorDepartamento/' + id);
    }); 
    
    $("#sltClasifSectCutAdic").change(function(event){
        var id = $("#sltClasifSectCutAdic").find(':selected').val();
        $("#sltClasifSubSectCutAdic").load('/index.php/controladorSindicato/ObtenerClasifSectCut/' + id);
    });     
        
    $("input[name=txtRutAdic]").change(function(){        
        var valor = $("#txtRutAdic").val();
        $("#divRutVal").empty();
        $("#divRutVal").load('/index.php/controladorSindicato/ValidarRut/' + valor);                
    });
        
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
            
      var existeRut = $('#divRutVal').is(':empty');      
      if(existeRut === false)
        validaCampo = true;
    
      if($("#txtNumeroResolucionAdic").val() === "")              
        validaCampo = true;      
      
      if($("#txtNombreSindicatoAdic").val() === "")              
        validaCampo = true;
              
      if($("#txtRutAdic").val() === "")                    
        validaCampo = false;    
    
      if($("#sltPeriodoVigJuntaDirectivaAdic").val() === "")              
        validaCampo = true;        

            
      if($("#sltDepartamentoAdic").val() === "")                    
        validaCampo = true;
            
      if($("#sltMunicipioAdic").val() === "")                    
        validaCampo = true;      
    
      var codBien = $("#sltBienesInmueblesPropAdic").find(':selected').val();
      if(codBien === "OTROSBIENESINMUEBLES" && $("#txtOtrosBienesInmueblesAdic").val() === "")
          validaCampo = true;
      
      if(validaCampo === false)
      {
        $( "#divError" ).text( "Cargando..." ).show();
        return;
      }
      else      
      {
        if(existeRut === false)
            $( "#divError" ).text( "El RUT ya existe, escriba uno nuevo." ).show();
        else if(codBien === "OTROSBIENESINMUEBLES" && $("#txtOtrosBienesInmueblesAdic").val() === "")
        {            
            //var idx = $('#tabAdicionar a[href="#about-content"]').parent().index();
            //$("#tabAdicionar").tabs( "option", "active", idx);
            var index = $('#tabAdicionar a[href="#about-content"]').parent().index();
            $('#tabAdicionar').tabs({ active: index });
            $("#txtOtrosBienesInmueblesAdic").css({'border': "1px solid #A30000"});
            $('#txtOtrosBienesInmueblesAdic').focus();            
            $( "#divError" ).text( "Falta diligenciar el campo Otros Bienes Inmuebles de la pestaña información administrativa." ).show();
        }
        else
            $( "#divError" ).text( "Falta diligenciar campos obligatorios, revisar todas las pestañas." ).show();
        
        event.preventDefault();        
      }
    });
});