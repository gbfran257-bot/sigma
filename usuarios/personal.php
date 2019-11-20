<?php require_once('../Connections/horizonte.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) { session_start(); }

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){ $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']); }

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) { header("Location: $logoutGoTo"); exit; }
}
?>
<?php
if (!isset($_SESSION)) { session_start(); }
$MM_authorizedUsers = "1,2,3,4,5,6,8";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { $isValid = true; } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { $isValid = true; } 
    if (($strUsers == "") && false) { $isValid = true; } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT id_u, nombre_u, apaterno_u, amaterno_u, idSucursal_u, usuario_u, idDepartamento_u, idPuesto_u, acceso_u, sexo_u, foto_u, nombreFoto_u FROM usuarios WHERE usuario_u = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

if($row_usuario['acceso_u']==6){
	//header("Location: diagnostico/laboratorio/listado.php");
}

mysql_select_db($database_horizonte, $horizonte);
$query_nombreSucursalUsuario = sprintf("SELECT nombre_su FROM sucursales WHERE clave_su = %s", GetSQLValueString($row_usuario['idSucursal_u'], "text"));
$nombreSucursalUsuario = mysql_query($query_nombreSucursalUsuario, $horizonte) or die(mysql_error());
$row_nombreSucursalUsuario = mysql_fetch_assoc($nombreSucursalUsuario);
$totalRows_nombreSucursalUsuario = mysql_num_rows($nombreSucursalUsuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombreDepartamentoUsuario = sprintf("SELECT nombre_d FROM departamentos WHERE id_d = %s", GetSQLValueString($row_usuario['idDepartamento_u'], "int"));
$nombreDepartamentoUsuario = mysql_query($query_nombreDepartamentoUsuario, $horizonte) or die(mysql_error());
$row_nombreDepartamentoUsuario = mysql_fetch_assoc($nombreDepartamentoUsuario);
$totalRows_nombreDepartamentoUsuario = mysql_num_rows($nombreDepartamentoUsuario);

?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../imagenes/favicon.ico">
<meta charset="utf-8">
<title>PERSONAL</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../css/usuarios.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.11.4/flick/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../DataTables-1.10.2/media/css/jquery.dataTables.css">

<script src="../jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.11.4/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.11.4/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../jquery-ui-1.11.4/jquery-ui.js"></script>
<script src="../DataTables-1.10.2/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.2/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/calcula_edad.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../jquery-ui-1.11.4/external/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../funciones/js/redondea.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../funciones/js/stdlib.js"></script>
<script type="text/javascript" src="imagenes/ajaxupload.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script language="javascript">
//para las tooltips
$( document ).tooltip({
	position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ) {$( this ).css( position );} }
});
$(document).ready(function() {
	//inicializaciones			
	var div_menu_lat = $('#menu_lat');
	var iconos_menu_lat = $('#menu_lat img');
		
	iconos_menu_lat.css('width','70%').css('height','84%').css('background-color','rgba(255,255,255,0.9)').css('border-radius','6px');
	iconos_menu_lat.hover(function(e) { $(this).css('cursor','pointer'); });	
								
});
</script>

