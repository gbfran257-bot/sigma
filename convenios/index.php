<?php require_once('../Connections/horizonte.php'); ?>
<?php
//initialize the session
ini_set("session.cookie_lifetime","7200");
ini_set("session.gc_maxlifetime","7200");
if (!isset($_SESSION)) { session_start(); }

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

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
$MM_authorizedUsers = "1,2,3,4,5,6,7,8,9,10,11,12,13";
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
    if (in_array($UserName, $arrUsers)) { $isValid = true;  } 
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
  if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }

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

if (isset($_SESSION['MM_Username'])) { $colname_usuario = $_SESSION['MM_Username']; }
mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT id_u, nombre_u, apaterno_u, amaterno_u, idSucursal_u, usuario_u, idDepartamento_u, idPuesto_u, acceso_u, sexo_u, foto_u, nombreFoto_u FROM usuarios WHERE usuario_u = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

if($row_usuario['acceso_u']==6){ /*header("Location: diagnostico/laboratorio/listado.php"); */}

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
<link rel="shortcut icon" href="../imagenes/general/favicon.ico">
<meta charset="utf-8">
<title>CONVENIOS</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">

<script src="../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/retardo.js"></script>
<script src="../funciones/js/stdlib.js"></script>

<script language="javascript">
//para las tooltips
$( document ).tooltip({ extraClass: "arrow", position: { my: "center bottom-10", at: "center top" } });

$(document).ready(function() {
	//inicializaciones			
	$('#verMenu').click(function(e){window.location='../menu.php?menu=ma';});
	var i = 1;
	
	$('#dispara_menu').click(function(e) { i++;
		if(i%2==0){
			$('#header').after('<div id="div_menu" class="ver_menu" style="border:1px none red; z-index:1000000000000; position:fixed; width:240px;"><table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="left"><ul id="menu_u1" style="border-bottom-left-radius:4px;border-bottom-right-radius:4px;"><li><div id="mi_perfil"><span class="ui-icon ui-icon-person"></span> Mi perfil</div></li><li><div><span class="ui-icon ui-icon-gear"></span> Configuración</div></li><li><div><span class="ui-icon ui-icon-power"></span> <a href="<?php echo $logoutAction ?>">Cerrar sesión</a></div></li><li><div id="ayuda"><span class="ui-icon ui-icon-info"></span> Ayuda</div></li><li><div id="reportar_problema"><span class="ui-icon ui-icon-comment"></span> Reportar problema</div></li><li><div id="politicas_condiciones"><span class="ui-icon ui-icon-script"></span> Políticas y condiciones</div></li><li><div id="aviso_privacidad"><span class="ui-icon ui-icon-alert"></span> Aviso de privacidad</div></li><li><div id="acerca_de"><span class="ui-icon ui-icon-star"></span> Acerca de</div></li></ul></td></tr></table></div>');
			$('#div_menu').css('top',$('#header').height()+0); $('#menu_u1').menu(); 
			$('#mi_perfil').click(function(e){ window.location="usuarios/perfil.php"; });
			$('#div_menu').css('right',104);
			$('#dispara_menu span').removeClass('ui-icon-triangle-1-s'); $('#dispara_menu span').addClass('ui-icon-triangle-1-n');
			$('#contenido').click(function(e){ 
				$('#div_menu').remove(); i = 1;
				$('#dispara_menu span').removeClass('ui-icon-triangle-1-n');
				$('#dispara_menu span').addClass('ui-icon-triangle-1-s');
			});
		}else{ 
			$('#dispara_menu span').removeClass('ui-icon-triangle-1-n'); $('#dispara_menu span').addClass('ui-icon-triangle-1-s');
			$('#div_menu').remove(); 
		}
    });	
	
	$('#formGenerales').validate({ ignore: 'hidden'});								
});
</script>

