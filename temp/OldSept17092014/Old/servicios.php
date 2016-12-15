<?php 
include("config/codes/functions.php");

$titulo = "Portafolio de servicios";
$item = 2;
$seleccion = $_GET["item"];

if(empty($seleccion))
	$seleccion = 1;

Cabecera($titulo, $item)
?>
<link rel="stylesheet" type="text/css" href="/config/css/styles.css" />

<div id="divContenedorPrincipal">
    <div id="divContenedorSubPrincipal">
        <div id="divTitulo">
            <div id="divTituloFuente">Portafolio de Servicios</div>
            <div id="divFecha"><?php echo $fecha ?></div>
            <div id="divFloatRight"><img src="/config/images/calendario.jpg" /></div>
        </div>             
        <div id="divQuienesSomos">
            
            <div class="divQuienesSomos2">                
                <div class="textoQuienesSomos">
                    <p>Brindamos <b style="color: #122ACC;">soluciones integrales en tecnologías de información</b> que responden eficazmente a los requerimientos específicos del cliente. Es nuestro propósito convertirnos en el aliado estratégico propicio para apoyarlo en el fortalecimiento de su plataforma tecnológica, con el fin de contribuir en la eficiencia de los procesos y al aumento en el nivel de competitividad de su empresa.
                        <br/><br/>
                        Dado que nuestro compromiso es proporcionarle servicios de excelente calidad, en Excellentiam Soluciones Empresariales encontrará el apoyo y asistencia oportunos cuando usted lo requiera; poniendo a su disposición nuestra experiencia y confiabilidad; soportado con nuestro conocimiento, metodologías acertadas, personal idóneo para brindar una excelente atención y un amplio portafolio de servicios adaptable a sus exigencias y orientado a apoyar el logro de los objetivos de su organización.
                        <br/><br/>
                        <b style="color: #122ACC;">A continuación hacemos una descripción de cada uno de nuestros servicios.</b></p>
                </div>
            </div>
			
			<div style="clear: both;margin-bottom: 15px;height: 3px;"></div>
			
			<div class="containerServicio">			
				<div id="va-accordion" class="va-container">
					<div class="va-nav">
						<span class="va-nav-prev">Ir abajo</span>
						<span class="va-nav-next">Ir Arriba</span>
					</div>
					<div class="va-wrapper">
						<div class="va-slice va-slice-6">
							<h3 class="va-title">MESA DE SERVICIOS - SERVICETONIC</h3>
							<div class="va-content">
								<p><b>Servicetonic</b> es la plataforma de automatización y gestión de servicios más eficiente y de menor costo del mercado, que brinda a las empresas la alternativa de hacer más con menos recursos. Es la Herramienta apropiada para la gestión de incidencias, peticiones, quejas, reclamos, solicitudes   (PQR's), en un entorno actual, amigable, potente, totalmente configurable, fácil de usar y adaptable a cualquier entorno que usted necesite su empresa.
									<br/><br/>
									<b>ServiceTonic</b> conjuga las ventajas de una aplicación 100% web, con la potencia de una aplicación de escritorio. Su enfoque óptimo orientada a la productividad, permite que tanto clientes, administradores y supervisores tengan una interacción total con el software.
									<br/><br/>
									Su gran adaptabilidad permite su implementación en diferentes áreas de la organización tales como Servicio al Cliente, Gestión de IT, Logística, Administración, Compras, Recursos Humanos, en fin cualquier área que usted lo requiera.</p>								
							</div>	
						</div>
						<div class="va-slice va-slice-4">
							<h3 class="va-title">FABRICACIÓN DE SOFTWARE</h3>
							<div class="va-content">
								<p>Se desarrollan y producen Sistemas de información donde se Integran los procesos de negocio, metodologías y se crean componentes que permitan que los sistemas de informaciíon interantuan com parte integral de la misión y visió del negicio, incrementando positivamente la producción y reduciendo considerablemente los costos y riesgos de las diferentes Aplicaciones de Negocio.</p>								
							</div>	
						</div>
						<div class="va-slice va-slice-1">
							<h3 class="va-title">BPO  (Business Process Outsourcing)</h3>
							<div class="va-content">
								<p>Permite que las Organizaciones puedan obtener servicios profesionales en gestion y desarrollo de Aplicaciones, Consiltoria Especializada en arquitectura e infraestructara de IT, Operaciones de Centros de Datos o de Pruebas y aseguramiento de la Calidad, Gestion documental y bodega.  </p>							
							</div>
						</div>
						<div class="va-slice va-slice-2">
							<h3 class="va-title">BUSINESS CONSULTING</h3>
							<div class="va-content">
								<p>Se identifican las diferentes formas de optimizar los modelos de negocios con el fin de apoyar y generar situaciones y procedimientos que se encargan del buen funcionamiento asociado con una organización.</p>							</div>	
						</div>
						<div class="va-slice va-slice-3">
							<h3 class="va-title">GESTION DE PROCESOS</h3>
							<div class="va-content">
								<p>Apoyamos sus procesos de negocios permitiéndole a su organización mejorar el desempeño de su negocio, gestionando, optimizando e integrando procesos y tecnología en servicios orientados al diseño de Procesos, Rediseño/diseño de procesos con base a modelos de referencia, Modelado de procesos de negocio habilitados por tecnología de información (BPM). </p>
							</div>	
						</div>						
						<div class="va-slice va-slice-5">
							<h3 class="va-title">INTEGRACIÓN DE APLICACIONES Y PLATAFORMAS</h3>
							<div class="va-content">
								<p>Debido a los diferentes aplicativos y plataformas, las empresas utilizan más de una base de datos con la información de sus clientes, de esta forma creando errores y duplicación de esta misma información. Por este motivo se presenta un sistema para unificar esta información, base de datos, plataformas y aplicaciones, logrando tener como resultado una única base de información para el cliente y de esta manera crear un sistema integrado. </p>								
							</div>	
						</div>						
						<div class="va-slice va-slice-7">
							<h3 class="va-title">OTROS SERVICIOS</h3>
							<div class="va-content">
								<p>Debido a los diferentes aplicativos y plataformas, las empresas utilizan más de una base de datos con la información de sus clientes, de esta forma creando errores y duplicación de esta misma información. Por este motivo se presenta un sistema para unificar esta información, base de datos, plataformas y aplicaciones, logrando tener como resultado una única base de información para el cliente y de esta manera crear un sistema integrado. </p>								
							</div>	
						</div>
					</div>
				</div>
			</div>
				
		<script type="text/javascript" src="/config/js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="/config/js/jquery.mousewheel.js"></script>
		<script type="text/javascript" src="/config/js/jquery.vaccordion.js"></script>
		<script type="text/javascript">
			$(function() {				
				$('#va-accordion').vaccordion({
					visibleSlices	: 4,
					expandedHeight	: 250,					
					animOpacity		: 0.5,
					contentAnimSpeed: 100
				});				
				$(".va-slice-<?php echo $seleccion ?>").click();
			});
		</script>
					
            <div style="margin-top: 65px;"></div>
        </div>
        <div class="divSemiFinal"></div>
        <div class="divSemiFinal2">&nbsp;&nbsp;&nbsp;</div>
    </div>
</div>

<?php Fin() ?>