<?php 
include("config/codes/functions.php");

$titulo = "Inicio";
$item = 0;
$redes = '<div style="float: left;margin-bottom: 13px;">
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, "script", "facebook-jssdk"));</script>         
                        <div class="fb-like" data-href="https://www.facebook.com/excellentiam.solucionesempresariales/" data-width="200px" data-layout="button_count" data-action="recommend" data-show-faces="true" data-share="true"></div>
                    </div>
                    <div style="float: left;">                        
                            <a href="https://twitter.com/share" class="twitter-share-button" data-via="excellentiam" data-lang="es">Twittear</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            <!-- Place this tag where you want the share button to render. -->
                            <div class="g-plus" data-action="share" data-annotation="bubble" data-height="15"></div>                                
                    </div>
                    <div style="clear: both;"></div>
                    <div style="height: 10px;"></div>';

Cabecera($titulo, $item)
?>

<div id="divContenedorPrincipal">
    <div id="divContenedorSubPrincipal">
        <div id="divTitulo">
            <div id="divTituloFuente">Bienvenidos</div>
            <div id="divFecha"><?php echo $fecha ?></div>
            <div id="divFloatRight"><img src="/config/images/calendario.jpg" /></div>
        </div>
        <div id="divDescripcion">
            <div id="divTexto">
                Nuestra Empresa es una consultora multinacional que provee servicios especializados en consultoría de
                gesti&oacute;n de servicios, dise&ntilde;o, desarrollo, consultor&iacute;a e implementaci&oacute;n de sistemas
                de informaci&oacute;n, procesos y outsourcing que permiten entregar soluciones eficientes a su organizaci&oacute;n.
                <br/><br/>
                <p>Cubrimos los Sectores de Telecomunicaciones, Entidades Financieras, Industria, Utilities &amp; Energ&iacute;a,
                 Seguros, Administraciones P&uacute;blicas, Medios de Comunicaci&oacute;n y Sanidad.</p>
            </div>
            <div id="divAncho"></div>
        </div>
        <div class="both"></div>
        <div id="divServicios">
            <div class="divServiciosMarco" style="margin-left: 60px;">
                <div class="divTituloPortafolio">BPO  (Business Process Outsourcing)</div>
                <img src="/config/images/bpo.jpg" class="imgPortafolio" />
                <div class="textoDivPortafolio">
                    Permite que las Organizaciones puedan obtener servicios profesionales en gestion y desarrollo de Aplicaciones...
                    <div class="leerMas">
                        <a href="servicios.php?item=1" class="textNaranja">Ver mas...</a>
                    </div>
                    <?php echo $redes ?>
                </div>
            </div>

            <div class="divServiciosMarco">
                <div class="divTituloPortafolio">BUSINESS CONSULTING</div>
                <img src="/config/images/business.jpg" class="imgPortafolio" />
                <div class="textoDivPortafolio">
                    Se identifican las diferentes formas de optimizar los modelos de negocios con el fin de apoyar y generar situaciones...
                    <div style="text-align: right;color: #FF7C03;">
                        <a href="servicios.php?item=2" class="textNaranja">Ver mas...</a>
                    </div>
                    <?php echo $redes ?>
                </div>
            </div>

            <div class="divServiciosMarco">
                <div class="divTituloPortafolio">FABRICACI&Oacute;N DE SOFTWARE</div>
                <img src="/config/images/fabricacion.jpg" class="imgPortafolio" />
                <div class="textoDivPortafolio">
                        Se desarrollan y producen Sistemas de informaci&oacute;n donde se Integran los procesos de negocio, metodolog&iacute;as...
                <div style="text-align: right;color: #FF7C03;">
                        <a href="servicios.php?item=4" style="color: #FF7C03;">Ver mas...</a>
                </div>
                <?php echo $redes ?>
                </div>
            </div>

            <div class="both"></div>
        </div>
        <div class="divSemiFinal"></div>
        <div class="divSemiFinal2">&nbsp;&nbsp;&nbsp;</div>
    </div>
</div>

<?php Fin() ?>