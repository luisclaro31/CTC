<?php 
/*
 * Vista victima
 * Excellentiam S.E.
 * Fecha creacion: 19/09/14
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Gestión Victima";
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
{    
    $tituloTab = 'Modificar';     
    $tabActivo = 2;    
}

Cabecera($tituloPagina, $usuario, $tab, $tabActivo); 

if(!isset($consultar) || $tituloTab == 'Consulta')
{
    echo form_open('controladorVictima/AdicionarVictima'); 
    echo "<script src='/js/victimaAdicionar.js'></script>";
}
else
{
    echo form_open('controladorVictima/ModificarVictima'); 
    echo "<script src='/js/victimaModificar.js'></script>";
}

/*
 * Mensajes de eliminacion de registros
 */
if(isset($estadoEliminar) && $estadoEliminar == true) 
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">			
            Se elimino satisfactoriamente el registro de victima.
          </div>';
else if(isset($estadoEliminar) && $estadoEliminar == false)               
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">                        
            Ocurrio un problema al eliminar el registro de victima.
          </div>';
/*
 * Mensajes de modificacion de registros
 */
if(isset($estadoModificar) && $estadoModificar == true)            
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">			
            Se actualizo el registro de victima satisfactoriamente.                 
          </div>';
else if(isset($estadoModificar) && $estadoModificar == false)            
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">			
            Error al actualizar el registro de victima.                 
          </div>';
/*
 * Mensajes de adicion de registros
 */
if(isset($estadoAdicionar) && $estadoAdicionar == true)            
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">			
            Se adicionó el registro de victima satisfactoriamente.                 
          </div>';
else if(isset($estadoAdicionar) && $estadoAdicionar == false)            
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">			
            Error al adicionar el registro de victima.                 
          </div>';
/*
 * Validacion de modo consulta detallada
 */
if(isset($consultar) && $consultar == "1")
    echo "<script src='/js/victima.js'></script>";

if(/*count($registros) > 0 && */$usuario['perfil'] == 'Lector Sindicato' || $usuario['perfil'] == "Editor Federacion" || $usuario['perfil'] == "Lector Federacion")
    echo "<script type='text/javascript'>
            $(function() { 
                $('#tabs').tabs('disable', 1);
            });
          </script>";
?>

<div id='divTituloPrincipal'>    
    <?php echo $tituloPagina; ?>
</div>