<script>
$(document).ready(function(e) {
    var miUsuario = $('.miUsuario'),
	misDatosUsuario = $('#misDatosUsuario');
	misDatosUsuario.hide();
	var dj = 1;
	miUsuario.click(
		function(e) {
			dj++;
			if(dj%2==0){ misDatosUsuario.stop().show('explode','slow');
			}else{ misDatosUsuario.stop().hide('explode','slow'); }
    	}
	);
	
	var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75);
	var cy = $('#header table').height() -8;

	misDatosUsuario.css('right',cx).css('top',cy);
	cargaFicha();
	
	//esto va despues de la función que carga la ficha del paciente
	$( window ).resize(function(e) {
        var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75);
		var cy = $('#header table').height();
	
		misDatosUsuario.css('right',cx).css('top',cy);
		
		var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 160;
		var wi = $('#referencia').width() * 0.96;
		$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
		$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
		
		$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-40);
		$('.tabs').css('width',120);
    });
	
});
function cargaFicha(){
$(document).ready(function(e) {
    $("#dialog-confirmarNuevoPaciente").load('htmls/usuario.php #fichaUsuario', function( response, status, xhr ){
		if ( status == "success" ) { 
			$('#formGenerales').validate({ ignore: 'hidden', focusCleanup: true,
				rules:{
					claveUsuario:{ required:true, remote:{ url: 'files-serverside/checkClaveUsuario.php?idU='+$('#idPacienteN').val(), type: "post", data: { clave:function(){ return $('#claveUsuario').val(); } } }, minlength: 4 },
					username:{ required:true, remote:{ url: 'files-serverside/checkUserUsuario.php?idU='+$('#idPacienteN').val(), type: "post", data: { user:function(){ return $('#username').val(); } } }, minlength: 4 }
				},
				messages:{
					claveUsuario:{ required: 'SE DEBE DE INGRESAR EL IDENTIFICADOR DEL USUARIO.', remote:'ESTE IDENTIFICADOR YA ESTA EN USO, FAVOR DE INTENTAR CON OTRO', minlength:'EL IDENTIFICADOR CONSTA DE 4 CARACTERES' },
					username:{ required: 'SE DEBE DE INGRESAR EL NOMBRE DE USUARIO.', remote:'ESTE NOMBRE DE USUARIO YA ESTA EN USO, FAVOR DE INTENTAR CON OTRO', minlength:'EL NOMBRE DE USUARIO CONSTA DE MÍNIMO 4 CARACTERES' }
				}
			});
			
			var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 160;
			var wi = $('#referencia').width() * 0.96;
			$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
			$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
			
			window.setTimeout(function(){
				$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() + 20).css('width',$('#dialog-confirmarNuevoPaciente').width()-20);
			},100);
			
			$('.tabs').css('width',120);
			
			//inicializamos el formulario de usuario
			$( "#spinner" ).timespinner();
			var current = $( "#spinner" ).timespinner( "value" );
			Globalize.culture( "de-DE" );
			$( "#spinner" ).timespinner( "value", current );
			$('#fnacP').datepicker({
				changeMonth: true, changeMonth: true, nextText: "Siguiente", prevText: "Anterior", showAnim : "slideDown", changeYear: true, maxDate: +0, minDate: -43800, dateFormat: "dd/mm/yy",
				dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ], dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
				monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septimbre", "Octubre", "Noviembre", "Diciembre" ],
				monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"] //"onSelect": function(date) { $('#edadP').val(calcular_edad(date)); }
			}).css('text-align','center');
					
			$("#sexoP").load('files-serverside/genera_sexos.php');
			$("#sucursalP").load('files-serverside/genera_sucursales.php?idS='+$('#sucursalU').val());
			$("#tsanguineoP").load('files-serverside/genera_tsangre.php');
			$("#especialidadU").load('files-serverside/genera_especialidades.php');
			
			$("#estadoP").load('files-serverside/genera_estados.php', function( response, status, xhr ) {
				  if ( status == "success" ) { 
						$("#estadoP").change(function(event){
							var id = $("#estadoP").find(':selected').text();//alert(id);
							$("#municipioP").load('files-serverside/genera_municipios.php?id='+escape(id), function( response, status, xhr ) {
								  if ( status == "success" ) { 
										if ($("#estadoP").val()==''){
											var id1x = $("#estadoP").find(':selected').text();
											var idx = $("#municipioP").find(':selected').text();
											var id3 = $("#coloniaP").find(':selected').text();
											$("#coloniaP").load('files-serverside/genera_colonias.php?idM='+escape(idx)+'&idE='+escape(id1x));
											$("#cpP").load('files-serverside/genera_cp.php?idC='+escape(id3)+'&idE='+escape(id1x)+'&idM='+escape(idx));
										}
								  }
							});
						});
				  }
			});
			
			$("#municipioP").change(function(event){
				var id = $("#municipioP").find(':selected').text();var id1 = $("#estadoP").find(':selected').text();
				$("#coloniaP").load('files-serverside/genera_colonias.php?idM='+escape(id)+'&idE='+escape(id1));
				if ($("#municipioP").val()==''){
					var id1 = $("#estadoP").find(':selected').text();
					var id2 = $("#municipioP").find(':selected').text();
					var id3 = $("#coloniaP").find(':selected').text();
					$("#cpP").load('files-serverside/genera_cp.php?idE='+escape(id1)+'&idM='+escape(id2)+'&idC='+escape(id3));
				}
			});
			$("#coloniaP").change(function(event){
				var idC = $("#coloniaP").find(':selected').text();var idE = $("#estadoP").find(':selected').text();var idM = $("#municipioP").find(':selected').text();
				$("#cpP").load('files-serverside/genera_cp.php?idC='+escape(idC)+'&idE='+escape(idE)+'&idM='+escape(idM));
			});
			
			$('#ocupacionP').keyup(function(e) {
				var y=$(this).val();
				var b="files-serverside/genera_ocupaciones.php?ocupacion="+y;
				$( "#ocupacionP" ).autocomplete({
					source: b,
					minLength: 2
				}); 
			});
			
			$("#departamentoU").load('files-serverside/genera_depto.php', function( response, status, xhr ) {
			  if ( status == "success" ) { 
					$("#departamentoU").change(function(event){
						var id = $("#departamentoU").val();//alert(id);
						$("#areaU").load('files-serverside/genera_areas.php?id='+escape(id), function( response, status, xhr ) {
						  if ( status == "success" ) { 
								if ($("#departamentoU").val()==''){
									var id1x = $("#departamentoU").find(':selected').text();
									$("#areaU").load('files-serverside/genera_areas.php?id='+escape(idx));
								}
						  }
						});	
					});
			  }
			});
			
			$("#escolaridadP").load('files-serverside/genera_escolaridades.php');
			$("#puestoU").load('files-serverside/genera_puestos.php');
			$("#discapacidadP").load('files-serverside/genera_discapacidades.php');
			//fin de las inicializaciones del formulario de usuarios
			
			$('#usuarioForaneo').click(function(e) {
				if($(this).prop('checked')==true){$('#usuarioF').val(1);}else{$('#usuarioF').val(0);}
			});
			$('#horarioDe').timepicker({
				currentText: 'Ahora',
				closeText: 'Ok',
				timeOnlyTitle: 'Escoge la Hora',
				timeText: 'Hora',
				hourText: 'Horas',
				minuteText: 'Minutos'
			});
			$('#horarioDe').css('text-align','center');
			$('#horarioA').timepicker({
				currentText: 'Ahora',
				closeText: 'Ok',
				timeOnlyTitle: 'Escoge la Hora',
				timeText: 'Hora',
				hourText: 'Horas',
				minuteText: 'Minutos'
			});
			$('#horarioA').css('text-align','center');
				
			var miMenu=$('#miMenu');
			miMenu.hide();
			$('#verMenu').click(function(e) {
				verMenu();
			});
			
			$('#profesionUsuario').keyup(function(e) {
				var x=$(this).val();
				var a="files-serverside/catProfesiones.php?profesion="+x;
			   $('#profesionUsuario').autocomplete({
					source: a,
					minLength: 2
				}); 
			});//Fin de las inicializaciones de los campos de la ficha del usuario
			
			var cuadrado = 20;
			$('button').css('min-width',cuadrado).css('min-height',cuadrado);
			$('#bPromotor').button({ icons: { primary: "ui-icon-search" }, text: false });
			$('#bPromotor').click(function(e) {
				$("#dialog-buscaMedico").load("htmls/dialogBuscarPromotor.php #buscarPromotor", function( response, status, xhr ) { 
				if ( status == "success" ) {
					var he3 = $('#referencia').height() - 100; var wi3 = $('#referencia').width() * 0.98;
					$('#dialog-buscaMedico').dialog({ 
						title: 'BUSCAR EL PROMOTOR PARA EL MÉDICO', modal: true, autoOpen: true, closeText: '', width: wi3, 
						height: he3, closeOnEscape: false, dialogClass: 'no-close',
						buttons: {
						"Aceptar": function() {
						   if($('.selected2').length >0){$('#errorSeleccionMédico').hide();
						    $('#idPromotor').val($('#idPromotorT').val());
							$('#promotor').val($('#promotorT').val()); 
							$('#dialog-buscaMedico').dialog('close');
						   }else{
						   	$('#errorSeleccionMédico').hide().show('shake'); 
						   }
						},
						"Cancelar": function() { $('#dialog-buscaMedico').dialog('close'); }
					  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscaMedico').empty(); },
					  open:function( event, ui ){ var oTableBMC1;
						oTableBMC1 = $('#dataTableBMConsulta').dataTable({
							"bJQueryUI": false, "bRetrieve": true, ordering: false,
							"sScrollY": $('#dialog-buscaMedico').height()-145, "bStateSave": false, "bInfo": true, 
							"bFilter": true, "aaSorting": [[1, "asc"]],
							"aoColumns": [
								{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
							], "iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
							"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
							"sAjaxSource": "datatable-serverside/buscar_promotor.php", 
							"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
							"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
							"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
							"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", "sSearch": "" }
						});//fin datatable
						
						$(".pieTablaBMCo input").keyup( function () { /* Filter on the column (the index) of this element */
							oTableBMC1.fnFilter( this.value, $(".pieTablaBMCo input").index(this) );
						});
						 	
						$('.filtroBMC input').attr("placeholder", "BUSQUE UN USUARIO PROMOTOR AQUÍ, Y DELE CLIC PARA SEECCIONARLO...").addClass('placeHolder');
						$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
						$('.filtroBMC input').css('width',($('#dialog-buscaMedico').width() * 1) ); $('.filtroBMC').css('left',-16);
						$("div.toolbarBMC").css('white-space','nowrap').css('border','1px none red').css('padding','10px');
						
						var tableBM = $('#dataTableBMConsulta').DataTable();
						$('#dataTableBMConsulta tbody').on('click','tr',function(){
							if($(this).hasClass('selected2')){$(this).removeClass('selected2');}
							else{
								tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
								$('#errorSeleccionMédico').hide();
							}
						});
						
						$('#dataTableBMConsulta tbody').on( 'click', 'tr', function () {
							var nTdsBMC = $('td', this); var idConsulta = $(nTdsBMC[0]).html().split('"'); //alert(idConsulta[1]);
							$('#idPromotorT').val(idConsulta[1]);
							var nMedico = $(nTdsBMC[0]).text()+' '+$(nTdsBMC[1]).text()+' '+$(nTdsBMC[2]).text();
							$('#promotorT').val(nMedico);
						}); //con la clave del médico sacamos su id
					  }
					});
				}});
			});
			
			$('#addConvenio').button({ icons: { primary: "ui-icon-plusthick" }, text: false });
			
			$('form').submit(function(event) { event.preventDefault(); });
			$('#bPromotor').click(function(event) { event.preventDefault(); });
			$('#upload').button({ icons: { primary: "ui-icon-image" }, text: true, label: "Agregar fotografía" });
			
			$('#comisionU').keyup(function(e) {
				if($(this).val()>100){$('#comisionU').val(100);}
				if($(this).val()<0){$('#comisionU').val(0);}
			});
			
			$('#claveUsuario').keyup(function(e) {
				var x=$(this).val();
				if( x.length>3 & x.length<5 ){
					var claveUsuario1 = $('#claveUsuario').val();
					var datoU ={ claveUsuario1:claveUsuario1}
					$.post('files-serverside/disponibleClaveUsuario.php',datoU).done(function( data ) {
						if (data == 1){
							$('#textoClaveUsuarioDisponible').text('Disponible');$('#textoClaveUsuarioDisponible').addClass('textoAceptable');
							$('#textoClaveUsuarioDisponible').removeClass('textoNoAceptable');
							$('#textoClaveUsuarioDisponible').removeClass('textoAlerta');
							$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-alert');
							$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-closethick');
							$('#iconoClaveUsuario').addClass('ui-icon ui-icon-check');
						}else{
							$('#textoClaveUsuarioDisponible').text('No Disponible');$('#textoClaveUsuarioDisponible').addClass('textoNoAceptable');
							$('#textoClaveUsuarioDisponible').removeClass('textoAceptable');
							$('#textoClaveUsuarioDisponible').removeClass('textoAlerta');
							$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-alert');
							$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-check');
							$('#iconoClaveUsuario').addClass('ui-icon ui-icon-closethick');
						}
					});
		
				}else{
					$('#textoClaveUsuarioDisponible').text('Muy Corto');$('#textoClaveUsuarioDisponible').addClass('textoAlerta');
					$('#iconoClaveUsuario').addClass('ui-icon ui-icon-alert');$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-closethick');
					$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-check');
				}
				if(x.length<=3){ 
					$('#textoClaveUsuarioDisponible').removeClass('textoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoNoAceptable');
					$('#iconoClaveUsuario').addClass('ui-icon ui-icon-alert');
				}
				if(x.length==0){ $('#textoClaveUsuarioDisponible').text('Vacío');}
			});
			$('#username').keyup(function(e) {
				var x=$(this).val();
				if( x.length>3 & x.length<9 ){
					var userName = $('#username').val();
					var datoUN ={userName:userName}
					$.post('files-serverside/disponibleUserName.php',datoUN).done(function( data1 ) {
						if (data1 == 1){
							$('#textoUsuarioDisponible').text('Disponible');$('#textoUsuarioDisponible').addClass('textoAceptable');
							$('#textoUsuarioDisponible').removeClass('textoNoAceptable');
							$('#textoUsuarioDisponible').removeClass('textoAlerta');
							$('#iconoUsuario').removeClass('ui-icon ui-icon-alert');
							$('#iconoUsuario').removeClass('ui-icon ui-icon-closethick');
							$('#iconoUsuario').addClass('ui-icon ui-icon-check');
						}else{
							$('#textoUsuarioDisponible').text('No Disponible');$('#textoUsuarioDisponible').addClass('textoNoAceptable');
							$('#textoUsuarioDisponible').removeClass('textoAceptable');
							$('#textoUsuarioDisponible').removeClass('textoAlerta');
							$('#iconoUsuario').removeClass('ui-icon ui-icon-alert');
							$('#iconoUsuario').removeClass('ui-icon ui-icon-check');
							$('#iconoUsuario').addClass('ui-icon ui-icon-closethick');
						}
					});
				}else{
					$('#textoUsuarioDisponible').text('Muy Corto');$('#textoUsuarioDisponible').addClass('textoAlerta');
					$('#iconoUsuario').addClass('ui-icon ui-icon-alert');$('#iconoUsuario').removeClass('ui-icon ui-icon-closethick');
					$('#iconoUsuario').removeClass('ui-icon ui-icon-check');
				}
				if(x.length<=3){ 
					$('#textoUsuarioDisponible').removeClass('textoAceptable'); $('#textoUsuarioDisponible').removeClass('textoNoAceptable');
					$('#iconoUsuario').addClass('ui-icon ui-icon-alert');
				}
				if(x.length==0){ $('#textoUsuarioDisponible').text('Vacío');}
			});
		}
	});//fin de load
	$('#formGenerales input,#dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
	return true;
});
}//fin cargar ficha
function openFile(file) {
    var extension = file.substr( (file.lastIndexOf('.') +1) );
    switch(extension) {
        case 'jpg':
		case 'JPG':
        case 'png'://case 'gif':
		case 'PNG':
            return 1;
        break; //case 'zip': //case 'rar': //alert('was zip rar'); //break; //case 'pdf': //alert('was pdf'); //break;
        default:
            return 0;
    }
};
</script>

