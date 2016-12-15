<?php
include("config/codes/config.php");

Cabecera("Contactenos", 4);
?>
	
    <!-- Banner Acordion -->    
    <div align="center" style="border-top: 0px dashed #666668;padding-top: 5px;width: 990px; height="5px" margin-left: 15px;" >

        <div  align="left" class="forma" style=" font-size: 13px; -webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px;CCborderRadius: 5px; float:left; background-color: #ddd;border: 1px solid #B7B7B7;padding: 15px;">
  			<form name="fomulario1" action="#" method="post" class="contact_form">           
                        <a>Nombres y Apellidos</a> <b style="color: #C43636;">*</b>
                       <br/>
                       <input title="Se necesita un Nombre" type="text" name="nombres" id="nombres" val="" size="30"  required />
                       <br/><br/>
                       <a>Empresa</a> <b style="color: #C43636;">*</b>
                	<b style="margin-right: 170px;"></b> <a>Tel&eacute;fono</a> <b style="color: #C43636;">*</b>                        
                       <br/>
                       <input title="Se necesita el nombre de la empresa" type="text" name="Emp" id="Emp" val="" size="30"  required/> 
                       <input title="Se necesita el tel&eacute;fono de la empresa" type="text" name="ciu" id="Emp" val="" size="30"  required/>                     
                       <br/><br/>
                       <a>E-mail</a> <b style="color: #C43636;">*</b>
                       <br/>
                       <input title="mail@ejemplo.com" type="text" name="email" id="email" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" size="30"  required/>
                       <br/><br/>
                       </br><br>
                       <a>Pa&iacute;s</a> <b style="color: #C43636;">*</b>
                       <b style="margin-right: 80px;"></b> <a>Ciudad</a> <b style="color: #C43636;">*</b>                        			
                       </br><br>
                       	<select name=pais onchange="cambia_provincia()">
			<option value="0" selected>Seleccione...
			<option value="1">Colombia
			<option value="2">Argentina
			<option value="3">Espa&ntilde;a
			<option value="4">Francia
			</select>
			
			<select name=provincia>
			<option value="-">-
			</select>
                       <br/><br/>			
                       <a>Mensaje</a> <b style="color: #C43636;"  >*</b>
                       <br/>
                       <textarea title="Se necesita su Mensaje" cols="55" rows="5" name="comentarios"  id="comentarios" required > </textarea>				
                       <div align="center">
                           <button class="submit" type="submit" value="Enviar" name="env" id="env" style="width: 120px; height: 25px;"> Enviar</button>						
                       </div>
                       </form>
			<script>
			//defino una serie de varibles Array para cada país
			var provincias_1=new Array ("-","Bogota "," Bucaramanga "," Cucuta "," Pereira "," Cali "," Pasto "," Santa marta ",
			" Manizales "," Villavicencio "," Valledupar "," Buenaventura "," Neiva"," Pereira "," Medellin"," Soacha "," Ibague ",
			" Barranquilla"," Cartagena ","...")
			var provincias_2=new Array("-","Salta","San Juan","San Luis","La Rioja","La Pampa","...")
			var provincias_3=new Array("-","Andalucia","Asturias","Baleares","Canarias","Castilla y Leon","Castilla-La Mancha","...")
			var provincias_4=new Array("-","Aisne","Creuse","Dordogne","Essonne","Gironde ","...")
			
			//función que cambia las provincias del select de provincias en función del país que se haya escogido en el select de país.
			function cambia_provincia(){
				//tomo el valor del select del pais elegido
				var pais
				pais = document.fomulario1.pais[document.fomulario1.pais.selectedIndex].value
				//miro a ver si el pais está definido
				if (pais != 0) {
					//si estaba definido, entonces coloco las opciones de la provincia correspondiente.
					//selecciono el array de provincia adecuado
					mis_provincias=eval("provincias_" + pais)
					//calculo el numero de provincias
					num_provincias = mis_provincias.length
					//marco el número de provincias en el select
					document.fomulario1.provincia.length = num_provincias
					//para cada provincia del array, la introduzco en el select
					for(i=0;i<num_provincias;i++){
					   document.fomulario1.provincia.options[i].value=mis_provincias[i]
					   document.fomulario1.provincia.options[i].text=mis_provincias[i]
					}	
				}else{
					//si no había provincia seleccionada, elimino las provincias del select
					document.fomulario1.provincia.length = 1
					//coloco un guión en la única opción que he dejado
					document.fomulario1.provincia.options[0].value = "-"
				    document.fomulario1.provincia.options[0].text = "-"
				}
				//marco como seleccionada la opción primera de provincia
				document.fomulario1.provincia.options[0].selected = true
			}
			</script>
		 </div>

        <div style="float:left;">
            <div align="left" class="forma" style=" font-size: 13px; -webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px;CCborderRadius: 5px; background-color: #ddd;border: 1px solid #B7B7B7;padding: 7px;margin-left: 16px;width: 445px; height: 172px;">
                
                <b style="margin-left: 37px;">Direcci&oacute;n:</b> <a style=" margin-left: 97px;">Cra. 18 # 86 A 14.</a>
                <br/>
                <b style=" margin-left: 37px;"></b><a style=" margin-left: 157px;">Bogot&aacute;, Colombia.</a>
                <br/><br/>
                <b style="margin-left: 37px;">Web:</b> <b style="margin-left: 120px; color: #122ACC;">www.excellentiam.co</a></b>
                <br/><br/>
                <b style="margin-left: 37px;">Tel:</b> <a style=" margin-left: 147px;">57 1 638 6031 </a>
                <br/><br/>
                <b style="margin-left: 37px;">Celular:</b> <a style=" margin-left: 90px;"> 312 449 8231 / 300 299 2461</a></b>
                <br/><br/>
                <b style="margin-left: 37px;">E-mail:</b> <address><a href="mailto:contacto@excellentiam.co"><b style="color: #122ACC;margin-left: 173px;margin-top: -50px;">contacto@excellentiam.co</b></a></address>
            </div>

            <div class="forma" style="padding-top: 45px;font-size: 13px; -webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px;CCborderRadius: 5px; background-color: #ddd;border: 1px solid #B7B7B7;padding: 8px;margin-left: 16px; height: 180px; width: 445px; margin-top: 8px;text-align: center;">
                            <a>Encuentranos en:</a>
                <br/><br/>
                <a href="https://www.facebook.com/excellentiam.solucionesempresariales" target="_blank"><img src="/config/Imagenes/Facebook.png" border = 0; width="147" height="75" style="margin-right: 25px;"/></a>
                <a href="https://twitter.com/excellentiam" target="_blank"><img src="/config/Imagenes/twitter.png" border = 0; width="147" height="75"/></a>
                <a href="https://www.linkedin.com/excellentiam" target="_blank"><img src="/config/Imagenes/LinKed.png" border = 0;  width="147" height="75"/></a>
            </div>
            </div>
      <div style="clear: both;"></div>
    </div>      
    <!-- Fin Banner Acordion -->

<?php fin(800) ?>