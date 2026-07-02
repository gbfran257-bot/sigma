<?php
	include_once 'recursos/session.php';
	include_once 'Connections/database.php';
	include_once 'recursos/utilities.php';
	include_once 'recursos/datauser.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SISTEMA DE EXPEDIENTE CLÍNICO ELECTRÓNICO">
    <meta name="author" content="ING JESUS DIAZ CONTRERAS">
    
    <title>SISTEMA - CONFIGURAR ALERTA </title>
    
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
    <script src='c3/d3/d3.min.js'></script>
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
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div class="container py-5">
    <form action="guardar_mensaje.php" method="POST" id="form-principal" name="form-principal" data-toggle="validator" role="form">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Mensaje de Inicio</h2>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input
                        type="text"
                        class="form-control"
                        id="titulo"
                        name="titulo"
                        maxlength="200"
                        required>
                </div>

                <div class="mb-3" style="margin-top:10px;">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea
                        class="form-control"
                        id="mensaje"
                        name="mensaje"
                        rows="6"
                        required></textarea>
                </div>

                <div class="mb-3" style="margin-top:10px;">
                    <label for="activo" class="form-label">Activo</label>
                    <select
                        class="form-select"
                        id="activo"
                        name="activo">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>

            </div>

            <div class="card-footer text-end" style="margin-top:12px;">
                <button type="submit" class="btn btn-primary">
                    Guardar
                </button>
                <button type="reset" class="btn btn-secondary">
                    Limpiar
                </button>
            </div>
        </div>
    </form>
</div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>

$(document).ready(function(e) {
    $.post('genera/datos_modal_inicio.php').done(function(dataInicio) {
        var datosInicio = dataInicio.split('*;');
        $('#titulo').val(datosInicio[1]);
        $('#mensaje').val(datosInicio[2]);
        $('#activo').val(datosInicio[0]);
    });

    $('#form-principal').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) { 
        } else { 
            e.preventDefault(); 
            
            var datosForm = $('#form-principal').serialize();
            $.post('genera/update_mensaje_inicio.php',datosForm).done(function( dataUpdate ) {
                if (dataUpdate==1){
                    swal({
                        title: "¡CONFIRMACIÓN!", type: "success", text: "El Mensaje se ha actualizado.",
                        timer: 1900, showConfirmButton: false
                    }); return;
                } else{alert(dataUpdate);}
            });
        }
    });

});

</script>