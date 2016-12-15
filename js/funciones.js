$(function() { 
    $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-60Y", maxDate: "0", changeMonth: true, changeYear: true });
    $( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-60Y", maxDate: "0", changeMonth: true, changeYear: true }); 
    $( "#datepicker3" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-40Y", maxDate: "0", changeMonth: true, changeYear: true }); 
    $( "#datepicker4" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-40Y", maxDate: "0", changeMonth: true, changeYear: true }); 
    $( "#datepicker5" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-40Y", maxDate: "0", changeMonth: true, changeYear: true }); 
    $( "#datepicker6" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-40Y", maxDate: "0", changeMonth: true, changeYear: true }); 
    $( "#datepicker7" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-40Y", maxDate: "0", changeMonth: true, changeYear: true }); 
    $( "#datepicker8" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-40Y", maxDate: "0", changeMonth: true, changeYear: true }); 
    $( "#datepicker9" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-40Y", maxDate: "0", changeMonth: true, changeYear: true }); 
    $( "#datepicker10" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-120Y", maxDate: "0", changeMonth: true, changeYear: true });
    $( "#datepicker11" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-120Y", maxDate: "0", changeMonth: true, changeYear: true });
    $( "#datepickerMayor" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-40Y", maxDate: "+20Y", changeMonth: true, changeYear: true });
    $( "#datepickerMayor2" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-40Y", maxDate: "+20Y", changeMonth: true, changeYear: true });
    $( "#datepickerMayor3" ).datepicker({ dateFormat: "yy-mm-dd", minDate: "-0Y", maxDate: "+20Y", changeMonth: true, changeYear: true });
    $(".fechas").keypress(function() { return false; });    
    $("#dialogo").dialog({ 
                height: 200,                           
                resizable: false,
                modal: true                        
    });             
    $(".limpiarFormulario").click(function(){
        $('form').clearForm(); 
        $("#divRutVal").empty();
        $("#divError").empty();
        $("#divErrorMod").empty();
    });
    $('#sidemenu a').on('click', function(e){
      e.preventDefault();
      if($(this).hasClass('open')) 
      {
        // do nothing because the link is already open
      } 
      else {
        var oldcontent = $('#sidemenu a.open').attr('href');
        var newcontent = $(this).attr('href');

        $(oldcontent).fadeOut('fast', function(){
          $(newcontent).fadeIn().removeClass('hidden');
          $(oldcontent).addClass('hidden');
        });
        $('#sidemenu a').removeClass('open');
        $(this).addClass('open');
      }
    });        
   $('#sidemenuMod a').on('click', function(e){
      e.preventDefault();
      if($(this).hasClass('open')) 
      {
        // do nothing because the link is already open
      } 
      else {
        var oldcontent = $('#sidemenuMod a.open').attr('href');
        var newcontent = $(this).attr('href');

        $(oldcontent).fadeOut('fast', function(){
          $(newcontent).fadeIn().removeClass('hidden');
          $(oldcontent).addClass('hidden');
        });
        $('#sidemenuMod a').removeClass('open');
        $(this).addClass('open');
      }
    });
 });       
 function Confirmar(url)
 {
     $(function() {
         $( "#dialog-confirm" ).dialog({
           resizable: false,
           height:140,
           modal: true,
           buttons: {
             "Aceptar": function() {
               $( this ).dialog( "close" );  
               document.location = url;
               return true;
             },
             Cancel: function() {
               $( this ).dialog( "close" );
               return false;   
             }
           }
         });
     });            
 }
 function nobackbutton()
 { 
   window.location.hash = "no-back-button";
   window.location.hash = "Again-No-back-button"; //chrome
   window.onhashchange = function() {
   window.location.hash = "no-back-button";
   }
 }
 
/*Filtra por grid*/ 
function filtrar()
{
        var tableReg = document.getElementById('grid');
        var searchText = document.getElementById('searchTerm').value.toLowerCase();
        var cellsOfRow="";
        var found=false;
        var compareWith="";

        // Recorremos todas las filas con contenido de la tabla
        for (var i = 1; i < tableReg.rows.length; i++)
        {
                cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
                found = false;
                // Recorremos todas las celdas
                for (var j = 0; j < cellsOfRow.length && !found; j++)
                {
                        compareWith = cellsOfRow[j].innerHTML.toLowerCase();
                        // Buscamos el texto en el contenido de la celda
                        if (searchText.length == 0 || (compareWith.indexOf(searchText) > -1))
                        {
                                found = true;
                        }
                }
                if(found)
                {
                        tableReg.rows[i].style.display = '';
                } else {
                        // si no ha encontrado ninguna coincidencia, esconde la
                        // fila de la tabla
                        tableReg.rows[i].style.display = 'none';
                }
        }
} 

$(document).ready(function() {
    $('#table').DataTable( {
        columnDefs: [ {
            targets: [ 0 ],
            orderData: [ 0, 1 ]
        }, {
            targets: [ 1 ],
            orderData: [ 1, 0 ]
        }, {
            targets: [ 4 ],
            orderData: [ 4, 0 ]
        } ]
    } );
} );		

 
 /*calendario*/
 
$(document).ready(function(){
        	//al pulsar en un campo del calendario
            $("#calendario .dia").click(function(){

            	//obtenemos el nÃºmero del dÃ­a
                var num_dia = $(this).find('.num_dia').html();

                //detectamos si es hoy
                var hoy = $(this).find('.highlight').html();

                //si es hoy podemos hacer otras cosas
                if(hoy)
                {
                	$( "<div>Hoy no puede generar agenda</div>" ).dialog({
				      title: 'Hoy no se puede agendar',
				      height: 300,
				      width: 350,
				      modal: true,
				      buttons: {
				        "Aceptar": function() {
				        	$(this).dialog('close');
				         }
				      }

				    });     
                	return false;
                }

                //obtenemos el año a traves del campo oculto del formulario
                var year = $(".year").val();

                //obtenemos el mes a traves del campo oculto del formulario
                var month = $(".month").val();


                //obtenemos el mes a traves del campo oculto del formulario
                //y le restamos uno porque en javascript los meses igual que
                //los dÃ­as empiezan en 0, si es enero debe ser 0 y no 1
                var monthjs = $(".month").val() - 1;

                //anteponemos el 0 si es un solo numero para poder trabajar
                //correctamente la fecha
                if(num_dia.lenght == 1)
                {
                	num_dia = '0'+num_dia;
                }

                //anteponemos el 0 si es un solo numero para poder trabajar
                //correctamente la fecha
                if(month.lenght == 1)
                {
                	month = '0'+month;
                }

                //creamos la fecha sobre la que el usuario ha pulsado
                var fecha = new Date(year,monthjs,num_dia);
				
				//si es sábado no dejamos insertar, solo trabajamos hasta el viernes! :D
				if(fecha.getDay() == 6) 
				{
					$( "<div>Hoy es s�bado</div>" ).dialog({
				      title: 'Hoy no se generar agenda porque es s�bado',
				      height: 300,
				      width: 500,
				      modal: true,
				      buttons: {
				        "Aceptar": function() {
				        	$(this).dialog('close');
				         }
				      }

				    });     
                	return false;
				}

				//si es domingo menos! (; dodmingo es el día 0 de la semana en javascript
				if(fecha.getDay() == 0) 
				{
					$( "<div>Hoy es domingo</div>" ).dialog({
				      title: 'Hoy no se generar agenda porque es domingo',
				      height: 300,
				      width: 500,
				      modal: true,
				      buttons: {
				        "Aceptar": function() {
				        	$(this).dialog('close');
				         }
				      }

				    });     
                	return false;
				}

				//si es distinto de nulo significa que hemos pulsado en un cuadro
				//del calendario que tiene nÃºmero
                if(num_dia != null)
                {

                   $("<div id='formul' class='miform'><form name='formu' class='formu'"+ 
                   	"method='POST' action='http://siscut.juliomedellin.com/index.php/controladorNotificacion/calen'>"+
                   	"<input type='hidden' value="+num_dia+" name='dia' />"+
                   	"<input type='hidden' value="+month+" name='month' />"+
                   	"<input type='hidden' value="+year+" name='year' />"+
                   	"<input type='text' name='comentario' /></form></div>").dialog({
				      title: 'Generar evento',
				      height: 300,
				      width: 350,
				      modal: true,
				      buttons: {
				        "Guardar": function() {      	
				        	$.ajax({
		                        url : $(".formu").attr('action'),
		                        type: 'POST',
		                        data: $(".formu").serialize(),

		                        success: function(data){        	
		                        	$('#formul').dialog('close');
		                            $('<div class="hecho">El evento se ha guardado, genere la notificaci&oacute;n</div>').dialog({
									      title: 'Evento guardado',
									      height: 300,
									      width: 350,
									      modal: true,									      
									});
									setTimeout(function() {
		                                window.location.href = "http://siscut.juliomedellin.com/index.php/controladorNotificacion/cal/"+year+"/"+month+"/1/";
		                            }, 2000);
		                        }
		                    });
				         },
				         "Cerrar": function() {
				         	$(".miform").dialog('close');
				         }
				      }

				    });

                }

            })
		            
        });