<?php 
/*
 * Vista Directivo
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Gesti�n Directivos";
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
  echo form_open('controladorDirectivo/AdicionarDirectivo');
  echo "<script src='/js/directivoSindicatoAdicionar.js'></script>";
}
else
{
  echo form_open('controladorDirectivo/ModificarDirectivo');
  echo "<script src='/js/directivoSindicatoModificar.js'></script>";
}

/*
* Mensajes de eliminacion de registros
*/
if(isset($estadoEliminar) && $estadoEliminar == true)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Se elimino satisfactoriamente el registro de directivo.
        </div>';
else if(isset($estadoEliminar) && $estadoEliminar == false)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Ocurrio un problema al eliminar el registro de directivo.
        </div>';
/*
* Mensajes de modificacion de registros
*/
if(isset($estadoModificar) && $estadoModificar == true)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Se actualizo el registro de directivo satisfactoriamente.
        </div>';
else if(isset($estadoModificar) && $estadoModificar == false)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Error al actualizar el registro de directivo.
        </div>';
/*
* Mensajes de adicion de registros
*/
if(isset($estadoAdicionar) && $estadoAdicionar == true)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Se adicion� el registro de directivo satisfactoriamente.
        </div>';
else if(isset($estadoAdicionar) && $estadoAdicionar == false)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Error al adicionar el registro de directivo.
        </div>';
/*
* Validacion de modo consulta detallada
*/
if(isset($consultar) && $consultar == "1")
  echo "<script src='/js/directivo.js'></script>";

