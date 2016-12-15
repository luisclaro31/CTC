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

//Funcion para cambiar a minusculas
function minusculas($cadena)
{
    return strtr(strtolower($cadena),array(
        "À" => "à", 
        "Á" => "á", 
        "Â" => "â", 
        "Ã" => "ã", 
        "Ä" => "ä", 
        "Å" => "å", 
        "Æ" => "æ",
        "Ç" => "ç",
        "È" => "è",
        "É" => "é",
        "Ê" => "ê",
        "Ë" => "ë",
        "Ì" => "ì",
        "Í" => "í",
        "Î" => "î",
        "Ï" => "ï",
        "Ð" => "ð",
        "Ñ" => "ñ",
        "Ò" => "ò",
        "Ó" => "ó",
        "Ô" => "ô",
        "Õ" => "õ",
        "Ö" => "ö",
        "Ø" => "ø",
        "Ù" => "ù",
        "Ü" => "ü",
        "Ú" => "ú"
    ));
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
