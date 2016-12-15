<?php 
include("config/codes/functions.php");

$titulo = "Nosotros";
$item = 1;

Cabecera($titulo, $item)
?>

<div id="divContenedorPrincipal">
    <div id="divContenedorSubPrincipal">
        <div id="divTitulo">
            <div id="divTituloFuente">Excellentiam Soluciones Empresariales</div>
            <div id="divFecha"><?php echo $fecha ?></div>
            <div id="divFloatRight"><img src="/config/images/calendario.jpg" /></div>
        </div>             
        <div id="divQuienesSomos">
            
            <div class="divQuienesSomos2">
                <div class="divQuienesSomos2-1">
                    <img src="/config/images/nosotros.jpg" width="163" height="109"/>
                </div>
                <div class="textoQuienesSomos">
                    <p>Nuestra Empresa es una consultora multinacional que provee servicios especializados en consultor&iacute;a de gesti&oacute;n de servicios, dise&ntilde;o, desarrollo, consultor&iacute;a e implementaci&oacute;n de sistemas de informaci&oacute;n, procesos y outsourcing que permiten entregar soluciones eficientes a su organizaci&oacute;n.</p>
                </div>
            </div>

            <div class="tituloQuienesSomos">
                <p>Nuestra Misi&oacute;n</p>
            </div>
                        
            <div class="lineaDashed"></div>

            <div class="divQuienesSomos2">
                <div class="divQuienesSomos2-1">
                        <img src="/config/images/mision.jpg" width="163" height="109"/>
                </div>
                <div class="textoQuienesSomos">
                    <p>Proveer servicios de consultor&iacute;a en procesos y gesti&oacute;n inform&aacute;tica no redundante y de calidad a todas las empresas en las &aacute;reas de tecnolog&iacute;as de informaci&oacute;n, telecomunicaciones, redes, seguridad de la informaci&oacute;n, organizaci&oacute;n y m&eacute;todos. Usando las mejores pr&aacute;cticas y est&aacute;ndares del mercado.</p>
                </div>
            </div>   			

            <div class="tituloQuienesSomos">
                <p>Nuestra Visi&oacute;n</p>
            </div>
            
            <div class="lineaDashed"></div>

            <div class="divQuienesSomos2">
                <div class="divQuienesSomos2-1">
                        <img src="/config/images/vision.jpg" width="163" height="109"/>
                </div>
                <div class="textoQuienesSomos">
                    <p>Ubicarnos en 5 a&ntilde;os entre las primeras diez compa&ntilde;&iacute;as en gesti&oacute;n de servicios integrados en tecnolog&iacute;a y procesos en el sector financiero y asegurador.</p>
                </div>
            </div>

            <div class="tituloQuienesSomos">
                <p>Nuestros Valores</p>
            </div>

            <div class="lineaDashed"></div>

            <div class="divQuienesSomos2">
                <div class="divQuienesSomos2-1">
                    <img src="/config/images/valores.jpg" width="163" height="129"/>
                </div>
                <div style="margin-left: 25px;float: left;"></div>
                <div class="textoQuienesSomos" style="float: left;">
                    <ul>
                        <li>Actitud positiva frente al desarrollo de proyectos</li> 
                        <li>Dinamismo e innovaci&oacute;n</li>
                        <li>Capacidad de adaptaci&oacute;n</li>
                        <li>Transparencia y honestidad</li> 
                        <li>Entrega impecable y con &eacute;tica empresarial</li>
                        <li>Compromiso con la calidad</li> 
                        <li>B&uacute;squeda de la excelencia a trav&eacute;s de nuestros servicios</li>
                    </ul>
                </div>
            </div>
            <div style="margin-top: 165px;"></div>
        </div>
        <div class="divSemiFinal"></div>
        <div class="divSemiFinal2">&nbsp;&nbsp;&nbsp;</div>
    </div>
</div>

<?php Fin() ?>