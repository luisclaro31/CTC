<?php
/*
 * Declaraciones de metodos para las gestiones de base de datos.
 *
 * v 1.0
 *
 */

class bd {

public function conexion()
{
     //Datos server BD
    $server = "localhost";
    $user = "daniel_guia";
    $pws = "guia2011";
    $bd = "daniel_omar"; 

   $link = @mysql_connect($server, $user, $pws);

   if (!$link)
      echo "Error conectando a la base de datos.";

   if (!@mysql_select_db($bd,$link))
      echo "Error seleccionando la base de datos.";
   
   return $link;
}

public function cerrar_conexion($stmt,$conn){
    @mysql_free_result($stmt);
    @mysql_close($conn);
}

public function select_item($campos,$tabla,$criterios)
{
    $conn = $this->conexion();
    
        $sql = "select $campos from $tabla where $criterios";

        $stid = @mysql_query($sql, $conn) or die ("Error: ".mysql_error());

        $item = @mysql_fetch_array($stid, MYSQL_NUM);
            
        $this->cerrar_conexion($stid,$conn);    
    
    return $item[0];            
}

public function exe_query($sql){
    
        $conn = $this->conexion();
        
        $stid = @mysql_query($sql, $conn) or die ("Error: ".mysql_error());
        
        return $stid;
}

public function selected($campo,$value = ""){

            $seleccionar = ($campo == $value) ? "selected = 'selected'" : "";
            echo $seleccionar;
}

public function select_for_option($campos,$tabla,$criterio = "",$value = "")
{
    $conn = $this->conexion();

    if(!empty($criterio))
        $where = "where $criterio";

    $stid = @mysql_query("select $campos from $tabla $where", $conn) or die ("Error: ".mysql_error());

    while ($row = @mysql_fetch_array($stid, MYSQL_NUM)) {

        $seleccionar = ($row[0] == $value) ? "selected = 'selected'" : "";

        echo "<option value='".$row[0]."' ".$seleccionar.">".ucfirst(minusculas($row[1]))."</option>";
    }

    $this->cerrar_conexion($stid,$conn);
}

public function select_items($campos,$tabla,$criterios = "")
{
    $conn = $this->conexion();
    $i = 0;
    $res = array();

    if(!empty($criterios))
        $where = "where $criterios";

    $sql = "select $campos from $tabla ".$where;

    $stid = mysql_query($sql, $conn) or die ("Error: ".mysql_error());

    while ($row = mysql_fetch_array($stid, MYSQL_NUM)) {
        foreach ($row as $item) {
            $res[$i] = convertir_tildes($item);
            $i++;
        }

    }

    $this->cerrar_conexion($stid,$conn);

    return $res;
}

public function update($tabla,$campo,$criterios)
{    
    $conn = $this->conexion();
    global $fecha_h_m_s_2;
    
    $sql = "update $tabla set $campo where $criterios";
    $stid = @mysql_query($sql, $conn) or die ("Error: ".mysql_error());    
    
    $sql_log = "INSERT INTO `log`(`date`, `tabla`, `campo`, `tipo_trans`) VALUES ('".$fecha_h_m_s_2."', '".$tabla."', '".htmlspecialchars($sql,ENT_QUOTES)."', 'update')";
    $insert = @mysql_query($sql_log, $conn);
    if(!$insert)
        echo "Problemas al actualizar el log de transacción";
        
    
    $this->cerrar_conexion($stid,$conn);
    return $stid;
}

public function insert($tabla, $valores, $campos = "")
{
    $conn = $this->conexion();
    global $fecha_h_m_s_2;
    
    if(empty($campos))
        $sql = "insert into $tabla values($valores)";
    else
        $sql = "insert into $tabla($campos) values($valores)";
    
    $stid = @mysql_query($sql,$conn);
    
    $sql_log = "INSERT INTO `log`(`date`, `tabla`, `campo`, `tipo_trans`) VALUES ('".$fecha_h_m_s_2."', '".$tabla."', '".htmlspecialchars($sql,ENT_QUOTES)."', 'insert')";
    
    $insert = @mysql_query($sql_log, $conn);
    
    if(!$insert)
        echo "Problemas al actualizar el log de transacción";
    
    $this->cerrar_conexion($stid,$conn);

    return $stid;

}

public function delete($tabla,$criterio)
{   
    global $fecha_h_m_s_2;
    
    $count = $this->select_count("select count(*) from $tabla where $criterio");
    
    if($count != 0){
        $conn = $this->conexion();
        $sql = "delete from $tabla where $criterio";
        $stid = mysql_query($sql, $conn) or die ("Error: ".mysql_error());
        
        $sql_log = "INSERT INTO `log`(`date`, `tabla`, `campo`, `tipo_trans`) VALUES ('".$fecha_h_m_s_2."', '".$tabla."', '".htmlspecialchars($sql,ENT_QUOTES)."', 'delete')";
        $insert = mysql_query($sql_log, $conn) or die ("Error: ".mysql_error());
        if(!$insert)
            echo "Problemas al actualizar el log de transacción";
    
        $this->cerrar_conexion($stid,$conn);
    }

    return $stid;
}

public function select_max($campo,$tabla,$criterio = "")
{
    $link = $this->conexion();

    if(!empty($criterio))
        $where = " where $criterio";

    $stid = @mysql_query($link, "select max($campo) from $tabla".$where);

    $item = @mysql_fetch_array($stid, MYSQL_NUM);

    $this->cerrar_conexion($stid,$link);

    return $item[0];

}

public function select_count($sql)
{
    $link = $this->conexion();

    $stid = @mysql_query($sql, $link);

    $item = @mysql_fetch_array($stid, MYSQL_NUM);

    $this->cerrar_conexion($stid,$link);

    return $item[0];

}

public function comprobar_cliente($codigo, $titulo){
                    
                    $titulo = str_replace("'","´",$titulo);

                    $id = $this->select_count("SELECT count(*) FROM estadisticas WHERE id = $codigo");

                    if($id == 0){

                        $insert = $this->insert(estadisticas, "'$codigo','$titulo','0','0','0'","id,nombre,est_esp,est_eng,est_cup");
                        
                        if(!$insert)
                            echo "Problemas al insertar nuevo cliente. Compruebe que el cliente no exista.";
                        else
                            return $codigo;
                    }
                    else
                            return $codigo;
}

public function estadisticas($codigo,$tabla,$idioma = 1){

                    $link = $this->conexion();

                    if($idioma == 1)
                        $campo = "est_esp";
                    elseif($idioma == 2)
                        $campo = "est_eng";
                    else
                        $campo = "est_cup";

                    $result = @mysql_query("SELECT ".$campo." FROM ".$tabla." WHERE id = ".$codigo, $link);

                    $row = @mysql_fetch_array($result);
                    $num = $row[0] + 1;

                    @mysql_query("UPDATE ".$tabla." set ".$campo." = ".$num." where id = ".$codigo,$link);

                    $this->cerrar_conexion($result, $link);

                    return $num;
}

}
?>



                                
                          