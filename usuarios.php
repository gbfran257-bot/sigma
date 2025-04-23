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
    
    <title>SISTEMA - USUARIOS</title>
    
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
	<link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    
    <!-- Mainly scripts -->
	<script src="js/jquery-3.2.1.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Clock picker -->
    <script src="js/plugins/clockpicker/bootstrap-clockpicker.js"></script>
    <script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="DataTables-1.10.13/media/js/jquery.dataTables.min.js"></script>
    <script src="DataTables-1.10.13/media/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables-1.10.13/extensions/Select/js/dataTables.select.min.js"></script>
    <script src="bootstrap-validator/js/validator.js"></script>
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.media.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.printElement.min.js" type="text/javascript"></script>
    <script src='c3/c3.min.js'></script>
    <script src='c3/d3/d3.min.js'></script>
    <script src="jq-file-upload-9.12.5/js/jquery.iframe-transport.js"></script>
	<script src="jq-file-upload-9.12.5/js/jquery.fileupload.js"></script>
    <script src='tinymce/tinymce.min.js'></script>
    <!-- Input Mask-->
    <script src="jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
    <!-- Mis funciones -->
    <script src="funciones/js/inicio.js"></script>
    <script src="funciones/js/caracteres.js"></script>
    <script src="funciones/js/calcula_edad.js"></script>
    <script src="funciones/js/stdlib.js"></script>
    <script src="funciones/js/bs-modal-fullscreen.js"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
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
    <link href="css/plugins/clockpicker/bootstrap-clockpicker.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<style>
		.select2-dropdown{
			z-index: 9999;
		}
		.panel-heading {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

    </style>
</head>
<?php include_once 'partes/header.php';?>
<?php
	if(isset($_GET['id_user'])) {
		$encode_id = $_GET['id_user'];
		$decode_id = base64_decode($encode_id);
		$user_id_array = explode('encodeuserid', $decode_id);
		$id_ucher = $user_id_array[1];
	}
?>
<!-- Contenido --><input name="xhgc" type="hidden" id="xhgc" value="<?php echo $id_ucher; ?>">
	<div class="hidden" id="dpa_imprimir"></div><div class="hidden" id="dpa_imprimir1"></div>
	
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead>
  <tr role="row" class="bg-primary">
    <th id="clickme" align="center" width="1px">ID</th>
        <th align="center" width="20px" nowrap>TÍTULO</th>
        <th align="center">NOMBRE</th>
        <th align="center" width="10px" nowrap>
        	<?php if($_SESSION['MM_UserGroup']==1){ ?>
        	<button type="button" class="btn btn-default btn-xs" onClick="nuevoUsuario();"><i class="fa fa-user-plus" aria-hidden="true"></i> USUARIO</button>
            <?php }else{echo "USUARIO";} ?>
        </th>
        <th align="center" width="10px">SUCURSAL</th>
        <th align="center">ACCESO</th>
     	<th align="center" width="130px" nowrap>DEPARTAMENTO</th>
        <th align="center" width="100px" nowrap>#CELULAR</th>
        <th align="center" width="50px" nowrap>RESET P</th>
        <th align="center" title="Habilitar/Inhabilitar usuario" width="30">ACTIVO</th>
        <th align="center" width="10px" nowrap>DOCS</th>
        <th align="center" width="10px" nowrap><span title="PERMISOS">PERM</span></th>
        <th align="center" width="10px" nowrap><span title="UBICACIÓN">UBI</span></th>
        <th align="center" width="10px" nowrap>VALIDADO</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Título" style="max-width:55px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Nombre"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Usuario" style="max-width:90px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Sucursal" style="max-width:100px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Nivel acceso" style="max-width:120px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Departamento" style="max-width:110px;"/></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
function validar_cuenta(id_u,nombre_u){
	swal({
	  title: "USUARIO "+nombre_u,
	  text: "¿Estás seguro de validar la cuenta del usuario?", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Validarlo", cancelButtonText: "Cancelar", closeOnConfirm: false
	},
	function(){
	  	var dato = {id_u:id_u}
		$.post('usuarios/files-serverside/validar_cuenta.php',dato).done(function(data){
			if(data==1){
				$('#clickme').click(); swal({title:"",type:"",text:"La cuenta del usuario ha sido validada", timer: 1800, showConfirmButton: false});
			}else{alert(data);}
		});
	});
}
$(document).ready(function(e){
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>ADMINISTRACIÓN</li><li class="active"><strong>USUARIOS</strong></li>');
	
	if($('#xhgc').val()!=''){
		var datos = {id:$('#xhgc').val()}
		$.post('usuarios/files-serverside/name_u.php',datos).done(function(data){ verUsuario($('#xhgc').val(), data); setTimeout(function(){    
			
			$('#tab_mi_grales').addClass('hide'); 
			$('#tab_mi_dir').addClass('hide'); 
			$('#tab_mi_con').addClass('hide'); 
			$('#tab_mi_hor').addClass('hide'); 
			$('#tab_mi_arc').addClass('hide'); 
			$('#tab_mi_fir').addClass('hide'); 
			$('#tab_mi_fot').addClass('hide'); 
			$('#tab_mi_esc').addClass('hide'); 
			$('#tab_mi_not').addClass('hide'); 
			$('#tab_mi_rec').addClass('hide'); 
			$('#tab_mi_format_im').addClass('hide'); 
			$('#tab_mi_conc').addClass('hide'); 
			$('#tab-seguridad').addClass('hide'); 
			// $('#tab_per').addClass('hide'); 


			$("#contrasena-tab").click(); }, 500);  });
	}else{ }
	//var bootstrapButton = $.fn.button.noConflict();  $.fn.bootstrapBtn = bootstrapButton; 
	
	$('#my_search').removeClass('hidden'); //$.fn.datepicker.defaults.autoclose = true;
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-155-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},
			{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":false},{"bVisible":false},
			{"bVisible":false},{"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"Si><"proc"p>', 
		deferRender: true, select: false, "processing": false, "sAjaxSource": "usuarios/datatable-serverside/usuarios.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#filtro').val(); var acceso = $('#acc_user').val(); var idU = $('#id_user').val();

			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "accesoU", "value": acceso } );
			aoData.push(  {"name": "idU", "value": idU } );
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "USUARIOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN USUARIO FILTRADO.", "sInfoFiltered": " TOTAL DE USUARIOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 100, paging: true
	});
	
	$('#clickme').click(function(e) { oTableP.draw(); }); window.setTimeout(function(){$('#clickme').click();},500);
	
	//para los filtros individuales por campo de texto
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
		
});

function cambiarFotoPerfil(id_u){

	const btnEnviar = document.querySelector("#actualizar_foto_p");
	const inputFile = document.querySelector("#foto_p");

	if (inputFile.files.length > 0) {
		let formData = new FormData();
		formData.append("idP", id_u);
		formData.append("idU", id_u);
		// formData.append("fecha", inputFile.files[0]);
		formData.append("NombreArchivo", 'foto_perfil');
		formData.append("archivo", inputFile.files[0]); // En la posición 0; es decir, el primer elemento
		fetch("usuarios/fotos/guardar.php", {
			method: 'POST',
			body: formData,
		})
			.then(respuesta => respuesta.text())
			.then(decodificado => {
				if(decodificado == 'Subido con éxito'){
					swal({
						title: "¡Bien!",
						text: decodificado,
						type: "success"
						}, function() {
							$("#fotP").load('usuarios/files-serverside/perfil_usuario.php?id='+id_u,function(response,status,xhr){
								if(status=="success"){ 
								$("#fotP").attr("src","usuarios/fotos/"+response);
							// 	// $("#tableImg").html(response);
								}
							});
						});							
				}else{
					swal("¡Uppss!", decodificado, "error");
				}
			});
	} else {
		// El usuario no ha seleccionado archivos
		alert("Selecciona un archivo");
	}		
}

function resetP(idU, usr, op){
	if(op == 1){ var titulo1 = "DESACTIVAR A "+usr, subt = "¿Deseas desactivar la cuenta del usuario?"; }
	else{ var titulo1 = "ACTIVAR A "+usr, subt = "¿Deseas activar la cuenta del usuario?"; }
	swal({
	  title:titulo1,text:subt,type:"warning",showCancelButton:true,confirmButtonColor: "#DD6B55",
	  confirmButtonText:"Aceptar",cancelButtonText:"Cancelar",closeOnConfirm:false
	},
	function(){
		var dato = { idUs:idU, idU:$('#id_user').val(), user:usr, opc:op }
		$.post('usuarios/files-serverside/reiniciarContraU.php', dato).done(function(data){
			if(data==1){ $('#clickme').click();
				swal({title:"",type:"",text:"La acción se realizó correctamente", timer: 1800, showConfirmButton: false});
			}else{alert(data);}
		});
	});
}

function resetPass(idU, usr){
	swal({
	  title:"RESET PASSWORD",text:"¿REINICIAR LA CONTRASEÑA DE "+usr+"?",type:"warning",showCancelButton:true,confirmButtonColor: "#DD6B55",
	  confirmButtonText:"Aceptar",cancelButtonText:"Cancelar",closeOnConfirm:false
	},
	function(){
		var dato = { idUs:idU, idU:$('#id_user').val() }
		$.post('usuarios/files-serverside/reiniciarContrasenaU.php', dato).done(function(data){
			if(data==1){ $('#clickme').click();
				swal({title:"",type:"",text:"LA CONTRASEÑA Y EL NOMBRE DE USUARIO ES EL MISMO Y AMBOS EN MAYÚSCULAS", timer: 1800, showConfirmButton: false});
			}else{alert(data);}
		});
	});
}

