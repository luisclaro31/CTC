<?php
include("config/codes/config.php");

Cabecera("Nosotros", 2);

$menu = $_GET['id'];

switch($menu)
{
	case "1": $menu = "bg6";
		break;
	case "2": $menu = "bg2";
		break;
	case "3": $menu = "bg5";
		break;
	case "4": $menu = "bg1";
		break;
	case "5": $menu = "bg4";
		break;
	case "6": $menu = "bg3";
		break;										
}
?>

        <!-- Banner Acordion -->
            <ul class="accordion" id="accordion">
                <li  class="bg1">
                    <div class="heading">VALORES CORPORATIVOS</div>
                    <div class="bgDescription"></div>
                    <div class="descriptionI" style="top: 47%;">
                        <h2> VALORES CORPORATIVOS</h2>                        
                        * Actitud positiva frente a la gesti�n y desarrollo de todos los proyectos <br/>
                        * Dinamismo e innovaci�n <br/>
                        * Capacidad de adaptaci�n <br/>
                        * Transparencia y honestidad <br/>
                        * Entrega impecable con �tica empresarial  <br/>
                        * Compromiso con la calidad <br/>
                        * B�squeda de la excelencia a trav�s de nuestros servicios  <br/>
                    </div>
                </li>
                <li class="bg2">
                    <div class="heading">OBJETIVOS DE CALIDAD</div>
                    <div class="bgDescription"></div>
                    <div class="descriptionI" style="top: 39%;">
                        <h2>OBJETIVOS DE CALIDAD</h2>
                        * Satisfacer las necesidades y expectativas de los clientes proporcionando un servicio t�cnico y tecnol�gico de alta calidad,
                        con personal calificado y cumpliendo con el desarrollo de los proyectos dentro de los tiempos y los costos acordados.                        
                        <br/>
                        * Aumentar la eficiencia y la eficacia de los procesos internos implementando acciones de mejora continua en cada una de las
                        �reas de la organizaci�n.
                        <br/>
                        * Asegurar la confiablidad en los desarrollos tecnol�gicos realizados por la compa��a partiendo de los requerimientos de los
                        clientes al inicio de los proyectos.
                        <br/>
                        * Desarrollar programas que fortalezcan las competencias laborales y el desarrollo integral del talento humano. 

                    </div>
                </li>
                <li class="bg3">
                    <div class="heading">VISION</div>
                    <div class="bgDescription"></div>
                    <div class="descriptionI" style="top: 55%;">
                        <h2>VISION</h2>
                        Consolidarnos en el sector de Servicios Inform�ticos en Colombia dentro de los primeros 5 a�os como l�deres en la gesti�n de
                        servicios de Tecnolog�as de Informaci�n y procesos en el sector financiero y asegurador, contando con un recurso humano altamente
                        calificado e innovador, permiti�ndonos ser reconocidos por nuestra eficiencia y calidad en la soluci�n y apoyo de las necesidades
                        de nuestros clientes.
                    </div>
                </li>
                <li class="bg4">
                    <div class="heading">MISION</div>
                    <div class="bgDescription"></div>
                    <div class="descriptionI" style="top: 50%;">
                        <h2>MISION</h2>
                        Prestar servicios de asesor�a, consultor�a y outsourcing en la gesti�n de servicios de Tecnolog�as de Informaci�n, procesos,
                        telecomunicaciones, redes, seguridad de la informaci�n, organizaci�n y m�todos, garantizando la satisfacci�n de las necesidades
                        y expectativas de nuestros clientes a trav�s de un servicio de innovaci�n y alta calidad orientado hacia el mejoramiento continuo
                        mediante un equipo de t�cnicos y profesionales altamente calificados, fundamentados en los valores �ticos y morales que brindamos
                        permanentemente, todo esto soportado bajo un programa de motivaci�n que nos permitir� alta excelencia.
                    </div>

                </li>
                <li class="bg5">
                    <div class="heading">POLITICA DE CALIDAD</div>
                    <div class="bgDescription"></div>
                    <div class="descriptionI" style="top: 48%;">
                        <h2>POLITICA DE CALIDAD</h2>
                        Brindar a las empresas del sector financiero y asegurador servicios especializados que contribuyan a la modernizaci�n y actualizaci�n
                        de sus procesos internos, a trav�s del desarrollo de software, desarrollo de aplicativos, estandarizaci�n y mejoramiento de procesos,
                        manejo de data center, apoyados en el uso eficiente de los recursos tanto humanos como tecnol�gicos y la mejora continua de los proceso
                        de la organizaci�n.
                    </div>
                </li>
                <li class="bg6">
                    <div class="heading">RESE�A HISTORICA</div>
                    <div class="bgDescription"></div>
                    <div class="descriptionI" style="top: 34%;">
                        <h2>RESE�A HISTORICA</h2>
                        Excellentiam Soluciones Empresariales SAS es una organizaci�n que nace en Julio del 2012 en Bogot�, Colombia.
                        <br/><br/>
                        Fundada como un grupo interdisciplinario de profesionales en �reas de la tecnolog�a de informaci�n y de procesos
                        enfocada inicialmente en compa��as del sector asegurador y financiero. Nuestro equipo de trabajo se ha focalizado
                        en proporcionar servicios profesionales e integrales en las �reas de Tecnolog�a y Sistemas, Organizaci�n y M�todos,
                        Back y front Office y �reas operativas entre otras. En la b�squeda de ampliar y mejorar nuestro portafolio de servicios
                        hemos adquirido convenios y membrec�as con importantes empresas a nivel nacional e internacional vincul�ndonos como partner
                        de negocios y capacit�ndonos en cada uno de sus productos para hacerlos partes de nuestras soluciones de negocio.
                    </div>
                </li>
            </ul>
        </div>
        <!-- ROTACION Acordion  -->

        <script type="text/javascript">
            $(function() {     
	            var $this = $('.<?php echo $menu; ?>');
	            $this .stop().animate({'width':'380px'},1500);
	            $('.heading',$this).stop(true,true).fadeOut();
	                        $('.bgDescription',$this).stop(true,true).slideDown(500);
	                        $('.descriptionI',$this).stop(true,true).fadeIn();
	            
                $('#accordion > li').hover(
                    function () {
                    	var $this = $('.<?php echo $menu; ?>');
                        $this.stop().animate({'width':'115px'},2000);
                        $('.heading',$this).stop(true,true).fadeIn();
                        $('.descriptionI',$this).stop(true,true).fadeOut(500);
                        $('.bgDescription',$this).stop(true,true).slideUp(700);
                    
                        var $this = $(this);
                        $this.stop().animate({'width':'380px'},1500);
                        $('.heading',$this).stop(true,true).fadeOut();
                        $('.bgDescription',$this).stop(true,true).slideDown(500);
                        $('.descriptionI',$this).stop(true,true).fadeIn();
                    },
                    function () {
                        var $this = $(this);
                        $this.stop().animate({'width':'115px'},2000);
                        $('.heading',$this).stop(true,true).fadeIn();
                        $('.descriptionI',$this).stop(true,true).fadeOut(500);
                        $('.bgDescription',$this).stop(true,true).slideUp(700);
                    }
                );
            });
        </script>
	<!-- Fin Banner Acordion -->

<?php fin(870) ?>