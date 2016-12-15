<?php 
/*
 * Vista Federaciones
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Gestión Reportes";
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

echo form_open('controladorReporte/GenerarReporte');
echo "<script src='/js/reporteGenerar.js'></script>";
?>

<div id='divTituloPrincipal'>
  <?php echo $tituloPagina; ?>
</div>

<div id="tabs" class="divTabs">
    <div style="margin-left: 34%;margin-top: 20px;margin-bottom: 20px;">
        <table>
        <?php if ( $usuario['perfil'] == "Administracion")
        {
        ?>    
            <tr class="trTitulo">
                <td colspan="3">Reportes Personalizados</td>
            </tr>
            <tr class="trTitulo">
                <td class="tdAmpliadoConsulta">Parámetros</td>
            </tr>
            <tr>
                <td style="border: 1px solid #111;vertical-align: middle;">
                    <table style="width: 370px;margin-top: 20px;">
                        <tr>
                            <td>
                                <div style="margin-left: 10px;">
                                    <label>Tabla</label>
                                </div>                                
                            </td>
                            <td>
                                <div style="margin-left: 10px;margin-bottom: 8px;">
                                   <div class="divControl">
                                        <select name="sltTabla" id="sltTabla">
                                           <option value=""> Seleccionar </option>                                        
                                              <?php                                                                                        
                                                 LlenarSelectOption($tablas)                                         
                                               ?>                                   
                                        </select>
                                   </div>
                                   <div class="campoObligatorio">*</div>
                                </div>                                
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin-left: 10px;">
                                    <label>Ordernar Por</label>
                                </div>                                
                            </td>
                            <td>
                                <div style="margin-left: 10px;margin-bottom: 8px;">
                                    <div class="divControl">
                                        <select name="sltOrdernarPor" id="sltOrdernarPor">                                        
                                            <option value=""> Seleccionar </option>
                                        </select>
                                    </div>                                    
                                </div>                                
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin-left: 10px;">
                                    <label>Agrupar Por</label>
                                </div>                                
                            </td>
                            <td>
                                <div style="margin-left: 10px;margin-bottom: 8px;">
                                    <div class="divControl">
                                        <select name="sltAgruparPor" id="sltAgruparPor">                                        
                                            <option value=""> Seleccionar </option>
                                        </select>
                                    </div>                                    
                                </div>                                
                            </td>
                        </tr>       
                        <tr class="trTitulo">
                            <td colspan="3">Condiciones de selección</td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin-left: 10px;margin-top: 15px;">
                                    <label>Campo</label>
                                </div>                                
                            </td>
                            <td>
                                <div style="margin-left: 10px;margin-bottom: 8px;">
                                    <select name="sltCampo" id="sltCampo">                                               
                                        <option value=""> Seleccionar </option>
                                    </select>        
                                </div>                                
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin-left: 10px;">
                                    <label>Operador</label>
                                </div>                                
                            </td>
                            <td>
                                <div style="margin-left: 10px;margin-bottom: 8px;">
                                    <select name="sltOperador" id="sltOperador">
                                        <option value=""> Seleccionar </option>
                                         <?php                                                                                        
                                            LlenarSelectOption($operador)                                         
                                          ?>                                                                                                                   
                                    </select>
                                </div>                                
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin-left: 10px;">
                                    <label>Condición</label>
                                </div>                                
                            </td>
                            <td>
                                <div style="margin-left: 10px;margin-bottom: 8px;">
                                    <input type="text" name="txtCondicion"/>
                                </div>                                
                            </td>
                        </tr>                        
                    </table>
                    <div class="divGuardar">
                    <button type="submit" class="submit">
                        <img src="/images/excel.jpg" width="36" height="36" />
                        <br/>
                        Generar Reporte
                    </button>                    
                    </div>   
                    <br/>
                </td>
<!--                <td class='td' style="vertical-align: middle;">
                    <a href="/index.php/controladorSindicato/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                        <img src="/images/excel.jpg" width="30" height="30" />
                    </a>
                </td>
                <td class='td' style="vertical-align: middle;">
                    <a href="/index.php/controladorSindicato/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                        <img src="/images/pdf.jpg" width="30" height="30" />
                    </a>
                </td>-->
            </tr>        
        <?php
        } 
        ?>            

        </table>
        
    </div>    
    <div style="margin-left: 0%;margin-top: 20px;margin-bottom: 20px;">
        <table align="center">
            <tr class="trTitulo">                
            </tr>
            <tr class="trTitulo">
                <td class='tdAmpliadoConsulta'>Nombre del Reporte</td>
                <td class='td'>Generar en Excel</td>
                <td class='td'>Generar en PDF</td>
                <td class='tdAmpliadoConsulta'>Nombre del Reporte</td>
                <td class='td'>Generar en Excel</td>
                <td class='tdAmpliadoConsulta'>Nombre del Reporte</td>
                <td class='td'>Generar en Excel</td>                
                <td class='tdAmpliadoConsulta'>Nombre del Reporte</td>
                <td class='td'>Generar en Excel</td>                
                <td class='tdAmpliadoConsulta'>Nombre del Reporte</td>
                <td class='td'>Generar en Excel</td>                                
            </tr>
            <tr>
                <td class='td'>Listado Afiliados</td>
                <td class='td'>
                    <a href="/index.php/controladorAfiliado/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                        <img src="/images/excel.jpg" width="30" height="30" />
                    </a>
                </td>
                <td class='td'>                
                    <a href="/index.php/controladorAfiliado/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                        <img src="/images/pdf.jpg" width="30" height="30" />
                    </a>
                </td>            
                <td class='td'>Porcentaje de Afiliados por edades</td>                
                <td class='td'>
                    <a href="/index.php/controladorReporte/GenerarExcelReporte/0" target="_blank" title="Exportar a formato Excel">
                        <img src="/images/excel.jpg" width="30" height="30" />
                    </a>
                </td>                
                <td class='td'>Porcentaje de Afiliados Genero Femenino</td>                
                <td class='td'>
                    <a href="/index.php/controladorReporte/GenerarExcelReporte/1" target="_blank" title="Exportar a formato Excel">
                        <img src="/images/excel.jpg" width="30" height="30" />
                    </a>
                </td>                                
                <td class='td'>Porcentaje de Afiliados con Educación Superior</td>                
                <td class='td'>
                    <a href="/index.php/controladorReporte/GenerarExcelReporte/2" target="_blank" title="Exportar a formato Excel">
                        <img src="/images/excel.jpg" width="30" height="30" />
                    </a>
                </td>                                                
                <td class='td'>Porcentaje de Afiliados con Capacitación Sindical</td>                
                <td class='td'>
                    <a href="/index.php/controladorReporte/GenerarExcelReporte/3" target="_blank" title="Exportar a formato Excel">
                        <img src="/images/excel.jpg" width="30" height="30" />
                    </a>
                </td>                                                                
            </tr>  
            <tr>
                <td class='td'>Listado Convenios Colectivos</td>
                <td class='td'>
                    <a href="/index.php/controladorConvenioColectivo/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                        <img src="/images/excel.jpg" width="30" height="30" />
                    </a>
                </td>
                <td class='td'>                
                    <a href="/index.php/controladorConvenioColectivo/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                        <img src="/images/pdf.jpg" width="30" height="30" />
                    </a>
                </td>
            </tr>
            <tr>
                <td class='td'>Listado Empresas</td>
                <td class='td'>
                    <a href="/index.php/controladorEmpresa/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                        <img src="/images/excel.jpg" width="30" height="30" />
                    </a>
                </td>
                <td class='td'>                
                    <a href="/index.php/controladorEmpresa/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                        <img src="/images/pdf.jpg" width="30" height="30" />
                    </a>
                </td>
            </tr>
            <tr>
                <td class='td'>Listado Federaciones</td>
                <td class='td'>
                    <a href="/index.php/controladorFederacion/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                        <img src="/images/excel.jpg" width="30" height="30" />
                    </a>
                </td>
                <td class='td'>                
                    <a href="/index.php/controladorFederacion/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                        <img src="/images/pdf.jpg" width="30" height="30" />
                    </a>
                </td>
            </tr>
            <tr>
                <td class='td'>Listado Sindicatos</td>
                <td class='td'>
                    <a href="/index.php/controladorSindicato/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                        <img src="/images/excel.jpg" width="30" height="30" />
                    </a>
                </td>
                <td class='td'>                
                    <a href="/index.php/controladorSindicato/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                        <img src="/images/pdf.jpg" width="30" height="30" />
                    </a>
                </td>
            </tr>
        </table>
    </div>    
</div>

<?php FinalDocumento(); ?>