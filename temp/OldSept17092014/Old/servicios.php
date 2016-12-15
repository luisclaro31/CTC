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
                    <p>Brindamos <b style="color: #122ACC;">soluciones integrales en tecnolog�as de informaci�n</b> que responden eficazmente a los requerimientos espec�ficos del cliente. Es nuestro prop�sito convertirnos en el aliado estrat�gico propicio para apoyarlo en el fortalecimiento de su plataforma tecnol�gica, con el fin de contribuir en la eficiencia de los procesos y al aumento en el nivel de competitividad de su empresa.
                        <br/><br/>
                        Dado que nuestro compromiso es proporcionarle servicios de excelente calidad, en Excellentiam Soluciones Empresariales encontrar� el apoyo y asistencia oportunos cuando usted lo requiera; poniendo a su disposici�n nuestra experiencia y confiabilidad; soportado con nuestro conocimiento, metodolog�as acertadas, personal id�neo para brindar una excelente atenci�n y un amplio portafolio de servicios adaptable a sus exigencias y orientado a apoyar el logro de los objetivos de su organizaci�n.
                        <br/><br/>
                        <b style="color: #122ACC;">A continuaci�n hacemos una descripci�n de cada uno de nuestros servicios.</b></p>
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
								<p><b>Servicetonic</b> es la plataforma de automatizaci�n y gesti�n de servicios m�s eficiente y de menor costo del mercado, que brinda a las empresas la alternativa de hacer m�s con menos recursos. Es la Herramienta apropiada para la gesti�n de incidencias, peticiones, quejas, reclamos, solicitudes   (PQR's), en un entorno actual, amigable, potente, totalmente configurable, f�cil de usar y adaptable a cualquier entorno que usted necesite su empresa.
									<br/><br/>
									<b>ServiceTonic</b> conjuga las ventajas de una aplicaci�n 100% web, con la potencia de una aplicaci�n de escritorio. Su enfoque �ptimo orientada a la productividad, permite que tanto clientes, administradores y supervisores tengan una interacci�n total con el software.
									<br/><br/>
									Su gran adaptabilidad permite su implementaci�n en diferentes �reas de la organizaci�n tales como Servicio al Cliente, Gesti�n de IT, Log�stica, Administraci�n, Compras, Recursos Humanos, en fin cualquier �rea que usted lo requiera.</p>								
							</div>	
						</div>
						<div class="va-slice va-slice-4">
							<h3 class="va-title">FABRICACI�N DE SOFTWARE</h3>
							<div class="va-content">
								<p>Se desarrollan y producen Sistemas de informaci�n donde se Integran los procesos de negocio, metodolog�as y se crean componentes que permitan que los sistemas de informaci�on interantuan com parte integral de la misi�n y visi� del negicio, incrementando positivamente la producci�n y reduciendo considerablemente los costos y riesgos de las diferentes Aplicaciones de Negocio.</p>								
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
								<p>Se identifican las diferentes formas de optimizar los modelos de negocios con el fin de apoyar y generar situaciones y procedimientos que se encargan del buen funcionamiento asociado con una organizaci�n.</p>							</div>	
						</div>
						<div class="va-slice va-slice-3">
							<h3 class="va-title">GESTION DE PROCESOS</h3>
							<div class="va-content">
								<p>Apoyamos sus procesos de negocios permiti�ndole a su organizaci�n mejorar el desempe�o de su negocio, gestionando, optimizando e integrando procesos y tecnolog�a en servicios orientados al dise�o de Procesos, Redise�o/dise�o de procesos con base a modelos de referencia, Modelado de procesos de negocio habilitados por tecnolog�a de informaci�n (BPM). </p>
							</div>	
						</div>						
						<div class="va-slice va-slice-5">
							<h3 class="va-title">INTEGRACI�N DE APLICACIONES Y PLATAFORMAS</h3>
							<div class="va-content">
								<p>Debido a los diferentes aplicativos y plataformas, las empresas utilizan m�s de una base de datos con la informaci�n de sus clientes, de esta forma creando errores y duplicaci�n de esta misma informaci�n. Por este motivo se presenta un sistema para unificar esta informaci�n, base de datos, plataformas y aplicaciones, logrando tener como resultado una �nica base de informaci�n para el cliente y de esta manera crear un sistema integrado. </p>								
							</div>	
						</div>						
						<div class="va-slice va-slice-7">
							<h3 class="va-title">OTROS SERVICIOS</h3>
							<div class="va-content">
								<p>Debido a los diferentes aplicativos y plataformas, las empresas utilizan m�s de una base de datos con la informaci�n de sus clientes, de esta forma creando errores y duplicaci�n de esta misma informaci�n. Por este motivo se presenta un sistema para unificar esta informaci�n, base de datos, plataformas y aplicaciones, logrando tener como resultado una �nica base de informaci�n para el cliente y de esta manera crear un sistema integrado. </p>								
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