<script>
  $.widget( "ui.timespinner", $.ui.spinner, {
	options: {
	  step: 60 * 1000,// seconds
	  page: 60 // hours
	},
	_parse: function( value ) {
      if ( typeof value === "string" ) {
        // already a timestamp
        if ( Number( value ) == value ) {
          return Number( value );
        }
        return +Globalize.parseDate( value );
      }
      return value;
    },
	_format: function( value ) {
      return Globalize.format( new Date(value), "t" );
    }
	 	
  });
</script>

<script>
function nuevoUsuario(){
$(document).ready(function(e) {
	$("#gallery").html('');
	$('#upload').show();
	$('#nombreFotoT').val('');
	$('#idPacienteN').val('');
	var now = new Date().getTime(); 
	var d = new Date();
	$('#nombreFotoT').val(d.format('Y-m-d-H-i-s-u').substring(0,22)); //alert($('#nombreFotoT').val());
	//Todo el pedo de la fotografía del perfil
	var button = $('#upload'), interval;
	new AjaxUpload(button,{
		action: 'imagenes/procesa.php?action='+document.getElementById('nombreFotoT').value, 
		name: 'image',
		onSubmit : function(file, ext){//alert('Procesa en nuevo paciente');
			// cambiar el texto del boton cuando se selecicione la imagen		
			button.text('Subiendo');
			if(openFile(file)==0){//si el archivo no es una imagen
				$('#upload').button({
				  icons: { primary: "ui-icon-alert" },
				  text: true, label: "Archivo no válido"
				});
				return false;
			}
			// desabilitar el boton
			interval = window.setInterval(function(){
				var text = button.text();
				if (text.length < 11){
					button.text(text + '.');					
				} else { button.text('Subiendo'); }
			}, 200);
		},
		onComplete: function(file, response){//alert(file);
			$('#upload').button({
			  icons: { primary: "ui-icon-image" },
			  text: true, label: "Cambiar la fotografía"
			}).hide();
			$('#hayFoto').val(1);
						
			window.clearInterval(interval);
			// Habilitar boton otra vez
			//this.enable();
			// Añadiendo las imagenes a mi lista
			if($('#gallery li').length == 0){
				$('#gallery').html(response).fadeIn("fast");
				$('#gallery li').eq(0).hide().show("slow");
			}else{
				$('#gallery').prepend(response);
				$('#gallery li').eq(0).hide().show("slow");
			}
			$('#miGaleri .eliminame').click(function(e) {//alert(8);
				var a = $(this); //alert(a.attr('name'));	
				$.get("imagenes/procesa.php?action=eliminar",{id:a.attr("name")},function(){//alert('Procesa en nuevo paciente eliminar normal');
					$('#gallery').html('');
					$('#upload').button({
					  icons: { primary: "ui-icon-image" },
					  text: true, label: "Agregar fotografía"
					}).show();
					$('#hayFoto').val(0);
				})
			});
		}
	});
	
	var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 20;
	var wi = $('#referencia').width() * 0.98;
	
    $('#dialog-confirmarNuevoPaciente').dialog({
		title:'NUEVO USUARIO',modal:true,autoOpen:false,closeText:'Salir sin guardar',width:wi,height:he,closeOnEscape:false, 
		dialogClass:'',
		buttons: {
      },
	  create: function( event, ui ) {},
	  open:function( event, ui ){//alert(8);
			$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab'); $('.pActivo').show();$('#tabs-5-1').hide();$('.idUsuarioP').val($('#idUsuario').val());$('.uActivo').hide();
			$('#guardarUser').button();
			$('#updateUser').hide();
			$('#guardarUser').click(function(event) {
                event.preventDefault();
				if($('#formGenerales').valid()){ 
					var datosP = $('#formGenerales').serialize();
					$.post('files-serverside/addUsuario.php',datosP).done(function( data ) {//guardamso al nuevo paciente
					//function processData(data){// alert(data);
						if (data==1){//si el paciente se guerdó (los purod datos generales) entonces se activan las demas pestañas y cambia de archivo de guardar a actualizar.
							$('#dialog-confirmaAltaPaciente').dialog('open');
							$('#clickme').click();$(this).dialog('close');
						}
						else{alert(data);}
					});
				}
            }).show();
			$('#pestanas').removeClass('ui-widget-header'); 
			$("#tipoUsuario").load('genera/tipos_usuario.php',function(response,status,xhr){ if(status == "success"){} });
			var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {
				validateOn:["blur"], isRequired:false, useCharacterMasking:true
			});
			var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "phone_number", {
				validateOn:["blur"], isRequired:false, useCharacterMasking:true
			});
			var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "phone_number", {
				validateOn:["blur"], isRequired:false, useCharacterMasking:true
			});
			var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "phone_number", {
				validateOn:["blur"], isRequired:false, useCharacterMasking:true
			});
			$('#telmovilP').focusout(function(e) { if($(this).val()=='('){$(this).val('');} }); 
		},
		close:function( event, ui ){ $( "#dialog-confirmarNuevoPaciente" ).tabs( "destroy" );$('#dialog-confirmarNuevoPaciente').empty();cargaFicha(); }
	});
	$('#dialog-confirmarNuevoPaciente').dialog('open');
});
}//fin función nuevoUsuario
</script>

