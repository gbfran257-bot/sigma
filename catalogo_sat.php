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

	<title>SISTEMA - LÍNEA CRUZ ROJA </title>

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

	<!-- Inicio de los diseños aplicados a los campos del formulario del modal de editar catálogo -->
	<style>
		.swal2-container {
			z-index: 8000;
		}

		#row-catalogo-priemr-grupo-campos {
			margin-bottom: 1.5rem;
		}

		#impuesto-clave {
			margin: 0px 1.5rem;
		}

		.grupo-campos-impuestos {
			margin: 0px 2rem;
		}

		.impuesto-primer-radio-button {
			margin: 1.5rem 0px
		}

		#isr_label_tasa,
		#isr_label_retenido,
		#ieps_label_trasladado,
		#ieps_label_retenido {
			color: rgba(0, 0, 0, 0.5);
		}

		.impuesto-radio-button-label {
			color: #000000;
		}
	</style>
	<!-- Fin de los diseños aplicados a los campos del formulario del modal de editar catálogo -->
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid">
		<thead id="cabecera_tBusquedaPrincipal">
			<tr role="row" class="bg-primary">
				<th id="clickme" style="vertical-align:middle;">#</th>
				<th style="vertical-align:middle;">
					<button type="button" class="btn btn-sm btn-primary" onClick="nuevo();">
						CLAVE <i class="fa fa-plus"></i>
					</button>
				</th>
				<th style="vertical-align:middle;" class="text-center">DESCRIPCIÓN</th>
				<th style="vertical-align:middle;" class="text-center">IVA</th>
				<th style="vertical-align:middle;" class="text-center">ELIMINAR</th>
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
				<th><input type="text" class="form-control input-sm" placeholder="LÍNEA" /></th>
				<th><input type="text" class="form-control input-sm" placeholder="DESCRIPCIÓN" /></th>
				<th><input type="text" class="form-control input-sm" placeholder="IVA" /></th>
				<th></th>
			</tr>
		</tfoot>
	</table>
</div>
<div id="auxiliar" class="hidden"></div>
<div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->
<?php include_once 'partes/footer.php'; ?>