<script>
$(document).ready(function(e) {
	var he = $('#referencia').height() - 160, wi = $('#referencia').width() * 0.96;
	$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
	$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
	
	$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-90);
	$('.tabs').css('width',wi/7.2);
				
	$( window ).resize(function(e) {
		var he = $('#referencia').height() - 160, wi = $('#referencia').width() * 0.96;
		$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
		$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
		
		$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-90);
		$('.tabs').css('width',wi/7.2);
    });
	
	var cuadrado = 35;
	$('button').css('width',cuadrado).css('height',cuadrado);
	$('#addConvenio').button({
      icons: { primary: "ui-icon-plusthick" },
      text: false
    });
	
	$('form').submit(function(event) { event.preventDefault(); });
	
});
</script>

<script>
  $.widget( "ui.timespinner", $.ui.spinner, {
	options: { // seconds
	  step: 60 * 1000, // hours
	  page: 60
	},
	_parse: function( value ) {
      if ( typeof value === "string" ) {
        // already a timestamp
        if ( Number( value ) == value ) { return Number( value ); }
        return +Globalize.parseDate( value );
      }
      return value;
    },
	_format: function( value ) { return Globalize.format( new Date(value), "t" ); }
	 	
  });
</script>

<script>
function verConvenio(x){ $(document).ready(function(e) {
	$('#idPacienteN').val(x);//asignamos el id del convenio a la variable para saber cual convenio actualizar por su id
	 var datos ={idC:x}
	 $.post('files-serverside/fichaConvenio.php',datos).done(function( data1 ) {
		if (data1 != "ok"){
			var datosI = data1.split('*}');
			var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 20;
			var wi = $('#referencia').width() * 0.96;
			var title = 'FICHA DEL CONVENIO. '+datosI[1];
			$('#dialog-confirmarNuevoPaciente').dialog({
				title: title, modal: true, autoOpen: false, closeText: '',width:wi, height:he, closeOnEscape: true, dialogClass: '',
				buttons: {
				"ACTUALIZAR": function() {
					if($('#formGenerales').valid()){
						var datosP = $('#formGenerales').serialize();
						$.post('files-serverside/updateConvenio.php',datosP).done(function( data ) {
							if (data=='ok'){//si el convenio se Actualizó 
								$('#dialog-confirmarNuevoPaciente').dialog('close');$('#clickme').click();
								$('#dialog-confirmaAltaPaciente').dialog('open');
							}
							else{alert(data);}
						});
					}
				},
				"CERRAR": function() { $(this).dialog('close'); }
			  },
			  open:function( event, ui ){
					$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
					$('#dialog-confirmarNuevoPaciente textarea').css('height','99%');
					$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
					//ponemos los valores INICIALES DE LA FICHA DEL CONVENIO:
					//datos generales
					$('#claveC').val(datosI[0]);$("#nombreC").val(datosI[1]);$('#descripcionC').val(datosI[2]);					
				},
				close:function( event, ui ){
					document.getElementById('formGenerales').reset();
					$('form label.error').hide();
				}
			});
			$('#dialog-confirmarNuevoPaciente').dialog('open');
		}else{alert(data);}
	});
}); }//fin verPaciente

