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
    
    <title>SISTEMA - CATÁLOGO DE MEDICAMENTOS</title>
    
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
		.select2-dropdown{
			z-index: 9999;
		}
	</style>
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
	<th id="clickme" style="vertical-align:middle;"><button type='button' class='btn btn-default btn-xs' id='btnAddEstudio' onClick='nuevaCompra()' title='Agregar un nuevo estudio'><i class='fa fa-plus' aria-hidden='true'></i> COMPRA</button></th>
	<th style="vertical-align:middle; white-space:nowrap;" nowrap>REFERENCIA</th>
    <th style="vertical-align:middle; white-space:nowrap;" nowrap>MED. GENERICO</th>
	<th style="vertical-align:middle; white-space:nowrap;" nowrap>PRODUCTO</th>
    <th style="vertical-align:middle; white-space:nowrap;" nowrap> LOTE</th>
    <th style="vertical-align:middle;">SUCURSAL</th>
    <th style="vertical-align:middle;">CANTIDAD ENTRANTE</th>
	<th style="vertical-align:middle;">ESTATUS</th>
    <th style="vertical-align:middle;">FECHA CADUCIDAD</th>
    <th style="vertical-align:middle;">COSTO UNITARIO</th>
    <th style="vertical-align:middle;" nowrap>REGISTRO</th>
	<th style="vertical-align:middle;" nowrap>EXIST.LOTE</th>
	<th style="vertical-align:middle;" nowrap>PROVEEDOR</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
			<th></th>
			<th><input type="text" class="form-control input-sm" placeholder="Referencia" style="max-width:90px;"/></th>
			<th><input type="text" class="form-control input-sm" placeholder="Med. generico"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Producto"style="max-width:100px;" /></th>
            <th><input type="text" class="form-control input-sm" placeholder="Lote" style="max-width:90px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Sucursal" style="max-width:100px;"/></th>
            <th></th>
			<th><input type="text" class="form-control input-sm" placeholder="Estatus" style="max-width:100px;"/></th>
            <th></th>
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Usuario" style="max-width:100px;"/></th>
			<th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Proveedor" style="max-width:100px;"/></th>
        </tr>
    </tfoot>
</table>
<!-- <div style='border:1px solid none; text-align:left;'>
	<table id='ocultarFP' width='' border='0' cellspacing='0' cellpadding='6'> 
		<tr>
			<td>SUCURSAL</td>
			<td><select name='miSucursal' id='miSucursal' class='form-control input-sm'></select></td>
		</tr> 
	</table>
</div> -->
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>FARMACIA</li><li class="active"><strong>COMPRA DE INSUMOS</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-153-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":false}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true},
			{"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true},{"bVisible":true}, {"bVisible":true},{"bVisible":true}, {"bVisible":true},
			{ "bVisible": true },
		],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "farmacia/compras/datatable-serverside/compras.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val(); 
			var acceso = $('#acc_user').val(); 
			var de = $('#fechaDe').val()+' 00:00:00';
			var a = $('#fechaA').val()+' 23:59:59';
			var idU = $('#id_user').val(); 
			// var de = $("#miSucursal").val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "accesoU", "value": acceso } );
			aoData.push(  {"name": "min", "value": de } ); 
			aoData.push(  {"name": "max", "value": a } ); 
			aoData.push(  {"name": "idU", "value": idU } );
			// aoData.push({"name": "idSu", "value": de });
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "SERVICIOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 500, paging: true,
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

	$('.infoPrincipal').append('<div id="divRangoFechas" style="text-align:left;"> <table width="100%" border="0" cellpadding="4" cellspacing="2" style="color:black; float:left;"> <tr> <td width="10px">De &nbsp;</td> <td width="1%"> <input name="fechaDe" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" style="width:100px;" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly > </td> <td width="10px">&nbsp; A &nbsp;</td> <td width="1%"> <input style="width:100px;" name="fechaA" type="text" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly> </td> <td id="rangosFechas">&nbsp; <input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">&nbsp; Hoy &nbsp;</label> <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">&nbsp; Todos &nbsp;</label> </td> </tr> </table> </div>');

	$('#radio1').click(function(e){
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>');$('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTableP.draw();
	});
	
	$('#radio2').click(function(e){
		$('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTableP.draw();
	});
	
	$('#fechaDe').on('changeDate', function(e) { oTableP.draw(); });
	$("#fechaA").on('changeDate', function(e) { oTableP.draw(); });
});

