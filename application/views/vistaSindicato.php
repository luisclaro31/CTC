
<?php 
/*
 * Vista Sindicato
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Gestión Sindicato";
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
    echo form_open('controladorSindicato/AdicionarSindicato'); 
    echo "<script src='/js/sindicatoAdicionar.js'></script>";
}
else
{
    echo form_open('controladorSindicato/ModificarSindicato'); 
    echo "<script src='/js/sindicatoModificar.js'></script>";
}

/*
 * Mensajes de eliminacion de registros
 */
if(isset($estadoEliminar) && $estadoEliminar == true) 
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">			
            Se elimino satisfactoriamente el sindicato.
          </div>';
else if(isset($estadoEliminar) && $estadoEliminar == false)               
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">                        
            Ocurrio un problema al eliminar el sindicato.
          </div>';
/*
 * Mensajes de modificacion de registros
 */
if(isset($estadoModificar) && $estadoModificar == true)            
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">			
            Se actualizo el sindicato satisfactoriamente.                 
          </div>';
else if(isset($estadoModificar) && $estadoModificar == false)            
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">			
            Error al actualizar el sindicato.                 
          </div>';
/*
 * Mensajes de adicion de registros
 */
if(isset($estadoAdicionar) && $estadoAdicionar == true)            
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">			
            Se adicionó el sindicato satisfactoriamente.                 
          </div>';
else if(isset($estadoAdicionar) && $estadoAdicionar == false)            
   echo '<div id="dialogo" align="center" class="ventana" title="Informacion">			
            Error al adicionar el sindicato.                 
          </div>';
/*
 * Validacion de modo consulta detallada
 */
if(isset($consultar) && $consultar == "1")
    echo "<script src='/js/sindicato.js'></script>";

if(count($registros) > 0 && $usuario['perfil'] != 'Administracion')
    echo "<script type='text/javascript'>
            $(function() { 
                $('#tabs').tabs('disable', 1);
            });
          </script>";
