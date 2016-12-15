<?php
/*
 * * Vista Usuarios * Excellentiam S.E. *
 * Fecha creacion: 17/09/14
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Gesti�n Usuarios";
$soloLectura = "";
if(isset($error))
    $tab = 'tabAdicionar';
else
    $tab = 'tabConsultar';

if(isset($consultar))
{  if($consultar == "1")
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
    echo form_open('controladorUsuario/AdicionarUsuario');
    echo "<script src='/js/usuarioAdicionar.js'></script>";

}
else
{  echo form_open('controladorUsuario/ModificarUsuario');
    echo "<script src='/js/usuarioModificar.js'></script>";

}
/** Mensajes de eliminacion de registros*/
if(isset($estadoEliminar) && $estadoEliminar == true)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Se elimino satisfactoriamente el registro de usuario.        </div>';
else if(isset($estadoEliminar) && $estadoEliminar == false)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Ocurrio un problema al eliminar el registro de usuario.        </div>';
/** Mensajes de modificacion de registros*/
if(isset($estadoModificar) && $estadoModificar == true)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Se actualizo el registro de usuario satisfactoriamente.        </div>';
else if(isset($estadoModificar) && $estadoModificar == false)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Error al actualizar el registro de usuario.        </div>';
/** Mensajes de adicion de registros*/
if(isset($estadoAdicionar) && $estadoAdicionar == true)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Se adicion� el registro de usuario satisfactoriamente.        </div>';
else if(isset($estadoAdicionar) && $estadoAdicionar == false)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">          Error al adicionar el registro de usuario.        </div>';
/** Validacion de modo consulta detallada*/
if(isset($consultar) && $consultar == "1")
    echo "<script src='/js/usuario.js'></script>";