function nuevoUsuario(){
	$("#myModal").load('usuarios/htmls/fichaUsuario.php', function( response, status, xhr ){ if(status=="success"){ 
		//ocultamos el mapa de google y el marco negro
		document.getElementById("gmaps").style.display = "none";
		
		$(".insers").load('genera/inserciones.php', function( response, status, xhr ) { if ( status == "success" ) { } }); var datosF = {id:1}
		tinymce.remove("#input"); tinymce.remove("#inputFI"); tinymce.remove("#input1");
		//$('.i-checks').iCheck({checkboxClass:'icheckbox_square-green',radioClass:'iradio_square-green',});
		
		$('#registroModalLabel').text('NUEVO USUARIO');
		siempre(18.8135, -98.9535); $('#idUsuarioP').val($('#id_user').val()); $('#btn_update_nota, #btn_update_receta, #btn_update_formato_i').hide();
		
		$('.clockpicker').clockpicker().find('input').change(function(){ console.log(this.value); });
		
		var input = $('#single-input').clockpicker({
			placement: 'bottom',align: 'left',autoclose: true, //'default': 'now'
		}); $('.popover').css('z-index','3000'); //$.fn.datepicker.defaults.autoclose = true;

		$('#alerta_form').hide(); var d=new Date(); $('#temporal_s,#aleatorio_nmed,#aleatorio_rmed,#aleatorio_formai').val(d.format('Y-m-d-H-i-s-u').substring(0,22));
		var tempo = $('#temporal_s').val();
		
		var tamNM = $('#referencia').height() - $('#my_nav').height() - $('#my_footer').height()-260;
		var oTableNM = $('#dataTableNotaM').DataTable({
			serverSide: true,"sScrollY": tamNM, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns":[ {"bVisible":true},{"bVisible":true}],
			"sDom": '<"filtro1Principal1">r<"data_tPrincipal1"t><"infoPrincipal1"S><"proc1">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "consultas/datatable-serverside/notas.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var acceso = $('#acc_user').val(); var idU = $('#id_user').val(); var aleatorio = $('#temporal_s').val();
				aoData.push(  {"name": "accesoU", "value": acceso } ); aoData.push( {"name": "idU", "value": idU } );
				aoData.push(  {"name": "aleatorio", "value": aleatorio } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "NOTAS FILTRADAS: _END_",
				"sInfoEmpty": "NINGUNA NOTA FILTRADA.", "sInfoFiltered": " TOTAL DE NOTAS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 500, paging: false,
		});
		
		$('#clickmeNM').click(function(e) { oTableNM.draw(); }); $('#tab_mi_not').click(function(e){ $('#clickmeNM').click(); });
		//para los fintros individuales por campo de texto
		oTableNM.columns().every(function(){
			var that = this; $('input',this.footer()).on('keyup change',function(){ if(that.search() !== this.value){that.search(this.value).draw();} });
		});
		//fin filtros individuales por campo de texto
		
		$('#addNotaM').click(function(e) {
            $('.si_nota').removeClass('hidden'); $('.no_nota').addClass('hidden'); window.setTimeout(function(){$('#mi_nota-tab').click();},200);
			
			var datosFts ={idU:$('#id_user').val()}
			$.post('consultas/files-serverside/check_formato_nota_medica.php',datosFts).done(function(data1){
				tinymce.get("input").execCommand('mceSetContent', false, data1);
			});
        });

		select2ini("#sat", "sat.php", "INGRESA LA CLAVE DE LA CUENTA DEL SAT ");
		
		tinymce.init({ 
			selector:'#myModal #input',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
			plugins: 
				"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
			relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
			toolbar: 
				"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
			insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
			paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
			setup: function(editor){
				editor.addButton( 'mybuttonVP', {
					text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
					onclick:function(){
						var res = tinyMCE.get("input").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
						$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
						$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
					}
				});
			}
		}); $('#idusuarioNM').val($('#id_user').val());
		
		$('#formato_si').change(function(){
			var datosFts ={idU:$('#id_user').val(), idE:this.value}
			$.post('imagen/estudios/files-serverside/check_formato_individual_m.php',datosFts).done(function(data1){
				tinymce.get("inputFI").execCommand('mceSetContent', false, data1);
			});
		});
																												   
		$('#addFormatI').click(function(e) {
            $('.si_forma_i').removeClass('hidden'); $('.no_forma_i').addClass('hidden'); window.setTimeout(function(){$('#mi_format_i-tab').click();},200);
        });
																												   
		var oTableFI = $('#dataTableFormatI').DataTable({
			serverSide: true,"sScrollY": tamNM, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns":[ {"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<"filtro1Principal1">r<"data_tPrincipal1"t><"infoPrincipal1"S><"proc1">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "consultas/datatable-serverside/formatosI.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var acceso = $('#acc_user').val(); var idU = $('#id_user').val(); var aleatorio = $('#temporal_s').val();
				aoData.push(  {"name": "accesoU", "value": acceso } ); aoData.push( {"name": "idU", "value": idU } );
				aoData.push(  {"name": "aleatorio", "value": aleatorio } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "FORMATOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN FORMATO FILTRADO.", "sInfoFiltered": " TOTAL DE FORMATOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 500, paging: false,
		});
		$('#clickmeFI').click(function(e) { oTableFI.draw(); }); $('#tab_mi_format_im').click(function(e){ $('#clickmeFI').click(); });
		//para los fintros individuales por campo de texto
		oTableFI.columns().every( function () {
			var that = this; $('input',this.footer()).on('keyup change',function(){ if(that.search() !== this.value){that.search(this.value).draw();} });
		} );
		//fin filtros individuales por campo de texto
		
		tinymce.init({ 
			selector:'#myModal #inputFI',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
			plugins: 
				"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
			relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
			toolbar: 
				"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
			insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
			paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
			setup: function(editor){
				editor.addButton( 'mybuttonVP', {
					text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
					onclick:function(){
						var res = tinyMCE.get("inputFI").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
						$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
						$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
					}
				});
			}
		}); $('#idusuarioNM').val($('#id_user').val());
		
		$('#formato_si').load('usuarios/genera/estudios_img.php?tempo='+tempo,function(response,status,xhr){if(status=="success"){
			window.setTimeout(function(){ $('#formato_si').chosen(); window.setTimeout(function(){$('#formato_si_chosen').width(100+'%'); },100); },500);
		}});
				
		var oTableRM = $('#dataTableRecetaM').DataTable({
			serverSide: true,"sScrollY": tamNM, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns":[ {"bVisible":true},{"bVisible":true}],
			"sDom": '<"filtro1Principal1">r<"data_tPrincipal1"t><"infoPrincipal1"S><"proc1">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "consultas/datatable-serverside/recetas.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var acceso = $('#acc_user').val(); var idU = $('#id_user').val(); var aleatorio = $('#temporal_s').val();
				aoData.push(  {"name": "accesoU", "value": acceso } ); aoData.push( {"name": "idU", "value": idU } );
				aoData.push(  {"name": "aleatorio", "value": aleatorio } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "RECETAS FILTRADAS: _END_", "sInfoEmpty": "NINGUNA RECETA FILTRADA.", "sInfoFiltered": " TOTAL DE RECETAS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 500, paging: false,
		});
		$('#clickmeRM').click(function(e) { oTableRM.draw(); }); $('#tab_mi_rec').click(function(e){ $('#clickmeRM').click(); });
		//para los fintros individuales por campo de texto
		oTableRM.columns().every( function () {
			var that = this; $('input',this.footer()).on('keyup change',function(){ if(that.search() !== this.value){that.search(this.value).draw();} });
		} );
		//fin filtros individuales por campo de texto
		
		$('#addRecetaM').click(function(e) {
            $('.si_receta').removeClass('hidden'); $('.no_receta').addClass('hidden');window.setTimeout(function(){$('#mi_receta-tab').click();},200);
			
			var datosFts ={idU:$('#id_user').val()}
			$.post('consultas/files-serverside/check_formato_receta_medica.php',datosFts).done(function(data1){
				tinymce.get("input1").execCommand('mceSetContent', false, data1);
			});
        });
		
		tinymce.init({ 
			selector:'#myModal #input1',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
			plugins: 
				"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
			relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
			toolbar: 
				"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
			insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
			paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
			setup: function(editor){
				editor.addButton( 'mybuttonVP', {
					text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
					onclick:function(){
						var res = tinyMCE.get("input1").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
						$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
						$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
					}
				});
			}
		}); $('#idusuarioNM').val($('#id_user').val());
		
		$("#cTituloU").load('usuarios/genera/titulos.php',function(response,status,xhr){ if(status == "success"){ $(this).val(1); } });
		$("#sexoP").load('usuarios/files-serverside/genera_sexos.php',function(response,status,xhr){ if(status == "success"){} });
		$("#sucursalP").load('usuarios/files-serverside/genera_sucursales.php',function(response,status,xhr){if(status=="success"){
			$(this).val($('#sucu_user').val());
		}});
		$("#tsanguineoP").load('usuarios/files-serverside/genera_tsangre.php',function(response,status,xhr){if(status=="success"){}});
		$("#departamentoU").load('usuarios/files-serverside/genera_depto.php',function(response,status,xhr){if(status=="success"){}});
		$("#puestoU").load('usuarios/files-serverside/genera_puestos.php',function(response,status,xhr){if(status=="success"){}});
		$("#estatusU").load('usuarios/genera/estatus_labo.php',function(response,status,xhr){if(status=="success"){}});
		$("#tipoUsuario").load('usuarios/genera/tipos_usuario.php?s='+$('#acc_user').val(),function(response,status,xhr){});
		$("#escolaridadP").load('usuarios/files-serverside/genera_escolaridades.php',function(response,status,xhr){
			$(this).change(function(e){
                if($(this).val()>=5){$('.superior').removeClass('hidden');}
				else{$('#profesionUsuario,#cedulaU,#especialidadU,#cedulaU1,#universidadU,#universidadEU').val('');$('.superior').addClass('hidden');}
            });
		});
		$("#universidadU,#universidadEU").load('usuarios/genera/universidades.php',function(response,status,xhr){if(status=="success"){
			window.setTimeout(function(){
				$("#universidadU").chosen(); window.setTimeout(function(){$('#universidadU_chosen').width(100+'%');},100);
				$("#universidadEU").chosen(); window.setTimeout(function(){$('#universidadEU_chosen').width(100+'%');},100);
			},500);
		}});
		$("#profesionUsuario").load('usuarios/genera/profesiones.php',function(response,status,xhr){if(status=="success"){
			window.setTimeout(function(){
				$("#profesionUsuario").chosen(); window.setTimeout(function(){$('#profesionUsuario_chosen').width(100+'%');},100);
			},500);
		}});
		$("#especialidadU").load('usuarios/files-serverside/genera_especialidades.php',function(response,status,xhr){});
			
		$("#estadoP").load('usuarios/files-serverside/genera_estados.php',function(response,status,xhr){if(status=="success"){ 
			$("#estadoP").change(function(event){
				var id = $("#estadoP").find(':selected').text();//alert(id);
				$("#municipioP").load('usuarios/files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr){
					  if(status=="success"){ 
							if ($("#estadoP").val()==''){
								var id1x=$("#estadoP").find(':selected').text(),idx=$("#municipioP").find(':selected').text();
								var id3 = $("#coloniaP").find(':selected').text();
								$("#coloniaP").load('usuarios/files-serverside/genera_colonias.php?idM='+escape(idx)+'&idE='+escape(id1x));
								$("#cpP").load('usuarios/files-serverside/genera_cp.php?idC='+escape(id3)+'&idE='+escape(id1x)+'&idM='+escape(idx));
							}
					  }
				});
			});
		} });
		
		$("#municipioP").change(function(event){
			var id = $("#municipioP").find(':selected').text();var id1 = $("#estadoP").find(':selected').text();
			$("#coloniaP").load('usuarios/files-serverside/genera_colonias.php?idM='+escape(id)+'&idE='+escape(id1));
			if ($("#municipioP").val()==''){
				var id1 = $("#estadoP").find(':selected').text();
				var id2 = $("#municipioP").find(':selected').text();
				var id3 = $("#coloniaP").find(':selected').text();
				$("#cpP").load('usuarios/files-serverside/genera_cp.php?idE='+escape(id1)+'&idM='+escape(id2)+'&idC='+escape(id3));
			}
		});
		$("#coloniaP").change(function(event){
			var idC = $("#coloniaP").find(':selected').text();var idE = $("#estadoP").find(':selected').text();var idM = $("#municipioP").find(':selected').text();
			$("#cpP").load('usuarios/files-serverside/genera_cp.php?idC='+escape(idC)+'&idE='+escape(idE)+'&idM='+escape(idM));
		});
		$("#linea_to").load('consultas/consultas/genera/lineasConsulta.php');
		$("#area_to").load('consultas/consultas/genera/areasConsulta.php'); $('#btn_cancel_add_concepto').text('Cancelar');
		$('#btn_add_concepto').removeClass('hidden'); $('#btn_update_concepto,#btn_del_concepto').addClass('hidden');
		
		$('#nvo_cto').click(function(e) { $('#panel_concepto').removeClass('hidden'); });
		$('#btn_cancel_add_concepto').click(function(e) { 
			$('#btn_add_concepto, #btn_update_concepto').addClass('disabled'); $('#btn_cancel_add_concepto').text('Cancelar');
			$('#btn_add_concepto').removeClass('hidden'); $('#btn_update_concepto,#btn_del_concepto').addClass('hidden');
            $('#panel_concepto').addClass('hidden'); $('#panel_concepto input, #panel_concepto select').val('');
        });
		
		$('#panel_concepto input').keyup(function(e) {
            if($('#nombre_to').val()!='' & $('#area_to').val()!='' & $('#linea_to').val()!='' & $('#precio_n').val()!='' & $('#precio_u').val()!='' & $('#precio_m').val()!='' & $('#precio_mu').val()!=''){ $('#btn_add_concepto, #btn_update_concepto').removeClass('disabled'); }
			else{$('#btn_add_concepto, #btn_update_concepto').addClass('disabled');}
        });
		$('#area_to').change(function(e) {
            if($('#nombre_to').val()!='' & $('#area_to').val()!='' & $('#linea_to').val()!='' & $('#precio_n').val()!='' & $('#precio_u').val()!='' & $('#precio_m').val()!='' & $('#precio_mu').val()!=''){ $('#btn_add_concepto, #btn_update_concepto').removeClass('disabled'); }
			else{$('#btn_add_concepto, #btn_update_concepto').addClass('disabled');}
        });
		
		var oTableC = $('#dataTableTos').DataTable({
			serverSide: true,ordering: false, searching: false, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns": [
				{"bVisible":true},{"bVisible":true },{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},
				{"bVisible":true},
				{"bVisible":true},
				{"bVisible":true},
				{"bVisible":true}
			],
			"sDom": '<""f>r<""t><""S><""p>',  deferRender: true, select: false, "processing": false, 
			"sAjaxSource": "usuarios/datatable-serverside/conceptos.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var aleatorio = $('#temporal_s').val(); aoData.push( {"name": "aleatorio", "value": aleatorio } );
				var acc_user = $('#acc_user').val(); aoData.push( {"name": "acc_user", "value": acc_user } );
			},
			"oLanguage": {
				"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"ESTE USUARIO NO CUENTA CON CONCEPTOS",
				"sInfo": "CONCEPTOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN CONCEPTO FILTRADO.", "sInfoFiltered": " TOTAL DE CONCEPTOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 500, paging: false,
		}); $('#clickmeTos').click(function(e) { oTableC.draw(); });
		$('#tab_mi_conc').click(function(e) { window.setTimeout(function(){oTableC.draw();},200); });
		
		$('#btn_add_concepto').click(function(e) {
            if($(this).hasClass('disabled')){
				swal({title: "", type: "error", text: "Debe completar todos los campos.", timer: 1300, showConfirmButton: false});
			}else{ $('#btn_add_concepto').addClass('disabled');
				var datos = {nombre:$('#nombre_to').val(), area:$('#area_to').val(), linea:$('#linea_to').val(), precio:$('#precio_n').val(), precioU:$('#precio_u').val(), precioM:$('#precio_m').val(), precioMU:$('#precio_mu').val(), idU:$('#idUsuarioP').val(), temporal:tempo, precio_h:$('#precio_h').val(),precio_costoproduccion:$('#precio_costoproduccion').val(),honorario_c:$('#honorario_c').val(),honorario_cu:$('#honorario_cu').val(),sat:$('#sat').val()}
				$.post('usuarios/files-serverside/addConcepto.php',datos).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
						$('#clickmeTos').click(); $('#btn_cancel_add_concepto').click();
						swal({ title:"", type:"success", text:"El concepto se ha creado.", timer:1500, showConfirmButton:false });
					} else{alert(data);}
				});
			}
        });
		$('#btn_update_concepto').click(function(e) {
            if($(this).hasClass('disabled')){
				swal({title: "", type: "error", text: "Debe completar todos los campos.", timer: 1300, showConfirmButton: false});
			}else{ $('#btn_update_concepto').addClass('disabled');
				var datos = {id:$('#mi_id_to').val(),nombre:$('#nombre_to').val(), area:$('#area_to').val(),linea:$('#linea_to').val(),precio:$('#precio_n').val(),precioU:$('#precio_u').val(),precioM:$('#precio_m').val(),precioMU:$('#precio_mu').val(),idU:$('#idUsuarioP').val(),temporal:tempo,precioH:$('#precio_h').val(),precio_costoproduccion:$('#precio_costoproduccion').val(),honorario_c:$('#honorario_c').val(),honorario_cu:$('#honorario_cu').val(),sat:$('#sat').val()}
				$.post('usuarios/files-serverside/updateConcepto.php',datos).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
						$('#clickmeTos').click(); $('#btn_cancel_add_concepto').click();
						swal({ title:"", type:"", text:"El concepto se ha actualizado.", timer:1500, showConfirmButton:false });
					} else{alert(data);}
				});
			}
        });
		$('#btn_del_concepto').click(function(e) {
			swal({
			  title: "", text: "¿Estás seguro de eliminar el concepto?", type: "warning", showCancelButton: true,
			  confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
			},
			function(){
			  	var datos = {id:$('#mi_id_to').val()}
				$.post('usuarios/files-serverside/deleteConcepto.php',datos).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
						$('#clickmeTos').click(); $('#btn_cancel_add_concepto').click();
						swal({ title:"", type:"", text:"El concepto se ha eliminado.", timer:1500, showConfirmButton:false });
					} else{alert(data);}
				});
			});
        });
		
		var oTableDoc = $('#dataTableDocs').DataTable({
			serverSide: true,ordering: false, searching: false, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns":[
				{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},
				{"bVisible":true},{"bVisible":true}
			],
			"sDom": '<""f>r<""t><""S><""p>',  deferRender: true, select: false, "processing": false, 
			"sAjaxSource": "usuarios/datatable-serverside/documentos.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var aleatorio = $('#temporal_s').val(); aoData.push( {"name": "aleatorio", "value": aleatorio } );
				var acc_user = $('#acc_user').val(); aoData.push( {"name": "acc_user", "value": acc_user } );
			},
			"oLanguage": {
				"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"ESTE USUARIO NO CUENTA CON DOCUMENTOS O IMÁGENES",
				"sInfo": "DOCUMENTOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN DOCUMENTO FILTRADO.", "sInfoFiltered": " TOTAL DE DOCUMENTOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 100, paging: false,
		}); $('#clickmeDocs').click(function(e) { oTableDoc.draw(); });
		$('#tab_mi_arc').click(function(e) { window.setTimeout(function(){oTableDoc.draw();},200); });
		
		$('#titulo_foto').keyup(function(e) {
            if($(this).val()!=''){ $('#btn_add_doc').removeClass('disabled'); }else{ $('#btn_add_doc').addClass('disabled'); }
        });
		$('#btn_add_doc').click(function(e) { if($('#titulo_foto').val()!=''){ $('#fileupload_foto').click(); }else{ } });
		//Para el upload
		'use strict';
		// Change this to the location of your server-side upload handler:
		var ko = $('#id_user').val();
		var url = window.location.hostname === 'blueimp.github.io' ?
					'//jquery-file-upload.appspot.com/' : 'usuarios/documentos/index.php?idU='+ko+'&idP='+tempo+'&nombreD='+escape($('#titulo_foto').val());
		$('#fileupload_foto').fileupload({
			url: url, dataType: 'json',
			submit:function (e, data) {
				if($('#titulo_foto').val()!=''){
					$.each(data.files, function (index, file) {
						var input = $('#titulo_foto'); data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
					});
				}else{return false;}
			},
			progress: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);$('#progress .bar').css( 'width', progress + '%' );
			},
			done: function (e, data) {
				swal({title:"",type:"",text:"El documento se ha cargado correctamente!",timer:1800,showConfirmButton:false});
				$('#clickmeDocs').click(); $('#titulo_foto').val(''); $('#btn_add_doc').addClass('disabled');
			}
		}); //Para el upload
		$('#checkbox-lu').click(function(e){
        	if($(this).is(':checked')){ $('#lunes_de1').val('08:00');$('#lunes_a1').val('18:00');$('#t_lunes').val(1); }
			else{ $('#lunes_de1').val('00:00');$('#lunes_a1').val('00:00');$('#t_lunes').val(0); } 
        });
		$('#checkbox-ma').click(function(e){
        	if($(this).is(':checked')){ $('#martes_de1').val('08:00');$('#martes_a1').val('18:00');$('#t_martes').val(1); }
			else{ $('#martes_de1').val('00:00');$('#martes_a1').val('00:00');$('#t_martes').val(0); } 
        });
		$('#checkbox-mi').click(function(e){
        	if($(this).is(':checked')){$('#miercoles_de1').val('08:00');$('#miercoles_a1').val('18:00');$('#t_miercoles').val(1); }
			else{$('#miercoles_de1').val('00:00');$('#miercoles_a1').val('00:00');$('#t_miercoles').val(0); } 
        });
		$('#checkbox-ju').click(function(e){
        	if($(this).is(':checked')){$('#jueves_de1').val('08:00');$('#jueves_a1').val('18:00');$('#t_jueves').val(1); }
			else{$('#jueves_de1').val('00:00');$('#jueves_a1').val('00:00');$('#t_jueves').val(0); } 
        });
		$('#checkbox-vi').click(function(e){
        	if($(this).is(':checked')){$('#viernes_de1').val('08:00');$('#viernes_a1').val('18:00');$('#t_viernes').val(1); }
			else{$('#viernes_de1').val('00:00');$('#viernes_a1').val('00:00');$('#t_viernes').val(0); } 
        });
		$('#checkbox-sa').click(function(e){
        	if($(this).is(':checked')){$('#sabado_de1').val('08:00');$('#sabado_a1').val('14:00');$('#t_sabado').val(1); }
			else{$('#sabado_de1').val('00:00');$('#sabado_a1').val('00:00');$('#t_sabado').val(0); } 
        });
		$('#checkbox-do').click(function(e){
        	if($(this).is(':checked')){$('#domingo_de1').val('08:00');$('#domingo_a1').val('14:00');$('#t_domingo').val(1); }
			else{$('#domingo_de1').val('00:00');$('#domingo_a1').val('00:00');$('#t_domingo').val(0); } 
        });
		
		$('#sucursal_as').load('usuarios/genera/sucursales.php?tempo='+tempo,function(response,status,xhr){if(status=="success"){
			window.setTimeout(function(){ $('#sucursal_as').chosen(); window.setTimeout(function(){$('#sucursal_as_chosen').width(100+'%'); },100); },500);
		}});
		$('#sucursal_as').change(function(e) {
            if($(this).val()!=''){$('#btn_asigna_sucu').removeClass('disabled');}else{$('#btn_asigna_sucu').addClass('disabled');}
        });
		$('#btn_asigna_sucu').click(function(e) {
            if(!$(this).hasClass('disabled')){
				var datos = {id_sucu:$('#sucursal_as').val(), id_u:$('#id_user').val(), tempo:tempo}
				$.post('usuarios/files-serverside/asignarSucursal.php',datos).done(function( data ) {
					if(data==1){//si el paciente se Actualizó 
						$('#clickmeSu').click(); $('#btn_asigna_sucu').addClass('disabled'); $('#sucursal_as').val('');
						$("#sucursal_as").trigger("chosen:updated");
						swal({title: "", type: "success", text: "La sucursal se asignó al usuario.", timer: 1800, showConfirmButton: false}); return;
					}else if(data==2){
						$('#btn_asigna_sucu').addClass('disabled'); $('#sucursal_as').val('');
						$("#sucursal_as").trigger("chosen:updated");
						swal({title:"",type:"",text:"Esta sucursal ya ha sido asignada al usuario.", timer: 1800, showConfirmButton: false});
					} else{alert(data);}
				});
			}else{}
        });
		var oTableSuc = $('#dataTableSucus').DataTable({
			serverSide: true,ordering: false, searching: false, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<""f>r<""t><""S><""p>',  deferRender: true, select: false, "processing": false, 
			"sAjaxSource": "usuarios/datatable-serverside/sucursales_asignadas.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var aleatorio = $('#temporal_s').val(); aoData.push( {"name": "aleatorio", "value": aleatorio } );
			},
			"oLanguage": {
				"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"ESTE USUARIO NO CUENTA CON SUCURSALES ASIGNADAS",
				"sInfo": "SUCURSALES FILTRADAS: _END_",
				"sInfoEmpty": "NINGUNA SUCURSAL FILTRADA.", "sInfoFiltered": " TOTAL DE SUCURSALES: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 100, paging: false,
		}); $('#clickmeSu').click(function(e) { oTableSuc.draw(); });
		$('#tab_mi_suc').click(function(e) { window.setTimeout(function(){oTableSuc.draw();},200); });
		
		$('.chekito').click(function(e) { //alert($(this).attr('lang'));
			if($(this).is(':checked')){ $('#'+$(this).attr('lang')).val(1); }else{ $('#'+$(this).attr('lang')).val(0); }
        });
		
		$('#form-registro').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			$("#alerta_form").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_form").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); //var $btn = $('#btn_registro').button('loading'); $('#btn_cancel_registro').hide();
			var datosP = $('#myModal #form-registro').serialize();
			$.post('usuarios/files-serverside/addUsuario.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $('#myModal').modal('hide'); //$('#btn_cancel_registro').show(); //$btn.button('reset');
					swal({ title: "", type: "success", text: "El usuario ha sido creado.", timer: 1800, showConfirmButton: false }); return;
				} else{alert(data);}
			});
		  }
		});
	
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal',function(e){//window.setTimeout(function(){ubicacion('tren escenico cuautla morelos')},2000);
			$('#form-registro').validator();
		});
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });

		//checkbox para seleccionar todos los permisos
		$('#permisos_recepcion').change(function() {
			if ($(this).is(':checked')) {
				$('#p_0').prop('checked', true);
				$('#p_1').prop('checked', true);
				$('#p_2').prop('checked', true);
				$('#p_3').prop('checked', true);
				$('#p_4').prop('checked', true);
				$('#p_5').prop('checked', true);
				$('#p_6').prop('checked', true);
			} else {
				$('#p_0').prop('checked', false);
				$('#p_1').prop('checked', false);
				$('#p_2').prop('checked', false);
				$('#p_3').prop('checked', false);
				$('#p_4').prop('checked', false);
				$('#p_5').prop('checked', false);
				$('#p_6').prop('checked', false);
			}
		});

		$('#permisos_consultas').change(function() {
			if ($(this).is(':checked')) {
				$('#p_8').prop('checked', true);
				$('#p_9').prop('checked', true);
				$('#p_10').prop('checked', true);
			} else {
				$('#p_8').prop('checked', false);
				$('#p_9').prop('checked', false);
				$('#p_10').prop('checked', false);
			}
		});

		$('#permisos_hospital').change(function() {
			if ($(this).is(':checked')) {
				$('#p_12').prop('checked', true);
				$('#p_13').prop('checked', true);
				$('#p_14').prop('checked', true);
			} else {
				$('#p_12').prop('checked', false);
				$('#p_13').prop('checked', false);
				$('#p_14').prop('checked', false);
			}
		});

		$('#permisos_imagen').change(function() {
			if ($(this).is(':checked')) {
				$('#p_15').prop('checked', true);
				$('#p_16').prop('checked', true);
				$('#p_17').prop('checked', true);
				$('#p_18').prop('checked', true);
				$('#p_19').prop('checked', true);
				$('#p_20').prop('checked', true);
			} else {
				$('#p_15').prop('checked', false);
				$('#p_16').prop('checked', false);
				$('#p_17').prop('checked', false);
				$('#p_18').prop('checked', false);
				$('#p_19').prop('checked', false);
				$('#p_20').prop('checked', false);
			}
		});

		$('#permisos_laboratorio').change(function() {
			if ($(this).is(':checked')) {
				$('#p_22').prop('checked', true);
				$('#p_23').prop('checked', true);
				$('#p_24').prop('checked', true);
				$('#p_25').prop('checked', true);
				$('#p_26').prop('checked', true);
			} else {
				$('#p_22').prop('checked', false);
				$('#p_23').prop('checked', false);
				$('#p_24').prop('checked', false);
				$('#p_25').prop('checked', false);
				$('#p_26').prop('checked', false);
			}
		});

		$('#permisos_servicios').change(function() {
			if ($(this).is(':checked')) {
				$('#p_28').prop('checked', true);
				$('#p_29').prop('checked', true);
				$('#p_30').prop('checked', true);
			} else {
				$('#p_28').prop('checked', false);
				$('#p_29').prop('checked', false);
				$('#p_30').prop('checked', false);
			}
		});

		$('#permisos_farmacia').change(function() {
			if ($(this).is(':checked')) {
				$('#p_32').prop('checked', true);
				$('#p_33').prop('checked', true);
				$('#p_34').prop('checked', true);
				$('#p_35').prop('checked', true);
				$('#p_36').prop('checked', true);
				$('#p_50').prop('checked', true);
				$('#p_49').prop('checked', true);
				$('#p_51').prop('checked', true);
			} else {
				$('#p_32').prop('checked', false);
				$('#p_33').prop('checked', false);
				$('#p_34').prop('checked', false);
				$('#p_35').prop('checked', false);
				$('#p_36').prop('checked', false);
				$('#p_50').prop('checked', false);
				$('#p_49').prop('checked', false);
				$('#p_51').prop('checked', false);
			}
		});

		$('#permisos_administracion').change(function() {
			if ($(this).is(':checked')) {
				$('#p_38').prop('checked', true);
				$('#p_39').prop('checked', true);
				$('#p_40').prop('checked', true);
				$('#p_41').prop('checked', true);
				$('#p_42').prop('checked', true);
				$('#p_43').prop('checked', true);
				$('#p_44').prop('checked', true);
				$('#p_45').prop('checked', true);
				$('#p_48').prop('checked', true);
				$('#p_46').prop('checked', true);
				$('#p_47').prop('checked', true);
				$('#p_7').prop('checked', true);
				$('#p_11').prop('checked', true);
				$('#p_21').prop('checked', true);
				$('#p_27').prop('checked', true);
				$('#p_31').prop('checked', true);
				$('#p_37').prop('checked', true);
			} else {
				$('#p_38').prop('checked', false);
				$('#p_39').prop('checked', false);
				$('#p_40').prop('checked', false);
				$('#p_41').prop('checked', false);
				$('#p_42').prop('checked', false);
				$('#p_43').prop('checked', false);
				$('#p_44').prop('checked', false);
				$('#p_45').prop('checked', false);
				$('#p_48').prop('checked', false);
				$('#p_46').prop('checked', false);
				$('#p_47').prop('checked', false);
				$('#p_7').prop('checked', false);
				$('#p_11').prop('checked', false);
				$('#p_21').prop('checked', false);
				$('#p_27').prop('checked', false);
				$('#p_31').prop('checked', false);
				$('#p_37').prop('checked', false);
			}
		});
		//
	}});
}