if($usuario['perfil'] == 'Lector Sindicato' || $usuario['perfil'] == "Editor Federacion" || $usuario['perfil'] == "Lector Federacion" )
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
      <li><a href="#tabConsultar" class="limpiarFormulario">Consultar</a></li>
      <li><a href="#tabAdicionar">Adicionar</a></li>
      <li><a href="#tabModificar"><?php echo $tituloTab ?></a></li>
  </ul>
  <div id="tabConsultar" align="center">
      <table cellpadding="5" align="center" cellspacing="3" class="td">
          
          <tr class="trTitulo">
              <td class='td' <?php if($usuario['perfil'] == "Lector Sindicato" || $usuario['perfil'] == "Editor Federacion" || $usuario['perfil'] == "Lector Federacion") echo "id='tdLector'"; else echo "id='tdAdministrador'" ?>></td>
              <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Cedula"; else echo '<a style="color: #fff;" href="/index.php/controladorDirectivo/index/5">Cedula &dArr;</a>' ?></td>            
              <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Nombres Apellidos"; else echo '<a style="color: #fff;" href="/index.php/controladorDirectivo/index/6">Nombres Apellidos &dArr;</a>' ?></td>
              <td class='td'>Cargo</td>
              <td class='td'>Correo</td>
              <td class='tdAmpliadoConsulta'><?php if($usuario['perfil'] != "Administracion") echo "Nombre Sindicato"; else echo '<a style="color: #fff;" href="/index.php/controladorDirectivo/index/14">Nombre Sindicato &dArr;</a>'?></td>
          </tr>
              <?php
              /*
               * * $registros: Array en donde se obtienen los resultados del
               * * $registro: Donde se almacenaran el registro actual para graficar
               */
              $color = "#FDFCFC";
              if($tituloTab != 'Consulta')
              {
                  if(!isset($consultar))
                  {
                    foreach($registros as $registro)
                    {
                        echo '<tr class="trDatos" style="background-color: '.$color.';">
                                      <td class="td" align="center">';
                        if($usuario['perfil'] == "Lector Sindicato" || $usuario['perfil'] == "Editor Federacion" || $usuario['perfil'] == "Lector Federacion")
                            echo '<div class="floatLeft">
                                      <a href="/index.php/controladorDirectivo/ConsultarDirectivo/'.$registro['cedula'].'/1" title="Consultar">
                                          <img src="/images/buscar.png" width="20" height="20" alt="Consultar"/>
                                      </a>
                                  </div>';
                        
                        else if($usuario['perfil'] == "Editor Sindicato")
                        {
                            echo '<div class="divImgEditar">
                                      <a href="/index.php/controladorDirectivo/ConsultarDirectivo/'.$registro['cedula'].'" title="Modificar">
                                          <img src="/images/editar.jpg" width="20" height="20"  alt="Editar"/>
                                      </a>
                                  </div>';
                        }                            
                        else 
                        {
                            echo '<div class="divImgEditar">
                                      <a href="/index.php/controladorDirectivo/ConsultarDirectivo/'.$registro['cedula'].'" title="Modificar">
                                          <img src="/images/editar.jpg" width="20" height="20"  alt="Editar"/>
                                      </a>
                                  </div>
                                  <div class="divImgEliminar">
                                      <a href="javascript:;" onclick="Confirmar(\'/index.php/controladorDirectivo/EliminarDirectivo/'.$registro['cedula'].'\'); return false;"  title="Eliminar">
                                          <img src="/images/eliminar.png" width="20" height="20" alt="Eliminar"/>
                                      </a>
                                  <div>';
                        }                                 
                        echo "<td class='td'>".$registro['cedula']."</td>";
                        echo "<td class='td'>".utf8_decode($registro['nombres_apellidos'])."</td>";
                        echo "<td class='td'>".utf8_decode($registro['cargo'])."</td>";
                        echo "<td class='td'>".utf8_decode($registro['correo'])."</td>";
                        echo "<td class='td'>".utf8_decode($registro['nombre'])."</td>";                        
                        echo "<td class='td'>";
                        $color = $color == "#FDFCFC" ? "#F0EEEE" : "#FDFCFC";
                    }             
                  }
                    else
                        $registro = $registros[0];
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
              <a href="/index.php/controladorDirectivo/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                  <img src="/images/excel.jpg" width="30" height="30" />
                  <br />
                  Exportar a Excel
              </a>
          </div>
          <div id="divExportarPdf">
              <a href="/index.php/controladorDirectivo/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                  <img src="/images/pdf.jpg" width="30" height="30" />
                  <br />
                  Exportar a Pdf
              </a>
          </div>
          <div class="clearBoth"></div>
      </div>
  </div>
  <div id="tabAdicionar">
      <div id="divEmpresa" class="clearfix">
          <ul id="sidemenu">
              <li>
                  <a href="#informacion-content" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Directivo Sindicato</a>
              </li>
          </ul>
          <div id="content">
              <!--Tab Datos Basicos-->
              <div id="informacion-content" class="contentblock">
                  <div align="center">
                      <fieldset align="center">
                          <legend align="left" class="legend">Datos B�sicos</legend>
                                <table align="left" style="margin-top: 15px;">                
                                    <tr>                     
                                        <td align="left" class="tdFormulario">      
                                            <label>Nombre  y Apellido</label>        
                                        </td>                           
                                        <td align="left" class="tdFormulario"> 
                                            <div class="divControl">                                             
                                                <input  type="text" name="txtNombreApellidoAdic" id="txtNombreApellidoAdic" value="" />  
                                            </div>                                                              
                                        <div class="campoObligatorio">*</div>                                                                    
                                        </td>                  
                                    </tr>    
                                    <tr>
                                        <td align="left" class="tdMiddle">
                                            <label>C�dula</label>
                                        </td>
                                        <td align="left" class="tdFormulario">
                                            <div>
                                                <div class="divControl">
                                                    <input type="text" id="txtCedulaDirectivoAdic" name="txtCedulaDirectivoAdic" />                                              
                                                </div>
                                                <div class="campoObligatorio">*</div>
                                                <div class="clearBoth"></div>
                                                <div id="divCedulaVal" class="fuenteRoja"></div>
                                            </div>
                                        </td>
                                    </tr>                                    
                                    <tr>                            
                                        <td align="left" class="tdFormulario">   
                                            <label>Fecha de Nacimiento</label>               
                                        </td>                   
                                        <td align="left" class="tdFormulario">             
                                          <div class="divControl">                                            
                                            <input type="text" id="datepicker10" name="txtFechaNacimientoAdic" id="txtFechaNacimientoAdic" value="" />        
                                          </div>
                                          <div class="campoObligatorio">*</div>                                            
                                        </td>                       
                                    </tr>                  
                                    <tr>                     
                                        <td align="left" class="tdFormulario">     
                                            <label>Edad por Categor�as</label>                
                                        </td>                         
                                        <td align="left" class="tdFormulario">     
                                            <div class="divControl">                                            
                                            <select name="sltEdadCategoriasAdic" id="sltEdadCategoriasAdic">    
                                                <option value=""> Seleccionar </option>           
                                                <?php                                 
                                                LlenarSelectOption($edadPorCategorias)
                                                ?>
                                            </select>                         
                                            </div>                                                              
                                        <div class="campoObligatorio">*</div>
                                        </td>                   
                                    </tr>                
                                    <tr>                      
                                        <td align="left" class="tdFormulario">   
                                            <label>N�mero de Celular</label>    
                                        </td>                  
                                        <td align="left" class="tdFormulario">     
                                            <input type="text" name="txtNumeroCelularAdic" id="txtNumeroCelularAdic" value="" />  
                                        </td>    
                                    </tr>  
                                    <tr>                      
                                        <td align="left" class="tdFormulario">   
                                            <label>Tel�fono</label>    
                                        </td>                  
                                        <td align="left" class="tdFormulario">     
                                            <input type="text" name="txtTelefonosAdic" id="txtTelefonosAdic" value="" />  
                                        </td>    
                                    </tr> 
                                    <tr>              
                                        <td align="left" class="tdFormulario">       
                                            <label>Correo Electr�nico</label>  
                                        </td>                
                                        <td align="left" class="tdFormulario">                 
                                            <input type="text" name="txtCorreoAdic" id="txtCorreoAdic" value="" />    
                                        </td>                 
                                    </tr>                    
                                    <tr>                      
                                        <td align="left" class="tdFormulario">     
                                            <label>Usuario Facebook</label>        
                                        </td>                    
                                        <td align="left" class="tdFormulario">         
                                            <input type="text" name="txtUsuarioFacebookAdic" id="txtUsuarioFacebookAdic" value="" />
                                        </td>          
                                    </tr>                      
                                    <tr>                    
                                        <td align="left" class="tdFormulario">   
                                            <label>Usuario Twiter</label>        
                                        </td>                         
                                        <td align="left" class="tdFormulario">       
                                            <input type="text" name="txtUsuarioTwiterAdic" id="txtUsuarioTwiterAdic" value="" />          
                                        </td>         
                                    </tr>                          
                                    <tr>                   
                                        <td align="left" class="tdFormulario">
                                            <label>Nivel educativo</label>                      
                                        </td>
                                        <td align="left" class="tdFormulario">      
                                            <div class="divControl">                                                                                        
                                            <select name="sltNivelEducativoAdic" id="sltNivelEducativoAdic">
                                                <option value=""> Seleccionar </option>        
                                                <?php                                 
                                                LlenarSelectOption($nivelEducativo)
                                                ?>
                                            </select>               
                                            </div>                                                              
                                         <div class="campoObligatorio">*</div>                                            
                                        </td>                
                                    </tr>              
                                    <tr>                    
                                        <td align="left" class="tdFormulario">    
                                            <label>Cargo</label>          
                                        </td>                  
                                        <td align="left" class="tdFormulario">           
                                            <div class="divControl">                                                                                        
                                            <select name="sltCargoDirectivoAdic" id="sltCargoDirectivoAdic"> 
                                                <option value="">Seleccionar </option>     
                                                <?php                                 
                                                LlenarSelectOption($cargos)
                                                ?>
                                            </select>       
                                            </div>                                                              
                                        <div class="campoObligatorio">*</div>                                            
                                        </td>                  
                                    </tr>                      
                                    <tr>                    
                                        <td align="left" class="tdFormulario">    
                                            <label>Sindicato al que Pertenece</label>          
                                        </td>                  
                                        <td align="left" class="tdFormulario">           
                                            <div class="divControl">                                                                                        
                                            <select name="sltSindicatoDirectivoAdic" id="sltSindicatoDirectivoAdic"> 
                                                <option value="">Seleccionar </option>     
                                                <?php                                 
                                                LlenarSelectOption($sindicatoDirectivo)
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
      <div id="divEmpresaModificar" class="clearfix">
          <ul id="sidemenuMod">
              <li>
                  <a href="#informacion-contentMod" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Directivo Sindicato</a>
              </li>
          </ul>
          <div id="contentMod">
              <!--Tab Datos Basicos-->
              <div id="informacion-contentMod" class="contentblock">
                  <div align="center">
                      <fieldset align="center">
                          <legend class="legend" align="left">Datos B�sicos</legend>
                          <table align="left">
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Nombre y Apellido</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <input type="text" name="txtNombreApellido" id="txtNombreApellido" <?php echo $soloLectura; ?> value="<?php echo $registro["nombres_apellidos"] ?>"/>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>                              
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Cedula</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl" style="display: none;">
                                          <input type="text" name="txtCedulaDirectivo" id="txtCedula" <?php echo $soloLectura; ?> value="<?php echo $registro["cedula"] ?>"/>
                                          <input type="text" name="txtIdDirectivo"   <?php echo $soloLectura; ?> value="<?php echo $registro["id_directivo"] ?>"/>
                                          <div class="campoObligatorio">*</div>
                                      </div>
                                      <label><?php echo $registro["cedula"] ?></label>
                                  </td>
                              </tr>
                                <tr>          
                                    <td align="left" class="tdFormulario">        
                                        <label>Fecha de Nacimiento</label>      
                                    </td>                       
                                    <td align="left" class="tdFormulario">    
                                      <div class="divControl">
                                        <input type="text" <?php if($consultar != "1") echo 'id="datepicker11"' ?> name="txtFechaNacimiento" id="txtFechaNacimiento" <?php echo $soloLectura; ?> class="fechas" value="<?php if($registro["fecha_nacimiento"] != '0000-00-00') echo $registro["fecha_nacimiento"]; ?>" />
                                      </div>                                        
                                      <div class="campoObligatorio">*</div>                                        
                                    </td>       
                                </tr>                                                 
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Edad por Categor�as</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltEdadCategorias" id="sltEdadCategorias">
                                              <option value=""> Seleccionar </option>
                                              <?php
                                              LlenarSelectOption($edadPorCategorias, $registro["edad_x_categoria_codigo"])
                                              ?>
                                          </select>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>                                
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>N�mero de Celular</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <input type="text" name="txtNumeroCelular" id="txtNumeroCelular" <?php echo $soloLectura; ?> value="<?php echo $registro["celular"] ?>"/>                                          
                                      </div>                                      
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Tel�fono</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtTelefonos" id="txtTelefonos" <?php echo $soloLectura; ?> value="<?php echo $registro["telefonos"] ?>"/>                                      
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Correo Electr�nico</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtCorreo" <?php echo $soloLectura; ?> value="<?php echo $registro["correo"]?>"/>
                                  </td>
                              </tr>                              
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Usuario Facebook</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtUsuarioFacebook" <?php echo $soloLectura; ?> value="<?php echo $registro["usuario_facebook"]?>"/>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Usuario Twiter</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtUsuarioTwiter" <?php echo $soloLectura; ?> value="<?php echo $registro["usuario_twiter"]?>"/>
                                  </td>
                              </tr>                              
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Nivel educativo</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltNivelEducativo" id="sltNivelEducativo">
                                              <option value=""> Seleccionar </option>
                                              <?php
                                              LlenarSelectOption($nivelEducativo, $registro["nivel_educativo_codigo"])
                                              ?>
                                          </select>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>                                
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Cargo</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltCargoDirectivo" id="sltCargoDirectivo">
                                              <option value=""> Seleccionar </option>
                                              <?php
                                              LlenarSelectOption($cargos, $registro["cargo_directivo_codigo"])
                                              ?>
                                          </select>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>                                                              
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Sindicato al que Pertenece</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltSindicatoDirectivo" id="sltSindicatoDirectivo">
                                              <option value=""> Seleccionar </option>
                                              <?php
                                              LlenarSelectOption($sindicatoDirectivo, $registro["rut"])
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
              <a href="/index.php/controladorDirectivo">
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
              <a href="/index.php/controladorDirectivo">
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