<div id="tabs" class="divTabs">  
    <ul>    
        <li><a href="#tabConsultar">Consultar</a></li>    
        <li><a href="#tabAdicionar">Adicionar</a></li>    
        <li><a href="#tabModificar"><?php echo $tituloTab ?></a></li>  
    </ul>  
    <div id="tabConsultar" align="center">
        <table id="table" class="display" cellspacing="0" width="100%">
                  <thead class="trTitulo">
                      <tr>
                          <th></th>
                          <th>Numero Cedula</th>
                          <th>Nombres y Apellidos Victima</th>                
                          <th>Empresa Labora</th>
                          <th>Departamento</th>
                          <th>Municipio</th>                
                          <th>Año Creación</th>                                          
                      </tr>
                  </thead>
                  <tbody>
                        <?php
                        /*
                         * * $registros: Array en donde se obtienen los resultados del
                         * * $registro: Donde se almacenaran el registro actual para graficar
                         */              
                        if($tituloTab != 'Consulta')
                        {
                            if(!isset($consultar))
                            {                    
                              foreach($registros as $registro)
                              {                   
                                  echo "<tr>";
                                  if($usuario['perfil'] == "Lector Sindicato" || $usuario['perfil'] == "Editor Federacion" || $usuario['perfil'] == "Lector Federacion")
                                      echo '<td>
                                                <a href="/index.php/controladorVictima/ConsultarVictima/'.$registro['id_victima'].'/1" title="Consultar">
                                                    <img src="/images/buscar.png" width="15" height="15" alt="Consultar"/>
                                                </a>
                                            </td>';

                                  else if($usuario['perfil'] == "Editor Sindicato")
                                  {
                                      echo '<td>
                                                <a href="/index.php/controladorVictima/ConsultarVictima/'.$registro['id_victima'].'" title="Modificar">
                                                    <img src="/images/editar.jpg" width="15" height="15"  alt="Editar"/>
                                                </a>
                                            </td>';
                                  }                            
                                  else 
                                  {
                                      echo '<td>
                                                <a href="/index.php/controladorVictima/ConsultarVictima/'.$registro['id_victima'].'" title="Modificar">
                                                    <img src="/images/editar.jpg" width="15" height="15"  alt="Editar"/>
                                                </a>                          
                                                <br>
                                                <a href="javascript:;" onclick="Confirmar(\'/index.php/controladorVictima/EliminarVictima/'.$registro['id_victima'].'\'); return false;"  title="Eliminar">
                                                    <img src="/images/eliminar.png" width="15" height="15" alt="Eliminar"/>
                                                </a>
                                            </td>';
                                  }                                                                                 
                                  echo "<td>".$registro['cedula']."</td>";
                                  echo "<td>".utf8_decode($registro['nombres_apellidos'])."</td>";
                                  echo "<td>".utf8_decode($registro['empresa'])."</th>";
                                  echo "<td>".utf8_decode($registro['departamento'])."</td>";
                                  echo "<td>".utf8_decode($registro['M'])."</td>";                        
                                  echo "<td>".utf8_decode($registro['anyo'])."</td>";                                                          
                                  echo "</tr>";                        
                              }

                            }
                              else
                                  $registro = $registros[0];
                        }
                        else
                            $registro = $registros[0];
                        ?>

                  </tbody>
              </table>                                          
        <div id="divExportarFormatos">        
            <div id="divExportarExcel">
                <a href="/index.php/controladorVictima/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                    <img src="/images/excel.jpg" width="30" height="30" />                
                    <br />                
                    Exportar a Excel           
                </a>        
            </div>        
            <div id="divExportarPdf">
                <a href="/index.php/controladorVictima/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                    <img src="/images/pdf.jpg" width="30" height="30" />                
                    <br />                
                    Exportar a Pdf            
                </a>        
            </div>        
            <div class="clearBoth"></div>    
        </div>  
    </div>          
    <div id="tabAdicionar">    
        <div id="divAfiliado" class="clearfix">        
            <ul id="sidemenu">          
                <li>            
                    <a href="#informacion-content" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Personal</a>          
                </li>          
                <li>            
                    <a href="#about-content"><i class="icon-info-sign icon-large"></i>Informaci&oacute;n Laboral</a>          
                </li>          
            </ul>                
            <div id="content">            
                <!--Tab Datos Basicos-->
                <div id="informacion-content" class="contentblock">                
                    <div align="center">                    
                        <fieldset align="center">                      
                            <legend align="left" class="legend">Datos Básicos</legend>                        
                            <table align="left">                 
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Número Cedula</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <div>
                                            <div class="divControl">
                                                <input type="text" id="txtCedulaVictimaAdic" name="txtCedulaVictimaAdic" />                                           
                                            </div>                                            
                                            <div class="clearBoth"></div>
                                            <div id="divCedulaVal" class="fuenteRoja"></div>
                                        </div> 
                                    </td>                          
                                </tr> 
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Nombres y Apellidos</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <div>
                                            <div class="divControl">
                                                <input type="text" name="txtNombreVictimaAdic" id="txtNombreVictimaAdic" />
                                            </div>                                            
                                            <div class="campoObligatorio">*</div>
                                        </div>
                                    </td>
                                </tr>                                                          
                                <tr>                            
                                    <td align="left" class="tdFormulario">       
                                        <label>Genero</label>       
                                    </td>                 
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltGeneroAdic" id="sltGeneroAdic">
                                                <option value=""> Seleccionar </option>   
                                                <?php                  
                                                   LlenarSelectOption($genero)  
                                                ?>                            
                                            </select> 
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>
                                    </td>             
                                </tr>                                                   
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                 
                                        <label>Departamento</label>                             
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <div>
                                            <div class="divControl">
                                                <select name="sltDepartamentoAdic" id="sltDepartamentoAdic">
                                                    <option value=""> Seleccionar </option>                                        
                                                    <?php                                            
                                                        LlenarSelectOption($departamentos)                                         
                                                    ?>                                   
                                                </select>  
                                            </div>                                            
                                            <div class="campoObligatorio">*</div>
                                        </div>
                                    </td>                          
                                </tr>                          
                                <tr>                             
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Municipio</label>
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                 
                                        <div>
                                            <div class="divControl">
                                                <select name="sltMunicipioAdic" id="sltMunicipioAdic">                                                    
                                                </select>  
                                            </div>                                            
                                            <div class="campoObligatorio">*</div>
                                        </div>
                                    </td>                          
                                </tr>                                                         
                                <tr>                            
                                    <td align="left" class="tdFormulario">       
                                        <label>Tipo de Violación</label>       
                                    </td>                 
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltTipoViolacionAdic" id="sltTipoViolacionAdic">
                                                <option value=""> Seleccionar </option>   
                                                <?php                  
                                                   LlenarSelectOption($tipoViolacion)  
                                                ?>                            
                                            </select> 
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>
                                    </td>             
                                </tr>                                                                                   
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Otro Tipo de Violación</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">      
                                        <div class="divControl">                                        
                                        <input type="text" name="txtOtroTipoViolacionAdic" id="txtOtroTipoViolacionAdic" />   
                                        </div>                                        
                                    </td>                                                         
                                </tr>                                                          
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Lugar</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">      
                                        <div class="divControl">                                        
                                        <input type="text" name="txtLugarAdic" id="txtLugarAdic" />   
                                        </div>                                        
                                    </td>                                                         
                                </tr>                          
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Causas</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">      
                                        <div class="divControl">                                        
                                        <input type="text" name="txtCausasAdic" id="txtCausasAdic" />   
                                        </div>                                        
                                    </td>                                                         
                                </tr>                                                          
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Responsables</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">      
                                        <div class="divControl">                                        
                                        <input type="text" name="txtResponsablesAdic" id="txtResponsablesAdic" />   
                                        </div>                                        
                                    </td>                                                         
                                </tr>
                                <tr>                             
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Clase trabajador</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtClaseTrabajadorAdic" />
                                    </td>                          
                                </tr>                                
                                <tr>                             
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Sub Tipo de trabajador</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtSubTipoTrabajadorAdic" />
                                    </td>                          
                                </tr>                                                                
                            </table>                    
                        </fieldset>                
                    </div>            
                </div>            
                <!--Tab Información Laboral-->
                <div id="about-content" class="contentblock hidden">                
                    <div align="center">                    
                        <fieldset align="center">                      
                            <legend align="left" class="legend"></legend>                        
                            <table align="left" >                          
                                <tr>                            
                                    <td align="left" class="tdFormulario">       
                                        <label>Empresa</label>       
                                    </td>                 
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltEmpresaAdic" id="sltEmpresaAdic">
                                                <option value=""> Seleccionar </option>   
                                                <?php                  
                                                   LlenarSelectOption($empresa)  
                                                ?>                            
                                            </select> 
                                        </div>                                                                                    
                                    </td>             
                                </tr>                                                   
                                <tr>                             
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Tipo Empresa</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtTipoEmpresaAdic" />
                                    </td>                          
                                </tr>                                                                                                     
                                <tr>                             
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Federación Región</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtFederacionRegionAdic" />
                                    </td>                          
                                </tr>
                                <tr>                            
                                    <td align="left" class="tdFormulario">       
                                        <label>Federación Rama</label>       
                                    </td>                 
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltFederacionRamaAdic" id="sltFederacionRamaAdic">
                                                <option value=""> Seleccionar </option>   
                                                <?php                  
                                                   LlenarSelectOption($federacionRama)  
                                                ?>                            
                                            </select> 
                                        </div>                                                                                    
                                    </td>             
                                </tr>                               
                                <tr>                            
                                    <td align="left" class="tdFormulario">       
                                        <label>Siglas Sindicato</label>       
                                    </td>                 
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltSiglasSindicatoAdic" id="sltSiglasSindicatoAdic">
                                                <option value=""> Seleccionar </option>   
                                                <?php                  
                                                   LlenarSelectOption($siglasSindicato)  
                                                ?>                            
                                            </select> 
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>
                                    </td>             
                                </tr>                                                   
                                <tr>                             
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Actividad Sindicato</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtActividadSindicatoAdic" />
                                    </td>                          
                                </tr>                                
                                <tr>                             
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Confederación</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtConfederacionAdic" />
                                    </td>                          
                                </tr>                                
                                <tr>                            
                                    <td align="left" class="tdFormulario">       
                                        <label>División Económica</label>       
                                    </td>                 
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltDivisionEconomicaAdic" id="sltDivisionEconomicaAdic">
                                                <option value=""> Seleccionar </option>   
                                                <?php                  
                                                   LlenarSelectOption($divisionEconomica)  
                                                ?>                            
                                            </select> 
                                        </div>                                                                                    
                                    </td>             
                                </tr>                                                               
                                <tr>                             
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Organización Política</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtOrganizacionPoliticaAdic" />
                                    </td>                          
                                </tr>                                                                
                                <tr>                              
                                    <td align="left" class="tdFormulario">                          
                                        <label>Fecha</label>                          
                                    </td>                   
                                    <td align="left" class="tdFormulario">              
                                        <input type="text" id="datepicker2" class="fechas" name="txtFechaAdic" />            
                                    </td>             
                                </tr>                         
                                <tr>                             
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Fuente</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtFuenteAdic" />
                                    </td>                          
                                </tr>                                     
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Resumen Hechos</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <textarea rows="7" cols="45" name="txtResumenHechosAdic"></textarea>
                                    </td>
                                </tr>                                
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                 
                                        <label>Departamento Hechos</label>                             
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <div>
                                            <div class="divControl">
                                                <select name="sltDepartamentoHechosAdic" id="sltDepartamentoHechosAdic">
                                                    <option value=""> Seleccionar </option>                                        
                                                    <?php                                            
                                                        LlenarSelectOption($departamentos)                                         
                                                    ?>                                   
                                                </select>  
                                            </div>                                            
                                            <div class="campoObligatorio">*</div>
                                        </div>
                                    </td>                          
                                </tr>                          
                                <tr>                             
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Municipio Hechos</label>
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                 
                                        <div>
                                            <div class="divControl">
                                                <select name="sltMunicipioHechosAdic" id="sltMunicipioHechosAdic">                                                    
                                                </select>  
                                            </div>                                            
                                            <div class="campoObligatorio">*</div>
                                        </div>
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
        <div id="divAfiliadotoModificar" class="clearfix">        
            <ul id="sidemenuMod">         
                <li>            
                    <a href="#informacion-contentMod" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Personal</a>         
                </li>         
                <li>         
                    <a href="#about-contentMod"><i class="icon-info-sign icon-large"></i>Informaci&oacute;n Laboral</a>       
                </li>       
            </ul>           
            <div id="contentMod">    
                <!--Tab Datos Basicos-->     
                <div id="informacion-contentMod" class="contentblock">      
                    <div align="center">     
                        <fieldset align="center">             
                            <legend class="legend" align="left">Datos Básicos</legend>    
                            <table align="left">             
                                <tr>                                         
                                    <td align="left" class="tdFormulario">                            
                                        <div class="divControl" style="display: none;">
                                            <input type="text" name="txtIdVictima" id="txtIdVictima" <?php echo $soloLectura; ?> value="<?php echo $registro["id_victima"] ?>"/>                                            
                                        </div>                                             
                                    </td>
                                </tr>                                 
                                <tr>                          
                                    <td align="left" class="tdFormulario">                   
                                        <label>Número Cedula</label>              
                                    </td>                  
                                    <td align="left" class="tdFormulario">                            
                                        <div class="divControl" style="display: none;">
                                            <input type="text" name="txtCedulaVictima" id="txtCedulaVictima" <?php echo $soloLectura; ?> value="<?php echo $registro["cedula"] ?>"/>
                                            <div class="campoObligatorio">*</div>
                                        </div>                                             
                                        <label><?php echo $registro["cedula"] ?></label>
                                    </td>
                                </tr> 
                                <tr>                 
                                    <td align="left" class="tdFormulario">      
                                        <label>Nombres y Apellidos</label>
                                    </td>                      
                                    <td align="left" class="tdFormulario">         
                                        <div class="divControl">
                                            <input type="text" name="txtNombreVictima" id="txtNombreVictima" <?php echo $soloLectura; ?> value="<?php echo $registro["nombres_apellidos"] ?>"/>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>
                                    </td>                 
                                </tr>                                                    
                                <tr>
                                    <td align="left" class="tdFormulario">        
                                        <label>Genero</label>
                                    </td>                
                                    <td align="left" class="tdFormulario">        
                                        <div class="divControl">
                                            <select name="sltGenero" id="sltGenero">                 
                                                <option value=""> Seleccionar </option>  
                                                <?php         
                                                LlenarSelectOption($genero, $registro["genero_codigo"])       
                                                ?>        
                                            </select>      
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>                   
                                </tr>                                                                                                          
                                <tr>                
                                    <td align="left" class="tdFormulario">      
                                        <label>Departamento</label>
                                    </td>                           
                                    <td align="left" class="tdFormulario">        
                                        <div class="divControl">
                                            <select name="sltDepartamento" id="sltDepartamento">
                                                <option value=""> Seleccionar </option>           
                                                 <?php      
                                                 LlenarSelectOption($departamentos, $registro["D"])       
                                                 ?>      
                                            </select>            
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                                                
                                    </td>                  
                                </tr>                  
                                <tr>              
                                    <td align="left" class="tdFormulario">   
                                        <label>Municipio</label>
                                    </td>                        
                                    <td align="left" class="tdFormulario">       
                                        <div class="divControl">
                                            <select name="sltMunicipio" id="sltMunicipio">
                                                <option value=""> Seleccionar </option>    
                                                <?php                
                                                LlenarSelectOption($municipios, $registro["municipio_codigo"])    
                                                ?>             
                                            </select>             
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>                    
                                </tr>                       
                                <tr>
                                    <td align="left" class="tdFormulario">        
                                        <label>Tipo de Violación</label>
                                    </td>                
                                    <td align="left" class="tdFormulario">        
                                        <div class="divControl">
                                            <select name="sltTipoViolacion" id="sltTipoViolacion">                 
                                                <option value=""> Seleccionar </option>  
                                                <?php         
                                                LlenarSelectOption($tipoViolacion, $registro["tipo_violacion_codigo"])       
                                                ?>        
                                            </select>      
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>                   
                                </tr>                                
                                <tr>                    
                                    <td align="left" class="tdFormulario">    
                                        <label>Otro Tipo de Violación</label>
                                    </td>                         
                                    <td align="left" class="tdFormulario">   
                                        <input type="text" name="txtOtroTipoViolacion" id="txtOtroTipoViolacion"  <?php echo $soloLectura; ?> value="<?php echo $registro["otro_tipo_violacion"]?>"/>         
                                    </td>                
                                </tr>                                                         
                                <tr>                    
                                    <td align="left" class="tdFormulario">    
                                        <label>Lugar</label>
                                    </td>                         
                                    <td align="left" class="tdFormulario">   
                                        <input type="text" name="txtLugar"  <?php echo $soloLectura; ?> value="<?php echo $registro["lugar"]?>"/>         
                                    </td>                
                                </tr>                         
                                <tr>              
                                    <td align="left" class="tdFormulario">                
                                        <label>Causas</label>
                                    </td>                   
                                    <td align="left" class="tdFormulario">  
                                        <div class="divControl">                                        
                                            <input type="text" name="txtCausas" id="txtCausas" <?php echo $soloLectura; ?> value="<?php echo $registro["causas"]?>" />
                                        </div>                                                                                                                            
                                    </td>                    
                                </tr>
                                <tr>              
                                    <td align="left" class="tdFormulario">                
                                        <label>Responsables</label>
                                    </td>                   
                                    <td align="left" class="tdFormulario">  
                                        <div class="divControl">                                        
                                            <input type="text" name="txtResponsables" id="txtResponsables" <?php echo $soloLectura; ?> value="<?php echo $registro["responsables"]?>" />
                                        </div>                                                                                                                            
                                    </td>                    
                                </tr>                                
                                <tr>                           
                                    <td align="left" class="tdFormulario">       
                                        <label>Clase Trabajador</label>
                                    </td>                       
                                    <td align="left" class="tdFormulario">    
                                        <input type="text" name="txtClaseTrabajador" <?php echo $soloLectura; ?> value="<?php echo $registro["clase_trabajador"]?>"/>      
                                    </td>                     
                                </tr>                  
                                <tr>             
                                    <td align="left" class="tdFormulario">       
                                        <label>Sub Tipo de Trabajador</label>
                                    </td>                     
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtSubTipoTrabajador" <?php echo $soloLectura; ?> value="<?php echo $registro["sub_tipo_trabajador"]?>"/>              
                                    </td>             
                                </tr>                    
                            </table>           
                        </fieldset>             
                    </div>           
                </div>       
                <div id="about-contentMod" class="contentblock hidden">         
                    <div align="center">                
                        <fieldset align="center">     
                            <legend align="left"></legend>   
                            <table align="left" >                 
                                <tr>
                                    <td align="left" class="tdFormulario">        
                                        <label>Empresa</label>
                                    </td>                
                                    <td align="left" class="tdFormulario">        
                                        <div class="divControl">
                                            <select name="sltEmpresa" id="sltEmpresa">                 
                                                <option value=""> Seleccionar </option>  
                                                <?php         
                                                LlenarSelectOption($empresa, $registro["id_empresa"])       
                                                ?>        
                                            </select>      
                                        </div>                                                                                                                          
                                    </td>                   
                                </tr>                                                                
                                <tr>             
                                    <td align="left" class="tdFormulario">       
                                        <label>Tipo Empresa</label>
                                    </td>                     
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtTipoEmpresa" <?php echo $soloLectura; ?> value="<?php echo $registro["tipo_empresa"]?>"/>              
                                    </td>             
                                </tr>                                                    
                                <tr>                     
                                    <td align="left" class="tdFormulario">             
                                        <label>Federación Región</label>
                                    </td>
                                    <td align="left" class="tdFormulario">                
                                        <input type="text" name="txtFederacionRegion" <?php echo $soloLectura; ?> value="<?php echo $registro["federacion_region"]?>"/> 
                                    </td>             
                                </tr>                      
                                <tr>
                                    <td align="left" class="tdFormulario">        
                                        <label>Federación Rama</label>
                                    </td>                
                                    <td align="left" class="tdFormulario">        
                                        <div class="divControl">
                                            <select name="sltFederacionRama" id="sltFederacionRama">                 
                                                <option value=""> Seleccionar </option>  
                                                <?php         
                                                LlenarSelectOption($federacionRama, $registro["federacion_rama_codigo"])       
                                                ?>        
                                            </select>      
                                        </div>                                                                                                                        
                                    </td>                   
                                </tr>                 
                                <tr>
                                    <td align="left" class="tdFormulario">        
                                        <label>Siglas Sindicato</label>
                                    </td>                
                                    <td align="left" class="tdFormulario">        
                                        <div class="divControl">
                                            <select name="sltSiglasSindicato" id="sltSiglasSindicato">                 
                                                <option value=""> Seleccionar </option>  
                                                <?php         
                                                LlenarSelectOption($siglasSindicato, $registro["id_sindicato"])       
                                                ?>        
                                            </select>      
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>                   
                                </tr>                                
                                <tr>                   
                                    <td align="left" class="tdFormulario">   
                                        <label>Actividad Sindicato</label>
                                    </td>             
                                    <td align="left" class="tdFormulario">         
                                        <input type="text" name="txtActividadSindicato" <?php echo $soloLectura; ?> value="<?php echo $registro["actividad_sindicato"]?>"/>    
                                    </td>                     
                                </tr>                     
                                <tr>                 
                                    <td align="left" class="tdFormulario">       
                                        <label>Confederación</label>
                                    </td>                         
                                    <td align="left" class="tdFormulario">        
                                        <input type="text" name="txtConfederacion" <?php echo $soloLectura; ?> value="<?php echo $registro["confederacion"]?>"/> 
                                    </td>               
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">        
                                        <label>División Económica</label>
                                    </td>                
                                    <td align="left" class="tdFormulario">        
                                        <div class="divControl">
                                            <select name="sltDivisionEconomica" id="sltDivisionEconomica">                 
                                                <option value=""> Seleccionar </option>  
                                                <?php         
                                                LlenarSelectOption($divisionEconomica, $registro["division_economica_codigo"])       
                                                ?>        
                                            </select>      
                                        </div>                                                                                    
                                    </td>                   
                                </tr>                                                                
                                <tr>                   
                                    <td align="left" class="tdFormulario">   
                                        <label>Organización Política</label>
                                    </td>             
                                    <td align="left" class="tdFormulario">         
                                        <input type="text" name="txtOrganizacionPolitica" <?php echo $soloLectura; ?> value="<?php echo $registro["organizacion_politica"]?>"/>    
                                    </td>                     
                                </tr>                     
                                <tr>          
                                    <td align="left" class="tdFormulario">        
                                        <label>Fecha</label>      
                                    </td>                       
                                    <td align="left" class="tdFormulario">    
                                        <input type="text" <?php if($consultar != "1") echo 'id="datepicker6"' ?> name="txtFecha" <?php echo $soloLectura; ?> class="fechas" value="<?php if($registro["fecha"] != '0000-00-00') echo $registro["fecha"]; ?>" />
                                    </td>       
                                </tr>                                                   
                                <tr>                   
                                    <td align="left" class="tdFormulario">   
                                        <label>Fuente</label>
                                    </td>             
                                    <td align="left" class="tdFormulario">         
                                        <input type="text" name="txtFuente" <?php echo $soloLectura; ?> value="<?php echo $registro["fuente"]?>"/>    
                                    </td>                     
                                </tr>                                                     
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Resumen Hechos</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <textarea rows="7" cols="45" <?php echo $soloLectura; ?> name="txtResumenHechos"><?php echo $registro["resumen_hechos"]?></textarea>
                                    </td>
                                </tr>                                
                                <tr>                
                                    <td align="left" class="tdFormulario">      
                                        <label>Departamento Hechos</label>
                                    </td>                           
                                    <td align="left" class="tdFormulario">        
                                        <div class="divControl">
                                            <select name="sltDepartamentoHechos" id="sltDepartamentoHechos">
                                                <option value=""> Seleccionar </option>           
                                                 <?php      
                                                 LlenarSelectOption($departamentos, $registro["DH"])       
                                                 ?>      
                                            </select>            
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                                                
                                    </td>                  
                                </tr>                  
                                <tr>              
                                    <td align="left" class="tdFormulario">   
                                        <label>Municipio Hechos</label>
                                    </td>                        
                                    <td align="left" class="tdFormulario">       
                                        <div class="divControl">
                                            <select name="sltMunicipioHechos" id="sltMunicipioHechos">
                                                <option value=""> Seleccionar </option>    
                                                <?php                
                                                LlenarSelectOption($municipios, $registro["municipio_hecho_codigo"])    
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
        <div id="divErrorMod"></div>      
        <div class="clearBoth"></div>    
        <div class="divGuardar">   
            <?php        
            if($tituloTab == 'Consulta')   
            {       
            ?>    
                <a href="/index.php/controladorVictima">       
                    <img src="/images/volver.png" width="36" height="36" />      
                    <br/>        
                    Regresar       
                </a>       
             <?php           
            }   
            else 
            { ?>  
                <div id="divGuardarMod">
                    <button type="submit" class="submit">
                        <img src="/images/guardar.jpg" width="36" height="36" />          
                        <br/>          
                        Guardar       
                    </button> 
                </div>
                <div id="divRegresarMod">
                <a href="/index.php/controladorVictima">       
                    <img src="/images/volver.png" width="36" height="36" />      
                    <br/>        
                    Regresar       
                </a>
                </div>
                <div class="clearBoth"></div>
            <?php } ?>
        </div>  
    </div>
</div>    

<?php FinalDocumento(); ?>