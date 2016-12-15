<?php

function Cabecera($titulo, $tab, $tabActivo = 2)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='es' lang='es'>
<head>
    <title><?php echo $titulo ?> | SIS</title>

    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/>

    <link rel="stylesheet" href="/css/styles.css" />    
    <link rel="stylesheet" href="/css/jquery-ui.css" />
    <script src="/js/jquery.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/script_menu.js"></script>
  
    <script type="text/javascript">
        $(document).ready(function(){            
            $("#tabs").tabs();
            var idx = $('#tabs a[href="#<?php echo $tab ?>"]').parent().index();
            $("#tabs").tabs( "option", "active", idx );
            
            $("#dialogo").dialog({ 
			width: 320,  
			height: 200,
			show: "scale", 
			hide: "scale", 
			resizable: "false",
			position: "center",
			modal: "true" 
            });            
            
             $('#tabs').tabs('disable', <?php echo $tabActivo ?>);
             <?php 
                if($tabActivo == 1) 
                    echo "$('#tabs').tabs('disable', 0);";
                else
                    echo "$('#tabs').tabs('enable', 0);";
             ?>
         });
       $(function() { $( "#datepicker" ).datepicker(); });
       $(function() { $( "#datepicker2" ).datepicker(); });
       $(function() { $( "#datepicker3" ).datepicker(); });
       $(function() { $( "#datepicker4" ).datepicker(); });
       $(function(){
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
       });
       $(function(){
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
    </script>
</head>

<body>    
<div id="divCabecera">
    <div id="divLogo">
        <img  src="/images/logo.png"  height="100" />
    </div>
    <div id="titEncabezado">
        Sistema de Informaci&oacute;n Sindical
    </div>
    <div class="clearBoth"></div>
    <div id='divMenu'>
        <ul>        
            <li class='active'>
                <a href='#'>
                    <span>Administracion</span>
                </a>
            </li>
            <li class='has-sub'>
                <a href='#'>
                    <span>Sindicatos</span>
                </a>
                <ul>
                    <li>
                        <a href='inicio'>
                            <span>Consultar </span>
                        </a>
                    </li>
                    <li>
                        <a class='last' href='#'>
                            <span>Adicionar</span>
                        </a>
                    </li>                
                </ul>
            </li>
            <li class='has-sub'>
                <a href='#'>
                    <span>Federaciones</span>
                </a>
                <ul>
                    <li>
                        <a href='federacion'>
                            <span>Consultar</span>
                        </a>
                    </li>
                    <li class='last'>
                        <a href='#'>
                            <span>Adicionar</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class='has-sub'>
                <a href='#'>
                    <span>Empresas</span>
                </a>
                <ul>
                    <li>
                        <a href='empresa'>
                            <span>Consultar</span>
                        </a>
                    </li>
                    <li class='last'>
                        <a href='#'>
                            <span>Adicionar</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class='has-sub'>
                <a href='#'>
                    <span>Convenios Colectivos</span>
                </a>
                <ul>
                    <li>
                        <a href='convenioscolectivos'>
                            <span>Consultar</span>
                        </a>
                    </li>
                    <li class='last'>
                        <a href='#'>
                            <span>Adicionar</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class='has-sub'>
                <a href='#'>
                    <span>Afiliados</span>
                </a>
                <ul>
                    <li>
                        <a href='afiliados'>
                            <span>Consultar</span>
                        </a>
                    </li>
                    <li class='last'>
                        <a href='#'>
                            <span>Adicionar</span>
                        </a>
                    </li>
                </ul>
            </li>                        
            <li class='last'>
                <a href='login'>
                    <span>Cerrar Sesión</span>
                </a>
            </li>
        </ul>
    </div>  
    <div class="clearBoth"></div>
</div>

<div id="divPrincipal">
    <div id="divBienvenido">
        Bienvenido: <b class="weight">Administrador</b>
    </div>
<?php
}

function FinalDocumento()
{
?>
</div>      

<div id="divLineaFinal">
    Sitio web creado y dise&ntilde;ado por Excellentiam 
</div>
</body>
</html>
<?php
}

//Funcion para convertir las tildes
function convertir_tildes($cadena)
{
    $cadena = str_replace("á","&aacute;",$cadena);
    $cadena = str_replace("é","&eacute;",$cadena);
    $cadena = str_replace("í","&iacute;",$cadena);
    $cadena = str_replace("ó","&oacute;",$cadena);
    $cadena = str_replace("ú","&uacute;",$cadena);
    $cadena = str_replace("ñ","&ntilde;",$cadena);
    $cadena = str_replace("Á","&Aacute;",$cadena);
    $cadena = str_replace("É","&Eacute;",$cadena);
    $cadena = str_replace("Í","&Iacute;",$cadena);
    $cadena = str_replace("Ó","&Oacute;",$cadena);
    $cadena = str_replace("Ú","&Uacute;",$cadena);
    $cadena = str_replace("Ñ","&Ntilde;",$cadena);
    return $cadena;
}


//Funcion para quitar tildes
function quitar_tildes($cadena)
{
    $cadena = str_replace("&aacute;","a",$cadena);
    $cadena = str_replace("&eacute;","e",$cadena);
    $cadena = str_replace("&iacute","i",$cadena);
    $cadena = str_replace("&oacute;","o",$cadena);
    $cadena = str_replace("&uacute;","u",$cadena);
    $cadena = str_replace("&ntilde;","ñ",$cadena);
    $cadena = str_replace("&Aacute;","A",$cadena);
    $cadena = str_replace("&Eacute;","E",$cadena);
    $cadena = str_replace("&Iacute;","I",$cadena);
    $cadena = str_replace("&Oacute;","O",$cadena);
    $cadena = str_replace("&Uacute;","U",$cadena);
    $cadena = str_replace("&Ntilde;","Ñ",$cadena);
    $cadena = str_replace("á","a",$cadena);
    $cadena = str_replace("é","e",$cadena);
    $cadena = str_replace("í","i",$cadena);
    $cadena = str_replace("ó","o",$cadena);
    $cadena = str_replace("ú","u",$cadena);
    $cadena = str_replace("ñ","ñ",$cadena);
    $cadena = str_replace("Á","A",$cadena);
    $cadena = str_replace("É","E",$cadena);
    $cadena = str_replace("Í","I",$cadena);
    $cadena = str_replace("Ó","O",$cadena);
    $cadena = str_replace("Ú","U",$cadena);
    $cadena = str_replace("Ñ","Ñ",$cadena);
    return $cadena;

}

//Funcion para cambiar a mayusculas
function mayusculas($cadena)
{
    return strtr(strtoupper($cadena), array(
        "à" => "À", 
        "á" => "Á", 
        "â" => "Â", 
        "ã" => "Ã", 
        "ä" => "Ä", 
        "å" => "Å", 
        "æ" => "Æ",
        "ç" => "Ç",
        "è" => "È",
        "é" => "É",
        "ê" => "Ê",
        "ë" => "Ë",
        "ì" => "Ì",
        "í" => "Í",
        "î" => "Î",
        "ï" => "Ï",
        "ð" => "Ð",
        "ñ" => "Ñ",
        "ò" => "Ò",
        "ó" => "Ó",
        "ô" => "Ô",
        "õ" => "Õ",
        "ö" => "Ö",
        "ø" => "Ø",
        "ù" => "Ù",
        "ü" => "Ü",
        "ú" => "Ú",
        "&AACUTE;" => "&Aacute;",
        "&EACUTE;" => "&Eacute;",        
        "&IACUTE;" => "&Iacute;",
        "&OACUTE;" => "&Oacute;",
        "&NTILDE;" => "&Ntilde;",
        "&UACUTE;" => "&Uacute;"
    ));
}

/*
 * Funcion para llenar los campos del multiples opciones
 */
function LlenarSelectOption($items, $seleccion = "")
{
    $seleccionar = "";
    
    foreach($items as $item)
    {
        $seleccionar = (mayusculas(convertir_tildes($item["codigo"])) == mayusculas(convertir_tildes($seleccion))) ? "selected = 'selected'" : "";
        echo "<option value='".mayusculas(convertir_tildes($item["codigo"]))."' ".$seleccionar.">".utf8_decode($item["descripcion"])."</option>";
    }
}
?>