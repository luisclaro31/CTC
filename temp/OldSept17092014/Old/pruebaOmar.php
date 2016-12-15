<?php

    $server = "localhost";
    $user = "daniel_guia";
    $pws = "guia2011";
    $bd = "daniel_omar"; 

   $link = @mysql_connect($server, $user, $pws);

   if (!$link)
      echo "Error conectando a la base de datos.";

   if (!@mysql_select_db($bd,$link))
      echo "Error seleccionando la base de datos.";
      
      
?>