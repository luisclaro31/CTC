<?php 
/*
 * Vista Seccional Por Federacion
 * Excellentiam S.E.
 * Fecha creacion: 10/07/15
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Federaciones Afiliadas a Seccional";
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
  echo form_open('controladorSeccionalFederacion/AdicionarSeccionalFederacion');
  echo "<script src='/js/seccionalFederacion.js'></script>";
}
else
{
  echo form_open('controladorSeccionalFederacion/ModificarSeccionalFederacion');
  echo "<script src='/js/seccionalFederacionModificar.js'></script>";
}

/*
* Mensajes de eliminacion de registros
*/
if(isset($estadoEliminar) && $estadoEliminar == true)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          .
        </div>';
else if(isset($estadoEliminar) && $estadoEliminar == false)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          .
        </div>';
/*
* Mensajes de modificacion de registros
*/
if(isset($estadoModificar) && $estadoModificar == true)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          .
        </div>';
else if(isset($estadoModificar) && $estadoModificar == false)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          .
        </div>';
/*
* Mensajes de adicion de registros
*/
if(isset($estadoAdicionar) && $estadoAdicionar == true)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          .
        </div>';
else if(isset($estadoAdicionar) && $estadoAdicionar == false)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          .
        </div>';
/*
* Validacion de modo consulta detallada
*/
if(isset($consultar) && $consultar == "1")
  echo "<script src='/js/seccionalFederacion.js'></script>";
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
              <td class='td' <?php if($usuario['perfil'] == "Lector Seccional" || $usuario['perfil'] == "Editor Seccional")  echo "id='tdLector'"; else echo "id='tdAdministrador'" ?>></td>     
              <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "RUT Seccional"; else echo '<a style="color: #fff;" href="/index.php/controladorSeccionalFederacion/index/1">RUT Seccional &dArr;</a>' ?></td>            
              <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Nombre Seccional"; else echo '<a style="color: #fff;" href="/index.php/controladorSeccionalFederacion/index/23">Nombre Seccional &dArr;</a>' ?></td>
              <td class='td'>Sigla Seccional</td>              
              <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Estado Seccional"; else echo '<a style="color: #fff;" href="/index.php/controladorSeccionalFederacion/index/10">Estado Sindicato &dArr;</a>' ?></td>              
              <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "RUT Federación"; else echo '<a style="color: #fff;" href="/index.php/controladorSeccionalFederacion/index/52">RUT Federación &dArr;</a>' ?></td>            
              <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Nombre Federación"; else echo '<a style="color: #fff;" href="/index.php/controladorSeccionalFederacion/index/53">Nombre Federación &dArr;</a>' ?></td>
              <td class='td'>Sigla Federación</td>
              <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Estado Federación"; else echo '<a style="color: #fff;" href="/index.php/controladorSeccionalFederacion/index/56">Estado Federación &dArr;</a>' ?></td>                       
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
                        if($usuario['perfil'] == "Administracion" || $usuario['perfil'] == "Editor Seccional" || $usuario['perfil'] == "Lector Seccional")
                            echo '<div class="floatLeft">
                                      <a href="/index.php/controladorFederacion/ConsultarFederacion/'.$registro['rut'].'/1" title="Consultar">
                                          <img src="/images/buscar.png" width="20" height="20" alt="Consultar"/>
                                      </a>
                                  </div>';
                        else if ($usuario['perfil'] == " ")
                        {
                            echo '<div class="divImgEditar">
                                      <a href="/index.php/controladorSeccionalFederacion/ConsultarSeccionalFederacion/'.$registro['rut'].'" title="Modificar">
                                          <img src="/images/editar.jpg" width="20" height="20"  alt="Editar"/>
                                      </a>
                                  </div>';
                        }                            
                        else if ($usuario['perfil'] == " ")
                        {
                            echo '<div class="divImgEditar">
                                      <a href="/index.php/controladorSeccionalFederacion/ConsultarSeccionalFederacion/'.$registro['rut'].'" title="Modificar">
                                          <img src="/images/editar.jpg" width="20" height="20"  alt="Editar"/>
                                      </a>
                                  </div>                                  
                                  <div class="divImgEliminar">
                                      <a href="javascript:;" onclick="Confirmar(\'/index.php/controladorSeccionalFederacion/EliminarSeccionalFederacion/'.$registro['rut'].'\'); return false;"  title="Eliminar">
                                          <img src="/images/eliminar.png" width="20" height="20" alt="Eliminar"/>
                                      </a>
                                  <div>';
                        }                                                    
                        echo "<td class='td'>".$registro['rut_seccional']."</td>";
                        echo "<td class='td'>".utf8_decode($registro['nombre_seccional'])."</td>";
                        echo "<td class='td'>".utf8_decode($registro['siglas_seccional'])."</td>";
                        echo "<td class='td'>".utf8_decode($registro['estado_seccional_descripcion'])."</td>";
                        echo "<td class='td'>".utf8_decode($registro['rut'])."</td>";
                        echo "<td class='td'>".utf8_decode($registro['nombre_federacion'])."</td>";
                        echo "<td class='td'>".utf8_decode($registro['siglas_federacion'])."</td>";
                        echo "<td class='td'>".utf8_decode($registro['estado_federacion_descripcion'])."</td>
                            </tr>";
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
        <?php
        if($usuario['perfil'] == "Administracion")                     
             echo "<div id='divPaginado'>".$paginacion."</div>";            
        ?>
      <div id="divExportarFormatos">
          <div id="divExportarExcel">
              <a href="/index.php/controladorSeccionalFederacion/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                  <img src="/images/excel.jpg" width="30" height="30" />
                  <br />
                  Exportar a Excel
              </a>
          </div>
          <div id="divExportarPdf">
              <a href="/index.php/controladorSeccionalFederacion/GenerarPdf" target="_blank" title="Exportar a formato PDF">
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
                  <a href="#informacion-content" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Empresa</a>
              </li>
              <li>
                  <a href="#about-content"><i class="icon-info-sign icon-large"></i>Informaci&oacute;n Administrativa Empresa</a>
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
                                      <label>Rut</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div>
                                          <div class="divControl">
                                              <input type="text" id="txtRutAdic" name="txtRutAdic" />                                              
                                          </div>
                                          <div class="campoObligatorio">*</div>
                                          <div class="clearBoth"></div>
                                          <div id="divRutVal" class="fuenteRoja"></div>
                                      </div>
                                  <td align="left" class="tdFormulario">
                                      <div>
                                          <div class="divControl">
                                              <input type="text" name="txtDigitoVerificacionAdic" id="txtDigitoVerificacionAdic" placeholder ="DV" class="inputdigito" />
                                          </div>
                                          <div class="campoObligatorio">*</div>
                                      </div>
                                  </td>                                                                        
                              </tr>
                              <tr>
                                  <td align="left" class="tdMiddle">
                                      <label>Nombre Empresa</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div>
                                          <div class="divControl">
                                              <input type="text" name="txtNombreEmpresaAdic" id="txtNombreEmpresaAdic" onkeyup = "this.value=this.value.toUpperCase()" />
                                          </div>
                                          <div class="campoObligatorio">*</div>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdMiddle">
                                      <label>Sigla</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtSiglaAdic" onkeyup = "this.value=this.value.toUpperCase()" />
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
                                    <div class="divControl">
                                        <select name="sltMunicipioAdic" id="sltMunicipioAdic">
                                        </select>
                                    </div>
                                    <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdMiddle">
                                      <label>Dirección</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtDireccionAdic"/>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdMiddle">
                                      <label>Teléfonos</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtTelefonoAdic"  id="txtTelefonoAdic"/>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdMiddle">
                                      <label>Correo Electrónico</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtCorreoAdic" />
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdMiddle">
                                      <label>Página Web</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtPaginaWebAdic" />
                                  </td>
                              </tr>
                          </table>
                      </fieldset>
                  </div>
              </div>
              <!--Tab Información Administrativa-->
              <div id="about-content" class="contentblock hidden">
                  <div align="center">
                      <fieldset align="center">
                          <legend align="left" class="legend"></legend>
                          <table align="left" width="700px" >
                              <tr>
                                  <td align="left">
                                      <label>Grupo Económico</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltGrupoEconomAdic" id="sltGrupoEconomAdic" >
                                              <option value=""> Seleccionar </option>
                                              <?php
                                              LlenarSelectOption($grupoEconoEmpr)
                                              ?>
                                          </select>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Empresa Según Origen del Capital</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltEmpresaSegOriCapAdic" id="sltEmpresaSegOriCapAdic">
                                              <option value=""> Seleccionar </option>
                                              <?php
                                                 LlenarSelectOption($empresaSegOriCap)
                                              ?>
                                          </select>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left">
                                      <label>Empresa Según Capital</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltEmpresaSegCapAdic" id="sltEmpresaSegCapAdic">
                                              <option value=""> Seleccionar </option>
                                              <?php
                                              LlenarSelectOption($empresaSegCap)
                                              ?>
                                          </select>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Tipo de Empresa Estatal</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltEmpresaTipEstAdic" id="sltEmpresaTipEstAdic">
                                              <option value=""> Seleccionar </option>
                                              <?php
                                              LlenarSelectOption($empresaTipEst)
                                              ?>
                                          </select>
                                      </div>                                      
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Número de Trabajadores de la Empresa</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <input type="text" name="txtNumeroTrabajaEmprAdic" id="txtNumeroTrabajaEmprAdic" />
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Número de Afiliados al Sindicato</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <input type="text" name="txtNumeroAfiliadosSindicatoAdic" id="txtNumeroAfiliadosSindicatoAdic" />
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>                              
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Clase de Contrato</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <label>Directos</label>                                        
                                        <br/>                                                            
                                        <input type="checkbox" class="check"name="chkFijoAdic" id="chkFijoAdic" value="FIJO">Fijo
                                        <br/>                    
                                        <input type="checkbox" class="check"name="chkIndefinidoAdic" id="chkIndefinidoAdic" value="INDEFINIDOCONTRATO">Indefinido
                                        <br/>                            
                                        <input type="checkbox" class="check"name="chkPrestacionServiciosAdic" id="chkPrestacionServiciosAdic" value="PRESTACIONSERVICIO">Prestación de Servicios
                                    </td>
                                    <td align="left" class="tdFormulario" >
                                        <label>Tercereados</label>                                        
                                        <br/>                                                            
                                        <input type="checkbox" class="check"name="chkCooperativatrabajoAdic" id="chkCooperativatrabajoAdic" value="COOPERATIVATRABAJO">Cooperativa de trabajo
                                        <br/>                    
                                        <input type="checkbox" class="check"name="chkEmpresaTemporalSasAdic" id="chkEmpresaTemporalSasAdic" value="EMPRESATEMPORALSAS">Empresa Temporal SAS                                        
                                    </td>                                    
                                </tr>                                                                                            
                              <tr>
                                  <td align="left" class="tdMiddle">
                                      <label>Observaciones</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <textarea rows="7" cols="45" name="txtObservacionesAdic"></textarea>
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
                  <a href="#informacion-contentMod" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Empresa</a>
              </li>
              <li>
                  <a href="#about-contentMod"><i class="icon-info-sign icon-large"></i>Informaci&oacute;n Administrativa Empresa</a>
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
                                      <label>Rut</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl" style="display: none;">
                                          <input type="text" name="txtRut" id="txtRut" <?php echo $soloLectura; ?> value="<?php echo $registro["rut"] ?>"/>
                                          <div class="campoObligatorio">*</div>
                                      </div>
                                      <label><?php echo $registro["rut"] ?></label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl" style="display: none;">
                                          <input type="text" name="txtDigitoVerificacion" id="txtDigitoVerificacion"  <?php echo $soloLectura; ?> value="<?php echo $registro["digito_verificacion"] ?>"/>
                                          <div class="campoObligatorio">*</div>
                                      </div>
                                      <label><?php echo $registro["digito_verificacion"] ?></label>
                                  </td>                                  
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Nombre Empresa</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <input type="text" name="txtNombreEmpresa" id="txtNombreEmpresa" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> value="<?php echo $registro["nombre"] ?>"/>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Sigla</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtSigla" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> value="<?php echo $registro["sigla"] ?>"/>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Departamento</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltCodDepartamento" id="sltCodDepartamento">
                                              <option value=""> Seleccionar </option>
                                               <?php
                                               LlenarSelectOption($departamentos, $registro["descripcion"])
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
                                          <select name="sltCodMunicipio" id="sltCodMunicipio">
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
                                      <label>Dirección</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtDireccion" <?php echo $soloLectura; ?> value="<?php echo $registro["direccion"]?>"/>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Teléfonos</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtTelefono" id="txtTelefono" <?php echo $soloLectura; ?> value="<?php echo $registro["telefonos"]?>"/>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Correo Electrónico</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtCorreo" <?php echo $soloLectura; ?> value="<?php echo $registro["correo"]?>"/>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Página Web</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <input type="text" name="txtPaginaWeb" <?php echo $soloLectura; ?> value="<?php echo $registro["pagina_web"]?>"/>
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
                          <table align="left" width="700px">
                              <tr>
                                  <td align="left">
                                      <label>Grupo Económico</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltGrupoEconom" id="sltGrupoEconom">
                                              <option value=""> Seleccionar </option>
                                              <?php
                                              LlenarSelectOption($grupoEconoEmpr, $registro["grupo_economico_codigo"])
                                              ?>
                                          </select>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Empresa Según Origen del Capital</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltEmpresaSegOriCap" id="sltEmpresaSegOriCap">
                                              <option value=""> Seleccionar </option>
                                              <?php
                                              LlenarSelectOption($empresaSegOriCap, $registro["capital_extranjero_codigo"])
                                              ?>
                                          </select>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Empresa según capital</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltEmpresaSegCap" id="sltEmpresaSegCap">
                                              <option value=""> Seleccionar </option>
                                              <?php
                                                  LlenarSelectOption($empresaSegCap, $registro["tipo_empresa_segun_capital_codigo"])
                                              ?>
                                          </select>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Tipo de Empresa Estatal</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <div class="divControl">
                                          <select name="sltEmpresaTipEst" id="sltEmpresaTipEst">
                                              <option value=""> Seleccionar </option>
                                              <?php
                                              LlenarSelectOption($empresaTipEst, $registro["tipo_empresa_estatal_codigo"])
                                              ?>
                                          </select>
                                      </div>                                      
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Número de Trabajadores de la Empresa</label>
                                  </td>
                                  <td align="left">
                                      <div class="divControl">
                                          <input type="text" name="txtNumeroTrabajaEmpr" id="txtNumeroResolucion" <?php echo $soloLectura; ?> value="<?php echo $registro["numero_trabajadores_empresa"]; ?>"/>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="left" class="tdFormulario">
                                      <label>Número de Afiliados al Sindicato</label>
                                  </td>
                                  <td align="left">
                                      <div class="divControl">
                                          <input type="text" name="txtNumeroAfiliadosSindicato" id="txtNumeroAfiliadosSindicatoAdic" <?php echo $soloLectura; ?> value="<?php echo $registro["numero_afiliados_sindicato"]; ?>"/>
                                      </div>
                                      <div class="campoObligatorio">*</div>
                                  </td>
                              </tr>                              
                                <tr>                           
                                    <td align="left" class="tdMiddle">      
                                        <label>Clase de Contrato</label>               
                                    </td>                              
                                    <td align="left" class="tdFormulario">    
                                        <?php
                                        $chkFijo = '';
                                        $chkIndefinido = '';
                                        $chkPrestacionServicios = '';
                                        
                                        if(count($claseContrato) > 0)
                                        {                                            
                                            foreach ($claseContrato as $contrato)
                                            {                                                
                                                if($contrato['clase_contrato_codigo'] == 'FIJO')
                                                    $chkFijo = 'checked';
                                                
                                                if($contrato['clase_contrato_codigo'] == 'INDEFINIDOCONTRATO')
                                                    $chkIndefinido = 'checked';
                                                
                                                if($contrato['clase_contrato_codigo'] == 'PRESTACIONSERVICIO')
                                                    $chkPrestacionServicios = 'checked';

                                            }
                                        }
                                        ?>
                                        <label>Directos</label>                                        
                                        <br/>                                                                                                    
                                        <input type="checkbox" class="check" name="chkFijo" id='chkFijo' value="FIJO" <?php echo $chkFijo ?>>Fijo
                                        <br/>
                                        <input type="checkbox" class="check" name="chkIndefinido" id='chkIndefinido' value="INDEFINIDOCONTRATO" <?php echo $chkIndefinido ?>>Indefinido
                                        <br/>
                                        <input type="checkbox" class="check" name="chkPrestacionServicios" id='chkPrestacionServicios' value="PRESTACIONSERVICIO" <?php echo $chkPrestacionServicios ?>>Prestación de Servicios
                                    </td>                       
                                    <td align="left" class="tdFormulario">    
                                        <?php
                                        $chkCooperativatrabajo = '';
                                        $chkEmpresaTemporalSas = '';                                        
                                        
                                        if(count($claseContrato) > 0)
                                        {                                            
                                            foreach ($claseContrato as $contrato)
                                            {                                                
                                                if($contrato['clase_contrato_codigo'] == 'COOPERATIVATRABAJO')
                                                    $chkCooperativatrabajo = 'checked';
                                                
                                                if($contrato['clase_contrato_codigo'] == 'EMPRESATEMPORALSAS')
                                                    $chkEmpresaTemporalSas = 'checked';

                                            }
                                        }
                                        ?>
                                        <label>Tercereados</label>
                                        <br/>                                                                                                    
                                        <input type="checkbox" class="check" name="chkCooperativatrabajo" id='chkCooperativatrabajo' value="COOPERATIVATRABAJO" <?php echo $chkCooperativatrabajo ?>>Cooperativa de trabajo
                                        <br/>
                                        <input type="checkbox" class="check" name="chkEmpresaTemporalSas" id='chkEmpresaTemporalSas' value="EMPRESATEMPORALSAS" <?php echo $chkEmpresaTemporalSas ?>>Empresa Temporal SAS                                        
                                    </td>                                                           
                                </tr>
                              <tr>
                                  <td align="left" class="tdMiddle">
                                      <label>Observaciones</label>
                                  </td>
                                  <td align="left" class="tdFormulario">
                                      <textarea rows="7" cols="45" <?php echo $soloLectura; ?> name="txtObservaciones"><?php echo $registro["observaciones"]?></textarea>
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
              <a href="/index.php/controladorEmpresa">
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
              <a href="/index.php/controladorEmpresa">
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