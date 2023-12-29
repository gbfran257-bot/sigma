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
    
    <title>SISTEMA - UNIDADES DE MEDIDA</title>
    
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

  <!--Select2-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="js/select2Gen.js"></script>
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;">
		PACIENTE
    </th>
    <th style="vertical-align:middle;">FECHA</th>
    <th style="vertical-align:middle;">USUARIO</th>
    <th style="vertical-align:middle;">CONSULTA</th>
    <th style="vertical-align:middle;">MOTIVO</th>
    <th style="vertical-align:middle;">Atender/Eliminar</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Paciente"/></th>
            <th><!-- <input type="text" class="form-control input-sm" placeholder="-Abreviación-"/> --></th>
            <th><!-- <input type="text" class="form-control input-sm" placeholder="-Usuario-"/> --></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>

<style>
	.modal-fullscreen  {
		max-width: 120%;
		width: 95%;
		margin: 25;
	}
  /* Estilo necesario para que se muestre el select2 en el modal */
  .select2-container {
			z-index: 9999;
	}
</style>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
  $(document).ready(function(e) {
    
    $('#breadc').html('<li><a href="index.php">HOME</a></li><li>ADMINISTRACIÓN</li><li class="active"><strong>SOLICITUDES HOSPITALIZACION</strong></li>');
    
    $('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
    
    var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-140-$('#breadc').height();
    var oTableP = $('#dataTablePrincipal').DataTable({
      serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
      "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
        /* var Total = 0;
        var abonado = 0;
        var saldo = 0;
        for ( var i=iStart ; i<iEnd ; i++ )
        {
          Total += aaData[ aiDisplay[i] ][4]*1;
          abonado += aaData[ aiDisplay[i] ][5]*1;
          saldo += aaData[ aiDisplay[i] ][6]*1;
        }
        var nCells = nRow.getElementsByTagName('th');
        nCells[4].innerHTML = '$'+redondear(parseFloat(Total * 100)/100,2);
        nCells[5].innerHTML = '$'+redondear(parseFloat(abonado * 100)/100,2);
        nCells[6].innerHTML = '$'+redondear(parseFloat(saldo * 100)/100,2); */
      }, scroller: false, responsive: true,
      "aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true} ],
      "sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
      deferRender: true, select: false, "processing": false, 
      "sAjaxSource": "consultas/datatable-serverside/informacion_datos_prev_hosp.php",
      "fnServerParams": function (aoData, fnCallback) { 
        //
        var de1 = $('#top-search').val();
        var de = $('#fechaDe').val() + ' 00:00:00';
        var a = $('#fechaA').val() + ' 23:59:59';

        aoData.push({ "name": "nombre", "value": de1 });
        aoData.push({ "name": "min", "value": de });
        aoData.push({ "name": "max", "value": a });
        //
        var nombre = $('#top-search').val();
        var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
        
        aoData.push( {"name": "nombre", "value": nombre } );
        aoData.push(  {"name": "accesoU", "value": acceso } );
        aoData.push(  {"name": "idU", "value": idU } );
      },
      "oLanguage": {
        "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
        "sInfo": "SERVICIOS FILTRADOS: _END_",
        "sInfoEmpty": "NINGÚN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_", "sSearch": "",
        "oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
      },"iDisplayLength": 50000, paging: false,
    });

    $('#clickme').click(function(e) { oTableP.draw(); }); window.setTimeout(function(){$('#clickme').click();},500);
    
    //para los fintros individuales por campo de texto
    oTableP.columns().every( function () {
      var that = this;
  
      $( 'input', this.footer() ).on( 'keyup change', function () {
        if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
      } );
    } );
    //fin filtros individuales por campo de texto
    $('#top-search').keyup(function(e) {
          $('#dataTablePrincipal_filter input').val($(this).val()); $('#dataTablePrincipal_filter input').keyup();
      }).focus();
    $('.filtro1Principal').addClass('hidden');


    //
    $('.infoPrincipal').append('<div id="divRangoFechas" style="text-align:left;"> <table width="100%" border="0" cellpadding="4" cellspacing="2" style="color:black; float:left;"> <tr> <td width="10px">De &nbsp;</td> <td width="1%"> <input name="fechaDe" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" style="width:100px;" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly > </td> <td width="10px">&nbsp; A &nbsp;</td> <td width="1%"> <input style="width:100px;" name="fechaA" type="text" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly> </td> <td id="rangosFechas">&nbsp; <input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">&nbsp; Hoy &nbsp;</label> <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">&nbsp; Todos &nbsp;</label> </td> </tr> </table> </div>');
    
    $('#radio1').click(function(e) {
      $('#fechaDe').val('<?php echo date("Y-m-d"); ?>');
      $('#fechaA').val('<?php echo date("Y-m-d"); ?>');
      oTableP.draw();
    });

    $('#radio2').click(function(e) {
      $('#fechaDe').val('2023-01-01');
      $('#fechaA').val('<?php echo date("Y-m-d"); ?>');
      oTableP.draw();
    });

    $('#fechaDe').on('changeDate', function(e) {
      oTableP.draw();
    });
    $("#fechaA").on('changeDate', function(e) {
      oTableP.draw();
    });
    //

  });