function nuevaCompra(){
	$("#myModal").load('farmacia/compras/htmls/compra.php', function( response, status, xhr ){
	if(status=="success"){ 
		var COMPRA = [];
		COMPRA['eliminacion_reciente'] = false;
		COMPRA['editado_reciente'] = null;
		var cont = 0;
		$('#compra-tab').click(function(e){
			if($('#t_compra').hasClass('hide')){
				$('#t_compra').removeClass('hide');
				$('#t_resumen').addClass('hide');
				$('#btn_pagar').addClass('hidden');
				$('#btn_agregar').removeClass('hidden');
			}
		
		});
		$('#resumen-tab').click(function(e){
			if($('#t_resumen').hasClass('hide')){
				$('#t_resumen').removeClass('hide');
				$('#t_compra').addClass('hide');
				$('#btn_agregar').addClass('hidden');
				$('#btn_pagar').removeClass('hidden');
			}
		});
		select2ini("#producto", "medicamento.php", "Seleccione el producto que desea comprar", "431.763px");
		
		$('#sucursal').load("farmacia/compras/files-serverside/sucursales.php?idU="+$('#id_user').val(),function(response,status,xhr){});

		$('#btn_agregar').click(function(e){
			// Verificamos que el formulario este completo
			if ($("#producto").val() === null || $("#select-proveedores").val() === "" || $("#costoU").val() === "" || $("#cantidad").val() === "" || $("#lote").val() === "" || $("#caducidad").val() === "") {
				return swal("¡Oops!", "Completa los datos del formulario para contirnuar.", "info");
			}

			if ((!COMPRA['eliminacion_reciente'] && COMPRA['editado_reciente'] === null) || (!COMPRA['eliminacion_reciente'] && COMPRA['editado_reciente'] !== null)) {
				console.log(COMPRA);
				var producto = $('#producto').val();
				var productoletra = $('select[name="producto"] option:selected').text();
				var costo = $('#costoU').val();
				var cantidad = $('#cantidad').val();
				var lote = $('#lote').val();
				var sucursal = $('#sucursal').val();
				var caducidad = $('#caducidad').val();
				var estatus = $('#estatus').val();
				var costoT =  Number.parseFloat(costo) * Number.parseFloat(cantidad);
					costoT = costoT.toFixed(2);
				const proveedor = $("#select-proveedores").val();
				
				if (COMPRA['editado_reciente'] !== null) {
					COMPRA[COMPRA['editado_reciente']] = {
						"producto":producto,
						"producto_letra":productoletra,
						"costo":costo,
						"cantidad":cantidad,
						"lote":lote,
						"sucursal":sucursal,
						"caducidad":caducidad,
						"estatus":estatus,
						"total":costoT,
						"proveedor": proveedor,
					};
				} else {
					COMPRA[cont] = {
						"producto":producto,
						"producto_letra":productoletra,
						"costo":costo,
						"cantidad":cantidad,
						"lote":lote,
						"sucursal":sucursal,
						"caducidad":caducidad,
						"estatus":estatus,
						"total":costoT,
						"proveedor": proveedor,
					};
					cont++;
				}
			}
			
			COMPRA['eliminacion_reciente'] = false;
			COMPRA['editado_reciente'] = null;

			var salida= "";
			var costoTotal = 0;
			for (let index = 0; index < COMPRA.length; index++) {
				costoTotal =    Number.parseFloat(COMPRA[index]['total']) +  costoTotal;

				salida +="	<tr> "+
						"		<td>"+
									(index + 1) +
						"		</td>"+
						"		<td>"+
									COMPRA[index]['producto_letra'] +
						"		</td>"+
						"		<td>"+
									COMPRA[index]['cantidad'] +
						"		</td>"+
						"		<td>"+
									COMPRA[index]['costo'] +
						"		</td>"+
						"		<td>" +
									`<button id="editar-${COMPRA[index]['producto']}" type="button" class="btn btn-warning" style="margin-right: 5px;"><img src="./farmacia/compras/img/editar_icono.png"  width="15px" height="15px" /></button>`+
									`<button id="eliminar-${COMPRA[index]['producto']}" type="button" class="btn btn-danger"><img src="./farmacia/compras/img/eliminar_icono.png" width="15px" height="15px" /></button>`+
						"		</td>" +
						"		<td>"+
									COMPRA[index]['total'] + 
						"		</td>"+
						"	</tr>";
					
			}
				salida +="	<tr> "+
						"		<td></td>"+
						"		<td></td>"+
						"		<td></td>"+
						"		<td></td>"+
						"		<td></td>"+
						"		<td>$"+ costoTotal +"</td>"+
						"	</tr> ";
			$('#ResumenTable').html(salida);

			// Asignamos las funciones de editar y eliminar a todos los productos agregados al resumen
			for (let index = 0; index < COMPRA.length; index++) {
				$("#editar-" + COMPRA[index]['producto']).click(() => {
					$("#compra-tab").click();
					$("#producto").val(COMPRA[index]['producto']);
					$("#producto").change();
					$("#costoU").val(COMPRA[index]['costo']);
					$("#cantidad").val(COMPRA[index]['cantidad']);
					$("#lote").val(COMPRA[index]['lote']);
					$("#sucursal").val(COMPRA[index]['sucursal']);
					$("#sucursal").change();
					$("#caducidad").val(COMPRA[index]['caducidad']);
					$("#estatus").val(COMPRA[index]['estatus']);
					$("#estatus").change();
					$("#select-proveedores").val(COMPRA[index]['proveedor']);
					$("#select-proveedores").change();
					COMPRA['editado_reciente'] = index;
				});

				$("#eliminar-" + COMPRA[index]['producto']).click(() => {
					swal({
						type: "info",
						title: "¡Atención!",
						text: "¿Quieres eliminar el medicamento/producto seleccionado de la orden de compra?",
						showCancelButton: true,
						cancelButtonText: "Cancelar",
						confirmButtonText: "Eliminar"
					}, (isConfirmed) => {
						if (isConfirmed) {
							COMPRA = COMPRA.filter((producto) => producto.producto !== COMPRA[index]['producto']);
							COMPRA['eliminacion_reciente'] = true;
							cont--;
							$("#btn_agregar").click();
						}
					});
				});
			}

			$('#costoU').val(0);
			$('#cantidad').val(0);
			$('#lote').val('');
			$('#caducidad').val('');
			console.log(COMPRA);

			// Se limpia la lista despegable de los productos y de los proveedores //
			$("#producto").val("");
			$("#producto").change();
			$("#select-proveedores").val("");
			$("#select-proveedores").change();
		});

		$('#producto, #sucursal').change(function(e){
			// Se ocultan los textos referentes al producto seleccionado cuando se guarda uno //
			if (e.target.id === "producto" && $("#producto").val() === null) {
				$("#productoName").text("");
				$("#precioPublicoProd").text("");
				$("#precioUltimaCompra").text("");
				$("#cantMax").text("");
				$("#cantMin").text("");
				return ;
			}

			var datoPro = { prod : $('#producto').val(), id_su : $('#sucursal').val()}
			$.post('farmacia/compras/files-serverside/precioProd.php', datoPro).done(function( data ) {
				var datos = data.split('}{[_}');
				$('#cantMax').text("Cantidad maxima de producto: "+datos[2]);
				$('#cantMin').text("Cantidad minima de producto: "+datos[3]);
				$('#productoName').text(datos[0]);
				$('#precioPublicoProd').text("Precio público: $" + datos[1]);
				$('#precioUltimaCompra').text("Última compra: $" + datos[4]);
			});
		});

		$('#costoU').change(function(e){
			var datoPr = {idU:$('#id_user').val(), prod : $('#producto').val(), costoVal : $('#costoU').val() }
			$.post('farmacia/compras/files-serverside/costoVSprecioPublico.php', datoPr).done(function( data ) {
				if(data == 2){
					$('#costoAlert').text("El costo no puede ser igual o mayor al precio de venta al publico");
					$('#costoU').css("border","solid 2px red");
					$('#costoU').val(0);
				}else{
					$('#costoAlert').text("");
					$('#costoU').css("border","solid 1px aqua");
				}
			});
		});

		$('#btn_pagar').click(function(e){
			var dato = { idU:$('#id_user').val(), datos:COMPRA }
			$.post('farmacia/compras/files-serverside/addCompra.php', dato).done(function( data ) {
				if(data==1){
					$('#myModal').modal('hide');
					swal.close(); $('#clickme').click(); 
					window.setTimeout(function(){
						swal({title:"",type:"success",text:"¡el producto se ha registrado correctamente!",timer:2500,showConfirmButton:false});
					},300);
				}else{alert(data);}
			});
		});
		
		/* INICIO DE LOS CAMBIOS PARA EL FUNCIONAMIENTO DE LOS PROVEEDORES */
		
		// Agregamos la función de redirigir a la página de pacientes en caso de que se quiera crear uno //
		$("#redirect-nuevo-proveedor").click((e) => {
			e.preventDefault();
			window.location.href = "./pacientes.php?nuevo-proveedor=true";
		});

		// Agregamos la función de redirigir a la página de medicamentos en caso de que se quiera crear uno //
		$("#redirect-nuevo-medicamento").click((e) => {
			e.preventDefault();
			window.location.href = "./catalogo_medicamentos.php?nuevo-medicamento=true";
		});

		// Agregamos la funcionalidad de cargar a todos los proveedores en la lista despegable //
		getListaProvedores();

		/* FINAL DE LOS CAMBIOS PARA EL FUNCIONAMIENTO DE LOS PROVEEDORES */

		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal',function(e){});
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	}});
}