function verUsuario(idU, nombre_u, tempi_u){
	$("#myModal1").load('usuarios/htmls/fichaUsuario.php?id_uu='+idU, function( response, status, xhr ){ if(status=="success"){
		//ocultamos el mapa de google y el marco negro
		document.getElementById("gmaps").style.display = "none";

		$(".insers").load('genera/inserciones.php', function( response, status, xhr ) { if ( status == "success" ) { } }); var datosF = {id:1}
		tinymce.remove("#input"); tinymce.remove("#input1"); tinymce.remove("#inputFI"); $('#btn_update_nota, #btn_update_receta, #btn_update_formato_i').hide();
		$('#aleatorio_nmed, #aleatorio_rmed, #aleatorio_formai').val('');
		
		$('#btn_registro_u').text('Actualizar'); $('#registroModalLabel').text('FICHA DE DATOS DEL USUARIO '+nombre_u);
		$('#username').replaceWith('<input name="username" id="username" type="text" class="form-control form-control-sm" readonly>');
		
		$('#idUsuarioP').val($('#id_user').val()); $('#idUsuarioN').val(idU); $('#btn_cancel_registro').text('Cerrar');
		$('.clockpicker').clockpicker().find('input').change(function(){ console.log(this.value); });
		var input = $('#single-input').clockpicker({placement: 'bottom',align: 'left',autoclose: true});
		$('.popover').css('z-index','3000');//alert(tempi_u); //$.fn.datepicker.defaults.autoclose = true;
		$('#alerta_form').hide(); var d = new Date(); 
		if(tempi_u==''){$('#temporal_s').val(d.format('Y-m-d-H-i-s-u').substring(0,22));}else{$('#temporal_s').val(tempi_u);}
		//d.format('Y-m-d-H-i-s-u').substring(0,22));
		var tempo = $('#temporal_s').val();//$('#temporal_s').val();
		
		var tamNM = $('#referencia').height() - $('#my_nav').height() - $('#my_footer').height()-260;
		var oTableNM = $('#dataTableNotaM').DataTable({
			serverSide: true,"sScrollY": tamNM, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns":[ {"bVisible":true},{"bVisible":true}],
			"sDom": '<"filtro1Principal1">r<"data_tPrincipal1"t><"infoPrincipal1"S><"proc1">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "consultas/datatable-serverside/notas.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var acceso = $('#acc_user').val(); //var idU = $('#id_user').val();
				aoData.push(  {"name": "accesoU", "value": acceso } ); aoData.push(  {"name": "idU", "value": idU } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "NOTAS FILTRADAS: _END_",
				"sInfoEmpty": "NINGUNA NOTA FILTRADA.", "sInfoFiltered": " TOTAL DE NOTAS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 500, paging: false,
		});
		$('#clickmeNM').click(function(e) { oTableNM.draw(); }); $('#tab_mi_not').click(function(e){ $('#clickmeNM').click(); });
		
		//para los filtros individuales por campo de texto
		oTableNM.columns().every( function () {
			var that = this;
			$( 'input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
			} );
		} );
		//fin filtros individuales por campo de texto
		$('#addNotaM').click(function(e) {
            $('.si_nota').removeClass('hidden'); $('.no_nota').addClass('hidden'); window.setTimeout(function(){$('#mi_nota-tab').click();},200);
			
			var datosFts ={idU:$('#id_user').val()}
			$.post('consultas/files-serverside/check_formato_nota_medica.php',datosFts).done(function(data1){
				tinymce.get("input").execCommand('mceSetContent', false, data1);
			});
        });
		
		tinymce.init({ 
			selector:'#myModal1 #input',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
			plugins: 
				"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
			relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
			toolbar: 
				"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
			insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
			paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
			setup: function(editor){
				editor.addButton( 'mybuttonVP', {
					text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
					onclick:function(){
						var res = tinyMCE.get("input").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
						$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
						$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
					}
				});
			}
		}); $('#idusuarioNM').val($('#id_user').val());
		
		select2ini("#sat", "sat.php", "INGRESA LA CLAVE DE LA CUENTA DEL SAT ");
		$('#formato_si').change(function(){
			var datosFts ={idU:$('#id_user').val(), idE:this.value}
			$.post('imagen/estudios/files-serverside/check_formato_individual_m.php',datosFts).done(function(data1){
				tinymce.get("inputFI").execCommand('mceSetContent', false, data1);
			});
		});
																												   
		$('#addFormatI').click(function(e) {
            $('.si_forma_i').removeClass('hidden'); $('.no_forma_i').addClass('hidden'); window.setTimeout(function(){$('#mi_format_i-tab').click();},200);
        });
		
		var oTableFI = $('#dataTableFormatI').DataTable({
			serverSide: true,"sScrollY": tamNM, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns":[ {"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<"filtro1Principal1">r<"data_tPrincipal1"t><"infoPrincipal1"S><"proc1">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "consultas/datatable-serverside/formatosI.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var acceso = $('#acc_user').val(); var idU = $('#id_user').val(); var aleatorio = $('#temporal_s').val();
				aoData.push(  {"name": "accesoU", "value": acceso } ); aoData.push( {"name": "idU", "value": idU } );
				aoData.push(  {"name": "aleatorio", "value": tempi_u } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "FORMATOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN FORMATO FILTRADO.", "sInfoFiltered": " TOTAL DE FORMATOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 500, paging: false,
		});
		$('#clickmeFI').click(function(e) { oTableFI.draw(); }); $('#tab_mi_format_im').click(function(e){ $('#clickmeFI').click(); });
		//para los fintros individuales por campo de texto
		oTableFI.columns().every( function () {
			var that = this;
			$('input',this.footer()).on('keyup change',function(){ if(that.search() !== this.value){that.search(this.value).draw();} });
		} );
		//fin filtros individuales por campo de texto
		
		tinymce.init({ 
			selector:'#myModal1 #inputFI',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
			plugins: 
				"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
			relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
			toolbar: 
				"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
			insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
			paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
			setup: function(editor){
				editor.addButton( 'mybuttonVP', {
					text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
					onclick:function(){
						var res = tinyMCE.get("inputFI").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
						$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
						$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
					}
				});
			}
		});

		$("#fotP").load('usuarios/files-serverside/perfil_usuario.php?id='+idU,function(response,status,xhr){
			if(status=="success"){ 
				if(response != '.'){
					$("#fotP").attr("src","usuarios/fotos/"+response);
				}else{
					$("#fotP").attr("src","imagenes/user_profile_male.png");
				}
			
		// 	// $("#tableImg").html(response);
			}
		});
		
		$('#formato_si').load('usuarios/genera/estudios_img.php?tempo='+tempo,function(response,status,xhr){if(status=="success"){
			window.setTimeout(function(){ $('#formato_si').chosen(); window.setTimeout(function(){$('#formato_si_chosen').width(100+'%'); },100); },500);
		}});
		
		var oTableRM = $('#dataTableRecetaM').DataTable({
			serverSide: true,"sScrollY": tamNM, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns":[ {"bVisible":true},{"bVisible":true}],
			"sDom": '<"filtro1Principal1">r<"data_tPrincipal1"t><"infoPrincipal1"S><"proc1">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "consultas/datatable-serverside/recetas.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var acceso = $('#acc_user').val(); var idU = $('#id_user').val(); var aleatorio = $('#temporal_s').val();
				aoData.push(  {"name": "accesoU", "value": acceso } ); aoData.push( {"name": "idU", "value": idU } );
				aoData.push(  {"name": "aleatorio", "value": aleatorio } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "RECETAS FILTRADAS: _END_", "sInfoEmpty": "NINGUNA RECETA FILTRADA.", "sInfoFiltered": " TOTAL DE RECETAS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 500, paging: false,
		});
		$('#clickmeRM').click(function(e) { oTableRM.draw(); }); $('#tab_mi_rec').click(function(e){ $('#clickmeRM').click(); });
		//para los fintros individuales por campo de texto
		oTableRM.columns().every( function () {
			var that = this; $('input',this.footer()).on('keyup change',function(){ if(that.search() !== this.value){that.search(this.value).draw();} });
		} );
		//fin filtros individuales por campo de texto
		
		$('#addRecetaM').click(function(e) {
            $('.si_receta').removeClass('hidden'); $('.no_receta').addClass('hidden');window.setTimeout(function(){$('#mi_receta-tab').click();},200);
			
			var datosFts ={idU:$('#id_user').val()}
			$.post('consultas/files-serverside/check_formato_receta_medica.php',datosFts).done(function(data1){
				tinymce.get("input1").execCommand('mceSetContent', false, data1);
			});
        });
		
		tinymce.init({ 
			selector:'#myModal1 #input1',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
			plugins: 
				"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
			relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
			toolbar: 
				"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
			insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
			paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
			setup: function(editor){
				editor.addButton( 'mybuttonVP', {
					text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
					onclick:function(){
						var res = tinyMCE.get("input1").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
						$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
						$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
					}
				});
			}
		}); $('#idusuarioNM').val($('#id_user').val());
		
		var dato_p = {id_u:idU, tempo:tempo}
		$.post('usuarios/files-serverside/fichaUsuario.php',dato_p).done(function(data){ var dato = data.split(';-}{');
			$('#nombreP').val(dato[0]); $('#apaternoP').val(dato[1]); $('#amaternoP').val(dato[2]); $('#nacionalidadP').val(dato[24]); $("#selectEquipoQx").val(dato[57]);
			$("#sexoP").load('usuarios/files-serverside/genera_sexos.php',function(response,status,xhr){if(status == "success"){
				$(this).val(dato[16]);
			}});
			$('#fnacP').val(dato[17]); $('#telmovilP').val(dato[7]); siempre(dato[34], dato[35]); var tempo = dato[50];
			$("#sucursalP").load('usuarios/files-serverside/genera_sucursales.php',function(response,status,xhr){if(status=="success"){
				$(this).val(dato[14]);
			}});
			$("#departamentoU").load('usuarios/files-serverside/genera_depto.php',function(response,status,xhr){if(status=="success"){
				$(this).val(dato[22]);
			}});
			$("#puestoU").load('usuarios/files-serverside/genera_puestos.php',function(response,status,xhr){if(status=="success"){
				$(this).val(dato[25]);
			}});
			$("#estatusU").load('usuarios/genera/estatus_labo.php',function(response,status,xhr){if(status=="success"){
				$(this).val(dato[52]);
			}});
			$("#tipoUsuario").load('usuarios/genera/tipos_usuario.php?s='+$('#acc_user').val(),function(response,status,xhr){
				if(status=="success"){$(this).val(dato[21]);}
			});
			$('#username').val(dato[20]); $('#tipo_acceso').val(dato[53]); $('#curpP').val(dato[6]);
			$("#escolaridadP").load('usuarios/files-serverside/genera_escolaridades.php',function(response,status,xhr){
				$(this).val(dato[19]);
				if(dato[19]>=5){$('.superior').removeClass('hidden');}else{
					$('#profesionUsuario,#cedulaU,#especialidadU,#cedulaU1,#universidadU,#universidadEU').val('');$('.superior').addClass('hidden');
				}
				$(this).change(function(e){
					if($(this).val()>=5){$('.superior').removeClass('hidden');}else
					{$('#profesionUsuario,#cedulaU,#especialidadU,#cedulaU1,#universidadU,#universidadEU').val('');$('.superior').addClass('hidden');}
				});
			});
			$("#cTituloU").load('usuarios/genera/titulos.php',function(response,status,xhr){if(status == "success"){
				$(this).val(dato[33]);
			}});
			$('#estatus_ge').val(dato[54]); $('#cedulaU').val(dato[5]); $('#cedulaU1').val(dato[3]); $('#rfcP').val(dato[13]);
			$("#tsanguineoP").load('usuarios/files-serverside/genera_tsangre.php',function(response,status,xhr){if(status=="success"){
				$(this).val(dato[32]);
			}});
			$("#universidadU").load('usuarios/genera/universidades.php',function(response,status,xhr){if(status=="success"){
				$(this).val(dato[51]);
				window.setTimeout(function(){
					$("#universidadU").chosen(); window.setTimeout(function(){$('#universidadU_chosen').width(100+'%');},100);
				},500);
			}});
			$("#universidadEU").load('usuarios/genera/universidades.php',function(response,status,xhr){if(status=="success"){
				$(this).val(dato[56]);
				window.setTimeout(function(){
					$("#universidadEU").chosen(); window.setTimeout(function(){$('#universidadEU_chosen').width(100+'%');},100);
				},500);
			}});
			$("#profesionUsuario").load('usuarios/genera/profesiones.php',function(response,status,xhr){if(status=="success"){
				$(this).val(dato[23]);
				window.setTimeout(function(){
					$("#profesionUsuario").chosen(); window.setTimeout(function(){$('#profesionUsuario_chosen').width(100+'%');},100);
				},500);
			}});
			$("#especialidadU").load('usuarios/files-serverside/genera_especialidades.php',function(response,status,xhr){
				if(status=="success"){$(this).val(dato[4]);}
			});
			$('#notasP').val(dato[18]); $('#calleP').val(dato[27]);
			$("#estadoP").load('usuarios/files-serverside/genera_estados.php',function(response,status,xhr){if(status=="success"){
				$(this).val(dato[28]);
				$("#estadoP").change(function(event){
					var id = $("#estadoP").find(':selected').text();//alert(id);
					$("#municipioP").load('usuarios/files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr){
						  if(status=="success"){ $("#municipioP").val(dato[29]);
								if ($("#estadoP").val()==''){
									var id1x=$("#estadoP").find(':selected').text(),idx=$("#municipioP").find(':selected').text();
									var id3 = $("#coloniaP").find(':selected').text();
									$("#coloniaP").load('usuarios/files-serverside/genera_colonias.php?idM='+escape(idx)+'&idE='+escape(id1x),function(response,status,xhr){
										if(status=="success"){
											$("#coloniaP").val(dato[30]);
											
										}
									});
									$("#cpP").load('usuarios/files-serverside/genera_cp.php?idC='+escape(id3)+'&idE='+escape(id1x)+'&idM='+escape(idx),function(response,status,xhr){
										if(status=="success"){$("#cpP").val(dato[31]); }
									});
								}$("#municipioP").change();
						  }
					});
				}); $("#estadoP").change();
			}});
			$("#municipioP").change(function(event){
				var id = $("#municipioP").find(':selected').text();var id1 = $("#estadoP").find(':selected').text();
				$("#coloniaP").load('usuarios/files-serverside/genera_colonias.php?idM='+escape(id)+'&idE='+escape(id1),function(response,status,xhr){$("#coloniaP").val(dato[30]);});
				//if (dato[29]==''){
					//var id1 = $("#estadoP").find(':selected').text();
					//var id2 = $("#municipioP").find(':selected').text();
					//var id3 = $("#coloniaP").find(':selected').text();
					$("#coloniaP").change(function(event){
						var idC = $("#coloniaP").find(':selected').text();var idE = $("#estadoP").find(':selected').text();var idM = $("#municipioP").find(':selected').text();//alert('1');
						
						$("#cpP").load('usuarios/files-serverside/genera_cp.php?idC='+escape(idC)+'&idE='+escape(idE)+'&idM='+escape(idM));
					}); window.setTimeout(function(){$("#coloniaP").change();},800);
					//$("#cpP").load('usuarios/files-serverside/genera_cp.php?idE='+escape(id1)+'&idM='+escape(id2)+'&idC='+escape(id3),function(response,status,xhr){$("#cpP").val(dato[31]);});
				//}
			});
			$('#telparticularP').val(dato[8]); $('#telefonoTrabajoP').val(dato[9]); $('#extensionTelTraP').val(dato[10]);
			$('#avisarP').val(dato[12]); $('#telefonoEmergenciaP').val(dato[11]); $('#emailP').val(dato[15]);
			$('#lunes_de1').val(dato[36]); $('#lunes_a1').val(dato[37]); 
			$('#martes_de1').val(dato[38]); $('#martes_a1').val(dato[39]);
			$('#miercoles_de1').val(dato[40]); $('#miercoles_a1').val(dato[41]);
			$('#jueves_de1').val(dato[42]); $('#jueves_a1').val(dato[43]);
			$('#viernes_de1').val(dato[44]); $('#viernes_a1').val(dato[45]);
			$('#sabado_de1').val(dato[46]); $('#sabado_a1').val(dato[47]);
			$('#domingo_de1').val(dato[48]); $('#domingo_a1').val(dato[49]);
			
			$("#linea_to").load('consultas/consultas/genera/lineasConsulta.php');
			$("#area_to").load('consultas/consultas/genera/areasConsulta.php'); $('#btn_cancel_add_concepto').text('Cancelar');
			$('#btn_add_concepto').removeClass('hidden'); $('#btn_update_concepto,#btn_del_concepto').addClass('hidden');
			
			$('#nvo_cto').click(function(e) { $('#panel_concepto').removeClass('hidden'); });
			$('#btn_cancel_add_concepto').click(function(e) { 
				$('#btn_add_concepto, #btn_update_concepto').addClass('disabled'); $('#btn_cancel_add_concepto').text('Cancelar');
				$('#btn_add_concepto').removeClass('hidden'); $('#btn_update_concepto,#btn_del_concepto').addClass('hidden');
				$('#panel_concepto').addClass('hidden'); $('#panel_concepto input, #panel_concepto select').val('');
			});
			
			$('#panel_concepto input').keyup(function(e) {
				if($('#nombre_to').val()!='' & $('#area_to').val()!='' & $('#linea_to').val()!=''  & $('#precio_n').val()!='' & $('#precio_u').val()!='' & $('#precio_m').val()!='' & $('#precio_mu').val()!=''){ $('#btn_add_concepto, #btn_update_concepto').removeClass('disabled'); }
				else{$('#btn_add_concepto, #btn_update_concepto').addClass('disabled');}
			});
			$('#area_to').change(function(e) {
				if($('#nombre_to').val()!='' & $('#area_to').val()!='' & $('#linea_to').val()!='' & $('#precio_n').val()!='' & $('#precio_u').val()!='' & $('#precio_m').val()!='' & $('#precio_mu').val()!=''){ $('#btn_add_concepto, #btn_update_concepto').removeClass('disabled'); }
				else{$('#btn_add_concepto, #btn_update_concepto').addClass('disabled');}
			});
			
			var oTableC = $('#dataTableTos').DataTable({
				serverSide: true,ordering: false, searching: false, scrollCollapse: false, "scrollX": true,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
				"aoColumns": [
					{"bVisible":true},{"bVisible":true },{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}
				],
				"sDom": '<""f>r<""t><""S><""p>',  deferRender: true, select: false, "processing": false, 
				"sAjaxSource": "usuarios/datatable-serverside/conceptos.php",
				"fnServerParams": function (aoData, fnCallback) { 
					var aleatorio = tempo; aoData.push( {"name": "aleatorio", "value": aleatorio } );
					var acc_user = $('#acc_user').val(); aoData.push( {"name": "acc_user", "value": acc_user } );
				},
				"oLanguage": {
					"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"ESTE USUARIO NO CUENTA CON CONCEPTOS",
					"sInfo": "CONCEPTOS FILTRADOS: _END_",
					"sInfoEmpty": "NINGÚN CONCEPTO FILTRADO.", "sInfoFiltered": " TOTAL DE CONCEPTOS: _MAX_", "sSearch": "",
					"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
				},"iDisplayLength": 500, paging: false,
			}); $('#clickmeTos').click(function(e) { oTableC.draw(); });
			$('#tab_mi_conc').click(function(e) { window.setTimeout(function(){oTableC.draw();},200); });
			
			$('#btn_add_concepto').click(function(e) {
				if($(this).hasClass('disabled')){
					swal({title: "", type: "error", text: "Debe completar todos los campos.", timer: 1300, showConfirmButton: false});
				}else{ $('#btn_add_concepto').addClass('disabled');
					var datos = {nombre:$('#nombre_to').val(), area:$('#area_to').val(), linea:$('#linea_to').val(), precio:$('#precio_n').val(), precioU:$('#precio_u').val(), precioM:$('#precio_m').val(), precioMU:$('#precio_mu').val(), idU:$('#idUsuarioP').val(), temporal:tempo, precio_h:$('#precio_h').val(),precio_costoproduccion:$('#precio_costoproduccion').val(),honorario_c:$('#honorario_c').val(),honorario_cu:$('#honorario_cu').val(),sat:$('#sat').val()}
					$.post('usuarios/files-serverside/addConcepto.php',datos).done(function( data ) {
						if (data==1){//si el paciente se Actualizó 
							$('#clickmeTos').click(); $('#btn_cancel_add_concepto').click();
							swal({ title:"", type:"success", text:"El concepto se ha creado.", timer:1500, showConfirmButton:false });
						} else{alert(data);}
					});
				}
			});
			$('#btn_update_concepto').click(function(e) {
				if($(this).hasClass('disabled')){
					swal({title: "", type: "error", text: "Debe completar todos los campos.", timer: 1300, showConfirmButton: false});
				}else{ $('#btn_update_concepto').addClass('disabled');
					var datos = {id:$('#mi_id_to').val(),nombre:$('#nombre_to').val(), area:$('#area_to').val(), linea:$('#linea_to').val(),precio:$('#precio_n').val(),precioU:$('#precio_u').val(),precioM:$('#precio_m').val(),precioMU:$('#precio_mu').val(),idU:$('#idUsuarioP').val(),temporal:tempo,precioH:$('#precio_h').val(),precio_costoproduccion:$('#precio_costoproduccion').val(),honorario_c:$('#honorario_c').val(),honorario_cu:$('#honorario_cu').val(), pm:$('#idUsuarioN').val(), cambioGlobal: $("#cambioGlobal_cg").prop("checked"), sat:$('#sat').val()}
					$.post('usuarios/files-serverside/updateConcepto.php',datos).done(function( data ) {
						if (data==1){//si el paciente se Actualizó 
							$('#clickmeTos').click(); $('#btn_cancel_add_concepto').click();
							swal({ title:"", type:"", text:"El concepto se ha actualizado.", timer:1500, showConfirmButton:false });
							$("#cambioGlobal_cg").prop("checked", false);
						} else{alert(data);}
					});
				}
			});
			$('#btn_del_concepto').click(function(e) {
				swal({
				  title: "", text: "¿Estás seguro de eliminar el concepto?", type: "warning", showCancelButton: true,
				  confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
				},
				function(){
					var datos = {id:$('#mi_id_to').val()}
					$.post('usuarios/files-serverside/deleteConcepto.php',datos).done(function( data ) {
						if (data==1){//si el paciente se Actualizó 
							$('#clickmeTos').click(); $('#btn_cancel_add_concepto').click();
							swal({ title:"", type:"", text:"El concepto se ha eliminado.", timer:1500, showConfirmButton:false });
						} else{alert(data);}
					});
				});
			});
			
			var oTableDoc = $('#dataTableDocs').DataTable({
				serverSide: true,ordering: false, searching: false, scrollCollapse: false, "scrollX": true,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
				"aoColumns":[
					{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},
					{"bVisible":true},{"bVisible":true}
				],
				"sDom": '<""f>r<""t><""S><""p>',  deferRender: true, select: false, "processing": false, 
				"sAjaxSource": "usuarios/datatable-serverside/documentos.php",
				"fnServerParams": function (aoData, fnCallback) { 
					var aleatorio = tempo; aoData.push( {"name": "aleatorio", "value": aleatorio } );
					var acc_user = $('#acc_user').val(); aoData.push( {"name": "acc_user", "value": acc_user } );
				},
				"oLanguage": {
					"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"ESTE USUARIO NO CUENTA CON DOCUMENTOS O IMÁGENES",
					"sInfo": "DOCUMENTOS FILTRADOS: _END_",
					"sInfoEmpty": "NINGÚN DOCUMENTO FILTRADO.", "sInfoFiltered": " TOTAL DE DOCUMENTOS: _MAX_", "sSearch": "",
					"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
				},"iDisplayLength": 100, paging: false,
			}); $('#clickmeDocs').click(function(e) { oTableDoc.draw(); });
			$('#tab_mi_arc').click(function(e) { window.setTimeout(function(){oTableDoc.draw();},200); });
			
			$('#titulo_foto').keyup(function(e) {
				if($(this).val()!=''){ $('#btn_add_doc').removeClass('disabled'); }else{ $('#btn_add_doc').addClass('disabled'); }
			});
			$('#btn_add_doc').click(function(e) { if($('#titulo_foto').val()!=''){ $('#fileupload_foto').click(); }else{ } });
			//Para el upload
			'use strict';
			// Change this to the location of your server-side upload handler:
			var ko = $('#id_user').val();
			var url = window.location.hostname === 'blueimp.github.io' ?
						'//jquery-file-upload.appspot.com/' : 'usuarios/documentos/index.php?idU='+ko+'&idP='+tempo+'&nombreD='+escape($('#titulo_foto').val());
			$('#fileupload_foto').fileupload({
				url: url, dataType: 'json',
				submit:function (e, data) {
					if($('#titulo_foto').val()!=''){
						$.each(data.files, function (index, file) {
							var input = $('#titulo_foto'); data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
						});
					}else{return false;}
				},
				progress: function (e, data) {
					var progress = parseInt(data.loaded / data.total * 100, 10);$('#progress .bar').css( 'width', progress + '%' );
				},
				done: function (e, data) {
					swal({title:"",type:"",text:"El documento se ha cargado correctamente!",timer:1800,showConfirmButton:false});
					$('#clickmeDocs').click(); $('#titulo_foto').val(''); $('#btn_add_doc').addClass('disabled');
				}
			}); //Para el upload
			$('#checkbox-lu').click(function(e){
				if($(this).is(':checked')){ $('#lunes_de1').val('08:00');$('#lunes_a1').val('18:00');$('#t_lunes').val(1); }
				else{ $('#lunes_de1').val('00:00');$('#lunes_a1').val('00:00');$('#t_lunes').val(0); } 
			});
			$('#checkbox-ma').click(function(e){
				if($(this).is(':checked')){ $('#martes_de1').val('08:00');$('#martes_a1').val('18:00');$('#t_martes').val(1); }
				else{ $('#martes_de1').val('00:00');$('#martes_a1').val('00:00');$('#t_martes').val(0); } 
			});
			$('#checkbox-mi').click(function(e){
				if($(this).is(':checked')){$('#miercoles_de1').val('08:00');$('#miercoles_a1').val('18:00');$('#t_miercoles').val(1); }
				else{$('#miercoles_de1').val('00:00');$('#miercoles_a1').val('00:00');$('#t_miercoles').val(0); } 
			});
			$('#checkbox-ju').click(function(e){
				if($(this).is(':checked')){$('#jueves_de1').val('08:00');$('#jueves_a1').val('18:00');$('#t_jueves').val(1); }
				else{$('#jueves_de1').val('00:00');$('#jueves_a1').val('00:00');$('#t_jueves').val(0); } 
			});
			$('#checkbox-vi').click(function(e){
				if($(this).is(':checked')){$('#viernes_de1').val('08:00');$('#viernes_a1').val('18:00');$('#t_viernes').val(1); }
				else{$('#viernes_de1').val('00:00');$('#viernes_a1').val('00:00');$('#t_viernes').val(0); } 
			});
			$('#checkbox-sa').click(function(e){
				if($(this).is(':checked')){$('#sabado_de1').val('08:00');$('#sabado_a1').val('14:00');$('#t_sabado').val(1); }
				else{$('#sabado_de1').val('00:00');$('#sabado_a1').val('00:00');$('#t_sabado').val(0); } 
			});
			$('#checkbox-do').click(function(e){
				if($(this).is(':checked')){$('#domingo_de1').val('08:00');$('#domingo_a1').val('14:00');$('#t_domingo').val(1); }
				else{$('#domingo_de1').val('00:00');$('#domingo_a1').val('00:00');$('#t_domingo').val(0); } 
			});
			for(var it=0; it<52; it++){
				if(dato[55][it]==1){
					$("input[name='h_permisos["+it+"]']").val(1);
					$("input[name='p_"+it+"']").prop('checked', true);
				}else{
					$("input[name='h_permisos["+it+"]']").val(0);
				}
			}
			
			$('#sucursal_as').load('usuarios/genera/sucursales.php?tempo='+tempo,function(response,status,xhr){if(status=="success"){
				window.setTimeout(function(){
					$('#sucursal_as').chosen(); window.setTimeout(function(){$('#sucursal_as_chosen').width(100+'%'); },100);
				},500);
			}});
			$('#sucursal_as').change(function(e) {
				if($(this).val()!=''){$('#btn_asigna_sucu').removeClass('disabled');}else{$('#btn_asigna_sucu').addClass('disabled');}
			});
			$('#btn_asigna_sucu').click(function(e) {
				if(!$(this).hasClass('disabled')){
					var datos = {id_sucu:$('#sucursal_as').val(), id_u:$('#id_user').val(), tempo:tempo, asignar_a:idU}
					$.post('usuarios/files-serverside/asignarSucursal.php',datos).done(function( data ) {
						if(data==1){//si el paciente se Actualizó 
							$('#clickmeSu').click(); $('#btn_asigna_sucu').addClass('disabled'); $('#sucursal_as').val('');
							$("#sucursal_as").trigger("chosen:updated");
							swal({ title: "", type: "success", text: "La sucursal se asignó al usuario.", timer: 1800, showConfirmButton: false }); return;
						}else if(data==2){
							$('#btn_asigna_sucu').addClass('disabled'); $('#sucursal_as').val('');
							$("#sucursal_as").trigger("chosen:updated");
							swal({ title:"",type:"",text:"Esta sucursal ya ha sido asignada al usuario.", timer: 1800, showConfirmButton: false });
						} else{alert(data);}
					});
				}else{}
			});
			var oTableSuc = $('#dataTableSucus').DataTable({
				serverSide: true,ordering: false, searching: false, scrollCollapse: false, "scrollX": true,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
				"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
				"sDom": '<""f>r<""t><""S><""p>',  deferRender: true, select: false, "processing": false, 
				"sAjaxSource": "usuarios/datatable-serverside/sucursales_asignadas.php",
				"fnServerParams": function (aoData, fnCallback) { var aleatorio = tempo; aoData.push( {"name": "aleatorio", "value": aleatorio } ); },
				"oLanguage": {
					"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"ESTE USUARIO NO CUENTA CON SUCURSALES ASIGNADAS",
					"sInfo": "SUCURSALES FILTRADAS: _END_",
					"sInfoEmpty": "NINGUNA SUCURSAL FILTRADA.", "sInfoFiltered": " TOTAL DE SUCURSALES: _MAX_", "sSearch": "",
					"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
				},"iDisplayLength": 100, paging: false,
			}); $('#clickmeSu').click(function(e) { oTableSuc.draw(); });
			$('#tab_mi_suc').click(function(e) { window.setTimeout(function(){oTableSuc.draw();},200); });
			
			$('.chekito').click(function(e) { //alert($(this).attr('lang'));
				if($(this).is(':checked')){
					$(this).parent().parent().children("input[type='hidden']").val(1);
				}else{
					$(this).parent().parent().children("input[type='hidden']").val(0);
				}
			});
			
			$('#form-registro').validator().on('submit', function (e) {
			  if (e.isDefaultPrevented()) { // handle the invalid form...
				$("#alerta_form").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_form").slideUp(600); });
			  } else { // everything looks good!
				e.preventDefault(); 
				//var $btn = $('#btn_registro').button('loading'); $('#btn_cancel_registro').hide();
				var datosP = $('#myModal1 #form-registro').serialize();
				$.post('usuarios/files-serverside/updateUsuario.php',datosP).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
						$('#clickme').click(); $('#myModal1').modal('hide'); //$('#btn_cancel_registro').show(); //$btn.button('reset');
						swal({ title:"",type:"",text:"El usuario se ha actualizadodo.",timer:1800,showConfirmButton:false }); return;
					} else{alert(data);}
				});
			  }
			});
		});
		$('#btn_update_contra_u').click(function(e) {
            var datos = {id_u: idU, contra_actual:$('#contra_actual').val(), contra_new:$('#contra_new').val(), re_contra_new:$('#re_contra_new').val()}
			$.post('usuarios/files-serverside/updateContra.php',datos).done(function(data){//alert(data);
				if(data==2 || data==3 || data==4){
					swal({title:"",type:"error",text:"¡Debe de llenar todos los campos!",timer:1800,showConfirmButton:false});
				}else if(data == 5){
					swal({title:"",type:"error",text:"¡La contraseña nueva no coincide con el campo de confirmación!",timer:1800,showConfirmButton:false});
				}else if(data == 6){
					swal({title:"",type:"error",text:"¡La contraseña nueva debe ser de por lo menos 6 dígitos!",timer:1800,showConfirmButton:false});
				}else if(data == 0){
					swal({title:"",type:"error",text:"¡La nueva contraseña y la contraseña actual no coinciden!",timer:1800,showConfirmButton:false});
				}
				else{
					swal({title:"",type:"success",text:"¡La contraseña se ha actualizado correctamente!",timer:1800,showConfirmButton:false});
					$('#contra_actual, #contra_new, #re_contra_new').val('');
				}
			});
        });
	
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal',function(e){ $('#form-registro').validator(); });
		$('#myModal1').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal1").empty(); });

			//checkbox para seleccionar todos los permisos
			$('#permisos_recepcion').change(function() {
			if ($(this).is(':checked')) {
				$('#p_0').prop('checked', true);
				$('#p_1').prop('checked', true);
				$('#p_2').prop('checked', true);
				$('#p_3').prop('checked', true);
				$('#p_4').prop('checked', true);
				$('#p_5').prop('checked', true);
				$('#p_6').prop('checked', true);
				for(var it=0; it<7; it++){
					$("input[name='h_permisos["+it+"]']").val(1);
				}
			} else {
				$('#p_0').prop('checked', false);
				$('#p_1').prop('checked', false);
				$('#p_2').prop('checked', false);
				$('#p_3').prop('checked', false);
				$('#p_4').prop('checked', false);
				$('#p_5').prop('checked', false);
				$('#p_6').prop('checked', false);
				for(var it=0; it<7; it++){
					$("input[name='h_permisos["+it+"]']").val(0);
				}
			}
		});

		$('#permisos_consultas').change(function() {
			if ($(this).is(':checked')) {
				$('#p_8').prop('checked', true);
				$('#p_9').prop('checked', true);
				$('#p_10').prop('checked', true);
				for(var it=8; it<11; it++){
					$("input[name='h_permisos["+it+"]']").val(1);
				}
			} else {
				$('#p_8').prop('checked', false);
				$('#p_9').prop('checked', false);
				$('#p_10').prop('checked', false);
				for(var it=8; it<11; it++){
					$("input[name='h_permisos["+it+"]']").val(0);
				}
			}
		});

		$('#permisos_hospital').change(function() {
			if ($(this).is(':checked')) {
				$('#p_12').prop('checked', true);
				$('#p_13').prop('checked', true);
				$('#p_14').prop('checked', true);
				for(var it=12; it<15; it++){
					$("input[name='h_permisos["+it+"]']").val(1);
				}
			} else {
				$('#p_12').prop('checked', false);
				$('#p_13').prop('checked', false);
				$('#p_14').prop('checked', false);
				for(var it=12; it<15; it++){
					$("input[name='h_permisos["+it+"]']").val(0);
				}
			}
		});

		$('#permisos_imagen').change(function() {
			if ($(this).is(':checked')) {
				$('#p_15').prop('checked', true);
				$('#p_16').prop('checked', true);
				$('#p_17').prop('checked', true);
				$('#p_18').prop('checked', true);
				$('#p_19').prop('checked', true);
				$('#p_20').prop('checked', true);
				for(var it=15; it<21; it++){
					$("input[name='h_permisos["+it+"]']").val(1);
				}
			} else {
				$('#p_15').prop('checked', false);
				$('#p_16').prop('checked', false);
				$('#p_17').prop('checked', false);
				$('#p_18').prop('checked', false);
				$('#p_19').prop('checked', false);
				$('#p_20').prop('checked', false);
				for(var it=15; it<21; it++){
					$("input[name='h_permisos["+it+"]']").val(0);
				}
			}
		});

		$('#permisos_laboratorio').change(function() {
			if ($(this).is(':checked')) {
				$('#p_22').prop('checked', true);
				$('#p_23').prop('checked', true);
				$('#p_24').prop('checked', true);
				$('#p_25').prop('checked', true);
				$('#p_26').prop('checked', true);
				for(var it=22; it<27; it++){
					$("input[name='h_permisos["+it+"]']").val(1);
				}
			} else {
				$('#p_22').prop('checked', false);
				$('#p_23').prop('checked', false);
				$('#p_24').prop('checked', false);
				$('#p_25').prop('checked', false);
				$('#p_26').prop('checked', false);
				for(var it=22; it<27; it++){
					$("input[name='h_permisos["+it+"]']").val(0);
				}
			}
		});

		$('#permisos_servicios').change(function() {
			if ($(this).is(':checked')) {
				$('#p_28').prop('checked', true);
				$('#p_29').prop('checked', true);
				$('#p_30').prop('checked', true);
				for(var it=28; it<31; it++){
					$("input[name='h_permisos["+it+"]']").val(1);
				}
			} else {
				$('#p_28').prop('checked', false);
				$('#p_29').prop('checked', false);
				$('#p_30').prop('checked', false);
				for(var it=28; it<31; it++){
					$("input[name='h_permisos["+it+"]']").val(0);
				}
			}
		});

		$('#permisos_farmacia').change(function() {
			if ($(this).is(':checked')) {
				$('#p_32').prop('checked', true);
				$('#p_33').prop('checked', true);
				$('#p_34').prop('checked', true);
				$('#p_35').prop('checked', true);
				$('#p_36').prop('checked', true);
				$('#p_50').prop('checked', true);
				$('#p_49').prop('checked', true);
				$('#p_51').prop('checked', true);
				$("input[name='h_permisos[50]']").val(1);
				$("input[name='h_permisos[49]']").val(1);
				$("input[name='h_permisos[51]']").val(1);
				for(var it=32; it<37; it++){
					$("input[name='h_permisos["+it+"]']").val(1);
				}
			} else {
				$('#p_32').prop('checked', false);
				$('#p_33').prop('checked', false);
				$('#p_34').prop('checked', false);
				$('#p_35').prop('checked', false);
				$('#p_36').prop('checked', false);
				$('#p_50').prop('checked', false);
				$('#p_49').prop('checked', false);
				$('#p_51').prop('checked', false);
				$("input[name='h_permisos[50]']").val(0);
				$("input[name='h_permisos[49]']").val(0);
				$("input[name='h_permisos[51]']").val(0);
				for(var it=32; it<37; it++){
					$("input[name='h_permisos["+it+"]']").val(0);
				}
			}
		});

		$('#permisos_administracion').change(function() {
			if ($(this).is(':checked')) {
				$('#p_38').prop('checked', true);
				$('#p_39').prop('checked', true);
				$('#p_40').prop('checked', true);
				$('#p_41').prop('checked', true);
				$('#p_42').prop('checked', true);
				$('#p_43').prop('checked', true);
				$('#p_44').prop('checked', true);
				$('#p_45').prop('checked', true);
				$('#p_48').prop('checked', true);
				$('#p_46').prop('checked', true);
				$('#p_47').prop('checked', true);
				$('#p_7').prop('checked', true);
				$('#p_11').prop('checked', true);
				$('#p_21').prop('checked', true);
				$('#p_27').prop('checked', true);
				$('#p_31').prop('checked', true);
				$('#p_37').prop('checked', true);
				$("input[name='h_permisos[7]']").val(1);
				$("input[name='h_permisos[11]']").val(1);
				$("input[name='h_permisos[21]']").val(1);
				$("input[name='h_permisos[27]']").val(1);
				$("input[name='h_permisos[31]']").val(1);
				$("input[name='h_permisos[37]']").val(1);
				for(var it=38; it<49; it++){
					$("input[name='h_permisos["+it+"]']").val(1);
				}
			} else {
				$('#p_38').prop('checked', false);
				$('#p_39').prop('checked', false);
				$('#p_40').prop('checked', false);
				$('#p_41').prop('checked', false);
				$('#p_42').prop('checked', false);
				$('#p_43').prop('checked', false);
				$('#p_44').prop('checked', false);
				$('#p_45').prop('checked', false);
				$('#p_48').prop('checked', false);
				$('#p_46').prop('checked', false);
				$('#p_47').prop('checked', false);
				$('#p_7').prop('checked', false);
				$('#p_11').prop('checked', false);
				$('#p_21').prop('checked', false);
				$('#p_27').prop('checked', false);
				$('#p_31').prop('checked', false);
				$('#p_37').prop('checked', false);
				$("input[name='h_permisos[7]']").val(0);
				$("input[name='h_permisos[11]']").val(0);
				$("input[name='h_permisos[21]']").val(0);
				$("input[name='h_permisos[27]']").val(0);
				$("input[name='h_permisos[31]']").val(0);
				$("input[name='h_permisos[37]']").val(0);
				for(var it=38; it<49; it++){
					$("input[name='h_permisos["+it+"]']").val(0);
				}
			}
		});
		//
	}});
}