function insertar_reg_historial(id_rh,id_ov){
	var datos = { id_rh:id_rh, id_ov:id_ov, idU:$('#id_user').val() }
	$.post('referencias_hospital/insertar_reg_historial.php', datos).done(function(data) {
	  $('#clickmeSe,#clickmeSmS,#clickmeHis').click();
	});
}

  function hospitalizar(id_dph){
    var datos_dph = {id_dph:id_dph}
    $.post('consultas/files-serverside/obtener_info_prev_hosp.php', datos_dph).done(function(data_dph) {
      var datos_obtenidos = data_dph.split('*}');

      $("#myModal1").load('consultas/htmls/selecciona_cama.php', function(response, status, xhr){ if(status=="success"){
        setTimeout(() => {
          $("#motivo_h").val(datos_obtenidos[4]);
        }, "800");

        /* comienza copia de funcionalidad */

        $('#form-selecciona-cama').validator().on('submit', function (e) {
										if (e.isDefaultPrevented()) { // handle the invalid form...
										} else { // everything looks good!
											e.preventDefault(); 

											// Aqui ya se hospitaliza
                      var datosCC = {id_vc:datos_obtenidos[3]}
											$.post('consultas/files-serverside/check_hospitalizado.php',datosCC).done(function(data_check){
												if(data_check<1){
													swal({
													title: "", text: "¿Desea hospitalizar a éste paciente?", showCancelButton: true, confirmButtonColor: "#DD6B55",type:"warning",
													showConfirmButton: true, confirmButtonText: 'Hospitalizar', cancelButtonText: "Cancelar", closeOnConfirm: false,
													},
													function(){
														var datosT = {idP:datos_obtenidos[1], idU:$('#id_user').val(), id_vc:datos_obtenidos[3], id_cama_h: $('#id_cama_h').val(), motivo_h: $('#motivo_h').val(),idM: $('#id_medico_t').val()} 
														$.post('consultas/files-serverside/hospitalizar.php',datosT).done(function(data){
                              
															if(data==1){
																//creacion ref. hospital
																var datos_ref_h = { idP:datos_obtenidos[1], idU:$('#id_user').val(), id_vc:datos_obtenidos[3] }
																$.post('consultas/files-serverside/crear_insertar_ref_hospital.php',datos_ref_h).done(function(data_ref_h){
																	var datosrefh = data_ref_h.split(';*-');
																	$('#clickme').click(); 
																	$('#hospitalizarP').remove();

																	swal({
																	title: "REFERENCIA DE HOSPITAL CREADA", text: "¿DESEA AGREGAR ESTA ORDEN DE VENTA A LA REREFENCIA DE HOSPITAL "+ datosrefh[1] + "?", showCancelButton: true, confirmButtonColor: "#DD6B55",type:"warning",
																	showConfirmButton: true, confirmButtonText: 'Aceptar', cancelButtonText: "Cancelar", closeOnConfirm: false,
																	},
																	function(){
																		//obtenemos el id de la referencia de hospital
																		var datopaciente = { id_paciente:datos_obtenidos[1] }
																		$.post('referencias_hospital/verificar_existe_ref_h.php', datopaciente).done(function(data_verh){
																			var datos = data_verh.split('*}');
																			if(datos[0]>=1){
																				//obtenemos la referencia asociada al concepto de la consulta(id_vc)
																				var datos_search_eov = {id_vc:datos_obtenidos[3]}
																				$.post('referencias_hospital/encontrar_ov.php', datos_search_eov).done(function(data_eov){
																					var datos_eov = data_eov.split('*}');
																					if(datos_eov[0]>=1){
																						var datos_ins_rrh = { id_referencia_h:datos[1], referencia_ov:datos_eov[1] }
																						$.post('referencias_hospital/insertar_seguimiento_ref_h.php', datos_ins_rrh).done(function(data_rrh){
																							if(data_rrh==1){
																								insertar_reg_historial(datos[1],datos_eov[2]);
																								swal({
																									title: "SE AGREGO CORRECTAMENTE",
																									text: "",
																									type: "success",
																									timer: 2700, 
																									showConfirmButton: false 
																								});
																							}
																						}); 
																					}else{
																						alert("no se encontro referencia de ov "+datos_obtenidos[3]);
																					}
																				});
																			}
																		}); 
																	});
																	
																	$('#myModal1').modal('hide');

																	if(datosrefh[0]!=='1'){
																		alert(data_ref_h);
																	}
																	
																});
															}else{alert(data);}
														});
													});
												}else{
													swal({ title: "No se puede hospitalizar", type: "error", text: "El paciente ya se encuentra hospitalizado.", timer: 1800, showConfirmButton: false });
													$('#hospitalizarP').remove();
												}
											});

										}
									}); 

        /* termina copia de funcionalidad */

        $('#myModal1').modal('show');
        $('#myModal1').on('shown.bs.modal', function(e){ $('#form-selecciona-cama').validator(); });
        $('#myModal1').on('hidden.bs.modal', function(e){ $("#myModal1 .modal-content").remove(); $("#myModal1").empty(); });
      }});
      
    });
  }

</script>