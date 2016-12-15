<?php
@ob_start("ob_gzhandler");
@date_default_timezone_set('America/Bogota');   //Defino zona horaria para php5 Host
@setlocale(LC_ALL,'es_MX');

$local = $_SERVER["DOCUMENT_ROOT"];

/***********funciones de Base de datos**************/
require($local."/config/codes/bd.php");

/***********Archivo de funciones bas**************/
require($local."/config/codes/functions.php");

/***********Archivo de funciones avan**************/
require($local."/config/codes/functions_other.php");
        
//Objeto para base de datos y variables
$bd = new bd();
$fecha = @date("d/m/Y");
$fecha_h_m_s = @date("d/m/Y h:i:s a");
$fecha_h_m_s_2 = @date("Y-m-d h:i:s");
$hora = @date("H:i:s");

?>

                                


                                
                          