function tipo_acceso_su(id_sa, valor){
	var datos = {id:id_sa, valor:valor}
	$.post('usuarios/files-serverside/accesoSucursal.php',datos).done(function(data){
		if (data==1){ $('#clickmeSu').click();
			swal({title:"",type:"success",text:"El acceso se ha atualizado!",timer:1500,showConfirmButton:false});
		}else{alert(data);}
	});
}
function eliminar_sucu(id_su, nombre_suc){//alert(tipo_doc);
	swal({
	  title: "Desasignar sucursal", text:"¿ESTÁ SEGURO QUE DESEA DESASIGNAR LA SUCURSAL "+nombre_suc+" DEL USUARIO?", type: "warning",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Desasignar", cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		var datos = {id:id_su}
		$.post('usuarios/files-serverside/desasignarSucursal.php',datos).done(function(data){
			if (data==1){ $('#clickmeSu').click();
				swal({title:"",type:"",text:"La sucursal se desasignó del usuario!",timer:1800,showConfirmButton:false});
			}else{alert(data);}
		});
	});
}
function e_principal(estatus,id_eu,aleatorio){
	var datos = { estatus:estatus, id_eu:id_eu,aleatorio:aleatorio }
	$.post('usuarios/files-serverside/empresaPrincipal.php',datos).done(function(data){
		if(data==1){ $('#clickmeSu').click(); }else{console.log(data);}
	});
}
function cerrar_nota(){
	$('.no_nota').removeClass('hidden'); $('.si_nota,.si_receta,.si_forma_i').addClass('hidden'); window.setTimeout(function(){$('#notas-tab').click();},200);
	$('#nombreNM, #inserta_algo').val(''); tinymce.activeEditor.setContent(''); $('#btn_registro_nota').show(); $('#btn_update_nota').hide();
}
function cerrar_receta(){
	$('.no_receta').removeClass('hidden'); $('.si_receta,.si_nota,.si_forma_i').addClass('hidden'); window.setTimeout(function(){$('#recetas-tab').click();},200);
	$('#nombreRM, #inserta_algo1').val(''); tinymce.activeEditor.setContent(''); $('#btn_registro_receta').show(); $('#btn_update_receta').hide();
}
function cerrar_forma_i(){
	$('.no_forma_i').removeClass('hidden'); $('.si_receta,.si_nota,.si_forma_i').addClass('hidden'); window.setTimeout(function(){$('#formati-tab').click();},200);
	$('#nombreFI, #inserta_algoFI').val(''); tinymce.activeEditor.setContent(''); $('#btn_registro_formato_i').show(); $('#btn_update_formato_i').hide();
	$("#formato_si").attr('disabled', false); $("#formato_si").val(''); $("#formato_si").trigger("chosen:updated");
}
function guardarNota(){
	$('#miDiagnostico').val(tinymce.activeEditor.getContent());
	if($('#nombreNM').val()!='' & $('#miDiagnostico').val()!=''){
		var datos={
			input:tinyMCE.get('input').getContent(),nombreNM:$('#nombreNM').val(),idusuarioNM:$('#id_user').val(),a:$('#idUsuarioN').val(),
			temporal:$('#temporal_s').val()
		}
		$.post('consultas/files-serverside/addNota.php',datos).done(function(data){
			if (data==1){ 
				cerrar_nota(); $('#clickmeNM').click();
				swal({
				  title: "", type: "success", text: "La nota médica se ha creado correctamente.", timer: 1800, showConfirmButton: false
				}); return;
			}else{alert(data);}
		});
	}else{}
}
function guardarReceta(){
	$('#miDiagnostico1').val(tinymce.activeEditor.getContent());
	if($('#nombreRM').val()!='' & $('#miDiagnostico1').val()!=''){
		var datos={
			input:tinyMCE.get('input1').getContent(),nombreNM:$('#nombreRM').val(),idusuarioNM:$('#id_user').val(),a:$('#idUsuarioN').val(),
			temporal:$('#temporal_s').val()
		}
		$.post('consultas/files-serverside/addReceta.php',datos).done(function(data){
			if (data==1){ 
				cerrar_receta(); $('#clickmeRM').click();
				swal({ title: "", type: "success", text: "La receta médica se ha creado correctamente.", timer: 1800, showConfirmButton: false }); return;
			}else{alert(data);}
		});
	}else{}
}
function guardarFormatoI(){
	$('#miDiagnosticoFI').val(tinymce.activeEditor.getContent());
	if($('#nombreFI').val()!='' & $('#miDiagnosticoFI').val()!='' & $('#formato_si').val()!=''){
		var datos={
			input:tinyMCE.get('inputFI').getContent(),nombreFI:$('#nombreFI').val(),idusuarioFI:$('#id_user').val(),a:$('#formato_si').val(),
			temporal:$('#temporal_s').val()
		}
		$.post('consultas/files-serverside/addFormatoI.php',datos).done(function(data){
			if (data==1){ 
				cerrar_forma_i(); $('#clickmeFI').click();
				swal({ title: "", type: "success", text: "El formato se ha creado correctamente.", timer: 1800, showConfirmButton: false }); return;
			}else{alert(data);}
		});
	}else{alert()}
}
function verNota(id){
	$('.si_nota').removeClass('hidden'); $('.no_nota').addClass('hidden'); window.setTimeout(function(){$('#mi_nota-tab').click();},200);
	$('#btn_update_nota').show(); $('#btn_registro_nota').hide(); $('#id_nmed').val(id);
	var datos = { id:id }
	$.post('consultas/files-serverside/ficha_receta.php',datos).done(function(data){
		var datos = data.split('{];[}'); tinymce.get('input').setContent(datos[1]); $('#nombreNM').val(datos[0]);
	});
}
function verReceta(id){
	$('.si_receta').removeClass('hidden'); $('.no_receta').addClass('hidden'); window.setTimeout(function(){$('#mi_receta-tab').click();},200);
	$('#btn_update_receta').show(); $('#btn_registro_receta').hide(); $('#id_rmed').val(id);
	var datos = { id:id }
	$.post('consultas/files-serverside/ficha_nota.php',datos).done(function(data){
		var datos = data.split('{];[}'); tinymce.get('input1').setContent(datos[1]); $('#nombreRM').val(datos[0]);
	});
}
function verFormatosI(id){
	$('.si_forma_i').removeClass('hidden'); $('.no_forma_i').addClass('hidden'); window.setTimeout(function(){$('#mi_format_i-tab').click();},200);
	$('#btn_update_formato_i').show(); $('#btn_registro_formato_i').hide(); $('#id_formai').val(id);
	var datos = { id:id }
	$.post('consultas/files-serverside/ficha_estudio_i.php',datos).done(function(data){
		var datos = data.split('{];[}'); tinymce.get('inputFI').setContent(datos[1]); $('#nombreFI').val(datos[0]);
		$("#formato_si").val(datos[2]); $("#formato_si").prop('disabled','disabled'); $("#formato_si").trigger("chosen:updated");
	});
}
function updateNota(){
	$('#miDiagnostico').val(tinymce.activeEditor.getContent());
	if($('#nombreNM').val()!='' & $('#miDiagnostico').val()!=''){
		var datos = { input:tinyMCE.get('input').getContent(),nombreNM:$('#nombreNM').val(),idNM:$('#id_nmed').val() }
		$.post('consultas/files-serverside/updateNota.php',datos).done(function(data){
			if (data==1){ 
				cerrar_nota(); $('#clickmeNM').click();
				swal({ title: "", type: "success", text: "La nota médica se ha actualizado correctamente.", timer: 1800, showConfirmButton: false }); return;
			}else{alert(data);}
		});
	}else{}
}
function updateReceta(){
	$('#miDiagnostico1').val(tinymce.activeEditor.getContent());
	if($('#nombreRM').val()!='' & $('#miDiagnostico1').val()!=''){
		var datos = { input:tinyMCE.get('input1').getContent(),nombreNM:$('#nombreRM').val(),idNM:$('#id_rmed').val() }		
		$.post('consultas/files-serverside/updateNota.php',datos).done(function(data){
			if (data==1){ 
				cerrar_receta(); $('#clickmeRM').click();
				swal({ title: "", type: "success", text: "La receta médica se ha actualizado correctamente.", timer: 1800, showConfirmButton: false }); return;
			}else{alert(data);}
		});
	}else{}
}
function updateFormaI(){
	$('#miDiagnosticoFI').val(tinymce.activeEditor.getContent());
	if($('#nombreFI').val()!='' & $('#miDiagnosticoFI').val()!=''){
		var datos = { input:tinyMCE.get('inputFI').getContent(),nombreFI:$('#nombreFI').val(),idFI:$('#id_formai').val() }
		$.post('consultas/files-serverside/updateFormatoI.php',datos).done(function(data){
			if (data==1){ 
				cerrar_forma_i(); $('#clickmeFI').click();
				swal({ title: "", type: "success", text: "El formato se ha actualizado correctamente.", timer: 1800, showConfirmButton: false }); return;
			}else{alert(data);}
		});
	}else{}
}
function ver_docu(id_doc,exte,time){
	$('.no_document').addClass('hidden'); $('.si_document').removeClass('hidden');
	if(!$('#btn_update_u').hasClass('hidden')){$('#btn_update_u').addClass('hidden');}
	var widi = $('#myModal').width()*0.6;
	if(exte != 'pdf' & exte != 'PDF'){
		x='usuarios/documentos/files/'+id_doc+'.'+exte+'?'+time;
		$('#mi_documento').html('<img src='+x+' style="max-width:'+widi+'px; border:3px solid white; border-radius:4px; background-color:rgba(255, 255, 255, 1);">');
	}else{
		x='usuarios/documentos/files/'+id_doc+'.pdf'; 
		var h=$('#referencia').height()-$('#nav-header').height()-$('#my_footer').height();
		$('#mi_documento').html('<a class="media" href=""> </a>'); $('a.media').media({width:790, height:h-136, src:x});	
	}
}
function eliminar_docu(id_doc, ext_doc, nombre_doc){//alert(tipo_doc);
	swal({
	  title: "Eliminar documento", text: "¿ESTÁ SEGURO QUE DESEA ELIMINAR EL DOCUMENTO "+nombre_doc+"?", type: "warning",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
	},
	function(){
		var datos = {id:id_doc, tipo:ext_doc}
		$.post('usuarios/files-serverside/eliminarDocumento.php',datos).done(function(data){
			if (data==1){ $('#clickmeDocs').click();
				swal({title:"",type:"",text:"El documento se ha eliminado!",timer:1800,showConfirmButton:false});
			}else{alert(data);}
		});
	});
}
function cerrar_ver_doc(){ $('.no_document').removeClass('hidden'); $('.si_document').addClass('hidden'); }
function editar_concepto(idC){ $('#mi_id_to').val(idC);
	var datos = {id:idC}
	$.post('usuarios/files-serverside/datos_cto.php',datos).done(function(data){
		$('#btn_add_concepto').addClass('hidden'); $('#btn_update_concepto,#btn_del_concepto').removeClass('hidden');
		$('#panel_concepto').removeClass('hidden'); $('#btn_cancel_add_concepto').text('Cerrar');
		var dato = data.split('{}*');
		$('#nombre_to').val(dato[0]); $('#area_to').val(dato[1]); $('#precio_n').val(dato[2]); $('#precio_u').val(dato[3]);
		$('#precio_m').val(dato[4]); $('#precio_mu').val(dato[5]); $('#precio_h').val(dato[7]); $('#precio_costoproduccion').val(dato[8]); $('#honorario_c').val(dato[9]); $('#honorario_cu').val(dato[10]); $('#linea_to').val(dato[11]); $('#btn_update_concepto').removeClass('disabled');
		if(dato[6]>1){ $('#btn_del_concepto').addClass('hidden'); $('#btn_del_concepto').addClass('disabled');}
		else{ $('#btn_del_concepto').removeClass('hidden'); $('#btn_del_concepto').removeClass('disabled'); }

		select2ini("#sat", "sat.php", "INGRESA LA CLAVE DE LA CUENTA DEL SAT ");
			$("#sat").html("<option value='"+dato[12]+"' selected>"+dato[13]+"</option>");
			$("#sat").select2("data", {
				id: dato[12],
				text: dato[13]
			});
			$("#sat").trigger("change");

	});
}