?><div id='divTituloPrincipal'>
<?php echo $tituloPagina; ?>
    </div><div id="tabs" class="divTabs">
    <ul>
        <li><a href="#tabConsultar" class="limpiarFormulario">Consultar</a></li>
        <li><a href="#tabAdicionar">Adicionar</a></li>
        <li><a href="#tabModificar">
                <?php echo $tituloTab ?>
            </a></li>
    </ul>    <div id="tabConsultar" align="center" style="padding-top: 25px;">
        <table id="table" class="display" cellspacing="0" width="100%">
            <thead class="trTitulo">
            <tr>
                <th></th>
                <th>Nombres</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Grupo de Usuario</th>
                <th>Usuario</th>
                <th>Fecha de �ltimo Ingreso</th>
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
                        if($usuario['perfil'] == "Lector")
                            echo '<td>
                                                <a href="/index.php/controladorUsuario/ConsultarUsuario/'.$registro['id_usuario'].'/1" title="Consultar">
                                                    <img src="/images/buscar.png" width="15" height="15" alt="Consultar"/>
                                                </a>
                                            </td>';
                        else
                        {
                            echo '<td>
                                                <a href="/index.php/controladorUsuario/ConsultarUsuario/'.$registro['id_usuario'].'" title="Modificar">
                                                    <img src="/images/editar.jpg" width="15" height="15"  alt="Editar"/>
                                                </a>                          
                                                <br>
                                                <a href="javascript:;" onclick="Confirmar(\'/index.php/controladorUsuario/EliminarUsuario/'.$registro['id_usuario'].'\'); return false;"  title="Eliminar">
                                                    <img src="/images/eliminar.png" width="15" height="15" alt="Eliminar"/>
                                                </a>
                                            </td>';
                        }
                        echo "<td>".utf8_decode($registro['nombre_apellido'])."</td>";
                        echo "<td>".utf8_decode($registro['correo'])."</th>";
                        echo "<td>".utf8_decode($registro['descripcion_estado'])."</td>";
                        echo "<td>".utf8_decode($registro['nombre_grupo'])."</td>";
                        echo "<td>".utf8_decode($registro['login_usuario'])."</td>";
                        echo "<td>".utf8_decode($registro['fecha_ultimo_ingreso'])."</td>";
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
        <div>
            <div id="divExportarExcel">
                <a href="/index.php/controladorUsuario/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                    <img src="/images/excel.jpg" width="30" height="30" />
                    <br />
                    Exportar a Excel
                </a>
            </div>
            <div id="divExportarPdf">
                <a href="/index.php/controladorUsuario/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                    <img src="/images/pdf.jpg" width="30" height="30" />
                    <br />
                    Exportar a Pdf
                </a>
            </div>
            <div class="clearBoth"></div>
        </div>
    </div>
    <div id="tabAdicionar">        <div id="divConvenio" class="clearfix">            <ul id="sidemenu">                <li>                    <a href="#informacion-content" class="open"><i class="icon-home icon-large"></i>Informaci�n B�sica</a>                </li>            </ul>            <div id="content">                <!--Tab Datos Basicos-->                <div id="informacion-content" class="contentblock">                    <div align="center">                        <fieldset align="center">                          <legend align="left" class="legend">Datos B�sicos</legend>                            <table align="left">                                                                <tr>                                    <td align="left" class="tdFormulario">                                        <label>Nombres y apellidos</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <input type="text" name="txtNombresApellidosAdic" id="txtNombresApellidosAdic" />                                        </div>                                        <div class="campoObligatorio">*</div>                                                                            </td>                                </tr>                                <tr>                                    <td align="left" class="tdFormulario">                                        <label>Correo</label>                                    </td>                                    <td align="left" class="tdFormulario">                                                                                <input type="text" name="txtCorreoAdic" id="txtCorreoAdic"/>                                                                            </td>                                </tr>                                <tr>                                    <td align="left" class="tdFormulario">                                        <label>Grupo Usuario</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <select name="sltGrupoUsuarioAdic" id="sltGrupoUsuarioAdic">                                                <option value=""> Seleccionar </option>                                                  <?php                                                  LlenarSelectOption($grupoUsuario)                                                  ?>                                            </select>                                        </div>                                        <div class="campoObligatorio">*</div>                                                                              </td>                                </tr>                                  <tr>                                    <td align="left" class="tdFormulario">                                        <label>Usuario</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <input type="text" name="txtUsuarioAdic" id="txtUsuarioAdic"/>                                        </div>                                        <div class="campoObligatorio">*</div>                                                                                <div class="clearBoth"></div>                                        <div id="divValUsuario" class="fuenteRoja"></div>                                    </td>                                </tr>                                <tr>                                    <td align="left" class="tdFormulario">                                        <label>Contrase�a</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <input type="password" name="txtPasswordAdic" id="txtPasswordAdic"/>                                        </div>                                        <div class="campoObligatorio">*</div>                                                                            </td>                                </tr>                                <tr>                                    <td align="left" class="tdFormulario">                                        <label>Escribir Contrase�a Nuevamente</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <input type="password" name="txtPasswordRepAdic" id="txtPasswordRepAdic"/>                                        </div>                                        <div class="campoObligatorio">*</div>                                            <div class="clearBoth"></div>                                        <div id="divValContrasenya" class="fuenteRoja"></div>                                    </td>                                </tr>                            </table>                        </fieldset>                    </div>                </div>            </div>        </div>        <div id="divError"></div>      <div class="clearBoth"></div>      <div class="divGuardar">          <button type="submit" class="submit">              <img src="/images/guardar.jpg" width="36" height="36" />              <br/>              Guardar          </button>      </div>    </div>    <div id="tabModificar">        <div id="divConvenioModificar" class="clearfix">            <ul id="sidemenuMod">                <li>                    <a href="#informacion-contentMod" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Usuario</a>                </li>            </ul>            <div id="contentMod">                <!--Tab Datos Basicos-->                <div id="informacion-contentMod" class="contentblock">                    <div align="center">                        <fieldset align="center">                          <legend align="left" class="legend">Datos B�sicos</legend>                            <table align="left">                                                                <tr>                                    <td align="left" class="tdFormulario">                                        <label>Nombres y apellidos</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <input type="text" <?php echo $soloLectura; ?> name="txtNombresApellidos" id="txtNombresApellidos" value="<?php echo utf8_decode($registro['nombre_apellido']) ?>"/>                                            <input type="hidden" <?php echo $soloLectura; ?> name="txtId" id="txtId" value="<?php echo $registro['id_usuario'] ?>"/>                                        </div>                                        <div class="campoObligatorio">*</div>                                                                            </td>                                </tr>                                <tr>                                    <td align="left" class="tdFormulario">                                        <label>Correo</label>                                    </td>                                    <td align="left" class="tdFormulario">                                                                                <input type="text" <?php echo $soloLectura; ?> name="txtCorreo" id="txtCorreo" value="<?php echo $registro['correo'] ?>"/>                                                                            </td>                                </tr>                                <?php                                 if($usuario['perfil'] == "Administracion")                                 {                                ?>                                <tr>                                    <td align="left" class="tdFormulario">                                        <label>Estado</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <select name="sltEstado" id="sltEstado">                                                <option value=""> Seleccionar </option>                                                  <?php                                                  LlenarSelectOption($estados, $registro['estado_codigo'])                                                  ?>                                            </select>                                        </div>                                        <div class="campoObligatorio">*</div>                                                                              </td>                                </tr>                                 <tr>                                    <td align="left" class="tdFormulario">                                        <label>Grupo Usuario</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <select name="sltGrupoUsuario" id="sltGrupoUsuario">                                                <option value=""> Seleccionar </option>                                                  <?php                                                  LlenarSelectOption($grupoUsuario, $registro['grupo_usuario_id_grupo'])                                                  ?>                                            </select>                                        </div>                                        <div class="campoObligatorio">*</div>                                                                              </td>                                </tr>                                  <tr>                                    <td align="left" class="tdFormulario">                                        <label>Usuario</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <input type="text" <?php echo $soloLectura; ?> name="txtUsuario" id="txtUsuario" value="<?php echo $registro['login_usuario'] ?>"/>                                                                                    </div>                                        <div class="campoObligatorio">*</div>                                                                                <div class="clearBoth"></div>                                        <div id="divValUsuarioMod" class="fuenteRoja"></div>                                    </td>                                </tr>                                    <?php                                 }                                                                if($consultar != "1") { ?>                                <tr>                                    <td align="left" class="tdFormulario">                                        <label>Contrase�a</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <input type="password" name="txtPassword" id="txtPassword" value=""/>                                                                                        <?php if($usuario['perfil'] != "Administracion") { ?>                                                <div style='display: none;'>                                                    <input type="hidden" <?php echo $soloLectura; ?> name="txtUsuario" id="txtUsuario" value="<?php echo $registro['login_usuario'] ?>"/>                                                                                                                                                <div id="divValUsuarioMod" class="fuenteRoja"></div>                                                    <select name="sltGrupoUsuario" id="sltGrupoUsuario">                                                        <option value=""> Seleccionar </option>                                                          <?php                                                          LlenarSelectOption($grupoUsuario, $registro['grupo_usuario_id_grupo'])                                                          ?>                                                    </select>                                                    <select name="sltEstado" id="sltEstado">                                                        <option value=""> Seleccionar </option>                                                          <?php                                                          LlenarSelectOption($estados, $registro['estado_codigo'])                                                          ?>                                                    </select>                                                </div>                                            <?php } ?>                                              <input type="hidden" <?php echo $soloLectura; ?> name="txtUsuarioAnt" id="txtUsuarioAnt" value="<?php echo $registro['login_usuario'] ?>"/>                                        </div>                                        <div class="campoObligatorio">*</div>                                                                            </td>                                </tr>                                <tr>                                    <td align="left" class="tdFormulario">                                        <label>Escribir Contrase�a Nuevamente</label>                                    </td>                                    <td align="left" class="tdFormulario">                                        <div class="divControl">                                            <input type="password" name="txtPasswordRep" id="txtPasswordRep" value=""/>                                        </div>                                        <div class="campoObligatorio">*</div>                                            <div class="clearBoth"></div>                                        <div id="divValContrasenyaMod" class="fuenteRoja"></div>                                    </td>                                </tr>                                <?php } ?>                            </table>                                                      <div class='clearBoth'></div>                                                    </fieldset>                    </div>                </div>            </div>        </div>        <div id="divErrorMod"></div>      <div class="clearBoth"></div>      <div class="divGuardar">          <?php          if($tituloTab == 'Consulta')          {          ?>              <a href="/index.php/controladorUsuario">                  <img src="/images/volver.png" width="36" height="36" />                  <br/>                  Regresar              </a>           <?php          }          else          { ?>              <div id="divGuardarMod">                  <button type="submit" class="submit">                      <img src="/images/guardar.jpg" width="36" height="36" />                      <br/>                      Guardar                  </button>              </div>              <div id="divRegresarMod">                  <?php                                        if($usuario['perfil'] != "Administracion")                        echo '<a href="/index.php/controladorInicio">                                  <img src="/images/volver.png" width="36" height="36" />                                  <br/>                                  Regresar                              </a>';                    else                        echo '<a href="/index.php/controladorUsuario">                                              <img src="/images/volver.png" width="36" height="36" />                                  <br/>                                  Regresar                              </a>';                                      ?>                            </div>              <div class="clearBoth"></div>          <?php } ?>      </div>    </div></div><?php FinalDocumento(); ?>