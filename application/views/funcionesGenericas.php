<?php
/*
 *
 */
function Cabecera($titulo, $datosUsuario, $tab = "tabModificar", $tabActivo = 2)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='es' lang='es'>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title><?php echo $titulo ?> | SIS</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <link rel="shortcut icon" href="/images/logo.ico"/>
    <link rel="stylesheet" href="/css/estilos.css" />
    <link rel="stylesheet" href="/css/jquery-ui.css" />

    <link rel="stylesheet" href="/css/estilosGrid.css" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="/js/jquery.js"></script>
    <script src="/js/funciones.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/jquery.numeric.js"></script>
    <script src="/js/jquery.validate.js"></script>
    <script src="/js/jquery.form.js"></script>

    <script src="/js/javaScriptsGrid.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $( document ).tooltip();
            $("#tabs").tabs();
            var idx = $('#tabs a[href="#<?php echo $tab ?>"]').parent().index();
            $("#tabs").tabs( "option", "active", idx );

             $('#tabs').tabs('disable', <?php echo $tabActivo ?>);
             <?php
                if($tabActivo == 1)
                    echo "$('#tabs').tabs('disable', 0);";
                else
                    echo "$('#tabs').tabs('enable', 0);";

                if($datosUsuario['perfil'] == "Lector")
                    echo "$('#tabs').tabs('disable', 1);";
             ?>

                $("#menu").menu({position: {at: "left bottom"}});
         });
    </script>
    <?php
        if($datosUsuario['perfil'] == "Administracion")
        {
    ?>
            <style>
                .ui-menu > li {
                    float: left;
                    display: block;
                    width: 121px;
                    text-align: center;
                    font-family: "Arial";
                    font-size: 9px;
                    color: #111;
                    text-shadow: #87CEEB 1px 3px;
                }
                .ui-menu ul li ul {
                    left:124px !important;
                    margin-top: -20px !important;
                    width:100%;
                }
            </style>
    <?php
        }
    ?>
</head>

