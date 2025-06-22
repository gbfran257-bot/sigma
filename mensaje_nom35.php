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

    <title>SISTEMA - TEXTO EMAIL</title>

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
    <link rel="stylesheet" type="text/css" href="css/cssGenerales.css">
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

<?php include_once("./partes/header.php"); ?>

<!--Contenido de la página-->

<div class="container mt-5">
  <form action="procesar.php" method="POST" name="form-est" id="form-est">
    <div class="form-group">
      <h2 for="textoInput">Escriba el texto que se enviara en los correos.</h2>
      <br>
      <label for="textoInput">NOTA: escriba &lt;code&gt; en el lugar que ira el codigo de App Question.</label>
      <br><br>
      <input type="text" class="form-control" id="texto_email" name="texto_email" placeholder="Ingrese algo aquí">
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
  </form>
</div>


<!--Contenido de la página-->

<?php include_once("./partes/footer.php"); ?>

<script>
  $(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>NOM35</li><li class="active"><strong>TEXTO EMAIL</strong></li>');
  });

        var datos = {id:1}
		$.post('nom35/files-serverside/ficha_email.php',datos).done(function(data1){
			 $('#texto_email').val(data1);

			$('#form-est').validator().on('submit', function (e) {
			  if (e.isDefaultPrevented()) { 
				/* $("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); }); */
			  } else { 
				e.preventDefault(); 
				
				var datosP = {
                    id:1,
                    mensaje:$('#texto_email').val()
                }
				$.post('nom35/files-serverside/update_texto_email.php',datosP).done(function( data ) {
					if (data==1){
						/* $('#clickme').click(); $('#myModal').modal('hide');  */
						swal({
						  title: "¡CONFIRMACIÓN!", type: "success", text: "El texto de los Email se actualizó.",
						  timer: 1900, showConfirmButton: false
						}); return;
					} else{alert(data);}
				});
			  }
			});
		});

</script>

</html>




