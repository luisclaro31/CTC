<?php
@date_default_timezone_set('America/Bogota');

//Funcion para determinar fecha
function fecha($language){
    if($language != 1){
        @setlocale(LC_ALL,"En-Us"); //Defino idioma en ingles para host local
        $fecha = ucfirst(strftime("%A, %B ")).ucfirst(strftime("%d, %Y"));
        return $fecha;
    }
    else{
        @setlocale(LC_TIME, 'Spanish'); //Defino idioma para host local
        $fecha = ucfirst(strftime("%A, %d de ")).ucfirst(strftime("%B de %Y"));
        return $fecha;
    }
}

//Cache de memoria
function cache(){

 header("Cache-Control: public, must-revalidate");
 // calc an offset of 24 hours
 $offset = 3600 * 24;
 // calc the string in GMT not localtime and add the offset
 $expire = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
 //output the HTTP header
 header($expire);
 $gmt_mtime = gmdate('D, d M Y H:i:s', time() ) . ' GMT';
 header("Last-Modified: " . $gmt_mtime );
}

//Funcion para redondear numeros decimales
function redondeado($numero, $decimales) {
    $factor = pow(10, $decimales);
    return (round($numero*$factor)/$factor); 
}

//Funcion para cambiar a mayusculas
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

//Funcion para cambiar a minusculas
function minusculas($cadena)
{
    return strtr(strtolower($cadena),array(
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
        "�" => "�"
    ));
}

//Funcion para convertir las tildes
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

//Funcion para quitar tildes
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

//Funcion para fotos dependiendo del formato
function fotos($ruta,$ancho = 320,$altura = 240,$border = 0,$nombre = "",$style = "")
{
    $ruta_p = explode(".",$ruta);
    
    if($ancho != 'auto')
        $ancho_1 = $ancho.'px';
    else
        $ancho_1 = $ancho;
    
    if($altura != 'auto')
        $altura_1 = $altura.'px';
    else
        $altura_1 = $altura;
    
    if(empty($ruta_p[0]))
           $formato = $ruta_p[3];
    else
        $formato = $ruta_p[1];
    
    
    if($formato == "swf")
        $foto = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="'.$ancho.'" height="'.$altura.'">
                                    <param name="movie" value="'.$ruta.'">
                                    <param name="menu" value="false" />
                                    <param name="quality" value="high">
                                    <param name="wmode" value="transparent">
                                    <embed src="'.$ruta.'" quality=high wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'.$ancho.'" height="'.$altura.'"></embed></object>  ';
    else
        $foto ='<img src="'.$ruta.'" width="'.$ancho.'" height="'.$altura.'" border="'.$border.'"  alt="'.$nombre.'" '.$style.'/>';
        
echo $foto;
}

?>