function nuevoConvenio(idCo){ $(document).ready(function(e) {
	var he=$('#referencia').height()-20, wi = $('#referencia').width() * 0.98;
	
$("#dialog-confirmarNuevoPaciente").load("htmls/ficha_convenio.php #ficha_convenio",function(response, status, xhr) {
	if ( status == "success" ) {
		if(idCo==undefined){
			var now = new Date().getTime(); var d = new Date();
			$('#aleatorioB').val(d.format('Y-m-d-H-i-s-u').substring(0,22));
			$('#bGuardaB').show();
			$('#bActualizaB').hide();
		}else{
			$('#idBeneficio').val(idCo);
			var datosC = {id:idCo}
			$.post('files-serverside/fichaConvenio.php',datosC).done(function( data ) {
				$('#bGuardaB').hide();
				$('#bActualizaB').show();
				datosCo = data.split('*};');
				$('#nombreB').val(datosCo[0]);
				$('#descripcionB').val(datosCo[1]);
				$('#aleatorioB').val(datosCo[2]);
			});
		}
		
		var he = $('#referencia').height() - 100, wi = $('#referencia').width() * 0.96;
	
		$('#dialog-confirmarNuevoPaciente').dialog({
			title:'CONVENIO',modal: true,autoOpen: true,closeText:'',width: wi,height: he,closeOnEscape: false,
			dialogClass: 'no-close',
			buttons: { //"GUARDAR": function() { }, //"CANCELAR":function(){ $(this).dialog('close'); }
		  },
		  open:function( event, ui ){
			  $('#saveNbeneficio, #cancelNbeneficio, #updateNbeneficio').button({});
		  	var oTableCoNB;
			oTableCoNB = $('#dataTableAB').dataTable({ "bJQueryUI": false,ordering: false, "bRetrieve": true, 
				"sScrollY": he/2, "bStateSave": false, "bInfo": false, "bFilter": false, 
				"aaSorting": [[0, "asc"]],
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
				"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
					{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }], 
					"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
				"sDom": '<"toolbarAB"><"filtroAB"f>lr<"data_tAB"t><"infoAB"i>S', 
				"sAjaxSource": "datatable-serverside/conceptos_seleccionados_beneficios1.php", 
				"fnServerParams": function (aoData, fnCallback) { 
					var aleatorio = $('#aleatorioB').val(); aoData.push( {"name": "aleatorio", "value": aleatorio } ); },
				"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
				"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
				"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
				"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>CANCEPTOS: _MAX_", "sSearch": "" }
			});/*fin datatable*/ $('#clickmeAB').click(function(e) { oTableCoNB.fnDraw(); });
			$('#tabs-2-1').click(function(e) { $('#clickmeAB').click(); });
			var xx = 30;
			$('#asignaConvenio').css('width',xx).css('height',xx).button({ icons: { primary: "ui-icon-refresh" }, text: false });
			$('#asignaConvenio').click(function(event) { event.preventDefault(); });
			$('#asignaConvenio').click(function(e) {
            	$("#dialog-catalogos").load("htmls/ficha_convenio.php #buscar_conceptos", function( response, status, xhr ) { 
				if ( status == "success" ) {
					$('#dialog-catalogos').dialog({ 
						title: 'BUSCAR LOS CONCEPTOS PARA EL BENEFICIO', modal: true, autoOpen: true, closeText: '', 
						width: wi, height: he, closeOnEscape: false, dialogClass: 'no-close',
						buttons: {
						"Aceptar": function() { checarHayConcepto($('#aleatorioB').val()); },
						"Cerrar": function() { $('#dialog-catalogos').dialog('close'); },
					  }, create: function( event, ui ) {}, 
					  close:function( event, ui ){ $('#clickmeIn').click();$('#clickmeAB').click();$('#dialog-catalogos').empty(); },
					  open:function( event, ui ){ 
						var oTableBmB1;
						oTableBmB1 = $('#dataTableBconceptos').dataTable({ 
							"bJQueryUI": false, "bRetrieve": true, "sScrollY": ($('#dialog-catalogos').height()-155)/2, 
							"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[1, "asc"]],
							"aoColumns": [{ "bSortable": false },{ "bSortable": false }, { "bSortable": false }, 
								{ "bSortable": false }], "iDisplayLength": 30, "bLengthChange": false, 
								"bProcessing": false, "bServerSide": true,
							"sDom": '<"toolbarBMB"><"filtroBMB">lr<"data_tBMB"t><"infoBMB"i>S', 
							"sAjaxSource": "datatable-serverside/buscar_conceptos_beneficio.php", 
							"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
							"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
							"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
							"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>CONCEPTOS: _MAX_", "sSearch": "" }
						}); $('#clickmeCoB').click(function(e) { oTableBmB1.fnDraw(); });
						
						$(".pieTablaBco input").keyup( function () { oTableBmB1.fnFilter( this.value, $(".pieTablaBco input").index(this) ); });
							
						$('.filtroBMB input').attr("placeholder", "BUSQUE LAS INDICACIONES AQUÍ, Y DELE CLIC PARA SEECCIONARLAS...").addClass('placeHolder');
						$('.infoBMB').hide(); $('.filtroBMB input').focus(); $('.filtroBMB input').css('width', ($('#dialog-catalogos').width() -16) ).hide(); $('.filtroBMB').css('left',-32);
						
						var tableBMB = $('#dataTableBconceptos').DataTable();
						$('#dataTableBconceptos tbody').on('click','tr',function(){
							if($(this).hasClass('selected2')){$(this).removeClass('selected2');}else{tableBMB.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');$('#errorSeleccionConceptos').hide();}
						});
						
						$('#dataTableBconceptos tbody').on( 'click', 'tr', function () { 
							var nTdsMNB = $('td', this);  
							subirConcepto($(nTdsMNB[0]).text(), $('#aleatorioB').val(), $('#idUser').val()); 
						});
						
						var oTableBmB2;
						oTableBmB2 = $('#dataTableCoSBeneficio').dataTable({ "bJQueryUI": false, "bRetrieve": true, "sScrollY": ($('#dialog-catalogos').height()-155)/2, "bStateSave": false, "bInfo": false, "bFilter": false, "aaSorting": [[0, "asc"]],
							"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, ordering: false,
							"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
								{ "bSortable": false }, { "bSortable": false }], 
								"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
							"sDom": '<"toolbarBMB1"><"filtroBMB1"f>lr<"data_tBMB1"t><"infoBMB1"i>S', "sAjaxSource": "datatable-serverside/conceptos_seleccionados_beneficios.php", 
							"fnServerParams": function (aoData, fnCallback) { var aleatorio = $('#aleatorioB').val(); aoData.push(  {"name": "aleatorio", "value": aleatorio } ); },
							"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
							"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADAS: _END_", "sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "<br/>INDICACIONES: _MAX_", "sSearch": "" }
						});/*fin datatable*/ $('#clickmeCoSB').click(function(e) { oTableBmB2.fnDraw(); });
					  }
					});
				} });
            });
			$('#saveNbeneficio').click(function(e) {
				if($('#formNbeneficio').valid()){ 
					$('#idUsuarioB').val($('#idUser').val());
					var datosNB = $('#formNbeneficio').serialize();
					$.post('files-serverside/addBeneficio.php',datosNB).done(function( data ) {
						if (data==1){
							$('#dialog-confirmarNuevoPaciente').dialog('close');$('#clickme').click();
							$('#dialog-confirmaAltaPaciente').dialog('open');
						}
						else{alert(data);}
					});
				}
			});
			$('#updateNbeneficio').click(function(e) {
				if($('#formNbeneficio').valid()){ 
					var datosUB = $('#formNbeneficio').serialize();
					$.post('files-serverside/updateConvenio.php',datosUB).done(function( data ) {
						if (data==1){
							$('#dialog-confirmarNuevoPaciente').dialog('close');$('#clickme').click();
							$('#dialog-confirmaAltaPaciente').dialog('open');
						}
						else{alert(data);}
					});
				}
			});
			$('#cancelNbeneficio').click(function(e) { $('#dialog-confirmarNuevoPaciente').dialog('close'); });
		  	$('#formNbeneficio').validate({ignore: 'hidden'});
			$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
			$('#dialog-confirmarNuevoPaciente textarea').css('height','99%');
			$("#ficha_convenio").tabs({active: 0}); $('#pestanas').removeClass('ui-widget-header');
		  },
		  close:function( event, ui ){ $('#dialog-confirmarNuevoPaciente').empty(); }
		});
	}
});

}); }

