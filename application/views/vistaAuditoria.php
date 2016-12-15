<?php
/*
 * Vista Municipios
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Gesti�n Auditoria";
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
     {  $tituloTab = 'Modificar';
        $tabActivo = 2;

     }
Cabecera($tituloPagina, $usuario, $tab, $tabActivo);
?>


<div id='divTituloPrincipal'>
    <?php echo $tituloPagina; ?>
</div><div id="tabs" class="divTabs">
    <ul>
        <li><a href="#tabConsultar">Consultar</a></li>
    </ul>
    <div id="tabConsultar" align="center" style="padding-top: 25px;">
    <table id="table" class="display" cellspacing="0" width="100%">
        <thead class="trTitulo">
            <tr>
                <th>Codigo Registro</th>
                <th>Nombre Usuario</th>
                <th>Nombre Tabla</th>
                <th>Fecha Evento</th>
                <th>Tipo Cambio</th>
                <th>Ip Usuario</th>
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
                        echo "<td>".utf8_decode($registro['id_registro'])."</td>";
                        echo "<td>".utf8_decode($registro['nombre_apellido'])."</th>";
                        echo "<td>".utf8_decode($registro['nombre_tabla'])."</td>";
                        echo "<td>".utf8_decode($registro['fecha'])."</td>";
                        echo "<td>".utf8_decode($registro['tipo_creacion_cambio'])."</td>";
                        echo "<td>".utf8_decode($registro['ip_usuario'])."</td>";
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
                <a href="/index.php/controladorAuditoria/GenerarExcel" target="_blank" title="Exportar a formato Excel">
                    <img src="/images/excel.jpg" width="30" height="30" />
                    <br />
                    Exportar a Excel
                </a>
            </div>
            <div id="divExportarPdf">
                <a href="/index.php/controladorAuditoria/GenerarPdf" target="_blank" title="Exportar a formato PDF">
                    <img src="/images/pdf.jpg" width="30" height="30" />
                    <br />
                    Exportar a Pdf
                </a>
            </div>
            <div class="clearBoth"></div>
        </div>
    </div>
</div>
<?php FinalDocumento(); ?>