<body onload="nobackbutton();">
<div id="divCabecera">
    <div id="dialog-confirm" title="Eliminar" style="display: none;height: 60px;">
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
            �Esta seguro que desea eliminar el registro?
    </div>
    <div id="divLogo">
        <img  src="/images/logo.png"  height="100" />
    </div>
    <div id="titEncabezado">
         SISTEMA DE INFORMACION SINDICAL - SIS
    </div>
    <div class="clearBothMenu"></div>

    <div id="divMenu">
        <ul id="menu">
            <?php
                if($datosUsuario['perfil'] == "Administracion")
                {
            ?>
                    <li><a href="#">Administracion</a>
                    <ul>
                        <li><a href="/index.php/controladorUsuario">Usuarios</a>
                        <ul>
<!--                        <li><a href="/index.php/controladorMenu">Gesti�n Men�</a></li>
                        <li><a href="#">Men� por Usuario</a></li>-->
                        <li><a href="/index.php/controladorUsuarioSindicato">Usuario por Organizaci�n Sindical</a></li>
                        </ul>
                        </li>
                        <li><a href="#">Par�metros</a>
                        <ul>
                        <li><a href="/index.php/controladorDepartamento">Departamentos</a></li>
                        <li><a href="/index.php/controladorMunicipio">Municipios</a></li>
                        <li><a href="/index.php/controladorGenerico">Variables Tipo Categor�a</a></li>
                        <li><a href="/index.php/controladorEstado">Variables Tipo Estado</a></li>
                        <li><a href="/index.php/controladorCargo">Variables Tipo Cargo</a></li>
                        </ul>
                        </li>
                        <li><a href="/index.php/controladorAuditoria">Auditoria</a></li>
                        <li><a href="/index.php/controladorCargue">Cargue de Informaci�n</a></li>
                    </ul>
                    </li>
                    <li><a href="/index.php/controladorFederacion">Federaciones</a>
                        <ul>
                            <li><a href="/index.php/controladorFederacionSindicato">Sindicatos Afiliados</a></li>
                            <li><a href="/index.php/controladorDirectivoFederacion">Directivos y Sub Directivos</a></li>
                        </ul>
                    </li>
                    <li><a href="/index.php/controladorSeccional">Seccionales</a>
                        <ul>
                            <li><a href="/index.php/controladorSeccionalFederacion">Federaciones Afiliadas</a></li>
                            <li><a href="/index.php/controladorDirectivoSeccional">Directivos y Sub Directivos</a></li>
                        </ul>
                    </li>
                    <li><a href="/index.php/controladorSindicato">Sindicatos</a>
                            <ul>
                                <li><a href="/index.php/controladorDirectivo">Directivos y Sub Directivos</a></li>
                            </ul>
                    </li>
                    <li><a href="/index.php/controladorEmpresa">Empresas</a></li>
                    <li><a href="/index.php/controladorConvenioColectivo">Convenios Colectivos</a>
                    <ul>
                        <li><a href="/index.php/controladorSindicatoConvenio">Sindicatos X Convenio</a></li>
                    </ul>
                    </li>
                    <li><a href="/index.php/controladorAfiliado">Afiliados</a></li>
            <?php
                }
            ?>
            <?php
                if($datosUsuario['perfil'] == "Editor Federacion" || $datosUsuario['perfil'] == "Lector Federacion")
                {
            ?>
                    <li><a href="/index.php/controladorFederacion">Federaciones</a>
                        <ul>
                            <li><a href="/index.php/controladorDirectivoFederacion">Directivos y Sub Directivos</a></li>
                        </ul>
                    </li>
                    <li><a href="/index.php/controladorFederacionSindicato">Sindicatos Afiliados</a>
                            <ul>
                                <li><a href="/index.php/controladorDirectivo">Directivos y Sub Directivos</a></li>
                            </ul>
                    </li>
            <?php
                }
            ?>
            <?php
                if($datosUsuario['perfil'] == "Editor Sindicato" || $datosUsuario['perfil'] == "Lector Sindicato")
                {
            ?>
            <li><a href="/index.php/controladorSindicato">Sindicatos</a>
	            <ul>
	                <li><a href="/index.php/controladorDirectivo">Directivos y Sub Directivos</a></li>
	            </ul>
            </li>
            <li><a href="/index.php/controladorEmpresa">Empresas</a></li>
            <li><a href="/index.php/controladorConvenioColectivo">Convenios Colectivos</a>
            <ul>
                <li><a href="/index.php/controladorSindicatoConvenio">Sindicatos X Convenio</a></li>
            </ul>
            </li>
            <li><a href="/index.php/controladorAfiliado">Afiliados</a></li>

            <?php
                }
            ?>

            <?php
                if($datosUsuario['perfil'] == "Editor Seccional" || $datosUsuario['perfil'] == "Lector Seccional")
                {
            ?>
                    <li><a href="/index.php/controladorSeccional">Seccionales</a>
                        <ul>
                            <li><a href="/index.php/controladorDirectivoSeccional">Directivos y Sub Directivos</a></li>
                        </ul>
                    </li>
                    <li><a href="/index.php/controladorSeccionalFederacion">Federaciones Afiliadas</a>
                        <ul>
                            <li><a href="/index.php/controladorDirectivoFederacion">Directivos y Sub Directivos</a></li>
                        </ul>
                    </li>
            <?php
                }
            ?>
            <li><a href="/index.php/controladorReporte">Reportes</a></li>
            <?php
                if($datosUsuario['perfil'] != "Administracion")
                {
            ?>
                    <li><a href="/index.php/controladorUsuario/ConsultarUsuario/<?php echo $datosUsuario['idUsuario'] ?>">Gesti�n Cuenta</a></li>
            <?php
                }
            ?>
            <li><a href="/index.php/login/Logout">Cerrar Sesi�n</a></li>
        </ul>
    </div>
    <div class="clearBoth"></div>
</div>

<div id="divPrincipal">
    <div id="divBienvenido">
        Bienvenido: <b class="weight"><?php echo $datosUsuario['usuario'].' ('.$datosUsuario['perfil'].')' ?></b>
    </div>
<?php
}