function editCantidadBeneficio(id){ $(document).ready(function(e) {
	$("#dialog-catalogos").load('htmls/ficha_convenio.php #editCantidad', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditCantidad').validate();
			$('#dialog-catalogos').dialog({ 
				title: 'EDITAR EL NÚMERO DE CONCEPTOS', modal: true, autoOpen: true, closeText: '', width: 600, height: 300, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditCantidad').valid()){
							var datosEC = $('#formEditCantidad').serialize();
							$.post('files-serverside/editCantidad.php',datosEC).done(function(data){
								if(data == 1){ $('#clickmeAB').click(); $('#dialog-catalogos').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-catalogos').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-catalogos').empty(); },
				open:function( event, ui ){
					$('#idAC').val(id);
					$('#idUsuarioEC').val($('#idUser').val());
				}
			});
		}
	});
}); }

function editPrecioBeneficio(id){ $(document).ready(function(e) {
	$("#dialog-catalogos").load('htmls/ficha_convenio.php #editPrecios', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditPrecios').validate({});
			$('#dialog-catalogos').dialog({ 
				title: 'EDITAR LOS PRECIOS DEL CONCEPTO', modal: true, autoOpen: true, closeText: '', width: 600, height: 320, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditPrecios').valid()){
							var datosEP = $('#formEditPrecios').serialize();
							$.post('files-serverside/editPrecios.php',datosEP).done(function(data){
								if(data == 1){ $('#clickmeAB').click(); $('#dialog-catalogos').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-catalogos').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-catalogos').empty(); },
				open:function( event, ui ){
					$('#idAC').val(id);
					$('#idUsuarioEP').val($('#idUser').val());
				}
			});
		}
	});
}); }

