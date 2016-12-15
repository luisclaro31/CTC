<?php
//Zona horaria de Bogotá
date_default_timezone_set('America/Bogota');

//Variables global
$url_base = $_SERVER['DOCUMENT_ROOT']."/";
@setlocale(LC_TIME, 'es_ES'); //Defino idioma para host local

$fecha = strftime("%A, %d de %B de %Y");

//Llama a la cabecera de la pagina
function Cabecera($titulo, $item = 0)
{
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='es' lang='es'>
    <head>
            <title><?php echo $titulo ?> | Excellentiam Soluciones Empresariales</title>

            <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/>
            <meta name="author" content="Excellemtiam - 2014" />
            <meta name="keywords" content="" />
            <meta name="description" content="" />

            <link rel="shortcut icon" href="/config/images/log.ico"/>
            <link rel="stylesheet" type="text/css" href="/config/css/Styles.css" />
            <link rel="stylesheet" type="text/css" href="/config/css/orbit-1.2.3.css">
            <link rel="stylesheet" type="text/css" href="/config/css/imageScroller.css">

            <script type="text/javascript" src="/config/js/jquery-1.5.1.min.js"></script>
            <script type="text/javascript" src="/config/js/jquery.orbit-1.2.3.min.js"></script>
            <script type="text/javascript" src="/config/js/jquery.orbit-1.2.3.js"></script>
            <script type="text/javascript" src="/config/js/jvalidaciones.js"></script>
            
            <link rel="stylesheet" type="text/css" href="/config/css/Banner.css" />
            <link rel="stylesheet" type="text/css" href="/config/css/BannerAnexo.css" />
		<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="http://tympanus.net/Tutorials/SlideshowJmpress/css/style_ie.css" />
		<![endif]-->
		<!-- jQuery -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
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

    </head>

    <body>
        <div align="center">
            <div id="divCabecera">
                <div id="divCont1">
                    <div class="floatLeft">
                        <a href="index.php"><img src="/config/images/logo.jpg"/></a>
                    </div>
                    <div id="divCont2">
                            <div align="right" class="textRight">
                                <div class="floatRight">
                                    <address><a href="mailto:contacto@excellentiam.co"><img src="/config/images/correo-mini.png" border="0"/></a></address>
                                </div>
                                <div class="floatRight">
                                    <a href="https://www.facebook.com/excellentiam.solucionesempresariales" target="_blank"><img src="/config/images/face-mini.png" border="0"/></a>
                                </div>
                                <div class="floatRight">
                                    <a href="https://twitter.com/excellentiam" target="_blank"><img src="/config/images/twitter-mini.png" border="0"/></a>
                                </div>                                
                                <div style="clear: both;"></div>
                            </div>
                            <div id="divCreandoIn">Creando, Innovando, Proyectando y Creciendo</div>
                            <div align="right" id="divBuscar">
                                    <div id="divImgBuscar"><img src="/config/images/buscar.jpg" /></div> 
                                    <div id="divTextoBuscar"><input type="text" style="color: #C8C8C9;" value="Buscar en el sitio"></div> 
                                    <div id="divAyuda">Ayuda |</div>    				   				    				
                            </div>
                    </div>
                </div>    
            </div>
            <div style="width: 100%;clear: both;background-color: #00192D;">
                <div class="container">                                    
                    <section id="jms-slideshow" class="jms-slideshow">
                            <div class="step" data-color="color-2">
                                    <div class="jms-content">
                                        <h3>Quienes somos...</h3>
                                        <p>Brindamos soluciones integrales en teconologías de información que responden eficazmente a los requerimientos especificos del cliente.</p>
                                        <a class="jms-link" href="quienesSomos.php">Leer mas...</a>
                                    </div>
                                    <img src="config/images/1-banner.png" style="margin-left: 25px;"/>
                            </div>
                            <div class="step" data-color="color-3" data-y="900" data-rotate-x="80">
                                    <div class="jms-content">
                                            <h3>Mesa de servicios...</h3>
                                    <p> Es la plataforma de automatización y gestión de servicios más eficiente y de menor costo del mercado</p>
                                            <a class="jms-link" href="servicios.php?item=6">Leer mas...</a>
                                    </div>
                                    <img src="config/images/2-banner.png" />
                            </div>
                            <div class="step" data-color="color-4" data-x="-100" data-z="1500" data-rotate="170">
                                    <div class="jms-content">
                                            <h3>Fabricación de software...</h3>
                                    <p>Se desarrollan y producen Sistemas de información donde se Integran los procesos de negocio</p>
                                            <a class="jms-link" href="servicios.php?item=4">Leer mas...</a>
                                    </div>
                                    <img src="images/3.png" />
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
            <div id="linSuperior"></div>
            <div id="divMenu">
                <ul id="menu">
                    <li style="margin-left: 11%;border-left: 2px solid #111;" <?php if($item == 0) echo 'class="select"' ?>><a href="index.php">Inicio</a></li>
                    <li <?php if($item == 1) echo 'class="select"' ?>><a href="quienesSomos.php">Nosotros</a></li>
                    <li <?php if($item == 2) echo 'class="select"' ?>><a href="servicios.php">Portafolio de Servicios</a></li>
                    <li <?php if($item == 3) echo 'class="select"' ?>><a href="contactenos.php">Contactenos</a></li>
                </ul>
            </div>
    <?php
}

//LLama al final del documento
function fin()
{
    ?>
        <div id="linInferior"></div>
            <div id="divCont3">
                <div id="divFin">
                    <div id="divLogoAbajo"><a href="index.php"><img src="/config/images/logo.jpg" class="logo"/></a></div>
                    <div id="divContacto">
                            Contactenos: 
                            <br/> 
                            <address><a href="mailto:contacto@excellentiam.co" style="color: #1818BD;">contacto@excellentiam.co</a></address>
                    </div>
                    <div id="divLinks">
                            <a href="https://www.facebook.com/excellentiam.solucionesempresariales" target="_blank">Facebook</a>
                            <br/> 
                            <a href="https://twitter.com/excellentiam" target="_blank">Twitter </a>
                            <br/>
                            Sugerir la pagina a un amigo
                    </div>
                    <div id="divSiguenos">Siguenos:&nbsp;&nbsp;</div>
                    <div id="copyRight">
                            &copy; Copyright 2014, Excellentiam Soluciones Empresariales. All Rights Reserved.
                    </div>    		
                </div>
            </div>
        </div>    
    </body>
    </html>
    <?php
}
?>



        
    	