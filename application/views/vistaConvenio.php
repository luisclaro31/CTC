<?php 
/*
 * Vista Convenios Colectivos
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Gestión Convenios Colectivos";
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
  echo form_open('controladorConvenioColectivo/AdicionarConvenio');
  echo "<script src='/js/convenioAdicionar.js'></script>";
}
else
{
  echo form_open('controladorConvenioColectivo/ModificarConvenio');
  echo "<script src='/js/convenioModificar.js'></script>";
}

/*
* Mensajes de eliminacion de registros
*/
if(isset($estadoEliminar) && $estadoEliminar == true)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Se elimino satisfactoriamente el registro de convenio.
        </div>';
else if(isset($estadoEliminar) && $estadoEliminar == false)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Ocurrio un problema al eliminar el registro de convenio.
        </div>';
/*
* Mensajes de modificacion de registros
*/
if(isset($estadoModificar) && $estadoModificar == true)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Se actualizo el registro de empresa satisfactoriamente.
        </div>';
else if(isset($estadoModificar) && $estadoModificar == false)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Error al actualizar el registro de empresa.
        </div>';
/*
* Mensajes de adicion de registros
*/
if(isset($estadoAdicionar) && $estadoAdicionar == true)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Se adicionó el registro de empresa satisfactoriamente.
        </div>';
else if(isset($estadoAdicionar) && $estadoAdicionar == false)
  echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Error al adicionar el registro de empresa.
        </div>';
/*
* Validacion de modo consulta detallada
*/
if(isset($consultar) && $consultar == "1")
  echo "<script src='/js/convenio.js'></script>";