function borrarConceptoNB(idConcepto){ $(document).ready(function(e) { var datosConceptoNB = {idConcepto:idConcepto}
	$.post('files-serverside/eliminarConceptoNB.php',datosConceptoNB).done(function( data ) { if (data==1){ $('#clickmeCoSB').click(); $('#clickme, #clickme').click(); } else{alert(data);} });
});}
function checarHayConcepto(noAleatorio){ $(document).ready(function(e) { var datosChecaConcepto = {noAleatorio:noAleatorio}
  $.post('files-serverside/checarHayConceptos.php',datosChecaConcepto).done(function(data){if(data>0){$('#errorSeleccionConceptos').hide();$('#dialog-catalogos').dialog('close');$('#clickme').click();}else{$('#errorSeleccionConceptos').hide().show('shake');}}); 
});}

function subirConcepto(concepto, noAleatorio, idU){ $(document).ready(function(e) {//alert(muestra);
	if(concepto != 'SIN COINCIDENCIAS - LO SENTIMOS'){ var datosSCoB = {concepto:concepto, noAleatorio:noAleatorio, idU:idU}
		$.post('files-serverside/guardarConceptoNB.php',datosSCoB).done(function( data ) { 
			if (data==1){ $('#clickmeCoSB').click(); $('#clickme, #clickme').click(); 
			} else{alert(data);} });
	}
});}

</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<div id="dialog-catalogos" style="display:none; overflow:hidden;"> </div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="sucursalU" type="hidden" id="sucursalU" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="indicePaciente" type="hidden" id="indicePaciente">
<input name="sucursalOV" type="hidden" id="sucursalOV" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="today" id="today" type="hidden" value="<?php echo date("d/m/Y"); ?>">

<div id="header" class="header">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_iconoConvenios.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">CONVENIOS</span></td>
        <td width="1%" nowrap valign="middle">
        	<span id="dispara_menu">
            	<?php if($row_usuario['foto_u'] == 1){?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="21">
                <?php }else{?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="21">
                <?php }?>
            	<?php echo $row_usuario['usuario_u']; ?> <span class="ui-icon ui-icon-triangle-1-s"></span>
            </span>
        </td>
        <td width="100" nowrap align="left"> </td>
      </tr>
    </table>
</div>

<div class="contenido" id="contenido" align="center">
  <table width="90%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTablePrincipal" class="tablilla">
    <thead id="cabecera_tBusquedaPrincipal">
      <tr bgcolor="#FF6633" style="font-size:1.4em;">
        <th id="clickme" class="titulosTabs" align="center" style="color:white;">BENEFICIO</th>
        <th class="titulosTabs" align="center" style="color:white;" width="10px">#PACIENTES</th>
      </tr>
    </thead>
    <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
</div>

<div id="dialog-confirmarNuevoPaciente" style="display:none;">
	<ul id="pestanas">
    	<li><a class="tabs" href="#tabs-1" style="color:white; background-color:#FF6600;">DATOS DEL CONVENIO</a></li>
    </ul>
 <form action="" method="post" name="formGenerales" id="formGenerales" target="_self">
 <input name="idPacienteN" type="hidden" id="idPacienteN">
  <div class="miTab" id="tabs-1">
    <input name="idUsuarioP" id="idUsuarioP" class="idUsuarioP" type="hidden" value="<?php echo $row_usuario['id_u']; ?>">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr align="left">
            <td class="titulosTabs" width="30%">CLAVE DEL CONVENIO *</td>
            <td class="titulosTabs" width="">NOMBRE DEL CONVENIO *</td>
          </tr>
          <tr>
            <td><input name="claveC" id="claveC" type="text" onKeyUp="conMayusculas(this);" class="required" value=""></td>
            <td><input name="nombreC" id="nombreC" type="text" onKeyUp="conMayusculas(this);" maxlength="" class="required"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr align="left">
            <td class="titulosTabs" width="">DESCRIPCION *</td>
          </tr>
          <tr>
            <td><textarea name="descripcionC" id="descripcionC" cols="" rows="" style="resize:none;" onKeyUp="conMayusculas(this);" class="required"></textarea></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
  