<script>
function verMenu(){
	$(document).ready(function(e) {
        $('#miMenu').show('fold','slow');
		$('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">PERSONAL</span>');
    });
}
function ocultarMenu(){
	$(document).ready(function(e) {
        $('#miMenu').hide('fold','slow');
		$('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">PERSONAL</span>');
    });
}
</script>

</head>

<body>
<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; border: 1px solid red; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="sucursalU" type="hidden" id="sucursalU" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="indicePaciente" type="hidden" id="indicePaciente">
<input name="sucursalOV" type="hidden" id="sucursalOV" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="today" id="today" type="hidden" value="<?php echo date("d/m/Y"); ?>">

<div id="header" class="header" style="display:;">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" class="iconito"><img src="../imagenes/iconitos/_iconoUsuarios.png" height="50"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">PERSONAL</span></td>
        <td id="celdaUsuario" width="50%" valign="top" align="center">
            <table class="miUsuario" width="1%" height="100%" border="0" cellspacing="0" cellpadding="4" style="border-radius:0px;">
              <tr>
                <td align="center" nowrap valign="middle">
                <?php if($row_usuario['foto_u'] == 1){?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="25">
                <?php }else{?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="25">
                <?php }?>
                </td>
                <td nowrap valign="middle" class="usuarioPerfil">
                <?php echo $row_usuario['usuario_u']; ?>
                </td>
              </tr>
            </table>
    <div id="misDatosUsuario">
    <table width="100%" border="0" cellspacing="2" cellpadding="">
        <tr>
            <td>
            <?php if($row_usuario['foto_u'] == 1){?>
                <img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="80">
            <?php }else{?>
                <img class="fotoUsuario" id="miFotoUsuario" src="../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="80">
            <?php }?>
            </td>
            <td align="center"><?php echo $row_usuario['nombre_u']." ".$row_usuario['apaterno_u']." ".$row_usuario['amaterno_u']; ?> <br> <span style="font-size:0.7em">(<?php echo $row_usuario['idPuesto_u']; ?>)</span></td>
        </tr>
    </table>
    
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr>
        <td style="font-weight:bold;" align="center"><?php echo $row_nombreSucursalUsuario['nombre_su']; ?></td>
        </tr>
        <tr>
        <td style="font-size:0.8em;" align="center"><?php echo $row_nombreDepartamentoUsuario['nombre_d']; ?></td>
        </tr>
        <tr>
        <td style="font-size:0.8em;" align="center"><span style="text-decoration:underline; cursor:pointer;"><a href="<?php echo $logoutAction ?>">CERRAR SESIÓN</a></span></td>
        </tr>
    </table>
    </div>
        </td>
      </tr>
    </table>
