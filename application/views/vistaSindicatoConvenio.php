<?php 
/*
 * Vista Sindicato Convenio
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Gestión Sindicatos que Firman el Convenio ";
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
  echo form_open('controladorSindicatoConvenio/AdicionarSindicatoEmpresa');
  echo "<script src='/js/sindicatoConvenioAdicionar.js'></script>";
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
            <tr class='trTitulo'>
                <td class='td' <?php if($usuario['perfil'] == "Lector Sindicato") echo "id='tdLector'"; else echo "id='tdAdministrador'" ?>></td>
                <td class='td'>Nombre Sindicato</td>                
                <td class='tdFormularioAmpliado'>Convenio Empresa (fecha ini - fecha fin)</td>
            </tr>                    
                <?php        
                /*         
                 * * $registros: Array en donde se obtienen los resultados del         
                 * * $registro: Donde se almacenaran el registro actual para graficar         
                 */        
                $color = "#FDFCFC";
                foreach($registros as $registro)        
                {            
                        echo '<tr class="trDatos" style="background-color: '.$color.';">
                                      <td class="td" align="center">';                    
                    
                    if($usuario['perfil'] != "Lector Sindicato")
                        echo '<div class="floatLeft">
                                   <a href="javascript:;" onclick="Confirmar(\'/index.php/controladorSindicatoConvenio/EliminarSindicatoEmpresa/'.$registro['convenio_colectivo_id_convenio_colectivo'].'\'); return false;"  title="Eliminar">
                                       <img src="/images/eliminar.png" width="20" height="20" alt="Eliminar"/>
                                   </a>
                                <div>
                              </td>';
                    echo "<td class='td'>".$registro["nombre_sindicato"]."</td>";            
                    echo "<td class='td'>".$registro['nombre_empresa'].' ('.$registro["fecha_inicio_convenio"].' - '.$registro["fecha_finalizacion_convenio"].')'."</td>
                        </tr>";                            
                    $color = $color == "#FDFCFC" ? "#F0EEEE" : "#FDFCFC";
                }        
                ?>                        
        </table>     
        <div id="divExportarFormatos">
          <div id="divExportarExcel">
              <a href="/index.php/controladorSindicatoConvenio/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                  <img src="/images/excel.jpg" width="30" height="30" />
                  <br />
                  Exportar a Excel
              </a>
          </div>
          <div id="divExportarPdf">
              <a href="/index.php/controladorSindicatoConvenio/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                  <img src="/images/pdf.jpg" width="30" height="30" />
                  <br />
                  Exportar a Pdf
              </a>
          </div>
          <div class="clearBoth"></div>
      </div> 
    </div>          
    <div id="tabAdicionar">    
        <div id="divSindicatoEmpresa" class="clearfix">        
            <ul id="sidemenu">          
                <li>            
                    <a href="#informacion-content" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Sindicatos por Empresa</a>          
                </li>          
            </ul>                
            <div id="content">            
                <!--Tab Datos Basicos-->            
                <div id="informacion-content" class="contentblock">                
                    <div align="center">                    
                        <fieldset style="width: 570px;padding: 15px;" align="center">                      
                            <legend align="left" style="font-weight: bold;margin-bottom: 5px;">Datos Básicos</legend>                        
                            <table align="left">                          
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Sindicatos (as) que Firman el Convenio</label>
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                                                          
                                        <div class="divControl">
                                            <select name="sltSindicaFirmanConvenioAdic" id="sltSindicaFirmanConvenioAdic" />
                                                <option value=""> Seleccionar </option>                                        
                                                <?php                                                                                        
                                                    LlenarSelectOption($sindicaFirmanConvenio)
                                                ?>                                   
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>                          
                                </tr>                                
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Empresa con la Cual se Firma el Convenio</label>
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                                                          
                                        <div class="divControl">
                                            <select name="sltEmpresaFirmaConvenioAdic" id="sltEmpresaFirmaConvenioAdic" />
                                                <option value=""> Seleccionar </option>                                        
                                                <?php                                                                                        
                                                    LlenarSelectOption($empresaFirmaConvenio)
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
        <div id="divError" style="float: left;font-size: 11px;color: #A30000;padding-top: 15px;text-align: center;width: 100%;">        
            <?php             
            if(isset($error))                      
                echo $error;           
            echo form_error('maillogin');        
            ?>    
        </div>          
        <div class="clearBoth"></div>        
        <div style="margin-top: 15px;">       
            <button type="submit" style="border: 0; cursor: pointer;background-color: #fff;">         
                <img src="/images/guardar.jpg" width="36" height="36" />          
                <br/>          
                Guardar       
            </button>    
        </div>  
    </div>      
    <div id="tabModificar">    
               
 
    </div>
</div>    

<?php FinalDocumento(); ?>