function siempre(la,lo){
	var i=0;
	$('#tab_mi_dir').click(function(e) {
	  if(i%2==0){i++;
	  var map = new google.maps.Map(document.getElementById('map'), {
		center: new google.maps.LatLng(la, lo), zoom: 16, scrollwheel: false //Cuautla :3
	  });
	  marker = new google.maps.Marker({
		map: map, draggable: true, animation: google.maps.Animation.DROP, position: new google.maps.LatLng(la, lo)
	  });

	  $('#p_latitud').text(redondear(la,4));$('#p_latitud_s').val(la);
	  $('#p_longitud').text(redondear(lo,4));$('#p_longitud_s').val(lo);
	  marker.addListener('dragend', function(){
		  map.panTo(marker.getPosition());
		  var markerLatLng = marker.getPosition();
		  $('#p_latitud').text(redondear(markerLatLng.lat(),4)); $('#p_latitud_s').val(markerLatLng.lat());
		  $('#p_longitud').text(redondear(markerLatLng.lng(),4)); $('#p_longitud_s').val(markerLatLng.lng());
	  });
	  google.maps.event.addListener(marker, 'click', function(){ });
	  
	  var geocoder = new google.maps.Geocoder();
	  $('.mi_dir').keyup(function(e) { 
		  var address = $('#estadoP').find(':selected').text()+' '+$('#municipioP').find(':selected').text()+' '+$('#coloniaP').find(':selected').text()+' '+document.getElementById('calleP').value;

		  geocoder.geocode({'address': address}, function(results, status) { 
			if (status === google.maps.GeocoderStatus.OK) {
			  map.setCenter(results[0].geometry.location);

			  var markerLatLng = results[0].geometry.location;
			  $('#p_latitud').text(redondear(markerLatLng.lat(),4)); $('#p_latitud_s').val(markerLatLng.lat());
			  $('#p_longitud').text(redondear(markerLatLng.lng(),4)); $('#p_longitud_s').val(markerLatLng.lng());
			  
			  marker.setPosition(results[0].geometry.location);
			} //else { alert('Geocode was not successful for the following reason: ' + status); }
		  });
	  });
	  $('.mi_dir').change(function(e) { 
		  var address = $('#estadoP').find(':selected').text()+' '+$('#municipioP').find(':selected').text()+' '+$('#coloniaP').find(':selected').text()+' '+document.getElementById('calleP').value;

		  geocoder.geocode({'address': address}, function(results, status) { 
			if (status === google.maps.GeocoderStatus.OK) {
			  map.setCenter(results[0].geometry.location);

			  var markerLatLng = results[0].geometry.location;
			  $('#p_latitud').text(redondear(markerLatLng.lat(),4)); $('#p_latitud_s').val(markerLatLng.lat());
			  $('#p_longitud').text(redondear(markerLatLng.lng(),4)); $('#p_longitud_s').val(markerLatLng.lng());
			  
			  marker.setPosition(results[0].geometry.location);
			} //else { alert('Geocode was not successful for the following reason: ' + status); }
		  });
	  });
	  }
	});
}

