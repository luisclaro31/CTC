<?php

$nombres = $_POST['nombres'];
$ciu = $_POST['ciu'];
$email_per = $_POST['email'];
$comentarios = $_POST['comentarios'];
$para = "hector.forero@excellentiam.co, daniel.forero@allianz.co";

$comp = array("url","link","http","[^A-Za-z0-9.?!]");

foreach($comp as $rep)
    $comentarios = ereg_replace("$rep", " ", $comentarios);

    $titulo = "Comentarios Excellentiam Soluciones Empresariales página web";
    // message
    $mensaje = '
    <html>
    <head>
      <title>Comentarios Excellentiam Soluciones Empresariales</title>
    </head>
    <body style="background-color: #fff;margin:0;padding:0;">
    
      <table align="center" border="1" cellpadding="3" cellspacing="0" style="background-color: #EBEBEB;border: 2px solid #000000;">
            <tr>
                <td colspan="2" style="border:0;"><img src="http://excellentiam.guiamultimedia.com.co/config/images/logo.jpg" border="0"/></td>
                <td colspan="2" style="font-weight: bold;border:0;"> COMENTARIOS EXCELLENTIAM SOLUCIONES EMPRESARIALES</td>
            </tr>
    
            <tr style="font-weight: bold;">
                <th>Usuario que realiza comentario</th><th>Ciudad</th><th>E-mail</th><th>Comentario</th>
            </tr>
    
            <tr style="background-color: #fff;">
                <td>'.$nombres.'</td><td>'.$ciu.'</td><td>'.$email_per.'</td><td>'.$comentarios.'</td>
            </tr>
      </table>
    </body>
    </html>
    ';
    
// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$cabeceras .= 'From: contacto@excellentiam.co' . "\r\n";

$enviar = @mail($para, $titulo, $mensaje, $cabeceras);

if(!$enviar)
    echo "Error al enviar";
else{
    
    echo $cerrar = "<script language='javascript'>
        alert('Gracias por sus comentarios.');
		self.close();
        </script>";
}
?>
             


                                
                          