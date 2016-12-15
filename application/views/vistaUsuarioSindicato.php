<?php
/*
 * Vista Asociar Grupo a Usuario
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Gesti�n Usuario por Organizaci�n Sindical";
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
    echo form_open('controladorUsuarioSindicato/AdicionarUsuarioSindicato');
    echo "<script src='/js/usuarioSindicatoAdicionar.js'></script>";
}
else
{
    echo form_open('controladorUsuario/ModificarUsuario');
    echo "<script src='/js/usuarioSindicatoModificar.js'></script>";
}

/*
* Mensajes de eliminacion de registros
*/
if(isset($estadoEliminar) && $estadoEliminar == true)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Se elimino satisfactoriamente la asociaci�n de grupo y men�.
        </div>';
else if(isset($estadoEliminar) && $estadoEliminar == false)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Ocurrio un problema al eliminar la asociaci�n de grupo y men�.
        </div>';
/*
* Mensajes de adicion de registros
*/
if(isset($estadoAdicionar) && $estadoAdicionar == true)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Se adicion� la asociaci�n de grupo y men� satisfactoriamente.
        </div>';
else if(isset($estadoAdicionar) && $estadoAdicionar == false)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Error al adicionar la asociaci�n de grupo y men�.
        </div>';
/*
* Mensajes de adicion de registros
*/
if(isset($estadoAdicionar) && $estadoAdicionar == true)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Se adicion� el registro de usuario sindicato satisfactoriamente.
        </div>';
else if(isset($estadoAdicionar) && $estadoAdicionar == false)
    echo '<div id="dialogo" align="center" class="ventana" title="Informacion">
          Error al adicionar el registro de usuario sindicato.
        </div>';
/*
* Validacion de modo consulta detallada
*/
if(isset($consultar) && $consultar == "1")
    echo "<script src='/js/usuarioSindicato.js'></script>";
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
            <table id="table" class="display" cellspacing="0" width="100%">
                <thead class="trTitulo">
                <tr>
                    <th></th>
                    <th>Login del Usuario</th>
                    <th>Nombre del Usuario</th>
                    <th>Grupo de Vinculaci�n</th>
                    <th>Nombre organizaci�n sindical</th>
                    <th>Tipo organizaci�n sindical</th>
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
                            echo '<td>
                                                <a href="javascript:;" onclick="Confirmar(\'/index.php/controladorUsuarioSindicato/EliminarUsuarioSindicato/'.$registro['usuario_id_usuario'].'\'); return false;"  title="Eliminar">
                                                    <img src="/images/eliminar.png" width="15" height="15" alt="Eliminar"/>
                                                </a>
                                            </td>';
                            echo "<td>".utf8_decode($registro['login_usuario'])."</td>";
                            echo "<td>".utf8_decode($registro['nombre_apellido'])."</th>";
                            echo "<td>".utf8_decode($registro['descripcion'])."</td>";
                            echo "<td>".utf8_decode($registro['nombre'])."</td>";
                            echo "<td>".utf8_decode($registro['tipo'])."</td>";
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
                    <a href="/index.php/controladorUsuarioSindicato/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                        <img src="/images/excel.jpg" width="30" height="30" />
                        <br />
                        Exportar a Excel
                    </a>
                </div>
                <div id="divExportarPdf">
                    <a href="/index.php/controladorUsuarioSindicato/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                        <img src="/images/pdf.jpg" width="30" height="30" />
                        <br />
                        Exportar a Pdf
                    </a>
                </div>
                <div class="clearBoth"></div>
            </div>
        </div>
        <div id="tabAdicionar">
            <div id="divUsuarioSindicato" class="clearfix">
                <ul id="sidemenu">
                    <li>
                        <a href="#informacion-content" class="open"><i class="icon-home icon-large"></i>Usuario por Organizaci�n Sindical</a>
                    </li>
                </ul>
                <div id="content">
                    <!--Tab Datos Basicos-->
                    <div id="informacion-content" class="contentblock">
                        <div align="center">
                            <fieldset align="center">
                                <legend align="left" class="legend"></legend>
                                <table align="center">
                                    <tr>
                                        <td align="left" class="tdFormulario">
                                            <label>Usuario</label>
                                        </td>
                                        <td align="left" class="tdFormulario">
                                            <div class="divControl">
                                                <select name="sltUsuarioAdic" id="sltUsuarioAdic" />
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($nombreUsuario)
                                                ?>
                                                </select>
                                            </div>
                                            <div class="campoObligatorio">*</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" class="tdFormulario">
                                            <label>Nombre Organizaci�n Sindical</label>
                                        </td>
                                        <td align="left" class="tdFormulario">
                                            <div class="divControl">
                                                <select name="sltSindicatoAdic" id="sltSindicatoAdic" />
                                                <option value=""> Seleccionar </option>
                                                <?php
                                                LlenarSelectOption($registrosConsultaSindicato)
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

        </div>
    </div>

<?php FinalDocumento(); ?>