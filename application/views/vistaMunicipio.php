<?php 
/*
 * Vista Municipios 
 * Excellentiam S.E. 
 * Fecha creacion: 17/09/14 
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Gesti�n Municipios";
$soloLectura = "";

if(isset($error))  
    $tab = 'tabAdicionar';
else  
    $tab = 'tabConsultar';
if(isset($consultar))
    {  
    if($consultar == "1")      
        $tituloTab = 'Consulta';  
    else
        $tituloTab = 'Modificar';  
    
    $tab = 'tabModificar';
    $tabActivo = 1;  
    
    if($consultar == "1")      
        $soloLectura = "readonly";
    
    }
 else
     {  $tituloTab = 'Modificar';  
        $tabActivo = 2;
        
     }
Cabecera($tituloPagina, $usuario, $tab, $tabActivo);
if(!isset($consultar) || $tituloTab == 'Consulta')
    {
    echo form_open('controladorMunicipio/AdicionarMunicipio');  
    echo "<script src='/js/municipioAdicionar.js'></script>";
    
    }
    else
        {  
        echo form_open('controladorMunicipio/ModificarMunicipio');
        echo "<script src='/js/municipioModificar.js'></script>";
        
        }
        
/*
*  Mensajes de eliminacion de registros
*/
if(isset($estadoEliminar) && $estadoEliminar == true)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
        Se elimino satisfactoriamente el registro de municipio.        
        </div>';
else if(isset($estadoEliminar) && $estadoEliminar == false)  
   echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          
       Ocurrio un problema al eliminar el registro de Municipio.        
       </div>';
/*
 *  Mensajes de modificacion de registros
 */
if(isset($estadoModificar) && $estadoModificar == true)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          
        Se actualizo el registro de depatamento satisfactoriamente.        
        </div>';
else if(isset($estadoModificar) && $estadoModificar == false)  
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          
        Error al actualizar el registro de municipio.        
        </div>';
/**
 *  Mensajes de adicion de registros
 */

if(isset($estadoAdicionar) && $estadoAdicionar == true)  
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          
        Se adicion� el registro de municipio satisfactoriamente.        
        </div>';
else if(isset($estadoAdicionar) && $estadoAdicionar == false)  
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          
        Error al adicionar el registro de municipio.        
        </div>';
/*
 *  Validacion de modo consulta detallada
 */

if(isset($consultar) && $consultar == "1")  
    echo "<script src='/js/municipio.js'></script>";



?>


<div id='divTituloPrincipal'>  
    <?php echo $tituloPagina; ?>
