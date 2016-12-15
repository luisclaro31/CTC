<?php /* * Vista Tipo Estado * Excellentiam S.E. * Fecha creacion: 17/09/14 */include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");$tituloPagina = "Gesti�n Listas de Estados";$soloLectura = "";if(isset($error))  $tab = 'tabAdicionar';else  $tab = 'tabConsultar';if(isset($consultar)){  if($consultar == "1")      $tituloTab = 'Consulta';  else      $tituloTab = 'Modificar';  $tab = 'tabModificar';  $tabActivo = 1;  if($consultar == "1")      $soloLectura = "readonly";}else{  $tituloTab = 'Modificar';  $tabActivo = 2;}Cabecera($tituloPagina, $usuario, $tab, $tabActivo);if(!isset($consultar) || $tituloTab == 'Consulta'){  echo form_open('controladorEstado/AdicionarEstado');  echo "<script src='/js/estadoAdicionar.js'></script>";}else{  echo form_open('controladorEstado/ModificarEstado');  echo "<script src='/js/estadoModificar.js'></script>";}/** Mensajes de eliminacion de registros*/if(isset($estadoEliminar) && $estadoEliminar == true)  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Se elimino satisfactoriamente el registro de estado.        </div>';else if(isset($estadoEliminar) && $estadoEliminar == false)  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Ocurrio un problema al eliminar el registro de estado.        </div>';/** Mensajes de modificacion de registros*/if(isset($estadoModificar) && $estadoModificar == true)  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Se actualizo el registro de estado satisfactoriamente.        </div>';else if(isset($estadoModificar) && $estadoModificar == false)  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Error al actualizar el registro de estado.        </div>';/** Mensajes de adicion de registros*/if(isset($estadoAdicionar) && $estadoAdicionar == true)  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Se adicion� el registro de estado satisfactoriamente.        </div>';else if(isset($estadoAdicionar) && $estadoAdicionar == false)  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Error al adicionar el registro de estado.        </div>';/** Validacion de modo consulta detallada*/if(isset($consultar) && $consultar == "1")  echo "<script src='/js/estado.js'></script>";?><div id='divTituloPrincipal'>  <?php echo $tituloPagina; ?></div><div id="tabs" class="divTabs">    <ul>        <li><a href="#tabConsultar" class="limpiarFormulario">Consultar</a></li>        <li><a href="#tabAdicionar">Adicionar</a></li>        <li><a href="#tabModificar"><?php echo $tituloTab ?></a></li>    </ul>    <div id="tabConsultar" align="center" style="padding-top: 25px;">        <table cellpadding="5" align="center" cellspacing="3" class="td">            <tr class="trTitulo">                <td class='td' <?php if($usuario['perfil'] == "Lector") echo "id='tdLector'"; else echo "id='tdAdministrador'" ?>></td>                <td class='td'>Codigo</td>                <td class='td'>Descripci�n Lista de Estado</td>                <td class='td'>Nombre Estado</td>            </tr>                <?php                /*                 * * $registros: Array en donde se obtienen los resultados del                 * * $registro: Donde se almacenaran el registro actual para graficar                 */                $color = "#FDFCFC";                if(!isset($consultar))                {                    foreach($registros as $registro)                    {                             echo '<tr class="trDatos" style="background-color: '.$color.';">                                      <td class="td" align="center">';                        if($usuario['perfil'] == "Lector")                            echo '<div class="floatLeft">                                      <a href="/index.php/controladorEstado/ConsultarEstado/'.$registro['codigo'].'/1" title="Consultar">                                          <img src="/images/buscar.png" width="20" height="20" alt="Consultar"/>                                      </a>                                  </div>';                        else                        {                            echo '<div class="divImgEditar">                                      <a href="/index.php/controladorEstado/ConsultarEstado/'.$registro['codigo'].'" title="Modificar">                                          <img src="/images/editar.jpg" width="20" height="20"  alt="Editar"/>                                      </a>                                  </div>                                  <div class="divImgEliminar">                                      <a href="javascript:;" onclick="Confirmar(\'/index.php/controladorEstado/EliminarEstado/'.$registro['codigo'].'\'); return false;"  title="Eliminar">                                          <img src="/images/eliminar.png" width="20" height="20" alt="Eliminar"/>                                      </a>                                  <div>';                        }                        echo "</td>";                        echo "<td class='td'>".utf8_decode($registro['codigo'])."</td>";                                                echo "<td class='td'>".utf8_decode($registro['descripcion'])."</td>";                        echo "<td class='td'>".utf8_decode($registro['nombre_estado'])."</td>                                                        </tr>";                        $color = $color == "#FDFCFC" ? "#F0EEEE" : "#FDFCFC";                    }                 }                     else                  $registro = $registros[0];                ?>        </table>                <div id="divExportarFormatos">          <div id="divExportarExcel">              <a href="/index.php/controladorEstado/GenerarExcel" target="_blank" title="Exportar a formato Excel">                  <img src="/images/excel.jpg" width="30" height="30" />                  <br />                  Exportar a Excel              </a>          </div>          <div id="divExportarPdf">              <a href="/index.php/controladorEstado/GenerarPdf" target="_blank" title="Exportar a formato PDF">                  <img src="/images/pdf.jpg" width="30" height="30" />                  <br />                  Exportar a Pdf              </a>          </div>          <div class="clearBoth"></div>      </div>    </div>    <div id="tabAdicionar">        <div id="divConvenio" class="clearfix">            <ul id="sidemenu">                <li>                    <a href="#informacion-content" class="open"><i class="icon-home icon-large"></i>Informaci�n Listas de Estados</a>                </li>            </ul>            <div id="content">                <!--Tab Datos Basicos-->                <div id="informacion-content" class="contentblock">                    <div align="center">                        <fieldset align="center">                          <legend align="left" class="legend">Datos B�sicos</legend>                            <table align="left">                                         <tr>                                                                  <td align="left" class="tdMiddle">                                                                          <label>Codigo</label>                                                                  </td>                                                                  <td align="left" class="tdFormulario">                                                                          <div>                                            <div class="divControl">                                                <input type="text" id="txtCodigoAdic" name="txtCodigoAdic" />                                                <input type="hidden" id="txtExisteCodigo" name="txtExisteCodigo" />                                            </div>                                                                                        <div class="campoObligatorio">*</div>                                            <div class="clearBoth"></div>                                            <div id="divCodigoVal" class="fuenteRoja"></div>                                        </div>                                     </td>                                                          </tr>                                                                       <tr>                                    <td align="left" class="tdFormulario">                                        <label>Descripci�n Lista de Estado</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <input type="text" name="txtDescripcionEstadoAdic" id="txtDescripcionEstadoAdic" />                                        </div>                                        <div class="campoObligatorio">*</div>                                                                            </td>                                </tr>                                <tr>                                                                  <td align="left" class="tdMiddle">                                                                          <label>Nombre Estado</label>                                    </td>                                                                  <td align="left" class="tdFormulario">                                                                                                                  <div class="divControl">                                            <select name="sltNombreEstadoAdic" id="sltNombreEstadoAdic" />                                                <option value=""> Seleccionar </option>                                                                                        <?php                                                                                                                                            LlenarSelectOption($nombreEstado)                                                                                         ?>                                                                               </select>                                        </div>                                                                                    <div class="campoObligatorio">*</div>                                                                            </td>                                                          </tr>                            </table>                        </fieldset>                    </div>                </div>            </div>        </div>        <div id="divError"></div>      <div class="clearBoth"></div>      <div class="divGuardar">          <button type="submit" class="submit">              <img src="/images/guardar.jpg" width="36" height="36" />              <br/>              Guardar          </button>      </div>    </div>    <div id="tabModificar">        <div id="divConvenioModificar" class="clearfix">            <ul id="sidemenuMod">                <li>                    <a href="#informacion-contentMod" class="open"><i class="icon-home icon-large"></i>Informaci�n Listas de Estados</a>                </li>            </ul>            <div id="contentMod">                <!--Tab Datos Basicos-->                <div id="informacion-contentMod" class="contentblock">                    <div align="center">                        <fieldset align="center">                          <legend align="left" class="legend">Datos B�sicos</legend>                            <table align="left">                                                             <tr>                                                              <td align="left" class="tdFormulario">                                                           <label>Codigo</label>                                                  </td>                                                      <td align="left" class="tdFormulario">                                                                    <div class="divControl" style="display: none;">                                            <input type="text" name="txtCodigo" id="txtCodigo" <?php echo $soloLectura; ?> value="<?php echo $registro["codigo"] ?>"/>                                            <div class="campoObligatorio">*</div>                                        </div>                                                                                <label><?php echo $registro["codigo"] ?></label>                                    </td>                                </tr>                                                                 <tr>                                    <td align="left" class="tdFormulario">                                        <label>Descripci�n Lista de Estado</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <input type="text" <?php echo $soloLectura; ?> name="txtDescripcionEstado" id="txtDescripcionEstado" value="<?php echo $registro['descripcion'] ?>"/>                                        </div>                                        <div class="campoObligatorio">*</div>                                                                            </td>                                </tr>                                <tr>                                    <td align="left" class="tdFormulario">                                        <label>Nombre Estado</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <select name="sltNombreEstado" id="sltNombreEstado">                                                <option value=""> Seleccionar </option>                                                  <?php                                                  LlenarSelectOption($nombreEstado, $registro['estado_codigo'])                                                  ?>                                            </select>                                        </div>                                        <div class="campoObligatorio">*</div>                                                                              </td>                                </tr>                                                            </table>                                                      <div class='clearBoth'></div>                                                    </fieldset>                    </div>                </div>            </div>        </div>        <div id="divErrorMod"></div>      <div class="clearBoth"></div>      <div class="divGuardar">          <?php          if($tituloTab == 'Consulta')          {          ?>              <a href="/index.php/controladorEstado">                  <img src="/images/volver.png" width="36" height="36" />                  <br/>                  Regresar              </a>           <?php          }          else          { ?>              <div id="divGuardarMod">                  <button type="submit" class="submit">                      <img src="/images/guardar.jpg" width="36" height="36" />                      <br/>                      Guardar                  </button>              </div>              <div id="divRegresarMod">              <a href="/index.php/controladorEstado">                  <img src="/images/volver.png" width="36" height="36" />                  <br/>                  Regresar              </a>              </div>              <div class="clearBoth"></div>          <?php } ?>      </div>    </div></div><?php FinalDocumento(); ?>