?>
<script>
$(function() {
  $( "#divSindicato" ).tabs({
    beforeLoad: function( event, ui ) {
      ui.jqXHR.error(function() {
        ui.panel.html(
          "Cargando..." );
      });
    }
  });
});
</script>
  
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
                <td class='td' <?php if($usuario['perfil'] != "Administracion") echo "id='tdLector'"; else echo "id='tdAdministrador'" ?>></td>
                <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "RUT"; else echo '<a style="color: #fff;" href="/index.php/controladorSindicato/index/1">RUT &dArr;</a>' ?></td>            
                <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Nombre Sindicato"; else echo '<a style="color: #fff;" href="/index.php/controladorSindicato/index/23">Nombre Sindicato &dArr;</a>' ?></td>
                <td class='td'>Siglas</td>            
                <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Estado"; else echo '<a style="color: #fff;" href="/index.php/controladorSindicato/index/6">Estado &dArr;</a>' ?></td>            
                <td class='tdAmpliadoConsulta'><?php if($usuario['perfil'] != "Administracion") echo "Departamento"; else echo '<a style="color: #fff;" href="/index.php/controladorSindicato/index/19">Departamento &dArr;</a>' ?></td>            
                <td class='td'><?php if($usuario['perfil'] != "Administracion") echo "Municipio"; else echo '<a style="color: #fff;" href="/index.php/controladorSindicato/index/18">Municipio &dArr;</a>' ?></td>            
                <td class='tdAmpliadoConsulta'>Dirección</td>            
                <td class='td'>Telefóno</td>            
                <td width="90">Año <br/> Creación</td>        
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
                            if($usuario['perfil'] == "Lector Sindicato")
                                    echo '<div class="floatLeft">
                                              <a href="/index.php/controladorSindicato/ConsultarSindicato/'.$registro['rut'].'/1" title="Consultar">
                                                  <img src="/images/buscar.png" width="20" height="20" alt="Consultar"/>
                                              </a>
                                          </div>';
                            else if($usuario['perfil'] == "Editor Sindicato")
                            {
                                    echo '<div class="floatLeft">
                                              <a href="/index.php/controladorSindicato/ConsultarSindicato/'.$registro['rut'].'" title="Modificar">
                                                  <img src="/images/editar.jpg" width="20" height="20"  alt="Editar"/>
                                              </a>
                                          </div>';
                            }
                            else
                            {
                                    echo '<div class="divImgEditar">
                                              <a href="/index.php/controladorSindicato/ConsultarSindicato/'.$registro['rut'].'" title="Modificar">
                                                  <img src="/images/editar.jpg" width="20" height="20"  alt="Editar"/>
                                              </a>
                                          </div>
                                          <div class="divImgEliminar">
                                              <a href="javascript:;" onclick="Confirmar(\'/index.php/controladorSindicato/EliminarSindicato/'.$registro['rut'].'\'); return false;"  title="Eliminar">
                                                  <img src="/images/eliminar.png" width="20" height="20" alt="Eliminar"/>
                                              </a>
                                          <div>';
                            }
                            echo "</td>";
                            echo "<td class='td'>".$registro['rut']."</td>";            
                            echo "<td class='td'>".utf8_decode($registro['nombre'])."</td>";            
                            echo "<td class='td'>".utf8_decode($registro['siglas'])."</td>";            
                            echo "<td class='td'>".utf8_decode($registro['estado_codigo'])."</td>";            
                            echo "<td class='td'>".utf8_decode($registro['departamento'])."</td>";            
                            echo "<td class='td'>".utf8_decode($registro['municipio'])."</td>";            
                            echo "<td class='td'>".utf8_decode($registro['direccion'])."</td>";            
                            echo "<td class='td'>".utf8_decode($registro['telefonos'])."</td>";            
                            echo "<td class='td'>".$registro['anyo']."</td>
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
                <a href="/index.php/controladorSindicato/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                    <img src="/images/excel.jpg" width="30" height="30" />                
                    <br />                
                    Exportar a Excel           
                </a>        
            </div>        
            <div id="divExportarPdf">
                <a href="/index.php/controladorSindicato/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                    <img src="/images/pdf.jpg" width="30" height="30" />                
                    <br />                
                    Exportar a Pdf            
                </a>        
            </div>        
            <div class="clearBoth"></div>    
        </div>  
    </div>          
    <div id="tabAdicionar">            
        <div id="divSindicato" class="clearfix">        
            <ul>          
                <li>            
                    <a href="#informacion-content" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Sindicato</a>          
                </li>          
                <li>            
                    <a href="#about-content"><i class="icon-info-sign icon-large"></i>Informaci&oacute;n Administrativa</a>          
                </li>          
                <li>            
                    <a href="#ideas-content"><i class="icon-lightbulb icon-large"></i>Descripci&oacute;n del Sindicato</a>          
                </li>          
                <li>            
                    <a href="#contact-content"><i class="icon-envelope icon-large"></i>Afiliaciones Sindicales</a>                    
                </li>
                <li>            
                    <a href="/index.php/controladorDirectivoSin"><i class="icon-envelope icon-large"></i>Directivos</a>                    
                </li>
            </ul>                
            <div id="content" style="width: 100%;margin-left: -1%;">
                <!--Tab Datos Basicos-->
                <div id="informacion-content" class="contentblock">                
                    <div align="center">                    
                        <fieldset align="center">                      
                            <legend align="left" class="legend">Datos Básicos</legend>                        
                            <table align="center" width="700px">                 
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Rut</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <div>
                                            <div class="divControl">
                                                <input type="text" id="txtRutAdic" name="txtRutAdic" />
                                                <input type="hidden" id="txtExisteRut" name="txtExisteRut" />
                                            </div>                                            
                                            <div class="campoObligatorio">*</div>
                                            <div class="clearBoth"></div>
                                            <div id="divRutVal" class="fuenteRoja"></div>
                                        </div> 
                                    </td>                          
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
                                        <label>Número Personería Jurídica o Registro Sindical</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <div>
                                            <div class="divControl">
                                                <input type="text" id="txtRegistroSindicalAdic" name="txtRegistroSindicalAdic" />
                                                <input type="hidden" id="txtExisteRegistroSindical" name="txtExisteRegistroSindical" />
                                            </div>                                            
                                            <div class="campoObligatorio">*</div>
                                            <div class="clearBoth"></div>
                                            <div id="divRegistroSindicalVal" class="fuenteRoja"></div>
                                        </div> 
                                    </td>                          
                                </tr>                                 
                                <tr>                              
                                    <td align="left" class="tdMiddle">
                                        <label>Numero resoluci&oacute;n o registro</label>
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                                                                
                                        <div class="divControl">
                                            <input type="text" name="txtNumeroResolucionAdic" onkeyup = "this.value=this.value.toUpperCase()" id="txtNumeroResolucionAdic" />
                                        </div>
                                        <div class="campoObligatorio">*</div>                                                                                    
                                    </td>                          
                                </tr>                                                                                 
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                 
                                        <label for="">Fecha</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                                                          
                                        <input type="text" id="datepicker" class="fechas" name="txtFechaAdic" />
                                        (yyyy-mm-dd)
                                    </td>                          
                                </tr>                                                                                   
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Nombre Sindicato</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <div>
                                            <div class="divControl">
                                                <input type="text" name="txtNombreSindicatoAdic" onkeyup = "this.value=this.value.toUpperCase()" id="txtNombreSindicatoAdic" />
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
                                        <label>Clase Directiva</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                                                          
                                        <div class="divControl">
                                            <select name="sltClaseDirectivaAdic" id="sltClaseDirectivaAdic" />
                                                <option value=""> Seleccionar </option>                                        
                                                <?php                                                                                        
                                                    LlenarSelectOption($claseDirectiva)                                         
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
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Dirección</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtDireccionAdic" onkeyup = "this.value=this.value.toUpperCase()"/>                              
                                    </td>                          
                                </tr>                          
                                <tr>                             
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Teléfonos</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtTelefonoAdic" id="txtTelefonoAdic" />
                                    </td>                          
                                </tr>                          
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Celular institucional</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtCelularAdic" id="txtCelularAdic" />                              
                                    </td>                          
                                </tr>                          
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                 
                                        <label>Fax</label>                              
                                    </td>                             
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtFaxAdic" id="txtFaxAdic" />                                                                      
                                    </td>                          
                                </tr>                          
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Correo Electrónico</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                 
                                        <input type="text" name="txtCorreoAdic" onkeyup = "this.value=this.value.toUpperCase()" />                              
                                    </td>                          
                                </tr>                          
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Página Web</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtPaginaWebAdic" onkeyup = "this.value=this.value.toUpperCase()"/>                              
                                    </td>                          
                                </tr>                          
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                 
                                        <label>Facebook</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtFacebookAdic" onkeyup = "this.value=this.value.toUpperCase()" />                              
                                    </td>                          
                                </tr>                          
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Twiter</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="text" name="txtTwiterAdic" onkeyup = "this.value=this.value.toUpperCase()" />                              
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
                            <table align="left" >                          
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Secretarías que Existen en el Sindicato</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="checkbox" class="check" name="chkAdministracionFinanzasAdic" id='chkAdministracionFinanzasAdic' value="ADMINISTRAFINANZAS">Administración y finanzas                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuntosAgrariosAdic" id="chkAsuntosAgrariosAdic" value="ASUNTOSAGRARIOS" >Asuntos Agrarios                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuntosCooperativosAdic" id="chkAsuntosCooperativosAdic" value="ASUNTOSCOOPERATIVOS">Asuntos Cooperativos                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuntosNinezAdic" id="chkAsuntosNinezAdic" value="ASUNTOSNINEZ">Asuntos de la Niñez                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuntosEnergeticosAdic" id="chkAsuntosEnergeticosAdic" value="ASUNTOSENERGETICOS">Asuntos Energéticos                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuentosInternacionalesAdic" id="chkAsuentosInternacionalesAdic" value="ASUNTOSINTERNACIONA" >Asuntos Internacionales                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuntosInterSindicalesAdic" if="chkAsuntosInterSindicalesAdic" value="ASUNTOSINTERSINDICA">Asuntos Inter-sindicales                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuntosJuridicosAdic" id="chkAsuntosJuridicosAdic" value="ASUNTOSJURILABOR">Asuntos Jurídicos y laborales                                   
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuntosPoliticosAdic" id="chkAsuntosPoliticosAdic" value="ASUNTOSPOLILEGISLATI">Asuntos Políticos y Legislativos                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkComunicacionAdic" id="chkComunicacionAdic" value="COMUNICACION" >Comunicación                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkConflictosLaboralesAdic" id="chkConflictosLaboralesAdic" value="CONFLICTOSLABORALES">Conflictos Laborales                                 
                                        <br/>                                 
                                        <input type="checkbox" class="check" name="chkDerechosHumanosAdic" id="chkDerechosHumanosAdic" value="DERECHOSHUMASINDICA">Derechos Humanos y Sindicales                                 
                                        <br/>                                 
                                        <input type="checkbox" class="check" name="chkEcologiaMedioAdic" id="chkEcologiaMedioAdic" value="ECOLOGIAMEDIOAMBIEN">Ecología y Medio Ambiente                                   
                                        <br/>                                
                                        <input type="checkbox" class="check" name="chkEcologiaRecursosAdic" id="chkEcologiaRecursosAdic" value="ECOLOGIARECURNATURAL">Ecología y Recursos Naturales                          
                                        <br/>                               
                                        <input type="checkbox" class="check" name="chkEducacionAdic" id="chkEducacionAdic" value="EDUCACION" >Educación                                
                                        <br/>                              
                                        <input type="checkbox" class="check" name="chkEducacionInvestigacionAdic" id="chkEducacionInvestigacionAdic" value="EDUCACIONINVESTIGA">Educación e Investigación                           
                                        <br/>                             
                                        <input type="checkbox" class="check" name="chkJuventudAdic" id="chkJuventudAdic" value="JUVENTUD">Juventud                        
                                        <br/>                        
                                        <input type="checkbox" class="check" name="chkMedioAmbienteAdic" id="chkMedioAmbienteAdic" value="MEDIOAMBIENTE" >Medio Ambiente                 
                                        <br/>                      
                                        <input type="checkbox" class="check" name="chkMujerAdic" id="chkMujerAdic" value="MUJER">Mujer                        
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkOrganizacionAdic" id="chkOrganizacionAdic" value="ORGANIZACION">Organización
                                        <br/>
                                        <input type="checkbox" class="check" name="chkOrganizacionSocialesAdic" id="chkOrganizacionSocialesAdic" value="ORGANIZACIONSOCIAL">Organizaciones Sociales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkPlaneacionAdic" id="chkPlaneacionAdic" value="PLANEACION">Planeación                                        
                                        <br/>
                                        <input type="checkbox" class="check" name="chkProyectosAdic" id="chkProyectosAdic" value="PROYECTOS">Proyectos                                        
                                        <br/>
                                        <input type="checkbox" class="check" name="chkRelacionesPublicasAdic" id="chkRelacionesPublicasAdic" value="RELACIONESPUBLICAS">Relaciones Públicas                                        
                                        <br/>
                                        <input type="checkbox" class="check" name="chkSecretariaActasAdic" id="chkSecretariaActasAdic" value="SECRETARIAACTAS">Secretaría de Actas
                                        <br/>                                        
                                        <input type="checkbox" class="check" name="chkSeguridadSocialAdic" id="chkSeguridadSocialAdic" value="SEGURIDADSOCIAL">Seguridad Social
                                        <br/>
                                        <input type="checkbox" class="check" name="chkServidoresPublicosAdic" id="chkServidoresPublicosAdic" value="SERVIDORESPUBLICOS">Servidores Públicos                                        
                                        <br/>
                                        <input type="checkbox" class="check" name="chkTrabajoInformalAdic" id="chkTrabajoInformalAdic" value="TRABAJOINFORMAL">Trabajo Informal                                        
                                        <br/>
                                        <input type="checkbox" class="check" name="chkTransporteAdic" id="chkTransporteAdic" value="TRANSPORTE">Transporte
                                        <br/>
                                        <input type="checkbox" class="check" name="chkOtraSecretariaAdic" id="chkOtraSecretariaAdic" value="OTRASECRETARIA" >Otra                                        
                                    </td>                          
                                </tr>                        
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Cuáles ?</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtOtraSecretariaAdic" onkeyup = "this.value=this.value.toUpperCase()" id="txtOtraSecretariaAdic"/>
                                    </td>
                                </tr>                                                                
                                <tr>                              
                                    <td align="left" class="tdFormulario">                          
                                        <label>Fecha última Inscripción Junta Directiva</label>                          
                                    </td>                   
                                    <td align="left" class="tdFormulario">              
                                        <input type="text" id="datepicker2" class="fechas" name="txtFechaUltInscrJunDirectivaAdic" />            
                                    </td>             
                                </tr>                         
                                <tr>                            
                                    <td align="left" class="tdFormulario">       
                                        <label>Periodo Vigencia Junta Directiva</label>       
                                    </td>                 
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltPeriodoVigJuntaDirectivaAdic" id="sltPeriodoVigJuntaDirectivaAdic">
                                                <option value=""> Seleccionar </option>   
                                                <?php                  
                                                   LlenarSelectOption($periodoVigencia)  
                                                ?>                            
                                            </select> 
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>
                                    </td>             
                                </tr>                   
                                <tr>                       
                                    <td align="left" class="tdFormulario">             
                                        <label>Número Total de Afiliados</label>   
                                    </td>                     
                                    <td align="left" class="tdFormulario">      
                                        <input type="text" name="txtNumeroTotalAfiliadosAdic" id="txtNumeroTotalAfiliadosAdic" />   
                                    </td>                     
                                </tr>                    
                                <tr>                         
                                    <td align="left" class="tdMiddle">         
                                        <label>Descripción Afiliados Por Empresa</label>
                                    </td>                                                           
                                    <td align="left" class="tdFormulario">                                         
                                        <textarea rows="7" cols="45" name="txtDescripcionAfiliadosEmpresaAdic" onkeyup = "this.value=this.value.toUpperCase()" id="txtDescripcionAfiliadosEmpresaAdic" ></textarea>
                                    </td>               
                                </tr>                   
                                <tr>                           
                                    <td align="left" class="tdFormulario">    
                                        <label>Número  Afiliados Hombres</label>     
                                    </td>                          
                                    <td align="left" class="tdFormulario">   
                                        <input type="text" name="txtNumeroAfiliadosHombresAdic" id="txtNumeroAfiliadosHombresAdic" />   
                                    </td>                          
                                </tr>                          
                                <tr>
                                    <td align="left" class="tdFormulario">         
                                        <label>Número  Afiliados Mujeres</label>
                                    </td>                         
                                    <td align="left" class="tdFormulario">             
                                        <input type="text" name="txtNumeroAfiliadosMujeresAdic" id="txtNumeroAfiliadosMujeresAdic" />     
                                    </td>                 
                                </tr>
                                <tr>                        
                                    <td align="left" class="tdFormulario">          
                                        <label>Número  Afiliados Jóvenes  (menores de 35)</label>           
                                    </td>                       
                                    <td align="left" class="tdFormulario">       
                                        <input type="text" name="txtNumeroAfiliadosJovenesMenor35Adic" id="txtNumeroAfiliadosJovenesMenor35Adic" />       
                                    </td>               
                                </tr>         
                                <tr>                   
                                    <td align="left" class="tdFormulario">         
                                        <label>Número  Afiliados Sector Formal</label>             
                                    </td>                       
                                    <td align="left" class="tdFormulario">        
                                        <input type="text" name="txtNumeroAfiliadosSectorFormalAdic" id="txtNumeroAfiliadosSectorFormalAdic" />       
                                    </td>     
                                </tr>                     
                                <tr>                   
                                    <td align="left" class="tdFormulario">  
                                        <label>Número  Afiliados Sector Informal</label>                     
                                    </td>                          
                                    <td align="left" class="tdFormulario">        
                                        <input type="text" name="txtNumeroAfiliadosSectorInformalAdic" id="txtNumeroAfiliadosSectorInformalAdic" />     
                                    </td>               
                                </tr>                      
                                <tr>           
                                    <td align="left" class="tdMiddle">                   
                                        <label>Medio de Comunicación</label>                       
                                    </td>                             
                                    <td align="left" class="tdFormulario">                                        
                                        <input type="checkbox" class="check"name="chkBoletinAdic" value="BOLETIN">Boletín     
                                        <br/>                    
                                        <input type="checkbox" class="check"name="chkPeriodicoAdic" value="PERIODICO">Periódico  
                                        <br/>                            
                                        <input type="checkbox" class="check"name="chkProgramaRadioAdic" value="PROGRAMARADIO">Programa radio  
                                        <br/>                      
                                        <input type="checkbox" class="check"name="chkTelevisionAdic" value="TELEVISION">Televisión    
                                    </td>               
                                </tr> 
                                <tr>                     
                                    <td align="left" class="tdFormulario">       
                                        <label>Estado Sindicato</label>
                                    </td>                          
                                    <td align="left" class="tdFormulario">                                                 
                                        <div class="divControl">
                                            <select name="sltEstadoAdic" id="sltEstadoAdic">          
                                                <option value=""> Seleccionar </option>           
                                                <?php                   
                                                LlenarSelectOption($estadoSindicato)       
                                                ?>                 
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>             
                                    </td>                                              
                                </tr>                         
                                <tr>                           
                                    <td align="left">           
                                        <label>Característica para Sindicato Inactivo</label>       
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                                 
                                        <div class="divControl">
                                            <select name="sltCaracteristicasSindicatoInactivoAdic" id="sltCaracteristicasSindicatoInactivoAdic">          
                                                <option value=""> Seleccionar </option>           
                                                <?php                   
                                                LlenarSelectOption($caracteristicasSindicatInac)       
                                                ?>                 
                                            </select>
                                        </div>                                                                                    
                                    </td>                                                                                  
                                </tr>                                                         
                                <tr>                  
                                    <td align="left" class="tdFormulario">                         
                                        <label>Nombre Sindicato al que se  Fusiona</label>         
                                    </td>                            
                                    <td align="left" class="tdFormulario">           
                                        <input type="text" name="txtNombreSindicatoFusionaAdic" onkeyup = "this.value=this.value.toUpperCase()" id="txtNombreSindicatoFusionaAdic" />  
                                    </td>                  
                                </tr>                
                                <tr>                   
                                    <td align="left" class="tdMiddle">        
                                        <label>Descuento de Cuota Sindical para la Central</label>            
                                    </td>              
                                    <td align="left" class="tdFormulario">         
                                        <input type="radio" class="radio" name="rdbDescuentoCuotaSindicalAdic" value="1">Si   
                                        <br/>                       
                                        <input type="radio" class="radio" name="rdbDescuentoCuotaSindicalAdic" value="0" checked>No    
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Bienes Inmuebles de Propiedad del Sindicato</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="checkbox" class="check"name="chkCentroRecreativoAdic" id="chkCentroRecreativoAdic" value="CENTROECREATIVO">Centro Recreativo
                                        <br/>                    
                                        <input type="checkbox" class="check"name="chkOtrosBienesInmueblesAdic" id="chkOtrosBienesInmueblesAdic" value="OTROSBIENESINMUEBLES">Otros Bienes Inmuebles
                                        <br/>                            
                                        <input type="checkbox" class="check"name="chkSedePropiaAdic" id="chkSedePropiaAdic" value="SEDEPROPIA">Sede Propia
                                    </td>
                                </tr>                                
                                <tr>          
                                    <td align="left" class="tdFormulario">         
                                        <label>Otros Bienes Inmuebles</label>                 
                                    </td>                           
                                    <td align="left" class="tdFormulario">        
                                        <input type="text" name="txtOtrosBienesInmueblesAdic" onkeyup = "this.value=this.value.toUpperCase()" id="txtOtrosBienesInmueblesAdic"/>    
                                    </td>                   
                                </tr>                      
                                <tr>                       
                                    <td align="left" class="tdMiddle">            
                                        <label>Observaciones</label>                   
                                    </td>                
                                    <td align="left" class="tdFormulario">           
                                        <textarea rows="7" cols="45" name="txtObservacionesAdic" onkeyup = "this.value=this.value.toUpperCase()"></textarea>
                                    </td>                          
                                </tr>                      
                            </table>                   
                        </fieldset>               
                    </div>          
                </div>      
                <!--Tab Descripción Sindicato-->
                <div id="ideas-content" class="contentblock hidden">               
                    <div align="center">                  
                        <fieldset align="center">    
                            <legend align="left" class="legend"></legend>         
                            <table align="left" width="700px" >    
                                <tr>               
                                    <td align="left" class="tdFormulario">     
                                        <label>Clase de Sindicato</label>           
                                    </td>                         
                                    <td align="left" class="tdFormulario">                                                 
                                        <div class="divControl">
                                            <select name="sltClaseSindicatoAdic" id="sltClaseSindicatoAdic">          
                                                <option value=""> Seleccionar </option>           
                                                <?php                   
                                                LlenarSelectOption($claseSindicato)       
                                                ?>                 
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>             
                                    </td>          
                                </tr>              
                                <tr>            
                                    <td align="left" class="tdFormulario">    
                                        <label>Sindicato Según Origen</label>     
                                    </td>                  
                                    <td align="left" class="tdFormulario">                                                         
                                        <div class="divControl">
                                            <select name="sltSindicatoSegOriCapAdic" id="sltSindicatoSegOriCapAdic">    
                                                <option value=""> Seleccionar </option>            
                                                <?php              
                                                LlenarSelectOption($sindicatoOri)           
                                                ?>              
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>               
                                    </td>         
                                </tr>    
                                <tr>            
                                    <td align="left" class="tdFormulario">    
                                        <label>Sindicato Según Origen del Capital de La Empresa</label>     
                                    </td>                  
                                    <td align="left" class="tdFormulario">                                                         
                                        <div class="divControl">
                                            <select name="sltSindicatoSegCapEmpAdic" id="sltSindicatoSegCapEmpAdic">    
                                                <option value=""> Seleccionar </option>            
                                                <?php              
                                                LlenarSelectOption($sindicatoOriCap)           
                                                ?>              
                                            </select>
                                        </div>                                                                                             
                                    </td>         
                                </tr>
                                <tr>                             
                                    <td align="left" class="tdFormulario">                   
                                        <label>Sindicato Según Tipo de Empresa Estatal</label>              
                                    </td>                 
                                    <td align="left" class="tdFormulario">                                                 
                                        <div class="divControl">
                                            <select name="sltSindicatoSegTipEmprEstAdic" id="sltSindicatoSegTipEmprEstAdic">            
                                                <option value=""> Seleccionar </option>      
                                                  <?php                          
                                                  LlenarSelectOption($sindicatoTipoEmprEst)          
                                                  ?>                 
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>
                                </tr>                      
                                <tr>                   
                                    <td align="left" class="tdFormulario">    
                                        <label>Sindicato Estatal Según Modalidad del Contrato</label>      
                                    </td>                   
                                    <td align="left" class="tdFormulario">                                                
                                        <div class="divControl">
                                            <select name="sltSindicatoEstModaContraAdic" id="sltSindicatoEstModaContraAdic">        
                                                <option value=""> Seleccionar </option>           
                                                <?php   
                                                LlenarSelectOption($sindicatoEstModaContra)     
                                                ?>            
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                        
                                    </td>         
                                </tr>                       
                                <tr>                        
                                    <td align="left" class="tdFormulario">  
                                        <label>Actividad Económica de Servicio Público Esencial</label>    
                                    </td>                        
                                    <td align="left" class="tdFormulario">     
                                        <input type="radio" class="radio" name="rdbActividadEconomicaServPubAdic" value="1">Si                   
                                        <br/>                             
                                        <input type="radio" class="radio" name="rdbActividadEconomicaServPubAdic" value="0" checked>No    
                                    </td>                 
                                </tr>                         
                                <tr>                        
                                    <td align="left" class="tdFormulario">  
                                        <label>Han Sido Victimas de Violencia</label>    
                                    </td>                        
                                    <td align="left" class="tdFormulario">     
                                        <input type="radio" class="radio" name="rdbVictimaViolenciaAdic" id="rdbVictimaViolenciaSiAdic" value="1">Si                   
                                        <br/>                             
                                        <input type="radio" class="radio" name="rdbVictimaViolenciaAdic" id="rdbVictimaViolenciaNoAdic" value="0" checked>No    
                                    </td>                 
                                </tr>                                                         
                                <tr>                              
                                    <td align="left" class="tdMiddle">                                  
                                        <label>Que tipo de Violencia</label>                              
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <input type="checkbox" class="check" name="chkAllanamientoIlegalAdic" id='chkAllanamientoIlegalAdic' value="ALLANAMIENTOILEGAL">Allanamiento Ilegal                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAmenazasAdic" id="chkAmenazasAdic" value="AMENAZAS" >Amenazas
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAtentadoLesionesAdic" id="chkAtentadoLesionesAdic" value="ATENTADOLESIONES">Atentado con o sin Lesiones
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkDesaparicionAdic" id="chkDesaparicionAdic" value="DESAPARICION">Desaparición
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkDesplazamientoForzosoAdic" id="chkDesplazamientoForzosoAdic" value="DESPLAZADOFORZOSO">Desplazamiento Forzoso
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkDetencionArbitrariaAdic" id="chkDetencionArbitrariaAdic" value="DETENCIONARBITRARIA" >Detención Arbitraria
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkHomicidiosAdic" id="chkHomicidiosAdic" value="HOMICIDIOS">Homicidios
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkHostigamientoAdic" id="chkHostigamientoAdic" value="HOSTIGAMIENTO">Hostigamiento
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkSecuestroAdic" id="chkSecuestroAdic" value="SECUESTRO">Secuestro
                                        <br/>
                                        <input type="checkbox" class="check" name="chkOtroTipoViolenciaAdic" id="chkOtroTipoViolenciaAdic" value="OTROTIPOVIOLENCIA" >Otro Tipo de Violencia
                                    </td>                          
                                </tr>                                   
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Cuáles ?</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtOtroTipoViolenciaAdic" onkeyup = "this.value=this.value.toUpperCase()" id="txtOtroTipoViolenciaAdic"/>
                                    </td>
                                </tr>                                                                                                
                            </table>                    
                        </fieldset>                
                    </div>            
                </div>            
                <!--Tab Afiliaciones Sindicales-->
                <div id="contact-content" class="contentblock hidden">                
                    <div align="center">                    
                        <fieldset align="center">                      
                            <legend align="left" class="legend"></legend>                      
                            <table align="left" width="700px">                          
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Afiliación federación regional Y/O seccional</label>
                                    </td>
                                    <td align="left">
                                        <input type="checkbox" class="check"name="chkFedetralAdic" id="chkFedetralAdic" value="FEDETRAL">FEDETRAL –  Federación de Trabajadores del Atlántico
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkFedetrarAdic" id="chkFedetrarAdic" value="FEDETRAR">FEDETRAR – Federación Regional de Trabajadores del Eje Cafetero
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkFertrasuccolAdic" id="chkFertrasuccolAdic" value="FERTRASUCCOL">FERTRASUCCOL – Federación Regional de Trabajadores del Suroccidente Colombiano
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkFesinuvalcAdic" id="chkFesinuvalcAdic" value="FESINUVALC">FESINUVALC – Federación de Sindicatos Unidos del Valle del Cauca
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkFesrtralvaAdic" id="chkFesrtralvaAdic" value="FESRTRALVA">FESRTRALVA – Federación Sindical Regional de Trabajadores Libres del Valle del Cauca                                        
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkFestratolAdic" id="chkFestratolAdic" value="FESTRATOL">FESTRATOL – Federación Sindical de Trabajadores del Tolima
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkFetrabolAdic" id="chkFetrabolAdic" value="FETRABOL">FETRABOL –  Federación de Trabajadores de Bolívar
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkFetralmagAdic" id="chkFetralmagAdic" value="FETRALMAG">FETRALMAG – Federación de Trabajadores Libres del Magdalena
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkFetralnaAdic" id="chkFetralnaAdic" value="FETRALNA">FETRALNA – Federación de Trabajadores Libres de Nariño
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkFetralnorteAdic" id="chkFetralnorteAdic" value="FETRALNORTE">FETRALNORTE – Federación de Trabajadores Libres del Norte de Santander
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkAntioquiaAdic" id="chkAntioquiaAdic" value="ANTIOQUIA">Seccional Antioquia
                                        <br/>                    
                                        <input type="checkbox" class="check"name="chkBogotaAdic" id="chkBogotaAdic" value="BOGOTA">Seccional Bogotá - Cundinamarca
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkBolivarAdic" id="chkBolivarAdic" value="BOLIVAR">Seccional Bolívar
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkCaldasAdic" id="chkCaldasAdic" value="CALDAS">Seccional Caldas
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkCesarAdic" id="chkCesarAdic" value="CESAR">Seccional Cesar
                                        <br/>                    
                                        <input type="checkbox" class="check"name="chkCordobaAdic" id="chkCordobaAdic" value="CORDOBA">Seccional Córdoba
                                        <br/>                                                                                                                          
                                        <input type="checkbox" class="check"name="chkSantanderAdic" id="chkSantanderAdic" value="SANTANDER">Seccional Santander
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkValledelcaucaAdic" id="chkValledelcaucaAdic" value="VALLEDELCAUCA">Seccional Valle del Cauca
                                    </td>
                                </tr>
                                <tr>                                    
                                    <td align="left">                                   
                                    </td>                              
                                    <td align="left" class="tdFormulario">              
                                    </td>                   
                                </tr>                                                       
                                <tr>                                    
                                    <td align="left">                                   
                                        <label>Federación de Afiliación</label>
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                                                          
                                        <div class="divControl">
                                            <select name="sltFederacionAfiliacionAdic" id="sltFederacionAfiliacionAdic" >                                        
                                                <option value=""> Seleccionar </option>                       
                                                <?php                   
                                                LlenarSelectOption($federacionAfiliacion)       
                                                ?>   
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                                     
                                    </td>                   
                                </tr>                       
                                <tr>                              
                                    <td align="left">                                   
                                        <label>Afiliación a Federación de Rama</label>
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                                                          
                                        <div class="divControl">
                                            <select name="sltAfiliacionFedRamaAdic" id="sltAfiliacionFedRamaAdic" >                                        
                                                <option value=""> Seleccionar </option>                       
                                                <?php                   
                                                LlenarSelectOption($afiliaFederaRama)       
                                                ?>   
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                                     
                                    </td>                   
                                </tr>                                                       
                                <tr>                            
                                    <td align="left" class="tdFormulario">                  
                                        <label>Central sindical de donde proviene</label>                 
                                    </td>                          
                                    <td align="left" class="tdFormulario">                                                    
                                        <div class="divControl">
                                            <select name="sltCentralSindProvAdic" id="sltCentralSindProvAdic">                   
                                                <option value=""> Seleccionar </option>    
                                                <?php                   
                                                LlenarSelectOption($centralSindicProv)       
                                                ?>   
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                       
                                    </td>                  
                                </tr>                   
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Afiliación Internacional</label>
                                    </td>
                                    <td align="left" width="700px" >
                                        <input type="checkbox" class="check"name="chkBwiAdic" id="chkBwiAdic" value="BWI">BWI (Internacional de los trabajadores de la Construcción y la Madera)
                                        <br/>                    
                                        <input type="checkbox" class="check"name="chkEiAdic" id="chkEiAdic" value="EI"> EI (Federación Sindical Internacional de Maestros y Educadores)
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkIaeaAdic" id="chkIaeaAdic" value="IAEA">IAEA (Internacional de Artistas y Trabajadores del Entretenimiento)
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkIfjAdic" id="chkIfjAdic" value="IFJ">IFJ ( Federación Internacional de Periodistas)
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkIndustryAllAdic" id="chkIndustryAllAdic" value="INDUSTRYALL">INDUSTRIALL (Min energética e Industrial)
                                        <br/>                    
                                        <input type="checkbox" class="check"name="chkItfAdic" id="chkItfAdic" value="ITF"> ITF (Federación Internacional de Transporte)
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkIufAdic" id="chkIufAdic" value="IUF">IUF (Unión Internacional de Trabajadores de Agricultura y Alimentos)
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkPsiAdic" id="chkPsiAdic" value="PSI">PSI (Internacional de Servicios Públicos)
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkUniAdic" id="chkUniAdic" value="UNI">UNI (Sindicato Global)
                                        <br/>                                                                                  
                                        <input type="checkbox" class="check"name="chkNoAfiliadoAdic" id="chkchkNoAfiliadoAdic" value="NOAFILIADO">No Afiliado                                        
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
        <div id="divSindicatoModificar" class="clearfix">        
            <ul id="sidemenuMod">         
                <li>            
                    <a href="#informacion-contentMod" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Sindicato</a>         
                </li>         
                <li>         
                    <a href="#about-contentMod"><i class="icon-info-sign icon-large"></i>Informaci&oacute;n Administrativa</a>       
                </li>       
                <li>          
                    <a href="#ideas-contentMod"><i class="icon-lightbulb icon-large"></i>Descripci&oacute;n del Sindicato</a>         
                </li>        
                <li>   
                    <a href="#contact-contentMod"><i class="icon-envelope icon-large"></i>Afiliaciones Sindicales</a>        
                </li> 
            </ul>           
            <div id="contentMod">    
                <!--Tab Datos Basicos-->     
                <div id="informacion-contentMod" class="contentblock">      
                    <div align="center">     
                        <fieldset align="center">             
                            <legend class="legend" align="left">Datos Básicos</legend>    
                            <table align="left" width="700px">             
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
                                  <td align="left" class="tdFormulario" >
                                      <div class="divControl" style="display: none;">
                                          <input type="text" name="txtDigitoVerificacion" id="txtDigitoVerificacion"  <?php echo $soloLectura; ?> value="<?php echo $registro["digito_verificacion"] ?>"/>
                                          <div class="campoObligatorio">*</div>
                                      </div>
                                      <label><?php echo $registro["digito_verificacion"] ?></label>
                                  </td>                                                                                                          
                                </tr> 
                                <tr>                          
                                    <td align="left" class="tdFormulario">                   
                                        <label>Número Personería Jurídica o Registro Sindical</label>              
                                    </td>                  
                                    <td align="left" class="tdFormulario">                            
                                        <div class="divControl" style="display: none;">
                                            <input type="text" name="txtRegistroSindical" id="txtRegistroSindical" <?php echo $soloLectura; ?> value="<?php echo $registro["registro_sindical"] ?>"/>
                                            <div class="campoObligatorio">*</div>
                                        </div>                                                                                   
                                        <label><?php echo $registro["registro_sindical"] ?></label>
                                    </td>
                                </tr>                                 
                                <tr>                         
                                    <td align="left" class="tdFormulario">     
                                        <label>Numero resolución o registro</label>
                                    </td>                     
                                    <td align="left">                                          
                                        <div class="divControl">
                                            <input type="text" name="txtNumeroResolucion"  id="txtNumeroResolucion" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> value="<?php echo $registro["numero_resolucion_registro"]; ?>"/>       
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>
                                    </td>               
                                </tr>                                                                       
                                <tr>                            
                                    <td align="left">               
                                        <label>Fecha</label>
                                    </td>                       
                                    <td align="left" class="tdFormulario">      
                                        <input type="text" <?php if($consultar != "1") echo 'id="datepicker5"' ?> name="txtFecha" class="fechas" <?php echo $soloLectura; ?> value="<?php if($registro["fecha_resolucion"] != "0000-00-00") echo $registro["fecha_resolucion"]?>"/>             
                                    </td>                      
                                </tr>                                                                      
                                <tr>                 
                                    <td align="left" class="tdFormulario">      
                                        <label>Nombre Sindicato</label>
                                    </td>                      
                                    <td align="left" class="tdFormulario">         
                                        <div class="divControl">
                                            <input type="text" name="txtNombSindicato" id="txtNombSindicato" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> value="<?php echo $registro["nombre"] ?>"/>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>
                                    </td>                 
                                </tr>                    
                                <tr>                        
                                    <td align="left" class="tdFormulario">    
                                        <label>Sigla</label>
                                    </td>                           
                                    <td align="left" class="tdFormulario">            
                                        <input type="text" name="txtSigla" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> value="<?php echo $registro["siglas"] ?>"/>
                                    </td>                 
                                </tr>                         
                                <tr>
                                    <td align="left" class="tdFormulario">        
                                        <label>Clase Directiva</label>
                                    </td>                
                                    <td align="left" class="tdFormulario">        
                                        <div class="divControl">
                                            <select name="sltClaseDirectiva" id="sltClaseDirectiva">                 
                                                <option value=""> Seleccionar </option>  
                                                <?php         
                                                LlenarSelectOption($claseDirectiva, $registro["clase_directiva_codigo"])       
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
                                            <select name="sltCodDepartamento" id="sltCodDepartamento">
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
                                        <input type="text" name="txtDireccion" onkeyup = "this.value=this.value.toUpperCase()"  <?php echo $soloLectura; ?> value="<?php echo $registro["direccion"]?>"/>                                                 
                                    </td>                
                                </tr>                         
                                <tr>                           
                                    <td align="left" class="tdFormulario">       
                                        <label>Teléfono</label>
                                    </td>                       
                                    <td align="left" class="tdFormulario">    
                                        <input type="text" name="txtTelefono" id="txtTelefono" <?php echo $soloLectura; ?> value="<?php echo $registro["telefonos"]?>"/>      
                                    </td>                     
                                </tr>                  
                                <tr>             
                                    <td align="left" class="tdFormulario">       
                                        <label>Celular Institucional</label>
                                    </td>                     
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtCelular" id="txtCelular" <?php echo $soloLectura; ?> value="<?php echo $registro["celular_institucional"]?>"/>              
                                    </td>             
                                </tr>                       
                                <tr>           
                                    <td align="left" class="tdFormulario">       
                                        <label>Fax</label>
                                    </td>              
                                    <td align="left" class="tdFormulario">       
                                        <input type="text" name="txtFax" id="txtFax" <?php echo $soloLectura; ?> value="<?php echo $registro["fax"]?>"/>            
                                    </td>
                                </tr>                    
                                <tr>                     
                                    <td align="left" class="tdFormulario">             
                                        <label>Correo Electrónico</label>
                                    </td>
                                    <td align="left" class="tdFormulario">                
                                        <input type="text" name="txtCorreo" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> value="<?php echo $registro["correo"]?>"/> 
                                    </td>             
                                </tr>                
                                <tr>                 
                                    <td align="left" class="tdFormulario">  
                                        <label>Página Web</label>
                                    </td>                         
                                    <td align="left" class="tdFormulario">          
                                        <input type="text" name="txtPaginaWeb"  onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> value="<?php echo $registro["pagina_web"]?>"/>
                                    </td>                    
                                </tr>                      
                                <tr>                   
                                    <td align="left" class="tdFormulario">   
                                        <label>Facebook</label>
                                    </td>             
                                    <td align="left" class="tdFormulario">         
                                        <input type="text" name="txtFacebook" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> value="<?php echo $registro["usuario_facebook"]?>"/>    
                                    </td>                     
                                </tr>                     
                                <tr>                 
                                    <td align="left" class="tdFormulario">       
                                        <label>Twiter</label>
                                    </td>                         
                                    <td align="left" class="tdFormulario">        
                                        <input type="text" name="txtTwiter" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> value="<?php echo $registro["usuario_twiter"]?>"/> 
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
                                    <td align="left" class="tdMiddle">        
                                        <label>Secretarías que Existen en el Sindicato</label>     
                                    </td>                         
                                    <td align="left" class="tdFormulario"> 
                                        <?php
                                        $chkAdministracionFinanzas = '';      
                                        $chkAsuntosAgrariosAdic = '';
                                        $chkAsuntosCooperativos = '';
                                        $chkAsuntosNinez = '';
                                        $chkAsuntosEnergeticos = '';
                                        $chkAsuntosInternacionales = '';
                                        $chkAsuntosInterSindicalesAdic = '';
                                        $chkAsuntosJuridicosAdic = '';
                                        $chkAsuntosPoliticosAdic = '';
                                        $chkComunicacionAdic = '';
                                        $chkConflictosLaboralesAdic = '';
                                        $chkDerechosHumanosAdic = '';
                                        $chkEcologiaMedioAdic = '';
                                        $chkEcologiaRecursosAdic = '';
                                        $chkEducacionAdic = '';
                                        $chkEducacionInvestigacionAdic = '';
                                        $chkJuventudAdic = '';
                                        $chkMedioAmbienteAdic = '';
                                        $chkMujerAdic = '';
                                        $chkOrganizacionAdic = '';
                                        $chkOrganizacionSocialesAdic = '';
                                        $chkPlaneacionAdic = '';
                                        $chkProyectosAdic = '';
                                        $chkRelacionesPublicasAdic = '';
                                        $chkSecretariaActasAdic = '';
                                        $chkSeguridadSocialAdic = '';
                                        $chkServidoresPublicosAdic = '';
                                        $chkTrabajoInformalAdic = '';
                                        $chkTransporteAdic = '';
                                        $chkOtraSecretaria = '';                                                                                
                                        
                                        if(count($secretariasSindicato) > 0)
                                        {                                            
                                            foreach ($secretariasSindicato as $secretaria)
                                            {                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ADMINISTRAFINANZAS')
                                                    $chkAdministracionFinanzas = 'checked'; 
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ASUNTOSAGRARIOS')
                                                    $chkAsuntosAgrariosAdic = 'checked';           
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ASUNTOSCOOPERATIVOS')
                                                    $chkAsuntosCooperativos = 'checked';
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ASUNTOSNINEZ')
                                                    $chkAsuntosNinez = 'checked';
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ASUNTOSENERGETICOS')
                                                    $chkAsuntosEnergeticos = 'checked';
                                                                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ASUNTOSINTERNACIONA')
                                                    $chkAsuntosInternacionales = 'checked';
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ASUNTOSINTERSINDICA')
                                                    $chkAsuntosInterSindicalesAdic = 'checked';
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ASUNTOSJURILABOR')
                                                    $chkAsuntosJuridicosAdic = 'checked';
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ASUNTOSPOLILEGISLATI')
                                                    $chkAsuntosPoliticosAdic = 'checked';
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'COMUNICACION')
                                                    $chkComunicacionAdic = 'checked';
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'CONFLICTOSLABORALES')
                                                    $chkConflictosLaboralesAdic = 'checked';                                                
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'DERECHOSHUMASINDICA')
                                                    $chkDerechosHumanosAdic = 'checked';   
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ECOLOGIAMEDIOAMBIEN')
                                                    $chkEcologiaMedioAdic = 'checked';   
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ECOLOGIARECURNATURAL')
                                                    $chkEcologiaRecursosAdic = 'checked'; 
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'EDUCACION')
                                                    $chkEducacionAdic = 'checked'; 
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'EDUCACIONINVESTIGA')
                                                    $chkEducacionInvestigacionAdic = 'checked'; 
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'JUVENTUD')
                                                    $chkJuventudAdic = 'checked'; 
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'MEDIOAMBIENTE')
                                                    $chkMedioAmbienteAdic = 'checked'; 
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'MUJER')
                                                    $chkMujerAdic = 'checked'; 
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ORGANIZACION')
                                                    $chkOrganizacionAdic = 'checked'; 
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'ORGANIZACIONSOCIAL')
                                                    $chkOrganizacionSocialesAdic = 'checked';                                                 

                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'PLANEACION')
                                                    $chkPlaneacionAdic = 'checked';                                    
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'PROYECTOS')
                                                    $chkProyectosAdic = 'checked';
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'RELACIONESPUBLICAS')
                                                    $chkRelacionesPublicasAdic = 'checked'; 
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'SECRETARIAACTAS')
                                                    $chkSecretariaActasAdic = 'checked';      
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'SEGURIDADSOCIAL')
                                                    $chkSeguridadSocialAdic = 'checked';                                                      
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'SERVIDORESPUBLICOS')
                                                    $chkServidoresPublicosAdic = 'checked';
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'TRABAJOINFORMAL')
                                                    $chkTrabajoInformalAdic = 'checked';                                                
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'TRANSPORTE')
                                                    $chkTransporteAdic = 'checked';
                                                
                                                if($secretaria['sindicato_secretarias_sindicato_codigo'] == 'OTRASECRETARIA')
                                                    $chkOtraSecretaria = 'checked';                                                                                                
                                            }
                                        }
                                        ?>
                                        
                                        <input type="checkbox" class="check" name="chkAdministracionFinanzas" id='chkAdministracionFinanzas' <?php echo $chkAdministracionFinanzas ?> value="ADMINISTRAFINANZAS">Administración y finanzas                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check"name="chkAsuntosAgrarios" id="chkAsuntosAgrarios" <?php echo $chkAsuntosAgrariosAdic ?> value="ASUNTOSAGRARIOS" >Asuntos Agrarios                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check"name="chkAsuntosCooperativos" id="chkAsuntosCooperativos" <?php echo $chkAsuntosCooperativos ?> value="ASUNTOSCOOPERATIVOS">Asuntos Cooperativos                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check"name="chkAsuntosNinez" id="chkAsuntosNinez" <?php echo $chkAsuntosNinez ?> value="ASUNTOSNINEZ">Asuntos de la Niñez                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check"name="chkAsuntosEnergeticos" id="chkAsuntosEnergeticos" <?php echo $chkAsuntosEnergeticos ?> value="ASUNTOSENERGETICOS">Asuntos Energéticos                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuentosInternacionalesAdic" id="chkAsuentosInternacionalesAdic" <?php echo $chkAsuntosInternacionales ?> value="ASUNTOSINTERNACIONA" >Asuntos Internacionales                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuntosInterSindicalesAdic" id="chkAsuntosInterSindicalesAdic" <?php echo $chkAsuntosInterSindicalesAdic ?> value="ASUNTOSINTERSINDICA">Asuntos Inter-sindicales                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuntosJuridicosAdic" id="chkAsuntosJuridicosAdic" <?php echo $chkAsuntosJuridicosAdic ?> value="ASUNTOSJURILABOR">Asuntos Jurídicos y laborales                                   
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkAsuntosPoliticosAdic" id="chkAsuntosPoliticosAdic" <?php echo $chkAsuntosPoliticosAdic ?> value="ASUNTOSPOLILEGISLATI">Asuntos Políticos y Legislativos                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkComunicacionAdic" id="chkComunicacionAdic" <?php echo $chkComunicacionAdic ?> value="COMUNICACION" >Comunicación                                  
                                        <br/>                                  
                                        <input type="checkbox" class="check" name="chkConflictosLaboralesAdic" id="chkConflictosLaboralesAdic" <?php echo $chkConflictosLaboralesAdic ?> value="CONFLICTOSLABORALES">Conflictos Laborales                                 
                                        <br/>                                 
                                        <input type="checkbox" class="check" name="chkDerechosHumanosAdic" id="chkDerechosHumanosAdic" <?php echo $chkDerechosHumanosAdic ?> value="DERECHOSHUMASINDICA">Derechos Humanos y Sindicales                                 
                                        <br/>                                 
                                        <input type="checkbox" class="check" name="chkEcologiaMedioAdic" id="chkEcologiaMedioAdic" <?php echo $chkEcologiaMedioAdic ?> value="ECOLOGIAMEDIOAMBIEN">Ecología y Medio Ambiente                                   
                                        <br/>                                
                                        <input type="checkbox" class="check" name="chkEcologiaRecursosAdic" id="chkEcologiaRecursosAdic" <?php echo $chkEcologiaRecursosAdic ?> value="ECOLOGIARECURNATURAL">Ecología y Recursos Naturales                          
                                        <br/>                               
                                        <input type="checkbox" class="check" name="chkEducacionAdic" id="chkEducacionAdic" <?php echo $chkEducacionAdic ?> value="EDUCACION" >Educación                                
                                        <br/>                              
                                        <input type="checkbox" class="check" name="chkEducacionInvestigacionAdic" id="chkEducacionInvestigacionAdic" <?php echo $chkEducacionInvestigacionAdic ?> value="EDUCACIONINVESTIGA">Educación e Investigación                           
                                        <br/>                             
                                        <input type="checkbox" class="check" name="chkJuventudAdic" id="chkJuventudAdic" <?php echo $chkJuventudAdic ?> value="JUVENTUD">Juventud                        
                                        <br/>                        
                                        <input type="checkbox" class="check" name="chkMedioAmbienteAdic" id="chkMedioAmbienteAdic" <?php echo $chkMedioAmbienteAdic ?> value="MEDIOAMBIENTE" >Medio Ambiente                 
                                        <br/>                      
                                        <input type="checkbox" class="check" name="chkMujerAdic" id="chkMujerAdic" <?php echo $chkMujerAdic ?> value="MUJER">Mujer                        
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkOrganizacionAdic" id="chkOrganizacionAdic" <?php echo $chkOrganizacionAdic ?> value="ORGANIZACION">Organización                 
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkOrganizacionSocialesAdic" id="chkOrganizacionSocialesAdic" <?php echo $chkOrganizacionSocialesAdic ?> value="ORGANIZACIONSOCIAL">Organizaciones Sociales
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkPlaneacionAdic" id="chkPlaneacionAdic" <?php echo $chkPlaneacionAdic ?> value="PLANEACION">Planeación
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkProyectosAdic" id="chkProyectosAdic" <?php echo $chkProyectosAdic ?> value="PROYECTOS">Proyectos
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkRelacionesPublicasAdic" id="chkRelacionesPublicasAdic" <?php echo $chkRelacionesPublicasAdic ?> value="RELACIONESPUBLICAS">Relaciones Públicas
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkSecretariaActasAdic" id="chkSecretariaActasAdic" <?php echo $chkSecretariaActasAdic ?> value="SECRETARIAACTAS">Secretaría de Actas
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkSeguridadSocialAdic" id="chkSeguridadSocialAdic" <?php echo $chkSeguridadSocialAdic ?> value="SEGURIDADSOCIAL">Seguridad Social
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkServidoresPublicosAdic" id="chkServidoresPublicosAdic" <?php echo $chkServidoresPublicosAdic ?> value="SERVIDORESPUBLICOS">Servidores Públicos
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkTrabajoInformalAdic" id="chkTrabajoInformalAdic" <?php echo $chkTrabajoInformalAdic ?> value="TRABAJOINFORMAL">Trabajo Informal
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkTransporteAdic" id="chkTransporteAdic" <?php echo $chkTransporteAdic ?> value="TRANSPORTE">Transporte
                                        <br/>                          
                                        <input type="checkbox" class="check" name="chkOtraSecretaria" id="chkOtraSecretaria" <?php echo $chkOtraSecretaria ?> value="OTRASECRETARIA" >Otra                                        
                                    </td>                 
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Cuáles ?</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtOtraSecretaria" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> id="txtOtraSecretaria" value="<?php echo $registro["otras_secretarias"]?>" />
                                    </td>
                                </tr>                                                                
                                <tr>          
                                    <td align="left" class="tdFormulario">        
                                        <label>Fecha última Inscripción Junta Directiva</label>      
                                    </td>                       
                                    <td align="left" class="tdFormulario">    
                                        <input type="text" <?php if($consultar != "1") echo 'id="datepicker6"' ?> name="txtFechaUltimaInscJunta" <?php echo $soloLectura; ?> class="fechas" value="<?php if($registro["fecha_ultima_inscripcion_junta_directiva"] != '0000-00-00') echo $registro["fecha_ultima_inscripcion_junta_directiva"]; ?>" />
                                    </td>       
                                </tr>                   
                                <tr>                        
                                    <td align="left" class="tdFormulario">        
                                        <label>Periodo Vigencia Junta Directiva</label>
                                    </td>
                                    <td align="left" class="tdFormulario">           
                                        <div class="divControl">
                                            <select name="sltPeriodoVigJuntaDirectiva" id="sltPeriodoVigJuntaDirectiva">               
                                                <option value=""> Seleccionar </option>  
                                                <?php  
                                                    LlenarSelectOption($periodoVigencia, $registro["periodo_vigencia_junta_directiva_codigo"])       
                                                ?>        
                                            </select>            
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                 
                                    </td>                 
                                </tr>                          
                                <tr>              
                                    <td align="left" class="tdFormulario">                
                                        <label>Número Total de Afiliados</label>
                                    </td>                   
                                    <td align="left" class="tdFormulario">  
                                        <input type="text" name="txtNumeroTotalAfiliados" id="txtNumeroTotalAfiliados" <?php echo $soloLectura; ?> value="<?php echo $registro["numero_total_afiliados"]?>" />
                                    </td>                    
                                </tr>                       
                                <tr>    
                                    <td align="left" class="tdMiddle">         
                                        <label>Descripción Afiliados Por Empresa</label>
                                    </td>                       
                                    <td align="left" class="tdFormulario">                                               
                                        <textarea rows="7" cols="45" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> name="txtDescripcionAfiliadosEmpresa" id="txtDescripcionAfiliadosEmpresa"><?php echo $registro["descripcion_afiliados_empresa"]?></textarea>
                                    </td>                    
                                </tr>                     
                                <tr>                         
                                    <td align="left" class="tdFormulario">          
                                        <label>Número  Afiliados Hombres</label>               
                                    </td>                    
                                    <td align="left" class="tdFormulario">           
                                        <input type="text" name="txtNumeroAfiliadosHombres" <?php echo $soloLectura; ?> value="<?php echo $registro["numero_afiliados_hombres"]?>" />        
                                    </td>                  
                                </tr>                        
                                <tr>                          
                                    <td align="left" class="tdFormulario">         
                                        <label>Número  Afiliados Mujeres</label>
                                    </td>                          
                                    <td align="left" class="tdFormulario">          
                                        <input type="text" name="txtNumeroAfiliadosMujeres" <?php echo $soloLectura; ?> value="<?php echo $registro["numero_afiliados_mujeres"]?>" />    
                                    </td>                    
                                </tr>                        
                                <tr>                 
                                    <td align="left" class="tdFormulario">       
                                        <label>Número  Afiliados Jóvenes  (menores de 35)</label>      
                                    </td>             
                                    <td align="left" class="tdFormulario">    
                                        <input type="text" name="txtNumeroAfiliadosJovenes35" <?php echo $soloLectura; ?> value="<?php echo $registro["numero_afiliados_jovenes_menor_35"]?>" />   
                                    </td>                     
                                </tr>                   
                                <tr>                        
                                    <td align="left" class="tdFormulario">        
                                        <label>Número  Afiliados Sector Formal</label>     
                                    </td>                     
                                    <td align="left" class="tdFormulario">     
                                        <input type="text" name="txtNumeroAfiliadosSectorFormal" <?php echo $soloLectura; ?> value="<?php echo $registro["numero_afiliados_sector_formal"]?>" />     
                                    </td>                      
                                </tr>                         
                                <tr>                         
                                    <td align="left" class="tdFormulario">       
                                        <label>Número  Afiliados Sector Informal</label>          
                                    </td>                         
                                    <td align="left" class="tdFormulario">       
                                        <input type="text" name="txtNumeroAfiliadosSectorInformal" <?php echo $soloLectura; ?> value="<?php echo $registro["numero_afiliados_sector_informal"]?>" />        
                                    </td>                        
                                </tr>                        
                                <tr>                           
                                    <td align="left" class="tdMiddle">      
                                        <label>Medio de Comunicación</label>               
                                    </td>                              
                                    <td align="left" class="tdFormulario">    
                                        <?php
                                        $chkBoletin = '';
                                        $chkPeriodico = '';
                                        $chkProgramaRadio = '';
                                        $chkTelevision = '';
                                        
                                        if(count($mediosComunicacion) > 0)
                                        {                                            
                                            foreach ($mediosComunicacion as $medio)
                                            {                                                
                                                if($medio['sindicato_medio_comunicacion_codigo'] == 'BOLETIN')
                                                    $chkBoletin = 'checked';
                                                
                                                if($medio['sindicato_medio_comunicacion_codigo'] == 'PERIODICO')
                                                    $chkPeriodico = 'checked';
                                                
                                                if($medio['sindicato_medio_comunicacion_codigo'] == 'PROGRAMARADIO')
                                                    $chkProgramaRadio = 'checked';
                                                
                                                if($medio['sindicato_medio_comunicacion_codigo'] == 'TELEVISION')
                                                    $chkTelevision = 'checked';
                                            }
                                        }
                                        ?>
                                        <input type="checkbox" class="check" name="chkBoletin" id='chkBoletin' value="BOLETIN" <?php echo $chkBoletin ?>>Boletín
                                        <br/>
                                        <input type="checkbox" class="check" name="chkPeriodico" id='chkPeriodico' value="PERIODICO" <?php echo $chkPeriodico ?>>Periódico
                                        <br/>
                                        <input type="checkbox" class="check" name="chkProgramaRadio" id='chkProgramaRadio' value="PROGRAMARADIO" <?php echo $chkProgramaRadio ?>>Programa radio
                                        <br/>
                                        <input type="checkbox" class="check" name="chkTelevision" id='chkTelevision' value="TELEVISION" <?php echo $chkTelevision ?>>Televisión
                                    </td>                       
                                </tr>                      
                                <tr>                     
                                    <td align="left" class="tdFormulario">       
                                        <label>Estado Sindicato</label>
                                    </td>                          
                                    <td align="left" class="tdFormulario">    
                                        <div class="divControl">
                                            <select name="sltEstado" id="sltEstado">        
                                                <option value=""> Seleccionar </option>    
                                                <?php           
                                                LlenarSelectOption($estadoSindicato, $registro["estado_codigo"])   
                                                ?>           
                                            </select>                         
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                        
                                    </td>                      
                                </tr>                         
                                <tr>                           
                                    <td align="left">           
                                        <label>Característica  para  Sindicato Inactivo</label>       
                                    </td>                              
                                    <td align="left" class="tdFormulario">                                             
                                        <select name="sltCaracteristicasSindicatoInactivo" id="sltCaracteristicasSindicatoInactivo">   
                                            <option value=""> Seleccionar </option>      
                                            <?php     
                                            LlenarSelectOption($caracteristicasSindicatInac, $registro["caracteristicas_sindicato_inactivo_codigo"])  
                                            ?>     
                                        </select>                                        
                                    </td>                     
                                </tr>                                                         
                                <tr>                     
                                    <td align="left" class="tdFormulario">      
                                        <label>Nombre Sindicato al que se  Fusiona</label>   
                                    </td>                         
                                    <td align="left" class="tdFormulario">  
                                        <input type="text" name="txtNombreSindicatoFusiona" onkeyup = "this.value=this.value.toUpperCase()" id="txtNombreSindicatoFusiona" <?php echo $soloLectura; ?> value="<?php echo $registro["sindicato_fusionado"]?>" /> 
                                    </td>                      
                                </tr>                        
                                <tr>                  
                                    <td align="left" class="tdMiddle">         
                                        <label>Descuento de Cuota Sindical para la Central</label>          
                                    </td>              
                                    <td align="left" class="tdFormulario">       
                                        <input type="radio" class="radio" <?php if($registro["descuento_directo_cuota_sindical"] == 1) echo 'checked'; ?> name="rdbDescuentoCuotaSindical" value="1">Si     
                                        <br/>               
                                        <input type="radio" class="radio" <?php if($registro["descuento_directo_cuota_sindical"] == 0) echo 'checked'; ?> name="rdbDescuentoCuotaSindical" value="0">No  
                                    </td>               
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Bienes Inmuebles de Propiedad del Sindicato</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <?php
                                        $chkCentroRecreativo = '';
                                        $chkOtrosBienesInmuebles = '';
                                        $chkSedePropia = '';                                        
                                        
                                        if(count($bienInmueble) > 0)
                                        {                                            
                                            foreach ($bienInmueble as $inmueble)
                                            {                                                
                                                if($inmueble['bien_inmueble_codigo'] == 'CENTROECREATIVO')
                                                    $chkCentroRecreativo = 'checked';
                                                
                                                if($inmueble['bien_inmueble_codigo'] == 'OTROSBIENESINMUEBLES')
                                                    $chkOtrosBienesInmuebles = 'checked';
                                                
                                                if($inmueble['bien_inmueble_codigo'] == 'SEDEPROPIA')
                                                    $chkSedePropia = 'checked';

                                            }
                                        }
                                        ?>
                                        <input type="checkbox" class="check" name="chkCentroRecreativo" id='chkCentroRecreativo' value="CENTROECREATIVO" <?php echo $chkCentroRecreativo ?>>Centro Recreativo
                                        <br/>
                                        <input type="checkbox" class="check" name="chkOtrosBienesInmuebles" id='chkOtrosBienesInmuebles' value="OTROSBIENESINMUEBLES" <?php echo $chkOtrosBienesInmuebles ?>>Otros Bienes Inmuebles
                                        <br/>
                                        <input type="checkbox" class="check" name="chkSedePropia" id='chkSedePropia' value="SEDEPROPIA" <?php echo $chkSedePropia ?>>Sede Propia
                                    </td>
                                </tr>                                                                
                                <tr>                  
                                    <td align="left" class="tdFormulario">   
                                        <label>Otros Bienes Inmuebles</label>     
                                    </td>
                                    <td align="left" class="tdFormulario">  
                                        <input type="text" name="txtOtrosBienesInmubles" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> id="txtOtrosBienesInmubles" value="<?php echo $registro["otros_bienes_inmuebles"]?>" />    
                                    </td>                       
                                </tr>             
                                <tr>                       
                                    <td align="left" class="tdFormulario">     
                                        <label>Fecha última Actualización Información</label>
                                    </td>                          
                                    <td align="left" class="tdFormulario">      
                                        <input type="text" <?php if($consultar != "1") echo 'id="txtFechaUltimaActualizacion"' ?> name="txtFechaUltimaActualizacion" <?php echo $soloLectura; ?> class="fechas" value="<?php if($registro["fecha_ultima_actualizacion_informacion"] != "0000-00-00") echo $registro["fecha_ultima_actualizacion_informacion"]?>" />       
                                    </td>                       
                                </tr>                         
                                <tr>                         
                                    <td align="left" class="tdMiddle">         
                                        <label>Observaciones</label>
                                    </td>                       
                                    <td align="left" class="tdFormulario">       
                                        <textarea rows="7" cols="45" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> name="txtObservaciones"><?php echo $registro["observaciones"]?></textarea>
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
                            <table align="left" width="700px">                          
                                <tr>                              
                                    <td align="left" class="tdFormulario">                                  
                                        <label>Clase de Sindicato</label>
                                    </td>                         
                                    <td align="left" class="tdFormulario">              
                                        <div class="divControl">
                                            <select name="sltClaseSindicato" id="sltClaseSindicato">                 
                                                <option value=""> Seleccionar </option>                     
                                                <?php                                                              
                                                LlenarSelectOption($claseSindicato, $registro["clase_sindicato_codigo"])
                                                ?>                                 
                                            </select> 
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>
                                    </td> 
                                </tr>       
                                <tr>        
                                    <td align="left" class="tdFormulario">    
                                        <label>Sindicato Según Origen</label>   
                                    </td>       
                                    <td align="left" class="tdFormulario">     
                                        <div class="divControl">
                                            <select name="sltSindicatoSegOriCap" id="sltSindicatoSegOriCap">                  
                                                <option value=""> Seleccionar </option>            
                                                <?php                                 
                                                LlenarSelectOption($sindicatoOri, $registro["sindicato_x_origen_capital_empresa_codigo"])
                                                ?>
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                             
                                    </td>
                                </tr>
                                <tr>            
                                    <td align="left" class="tdFormulario">    
                                        <label>Sindicato Según Origen del Capital de La Empresa</label>     
                                    </td>                  
                                    <td align="left" class="tdFormulario">                                                         
                                        <div class="divControl">
                                            <select name="sltSindicatoSegCapEmp" id="sltSindicatoSegCapEmp">    
                                                <option value=""> Seleccionar </option>            
                                                <?php              
                                                LlenarSelectOption($sindicatoOriCap, $registro["tipo_sindicato_x_origen_capital_empresa_codigo"])           
                                                ?>              
                                            </select>
                                        </div>                                                                                               
                                    </td>         
                                </tr>
                                <tr>   
                                    <td align="left" class="tdFormulario">   
                                        <label>Sindicato Según Tipo de Empresa Estatal</label>
                                    </td>                           
                                    <td align="left" class="tdFormulario">                
                                        <div class="divControl">
                                            <select name="sltSindicatoSegTipEmprEst" id="sltSindicatoSegTipEmprEst">                    
                                                <option value=""> Seleccionar </option>     
                                                <?php                                 
                                                LlenarSelectOption($sindicatoTipoEmprEst, $registro["tipo_sindicato_x_empresa_estatal_codigo"])
                                                ?>
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                          
                                    </td>               
                                </tr>                  
                                <tr>                   
                                    <td align="left" class="tdFormulario">              
                                        <label>Sindicato Estatal Según Modalidad del Contrato</label>          
                                    </td>                       
                                    <td align="left" class="tdFormulario">        
                                        <div class="divControl">
                                            <select name="sltSindicatoEstModaContra" id="sltSindicatoEstModaContra">                   
                                                <option value=""> Seleccionar </option>           
                                                <?php                                 
                                                LlenarSelectOption($sindicatoEstModaContra, $registro["tipo_sindicato_estatal_x_modalidad_contra_codigo"])
                                                ?>
                                            </select> 
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                         
                                    </td>                    
                                </tr>                    
                                <tr>                        
                                    <td align="left" class="tdFormulario">         
                                        <label>Actividad Económica de Servicio Público Esencial</label>  
                                    </td>                          
                                    <td align="left" class="tdFormulario">        
                                        <input type="radio" class="radio" name="rdbActividadEconomicaServPub" <?php if($registro["actividad_economica_servicio_publico"] == 1) echo 'checked'; ?> value="1">Si    
                                        <br/>                        
                                        <input type="radio" class="radio" name="rdbActividadEconomicaServPub" <?php if($registro["actividad_economica_servicio_publico"] == 0) echo 'checked'; ?> value="0">No      
                                    </td>            
                                </tr>                 
                                <tr>                        
                                    <td align="left" class="tdFormulario">         
                                        <label>Han Sido Victimas de Violencia</label>  
                                    </td>                          
                                    <td align="left" class="tdFormulario">        
                                        <input type="radio" class="radio" name="rdbVictimaViolencia" id="rdbVictimaViolenciaSi" <?php if($registro["victima_violencia"] == 1) echo 'checked'; ?> value="1">Si    
                                        <br/>                        
                                        <input type="radio" class="radio" name="rdbVictimaViolencia" id="rdbVictimaViolenciaNo" <?php if($registro["victima_violencia"] == 0) echo 'checked'; ?> value="0">No      
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Que tipo de Violencia</label>
                                    </td>
                                    <td align="left" width="700px" >
                                        <?php
                                        $chkAllanamientoIlegal = '';
                                        $chkAmenazas = '';
                                        $chkAtentadoLesiones = '';
                                        $chkDesaparicion = '';
                                        $chkDesplazamientoForzoso = '';
                                        $chkDetencionArbitraria = '';
                                        $chkHomicidios = '';
                                        $chkHostigamiento = '';
                                        $chkSecuestro = '';
                                        $chkOtroTipoViolencia = '';
                                        
                                        if(count($tipoViolencia) > 0)
                                        {                                            
                                            foreach ($tipoViolencia as $otroTipoViolencia)
                                            {                                                
                                                if($otroTipoViolencia['violencia_sindicato'] == 'ALLANAMIENTOILEGAL')
                                                    $chkAllanamientoIlegal = 'checked';
                                                
                                                if($otroTipoViolencia['violencia_sindicato'] == 'AMENAZAS')
                                                    $chkAmenazas = 'checked';
                                                
                                                if($otroTipoViolencia['violencia_sindicato'] == 'ATENTADOLESIONES')
                                                    $chkAtentadoLesiones = 'checked';
                                                
                                                if($otroTipoViolencia['violencia_sindicato'] == 'DESAPARICION')
                                                    $chkDesaparicion = 'checked';
                                                
                                                if($otroTipoViolencia['violencia_sindicato'] == 'DESPLAZADOFORZOSO')
                                                    $chkDesplazamientoForzoso = 'checked';                                                
                                                
                                                if($otroTipoViolencia['violencia_sindicato'] == 'DETENCIONARBITRARIA')
                                                    $chkDetencionArbitraria = 'checked';
                                                
                                                if($otroTipoViolencia['violencia_sindicato'] == 'HOMICIDIOS')
                                                    $chkHomicidios = 'checked';
                                                
                                                if($otroTipoViolencia['violencia_sindicato'] == 'HOSTIGAMIENTO')
                                                    $chkHostigamiento = 'checked';
                                                
                                                if($otroTipoViolencia['violencia_sindicato'] == 'SECUESTRO')
                                                    $chkSecuestro = 'checked';    
                                                
                                                if($otroTipoViolencia['violencia_sindicato'] == 'OTROTIPOVIOLENCIA')
                                                    $chkOtroTipoViolencia = 'checked';

                                            }
                                        }
                                        ?>
                                        <input type="checkbox" class="check" name="chkAllanamientoIlegal" id='chkAllanamientoIlegal' value="ALLANAMIENTOILEGAL" <?php echo $chkAllanamientoIlegal ?>>Allanamiento Ilegal
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAmenazas" id='chkAmenazas' value="AMENAZAS" <?php echo $chkAmenazas ?>>Amenazas
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAtentadoLesiones" id='chkAtentadoLesiones' value="ATENTADOLESIONES" <?php echo $chkAtentadoLesiones ?>>Atentado con o sin Lesiones
                                        <br/>
                                        <input type="checkbox" class="check" name="chkDesaparicion" id='chkDesaparicion' value="DESAPARICION" <?php echo $chkDesaparicion ?>>Desaparición
                                        <br/>
                                        <input type="checkbox" class="check" name="chkDesplazamientoForzoso" id='chkDesplazamientoForzoso' value="DESPLAZADOFORZOSO" <?php echo $chkDesplazamientoForzoso ?>>Desplazamiento Forzoso
                                        <br/>
                                        <input type="checkbox" class="check" name="chkDetencionArbitraria" id='chkDetencionArbitraria' value="DETENCIONARBITRARIA" <?php echo $chkDetencionArbitraria ?>>Detención Arbitraria
                                        <br/>
                                        <input type="checkbox" class="check" name="chkHomicidios" id='chkHomicidios' value="HOMICIDIOS" <?php echo $chkHomicidios ?>>Homicidios
                                        <br/>
                                        <input type="checkbox" class="check" name="chkHostigamiento" id='chkHostigamiento' value="HOSTIGAMIENTO" <?php echo $chkHostigamiento ?>>Hostigamiento
                                        <br/>
                                        <input type="checkbox" class="check" name="chkSecuestro" id='chkSecuestro' value="SECUESTRO" <?php echo $chkSecuestro ?>>Secuestro
                                        <br/>                                        
                                        <input type="checkbox" class="check" name="chkOtroTipoViolencia" id='chkOtroTipoViolencia' value="OTROTIPOVIOLENCIA" <?php echo $chkOtroTipoViolencia ?>>Otro Tipo de Violencia                                        
                                    </td>
                                </tr>                                 
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Cuáles ?</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtOtroTipoViolencia" id="txtOtroTipoViolencia" onkeyup = "this.value=this.value.toUpperCase()" <?php echo $soloLectura; ?> id="txtOtraSecretaria" value="<?php echo $registro["otro_tipo_violencia"]?>" />
                                    </td>
                                </tr>                                                                                                
                            </table>                   
                        </fieldset>  
                    </div>            
                </div>            
                <div id="contact-contentMod" class="contentblock hidden">          
                    <div align="center">               
                        <fieldset align="center">             
                            <legend align="left" class="legend"></legend> 
                            <table align="left" width="700px">      
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Afiliación federación regional Y/O seccional</label>
                                    </td>
                                    <td align="left" width="700px" >
                                        <?php
                                        $chkAntioquia = '';
                                        $chkBogota = '';
                                        $chkBolivar = '';
                                        $chkCaldas = '';
                                        $chkCesar = '';
                                        $chkCordoba = '';
                                        $chkFedetral = '';
                                        $chkFedetrar = '';
                                        $chkFertrasuccol = '';
                                        $chkFesinuvalc = '';
                                        $chkFestratol = '';
                                        $chkFetrabol = '';
                                        $chkFetralmag = '';
                                        $chkFetralna = '';
                                        $chkFetralnorte = '';
                                        $chkSantander = '';
                                        $chkValledelcauca = '';
                                        
                                        if(count($afiliacionSubdirectivaRegional) > 0)
                                        {                                            
                                            foreach ($afiliacionSubdirectivaRegional as $subdirectivaRegional)
                                            {                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'ANTIOQUIA')
                                                    $chkAntioquia = 'checked';
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'BOGOTA')
                                                    $chkBogota = 'checked';
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'BOLIVAR')
                                                    $chkBolivar = 'checked';
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'CALDAS')
                                                    $chkCaldas = 'checked';
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'CESAR')
                                                    $chkCesar = 'checked';                                                
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'CORDOBA')
                                                    $chkCordoba = 'checked';
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'FEDETRAL')
                                                    $chkFedetral = 'checked';
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'FEDETRAR')
                                                    $chkFedetrar = 'checked';
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'FERTRASUCCOL')
                                                    $chkFertrasuccol = 'checked';    
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'FESINUVALC')
                                                    $chkFesinuvalc = 'checked';
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'FESTRATOL')
                                                    $chkFestratol = 'checked';                                                

                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'FETRABOL')
                                                    $chkFetrabol = 'checked';

                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'FETRALMAG')
                                                    $chkFetralmag = 'checked';
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'FETRALNA')
                                                    $chkFetralna = 'checked';
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'FETRALNORTE')
                                                    $chkFetralnorte = 'checked';                                                
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'SANTANDER')
                                                    $chkSantander = 'checked';
                                                
                                                if($subdirectivaRegional['afiliacion_subdirectiva_regional_codigo'] == 'VALLEDELCAUCA')
                                                    $chkValledelcauca = 'checked';                                                
                                            }
                                        }
                                        ?>
                                        <input type="checkbox" class="check" name="chkFedetral" id='chkFedetral' value="FEDETRAL" <?php echo $chkFedetral ?>>FEDETRAL –  Federación de Trabajadores del Atlántico
                                        <br/>
                                        <input type="checkbox" class="check" name="chkFedetrar" id='chkFedetrar' value="FEDETRAR" <?php echo $chkFedetrar ?>>FEDETRAR – Federación Regional de Trabajadores del Eje Cafetero
                                        <br/>
                                        <input type="checkbox" class="check" name="chkFertrasuccol" id='chkFertrasuccol' value="FERTRASUCCOL" <?php echo $chkFertrasuccol ?>>FERTRASUCCOL – Federación Regional de Trabajadores del Suroccidente Colombiano
                                        <br/>
                                        <input type="checkbox" class="check" name="chkFesinuvalc" id='chkFesinuvalc' value="FESINUVALC" <?php echo $chkFesinuvalc ?>>FESINUVALC – Federación de Sindicatos Unidos del Valle del Cauca
                                        <br/>
                                        <input type="checkbox" class="check" name="chkFestratol" id='chkFestratol' value="FESTRATOL" <?php echo $chkFestratol ?>>FESTRATOL – Federación Sindical de Trabajadores del Tolima
                                        <br/>
                                        <input type="checkbox" class="check" name="chkFetrabol" id='chkFetrabol' value="FETRABOL" <?php echo $chkFetrabol ?>>FETRABOL –  Federación de Trabajadores de Bolívar
                                        <br/>
                                        <input type="checkbox" class="check" name="chkFetralmag" id='chkFetralmag' value="FETRALMAG" <?php echo $chkFetralmag ?>>FETRALMAG – Federación de Trabajadores Libres del Magdalena
                                        <br/>
                                        <input type="checkbox" class="check" name="chkFetralna" id='chkFetralna' value="FETRALNA" <?php echo $chkFetralna ?>>FETRALNA – Federación de Trabajadores Libres de Nariño
                                        <br/>
                                        <input type="checkbox" class="check" name="chkFetralnorte" id='chkFetralnorte' value="FETRALNORTE" <?php echo $chkFetralnorte ?>>FETRALNORTE – Federación de Trabajadores Libres del Norte de Santander
                                        <br/>                                        
                                        <input type="checkbox" class="check" name="chkAntioquia" id='chkAntioquia' value="ANTIOQUIA" <?php echo $chkAntioquia ?>>Seccional Antioquia
                                        <br/>
                                        <input type="checkbox" class="check" name="chkBogota" id='chkBogota' value="BOGOTA" <?php echo $chkBogota ?>>Seccional Bogotá
                                        <br/>
                                        <input type="checkbox" class="check" name="chkBolivar" id='chkBolivar' value="BOLIVAR" <?php echo $chkBolivar ?>>Seccional Bolívar
                                        <br/>
                                        <input type="checkbox" class="check" name="chkCaldas" id='chkCaldas' value="CALDAS" <?php echo $chkCaldas ?>>Seccional Caldas
                                        <br/>
                                        <input type="checkbox" class="check" name="chkCesar" id='chkCesar' value="CESAR" <?php echo $chkCesar ?>>Seccional Cesar
                                        <br/>
                                        <input type="checkbox" class="check" name="chkCordoba" id='chkCordoba' value="CORDOBA" <?php echo $chkCordoba ?>>Seccional Córdoba
                                        <br/>
                                        <input type="checkbox" class="check" name="chkSantander" id='chkSantander' value="SANTANDER" <?php echo $chkSantander ?>>Seccional Santander
                                        <br/>
                                        <input type="checkbox" class="check" name="chkValledelcauca" id='chkValledelcauca' value="VALLEDELCAUCA" <?php echo $chkValledelcauca ?>>Seccional Valle del Cauca
                                    </td>
                                </tr>     
                                <tr>                                    
                                    <td align="left">                                   
                                    </td>                              
                                    <td align="left" class="tdFormulario">              
                                    </td>                   
                                </tr>                                                                                       
                                <tr>              
                                    <td align="left">    
                                        <label>Federación de Afiliación</label>
                                    </td>           
                                    <td align="left" class="tdFormulario">              
                                        <div class="divControl">
                                            <select name="sltFederacionAfiliacion" id="sltFederacionAfiliacion">
                                                <option value=""> Seleccionar </option>  
                                                <?php                                 
                                                LlenarSelectOption($federacionAfiliacion, $registro["federacion_registro_sindical"])
                                                ?>
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                                   
                                    </td>   
                                </tr>                                                
                                <tr>              
                                    <td align="left">    
                                        <label>Afiliación a Federación de Rama</label>
                                    </td>           
                                    <td align="left" class="tdFormulario">              
                                        <div class="divControl">
                                            <select name="sltAfiliacionFedRama" id="sltAfiliacionFedRama">
                                                <option value=""> Seleccionar </option>  
                                                <?php                                 
                                                LlenarSelectOption($afiliaFederaRama, $registro["afiliacion_federacion_rama_codigo"])
                                                ?>
                                            </select>
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                                   
                                    </td>   
                                </tr>                
                                <tr>                    
                                    <td align="left" class="tdFormulario">             
                                        <label>Central sindical de donde proviene</label>           
                                    </td>               
                                    <td align="left" class="tdFormulario">    
                                        <div class="divControl">
                                            <select name="sltCentralSindProv" id="sltCentralSindProv">               
                                                <option value=""> Seleccionar </option>        
                                                <?php                                 
                                                LlenarSelectOption($centralSindicProv, $registro["central_sindical_codigo"])
                                                ?>
                                            </select>  
                                        </div>                                            
                                        <div class="campoObligatorio">*</div>                                                       
                                    </td>                       
                                </tr>                
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Afiliación Internacional</label>
                                    </td>
                                    <td align="left" width="700px" >
                                        <?php
                                        $chkBwi = '';
                                        $chkEi = '';
                                        $chkIaea = '';                                        
                                        $chkIfj = '';
                                        $chkIndustryAll = '';
                                        $chkItf = '';                                        
                                        $chkIuf = '';
                                        $chkPsi = '';
                                        $chkUni = '';                                                                                
                                        $chkNoAfiliado = '';                                                                                
                                        
                                        if(count($afiliacionInternacional) > 0)
                                        {                                            
                                            foreach ($afiliacionInternacional as $internacional)
                                            {                                                
                                                if($internacional['afiliacion_internacional_codigo'] == 'BWI')
                                                    $chkBwi = 'checked';
                                                
                                                if($internacional['afiliacion_internacional_codigo'] == 'EI')
                                                    $chkEi = 'checked';
                                                
                                                if($internacional['afiliacion_internacional_codigo'] == 'IAEA')
                                                    $chkIaea = 'checked';
                                                
                                                if($internacional['afiliacion_internacional_codigo'] == 'IFJ')
                                                    $chkIfj = 'checked';
                                                
                                                if($internacional['afiliacion_internacional_codigo'] == 'INDUSTRYALL')
                                                    $chkIndustryAll = 'checked';
                                                
                                                if($internacional['afiliacion_internacional_codigo'] == 'ITF')
                                                    $chkItf = 'checked';

                                                if($internacional['afiliacion_internacional_codigo'] == 'IUF')
                                                    $chkIuf = 'checked';
                                                
                                                if($internacional['afiliacion_internacional_codigo'] == 'PSI')
                                                    $chkPsi = 'checked';
                                                
                                                if($internacional['afiliacion_internacional_codigo'] == 'UNI')
                                                    $chkUni = 'checked';                          
                                                
                                                if($internacional['afiliacion_internacional_codigo'] == 'NOAFILIADO')
                                                    $chkNoAfiliado = 'checked';                                                                        

                                            }
                                        }
                                        ?>
                                        <input type="checkbox" class="check" name="chkBwi" id='chkBwi' value="BWI" <?php echo $chkBwi ?>>BWI (Internacional de los trabajadores de la Construcción y la Madera)
                                        <br/>
                                        <input type="checkbox" class="check" name="chkEi" id='chkEi' value="EI" <?php echo $chkEi ?>>EI (Federación Sindical Internacional de Maestros y Educadores)
                                        <br/>
                                        <input type="checkbox" class="check" name="chkIaea" id='chkIaea' value="IAEA" <?php echo $chkIaea ?>>IAEA (Internacional de Artistas y Trabajadores del Entretenimiento)
                                        <br/>
                                        <input type="checkbox" class="check" name="chkIfj" id='chkIfj' value="IFJ" <?php echo $chkEi ?>>IFJ ( Federación Internacional de Periodistas)
                                        <br/>
                                        <input type="checkbox" class="check" name="chkIndustryAll" id='chkIndustryAll' value="INDUSTRYALL" <?php echo $chkIndustryAll ?>>INDUSTRIALL  (Min energética e Industrial)
                                        <br/>
                                        <input type="checkbox" class="check" name="chkItf" id='chkItf' value="ITF" <?php echo $chkItf ?>>ITF (Federación Internacional de Transporte)
                                        <br/>
                                        <input type="checkbox" class="check" name="chkIuf" id='chkIuf' value="IUF" <?php echo $chkIuf ?>>IUF (Unión Internacional de Trabajadores de Agricultura y Alimentos)
                                        <br/>
                                        <input type="checkbox" class="check" name="chkPsi" id='chkPsi' value="PSI" <?php echo $chkPsi ?>>PSI (Internacional de Servicios Públicos)
                                        <br/>
                                        <input type="checkbox" class="check" name="chkUni" id='chkUni' value="UNI" <?php echo $chkUni ?>>UNI (Sindicato Global)
                                        <br/>
                                        <input type="checkbox" class="check" name="chkNoAfiliado" id='chkNoAfiliado' value="NOAFILIADO" <?php echo $chkNoAfiliado ?>>No Afiliado
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
                if( $usuario['perfil'] == "Editor Federacion" || $usuario['perfil'] == "Lector Federacion")
                {
            ?> <a href="/index.php/controladorFederacionSindicato">
                <img src="/images/volver.png" width="36" height="36" />
                <br/>        
                   Regresar       
                </a>
            <?php                    
                }
                else {
            ?> <a href="/index.php/controladorSindicato">
                <img src="/images/volver.png" width="36" height="36" />
                <br/>        
                    Regresar       
                </a>       
             <?php           
                }             
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
                <a href="/index.php/controladorSindicato">       
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