function foto_perfil(idD,aleat){
	swal({
	  title:"",text:"¿Quieres actualizar la foto de perfil a esta imagen?",type:"warning",showCancelButton:true,
	  confirmButtonColor:"#DD6B55",confirmButtonText:"Actualizar",closeOnConfirm:false,cancelButtonText:"Cancelar"
	},
	function(){
		var datos = {id:idD, tempo:aleat}
		$.post('usuarios/files-serverside/foto_perfil.php',datos).done(function(data){ $('#clickmeDocs').click();
			if(data==1){swal({title:"",type:"",text:"La foto de perfil se ha actualizado",timer:1800,showConfirmButton:false});} else{alert(data);}
		});
	});
}
function firma(idD,aleat){
	swal({
	  title:"",text:"¿Quieres actualizar la firma digital del usuario a esta imagen?",type:"warning",showCancelButton:true,
	  confirmButtonColor:"#DD6B55",confirmButtonText:"Actualizar",closeOnConfirm:false,cancelButtonText:"Cancelar"
	},
	function(){
		var datos = {id:idD, tempo:aleat}
		$.post('usuarios/files-serverside/firma.php',datos).done(function(data){ $('#clickmeDocs').click();
			if(data==1){swal({title:"",type:"",text:"La firma digital se ha actualizado",timer:1800,showConfirmButton:false});} else{alert(data);}
		});
	});
}


function select2ini(donde, url, ph){
    $(donde).select2({
        language: "es",
        width: "off",
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


function initMap() { }
function insertAtCaret(text) { tinymce.get("input").execCommand('mceInsertContent', false, text); $('#inserta_algo').val(''); }
function insertAtCaret1(text) { tinymce.get("input1").execCommand('mceInsertContent', false, text); $('#inserta_algo1').val(''); }
function insertAtCaret2(text) { tinymce.get("inputFI").execCommand('mceInsertContent', false, text); $('#inserta_algo2').val(''); }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4cHSkoaQwTQjx31Y3xFf3kkSkD28X_Rs&callback=initMap"
	async defer>
</script>