</div>

<div id="miMenu" class="miMenu" align="center">
<table width="98%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
  <tr valign="middle" align="center" class="fondoMenu">
    <td class="eii"><img title="MENÚ ANTERIOR" src="../imagenes/submenu/_recepcion.png" width="100" onClick="window.location='../menu_recepcion.php'"></td>
    <td class="eid"><img title="INICIO" src="../imagenes/submenu/_inicio.png" width="100" onClick="window.location='../menu.php'"></td>
  </tr>
</table>
</div>

<div class="contenido" id="contenido" align="center">
  <table width="90%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTablePrincipal" class="tablilla">
    <thead id="cabecera_tBusquedaPrincipal">
      <tr bgcolor="#FF6633" style="font-size:1.4em;">
        <th class="titulosTabs" align="center" style="color:white;">ID</th>
        <th id="clickme" class="titulosTabs" align="center" style="color:white;">NOMBRE</th>
        <th class="titulosTabs" align="center" style="color:white;">USUARIO</th>
        <th class="titulosTabs" align="center" style="color:white;">SUCURSAL</th>
        <th class="titulosTabs" align="center" style="color:white;">PUESTO</th>
     	<th class="titulosTabs" align="center" style="color:white;">DEPARTAMENTO</th>
        <th class="titulosTabs" align="center" style="color:white;">CELULAR</th>
      </tr>
    </thead>
    <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>

<div id="dialog-confirmarNuevoPaciente" style="display:none;"></div>

<div id="dialog-buscaMedico" title="BUSCAR PROMOTOR" style="display:none;"> </div>

