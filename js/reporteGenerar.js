$(function(){       
    $("form").validate({
        rules: {                        
          sltTabla: {
              required: true
          }
        },
        messages: {                                              
            sltTabla: "Seleccione la tabla a consultar"           
        }
    });
    //$('.pasar').click(function() { return !$('#origen option:selected').remove().appendTo('#sltOrdernarPor'); });  
    //$('.quitar').click(function() { return !$('#sltOrdernarPor option:selected').remove().appendTo('#origen'); });
    //$('.pasartodos').click(function() { $('#origen option').each(function() { $(this).remove().appendTo('#sltOrdernarPor'); }); });
    //$('.quitartodos').click(function() { $('#sltOrdernarPor option').each(function() { $(this).remove().appendTo('#origen'); }); });
    //$('.submit').click(function() { $('#sltOrdernarPor option').prop('selected', 'selected'); });    

    $('#pasarOrdernarPor').click(function(){

        $('#origenOrdernarPor option:selected').each( function() {

                $('#sltOrdernarPor').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");

            $(this).remove();

        });

    });

    $('#quitarOrdernarPor').click(function(){

        $('#sltOrdernarPor option:selected').each( function() {

            $('#origenOrdernarPor').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");

            $(this).remove();

        });

    });    
    
    $('#pasarAgruparPor').click(function(){

        $('#origenAgruparPor option:selected').each( function() {

                $('#sltAgruparPor').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");

            $(this).remove();

        });

    });

    $('#quitarAgruparPor').click(function(){

        $('#sltAgruparPor option:selected').each( function() {

            $('#origenAgruparPor').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");

            $(this).remove();

        });

    });        
    
    $("#sltTabla").change(function(event){
        var id = $("#sltTabla").find(':selected').val();
        id = id.toLowerCase();
        //$("#sltOrdernarPor").load('/index.php/controladorReporte/ObtenerTablaPorColumna/' + id);
        $("#origenOrdernarPor").load('/index.php/controladorReporte/ObtenerColumnaPorTabla/' + id); 
        //$("#txtOrdernarPor").val('/index.php/controladorReporte/ObtenerColumnaPorTabla/' + id);
        $("#origenAgruparPor").load('/index.php/controladorReporte/ObtenerColumnaPorTabla/' + id);
        $("#sltCampo").load('/index.php/controladorReporte/ObtenerTablaPorColumna/' + id);
    }); 
            
    $( "form" ).submit(function( event ) {
      var validaCampo = false;
        
      if($("#sltTabla").val() === "")                    
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