</div><div id="tabs" class="divTabs">    
    <ul>        
        <li><a href="#tabConsultar" class="limpiarFormulario">Consultar</a></li>        
        <li><a href="#tabAdicionar">Adicionar</a></li>        
        <li><a href="#tabModificar"><?php echo $tituloTab ?></a></li>    
    </ul>    
    <div id="tabConsultar" align="center" style="padding-top: 25px;">        
        <table cellpadding="5" align="center" cellspacing="3" class="td">            
            <tr class="trTitulo">                
                <td class='td' <?php if($usuario['perfil'] == "Lector") echo "id='tdLector'"; else echo "id='tdAdministrador'" ?>></td>                                
                <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Codigo Municipio"; else echo '<a style="color: #fff;" href="/index.php/controladorMunicipio/index/1">Codigo Municipio &dArr;</a>' ?></td>                
                <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Nombre Municipio"; else echo '<a style="color: #fff;" href="/index.php/controladorMunicipio/index/2">Nombre Municipio &dArr;</a>' ?></td>                
            </tr>                
                <?php                
                /*                 
                 * * $registros: Array en donde se obtienen los resultados del                 
                 * * $registro: Donde se almacenaran el registro actual para graficar                 
                 */                
                $color = "#FDFCFC";                
                if(!isset($consultar))                
                    {                    
                    foreach($registros as $registro)                    
                        {                             
                        echo '<tr class="trDatos" style="background-color: '.$color.';">                                      
                            <td class="td" align="center">';                        
                        if($usuario['perfil'] == "Lector")                            
                            echo '<div class="floatLeft">                                      
                                <a href="/index.php/controladorMunicipio/ConsultarMunicipio/'.$registro['codigo'].'/1" title="Consultar">
                                    <img src="/images/buscar.png" width="20" height="20" alt="Consultar"/>                                      
                                    </a>                                  
                                    </div>';                        
                        else                        
                            {                            
                            echo '<div class="divImgEditar">                                      
                                <a href="/index.php/controladorMunicipio/ConsultarMunicipio/'.$registro['codigo'].'" title="Modificar">                                          
                                    <img src="/images/editar.jpg" width="20" height="20"  alt="Editar"/>                                      
                                    </a>                                  
                                    </div>                                  
                                    <div class="divImgEliminar">                                      
                                    <a href="javascript:;" onclick="Confirmar(\'/index.php/controladorMunicipio/EliminarMunicipio/'.$registro['codigo'].'\'); return false;"  title="Eliminar">                                          
                                        <img src="/images/eliminar.png" width="20" height="20" alt="Eliminar"/>                                      
                                        </a>                                  
                                        <div>';                        
                            
                              }
                              echo "</td>";                        
                              echo "<td class='td'>".utf8_decode($registro['codigo'])."</td>";                                                
                              echo "<td class='td'>".utf8_decode($registro['descripcion'])."</td>                                                        
                                  </tr>";                        
                              $color = $color == "#FDFCFC" ? "#F0EEEE" : "#FDFCFC";                    
                              
                              }                 
                             
                        }
                        else                  
                            $registro = $registros[0];                
                        ?>        
        </table>                
        <div id='divPaginado'>
            <?php echo $paginacion ?>
        </div>                
        <div id="divExportarFormatos">          
            <div id="divExportarExcel">              
                <a href="/index.php/controladorMunicipio/GenerarExcel" target="_blank" title="Exportar a formato Excel">                  
                    <img src="/images/excel.jpg" width="30" height="30" />                  
                    <br />                  
                    Exportar a Excel              
                </a>          
            </div>          
            <div id="divExportarPdf">              
                <a href="/index.php/controladorMunicipio/GenerarPdf" target="_blank" title="Exportar a formato PDF">                  
                    <img src="/images/pdf.jpg" width="30" height="30" />                  
                    <br />                  
                    Exportar a Pdf              
                </a>          
            </div>          
            <div class="clearBoth"></div>      
        </div>    
    </div>    
    <div id="tabAdicionar">        
        <div id="divConvenio" class="clearfix">            
            <ul id="sidemenu">                
                <li>                    
                    <a href="#informacion-content" class="open"><i class="icon-home icon-large"></i>Informaci�n Municipio</a>                
                </li>            
            </ul>            
            <div id="content">                
                <!--Tab Datos Basicos-->                
                <div id="informacion-content" class="contentblock">                    
                    <div align="center">                        
                        <fieldset align="center">                          
                            <legend align="left" class="legend">Datos B�sicos</legend>                            
                            <table align="left">                                         
                                <tr>                                                                  
                                    <td align="left" class="tdMiddle">                                                                          
                                        <label>Codigo Municipio</label>                                                                  
                                    </td>                                                                  
                                    <td align="left" class="tdFormulario">                                                                          
                                        <div>                                            
                                            <div class="divControl">                                                
                                                <input type="text" id="txtCodigoMunicipioAdic" name="txtCodigoMunicipioAdic" />                                                
                                                <input type="hidden" id="txtExisteCodigo" name="txtExisteCodigo" />                                            
                                            </div>                                                                                        
                                            <div class="campoObligatorio">*</div>                                            
                                            <div class="clearBoth"></div>                                            
                                            <div id="divCodigoVal" class="fuenteRoja"></div>                                        
                                        </div>                                     
                                    </td>                                                          
                                </tr>                                                                       
                                <tr>                                    
                                    <td align="left" class="tdFormulario">                                        
                                        <label>Nombre Municipio</label>                                    
                                    </td>                                    
                                    <td align="left" class="tdFormulario">                                        
                                        <div class="divControl">                                            
                                            <input type="text" name="txtNombreMunicipioAdic" id="txtNombreMunicipioAdic" />                                        
                                        </div>                                        
                                        <div class="campoObligatorio">*</div>                                                                            
                                    </td>                                
                                </tr>                                
                                <tr>                                                                  
                                    <td align="left" class="tdMiddle">                                                                          
                                        <label>Nombre del Departamento </label>                                                                  
                                    </td>                                                                  
                                    <td align="left" class="tdFormulario">                                                                                                                  
                                        <div class="divControl">                                            
                                            <select name="sltNombreDepartamentoAdic" id="sltNombreDepartamentoAdic" />                                                
                                            <option value=""> Seleccionar </option>                                                                                        
                                                <?php                                                                                                                                            
                                                LlenarSelectOption($nombreDepartamento)                                                                                         
                                                ?>                                                                               
                                            </select>                                        
                                        </div>                                                                                    
                                        <div class="campoObligatorio">*</div>                                                                            
                                    </td>                                                          
                                </tr>                            
                            </table>                        
                        </fieldset>                    
                    </div>                
                </div>            
            </div>        
        </div>        
        <div id="divError"></div>      
        <div class="clearBoth"></div>      
        <div class="divGuardar">          
            <button type="submit" class="submit">              
                <img src="/images/guardar.jpg" width="36" height="36" />              
                <br/>              
                Guardar          
            </button>      
        </div>    
    </div>    
    <div id="tabModificar">        
        <div id="divConvenioModificar" class="clearfix">            
            <ul id="sidemenuMod">                
                <li>                    
                    <a href="#informacion-contentMod" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Municipio</a>                
                </li>            
            </ul>            
            <div id="contentMod">                
                <!--Tab Datos Basicos-->                
                <div id="informacion-contentMod" class="contentblock">                    
                    <div align="center">                        
                        <fieldset align="center">                          
                            <legend align="left" class="legend">Datos B�sicos</legend>                            
                            <table align="left">                                                             
                                <tr>                                                              
                                    <td align="left" class="tdFormulario">                                                           
                                        <label>Codigo Municipio</label>                                                  
                                    </td>                                                      
                                    <td align="left" class="tdFormulario">                                                                    
                                        <div class="divControl" style="display: none;">                                            
                                            <input type="text" name="txtCodigoMunicipio" id="txtCodigoMunicipio" <?php echo $soloLectura; ?> value="<?php echo $registro["codigo"] ?>"/>                                            
                                            <div class="campoObligatorio">*</div>                                        
                                        </div>                                                                                
                                        <label><?php echo $registro["codigo"] ?></label>                                    
                                    </td>                                
                                </tr>                                                                 
                                <tr>                                    
                                    <td align="left" class="tdFormulario">                                        
                                        <label>Nombre Municipio</label>                                    
                                    </td>                                    
                                    <td align="left" class="tdFormulario">                                        
                                        <div class="divControl">                                            
                                            <input type="text" <?php echo $soloLectura; ?> name="txtNombreMunicipio" id="txtNombreMunicipio" value="<?php echo $registro['Nombre'] ?>"/>                                        
                                        </div>                                        
                                        <div class="campoObligatorio">*</div>                                                                            
                                    </td>                                
                                </tr>                                
                                <tr>                                    
                                    <td align="left" class="tdFormulario">                                        
                                        <label>Nombre del Departamento</label>                                    
                                    </td>                                    
                                    <td align="left" class="tdFormulario">                                        
                                        <div class="divControl">                                            
                                            <select name="sltNombreDepartamento" id="sltNombreDepartamento">                                                
                                                <option value=""> Seleccionar </option>                                                  
                                                    <?php                                                  
                                                    LlenarSelectOption($nombreDepartamento, $registro['departamento_codigo'])                                                  
                                                            ?>                                            
                                            </select>                                        
                                        </div>                                        
                                        <div class="campoObligatorio">*</div>                                                                              
                                    </td>                                
                                </tr>                                                            
                            </table>                                                      
                            <div class='clearBoth'></div>                                                    
                        </fieldset>                    
                    </div>                
                </div>            
            </div>        
        </div>        
        <div id="divErrorMod"></div>      
        <div class="clearBoth"></div>      
        <div class="divGuardar">          
            <?php          
            if($tituloTab == 'Consulta')          
                {          
                ?>              
            <a href="/index.php/controladorMunicipio">                  
                <img src="/images/volver.png" width="36" height="36" />                  
                <br/>                  
                Regresar              
            </a>           
                <?php          
                
                }          
                else          
                    { 
                    ?>              
            <div id="divGuardarMod">                  
                <button type="submit" class="submit">                      
                    <img src="/images/guardar.jpg" width="36" height="36" />                      
                    <br/>                      
                    Guardar                  
                </button>              
            </div>              
            <div id="divRegresarMod">              
                <a href="/index.php/controladorMunicipio">                  
                    <img src="/images/volver.png" width="36" height="36" />                  
                    <br/>                  
                    Regresar              
                </a>              
            </div>              
            <div class="clearBoth"></div>          
                <?php 
                
                } 
                ?>      
        </div>    
    </div>
</div>
<?php FinalDocumento(); ?>