<script>
	$(document).ready(function(e) {
		//breadcrumb
		$('#breadc').html('<li><a href="index.php">HOME</a></li><li>ADMINISTRACIÓN</li><li>CATÁLOGOS</li><li class="active"><strong>CATÁLOGO SAT</strong></li>');

		$('#my_search').removeClass('hidden');
		$.fn.datepicker.defaults.autoclose = true;

		var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height() - 127 - $('#breadc').height();
		var oTableP = $('#dataTablePrincipal').DataTable({
			serverSide: true,
			"sScrollY": tamP,
			ordering: false,
			searching: true,
			scrollCollapse: false,
			"scrollX": true,
			"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {},
			scroller: false,
			responsive: true,
			"aoColumns": [{
				"bVisible": true
			}, {
				"bVisible": true
			}, {
				"bVisible": true
			}, {
				"bVisible": true
			}, {
				"bVisible": true
			}],
			"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>',
			deferRender: true,
			select: false,
			"processing": false,
			"sAjaxSource": "catalogos/sat/datatable-serverside/sat.php",
			"fnServerParams": function(aoData, fnCallback) {
				var nombre = $('#top-search').val();
				var acceso = $('#acc_user').val();
				var idU = $('#id_user').val();

				aoData.push({
					"name": "nombre",
					"value": nombre
				});
				aoData.push({
					"name": "accesoU",
					"value": acceso
				});
				aoData.push({
					"name": "idU",
					"value": idU
				});
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page",
				"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
				"sInfo": "SERVICIOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN SERVICIO FILTRADO.",
				"sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_",
				"sSearch": "",
				"oPaginate": {
					"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
					"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
				}
			},
			"iDisplayLength": 20,
			paging: true,
		});

		$('#clickme').click(function(e) {
			oTableP.draw();
		});
		window.setTimeout(function() {
			$('#clickme').click();
		}, 500);

		//para los fintros individuales por campo de texto
		oTableP.columns().every(function() {
			var that = this;

			$('input', this.footer()).on('keyup change', function() {
				if (that.search() !== this.value) {
					that.search(this.value).draw();
				}
			});
		});
		//fin filtros individuales por campo de texto
		$('#top-search').keyup(function(e) {
			$('#dataTablePrincipal_filter input').val($(this).val());
			$('#dataTablePrincipal_filter input').keyup();
		}).focus();
		$('.filtro1Principal').addClass('hidden');
	});

	function editar(id_um, unidad) {
		$("#myModal").load('catalogos/sat/htmls/sat.php', function(response, status, xhr) {
			if (status == "success") {
				$('#id_usr_reg').val($('#id_user').val());
				$('#alerta_new_user').hide();
				$('#titulo_modal').text('FICHA DE CUENTA: ' + unidad);
				$('#id_sat').val(id_um);
				$('#idU').val($('#id_user').val());

				$('#btn_update_colonia').removeClass('hidden');
				$('#btn_save_colonia ').addClass('hidden');

				var datos = {
					id_um: id_um
				}
				$.post('catalogos/sat/files-serverside/ficha_sat.php', datos).done(function(data1) {
					// INICIO: Mostramos la información de los impuestos en los select //
					const datosI = JSON.parse(data1);
					$("#clave").val(datosI[0].clave_sat);
					$("#descripcion").val(datosI[0].descripcion_sat);
					for (let i = 0; i < datosI.length; i++) {
						agregarImpuesto(datosI[i].id_impuesto_catalogo);
					}

					const htmlImpuestosExtra = $('.impuesto_extra');
					for (let i = 0; i < htmlImpuestosExtra.length; i++) {
						setImpuestosCatalogoSAT(htmlImpuestosExtra[i], datosI[i]);
					}
					// FIN: Mostramos la información de los impuestos en los select //

					$('#form-sat').validator().on('submit', function(e) {
						if (e.isDefaultPrevented()) { // handle the invalid form...
							$("#alerta_new_user").fadeTo(2000, 500).slideUp(500, function() {
								$("#alerta_new_user").slideUp(600);
							});
						} else { // everything looks good!
							e.preventDefault();

							// Verificamos si hay impuestos extra y si estos están debidamente llenados //
							const impuestosExtra = $(".impuesto_extra");
							if (impuestosExtra.length === 0) {
								return swal({
									title: "Formulario incompleto",
									text: "Debes crear mínimo un impuesto aplicable",
									type: "error"
								});
							}
							const impuestos = verificarImpuestos(impuestosExtra);
							if (!impuestos) {
								return swal({
									title: "Formulario incompleto",
									text: "Llena los campos faltantes",
									type: "error"
								});
							}

							// Obtenemos los impuestos que se van a actualizar y los impuestos que se van a dar de alta
							const impuestosExtraActualizados = [];
							const impuestosExtraNuevos = [];
							for (const ie of impuestosExtra) {
								if (ie.querySelector('#id_impuesto_catalogo').value !== 'null') {
									impuestosExtraActualizados.push(ie);
								} else {
									impuestosExtraNuevos.push(ie);
								}
							}

							var datosP = $('#myModal #form-sat').serialize();
							$.post('catalogos/sat/files-serverside/update_sat.php', datosP).done(function(data) {
								if (data == 1) { //si el paciente se Actualizó 
									$('#clickme').click();
									$('#myModal').modal('hide');

									// Actualizamos los impuestos ya existentes
									actualizarImpuestos(impuestosExtraActualizados);

									// Insertamos los impuestos recién creados
									insertarImpuestos(impuestosExtraNuevos);

									return;
								} else {
									alert(data);
								}
							});
						}
					});
				});

				$('#myModal').modal('show');
				$('#myModal').on('shown.bs.modal', function(e) {});
				$('#myModal').on('hidden.bs.modal', function(e) {
					$(".modal-content").remove();
					$("#myModal").empty();
				});
			}
		});
	}

	function nuevo() {
		$("#myModal").load('catalogos/sat/htmls/sat.php', function(response, status, xhr) {
			if (status == "success") {
				$('#titulo_modal').text('CREAR UNA CUENTA NUEVA');

				$('#idU').val($('#id_user').val());
				$('#btn_save_colonia').removeClass('hidden');
				$('#btn_update_colonia ').addClass('hidden');



				$('#form-sat').validator().on('submit', function(e) {
					if (!e.isDefaultPrevented()) { // everything looks good!
						e.preventDefault();

						// Verificamos si hay impuestos extra y si estos están debidamente llenados //
						const impuestosExtra = $(".impuesto_extra");
						if (impuestosExtra.length === 0) {
							return swal({
								title: "Formulario incompleto",
								text: "Debes crear mínimo un impuesto aplicable",
								type: "error"
							});
						}
						const impuestos = verificarImpuestos(impuestosExtra);
						if (!impuestos) {
							return swal({
								title: "Formulario incompleto",
								text: "Llena los campos faltantes",
								type: "error"
							});
						}

						var datosP = $('#myModal #form-sat').serialize();
						// var token = $('meta[name="csrf-token"]').attr('content');
						$.post('catalogos/sat/files-serverside/addCuenta.php', datosP).done(function(data) {
							if (data == 1) { //si el paciente se Actualizó
								$('#clickme').click();
								$('#myModal').modal('hide');
								// Realizamos la petición para registrar los impuestos extra
								const bodyImpuestosExtra = new FormData();
								bodyImpuestosExtra.append('clave_sat', $('#clave').val());
								bodyImpuestosExtra.append('impuestosExtra', JSON.stringify(impuestos));
								fetch('catalogos/sat/files-serverside/addImpuestosExtra.php', {
									method: 'post',
									body: bodyImpuestosExtra
								}).then(response => response.json()).then(data => {
									swal({
										title: 'Registro exitoso',
										text: data.EXITO,
										type: 'success',
										timer: 1800,
										showConfirmButton: false
									});
								}).catch(error => {
									swal({
										title: 'Ocurrió un error',
										text: error,
										type: 'error',
										timer: 1800,
										showConfirmButton: false
									});
								});
								return;
							} else {
								alert(data);
							}
						});
					}
				});

				$('#myModal').modal('show');
				$('#myModal').on('shown.bs.modal', function(e) {
					$('#form-colonia').validator();
				});
				$('#myModal').on('hidden.bs.modal', function(e) {
					$(".modal-content").remove();
					$("#myModal").empty();
				});
			}
		});
	}

	function delete_l(id_p, nombre_p) {
		swal({
				title: "ELIMINAR CUENTA: " + nombre_p,
				text: "¿Estás seguro de eliminar esta cuenta?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Eliminar",
				cancelButtonText: "Cancelar",
				closeOnConfirm: false
			},
			function() {
				// var token = $('meta[name="csrf-token"]').attr('content');
				var datos = {
					id_p: id_p,
					nombre_p: nombre_p
				}
				$.post('catalogos/sat/files-serverside/eliminar.php', datos).done(function(data) {
					if (data == 1) {
						$('#myModalx').modal('hide');
						$('#clickme,#clickmeMem,#clickmeFo,#clickmeDo').click();
						swal({
							title: "",
							type: "success",
							text: "La cuenta se ha eliminado.",
							timer: 1800,
							showConfirmButton: false
						});
						return;
					} else {
						alert(data);
					}
				});
			});
	}
</script>

<!-- Inicio de la función que permite manejar el cambio del select para el impuesto ieps -->
<script src="./catalogos/sat/js/editarCatalogoSAT.js"></script>
<!-- Fin de la función que permite manejar el cambio del select para el impuesto ieps -->

<!-- INICIO: Función que maneja el mostrar la información de los impuestos de la bd en los select para su edición -->
<script src="./catalogos/sat/js/setImpuestosCatalogoSAT.js"></script>
<!-- FIN: Función que maneja el mostrar la información de los impuestos de la bd en los select para su edición -->

<!-- INICIO: Función que agrega el html para los impuestos extra que se van a aplicar -->
<script src="./catalogos/sat/js/agregarImpuesto.js"></script>
<!-- FIN: Función que agrega el html para los impuestos extra que se van a aplicar -->

<!-- INICIO: Función que agrega verifica si los impuestos extra son válidos para su envío a la bd -->
<script src="./catalogos/sat/js/verificarImpuestosExtra.js"></script>
<!-- FIN: Función que agrega verifica si los impuestos extra son válidos para su envío a la bd -->

<script src="./catalogos/sat/js/insertarImpuestos.js"></script>
<script src="./catalogos/sat/js/actualizarImpuestos.js"></script>