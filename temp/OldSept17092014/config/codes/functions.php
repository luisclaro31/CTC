<?php
//Zona horaria de Bogotá
date_default_timezone_set('America/Bogota');

//Variables global
$url_base = $_SERVER['DOCUMENT_ROOT']."/";
@setlocale(LC_TIME, 'es_ES'); //Defino idioma para host local

$fecha = strftime("%A, %d de %B de %Y");
$idioma = $_GET["lang"];

//Llama a la cabecera de la pagina
function Cabecera($titulo, $item = 0, $idioma = 1)
{
    global $bd;        
    $datos = $bd->select_items("Nombre, Direccion, Telefono, Celular, Email, Facebook, Twitter, Linked, Copyright, Id_Ciudad, Slogan, SeleccionIdioma","Admin_DatosEmpresa","id = 1 AND Id_Idioma = ".$idioma);
    $datosIdioma = $bd->select_items("I.Descripcion, IM.Nombre, I.TextoBuscar","Admin_Idioma I,Operacion_Imagenes IM","IM.Id = I.Id_Imagen AND I.Id = ".$idioma);
    
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='es' lang='es'>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />            
    <title> <?php echo $titulo ?> | <?php echo ucfirst(ucwords($datos[0])) ?></title>    
    
    <link rel="shortcut icon" href="config/images/log.ico"/>
    <link rel="stylesheet" type="text/css" href="config/css/menu.css" />    
    <link rel="stylesheet" type="text/css" href="/config/css/orbit-1.2.3.css" />
    <link rel="stylesheet" type="text/css" href="/config/css/imageScroller.css" /> 
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="/config/css/tabs-mouseover.css" />  
    <link rel="stylesheet" type="text/css" href="/config/css/Banner.css" />
    <link rel="stylesheet" type="text/css" href="/config/css/BannerAnexo.css" />
    <link rel="stylesheet" type="text/css" href="config/css/estilos.css" />    
    <!--[if IE 6]>
        <style>
        body {behavior: url("config/css/csshover3.htc");}
        #menu li .drop {background:url("img/drop.gif") no-repeat right 8px; 
        </style>
    <![endif]-->
    
    <!--[if IE 9]>
        <style>
	   #menu li {margin-top:12px;}
	   #bannerContenidoInf3{padding: 10px 35px 5px 25px;
                                font-size: 19px;height: 100px;width: 200%;color: #fff;margin-top:110px;margin-left: 22%;}
           #bannerContenidoImg3{margin-top: 315px;}
        </style>
    <![endif]-->
    
    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="http://tympanus.net/Tutorials/SlideshowJmpress/css/style_ie.css" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->	
	
    <!--[if IE 11]>
        <style>
           
        </style>
    <![endif]-->	
	
    <!-- jQuery -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script type="text/javascript" src="/config/js/jquery.orbit-1.2.3.min.js"></script>
    <script type="text/javascript" src="/config/js/jquery.orbit-1.2.3.js"></script>
    <script type="text/javascript" src="/config/js/jvalidaciones.js"></script>
    <!-- jmpress plugin -->
    <script type="text/javascript" src="http://tympanus.net/Tutorials/SlideshowJmpress/js/jmpress.min.js"></script>
    <!-- jmslideshow plugin : extends the jmpress plugin -->
    <script type="text/javascript" src="http://tympanus.net/Tutorials/SlideshowJmpress/js/jquery.jmslideshow.js"></script>
    <script type="text/javascript" src="http://tympanus.net/Tutorials/SlideshowJmpress/js/modernizr.custom.48780.js"></script>
        
    <noscript>
            <style>
            .step {
                    width: 100%;
                    position: relative;
            }
            .step:not(.active) {
                    opacity: 1;
                    filter: alpha(opacity=99);
                    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(opacity=99)";
            }
            .step:not(.active) a.jms-link{
                    opacity: 1;
                    margin-top: 40px;
            }
            </style>
    </noscript>
	
    <script type="text/javascript">
        $(function() {
          $( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
          $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
        });
    </script>
  
</head>
<body>
    <div align="center" id="principal">
        <!-- Cabecera -->
        <div align="left" id="cabecera">            
            <div align="left" id="cabeceraLogo">
                <a href="index.php"><img src="config/images/logo.png" alt="Inicio Excellentiam" border="0"/></a>
            </div>            
            <div id="cabeceraLinks">
                <a href="<?php echo $datos[5] ?>" target="_blank"><img src="config/images/fac_n.png" alt="Facebook" border="0"/></a>
                <a href="<?php echo $datos[6] ?>" target="_blank"><img src="config/images/twi_n.png" alt="Twitter" border="0"/></a>
                <a href="mailto:<?php echo $datos[4] ?>"><img src="config/images/cor_n.png" alt="Correo" border="0"/></a>
                <a href="<?php echo $datos[7] ?>" target="_blank"><img src="config/images/lin_n.png" alt="Linken-in" border="0"/></a>
            </div>
            <div id="cabeceraTexto">
                <?php echo $datos[10] ?>
            </div>
            <div>
                <form>
                    <div id="cabeceraBarraBusqueda">
                     <div id="cabeceraBarraBusquedaIdioma"><b style="font-size: 11px;"><?php echo $datos[11] ?> </b> </div>			 
                     <div id="cabeceraBarraBusquedaEsp"><img src="config/Imagenes/<?php echo $datosIdioma[1] ?>" /></div>
                     <div id="cabeceraBarraBusquedaDesc"> <b style="font-size: 11px;"> <?php echo $datosIdioma[0] ?> </b> </div>
                     <div id="cabeceraBarraBusquedaBuscador"><input name="buscador" type="text" placeholder="<?php echo $datosIdioma[2] ?>" id="buscador"/></div>
                     <div id="buscadorimg"><input  type="submit" value="" id="buscadorimgInput" /></div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Fin Cabecera -->
        <!-- Menú -->        
        <div align='center' id="menuP">
            <ul id="menu">
                <!-- Menú 1-->
                <li <?php if($item == 1) echo 'id="drop-1"'; ?>>
                    <a  href="index.php" id="select">Inicio</a>                    
                </li>                
                <!-- End Menú 1 -->
                <!-- Menú 2-->
                <li <?php if($item == 2) echo 'id="drop-1"'; ?>>
                    <a href="nosotros.php?id=1" class="drop">Nosotros</a>
                    <div class="dropdown_3columns">
                        <div class="col_1" id='menuCol1'>
                            <div class='left'>
                                <img src="config/Imagenes/tecnologia.png" width="25" height="25"/>
                            </div>
                            <div class='menuNosotros'>
                                Quienes Somos
                            </div>
                            <div class='menuItemMenuNosotros'>
                                <a href='nosotros.php?id=1'>Reseña Histórica</a> 
                                <a href='nosotros.php?id=3'>Politica de Calidad</a> 
                                <a href='nosotros.php?id=5'>Mision</a>                                
                                <a href='nosotros.php?id=6'>Vision</a>                                                                
                                <a href='nosotros.php?id=2'>Objetivos de Calidad</a>
                                <a href='nosotros.php?id=4'>Valores Corporativos</a>
                            </div>                            
                        </div>

                    </div>
                </li>
                <!-- End Menú 2 -->
                <!-- Menú 3-->
                <li <?php if($item == 3) echo 'id="drop-1"'; ?>>
                    <a href="portafolio.php#home" class="drop" style="margin-left: 20px;">Portafolio de Servicios</a>
                    <div class="dropdown_2columns">
                        <div class="col_1" id='menuCol2'>
                            <div class='left'>
                                <img src="config/Imagenes/gestionInfo.png" width="25" height="25"/>
                            </div>
                            <div class='menuNosotros'>
                                Gestion de información
                            </div>
                            <div class='menuItemMenuNosotros'>
                                <a href='portafolio.php#home'>Inteligencia de Negocios</a>                                
                                <a href='portafolio.php#home2'>Aplicaciones Moviles</a>
                                <a href='portafolio.php#home5'>Contenido Empresarial</a>
                            </div>
                            
                             <div id='menuPortafolio'>
                                <img src="config/Imagenes/gestionProc.png" width="25" height="25"/>
                            </div>
                            <div id='menuPortafolio2'>
                                <b>Gestion de Procesos</b>
                            </div>
                            <div id='menuItemMenuPortafolio'>
                                <a href='portafolio.php#gesti'>Gestion de Talento Humano</a> 
                                <a href='portafolio.php#BPO'>Procesos de Negocio</a>                               
                                <a href='portafolio.php#negocio'>Consultoria de Negocios</a>
                                <a href='portafolio.php#sertonic'>Mesa de Servicio</a>
                            </div>
                        </div>

                        <div class="col_1" id='menuPortafolio2'>
                            <div class='left'>
                                <img src="config/Imagenes/tecnologia.png" width="25" height="25"/>
                            </div>
                            <div class='menuNosotros'>
                                <b>Tecnologia de la Informacion</b>
                            </div>
                            <div id='menuItemMenuPortafolio2'>
                                <a href='portafolio.php#home6'>Integracion de Aplicaciones y Plataformas</a>                                
                                <a href='portafolio.php#home7'>Outsourcing y Disponibilidad</a>
                                <a href='portafolio.php#home8'>Fabrica de Software</a>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- End Menú 3 -->
                <!-- Menú 4-->
                <li <?php if($item == 4) echo 'id="drop-1"'; ?>>
                    <a href="contactenos.php" class="drop">Contactenos</a>                    
                </li>
                <!-- End Menú 4 -->
            </ul>
        </div>
        <!-- Fin Menú -->
        <!-- Banner -->
        <div id='banner'>
            <div id="bannerCont">
                <div class="container">                                    
                    <section id="jms-slideshow" >
                            <div class="step" data-color="color-1">
                                    <div class="jms-content">
                                        <h3>Fabricación de software</h3>                                        
                                        <div class='bannerContenidoInf'>Brindamos soluciones integrales en tecnologías
					de información que responden eficazmente a los requerimientos específicos del cliente. 
					Es nuestro propósito convertirnos en el aliado estratégico. </div> 
					<a href="portafolio.php#home8"><img id="bannerContenido" class="bannerContenidoImg" src="config/images/leer-mas.png" width="126" height="45" /></a>
                                    </div>                                    
			    </div> 
                            <div class="step" data-color="color-2" data-y="-100" data-z="1500" data-rotate="170">
                                    <div class="jms-content">
                                        <h3>Gestion de información</h3>
                                        <div class='bannerContenidoInf' >  Apoyamos a las organizaciones alineando a las personas, 
                                            los procesos y su infraestructura tecnológica bajo una sola visión y propósito empresarial,
                                            transformando datos en información y conocimiento, de tal manera que la gerencia pueda planear, 
                                            comunicar, ejecutar y controlar permitiendo el cumplimiento de objetivos operacionales y estratégicos, 
                                            a través de:</div> 
                                        <a href="portafolio.php#home"><img id="bannerContenido" class="bannerContenidoImg1" src="config/images/leer-mas.png" width="126" height="45" /></a>
                                    </div>
                            </div> 			     

                            <div class="step" data-color="color-3" data-x="-100" data-z="1500" data-rotate="170">
                                    <div class="jms-content">
                                        <h3>Outsourcing</h3>
                                        <div class='bannerContenidoInf' >  El servicio de Outsourcing de Excellentiam Soluciones Empresariales 
					permite que las organizaciones puedan disponer de servicios técnicos y profesionales en forma oportuna 
					y permanente durante el periodo de tiempo convenido., aplicados a la gestión operativa, administrativa, de arquitectura, ingeniería en 
                                        sistemas y de procesos, gestión y desarrollo de aplicaciones, operaciones de datacenter...</div> 
                                        <a href="portafolio.php#BPO"><img id="bannerContenido" class="bannerContenidoImg1" src="config/images/leer-mas.png" width="126" height="45" /></a>
                                    </div>
                            </div>   
                            <div class="step" data-color="color-4" data-y="900" data-rotate-x="80">
                                    <div class="jms-content">
                                        <h3>Mesa de Servicios  </h3>
                                        <div class='bannerContenidoInf'>  Es la plataforma de automatización y gestión de servicios más eficiente y 
					de menor costo del mercado, que brinda a las empresas la alternativa de hacer más con menos recursos. 
					Es la herramienta apropiada para la gestión de incidencias, peticiones, quejas, reclamos, solicitudes 
					(PQR´s), en un entorno actual, amigable, potente, totalmente configurable, fácil de usar y adaptable a 
					cualquier entorno que usted necesite en su empresa.</div> 
                                        <a href="portafolio.php#sertonic"><img class="bannerContenidoImg1" src="config/images/leer-mas.png" width="126" height="45" /></a>
                                    </div>
                            </div>  
                    </section>
                </div>
                <script type="text/javascript">
                    $(function() {
                        var jmpressOpts = { animation : { transitionDuration : '0.8s' } };

                        $( '#jms-slideshow' ).jmslideshow( $.extend( true, { jmpressOpts : jmpressOpts }, {
                                autoplay	: true,
                                bgColorSpeed:   '0.9s',
                                arrows		: true,
                                interval	: 9000
                        }));
                        
                        
                    });
                </script>
            </div>
        </div>
        <!-- Fin Banner -->
    <?php
}

//LLama al final del documento
function fin($margin = 805, $idioma = 1)
{
    global $bd;        
    $datos = $bd->select_items("Nombre, Direccion, Telefono, Celular, Email, Facebook, Twitter, Linked, Copyright, Id_Ciudad","Admin_DatosEmpresa","id = 1 AND Id_Idioma = ".$idioma);
    $ciudadPais = $bd->select_item("CONCAT( TRIM( C.Descripcion ) , CONCAT(  ', ', TRIM( P.Descripcion ) ) ) ", "Admin_Ciudad C, Admin_Pais P","C.Id_Pais = P.Id
                                    AND C.Id = $datos[9] AND C.Id_Idioma = ".$idioma);
    ?>
        </div>
    <div align="center" id="piePag" style="margin-top: <?php echo $margin ?>px;">
        <div align="left" id="divPie">            
            <div align="left" id="divPieDesc">
                <div id='divPieLogo' >
                    <img src="config/Imagenes/LogoInf.png" alt="Inicio" width="200" height="60"/>
                </div>
                <div id='divPieDescDatos'>
                    <b style="font-size: 10px;"><?php echo strtoupper($datos[0]) ?></b>
                    <br/>
                    <?php echo $datos[1] ?>
                    <br/>
                    <?php echo $datos[2] ?>                    
                    <br/>
                    <b><?php echo $ciudadPais ?>  </b>
                    <br/>
                    <address><a href="mailto:<?php echo $datos[4] ?>"><b id="divPieContac"><?php echo $datos[4] ?></b></a>
                </div>
                <div id='divPieSig'>
                    Siguenos
                </div>
                <div id="divPieSigLinks">
                <a href="<?php echo $datos[5] ?>" target="_blank"><img src="config/images/fac_abajo.png" alt="Facebook" border="0"/></a>
                <a href="<?php echo $datos[6] ?>" target="_blank"><img src="config/images/twi_abajo.png" alt="Twitter" border="0"/></a>
                <a href="mailto:<?php echo $datos[4] ?>"><img src="config/images/cor_abajo.png" alt="Correo" border="0"/></a>
                <a href="<?php echo $datos[7] ?>" target="_blank"><img src="config/images/lin_abajo.png" alt="Linken-in" border="0"/></a>
                </div>
	    <div style="margin-top: 3px" id="lineInfG"></div>
            <div id="lineInfN"></div>
            <div id='divPieCopy'>
                    <?php echo $datos[8] ?>
            </div>      
            </div>
        </div>
    </div>	
</body>
</html>
    <?php
}
?>



        
    	