/*
 *
 */
function CabeceraLogin($titulo)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='es' lang='es'>
<head>
    <title><?php echo $titulo ?> | SIS</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <link rel="shortcut icon" href="/images/logo.ico"/>
    <link rel="stylesheet" href="/css/estilos.css" />
    <link rel="stylesheet" href="/css/jquery-ui.css" />
    <script src="/js/jquery.js"></script>
    <script src="/js/funciones.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/jquery.numeric.js"></script>
    <script src="/js/jquery.validate.js"></script>
    <script src="/js/jquery.form.js"></script>
    <script src='/js/login.js'></script>
</head>

<body onload="nobackbutton();">
<div id="divCabecera">
    <div id="divLogo">
        <img  src="/images/logo.png"  height="100" />
    </div>
    <div id="titEncabezado">
         SISTEMA DE INFORMACION SINDICAL - SIS
    </div>
    <div class="clearBoth"></div>
</div>

<div id="divPrincipal">
<?php
}

/*
 * Funci�n con el contenido final del documento
 */
function FinalDocumento()
{
?>
</div>
</form>

<div id="divLineaFinal">
    <div class="floatRight" style="color: #031A2F;">
       Version 1.1.2 &copy; Copyright 2014, Excellentiam Soluciones Empresariales. Todos los derechos reservados.
    </div>
    <div class="floatLeft">
<!--        <img src="/images/logoExcellentiam.jpg" />-->
    </div>
</div>
</body>
</html>
<?php
}

/*
 * Funcion para convertir las tildes
 */
function convertir_tildes($cadena)
{
    $cadena = str_replace("�","&aacute;",$cadena);
    $cadena = str_replace("�","&eacute;",$cadena);
    $cadena = str_replace("�","&iacute;",$cadena);
    $cadena = str_replace("�","&oacute;",$cadena);
    $cadena = str_replace("�","&uacute;",$cadena);
    $cadena = str_replace("�","&ntilde;",$cadena);
    $cadena = str_replace("�","&Aacute;",$cadena);
    $cadena = str_replace("�","&Eacute;",$cadena);
    $cadena = str_replace("�","&Iacute;",$cadena);
    $cadena = str_replace("�","&Oacute;",$cadena);
    $cadena = str_replace("�","&Uacute;",$cadena);
    $cadena = str_replace("�","&Ntilde;",$cadena);
    return $cadena;
}

/*
 * Funcion para quitar tildes
 */
function quitar_tildes($cadena)
{
    $cadena = str_replace("&aacute;","a",$cadena);
    $cadena = str_replace("&eacute;","e",$cadena);
    $cadena = str_replace("&iacute","i",$cadena);
    $cadena = str_replace("&oacute;","o",$cadena);
    $cadena = str_replace("&uacute;","u",$cadena);
    $cadena = str_replace("&ntilde;","�",$cadena);
    $cadena = str_replace("&Aacute;","A",$cadena);
    $cadena = str_replace("&Eacute;","E",$cadena);
    $cadena = str_replace("&Iacute;","I",$cadena);
    $cadena = str_replace("&Oacute;","O",$cadena);
    $cadena = str_replace("&Uacute;","U",$cadena);
    $cadena = str_replace("&Ntilde;","�",$cadena);
    $cadena = str_replace("�","a",$cadena);
    $cadena = str_replace("�","e",$cadena);
    $cadena = str_replace("�","i",$cadena);
    $cadena = str_replace("�","o",$cadena);
    $cadena = str_replace("�","u",$cadena);
    $cadena = str_replace("�","�",$cadena);
    $cadena = str_replace("�","A",$cadena);
    $cadena = str_replace("�","E",$cadena);
    $cadena = str_replace("�","I",$cadena);
    $cadena = str_replace("�","O",$cadena);
    $cadena = str_replace("�","U",$cadena);
    $cadena = str_replace("�","�",$cadena);
    return $cadena;

}

/*
 * Funcion para cambiar a mayusculas
 */
function mayusculas($cadena)
{
    return strtr(strtoupper($cadena), array(
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
        "�" => "�",
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