if($usuario['perfil'] == 'Lector Sindicato')
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
    <div id="tabConsultar" align="center" style="padding-top: 25px;">
        <table cellpadding="5" align="center" cellspacing="3" class="td">
            <tr class="trTitulo">
                <td class='td' <?php if($usuario['perfil'] == "Lector Sindicato") echo "id='tdLector'"; else echo "id='tdAdministrador'" ?>></td>                
                <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Empresa con la cual se firma el convenio"; else echo '<a style="color: #fff;" href="/index.php/controladorConvenioColectivo/index/26">Empresa con la cual se firma el convenio &dArr;</a>' ?></td>                
                <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Fecha Inicio convenio"; else echo '<a style="color: #fff;" href="/index.php/controladorConvenioColectivo/index/10">Fecha Inicio convenio &dArr;</a>' ?></td>                
                <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Fecha finalización convenio"; else echo '<a style="color: #fff;" href="/index.php/controladorConvenioColectivo/index/11">Fecha finalización convenio &dArr;</a>' ?></td>                
                <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Departamento Sede Empresa"; else echo '<a style="color: #fff;" href="/index.php/controladorConvenioColectivo/index/30">Departamento Sede Empresa &dArr;</a>' ?></td>                
                <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Municipio Sede Empresa"; else echo '<a style="color: #fff;" href="/index.php/controladorConvenioColectivo/index/29">Municipio Sede Empresa &dArr;</a>' ?></td>
                <td class='td'>Teléfono Sede Empresa</td>
                <td class='td'>Año Creación</td>
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
                            if($registro['fecha_inicio_convenio'] != '0000-00-00')
                                $fechaInicioCont = $registro['fecha_inicio_convenio'];
                            else
                                $fechaInicioCont = '';

                            if($registro['fecha_finalizacion_convenio'] != '0000-00-00')
                                $fechaFinCont = $registro['fecha_finalizacion_convenio'];
                            else
                                $fechaFinCont = '';

                            echo '<tr class="trDatos" style="background-color: '.$color.';">
                                      <td class="td" align="center">';
                            if($usuario['perfil'] == "Lector Sindicato")
                                    echo '<div class="floatLeft">
                                              <a href="/index.php/controladorConvenioColectivo/ConsultarConvenio/'.$registro['id_convenio_colectivo'].'/1" title="Consultar">
                                                  <img src="/images/buscar.png" width="20" height="20" alt="Consultar"/>
                                              </a>
                                          </div>';
                            else if($usuario['perfil'] == "Editor Sindicato")
                            {
                                    echo '<div class="divImgEditar">
                                              <a href="/index.php/controladorConvenioColectivo/ConsultarConvenio/'.$registro['id_convenio_colectivo'].'" title="Modificar">
                                                  <img src="/images/editar.jpg" width="20" height="20"  alt="Editar"/>
                                              </a>
                                          </div>';
                            }
                            else
                            {
                                    echo '<div class="divImgEditar">
                                              <a href="/index.php/controladorConvenioColectivo/ConsultarConvenio/'.$registro['id_convenio_colectivo'].'" title="Modificar">
                                                  <img src="/images/editar.jpg" width="20" height="20"  alt="Editar"/>
                                              </a>
                                          </div>
                                          <div class="divImgEliminar">
                                              <a href="javascript:;" onclick="Confirmar(\'/index.php/controladorConvenioColectivo/EliminarConvenio/'.$registro['id_convenio_colectivo'].'\'); return false;"  title="Eliminar">
                                                  <img src="/images/eliminar.png" width="20" height="20" alt="Eliminar"/>
                                              </a>
                                          <div>';
                            }                            
                            echo "</td>";
                            echo "<td class='td'>".utf8_decode($registro['empresa_nombre'])."</td>";
                            echo "<td class='td'>".utf8_decode($fechaInicioCont)."</td>";
                            echo "<td class='td'>".utf8_decode($fechaFinCont)."</td>";
                            echo "<td class='td'>".utf8_decode($registro['departamento'])."</td>";
                            echo "<td class='td'>".utf8_decode($registro['municipio'])."</td>";
                            echo "<td class='td'>".utf8_decode($registro['telefonos'])."</td>";
                            echo "<td class='td'>".utf8_decode($registro['anyo_creacion'])."</td>
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
              <a href="/index.php/controladorConvenioColectivo/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                  <img src="/images/excel.jpg" width="30" height="30" />
                  <br />
                  Exportar a Excel
              </a>
          </div>
          <div id="divExportarPdf">
              <a href="/index.php/controladorConvenioColectivo/GenerarPdf" target="_blank" title="Exportar a formato PDF">
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
                    <a href="#informacion-content" class="open"><i class="icon-home icon-large"></i>Información Convenio</a>
                </li>
                <li>
                    <a href="#about-content"><i class="icon-info-sign icon-large"></i>Descripción del Convenio Colectivo</a>
                </li>
                <li>
                    <a href="#ideas-content"><i class="icon-lightbulb icon-large"></i>Otros Datos Convenio Colectivo</a>
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
                                    <td align="left" class="tdFormulario">
                                        <label>Empresa con la Cual se Firma el Convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltEmpresaFirmaConvenioAdic" id='sltEmpresaFirmaConvenioAdic'>
                                                <option value=" "> Seleccionar </option>
                                                  <?php
                                                  LlenarSelectOption($empresaFirmaConvenio)
                                                  ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>
                                </tr>                                  
                            </table>
                            <div class='clearBoth'></div>
                            <div id='divInformacionEmpresa'></div>
                        </fieldset>
                    </div>
                </div>
                <div id="about-content" class="contentblock hidden">
                    <div align="center">
                        <fieldset align="center">
                          <legend align="left" class="legend"></legend>
                            <table align="left" >
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Tipo Convenio Colectivo o Acuerdo laboral estatal</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltConvenioAcuerdoLaboEstatalAdic" id="sltConvenioAcuerdoLaboEstatalAdic">
                                                <option value=""> Seleccionar </option>
                                                  <?php
                                                  LlenarSelectOption($convenioAcuerdoLaboEstatal)
                                                  ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                          
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Fecha Inicio Convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <input type="text" class="fechas" id="datepicker" name="txtFechaInicioConvenioAdic" id="txtFechaInicioConvenioAdic" />                                            
                                        </div>
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Fecha finalización convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <input type="text" id="datepickerMayor" name="txtFechaFinalizConvenioAdic" id="txtFechaFinalizConvenioAdic"/>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Tiempo de Vigencia del Convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtTiemVigenConvenioAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Departamento de Firma Convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltDepartamentoAdic" id="sltDepartamentoAdic">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                    LlenarSelectOption($departamentos)
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Municipio de Firma Convenio</label>
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
                                    <td align="left" class="tdFormulario">
                                        <label>Numero Trabajadores Beneficiados</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtNumeroTrabaBenefiAdic"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Número Trabajadores no Beneficiados con el convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtNumeroTrabaNoBenefiAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Periodo Firma Convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltPeriodoFirmaConvenAdic" id="sltPeriodoFirmaConvenAdic">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                   LlenarSelectOption($periodoFirmaConven)
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Cual Otro Período de Firma</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtCualOtroPeriodoFirmaAdic" id="txtCualOtroPeriodoFirmaAdic"/>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                </div>
                <div id="ideas-content" class="contentblock hidden">
                    <div align="center">
                        <fieldset align="center">
                          <legend align="left" class="legend"></legend>
                            <table align="left">
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Fecha Convocatoria Tribunal de Arbitramento</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" class="fechas" id="datepicker3" name="txtFechaConvocaTribArbiAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Fecha Resolución Tribunal de Arbitramento</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" class="fechas" id="datepicker4" name="txtFechaResolTribArbiAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Meses de Duración Tribunal de Arbitramento</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtMesesDuracTribuArbitraAdic"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Prorroga Convenio Colectivo</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="radio" class="radio" name="rdbProrrConvColecAdic" value="1">Si
                                        <br/>
                                        <input type="radio" class="radio" name="rdbProrrConvColecAdic" value="0" checked>No
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Dirección Territorial</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltDireccTerriAdic" id="sltDireccTerriAdic">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($direccTerri)
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Inspección de Trabajo</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtInspeTrabaAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <label>Modalidad de Incremento Salarial</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltModaliIncremSalarialAdic" id="sltModaliIncremSalarialAdic">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($modaliIncremSalarial)
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                         
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Cuál ?</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtIndiqModaliIncreAdic" id="txtIndiqModaliIncreAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Valor del Incremento para la Modalidad por Años de Vigencia</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtValorIncreModaAnyoVigenciaAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Auxilio Convencional para la Central</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="radio" class="radio" name="rdbAuxConvenCentralAdic" value="1">Si
                                        <br/>
                                        <input type="radio" class="radio" name="rdbAuxConvenCentralAdic" value="0" checked>No
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Monto o Cuantía del Auxilio para la Central</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtMontoCuantiAuxCentrAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Estado de Pago Auxilio Convencional</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltEstaPagoAuxConvAdic" id="sltEstaPagoAuxConvAdic">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($estaPagoAuxConv)
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                          
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label><pre>Según el Número de Artículos Negociados para los Temas </pre>
                                        <pre>que se Reseñan Calcule el % Sobre el Total de Artículos</pre>
                                        <pre>de la Convención Colectiva o  Acuerdo laboral</pre></label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltPorcAcuerLaboralAdic" id="sltPorcAcuerLaboralAdic">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($prcAcuerLaboral)
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                         
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Cuales ?</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtOtroPorcAcuerLaboralAdic" id="txtOtroPorcAcuerLaboralAdic"/>
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
                    <a href="#informacion-contentMod" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Convenio</a>
                </li>
                <li>
                    <a href="#about-contentMod"><i class="icon-info-sign icon-large"></i>Descripci&oacute;n Convenio Colectivo</a>
                </li>
                <li>
                    <a href="#ideas-contentMod"><i class="icon-lightbulb icon-large"></i>Otros Datos Convenio Colectivo</a>
                </li>
            </ul>
            <div id="contentMod">
                <!--Tab Datos Basicos-->
                <div id="informacion-contentMod" class="contentblock">
                    <div align="center">
                        <fieldset align="center">
                          <legend align="left" class="legend">Datos Básicos</legend>
                            <table align="left">                                
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Empresa con la Cual se Firma el Convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltEmpresaFirmaConvenio" id="sltEmpresaFirmaConvenio"  >
                                                <option value=" "> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($empresaFirmaConvenio, $registro["empresa_rut"])
                                                ?>
                                            </select>
                                            <input type="hidden" name="idConvenio" value="<?php echo $registro["id_convenio_colectivo"]?>" />
                                            <input type="hidden" name="anyo" value="<?php echo $registro["anyo"]?>" />
                                        </div>
                                        <div class="campoObligatorio">*</div> 
                                    </td>
                                </tr>                                
                            </table>                          
                            <div class='clearBoth'></div>
                            <div id='divInformacionEmpresaMod'></div>
                        </fieldset>
                    </div>
                </div>
                <div id="about-contentMod" class="contentblock hidden">
                    <div align="center">
                       <fieldset align="center">
                          <legend align="left" class="legend"></legend>
                            <table align="left" >
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Tipo convenio colectivo o Acuerdo laboral estatal</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltConvenioAcuerdoLaboEstatal" id="sltConvenioAcuerdoLaboEstatal">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($convenioAcuerdoLaboEstatal, $registro["tipo_convenio_colectivo_codigo"])
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                         
                                    </td>
                                <tr>
                                    <td align="left">
                                        <label>Fecha Inicio Convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" <?php if($consultar != "1") echo 'id="datepicker6"' ?> name="txtFechaInicioConvenio" <?php echo $soloLectura; ?> value="<?php if($registro["fecha_inicio_convenio"] != "0000-00-00") echo $registro["fecha_inicio_convenio"]?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <label>Fecha Finalización Convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" <?php if($consultar != "1") echo 'id="datepickerMayor2"' ?> name="txtFechaFinalizConvenio" <?php echo $soloLectura; ?> value="<?php if($registro["fecha_finalizacion_convenio"] != "0000-00-00") echo $registro["fecha_finalizacion_convenio"]?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        Tiempo de Vigencia del Convenio
                                    </td>
                                    <td align="left">
                                        <input type="text" name="txtTiemVigenConvenio" <?php echo $soloLectura; ?> value="<?php echo $registro["tiempo_existencina_convenio"]?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Departamento de firma convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltCodDepartamento" id="sltCodDepartamento" >
                                                <option value=""> Seleccionar </option>
                                                 <?php
                                                 LlenarSelectOption($departamentos, $registro["departamento_codigo"])
                                                 ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                         
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Municipio de firma convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltCodMunicipio" id="sltCodMunicipio" >
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($municipios, $registro["municipio_firma_convenio_codigo"])
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                           
                                    </td>
                                </tr>                                
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Numero Trabajadores Beneficiados</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtNumeroTrabaBenefi" <?php echo $soloLectura; ?> value="<?php echo $registro["numero_trabajadores_beneficiado"]?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Número trabajadores no Beneficiados con el Convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtNumeroTrabaNoBenefi" <?php echo $soloLectura; ?> value="<?php echo $registro["numero_trabajadores_no_beneficiado"]?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Periodo firma convenio</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltPeriodoFirmaConven" id="sltPeriodoFirmaConven" >
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                    LlenarSelectOption($periodoFirmaConven, $registro["periodo_firma_codigo"])
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                         <label>Cual Otro Período de Firma</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtCualOtroPeriodoFirma" id="txtCualOtroPeriodoFirma" <?php echo $soloLectura; ?> value="<?php echo utf8_decode($registro["otro_periodo_firma"]) ?>" />
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                </div>
                <div id="ideas-contentMod" class="contentblock hidden">
                    <div align="center">
                        <fieldset align="center">
                          <legend align="left" class="legend"></legend>
                            <table align="left" >
                                <tr>
                                    <td align="left">
                                        <label>Fecha Convocatoria Tribunal de Arbitramento</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" <?php if($consultar != "1") echo 'id="datepicker7"' ?> name="txtFechaConvocaTribArbi" <?php echo $soloLectura; ?> value="<?php if($registro["fecha_convocada_tribunal_arbitramento"] != "0000-00-00") echo $registro["fecha_convocada_tribunal_arbitramento"]?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <label>Fecha Resolución Tribunal de Arbitramento</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" <?php if($consultar != "1") echo 'id="datepicker8"' ?> name="txtFechaResolTribArbiArbi" <?php echo $soloLectura; ?> value="<?php if($registro["fecha_resolucion_tribunal_arbitramento"] != "0000-00-00") echo $registro["fecha_resolucion_tribunal_arbitramento"]?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                       <label> Meses de Duración  Tribunal de Arbitramento</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtMesesDuracTribuArbitra" <?php echo $soloLectura; ?> value="<?php echo $registro["meses_duracion_tribunal"]?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Prorroga convenio colectivo</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="radio" class="radio" name="rdbProrrConvColec" value="1" <?php if($registro["prorroga_convenio_colectivo"] == "1") echo "checked"; ?>>Si
                                        <br/>
                                        <input type="radio" class="radio" name="rdbProrrConvColec" value="0" <?php if($registro["prorroga_convenio_colectivo"] == "0") echo "checked"; ?>>No
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Dirección Territorial</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltDireccTerri" id="sltDireccTerri" >
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                    LlenarSelectOption($direccTerri, $registro["direccion_territorial_codigo"])
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                           
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Inspección de Trabajo</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtInspeTraba" <?php echo $soloLectura; ?> value="<?php echo utf8_decode($registro["inspeccion_trabajo"]) ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Modalidad de Incremento Salarial</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltModaliIncremSalarial" id="sltModaliIncremSalarial" >
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                    LlenarSelectOption($modaliIncremSalarial, $registro["incremento_salarial_codigo"])
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                         
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Cuál ?</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtIndiqModaliIncre" id="txtIndiqModaliIncre" <?php echo $soloLectura; ?> value="<?php echo utf8_decode($registro["otra_modalidad_incremento"]) ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Valor del Incremento para la Modalidad por Años de Vigencia</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtValorIncreModaAnyoVigencia" <?php echo $soloLectura; ?> value="<?php echo $registro["valor_incremento"]?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Auxilio Convencional Para la Central</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="radio" class="radio" name="rdbAuxConvenCentral" value="1" <?php if($registro["auxilio_convencional_central"] == "1") echo "checked"; ?>>Si
                                        <br/>
                                        <input type="radio" class="radio" name="rdbAuxConvenCentral" value="0" <?php if($registro["auxilio_convencional_central"] == "0") echo "checked"; ?>>No
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Monto o Cuantía del Auxilio para la Central</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtMontoCuantiAuxCentr" <?php echo $soloLectura; ?> value="<?php echo $registro["valor_auxilio"]?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Estado de Pago Auxilio Convencional</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltEstaPagoAuxConv" id="sltEstaPagoAuxConv" >
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                    LlenarSelectOption($estaPagoAuxConv, $registro["estado_pago_auxilio_convencional_codigo"])
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>                                         
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label><pre>Según el Número de Artículos Negociados para los Temas </pre>
                                        <pre>que se Reseñan Calcule el % Sobre el Total de Artículos</pre>
                                        <pre>de la Convención Colectiva o  Acuerdo laboral</pre></label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltPorcAcuerLaboral" id="sltPorcAcuerLaboral" >
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                    LlenarSelectOption($prcAcuerLaboral, $registro["porcentaje_articulos_convenio_codigo"])
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>  
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Cuales ?</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" id="txtOtroPorcAcuerLaboral" name="txtOtroPorcAcuerLaboral" <?php echo $soloLectura; ?> value="<?php echo $registro["otro_valor_auxilio"]?>" />
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
              <a href="/index.php/controladorConvenioColectivo">
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
              <a href="/index.php/controladorConvenioColectivo">
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