<?php include_once 'recursos/session.php'; ?>
<?php include_once 'Connections/database.php'; ?>
<?php include_once 'recursos/utilities.php'; ?>
<?php include_once 'recursos/datauser.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SISTEMA DE EXPEDIENTE CLÍNICO ELECTRÓNICO">
    <meta name="author" content="ING JESUS DIAZ CONTRERAS">

    <title>SISTEMA - PEDIDOS</title>

    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
    <link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">

    <!-- Mainly scripts -->
    <script src="js/jquery-3.2.1.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="DataTables-1.10.13/media/js/jquery.dataTables.min.js"></script>
    <script src="DataTables-1.10.13/media/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables-1.10.13/extensions/Select/js/dataTables.select.min.js"></script>
    <script src="bootstrap-validator/js/validator.js"></script>
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.media.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.printElement.min.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="jQuery-TE_v.1.4.0/uncompressed/jquery-te-1.4.0.js" charset="utf-8"></script>
    <script src='tinymce/tinymce.min.js'></script>
    <script src='c3/c3.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Input Mask-->
    <script src="jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
    <!-- Mis funciones -->
    <script src="funciones/js/inicio.js"></script>
    <script src="funciones/js/caracteres.js"></script>
    <script src="funciones/js/calcula_edad.js"></script>
    <script src="funciones/js/stdlib.js"></script>
    <script src="funciones/js/bs-modal-fullscreen.js"></script>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="DataTables-1.10.13/media/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Scroller/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Select/css/select.bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="chosen/chosen.css">
    <link rel="stylesheet" href="chosen/chosen-bootstrap.css">
    <link href="jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">
    <link href="c3/c3.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-dropdown {
            z-index: 9999;
        }
    </style>
</head>

<!--Header-->
<?php include_once("./partes/header.php"); ?>

<!--Contenido de la página-->
<div id="tabla_pedidos" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid">
        <thead id="cabecera_tBusquedaPrincipal">
            <tr role="row" class="bg-primary">
                <th id="clickme" style="vertical-align:middle;">#</th>
                <th style="vertical-align:middle; white-space:nowrap;" nowrap>PRODUCTO</th>
                <th style="vertical-align:middle; white-space:nowrap;" nowrap>NOMBRE GENÉRICO</th>
                <th id="clickme" style="vertical-align:middle;">EXISTENCIAS</th>
                <th style="vertical-align:middle; white-space:nowrap;" nowrap>MÁXIMOS</th>
                <th style="vertical-align:middle; white-space:nowrap;" nowrap>MÍNIMOS</th>
                <th style="vertical-align:middle; white-space:nowrap;" nowrap>SURTIR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="dataTables_empty">Cargando datos del servidor</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="bg-primary">
                <th></th>
                <th>
                    <input type="text" id="medicamento" name="medicamento" class="form-control form-control-sm" placeholder="Medicamento" style="text-transform: uppercase;" />
                </th>
                <th>
                    <input type="text" id="nombre_generico" name="nombre_generico" class="form-control form-control-sm" placeholder="Nombre Genérico" style="text-transform: uppercase;" />
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
<!--Contenido de la página-->

<!--Footer-->
<?php include_once("./partes/footer.php"); ?>

<script src="./pedidos/js/pedidos.js"></script>
<script src="./pedidos/js/cambiarSurtir.js"></script>
<script src="./pedidos/js/imprimirReportePedidos.js"></script>
<script src="./pedidos/js/generatePrintingDate.js"></script>

</html>