const getListaProvedores = () => {
	fetch("farmacia/compras/files-serverside/farmacia-proveedores.php", {
		method: "GET"
	})
		.then(response => response.json())
		.then(provedores => {
			if (provedores.error) {
				throw new Error(provedores.error);
			}

			provedores.forEach((proveedor) => $("#select-proveedores").append(proveedor));
			$("#select-proveedores").select2();
		})
		.catch(error => console.error(error));
};

function estatus(id){
	swal({
		  title: "PRODUCTO ENTREGADO",
		  text: "¿Esta seguro que desea registrar este producto como entregado?",
		  type: "warning", showCancelButton: true,
		  confirmButtonColor: "#DD6B55", confirmButtonText: "Entregado", cancelButtonText: "Cancelar", closeOnConfirm: false
		},
		function(){
		  	var dato = { idP:id, idU:$('#id_user').val() }
			$.post('farmacia/compras/files-serverside/productoEntregado.php', dato).done(function( data ) {
				if(data==1){
					swal.close(); $('#clickme').click();
					window.setTimeout(function(){
						swal({title:"",type:"success",text:"¡el producto se ha registrado correctamente!",timer:2500,showConfirmButton:false});
					},300);
				}else{alert(data);}
			});
		});
}

function select2ini(donde, url, ph, width = "off"){
    $(donde).select2({
        language: "es",
        width: width,
        allowClear: true,
        ajax: {
            url: 'select/'+url,
            type: "post",
            data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                };
                return query;
            }
        },
        placeholder: ph
    });
}