</form>
</div>

<div id="dialog-confirmaAltaPaciente" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle" height="100%">LOS DATOS DEL BENEFICIO SE HAN GUARDADO SATISFACTORIAMENTE</td>
  </tr>
</table>
</div>

<div id="dialog-verPaciente" align="right" style="display:none;"> </div>

<div class="footer" id="footer" style="display:none;"> </div>

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
	var tamP = $('#referencia').height() - 190;
	oTableP = $('#dataTablePrincipal').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
		"bJQueryUI": false,ordering: false, "bScrollCollapse": true, "sScrollY": tamP, "bAutoWidth": false, "bStateSave": true, 
		"bInfo": true,
		"bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [{ "bSortable": false }, { "bSortable": false }],
		"iDisplayLength": 50, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
		"sDom": '<"toolbar"><"filtro1Principal"f>lr<"data_tPrincipal"t><"infoPrincipal"iS>',
		"sAjaxSource": "datatable-serverside/convenios.php",
		"fnServerParams": function (aoData, fnCallback) {
			   var de = $('#filtro').val();
               aoData.push(  {"name": "nombre", "value": de /*'2013-02-01 00:00:00'*/ } );
        },
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page",
			"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
			"sInfo": "ENCONTRADOS: _END_",
			"sInfoEmpty": "MOSTRADOS: 0",
			"sInfoFiltered": "BENEFICIOS: _MAX_",
			"sSearch": "",
			"oPaginate": {
       			"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
				"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
      		}
		}
	}); $('#clickme').click(function(e) { oTableP.fnDraw(); });
	
	$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right;'><table id='' style='float:right;' width='' border='0' cellspacing='0' cellpadding='6'> <tr> <td><button id='addPacientePrincipal' onClick='nuevoConvenio()' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title='Nuevo convenio'> <span class='ui-icon ui-icon-plusthick'></span> B</button></td> </tr> </table></div>" );
	$('#addPacientePrincipal').css('height', $('.filtro1Principal input').height());
	$('.filtro1Principal input').attr("placeholder", "PARA EMPEZAR, BUSQUE UN CONVENIO AQUÍ...").addClass('placeHolder');
	
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
	
	if($('.filtro1Principal input').val() ==''){
		div_botonesP.hide();
		$('#addPacientePrincipal').hide();
	}else{
		div_botonesP.show();
		$('#addPacientePrincipal').show();
	}
	
	paginacionesP.hide();
	
	search_boxP.focus();
	
	search_boxP.keyup(function(e) {
    	if( $(this).val() == '' ){
			$('#filtro').val('YO SOLO SE QUE NO SE NADA');
			div_botonesP.hide();
			$('#addPacientePrincipal').hide();
			oTableP.fnDraw();
		}else {
			$('#filtro').val('%%');
			div_botonesP.show();
			$('#addPacientePrincipal').show();
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
	var he1 = $('#referencia').height() - 100, wi1 = $('#referencia').width() * 0.97;
	
	$('#dialog-confirmaAltaPaciente').dialog({
		autoOpen: false, modal: true, width: 620, height:150, title: 'DATOS GUARDADOS', closeText: '',
		open:function( event, ui ){ window.setTimeout(function(){$('#dialog-confirmaAltaPaciente').dialog('close');},2500); }
	});
	
    $('#dialog-verPaciente').dialog({
		autoOpen: false, modal: true, width: wi1, height: he1, title: 'FICHA DEL CONVENIO', closeText: ''
	});
	
});
</script>