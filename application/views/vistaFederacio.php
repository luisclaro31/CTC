<?php
/*
 * Vista Federaciones
 * Excellentiam S.E.
 * Fecha creacion: 18/09/14
 */include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");
$tituloPagina = "Gesti�n Federaciones";$soloLectura = "";
if(isset($error))
    $tab = 'tabAdicionar';
else
    $tab = 'tabConsultar';
if(isset($consultar)){    if($consultar == "1")
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
{    echo form_open('controladorFederacion/AdicionarFederacion');
    echo "<script src='/js/federacionAdicionar.js'></script>";

}
else
{
    echo form_open('controladorFederacion/ModificarFederacion');
    echo "<script src='/js/federacionModificar.js'></script>";

}
/*
 * Mensajes de eliminacion de registros
 */

if(isset($estadoEliminar) && $estadoEliminar == true)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">            
        Se elimino satisfactoriamente.          
        </div>';else if(isset($estadoEliminar) && $estadoEliminar == false)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">            
                Ocurrio un problema al eliminar la federacion.          
                </div>';
/*
 * Mensajes de modificacion de registros
 */

if(isset($estadoModificar) && $estadoModificar == true)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">            
        Se actualizo la federacion satisfactoriamente.          
        </div>';
else
    if(isset($estadoModificar) && $estadoModificar == false)
        echo '<div id="dialogo" align="center" class="ventana" title="Informacion">            
            Error al actualizar la federacion.          
            </div>';

/*
 * Mensajes de adicion de registros
 */

if(isset($estadoAdicionar) && $estadoAdicionar == true)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">            
        Se adicion� la federacion satisfactoriamente.          
        </div>';else if(isset($estadoAdicionar) && $estadoAdicionar == false)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">            
                Error al adicionar la federacion.          
                </div>';

/*
 * Validacion de modo consulta detallada
 */

if(isset($consultar) && $consultar == "1")
    echo "<script src='/js/federacion.js'></script>";
if(count($registros) > 0 && $usuario['perfil'] != 'Administracion')
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
        <table id="table" class="display" cellspacing="0" width="100%">
            <thead class="trTitulo">
            <tr>
                <th></th>
                <th>Rut</th>
                <th>Nombre Federacion</th>
                <th>Siglas</th>
                <th>Estado</th>
                <th>Departamento</th>
                <th>Municipio</th>
                <th>Direcci�n</th>
                <th>Telef�no</th>
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
                        if($usuario['perfil'] == "Lector Federacion")
                            echo '<td>
                                                <a href="/index.php/controladorFederacion/ConsultarFederacion/'.$registro['id_federacion'].'/1" title="Consultar">
                                                    <img src="/images/buscar.png" width="15" height="15" alt="Consultar"/>
                                                </a>
                                            </td>';

                        else if($usuario['perfil'] == "Editor Federacion")
                        {
                            echo '<td>
                                                <a href="/index.php/controladorFederacion/ConsultarFederacion/'.$registro['id_federacion'].'" title="Modificar">
                                                    <img src="/images/editar.jpg" width="15" height="15"  alt="Editar"/>
                                                </a>
                                            </td>';
                        }
                        else
                        {
                            echo '<td>
                                                <a href="/index.php/controladorFederacion/ConsultarFederacion/'.$registro['id_federacion'].'" title="Modificar">
                                                    <img src="/images/editar.jpg" width="15" height="15"  alt="Editar"/>
                                                </a>                          
                                                <br>
                                                <a href="javascript:;" onclick="Confirmar(\'/index.php/controladorFederacion/EliminarFederacion/'.$registro['id_federacion'].'\'); return false;"  title="Eliminar">
                                                    <img src="/images/eliminar.png" width="15" height="15" alt="Eliminar"/>
                                                </a>
                                            </td>';
                        }
                        echo "<td>".$registro['rut']."</td>";
                        echo "<td>".utf8_decode($registro['nombre'])."</td>";
                        echo "<td>".utf8_decode($registro['sigla'])."</th>";
                        echo "<td>".utf8_decode($registro['estado_codigo'])."</td>";
                        echo "<td>".utf8_decode($registro['departamento'])."</td>";
                        echo "<td>".utf8_decode($registro['municipio'])."</td>";
                        echo "<td>".utf8_decode($registro['direccion'])."</td>";
                        echo "<td>".utf8_decode($registro['telefonos'])."</td>";
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
                <a href="/index.php/controladorFederacion/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                    <img src="/images/excel.jpg" width="30" height="30" />
                    <br />
                    Exportar a Excel
                </a>
            </div>
            <div id="divExportarPdf">
                <a href="/index.php/controladorFederacion/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                    <img src="/images/pdf.jpg" width="30" height="30" />
                    <br />
                    Exportar a Pdf
                </a>
            </div>
            <div class="clearBoth"></div>
        </div>
    </div>
    <div id="tabAdicionar">
        <div id="divFederacion" class="clearfix">
            <ul id="sidemenu">
                <li>
                    <a href="#informacion-content" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Federaciones</a>
                </li>
                <li>
                    <a href="#about-content"><i class="icon-info-sign icon-large"></i>Informaci&oacute;n Administrativa</a>
                </li>
                <li>
                    <a href="#contact-content"><i class="icon-envelope icon-large"></i>Afiliaciones Internacionales Federacion</a>
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
                                        <label>Rut</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <input type="text" id="txtRutAdic" name="txtRutAdic" />
                                        </div>
                                        <div class="clearBoth"></div>
                                        <div id="divRutVal" class="fuenteRoja"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>N�mero resoluci�n o registro</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <input type="text" name="txtNumeroResolucionAdic" id="txtNumeroResolucionAdic" />
                                        </div>
                                        <div class="campoObligatorio">*</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label for="">Fecha</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" id="datepicker" name="txtFechaAdic" class="fechas" />
                                        (yyyy-mm-dd)
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Nombre Federaci�n o Seccional</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <input type="text" name="txtNombreFederacionAdic" id="txtNombreSindicatoAdic" />
                                        </div>
                                        <div class="campoObligatorio">*</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Sigla</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtSiglaAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Departamento</label>
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
                                        <label>Direcci�n</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtDireccionAdic"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Tel�fonos</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtTelefonoAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Celular institucional</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtCelularAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Fax</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtFaxAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Correo Electr�nico</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtCorreoAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>P�gina Web</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtPaginaWebAdic" class="inputAmpliado"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Facebook</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtFacebookAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Twiter</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtTwiterAdic" />
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                </div>
                <!--Tab Informaci�n Administrativa-->
                <div id="about-content" class="contentblock hidden">
                    <div align="center">
                        <fieldset align="center">
                            <legend align="left" class="legend"></legend>
                            <table align="left" >
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Secretar�as que Existen en la Federaci�n</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="checkbox" class="check" name="chkAdministracionFinanzasAdic" id='chkAdministracionFinanzasAdic' value="ADMINISTRAFINANZAS">Administraci�n y finanzas
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuntosAgrariosAdic" id="chkAsuntosAgrariosAdic" value="ASUNTOSAGRARIOS" >Asuntos Agrarios
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuntosCooperativosAdic" id="chkAsuntosCooperativosAdic" value="ASUNTOSCOOPERATIVOS">Asuntos Cooperativos
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuntosNinezAdic" id="chkAsuntosNinezAdic" value="ASUNTOSNINEZ">Asuntos de la Ni�ez
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuntosEnergeticosAdic" id="chkAsuntosEnergeticosAdic" value="ASUNTOSENERGETICOS">Asuntos Energ�ticos
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuentosInternacionalesAdic" id="chkAsuentosInternacionalesAdic" value="ASUNTOSINTERNACIONA" >Asuntos Internacionales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuntosInterSindicalesAdic" if="chkAsuntosInterSindicalesAdic" value="ASUNTOSINTERSINDICA">Asuntos Inter-sindicales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuntosJuridicosAdic" id="chkAsuntosJuridicosAdic" value="ASUNTOSJURILABOR">Asuntos Jur�dicos y laborales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuntosPoliticosAdic" id="chkAsuntosPoliticosAdic" value="ASUNTOSPOLILEGISLATI">Asuntos Pol�ticos y Legislativos
                                        <br/>
                                        <input type="checkbox" class="check" name="chkComunicacionAdic" id="chkComunicacionAdic" value="COMUNICACION" >Comunicaci�n
                                        <br/>
                                        <input type="checkbox" class="check" name="chkConflictosLaboralesAdic" id="chkConflictosLaboralesAdic" value="CONFLICTOSLABORALES">Conflictos Laborales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkDerechosHumanosAdic" id="chkDerechosHumanosAdic" value="DERECHOSHUMASINDICA">Derechos Humanos y Sindicales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkEcologiaMedioAdic" id="chkEcologiaMedioAdic" value="ECOLOGIAMEDIOAMBIEN">Ecolog�a y Medio Ambiente
                                        <br/>
                                        <input type="checkbox" class="check" name="chkEcologiaRecursosAdic" id="chkEcologiaRecursosAdic" value="ECOLOGIARECURNATURAL">Ecolog�a y Recursos Naturales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkEducacionAdic" id="chkEducacionAdic" value="EDUCACION" >Educaci�n
                                        <br/>
                                        <input type="checkbox" class="check" name="chkEducacionInvestigacionAdic" id="chkEducacionInvestigacionAdic" value="EDUCACIONINVESTIGA">Educaci�n e Investigaci�n
                                        <br/>
                                        <input type="checkbox" class="check" name="chkJuventudAdic" id="chkJuventudAdic" value="JUVENTUD">Juventud
                                        <br/>
                                        <input type="checkbox" class="check" name="chkMedioAmbienteAdic" id="chkMedioAmbienteAdic" value="MEDIOAMBIENTE" >Medio Ambiente
                                        <br/>
                                        <input type="checkbox" class="check" name="chkMujerAdic" id="chkMujerAdic" value="MUJER">Mujer
                                        <br/>
                                        <input type="checkbox" class="check" name="chkOrganizacionAdic" id="chkOrganizacionAdic" value="ORGANIZACION">Organizaci�n
                                        <br/>
                                        <input type="checkbox" class="check" name="chkOrganizacionSocialesAdic" id="chkOrganizacionSocialesAdic" value="ORGANIZACIONSOCIAL">Organizaciones Sociales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkPlaneacionAdic" id="chkPlaneacionAdic" value="PLANEACION">Planeaci�n
                                        <br/>
                                        <input type="checkbox" class="check" name="chkProyectosAdic" id="chkProyectosAdic" value="PROYECTOS">Proyectos
                                        <br/>
                                        <input type="checkbox" class="check" name="chkRelacionesPublicasAdic" id="chkRelacionesPublicasAdic" value="RELACIONESPUBLICAS">Relaciones P�blicas
                                        <br/>
                                        <input type="checkbox" class="check" name="chkSecretariaActasAdic" id="chkSecretariaActasAdic" value="SECRETARIAACTAS">Secretar�a de Actas
                                        <br/>
                                        <input type="checkbox" class="check" name="chkSeguridadSocialAdic" id="chkSeguridadSocialAdic" value="SEGURIDADSOCIAL">Seguridad Social
                                        <br/>
                                        <input type="checkbox" class="check" name="chkServidoresPublicosAdic" id="chkServidoresPublicosAdic" value="SERVIDORESPUBLICOS">Servidores P�blicos
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
                                        <label>Otras Secretar�as</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtOtraSecretariaAdic" id="txtOtraSecretariaAdic"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdMiddle">
                                        <label>Tipo Federaci�n</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltTipoFederacionAdic" id="sltTipoFederacionAdic">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($tipoFederacion)
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Fecha �ltima Inscripci�n Junta Directiva</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" id="datepicker2" name="txtFechaUltInscrJunDirectivaAdic" class="fechas" />
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
                                    <td align="left" class="tdMiddle">
                                        <label>Medio de Comunicaci�n</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="checkbox" class="check"name="chkBoletinAdic" value="BOLETIN">Bolet�n
                                        <br/>
                                        <input type="checkbox" class="check"name="chkPeriodicoAdic" value="PERIODICO">Peri�dico
                                        <br/>
                                        <input type="checkbox" class="check"name="chkProgramaRadioAdic" value="PROGRAMARADIO">Programa radio
                                        <br/>
                                        <input type="checkbox" class="check"name="chkTelevisionAdic" value="TELEVISION">Televisi�n
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Federaci�n a la que se Fusiona</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtNombreFederacionFusionaAdic" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Bienes Inmuebles de Propiedad de la federacion</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltBienesInmueblesPropAdic" id="sltBienesInmueblesPropAdic">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($bienInmuebleCodigo)
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Otros Bienes Inmuebles</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtOtrosBienesInmueblesAdic" id="txtOtrosBienesInmueblesAdic"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Fecha �ltima Actualizaci�n Informaci�n</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" id="datepicker4" class="fechas" name="txtFechaUltActualizacionInfAdic">
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
                <!--Tab Afiliaciones Internacionales Federacion-->
                <div id="contact-content" class="contentblock hidden">
                    <div align="center">
                        <fieldset align="center">
                            <legend align="left" class="legend"></legend>
                            <table align="left"  >
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Afiliaci�n Internacional</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div>
                                            <div class="divControl">
                                                <select name="sltAfiliacionIntAdic" id="sltAfiliacionIntAdic">
                                                    <option value=""> Seleccionar </option>
                                                    <?php
                                                    LlenarSelectOption($afiliaciInternacio)
                                                    ?>
                                                </select>
                                            </div>
                                            <div id="divValAfiliacionIntAdic" class="divValidacionCampo"></div>
                                            <div class="clearBoth"></div>
                                        </div>
                                    </td>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Otra Afiliaci�n Internacional</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtOtraAfiliacionInternacionalAdic" id="txtOtraAfiliacionInternacionalAdic"/>
                                    </td>
                                </tr>
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
        <div id="divFederacionModificar" class="clearfix">
            <ul id="sidemenuMod">
                <li>
                    <a href="#informacion-contentMod" class="open"><i class="icon-home icon-large"></i>Informaci&oacute;n Federaciones</a>
                </li>
                <li>
                    <a href="#about-contentMod"><i class="icon-info-sign icon-large"></i>Informaci&oacute;n Administrativa</a>
                </li>
                <li>
                    <a href="#contact-contentMod"><i class="icon-envelope icon-large"></i>Afiliaciones Internacionales Federacion</a>
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
                                        <div class="divControl" style="display: none;">
                                            <input type="text" name="txtIdFederacion"  <?php echo $soloLectura; ?> value="<?php echo $registro["id_federacion"] ?>"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Rut</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <?php echo $registro["rut"] ?>
                                        <input type="hidden" name="txtRut" readonly value="<?php echo $registro["rut"] ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Numero resoluci�n o registro</label>
                                    </td>
                                    <td align="left">
                                        <div class="divControl">
                                            <input type="text" name="txtNumeroResolucion" id="txtNumeroResolucion" <?php echo $soloLectura; ?> value="<?php echo $registro["resolucion_registro"]; ?>"/>
                                        </div>
                                        <div class="campoObligatorio">*</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <label>Fecha</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" <?php if($consultar != "1") echo 'id="datepicker3"' ?> name="txtFecha" <?php echo $soloLectura; ?> value="<?php if($registro["fecha_resolucion"] != "0000-00-00") echo $registro["fecha_resolucion"]?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Nombre Federaci�n o Seccional</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <input type="text" name="txtNombreFederacion" id="txtNombreFederacion" <?php echo $soloLectura; ?> value="<?php echo $registro["nombre"] ?>"/>
                                        </div>
                                        <div class="campoObligatorio">*</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Sigla</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtSigla" <?php echo $soloLectura; ?> value="<?php echo $registro["sigla"] ?>"/>
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
                                        <label>Direcci�n</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtDireccion" <?php echo $soloLectura; ?> value="<?php echo $registro["direccion"]?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Tel�fono</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtTelefono" <?php echo $soloLectura; ?> value="<?php echo $registro["telefonos"]?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Celular Institucional</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtCelular" <?php echo $soloLectura; ?> value="<?php echo $registro["celular_institucional"]?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Fax</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtFax" <?php echo $soloLectura; ?> value="<?php echo $registro["fax"]?>"/>
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
                                        <label>P�gina Web</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtPaginaWeb" <?php echo $soloLectura; ?> class="inputAmpliado" value="<?php echo $registro["pagina_web"]?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Facebook</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtFacebook" <?php echo $soloLectura; ?> value="<?php echo $registro["usuario_facebook"]?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Twiter</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtTwiter" <?php echo $soloLectura; ?> value="<?php echo $registro["usuario_twiter"]?>"/>
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
                                        <label>Secretar�as que Existen en la Federaci�n</label>
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
                                        if(count($secretariasFederacion) > 0)
                                        {
                                            foreach ($secretariasFederacion as $secretaria)
                                            {
                                                if($secretaria['secretarias_federacion_codigo'] == 'ADMINISTRAFINANZAS')
                                                    $chkAdministracionFinanzas = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ASUNTOSAGRARIOS')
                                                    $chkAsuntosAgrariosAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ASUNTOSCOOPERATIVOS')
                                                    $chkAsuntosCooperativos = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ASUNTOSNINEZ')
                                                    $chkAsuntosNinez = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ASUNTOSENERGETICOS')
                                                    $chkAsuntosEnergeticos = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ASUNTOSINTERNACIONA')
                                                    $chkAsuntosInternacionales = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ASUNTOSINTERSINDICA')
                                                    $chkAsuntosInterSindicalesAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ASUNTOSJURILABOR')
                                                    $chkAsuntosJuridicosAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ASUNTOSPOLILEGISLATI')
                                                    $chkAsuntosPoliticosAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'COMUNICACION')
                                                    $chkComunicacionAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'CONFLICTOSLABORALES')
                                                    $chkConflictosLaboralesAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'DERECHOSHUMASINDICA')
                                                    $chkDerechosHumanosAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ECOLOGIAMEDIOAMBIEN')
                                                    $chkEcologiaMedioAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ECOLOGIARECURNATURAL')
                                                    $chkEcologiaRecursosAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'EDUCACION')
                                                    $chkEducacionAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'EDUCACIONINVESTIGA')
                                                    $chkEducacionInvestigacionAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'JUVENTUD')
                                                    $chkJuventudAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'MEDIOAMBIENTE')
                                                    $chkMedioAmbienteAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'MUJER')
                                                    $chkMujerAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ORGANIZACION')
                                                    $chkOrganizacionAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'ORGANIZACIONSOCIAL')
                                                    $chkOrganizacionSocialesAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'PLANEACION')
                                                    $chkPlaneacionAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'PROYECTOS')
                                                    $chkProyectosAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'RELACIONESPUBLICAS')
                                                    $chkRelacionesPublicasAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'SECRETARIAACTAS')
                                                    $chkSecretariaActasAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'SEGURIDADSOCIAL')
                                                    $chkSeguridadSocialAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'SERVIDORESPUBLICOS')
                                                    $chkServidoresPublicosAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'TRABAJOINFORMAL')
                                                    $chkTrabajoInformalAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'TRANSPORTE')
                                                    $chkTransporteAdic = 'checked';
                                                if($secretaria['secretarias_federacion_codigo'] == 'OTRASECRETARIA')
                                                    $chkOtraSecretaria = 'checked';
                                            }

                                        }
                                        ?>
                                        <input type="checkbox" class="check" name="chkAdministracionFinanzas" id='chkAdministracionFinanzas' <?php echo $chkAdministracionFinanzas ?> value="ADMINISTRAFINANZAS">Administraci�n y finanzas
                                        <br/>
                                        <input type="checkbox" class="check"name="chkAsuntosAgrarios" id="chkAsuntosAgrarios" <?php echo $chkAsuntosAgrariosAdic ?> value="ASUNTOSAGRARIOS" >Asuntos Agrarios
                                        <br/>
                                        <input type="checkbox" class="check"name="chkAsuntosCooperativos" id="chkAsuntosCooperativos" <?php echo $chkAsuntosCooperativos ?> value="ASUNTOSCOOPERATIVOS">Asuntos Cooperativos
                                        <br/>
                                        <input type="checkbox" class="check"name="chkAsuntosNinez" id="chkAsuntosNinez" <?php echo $chkAsuntosNinez ?> value="ASUNTOSNINEZ">Asuntos de la Ni�ez
                                        <br/>
                                        <input type="checkbox" class="check"name="chkAsuntosEnergeticos" id="chkAsuntosEnergeticos" <?php echo $chkAsuntosEnergeticos ?> value="ASUNTOSENERGETICOS">Asuntos Energ�ticos
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuentosInternacionalesAdic" id="chkAsuentosInternacionalesAdic" <?php echo $chkAsuntosInternacionales ?> value="ASUNTOSINTERNACIONA" >Asuntos Internacionales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuntosInterSindicalesAdic" id="chkAsuntosInterSindicalesAdic" <?php echo $chkAsuntosInterSindicalesAdic ?> value="ASUNTOSINTERSINDICA">Asuntos Inter-sindicales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuntosJuridicosAdic" id="chkAsuntosJuridicosAdic" <?php echo $chkAsuntosJuridicosAdic ?> value="ASUNTOSJURILABOR">Asuntos Jur�dicos y laborales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkAsuntosPoliticosAdic" id="chkAsuntosPoliticosAdic" <?php echo $chkAsuntosPoliticosAdic ?> value="ASUNTOSPOLILEGISLATI">Asuntos Pol�ticos y Legislativos
                                        <br/>
                                        <input type="checkbox" class="check" name="chkComunicacionAdic" id="chkComunicacionAdic" <?php echo $chkComunicacionAdic ?> value="COMUNICACION" >Comunicaci�n
                                        <br/>
                                        <input type="checkbox" class="check" name="chkConflictosLaboralesAdic" id="chkConflictosLaboralesAdic" <?php echo $chkConflictosLaboralesAdic ?> value="CONFLICTOSLABORALES">Conflictos Laborales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkDerechosHumanosAdic" id="chkDerechosHumanosAdic" <?php echo $chkDerechosHumanosAdic ?> value="DERECHOSHUMASINDICA">Derechos Humanos y Sindicales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkEcologiaMedioAdic" id="chkEcologiaMedioAdic" <?php echo $chkEcologiaMedioAdic ?> value="ECOLOGIAMEDIOAMBIEN">Ecolog�a y Medio Ambiente
                                        <br/>
                                        <input type="checkbox" class="check" name="chkEcologiaRecursosAdic" id="chkEcologiaRecursosAdic" <?php echo $chkEcologiaRecursosAdic ?> value="ECOLOGIARECURNATURAL">Ecolog�a y Recursos Naturales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkEducacionAdic" id="chkEducacionAdic" <?php echo $chkEducacionAdic ?> value="EDUCACION" >Educaci�n
                                        <br/>
                                        <input type="checkbox" class="check" name="chkEducacionInvestigacionAdic" id="chkEducacionInvestigacionAdic" <?php echo $chkEducacionInvestigacionAdic ?> value="EDUCACIONINVESTIGA">Educaci�n e Investigaci�n
                                        <br/>
                                        <input type="checkbox" class="check" name="chkJuventudAdic" id="chkJuventudAdic" <?php echo $chkJuventudAdic ?> value="JUVENTUD">Juventud
                                        <br/>
                                        <input type="checkbox" class="check" name="chkMedioAmbienteAdic" id="chkMedioAmbienteAdic" <?php echo $chkMedioAmbienteAdic ?> value="MEDIOAMBIENTE" >Medio Ambiente
                                        <br/>
                                        <input type="checkbox" class="check" name="chkMujerAdic" id="chkMujerAdic" <?php echo $chkMujerAdic ?> value="MUJER">Mujer
                                        <br/>
                                        <input type="checkbox" class="check" name="chkOrganizacionAdic" id="chkOrganizacionAdic" <?php echo $chkOrganizacionAdic ?> value="ORGANIZACION">Organizaci�n
                                        <br/>
                                        <input type="checkbox" class="check" name="chkOrganizacionSocialesAdic" id="chkOrganizacionSocialesAdic" <?php echo $chkOrganizacionSocialesAdic ?> value="ORGANIZACIONSOCIAL">Organizaciones Sociales
                                        <br/>
                                        <input type="checkbox" class="check" name="chkPlaneacionAdic" id="chkPlaneacionAdic" <?php echo $chkPlaneacionAdic ?> value="PLANEACION">Planeaci�n
                                        <br/>
                                        <input type="checkbox" class="check" name="chkProyectosAdic" id="chkProyectosAdic" <?php echo $chkProyectosAdic ?> value="PROYECTOS">Proyectos
                                        <br/>
                                        <input type="checkbox" class="check" name="chkRelacionesPublicasAdic" id="chkRelacionesPublicasAdic" <?php echo $chkRelacionesPublicasAdic ?> value="RELACIONESPUBLICAS">Relaciones P�blicas
                                        <br/>
                                        <input type="checkbox" class="check" name="chkSecretariaActasAdic" id="chkSecretariaActasAdic" <?php echo $chkSecretariaActasAdic ?> value="SECRETARIAACTAS">Secretar�a de Actas
                                        <br/>
                                        <input type="checkbox" class="check" name="chkSeguridadSocialAdic" id="chkSeguridadSocialAdic" <?php echo $chkSeguridadSocialAdic ?> value="SEGURIDADSOCIAL">Seguridad Social
                                        <br/>
                                        <input type="checkbox" class="check" name="chkServidoresPublicosAdic" id="chkServidoresPublicosAdic" <?php echo $chkServidoresPublicosAdic ?> value="SERVIDORESPUBLICOS">Servidores P�blicos
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
                                        <label>Otras Secretar�as</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtOtraSecretaria" <?php echo $soloLectura; ?> id="txtOtraSecretaria" value="<?php echo $registro["otras_secretarias"]?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Tipo Federaci�n</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltTipoFederacion" id="sltTipoFederacion">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($tipoFederacion, $registro["tipo_federacion_codigo"])
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Fecha �ltima Inscripci�n Junta Directiva</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" <?php if($consultar != "1") echo 'id="datepicker5"' ?> name="txtFechaUltimaInscJunta" <?php echo $soloLectura; ?> value="<?php if($registro["fecha_ultima_inscripcion_junta_directiva"] != "0000-00-00") echo $registro["fecha_ultima_inscripcion_junta_directiva"]; ?>" />
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
                                    <td align="left" class="tdMiddle">
                                        <label>Medio de Comunicaci�n</label>
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
                                                if($medio['medio_comunicacion_codigo'] == 'BOLETIN')
                                                    $chkBoletin = 'checked';
                                                if($medio['medio_comunicacion_codigo'] == 'PERIODICO')
                                                    $chkPeriodico = 'checked';
                                                if($medio['medio_comunicacion_codigo'] == 'PROGRAMARADIO')
                                                    $chkProgramaRadio = 'checked';
                                                if($medio['medio_comunicacion_codigo'] == 'TELEVISION')
                                                    $chkTelevision = 'checked';

                                            }

                                        }
                                        ?>
                                        <input type="checkbox" class="check" name="chkBoletin" id='chkBoletin' value="BOLETIN" <?php echo $chkBoletin ?>>Bolet�n
                                        <br/>
                                        <input type="checkbox" class="check" name="chkPeriodico" id='chkPeriodico' value="PERIODICO" <?php echo $chkPeriodico ?>>Peri�dico
                                        <br/>
                                        <input type="checkbox" class="check" name="chkProgramaRadio" id='chkProgramaRadio' value="PROGRAMARADIO" <?php echo $chkProgramaRadio ?>>Programa radio
                                        <br/>
                                        <input type="checkbox" class="check" name="chkTelevision" id='chkTelevision' value="TELEVISION" <?php echo $chkTelevision ?>>Televisi�n
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Estado Federaci�n</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltEstado" id="sltEstado">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($estadoFederacion, $registro["estado_codigo"])
                                                ?>
                                            </select>
                                        </div>
                                        <div class="campoObligatorio">*</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <label>Caracter�stica  para  Federaci�n Inactivo</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <select name="sltCaracteristicasFederacionInactivo" id="sltCaracteristicasFederacionInactivo">
                                            <option value=""> Seleccionar </option>
                                            <?php
                                            LlenarSelectOption($caracteristicasFederacionInac, $registro["caracteristica_federacion_inactiva_codigo"])
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Federaci�n a la que se Fusiona</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtNombreFederacionFusiona" <?php echo $soloLectura; ?> value="<?php echo $registro["federacion_fusionado"]?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Bienes Inmuebles de Propiedad de la federacion</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltBienesInmueblesProp" id="sltBienesInmueblesProp">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($bienInmuebleCodigo, $registro["bien_inmueble_codigo"])
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Otros Bienes Inmuebles</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtOtrosBienesInmubles" <?php echo $soloLectura; ?> id='txtOtrosBienesInmubles' value="<?php echo $registro["otros_bienes_inmuebles"]?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Fecha �ltima Actualizaci�n Informaci�n</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" <?php if($consultar != "1") echo 'id="datepicker6"' ?> name="txtFechaUltimaActualizacion" <?php echo $soloLectura; ?> value="<?php if($registro["fecha_ultima_actualizacion_informacion"] != "0000-00-00") echo $registro["fecha_ultima_actualizacion_informacion"]?>"/>
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
                <div id="contact-contentMod" class="contentblock hidden">
                    <div align="center">
                        <fieldset align="center">
                            <legend align="left" class="legend"></legend>
                            <table align="left">
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Afiliaci�n Internacional</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <div class="divControl">
                                            <select name="sltAfiliacionInt" id="sltAfiliacionInt">
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($afiliaciInternacio, $registro["afiliacion_internacional_codigo"])
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="tdFormulario">
                                        <label>Otra Afiliaci�n Internacional</label>
                                    </td>
                                    <td align="left" class="tdFormulario">
                                        <input type="text" name="txtOtraAfiliacionInternacional" <?php echo $soloLectura; ?> id='txtOtraAfiliacionInternacional' value="<?php echo $registro["otra_afiliacion_internacional"]?>" />
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
            <?php            if($tituloTab == 'Consulta')            {            ?>                <a href="/index.php/controladorFederacion">                    <img src="/images/volver.png" width="36" height="36" />                    <br/>                    Regresar                </a>             <?php            }            else            { ?>                <div id="divGuardarMod">                    <button type="submit" style="border: 0; cursor: pointer;background-color: #fff;">                        <img src="/images/guardar.jpg" width="36" height="36" />                        <br/>                        Guardar                    </button>                </div>                <div id="divRegresarMod">                <a href="/index.php/controladorFederacion">                    <img src="/images/volver.png" width="36" height="36" />                    <br/>                    Regresar                </a>                </div>                <div class="clearBoth"></div>            <?php } ?>        </div>    </div></div><?php FinalDocumento(); ?>