function resumenCompra(id,ref){
	$("#myModal").load('farmacia/compras/htmls/resumen.php', function( response, status, xhr ){
		var dato = { idU:$('#id_user').val(), idC:id}
		$.post('farmacia/compras/datatable-serverside/resumen.php', dato).done(function( data ) {
			
			
			$('#resumenTable').html(data);
			$('#tituloC').text("RESUMEN DE COMPRA "+ ref );
			// if(data==1){
			// 	$('#myModal').modal('hide');
			// 	swal.close(); $('#clickme').click(); 
			// 	window.setTimeout(function(){
			// 		swal({title:"",type:"success",text:"¡el producto se ha registrado correctamente!",timer:2500,showConfirmButton:false});
			// 	},300);
			// }else{alert(data);}
		});
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal',function(e){});
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	});
}





function nuevoEstudio(){
	$("#myModalx").load("farmacia/medicamentos/htmls/ficha_medicamento_c.php",function(response,status,xhr){ if(status=="success"){
		$("#miSucursalNS").load('pacientes/genera/genera_sucursales_ov.php?idU='+$('#id_user').val(),function(response,status,xhr){
			if (status = "success"){
				var datosUS = {idU:$('#id_user').val()}
				$.post('servicios/servicios/files-serverside/datosSucursalU.php',datosUS).done(function(data){ $("#miSucursalNS").val(data); });
			}
		});
		
		$('#id_user_reg_m').val($('#id_user').val());
		var tamM = $('#referencia').height() - $('#my_footer').height() - 160;
		var oTableM = $('#dataTableM').DataTable({
			serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns": [
				{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}
			],
			"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"S><"proc">', 
			deferRender: true, select: {style:'single'}, "processing": false, 
			"sAjaxSource": "farmacia/medicamentos/datatable-serverside/medicamentos_genericos.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
				aoData.push( {"name": "accesoU", "value": acceso } ); aoData.push( {"name": "idU", "value": idU } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "MEDICAMENTOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN MEDICAMENTO FILTRADO.", "sInfoFiltered": " TOTAL DE MEDICAMENTOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 200, paging: true,
		});
		$('#clickmeM').click(function(e) { oTableM.draw(); }); window.setTimeout(function(){$('#clickmeM').click();},500);
		//para los fintros individuales por campo de texto
		oTableM.columns().every( function () {
			var that = this;
			$('input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
			});
		} );
		//fin filtros individuales por campo de texto
		oTableM.on( 'select', function(e, dt, type, indexes){
			$('.ocul').removeClass('hidden');
			var rowData=oTableM.rows(indexes).data().toArray(); $('#cat_riesgo_e, #tex_cat_re').text(rowData[0][5]); //alert(rowData[0][4]);
			$('#tex_presentacion').text(rowData[0][6]); $('#tex_via').text(rowData[0][7]); $('#tex_dosis').val(rowData[0][8]);
			$('#tex_generalidades').text(rowData[0][9]); $('#tex_interacciones').text(rowData[0][10]);
			$('#tex_adversos').text(rowData[0][11]); $('#tex_contrain').text(rowData[0][12]); $('#tex_re').text(rowData[0][13]);
			$('#id_mg').val(rowData[0][14]); $('#form-medicamento').validator('update'); $('#tex_base').text(rowData[0][0]);
		})
		.on( 'deselect', function ( e, dt, type, indexes ){
			$('.ocul').addClass('hidden'); $('#tex_dosis,#precio_p_m').val(''); $('#form-medicamento').validator('update')
		});

		$('#btnNewMedGenerico').click(function(e){
			$('#t-medicamento').removeClass('hidden');
			$('#link-tab-3').click();
			// $('#tMedicamento').addClass('active');
			// $('#tGenerales').removeClass('active');
		});

		$('#med_generico').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			//$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			//var $btn = $('#btn_new_u').button('loading'); $('#btn_cancel_new_u').hide();
			var datosPG = $('#med_generico').serialize();
			$.post('farmacia/medicamentos/files-serverside/addMedicamentosGenerico.php',datosPG).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); //$('#myModalx').modal('hide'); //$btn.button('reset'); $('#btn_cancel_new_u').show(); 
					swal({
					  title: "¡CONFIRMACIÓN!", type: "success", text: "El medicamento se ha creado satisfactoriamente", timer: 1800, showConfirmButton: false
					}); return;
				} else{alert(data);}
			});
		  }
		});
		
		$('#form-medicamento').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			//$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			//var $btn = $('#btn_new_u').button('loading'); $('#btn_cancel_new_u').hide();
			var datosP = $('#form-medicamento').serialize();
			$.post('farmacia/medicamentos/files-serverside/addMedicamentos.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $('#myModalx').modal('hide'); //$btn.button('reset'); $('#btn_cancel_new_u').show(); 
					swal({
					  title: "¡CONFIRMACIÓN!", type: "success", text: "El medicamento se ha creado satisfactoriamente", timer: 1800, showConfirmButton: false
					}); return;
				} else{alert(data);}
			});
		  }
		});
		
		$('#myModalx').modal('show');
		$('#myModalx').on('shown.bs.modal', function (e) { $('#formEstudio').validator(); });
		$('#myModalx').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModalx").empty(); });
	} });
}
function verMedicamento(id_medi, nombre_m){
	$("#myModalx").load("farmacia/medicamentos/htmls/ficha_medicamento_c.php",function(response,status,xhr){ if(status=="success"){
		$('#id_user_reg_m').val($('#id_user').val()); $('#id_med_up').val(id_medi); $('#medicamento_base').removeClass('hidden');
		$('#titulo_modal').text('FICHA DEL MEDICAMENTO '+nombre_m); $('#guardarM').text('Actualizar');
		
		var tamM = $('#referencia').height() - $('#my_footer').height() - 144;
		var oTableM = $('#dataTableM').DataTable({
			serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns": [
				{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}
			],
			"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"S><"proc">', 
			deferRender: true, select: {style:'single'}, "processing": false, 
			"sAjaxSource": "farmacia/medicamentos/datatable-serverside/medicamentos_genericos.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
				aoData.push( {"name": "accesoU", "value": acceso } ); aoData.push( {"name": "idU", "value": idU } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "MEDICAMENTOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN MEDICAMENTO FILTRADO.", "sInfoFiltered": " TOTAL DE MEDICAMENTOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 200, paging: true,
		});
		$('#clickmeM').click(function(e) { oTableM.draw(); }); window.setTimeout(function(){$('#clickmeM').click();},500);
		//para los fintros individuales por campo de texto
		oTableM.columns().every( function () {
			var that = this;
			$('input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
			});
		} );
		//fin filtros individuales por campo de texto
		oTableM.on( 'select', function(e, dt, type, indexes){
			$('.ocul').removeClass('hidden');
			var rowData=oTableM.rows(indexes).data().toArray(); $('#cat_riesgo_e, #tex_cat_re').text(rowData[0][5]); //alert(rowData[0][4]);
			$('#tex_presentacion').text(rowData[0][6]); $('#tex_via').text(rowData[0][7]); $('#tex_dosis').val(rowData[0][8]);
			$('#tex_generalidades').text(rowData[0][9]); $('#tex_interacciones').text(rowData[0][10]);
			$('#tex_adversos').text(rowData[0][11]); $('#tex_contrain').text(rowData[0][12]); $('#tex_re').text(rowData[0][13]);
			$('#id_mg').val(rowData[0][14]); $('#form-medicamento').validator('update'); $('#tex_base').text(rowData[0][0]);
		})
		.on( 'deselect', function ( e, dt, type, indexes ){
			$('.ocul').addClass('hidden'); $('#tex_dosis,#precio_p_m').val(''); $('#form-medicamento').validator('update')
		});$('.ocul').removeClass('hidden');
		
		var datosM = {id_medi:id_medi}
		$.post('farmacia/medicamentos/files-serverside/infoMedicamentos.php',datosM).done(function(data){
			var datos = data.split('}{[_}');
			
			$("#miSucursalNS").load('pacientes/genera/genera_sucursales_ov.php?idU='+$('#id_user').val(),function(response,status,xhr){
				if (status = "success"){ $("#miSucursalNS").val($('#miSucursal').val()); }
			});
			
			$('#cat_riesgo_e, #tex_cat_re').text(datos[5]); //alert(rowData[0][4]);
			$('#tex_presentacion').text(datos[6]); $('#tex_via').text(datos[7]); $('#tex_dosis').val(datos[8]);
			$('#tex_generalidades').text(datos[9]); $('#tex_interacciones').text(datos[10]);
			$('#tex_adversos').text(datos[11]); $('#tex_contrain').text(datos[12]); $('#tex_re').text(datos[13]);
			$('#id_mg').val(datos[14]); $('#nombre_c_m').val(datos[15]); $('#precio_p_m').val(datos[16]);
			$('#precio_h_m').val(datos[17]); $('#precio_m_m').val(datos[18]); $('#costo_m').val(datos[19]);
			$('#codigo_b_m').val(datos[20]); $('#form-medicamento').validator('update'); $('#tex_base').text(datos[0]);
		});
		
		$('#form-medicamento').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			//$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			//var $btn = $('#btn_new_u').button('loading'); $('#btn_cancel_new_u').hide();
			var datosP = $('#form-medicamento').serialize();
			$.post('farmacia/medicamentos/files-serverside/updateMedicamento.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $('#myModalx').modal('hide'); //$btn.button('reset'); $('#btn_cancel_new_u').show(); 
					swal({
					  title: "¡CONFIRMACIÓN!", type: "success", text: "Los datos del medicamento se han actualizado.",
					  timer: 1800, showConfirmButton: false
					}); return;
				} else{alert(data);}
			});
		  }
		});
					
		$('#myModalx').modal('show');
		$('#myModalx').on('shown.bs.modal', function (e) { $('#formEstudio').validator(); });
		$('#myModalx').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModalx").empty(); });
	} });
}
</script>