<div id="dialog-confirmaAltaPaciente" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle" height="100%">LOS DATOS DEL PACIENTE SE HAN GUARDADO SATISFACTORIAMENTE</td> </tr> </table></div>

<form action="paciente.php" method="post" name="formP" target="_self" id="formP">
    <input name="idUsuario" type="hidden" id="idUsuario" value="<?php echo $row_usuario['id_u']; ?>">
    <input name="idPaciente" type="hidden" id="idPaciente" value="">
</form>

<div id="dialog-verPaciente" align="right" style="display:none;"> </div>

<div class="footer" id="footer" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle"> &copy; HORIZONTE MÉDICA <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS.</td> </tr> </table> </div>

<input name="filtro" id="filtro" type="hidden" value="YO SOLO SE QUE NO SE NADA">
</body>
</html>

<?php
mysql_free_result($usuario);
mysql_free_result($nombreSucursalUsuario);
mysql_free_result($nombreDepartamentoUsuario);
?>

<script type="text/javascript">
$(document).ready(function() {

	var oTableP;
	var tamP = $('#referencia').height() - 170;
	oTableP = $('#dataTablePrincipal').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
		"bJQueryUI": false,ordering: false, "bScrollCollapse": true, "sScrollY": tamP, "bAutoWidth": false, "bStateSave": true, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [
			{ "bVisible": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
			{ "bSortable": false }, { "bSortable": false }
		],
		"iDisplayLength": 80, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
		"sDom": '<"toolbar"><"filtro1Principal"f>lr<"data_tPrincipal"t><"infoPrincipal"i>S',
		"sAjaxSource": "datatable-serverside/personal.php",
		"fnServerParams": function (aoData, fnCallback) {
			   var de = $('#filtro').val();
               aoData.push(  {"name": "nombre", "value": de /*'2013-02-01 00:00:00'*/ } );
        },
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "ENCONTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<span style='display:none;'><br/>USUARIOS: _MAX_</span>", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		}
		
	});
	
	//$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right;'><table id='ocultarFP' style='float:right;' width='' border='0' cellspacing='0' cellpadding='6'> <tr> <td><img id='addPacientePrincipal' onClick='nuevoUsuario()' src='../imagenes/botones/_agregar1.png' width='' height=''></td> </tr> </table></div>" );
	$('#addPacientePrincipal').css('height', $('.filtro1Principal input').height());
	$('.filtro1Principal input').attr("placeholder", "PARA EMPEZAR, BUSQUE A UN PERSONAL AQUÍ...").addClass('placeHolder');
	
	//ponemos los botones de reset y de añadir un paciente de la tabla principal de busqueda de pacientes
	$("div.toolbar").css('white-space','nowrap').css('border','1px none red').css('padding','10px');
	
	if($('.filtro1Principal input').val() ==''){ $('#filtro').val('YO SOLO SE QUE NO SE NADA');
	}else{ $('#filtro').val('%%');oTableP.fnDraw(); }
	
	$('.filtro1Principal').css('left',$('#botonesPrincipal').width() );
	$('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );
		
	window.setTimeout(function(){
		$('.filtro1Principal').css('left',$('#botonesPrincipal').width() );
		$('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );
	},300);
	
	$( window ).resize(function() {
		$('.filtro1Principal').css('left',$('#botonesPrincipal').width() );
		$('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );
	});
	
	var search_boxP = $('.filtro1Principal input');
	var busquedaP = $('.filtro1Principal');
	var data_tP = $('#dataTablePrincipal tbody');
	var info_tP = $('.infoPrincipal *');
	var reseteP = $('#resetePrincipal');
	var div_botonesP = $('.botonesPrincipal');
	var paginacionesP = $('.paginacionPrincipal');
	var cabeceraP = $('#cabecera_tBusquedaPrincipal');
	
	$('#addPacientePrincipal').hide();
	
	if($('.filtro1Principal input').val() ==''){ div_botonesP.hide(); $('#addPacientePrincipal').hide();
	}else{ div_botonesP.show(); $('#addPacientePrincipal').show(); }
	
	paginacionesP.hide();
	
	search_boxP.focus();
	
	search_boxP.keyup(function(e) {
    	if( $(this).val() == '' ){
			$('#filtro').val('YO SOLO SE QUE NO SE NADA');
			$('#addPacientePrincipal').hide();
			div_botonesP.hide();
			oTableP.fnDraw();
		}else {
			$('#filtro').val('%%');
			$('#addPacientePrincipal').show();
			div_botonesP.show();
			oTableP.fnDraw();
		}
    });
	
	reseteP.click(function(e) {
        search_boxP.val('');
		search_boxP.focus();
		$('#filtro').val('YO SOLO SE QUE NO SE NADA');
		div_botonesP.hide();
		oTableP.fnDraw();
    });
	
	$('#clickme').click(function(e) { oTableP.fnDraw(); });

});
</script>

<script>
$(document).ready(function(e) {
	var he1 = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 20;
	var wi1 = $('#referencia').width() * 0.97;
	
	$('#dialog-confirmaAltaPaciente').dialog({
		autoOpen: false, modal: true, width: 620, height:150, title: 'DATOS GUARDADOS', closeText: '',
		open:function( event, ui ){
			$('#dialog-confirmarNuevoPaciente').dialog('close');
			window.setTimeout(function(){$('#dialog-confirmaAltaPaciente').dialog('close');},2500);
		}
	});
	
    $('#dialog-verPaciente').dialog({
		autoOpen: false,
		modal: true,
		width: wi1,
		height: he1,
		title: 'FICHA DEL PACIENTE',
		closeText: ''
	});
});
</script>

<script>
function SubirPhoto(a,b){//si el paciente cuenta con fotografía. A es el id del paciente, b es el nombre que tiene la fotografía y x es de nuevo el id del paciente
	$(document).ready(function(e) { //alert('cargar foto, el id del paciente es '+a+' el nombre del archivo de la foto es '+b); //Todo el pedo de la fotografía del perfil
		var button = $('#upload'), interval;
		new AjaxUpload(button,{
			action: 'imagenes/procesa.php?action='+b+'&idP='+a, 
			name: 'image',
			onChange : function(file, ext){
				if(openFile(file)==0){//si el archivo no es una imagen
					$('#upload').button({ icons: { primary: "ui-icon-alert" }, text: true, label: "Archivo no válido" });
					return false; //se cancela
				}
			},
			onSubmit : function(file, ext){//alert('Procesa en ver paciente agregar foto si no existe foto'); // cambiar el texto del boton cuando se selecicione la imagen		
				button.text('Subiendo');//alert(a+';2');alert(a+'_'+b);
				interval = window.setInterval(function(){
					var text = button.text();
					if (text.length < 11){
						button.text(text + '.');					
					} else {
						button.text('Subiendo');				
					}
				}, 200);
			},
			onComplete: function(file, response){//alert(file);
				$('#upload').button({ icons: { primary: "ui-icon-image" }, text: true, label: "Cambiar la fotografía" }).hide();
				$('#hayFoto').val(1); //$('#gallery .eliminame').parent().parent().parent().show();		
				window.clearInterval(interval);
				var xa= a, xb = b+'.jpg', xc = a;//alert(xa+'----'+xb);
				return photoSi(xa,xb,a);
			}
		});return;
    });
}
function photoSi(a,b,x){//si el paciente cuenta con fotografía. A es el id del paciente, b es el nombre que tiene la fotografía y x es de nuevo el id del paciente
	$(document).ready(function(e) { //alert('Si hay foto, el id del paciente es '+a+' el nombre del archivo de la foto es '+b+' de nuevo el id del paciente es '+x); //Todo el pedo de la fotografía del perfil
		$('#upload').hide(); //alert('hay foto y el id del paciente es '+datosI[39]);
		return cargarPhoto(a,b);//Cargamos la foto
    });
}
function photoNo(a,b,x){//si el paciente NO cuenta con fotografía. A es el id del paciente, b es el nombre que va tomar la fotografía y x es de nuevo el id del paciente
	$(document).ready(function(e) { //alert('No hay foto, el id del paciente es '+a+' el nombre del archivo de la foto es '+b+' de nuevo el id del paciente es '+x); //Todo el pedo de la fotografía del perfil
		$("#gallery").html('');
		$('#upload').button({
		  icons: { primary: "ui-icon-image" },
		  text: true, label: "Agregar fotografía"
		}).show();//alert('no hay foto y el id del paciente es '+datosI[39]);
		return SubirPhoto(a,b);
    });
}
function cargarPhoto(a,b){//a es el id del paciente y b es el nombre de la foto
$(document).ready(function(e) {//alert(b);
    $("#gallery").load("imagenes/procesa.php?action=listFotos&idPac="+a, function( response, status, xhr ) { 
		if ( status == "success" ) { 
			$('#gallery .eliminame1').click(function(e) {
				return eliminarPhoto(a,b);
			});
		}
	});return;
});
}
function eliminarPhoto(a,b){//a es el id del paciente y b es el nombre de la foto
$(document).ready(function(e) {
	var a1 = $('#gallery .eliminame1'); //alert(a.attr('name'));	
	$.get("imagenes/procesa.php?action=eliminar1",{idP:a, nombreF:b},function(){//alert('Procesa en ver paciente eliminar foto existente');
		a1.parent().fadeOut("slow"); //alert(a.attr('name'));//alert(x+'5');
		$('#upload').button({
		  icons: { primary: "ui-icon-image" },
		  text: true, label: "Agregar fotografía"
		}).show();
		$('#hayFoto').val(0); $('#nombreFotoT').val(''); $('#idPacienteN').val(''); $('#idPacienteN').val(a);
		var now = new Date().getTime(); var d = new Date();
		return photoNo(a,d.format('Y-m-d-H-i-s-u').substring(0,22),a);
	});
});
}

function verUsuario(x){//x es el id del usuario q seleccionamos
 $(document).ready(function(e) {//alert(4);
	$('#nombreFotoT').val('');
	$('#idPacienteN').val(x);//asignamos el id del paciente a la variable para saber cual paciente actualizar por su id
	 var datos ={idP:x}

	$.post('files-serverside/fichaUsuario.php',datos).done(function( data1 ) {
		if (data1 != "ok"){
			var datosI = data1.split('*}');

			var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 20;
			var wi = $('#referencia').width() * 0.98;
			var title = 'USUARIO '+datosI[0]+' '+datosI[1]+' '+datosI[2];
			$('#dialog-confirmarNuevoPaciente').dialog({
				title: title, modal: true, autoOpen: false, closeText: '', width: wi, height: he, closeOnEscape: true,
				dialogClass: '',
				buttons: {
				//"ACTUALIZAR": function() { },
				//"CERRAR": function() { $(this).dialog('close'); }
			  }, create: function( event, ui ) {},
			  open:function( event, ui ){
				  
				  $('#updateUser').button();
				  $('#updateUser').click(function(event) { 
				  	event.preventDefault();
					if($('#formGenerales').valid()){ 
						var datosP = $('#formGenerales').serialize();
						$.post('files-serverside/updateUsuario.php',datosP).done(function( data ) {
							if (data==1){//si el paciente se Actualizó 
								$('#idPacienteN').val(data);$('#clickme').click();
								$('#dialog-confirmaAltaPaciente').dialog('open');
							}
							else{alert(data);}
						});
					}
				  }).show(); if($('#accesoU').val()!=1){$('#updateUser,#bPromotor').hide();}
				  
				  $('#guardarUser').hide();
				  $('#fichaUsuario ul').removeClass('ui-widget-header');
				  window.setTimeout(function(){//alert(datosI[44]);
						$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
						$('.idUsuarioP').val($('#idUsuario').val());$('.uActivo').hide();
						$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
						if(datosI[42]==1){//Si el usuario tiene fotografía //Si el usuario tiene fotografía, entonces la carga // Listar  fotos que hay en mi tabla
							photoSi(datosI[44],datosI[43],x);
						}else{//Si el paciente NO tiene fotografía
							var now = new Date().getTime(); var d = new Date(); 
							photoNo(datosI[44],d.format('Y-m-d-H-i-s-u').substring(0,22),x);
						}
						var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {
							validateOn:["blur"], isRequired:false, useCharacterMasking:true
						});
						var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "phone_number", {
							validateOn:["blur"], isRequired:false, useCharacterMasking:true
						});
						var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "phone_number", {
							validateOn:["blur"], isRequired:false, useCharacterMasking:true
						});
						var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "phone_number", {
							validateOn:["blur"], isRequired:false, useCharacterMasking:true
						});
						//datos generales
						$('.tAlertaU').hide();
						$("#tipoUsuario").load('genera/tipos_usuario.php', function( response, status, xhr ) { 
							if ( status == "success" ) { $('#tipoUsuario').val(datosI[22]); } 
						});
						$('#nombreP').val(datosI[0]);$('#apaternoP').val(datosI[1]);$('#amaternoP').val(datosI[2]);$("#sexoP").val(datosI[16]);$("#nacionalidadP").val(datosI[26]);$("#fnacP").val(datosI[17]);$('#curpP').val(datosI[6]);
						$('#rfcP').val(datosI[13]);$('#sucursalP').val(datosI[14]);$('#claveUsuario').val(datosI[3]);$('#tipoUsuario').val(datosI[22]);$('#username').val(datosI[21]);$('#notasP').val(datosI[19]);$('#telmovilP').val(datosI[7]);
						if (datosI[38] == 1){$('#usuarioForaneo').prop('checked',true);$('#usuarioF').val(1);}else{$('#usuarioForaneo').prop('checked',false);$('#usuarioF').val(0);}
						$('#idPromotor').val(datosI[46]);$('#promotor').val(datosI[47]);
						//Datos de dirección
						$('#estadoP').val(datosI[34]);var idB = $("#estadoP").find(':selected').text();
						$("#municipioP").load('files-serverside/genera_municipios.php?id='+escape(idB), function( response, status, xhr ) {
							if ( status == "success" ) { 
							  $('#municipioP').val(datosI[35]);var idM1 = $("#municipioP").find(':selected').text();var id1E = $("#estadoP").find(':selected').text();
								$("#coloniaP").load('files-serverside/genera_colonias.php?idM='+escape(idM1)+'&idE='+escape(id1E), function( response, status, xhr ) {
								  if ( status == "success" ) { 
									$('#coloniaP').val(datosI[36]);var idCx = $("#coloniaP").find(':selected').text();var idEx = $("#estadoP").find(':selected').text();var idMx = $("#municipioP").find(':selected').text();
									$("#cpP").load('files-serverside/genera_cp.php?idC='+escape(idCx)+'&idE='+escape(idEx)+'&idM='+escape(idMx));
								  }
								});
							}
						});
						$('#calleP').val(datosI[31]);$('#noExtP').val(datosI[32]);$('#noIntP').val(datosI[33]);
						//Datos de contacto
						$('#telparticularP').val(datosI[8]);$('#telefonoTrabajoP').val(datosI[9]);$('#extensionTelTraP').val(datosI[10]);$('#avisarP').val(datosI[12]);$('#telefonoEmergenciaP').val(datosI[11]);$('#emailP').val(datosI[15]);
						//Datos adicionales
						$('#departamentoU').val(datosI[23]);var idDe = $("#departamentoU").val();
						$("#areaU").load('files-serverside/genera_areas.php?id='+escape(idDe), function( response, status, xhr ) {
						  if ( status == "success" ) { $('#areaU').val(datosI[24]); }
						});
	
						$('#puestoU').val(datosI[27]);$('#horarioDe').val(datosI[28]);$('#horarioA').val(datosI[29]);
						$('#escolaridadP').val(datosI[20]);$('#profesionUsuario').val(datosI[25]);
						$('#especialidadU').val(datosI[4]);$('#cedulaU').val(datosI[5]);$('#ocupacionP').val(datosI[41]);
						$('#tsanguineoP').val(datosI[39]);$('#comisionU').val(datosI[30]);$('#precioConsultaU').val(datosI[45]);
						$('#cedulaU1').val(datosI[30]); $('#cTituloU').val(datosI[48]);
						
						$('#claveUsuario').prop('disabled',true);$('#iconoClaveUsuario').addClass('ui-icon ui-icon-check');
						$('#textoClaveUsuarioDisponible').text('Disponible');$('#textoClaveUsuarioDisponible').addClass('textoAceptable');
						$('#username').prop('disabled',true);$('#iconoUsuario').addClass('ui-icon ui-icon-check');
						$('#textoUsuarioDisponible').text('Disponible');$('#textoUsuarioDisponible').addClass('textoAceptable');
					},600);
				},
				close:function( event, ui ){
					$( "#dialog-confirmarNuevoPaciente" ).tabs( "destroy" );$('#dialog-confirmarNuevoPaciente').empty();cargaFicha();$('#username').prop('disabled',false);
				}
			});
			$('#dialog-confirmarNuevoPaciente').dialog('open');
		}else{alert(data);}
	});
 });
}//fin verPaciente

function mostrarFoto(x){
	$(document).ready(function(e) {
		var foto ='<img src="takePicture/fotoPacientes/'+x+'.jpg" width="210" height="">';
		$('#datoFoto').html(foto);
    });
}
function ocultarFoto(){
	$(document).ready(function(e) {
		$('#datoFoto').html('');
    });
}
</script>