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
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
  	if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
	  $theValue =function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
	
	  switch ($theType) {
		case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
		case "long":
		case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
		case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
		case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
		case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
	  }
	  return $theValue;
	}
}

if (isset($_SESSION['MM_Username'])) { $colname_usuario = $_SESSION['MM_Username']; }
mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT id_u, nombre_u, apaterno_u, amaterno_u, idSucursal_u, usuario_u, idDepartamento_u, idPuesto_u, acceso_u, sexo_u, foto_u, nombreFoto_u FROM usuarios WHERE usuario_u = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error()); $row_usuario = mysql_fetch_assoc($usuario); $totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombreSucursalUsuario = sprintf("SELECT nombre_su FROM sucursales WHERE clave_su = %s", GetSQLValueString($row_usuario['idSucursal_u'], "text"));
$nombreSucursalUsuario = mysql_query($query_nombreSucursalUsuario, $horizonte) or die(mysql_error()); $row_nombreSucursalUsuario = mysql_fetch_assoc($nombreSucursalUsuario); $totalRows_nombreSucursalUsuario = mysql_num_rows($nombreSucursalUsuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombreDepartamentoUsuario = sprintf("SELECT nombre_d FROM departamentos WHERE id_d = %s", GetSQLValueString($row_usuario['idDepartamento_u'], "int"));
$nombreDepartamentoUsuario = mysql_query($query_nombreDepartamentoUsuario, $horizonte) or die(mysql_error()); $row_nombreDepartamentoUsuario = mysql_fetch_assoc($nombreDepartamentoUsuario); $totalRows_nombreDepartamentoUsuario = mysql_num_rows($nombreDepartamentoUsuario);
?>

<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../imagenes/favicon.ico">
<meta charset="utf-8">
<title>PACIENTES</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link href="../DataTables-1.10.5/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script src="../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.5/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/calcula_edad.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/redondea.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../funciones/js/stdlib.js"></script>
<script src="../funciones/js/generador_rfc.js"></script>
<script src="../funciones/js/cantidad_a_letra.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../chart_1.0.2/Chart.min.js"></script>
<script src="../funciones/js/jquery.media.js"></script> 
<script src="../funciones/js/jquery.fileDownload.js"></script>
<script src="../jq-file-upload-9.12.5/js/jquery.iframe-transport.js"></script>
<script src="../jq-file-upload-9.12.5/js/jquery.fileupload.js"></script>
<script src='../tinymce/tinymce.min.js'></script>

<script>
$(document).tooltip({position:{my:"center bottom-10",at:"center top",using:function(position,feedback){$(this).css(position);}}});

$(document).ready(function(e) {
	//Refrescamos la sesión para que no caduque, aunque no se refresque la ventana
	setInterval(function(){$.post('../remote_files/refresh_session.php'); },500000);
	
	$('#dialog-desaignaConvenio').dialog({ autoOpen:false});
	$('#formNM').validate({ ignore: 'hidden', focusCleanup: true,
		rules:{ idNM:{ required:true, remote:{ url: '../usuarios/files-serverside/checkClaveUsuario.php?idU='+$('#idPacienteN').val(), type: "post", data: { clave:function(){ return $('#idNM').val(); } } }, minlength: 4 } },
		messages:{ idNM:{ required: 'Se debe ingresar el identificador del médico.', remote:'Este identificador ya está en uso, favor de intentar con otro.', minlength:'El identificador consta de 4 caracteres' } }
	});
	
	$('#idNM').keyup(function(e) {
		var x=$(this).val();
			if( x.length>3 & x.length<5 ){
				var claveUsuario1 = $('#idNM').val(); var datoU ={ claveUsuario1:claveUsuario1}
				$.post('../usuarios/files-serverside/disponibleClaveUsuario.php',datoU).done(function( data ) {
					if (data == 1){
						$('#textoClaveUsuarioDisponible').text('Disponible');$('#textoClaveUsuarioDisponible').addClass('textoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoNoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoAlerta');
						$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-alert'); $('#iconoClaveUsuario').removeClass('ui-icon ui-icon-closethick'); $('#iconoClaveUsuario').addClass('ui-icon ui-icon-check');
					}else{
						$('#textoClaveUsuarioDisponible').text('No Disponible');$('#textoClaveUsuarioDisponible').addClass('textoNoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoAlerta');
						$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-alert'); $('#iconoClaveUsuario').removeClass('ui-icon ui-icon-check'); $('#iconoClaveUsuario').addClass('ui-icon ui-icon-closethick');
					}
				});
			}else{
				$('#textoClaveUsuarioDisponible').text('Muy Corto');$('#textoClaveUsuarioDisponible').addClass('textoAlerta'); $('#iconoClaveUsuario').addClass('ui-icon ui-icon-alert');$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-closethick');
				$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-check');
			}
			if(x.length<=3){ $('#textoClaveUsuarioDisponible').removeClass('textoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoNoAceptable'); $('#iconoClaveUsuario').addClass('ui-icon ui-icon-alert'); }
			if(x.length==0){ $('#textoClaveUsuarioDisponible').text('Vacío');}
	});
		
	cargaFicha();
		
	$('#dialog-nadaOV').dialog({ autoOpen: false, modal: true, closeOnEscape: true, width: 500, height:200, 
		title: 'REVISE LA ORDEN DE VENTA', closeText: '', dialogClass: 'no-close', 
		buttons: { Cerrar: function() {  $('#dialog-nadaOV').dialog('close'); } } 
	});
	
	$('#addMedico').button({ icons: { primary: "ui-icon-plusthick" }, text: true });
});

function eliminarConvenio(c,n){//c es el id de la asignación del convenio y n es el nombre del comvenio 
$(document).ready(function(e) { $('.convenioDC').text(n);
	$('#dialog-desaignaConvenio').dialog({
		autoOpen: true, modal: true, closeOnEscape: false, width: 700, height:250, title: 'DESASIGNAR EL BENEFICIO AL PACIENTE',
		closeText: '', dialogClass: 'no-close',
		close:function(event, ui){$('#miClick1').click();$('#dialog-desaignaConvenio').dialog('destroy');$('#clickme').click(); },
		buttons: {
			Desasignar: function() {
				var datosDC = {dc:c}
				$.post('files-serverside/desasignaConvenio.php', datosDC).done(function( data ) { if(data==1){ 
					$('#dialog-desaignaConvenio').dialog('close'); $('#miClick1c').click();
				}else{alert(data);} });
			},
			Cancelar: function() {  $('#dialog-desaignaConvenio').dialog('close'); }
		}
	});
}); }

function cargaFicha(){
$(document).ready(function(e) {
    $("#dialog-verPaciente").load('htmls/paciente.php #fichaPaciente', function( response, status, xhr ){
		//función que carga el contenido de toda la ficha del paciente y sus valores iniciales
		if ( status == "success" ) {
			$('#formGenerales').validate({ ignore: '.ignore, :hidden', 
				rules:{ 
					curpP:{ required:false, minlength: 18, maxlength: 18, 
						"remote": { url: 'files-serverside/checkCurp.php', type: "post", 
							data: { curpP:function() { return $('#curpP').val(); } }, 
							data: { idP:function() { return $('#idPacienteN').val(); } } 
						} 
					} 
				},
				messages:{ 
					curpP:{ 
						required:'Debe ingresar la CURP del paciente.', minlength:'La CURP debe ser de 18 dígitos.', 
						maxlength:'La CURP debe ser de 18 dígitos.', 
						remote:'¡Esta CURP pertenece a otro paciente, favor de verificar!' 
					} 
				}
			});	
			$('#form-asignaC').validate({});
			
			var he = $('#referencia').height() - 200, wi = $('#referencia').width() * 0.98;
			
			$("#dialog-verPaciente").tabs({active: 0}); 
						
			//inicializamos el formulario del paciente
			$('.4d').hide();
			$("#bancoPF").load("genera/bancos.php", function(response,status,xhr){ if(status=="success"){ 
				$('#bancoPF').change(function(e) {
					if($(this).val()!=''){ $('.4d').show(); $('#digitos4B').focus(); } else{ $('.4d').hide(); }
				});
			} });
			
			$('#agregarMunicipio, #agregarMunicipioF').click(function(e) {
				$("#dialog-nuevo").load("htmls/nuevo_municipio.php #form-muni", function( response, status, xhr ) { 
				if ( status == "success" ) { 
					$('#form-muni input, #form-muni select, #form-muni textarea').addClass('campoITtab');
					$('#dialog-nuevo').dialog({
						title:'AGREGAR UN NUEVO MUNICIPIO AL SISTEMA',modal:true,autoOpen:true,closeText:'',width:800,height:370,
						closeOnEscape:true,dialogClass:'',
						open:function(event,ui){ $('#id_u_nmuni').val($('#idUser').val()); $('#nombre_nm').prop('disabled',true);
							$('#form-muni').validate({
								rules:{ 
									nombre_nm:{ 
										required:true, 
										remote:{ 
											url: 'files-serverside/checkNombreMuni.php', 
											type: "post", 
											data: { 
												nombreM:function(){ return $('#nombre_nm').val(); }, 
												estado:function(){ return $('#estadoNM').val(); } 
											} 
										} 
									} 
								},
								messages:{ 
									nombre_nm:{ 
										required: 'Se debe ingresar el nombre del municipio.', 
										remote:'Este municipio ya existe en ésta entidad federativa, favor de verificar.' 
									} 
								}
							}); 
							$("#estadoNM").load('files-serverside/genera_estados.php', function( response, status, xhr ) { if ( status == "success" ) {
								$("#estadoNM").change(function(e) { if($(this).val()!=''){$('#nombre_nm').prop('disabled',false);}else{$('#nombre_nm').val('');$('#nombre_nm').prop('disabled',true);} });
								$('#nombre_nm').keyup(function(e) {if($('#form-muni').valid()){} });
							} });
						},
						close:function(event,ui){ document.getElementById('form-muni').reset(); $("#dialog-nuevo").empty();},
						buttons:{
							"Guardar": function() {
								if( $('#form-muni').valid() ){
									var datosMuni = $('#form-muni').serialize(); 
									$.post('files-serverside/guardarMuni.php',datosMuni).done(function(data){ if(data == 1){ 
										$("#estadoP").change();
										$('#texto-informar').text('¡El nuevo municipio se ha guardado satisfactoriamente!');
										$('#dialog-informar').dialog({
											autoOpen:true,modal:true, width:600, height:200,title:'DATOS GUARDADOS', closeText:'',
											open:function( event, ui ){ 
												$('#dialog-nuevo').dialog('close'); 
												window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000); 
											}
										});
									}else{alert(data);} });
								}
							},
							"Cancelar": function() { $('#dialog-nuevo').dialog('close'); }
						}
					}); //fin de dialog-nuevo
				} });//fin de load
            });
			$('#agregarColonia, #agregarColoniaF').click(function(e) {
				$("#dialog-nuevo").load("htmls/nuevo_municipio.php #form-col", function( response, status, xhr ) { if ( status == "success" ) { $('#form-col input, #form-col select, #form-col textarea').addClass('campoITtab');
					$('#dialog-nuevo').dialog({
						title:'AGREGAR UNA NUEVA COLONIA Y CP AL SISTEMA',modal:true,autoOpen:true,closeText:'',width:800,height:400,closeOnEscape:true,dialogClass:'',
						open:function(event,ui){ 
							$('#id_u_nmuni').val($('#idUser').val()); $('#nombre_nc, #cp_n').prop('disabled',true);
							$('#form-col').validate({
								rules:{ 
								 cp_n:{ minlength: 5, required:true, remote:{ url: 'files-serverside/checkNombreColo.php', type: "post", 
								 	data: { cp_n:function(){ return $('#cp_n').val(); }, municipio:function(){ return $('#municipioNM').val(); }, colonia:function(){ return $('#nombre_nc').val(); } } 
								 } 
								}
								},
								messages:{ cp_n:{ required: 'Se debe ingresar el código postal de la colonia.', remote:'Esta combinación de colonia y código postal ya existe en éste municipio, favor de verificar.' } }
							}); 
							$("#estadoNM").load('files-serverside/genera_estados.php', function( response, status, xhr ) { if ( status == "success" ) {
								$("#estadoNM").change(function(e) { $('#municipioNM').change(); if($(this).val()!=''){ }else{$('#nombre_nc, #cp_n').val('');$('#nombre_nc, #cp_n').prop('disabled',true);}
									var id = $("#estadoNM").find(':selected').text();//alert(id);
									$("#municipioNM").load('files-serverside/genera_municipios.php?id='+escape(id), function( response, status, xhr ) {
										if ( status == "success" ) {
											$("#municipioNM").change(function(e) {
                                                if($(this).val()!=''){
													$('#nombre_nc, #cp_n').prop('disabled',false);
												}else{
													$('#nombre_nc, #cp_n').val('');$('#nombre_nc, #cp_n').prop('disabled',true);
												}
                                            });
										}
									}); 
								});
								$('#nombre_nc').keyup(function(e) {if($('#form-col').valid()){} });
							} });
						},
						close:function(event,ui){ document.getElementById('form-col').reset(); $("#dialog-nuevo").empty();},
						buttons:{
							"Guardar": function() {
								if( $('#form-col').valid() ){
									var datosColi = $('#form-col').serialize(); 
									$.post('files-serverside/guardarColo.php',datosColi).done(function(data){ if(data == 1){ 
										$("#estadoP").change();
										$('#texto-informar').text('¡La nueva colonia y código postal se han guardado satisfactoriamente!');
										$('#dialog-informar').dialog({
											autoOpen:true,modal:true,width:600, height:200, title:'DATOS GUARDADOS', closeText:'',
											open:function( event, ui ){ 
												$('#dialog-nuevo').dialog('close'); 
												window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000); }
										});
									}else{alert(data);} });
								}
							},
							"Cancelar": function() { $('#dialog-nuevo').dialog('close'); }
						}
					}); //fin de dialog-nuevo
				} });//fin de load
            });
			
			$('.rnacido').hide(); $( "#spinner" ).timespinner(); var current = $( "#spinner" ).timespinner( "value" ); 
			Globalize.culture( "de-DE" ); $( "#spinner" ).timespinner( "value", current );
			  $('#fnacP').datepicker({
				changeMonth: true, changeMonth: true, nextText: "Siguiente", prevText: "Anterior", showAnim : "slideDown",
				changeYear: true, maxDate: +0, minDate: -43800, dateFormat: "dd/mm/yy",
				dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ], 
				dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
				monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septimbre", "Octubre", "Noviembre", "Diciembre" ],
				monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
				"onSelect": function(date) { $('#edadP').val(calcular_edad(date)); 
					if($('#fnacP').val() == $('#today').val()){$('.rnacido').show();}else{$('.rnacido').hide();} 
				}
			}).css('text-align','center');
			$('.calendario').datepicker({
				changeMonth: true, changeMonth: true, nextText: "Siguiente", prevText: "Anterior", showAnim : "slideDown", changeYear: true, maxDate: +1850, minDate: -365, dateFormat: "dd/mm/yy",
				dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ], dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
				monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septimbre", "Octubre", "Noviembre", "Diciembre" ], monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
			}).css('text-align','center');
					
			$("#sexoP").load('files-serverside/genera_sexos.php');
			$("#tSangreP").load('files-serverside/genera_tsangre.php',function(response,status,xhr){if(status=="success") {} });
			$("#sucursalP").load('genera/genera_sucursales_ov.php?idU='+$('#idUser').val());
			$("#tsanguineoP").load('files-serverside/genera_tsangre.php');
			$("#centroSaludP").load('genera/centros_salud.php'); $("#derechohabienciaP").load('genera/derechohabiencia.php');
			
			$("#estadoP,#estadoPF").load('files-serverside/genera_estados.php',function(response,status,xhr){if(status=="success"){
				//Cargamos la sucursal heredada del usuario.
				$('#sucursalP').val($('#sucursalU').val());
				// aquí voy a meter lo de las funciones de calcular RFC y CURP
				$('#entidadNacimientoP').change(function(e) {
                    if($('#formGenerales').valid()){
						var nombreXX=$('#nombreP').val(),apaternoXX=$('#apaternoP').val(),splitNombres=$('#nombreP').val().split(" ");
						if (splitNombres[0] == 'JOSE' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'MARIA' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'MA.' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'MA' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'DE' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'LA' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'LAS' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'MC' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'VON' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'DEL' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'LOS' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'Y' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'MAC' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						if (splitNombres[0] == 'VAN' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
						
						var asa = $('#apaternoP').val();
						
						if($('#apaternoP').val()[0]=='Ñ'){ asa = asa.replace("Ñ", "X");} 
						
						$('#curpP').val((fnCalculaCURP(nombreXX,asa,$('#amaternoP').val(),$('#fnacP').val(),$('#sexoP').val(),$('#entidadNacimientoP').find(':selected').text()))); $('#rfcP').val($('#curpP').val().substr(0,10));
					}else{ }
                });
				$('#nombreP, #apaternoP, #amaternoP').keyup(function(e) {
                    if($('#nombreP').val()!='' & $('#apaternoP').val()!='' & $('#fnacP').val()!='' & $('#sexoP').val()!=''){ $("#entidadNacimientoP").load('files-serverside/genera_estadosEN.php', function( response, status, xhr ) { if ( status == "success" ) { } });
					}else{ 
						$("#entidadNacimientoP").load('files-serverside/genera_nada.php', function( response, status, xhr ) {});
						$('#curpP, #rfcP').val('');
					}
                });
				$('#fnacP, #sexoP').change(function(e) {
                    if($('#fnacP').val()!='' & $('#sexoP').val()!='' & $('#nombreP').val()!='' & $('#apaternoP').val()!=''){ 
						$("#entidadNacimientoP").load('files-serverside/genera_estadosEN.php', function( response, status, xhr ) {
							if ( status == "success" ) { } 
						});
					}else{ 
						$("#entidadNacimientoP").load('files-serverside/genera_nada.php', function( response, status, xhr ) {});
						$('#curpP, #rfcP').val('');
					}
                });
				//Fin funciones calcular rfc y crup
				
				$("#estadoP").change(function(event){ $('#municipioP, #coloniaP').change();
					var id = $("#estadoP").find(':selected').text();//alert(id);
					$("#municipioP").load('files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr) {
					if ( status == "success" ) {
						if ($("#estadoP").val()==''){
							var id1x = $("#estadoP").find(':selected').text();
							var idx = $("#municipioP").find(':selected').text();
							var id3 = $("#coloniaP").find(':selected').text();
							$("#coloniaP").load('files-serverside/genera_colonias.php?idM='+escape(idx)+'&idE='+escape(id1x));
							$("#cpP").load('files-serverside/genera_cp.php?idC='+escape(id3)+'&idE='+escape(id1x)+'&idM='+escape(idx));
						}
					} });
				});
				$("#estadoPF").change(function(event){ $('#municipioPF, #coloniaPF').change();
					var idF = $("#estadoPF").find(':selected').text();//alert(id);
					$("#municipioPF").load('files-serverside/genera_municipios.php?id='+escape(idF),function(response,status,xhr){
					if ( status == "success" ) {
						if ($("#estadoPF").val()==''){
							var id1xF = $("#estadoPF").find(':selected').text();
							var idxF = $("#municipioPF").find(':selected').text();
							var id3F = $("#coloniaPF").find(':selected').text();
							$("#coloniaPF").load('files-serverside/genera_colonias.php?idM='+escape(idxF)+'&idE='+escape(id1xF));
							$("#cpPF").load('files-serverside/genera_cp.php?idC='+escape(id3F)+'&idE='+escape(id1xF)+'&idM='+escape(idxF));
						}
					} });
				});
			} });
			
			$("#municipioP").change(function(event){ $('#coloniaP').change();
				var id = $("#municipioP").find(':selected').text();var id1 = $("#estadoP").find(':selected').text();
				$("#coloniaP").load('files-serverside/genera_colonias.php?idM='+escape(id)+'&idE='+escape(id1));
				if ($("#municipioP").val()==''){
					var id1 = $("#estadoP").find(':selected').text();
					var id2 = $("#municipioP").find(':selected').text();
					var id3 = $("#coloniaP").find(':selected').text();
					$("#cpP").load('files-serverside/genera_cp.php?idE='+escape(id1)+'&idM='+escape(id2)+'&idC='+escape(id3));
				}
			});
			$("#municipioPF").change(function(event){ $('#coloniaPF').change();
				var idF = $("#municipioPF").find(':selected').text();var id1F = $("#estadoPF").find(':selected').text();
				$("#coloniaPF").load('files-serverside/genera_colonias.php?idM='+escape(idF)+'&idE='+escape(id1F));
				if ($("#municipioPF").val()==''){
					var id1F = $("#estadoPF").find(':selected').text();
					var id2F = $("#municipioPF").find(':selected').text();
					var id3F = $("#coloniaPF").find(':selected').text();
					$("#cpPF").load('files-serverside/genera_cp.php?idE='+escape(id1F)+'&idM='+escape(id2F)+'&idC='+escape(id3F));
				}
			});
			$("#coloniaP").change(function(event){
				var idC = $("#coloniaP").find(':selected').text();var idE = $("#estadoP").find(':selected').text();
				var idM = $("#municipioP").find(':selected').text();
				$("#cpP").load('files-serverside/genera_cp.php?idC='+escape(idC)+'&idE='+escape(idE)+'&idM='+escape(idM));
			});
			$("#coloniaPF").change(function(event){
				var idCF = $("#coloniaPF").find(':selected').text();var idEF = $("#estadoPF").find(':selected').text();
				var idMF = $("#municipioPF").find(':selected').text();
				$("#cpPF").load('files-serverside/genera_cp.php?idC='+escape(idCF)+'&idE='+escape(idEF)+'&idM='+escape(idMF));
			});
			
			$('#ocupacionP').keyup(function(e) {
				var y=$(this).val();
				var b="files-serverside/genera_ocupaciones.php?ocupacion="+y;
				$("#ocupacionP").autocomplete({ source: b, minLength: 2 }); 
			});
			
			$("#viviendaP").load('files-serverside/genera_viviendas.php');
			$("#nsocioeconomicoP").load('files-serverside/genera_ns.php');
			$("#escolaridadP").load('files-serverside/genera_escolaridades.php');
			$("#religionP").load('files-serverside/genera_religiones.php');
			$("#etniaP").load('files-serverside/genera_etnias.php');
			$("#discapacidadP").load('files-serverside/genera_discapacidades.php');
			//finaliza la función que carga la ficha del paciente
			
			var cuadrado = 20; $('table button').css('min-width',cuadrado).css('min-height',cuadrado);
			
			$('form').submit(function(event) { event.preventDefault(); });
			
			$('#tabs-5-1').click(function(e) { 
				var oTableC1;
				oTableC1 = $('#dataTableC').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
					"bJQueryUI": true, ordering: false, "bRetrieve": true, "sScrollY": $('#contenedorTablaC').height()-50, 
					"bAutoWidth": true, "bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
					"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
					{ "bSortable": false }, { "bSortable": false }], "iDisplayLength": 30000, "bLengthChange": false, 
					"bProcessing": true, "bServerSide": true, "sAjaxSource": "js/datatable-serverside/convenios.php",
					"fnServerParams": function (aoData, fnCallback) { 
						var idP = document.getElementById('idPacienteN').value; aoData.push(  {"name": "idP", "value": idP } ); },
					"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>',"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
					"sZeroRecords": "EL PACIENTE NO CUENTA CON BENEFICIOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": 
					"MOSTRADOS: 0", "sInfoFiltered": "<br/>CONVENIOS: _MAX_", "sSearch": "BUSCAR" }
				});//fin datatable
				$('#miClick1').click(function(e) { oTableC1.fnDraw(); }); oTableC1.fnDraw(); $('.DataTables_sort_icon').remove();
			});
		}
	});//fin load
	$('#formGenerales input, #dialog-verPaciente select, #dialog-verPaciente textarea').addClass('campoITtab');
	return true;
}); }//fin ready //fin cargarFicha()

function cargaFoto(){$(document).ready(function(e) {
	$('#form-foto').submit(function(event) { event.preventDefault(); }); $('#form-foto').validate();
	'use strict'; //Para el upload // Change this to the location of your server-side upload handler:
	var ko = $('#idUser').val();
	var url = window.location.hostname === 'blueimp.github.io' ?
				'//jquery-file-upload.appspot.com/' : 'fotos/index.php?idU='+ko+'&idP='+$('#temporal_s').val()+'&nombreD='+escape($('#titulo_foto').val());
	$('#fileupload_foto').fileupload({
		url: url, dataType: 'json',
		submit:function (e, data) {
			$.each(data.files, function (index, file) {
				var input=$('#temporal_s'); 
				data.formData={
					titulo_d:input.val(),ext_d:file.name.split('.')[1],e:$('#nuevo_o_viejo_u').val(),noT:$('#temporal_s').val() 
				};
				$('#ext_foto').val(file.name.split('.')[1]);
			});
		},
		progress: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10); 
			$('#progress2 .bar').css('width',progress + '%');
		},
		done: function (e, data) { $('#nuevo_o_viejo_u').val(1);
			$('#dialog-nivel3').dialog({
				autoOpen:true, modal: true, width: 500, height:120, title: 'FOTOGRAFÍA CARGADA', closeText: '',
				open:function( event, ui ){
					$('#fotoU').val(1);
					$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡La fotografía se guardó satisfactoriamente!</h3></td></tr></table>');
					window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
					$('#progress2 .bar').css('width',0);
					//Aquí mostrar la foto
					var datos = {aleatorio:$('#temporal_s').val()}
					$.post('files-serverside/datosFoto.php',datos).done(function( data ){ 
						var t = "<div style='background-image:url(fotos/files/"+data+"."+$("#ext_foto").val()+"?"+Math.round(Math.random()*1000)+");background-size:contain;background-repeat:no-repeat;background-position:center;background-color:white; width:100%; height:100%; cursor:;' class='conFoto' onClick=''></div>";
						$('#foto_usuario').html(t);
					});
				}, close:function( event, ui ){ $("#dialog-nivel3").empty();$('#dialog-nivel3').dialog('destroy'); }, buttons:{ }
			});
		},
	}); //Para el upload
});}

function asignarConvenio(idC, nC){ $(document).ready(function(e) { //alert(nC);
	$('#idC_AC').val(idC); $('#convenioAC').val(nC); $('#dialog-asignacionConvenio').dialog('open'); 
}); }
</script>

<script>
  $.widget( "ui.timespinner", $.ui.spinner, {
	options: { step: 60 * 1000, /*seconds*/ page: 60 /*hours*/ },
	_parse: function( value ) { if ( typeof value === "string" ) { if ( Number( value ) == value ) { return Number( value ); } return +Globalize.parseDate( value ); } return value; },
	_format: function( value ) { return Globalize.format( new Date(value), "t" ); }
  });
</script>

<script>
function nuevoPaciente(){ $(document).ready(function(e) {
	siempre(18.8135, -98.9535);
	$('#idPacienteN').val('');
	var now = new Date().getTime(); var d = new Date(); $('#temporal_s').val(d.format('Y-m-d-H-i-s-u').substring(0,22));
	
	var he = $('#referencia').height() - $('#header').height()-50; var wi = $('#referencia').width()*0.98;
	
    $('#dialog-verPaciente').dialog({
		title: 'ALTA DE UN NUEVO PACIENTE, INGRESE LOS DATOS REQUERIDOS.', modal: true, autoOpen: false, closeText: '', 
		width: wi, height: he, closeOnEscape: false, dialogClass: 'no-close',
		buttons: { 
      },
	  open:function( event, ui ){
		$('#nuevo_o_viejo_u').val(0);
		$('#fotoU').val(0); $('#b_subir_foto').click(function(e){ $('#fileupload_foto').click(); });
		$('.t_uno').css('height',$('#dialog-verPaciente').height()-50);
		$('#pestanas1, #pestanas').removeClass('ui-widget-header');
		$('#nombreP').focus(); $('#tabs-1-1').click(function(e) { $('#nombreP').focus(); });
		$('#savePac,#cancelSavePac').button({});
		$('.botonesSaveP').show();
		$('.botonesUpdateP, .botonesTerapiaP').hide();
		$('#dialog-verPaciente input, #dialog-verPaciente select, #dialog-verPaciente textarea').addClass('campoITtab'); 
		$('.pActivo').show();$('#tabs-5-1, #tabs-4-1').hide();$('.idUsuarioP').val($('#idUser').val()); 
		
		$('#savePac').click(function(e) {
            if($('#formGenerales').valid()){ 
				var datosP = $('#formGenerales').serialize();
				$.post('files-serverside/addPaciente.php',datosP).done(function( data ) { 
					if (data==1){ 
						$('#dialog-verPaciente').dialog('close'); 
						$('#texto-informar').text('¡El nuevo paciente se ha guardado satisfactoriamente!');
						$('#dialog-informar').dialog({
							autoOpen: true, modal: true, width: 600, height:200, title: 'DATOS GUARDADOS', closeText: '',
							open:function( event, ui ){ $('#dialog-verPaciente').dialog('close'); 
							$('#clickme').click(); window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000); }
						});
					} 
					else{alert(data);} 
				});
			}
        });
		$('#cancelSavePac').click(function(e) { $('#dialog-verPaciente').dialog('close'); });
		var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {
			validateOn:["blur"], isRequired:false, useCharacterMasking:true
		});
		var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "phone_number", {
			validateOn:["blur"], isRequired:false, useCharacterMasking:true
		});
		var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "phone_number", {
			validateOn:["blur"], isRequired:false, useCharacterMasking:true
		});
		var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {
			validateOn:["blur", "change"], minChars:18, maxChars:18
		});
		$('#telmovilP, #telparticularP, #telefonoTrabajoP').focusout(function(e) { if($(this).val()=='('){$(this).val('');} }); 
		
	  }, close:function( event, ui ){ $( "#dialog-verPaciente" ).tabs("destroy");$('#dialog-verPaciente').empty();cargaFicha(); }
	});
	$('#dialog-verPaciente').dialog('open');
});/*Fin ready*/ }//Fin nuevoPaciente()

</script>

<script>
$(document).ready(function(e){
	$('#miMenu').hide(); $('#verMenu').click(function(e){window.location='../menu.php?menu=mr';}); 
	$("#upload").button({ icons: { primary: "ui-icon-image" }, text: true });
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
});
</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="sucursalU" type="hidden" id="sucursalU" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="indicePaciente" type="hidden" id="indicePaciente">
<input name="agendarOV" type="hidden" id="agendarOV" value="0">
<input name="sucursalOV" type="hidden" id="sucursalOV" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="today" id="today" type="hidden" value="<?php echo date("d/m/Y"); ?>"> <input name="filtro" id="filtro" type="hidden" value="YO SOLO SE QUE NO SE NADA">

<input name="precioTemp" id="precioTemp" type="hidden" value="0"> <input name="urgeAtender1" id="urgeAtender1" type="hidden" value="0"> <input name="contaItems" id="contaItems" type="hidden" value="0"><input name="estado_pago_ov" id="estado_pago_ov" type="hidden" value="0">

<div id="header" class="header">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_iconoPacientes.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">PACIENTES</span></td>
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

<div class="contenido" id="contenido" align="center" style="margin-top:43px;">
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2" id="dataTablePrincipal" class="tablilla"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr class="titulos_dataceldas">
    <th id="clickme"class="titulosTabs"align="center" nowrap width="10px"> <span title="VISITAS">VTS</span> </th>
    <th align="center" width="10px">FÓLIO</th>
    <th align="center">NOMBRE</th>
    <th align="center" width="70px" nowrap>EDAD</th>
    <th align="center" width="30" nowrap>SEX</th>
    <th align="center" width="110px">TELÉFONO</th>
    <th align="center" width="50px"><span title="SUCURSAL">SUC</span></th>
    <th align="center" width="5px"><span title="LISTA DE BENEFICIOS">BNFS</span></th>
    <th align="center" width="5px"><span title="ORDEN DE VENTA">OV</span></th>
    <th align="center" width="5px"><span title="FORMATOS">FMTS</span></th>
    <th align="center" width="5px"><span title="DOCUMENTOS">DOCS</span></th>
    <th align="center" width="5px"><span title="EVENTOS">EVTS</span></th>
    <th align="center" width="5px"><span title="UBICACIÓN">UBI</span></th>
    <th align="center" width="5px"><span title="EXPEDIENTE CLÍNICO ELECTRÓNiCO">ECE</span></th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr>
            <th><input name="sX" type="hidden" value=""></th>
            <th><input name="sFolio" id="sFolio" type="text" class="search_init campos_b_t" placeholder="-FOLIO-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sPaciente" id="sPaciente" type="text" class="search_init campos_b_t" placeholder="-PACIENTE-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sX1" type="hidden" value=""></th>
            <th><input style="width:40px" name="sSexo" id="sSexo" type="text" class="search_init campos_b_t" placeholder="-SEX-" onKeyUp="conMayusculas(this);"/></th>
            <th>
            <input name="sTeléfono" id="sTeléfono" type="text" class="search_init campos_b_t" placeholder="-TELÉFONO-" onKeyUp="conMayusculas(this);"/>
            </th>
            <th><input name="sUmedica" id="sUmedica" type="text" class="search_init campos_b_t" placeholder="-SUCURSAL-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sX2" type="hidden" value=""></th>
            <th><input name="sX3" type="hidden" value=""></th>
            <th><input name="sX4" type="hidden" value=""></th>
            <th><input name="sX5" type="hidden" value=""></th>
            <th><input name="sX6" type="hidden" value=""></th>
            <th><input name="sX7" type="hidden" value=""></th>
            <th><input name="sX8" type="hidden" value=""></th>
        </tr>
    </tfoot>
</table>
</div>

<div id="dialog-verPaciente" class="dialogos"> </div>

<div id="dialog-confirmarAlgo" class="dialogos"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2"> <tr> <td align="center" valign="middle"><span id="textoAlgo"></span></td> </tr> </table> </div>

<div id="dialog-buscarConvenio" class="dialogos"> </div>

<div id="dialog-asignacionConvenio" class="dialogos">
<form action="" method="post" style="height:100%;" name="form-asignaC" id="form-asignaC" target="_self">
<input name="idP_AC" id="idP_AC" class="idP_fichaP" type="hidden" value=""><input name="idU_AC" id="idU_AC" class="idU_fichaP" type="hidden" value="<?php echo $row_usuario['id_u']; ?>"><input name="idC_AC" id="idC_AC" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr align="left">
    <td class="" nowrap width="1%">Paciente</td>
    <td><input name="pacienteAC" id="pacienteAC" type="text" readonly></td>
  </tr>
  <tr align="left">
    <td class="" nowrap>Beneficio</td>
    <td><input name="convenioAC" id="convenioAC" type="text" readonly></td>
  </tr>
  <tr align="left">
    <td class="" nowrap>Fecha expedición</td>
    <td><input class="calendario required" name="fechaIC" id="fechaIC" type="text" value="<?php echo date("d/m/Y"); ?>"></td>
  </tr>
  <tr align="left">
    <td class="" nowrap>Fecha expiración</td>
    <td><input class="calendario required" name="fechaFC" id="fechaFC" type="text" ></td>
  </tr>
</table>
</form>
</div>

<div id="dialog-nuevaVisita" class="dialogos"> </div>

<div id="dialog-buscaMedico" title="BUSCAR MÉDICO" class="dialogos"> </div>

<div id="dialog-buscarItems" title="BUSCAR/AGREGAR ITEMS" class="dialogos"> </div>

<div id="dialog-confirmaciones" class="dialogos"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" valign="middle" height="100%"><span id="texto-confirmaciones">GUARDADO SATISFACTORIAMENTE</span></td></tr></table></div>

<div id="dialog-confirmacion" class="dialogos">
<p class="textoMsjConfirmacion">¡LA ORDEN SE HA REGISTRADO CORRECTAMENTE!</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><input name="contadorX" id="contadorX" type="hidden"> <tr>
    <td><span id="imprimeTicket" class="miRecibo" style="cursor:pointer; font-style:italic; color:rgba(255,0,0,0.9); display:none; text-decoration:underline;">IMPRIMIR TICKET</span></td>
    <td><span class="miRecibo" style="cursor:pointer; font-style:italic; color:rgba(255,0,0,0.9); display:none; text-decoration:underline;">IMPRIMIR HOJA</span></td>
</tr> </table>
</div>

<div id="dialog-desaignaConvenio" class="dialogos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3"> 
	<tr> 
    	<td align="center">¿CONFIRMAR DESASIGNAR EL BENEFICIO <span class="convenioDC" style="text-decoration:underline;"></span> AL PACIENTE?</td> 
    </tr> 
</table>
</div>

<div id="dialog-confirmacion1" class="dialogos"> <p class="textoMsjConfirmacion1">Guardando Datos...</p> ¡Por favor espere! </div>

<div id="ticket" class="dialogos" style="color:black;"></div>
<div id="remision" class="dialogos" style="color:black;"></div>

<div id="dialog-agregarM" class="dialogos"> </div>

<div id="dialog-confirmarNM" class="dialogos"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3"> <tr> <td>EL NUEVO MÉDICO SE DIÓ DE ALTA SATISFACTORIAMENTE.</td> </tr> </table> </div>

<div id="dialog-conveniosP" class="dialogos"> </div>

<div id="dialog-preguntar" class="dialogos"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3"> <tr> <td align="center"><span id="textoPreguntar">¿ESTA SEGURO QUE</span></td> </tr> </table></div>

<div id="dialog-nadaOV" class="dialogos"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3"> <tr> <td align="left">AÚN NO SE PUEDE GUARDAR LA ORDEN DE VENTA, DEBE AGREGAR ALGÚN CONCEPTO.</td> </tr> </table></div>

<div id="dialog-nuevo" class="dialogos"> </div>

<div id="dialog-informar" class="dialogos"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="middle" height="100%"><span id="texto-informar"></span></td></tr></table></div>

<div id="dialog-historial" class="dialogos"> </div>

<div id="dialog-rDX" class="dialogos"> </div>

<div id="dialog-indicacionesLab" class="dialogos">
	<div id="indicacionesLabo">
    <table width="100%" border="0" cellspacing="0" cellpadding="8">
      <tr>
        <td colspan="2" align="center" height="30px">INDICACIONES PARA LOS ESTUDIOS DE LABORATORIO</td>
      </tr>
      <tr>
        <td align="left">PACIENTE: <span id="pacienteIL"></span></td>
        <td width="190px">FECHA: <span id="fechaIL"></span></td>
      </tr>
    </table>
	<table width="100%" cellspacing="0" id="dataTableIL" height="" border="0" cellpadding="4" class="">
        <thead>
            <tr style="color:; background-color:; font-size:0.9em;">
                <th align="center" id="miClickIL" style="color:white;" width="20px" nowrap>#</th>
                <th align="center" style="color:white;">INDICACIÓN</th>
            </tr>
        </thead>
        <tbody align="left" style="font-size:0.7em;" class="color_cuerpo_tabla"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    </table>
	</div>
</div>

<div id="dialog-historialPagos" class="dialogos"> 
<table width="100%" cellspacing="0" id="dataTableHP" height="100%" border="0" cellpadding="5" class="tablilla">
    <thead>
        <tr style="color:; background-color:#fc673d; font-size:0.9em;">
            <th align="center" id="miClickHP" style="color:white;" width="10px">#</th>
            <th align="center" style="color:white;" width="40px">FECHA</th>
            <th align="center" style="color:white;" width="">USUARIO</th>
            <th align="center" style="color:white;" width="70px">TOTAL $</th>
            <th align="center" style="color:white;" width="110px">ABONADO $</th>
            <th align="center" style="color:white;" width="90px">SALDO $</th>
            <th align="center" style="color:white;" width="40px">TICKET</th>
        </tr>
    </thead>
    <tbody align="left" style="font-size:0.7em;" class="color_cuerpo_tabla"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
</table>
</div>

<div id="dialog-cancelOV" class="dialogos">
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3"> 
    <tr> <td align="center">¿ESTÁ SEGURO QUE DESEA ELIMINAR LA ORDEN DE VENTA <span id="refCancelOV"></span>?</td> </tr>
    <tr> <td align="center">
    	<span style="float:left">Confirmar <input name="confirmaCOV" id="confirmaCOV" type="checkbox" value=""></span>
        <span id="debeConfirmarCOV" style="font-size:0.8em; color:red; display:none;">¡Debe confirmar!</span>
    </td> </tr> 
    </table>
</div>

<div id="dialog-eliminarItem" class="dialogos">
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3"> 
    <tr> <td align="center">¿ESTÁ SEGURO QUE DESEA ELIMINAR EL CONCEPTO <span class="cancelar_algo" id="conceptoCancel"></span> LA ORDEN DE VENTA <span class="refCancelOV cancelar_algo"></span>?</td> </tr>
    <tr> <td align="center" nowrap>
    	<span style="float:left"><form action="" method="post" name="form-eliminarItem" id="form-eliminarItem" target="_self">Confirmar <input name="confirmaCOV1" id="confirmaCOV1" type="checkbox" value=""></form></span>
        <span id="debeConfirmarCOV1" style="font-size:0.8em; color:red; display:none;">¡Debe confirmar!</span>
    </td> </tr> 
    </table>
</div>

<div id="dialog-confirmarCOV" class="dialogos"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3"> <tr> <td>LA ORDEN DE VENTA SE HA CANCELADO SATISFACTORIAMENTE.</td> </tr> </table> </div>

<div id="dialog-terapia" class="dialogos">
	<form action="" style="height:100%;" method="post" name="form-terapia" id="form-terapia" target="_self">
    <input class="required" name="id_paciente_tera" id="id_paciente_tera" type="hidden" value="">
    <input class="required" name="id_usuario_tera" id="id_usuario_tera" type="hidden" value="">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
    	<tr height="1%">
        	<td align="left">Indique el motivo por el cuál el paciente quiere entrar a un programa de terápia</td>
        </tr>
        <tr> 
        	<td align="left">
            <textarea class="required" name="motivo_tera" id="motivo_tera" cols="20" rows="3" style="resize:none; height:300; width:98%" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></textarea>
            </td> 
        </tr>
    </table>
    </form> 
</div>

<div id="dialog-confirmar" class="dialogos"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2"> <tr> <td>LA OPERACIÓN DE HA REALIZADO SATISFACTORIAMENTE.</td> </tr> </table> </div>

<div id="dialog-nivel1" class="dialogos"> </div>
<div id="dialog-nivel2" class="dialogos" align="left"> </div>
<div id="dialog-nivel3" class="dialogos"> </div>

<input name="miFacturados" id="miFacturados" type="hidden" value="0,1">
<input name="miSaldazos" id="miSaldazos" type="hidden" value="0">

</body>
</html>

<?php mysql_free_result($usuario); mysql_free_result($nombreSucursalUsuario); mysql_free_result($nombreDepartamentoUsuario); ?>

<script type="text/javascript">
function asigna_evento(idE,nombreE){
	$('#dialog-nivel2').dialog({
		autoOpen: true, modal: true, width: 700, height:200, title: nombreE, closeText: '',
		open:function( event, ui ){
			$("#dialog-nivel2").html('<table height="100%" width="100%" border="0" cellspacing="2" cellpadding="2"> <tr> <td><h3>¿Desea asignar un evento de <span style="text-decoration:underline;" id="mi_evento_a"></span> al paciente?</h3></td></tr></table>');
			$('#mi_evento_a').text(nombreE).css('text-transform','lowercase');
			switch(nombreE){
				case 'PLAN DE REHABILITACION':
					$('#dialog-nivel2').dialog({
						buttons:{
							"Si":function(){
								$('#id_paciente_tera').val($('#idP_evento').val());$('#id_usuario_tera').val($('#idUser').val());
								$('#dialog-terapia').dialog('open');
							},
							"Cancelar":function(){$('#dialog-nivel2').dialog('close');}
						}
					});
				break;
				case 'HOSPITALIZACION':
					$('#dialog-nivel2').dialog({
						buttons:{
							"Cerrar":function(){$('#dialog-nivel2').dialog('close');}
						}
					});
				break;
				default:
					alert('ERROR');
			}
		},
		close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); },
		buttons:{}
	});
}
function crear_formato(nameF, idF, idP){ //alert($('#idP_formatos').val());
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel2').dialog({
		autoOpen: true, modal: true, width: w, height:h, title: nameF, closeText: '',
		open:function( event, ui ){
			var datosT = {idP:idP,idU:$('#idUser').val()}
			$.post('files-serverside/cat_texts.php',datosT).done(function(dataT){ var datosTe = dataT.split('-{]');
				var alergiasx = datosTe[0], adiccionesx = datosTe[1], tel_particular_px = datosTe[2];
				var direccion_px = datosTe[3], edadx = datosTe[4], escolaridadx = datosTe[5], fnacx = datosTe[6];
				var fecha_actualx = datosTe[7], fecha_actual_completax = datosTe[8], historia_clinicax = datosTe[9];
				var lugar_nacimientopx = datosTe[10], nombre_pacientex = datosTe[11], peso_tallax = datosTe[12];
				var nombre_sucux = datosTe[13], religionpx = datosTe[14], sexox = datosTe[15], tipo_sangrepx = datosTe[16];
				
				var datos = {idNM:idF}
				$.post('files-serverside/textoNotaM.php',datos).done(function(data){ //alert(data);
					data = data.replace(/{et_alergias}/gi, alergiasx);
					data = data.replace(/{et_adicciones}/gi, adiccionesx);
					data = data.replace(/{et_telefono_particular_paciente}/gi, tel_particular_px);
					data = data.replace(/{et_direccion_paciente}/gi, direccion_px);
					data = data.replace(/{et_edad}/gi, edadx);
					data = data.replace(/{et_escolaridad_paciente}/gi, escolaridadx);
					data = data.replace(/{et_fechanacimiento}/gi, fnacx);
					data = data.replace(/{et_fechaactual}/gi, fecha_actualx);
					data = data.replace(/{et_fechahora}/gi, fecha_actual_completax);
					data = data.replace(/{et_historia_clinica}/gi, historia_clinicax);
					data = data.replace(/{et_lugar_nacimiento_paciente}/gi, lugar_nacimientopx);
					data = data.replace(/{et_nombre_paciente}/gi, nombre_pacientex);
					data = data.replace(/{et_pesotalla_g}/gi, peso_tallax);
					data = data.replace(/{et_nombre_sucu}/gi, nombre_sucux);
					data = data.replace(/{et_religion_paciente}/gi, religionpx);
					data = data.replace(/{et_sex}/gi, sexox);
					data = data.replace(/{et_tipo_sanguineo}/gi, tipo_sangrepx);
					tinymce.remove("#input");
					$('#dialog-nivel2').html('<textarea name="input" id="input" style="resize:none;">'+data+'</textarea>');
					tinymce.init({ 
						selector:'#dialog-nivel2 #input',resize:false,height:$('#dialog-nivel2').height()*0.83,theme: "modern",
						plugins: 
							"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, responsivefilemanager, code, importcss",
						relative_urls: true,
						filemanager_title:"Administrador de archivos",
    					filemanager_crossdomain: true,
						external_filemanager_path:"../tinymce/plugins/responsivefilemanager/filemanager/",
					    external_plugins: { "filemanager" : "../tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js"},
						image_advtab: true,
						menubar: false, plugin_preview_width: $('#dialog-nivel2').width()*0.8,
						toolbar: 
							"undo redo | insert | styleselect | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink anchor | forecolor backcolor  | print_ preview code_ | emoticons_ | table | responsivefilemanager_",
						insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
						paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
					});
				});
			});
		},
		close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); },
		buttons:{
			"Imprimir":function(){
				var datos = {idU:$('#idUser').val(), input:tinyMCE.get('input').getContent()}
				$.post('files-serverside/procesarPDF.php', datos).done(function(data){
					if(data==1){
						$.post('files-serverside/imprimirFormatoPDF.php?idU='+$('#idUser').val()).done(function(data){
						  var pusha={iduL:escape($('#idUser').val())}
						  $("#dialog-nivel2").load('htmls/frame_pdf_formato.php',pusha,function(response,status,xhr){});
						});
				 	}
				 	else{alert(data);}
				});
			}, "Cerrar":function(){$('#dialog-nivel2').dialog('close');}
		}
	});
}
			
function formatos(idP,nameP){$(document).ready(function(e){
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel1').dialog({
		autoOpen: true, modal: true, width: w, height:h, title: 'CREAR UN FORMATO PARA EL PACIENTE '+ nameP, closeText: '',
		open:function( event, ui ){
			$("#dialog-nivel1").load("htmls/formatos.php",function(response,status,xhr){if(status=="success"){
				$('#idP_formatos').val(idP);
				var h1 = $("#dialog-nivel1").height();
				var oTableFO = $('#dataTableFormatos').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
					"bJQueryUI": true, "bRetrieve": true, "sScrollY": h1-40, "bAutoWidth": true, "bStateSave": false, 
					"bInfo": true, "bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
					"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
					"iDisplayLength": 300, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
					"sAjaxSource": "datatable-serverside/dt_formatos.php",
					"fnServerParams":function(aoData, fnCallback){var idPa = idP;aoData.push({"name":"idP","value":idPa});}, 
					"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page",
					"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
					"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>FORMATOS: _MAX_", 
					"sSearch": "BUSCAR" }
				});//fin datatable
				$('.DataTables_sort_icon').remove();
			} });
		},
		close:function( event, ui ){ $("#dialog-nivel1").empty(); $('#dialog-nivel1').dialog('destroy'); },
		buttons:{ "Cerrar":function(){$('#dialog-nivel1').dialog('close');} }
	});
});}

function ver_documento(idDoc, docu, tipo, exte, time){ //alert(exte);
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel2').dialog({
		autoOpen: true, modal: true, width: w, height:h, title: ''+ docu, closeText: '',
		open:function( event, ui ){
			$("#dialog-nivel2").load('htmls/miPDFdocs.php #tablaMiPDF', function( response, status, xhr ) { 
				if ( status == "success" ) {
					if(tipo == 1){
						x='documentos/files/'+idDoc+'.'+exte+'?'+time;
						$('#mi_documento').html('<img src='+x+' style="max-width:750px; border:5px solid white; border-radius:4px; background-color:rgba(255, 255, 255, 1);">');
					}else{
						x='documentos/files/'+idDoc+'.pdf';
						$('#mi_documento').html('<a class="media" href=""> </a>');
						$('a.media').media({width:890, height:h-136, src:x});	
					}
				}
			});
		}, close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); },
		buttons:{
			"Imprimir":function(){$('#dialog-nivel2 #tablaMiPDF').printElement();},
			"Cerrar":function(){$('#dialog-nivel2').dialog('close');}
		}
	});
}

function documentos(idP,nameP){$(document).ready(function(e){
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel1').dialog({
		autoOpen: true, modal: true, width: w, height:h, title: 'DOCUMENTOS DEL PACIENTE '+ nameP, closeText: '',
		open:function( event, ui ){
			$("#dialog-nivel1").load("htmls/documentos.php #dataTableDocumentos",function(response,status,xhr){
				if(status == "success"){
					$('#idP_documento').val(idP);
					var h1 = $("#dialog-nivel1").height();
					//para fintro individual por campo de texto
					var asInitValsD = new Array();
					var oTableFO = $('#dataTableDocumentos').dataTable({
						"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
						"bJQueryUI": true, "bRetrieve": true, "sScrollY": h1-80, "bAutoWidth": true, "bStateSave": false, 
						"bInfo": true, "bFilter": true, "aaSorting": [[0, "asc"]], ordering: false,
						"aoColumns":[{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false}],
						"iDisplayLength": 300, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
						"sAjaxSource": "datatable-serverside/dt_documentos.php",
						"fnServerParams":function(aoData,fnCallback){var idPaD=idP; aoData.push({"name":"idP","value":idPaD}); }, 
						"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', 
						"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
						"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page",
						"sZeroRecords": "-EL PACIENTE NO CUENTA CON DOCUMENTOS-", 
						"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DOCUMENTOS: _MAX_", 
						"sSearch": "BUSCAR" }
					});//fin datatable
					$('.DataTables_sort_icon').remove();
					$('#clickmeDocs').click(function(e) { oTableFO.fnDraw(); });
					//para los fintros individuales por campo de texto
					$("tfoot input.documento_b").keyup(function(){/* Filter on the column (the index) of this element */ 
						oTableFO.fnFilter( this.value, $("tfoot input.documento_b").index(this) ); 
					});
					/* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
					$("tfoot input.documento_b").each( function (i) { asInitValsD[i] = this.value; } );
					 
					$("tfoot input.documento_b").focus( function () { 
						if ( this.className == "search_init" ) { this.className = ""; this.value = "";} 
					} );
					 
					$("tfoot input").blur( function (i) { 
						if ( this.value == "" ) { 
							this.className="search_init";
							this.value=asInitValsD[$("tfoot input.documento_b").index(this)];
						} 
					} );
					//fin filtros individuales por campo de texto
				}
			});
		},
		close:function( event, ui ){ $("#dialog-nivel1").empty(); $('#dialog-nivel1').dialog('destroy'); },
		buttons:{
			"Subir documento":function(){
				$('#dialog-nivel2').dialog({
					autoOpen:true,modal:true,width:800,height:300,title:'SUBIR UN DOCUMENTO DEL PACIENTE '+nameP,closeText:'',
					open:function( event, ui ){
						$("#dialog-nivel2").load("htmls/subir_documento.php #documento",function(response,status,xhr){
							if(status == "success"){
								$('#form-documento').submit(function(event) { event.preventDefault(); });
								$('#form-documento').validate();
									$('#fileupload').addClass('ui-state-disabled');
									$('#titulo_d').keyup(function(e) {//$('#fileupload').valid();
                                        if($(this).val()!=''){$('#fileupload').removeClass('ui-state-disabled');}
										else{$('#fileupload').addClass('ui-state-disabled');}
                                    });
									//Para el upload
									'use strict';
									// Change this to the location of your server-side upload handler:
									var ko = $('#idUser').val();
									var url = window.location.hostname === 'blueimp.github.io' ?
												'//jquery-file-upload.appspot.com/' : 'documentos/index.php?idU='+ko+'&idP='+idP+'&nombreD='+escape($('#titulo_d').val());
									$('#fileupload').fileupload({
										url: url, dataType: 'json',
										submit:function (e, data) {
											$.each(data.files, function (index, file) {
												var input = $('#titulo_d');
												data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
											});
										},
										progress: function (e, data) {
											var progress = parseInt(data.loaded / data.total * 100, 10);
											$('#progress .bar').css(
												'width',
												progress + '%'
											);
										},
										done: function (e, data) {
											$('#dialog-nivel3').dialog({
												autoOpen: true, modal: true, width: 500, height:120, 
												title: 'DOCUMENTO GUARDADO', closeText: '',
												open:function( event, ui ){
													$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El documento se guardó satisfactoriamente!</h3></td></tr></table>');
													$('#dialog-nivel2').dialog('close');
													window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
												},
												close:function( event, ui ){ 
													$("#dialog-nivel3").empty(); $('#dialog-nivel3').dialog('destroy');
													$('#clickmeDocs').click();
												},
												buttons:{ }
											});
										},
									});
									//Para el upload
							}
						});
					},
					close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); },
					buttons:{
						"Cancelar":function(){$('#dialog-nivel2').dialog('close');}
					}
				});
			},
			"Cerrar":function(){$('#dialog-nivel1').dialog('close');}
		}
	});
});}

function eventos(idP,nameP){$(document).ready(function(e){
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel1').dialog({
		autoOpen: true, modal: true, width: w, height:h, title: 'EVENTOS PARA EL PACIENTE '+ nameP, closeText: '',
		open:function( event, ui ){
			$("#dialog-nivel1").load("htmls/eventos.php #dataTableEventos",function(response,status,xhr){
				if(status == "success"){
					$('#idP_evento').val(idP);
					var h1 = $("#dialog-nivel1").height();
					var oTableEV = $('#dataTableEventos').dataTable({
						"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
						"bJQueryUI": true, "bRetrieve": true, "sScrollY": h1-40, "bAutoWidth": true, "bStateSave": false, 
						"bInfo": true, "bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
						"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
						"iDisplayLength": 300, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
						"sAjaxSource": "datatable-serverside/dt_eventos.php",
						"fnServerParams":function(aoData, fnCallback){/*var idB = x;aoData.push({"name":"idB","value":idB});*/}, 
						"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', 
						"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
						"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page",
						"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
						"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>EVENTOS: _MAX_", 
						"sSearch": "BUSCAR" }
					});//fin datatable
					$('.DataTables_sort_icon').remove();
				} 
			});
		},
		close:function( event, ui ){ $("#dialog-nivel1").empty(); $('#dialog-nivel1').dialog('destroy'); },
		buttons:{ "Cerrar":function(){$('#dialog-nivel1').dialog('close');} }
	});
});}

function misPacientes(){ $(document).ready(function(e){
	window.setTimeout(function(){
		var allBotonesIcono = $('.botonaso'); allBotonesIcono.css('width','25px').css('height','25px');
		
		$('.icono_documento').button({      icons: { primary: "ui-icon-folder-collapsed"},     text: false });
		$('.icono_visita').button({      icons: { primary: "ui-icon-cart"},     text: false });
        $('.icono_formato').button({    icons: { primary: "ui-icon-document"},     text: false });
	    $('.icono_capturado').button({    icons: { primary: "ui-icon-check"},     text: false });
	    $('.icono_interpretado').button({ icons: { primary: "ui-icon-search"},   text: false });
		$('.icono_imprimir').button({     icons: { primary: "ui-icon-print"},    text: false });
		$('.icono_entregar').button({     icons: { primary: "ui-icon-person"},    text: false });
		$('.icono_cargado').button({     icons: { primary: "ui-icon-document"},    text: false });
		$('.miPDF').button({              icons: { primary: "ui-icon-document"}, text: false });
		$('.updatePDF').button({          icons: { primary: "ui-icon-refresh"},  text: false });
		
		$('.botonaso').click(function(event) { event.preventDefault(); });	
	},200); });
}

$(document).ready(function() {	
	var asInitVals = new Array();
				
	var oTableP;
	var tamP = $('#referencia').height() - 160;
	oTableP = $('#dataTablePrincipal').dataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true,ordering: false, "bJQueryUI": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { misPacientes(); },
		"aoColumns": [
			{ "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }, { "bSortable": false },
			{ "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }, { "bSortable": false },
			{ "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }
		],
		"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"iS>',
		"sAjaxSource": "datatable-serverside/pacientes.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var de = $('#filtro').val(), cv = $('#convenioP1').val(); 
			aoData.push( {"name": "nombre", "value": de } ); 
			aoData.push( {"name": "convenio", "value": cv } ); 
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "PACIENTES FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN PACIENTE FILTRADO.", "sInfoFiltered": " TOTAL DE PACIENTES: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},
		scroller: { loadingIndicator: false }
	});
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { /* Filter on the column (the index) of this element */ oTableP.fnFilter( this.value, $("tfoot input").index(this) ); });
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus( function () { if ( this.className == "search_init" ) { this.className = ""; this.value = ""; } } );
     
    $("tfoot input").blur( function (i) { 
		if(this.value=="") { this.className = "search_init campos_b_t"; this.value = asInitVals[$("tfoot input").index(this)]; } 
	} );
	//fin filtros individuales por campo de texto
	
	$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right; height:10px;'><table id='ocultarFP' style='float:right;' width='' border='0' cellspacing='0' cellpadding='6'> <tr> <td> <button id='addPacientePrincipal' onClick='nuevoPaciente()' class='ui-button ui-widget ui-corner-all' title='Agregar un nuevo paciente'><span class='ui-icon ui-icon-plus'></span> <span class='ui-icon ui-icon-person'></span> </button></td> <td><select name='convenioP1' id='convenioP1'></select></td> </tr> </table></div>" );
	$('#addPacientePrincipal').css('height', 30);
	$('.filtro1Principal input').attr("placeholder", "BUSQUE UN PACIENTE AQUÍ...").addClass('placeHolder');
	
	//ponemos los botones de reset y de añadir un paciente de la tabla principal de busqueda de pacientes
	$("div.toolbar").css('white-space','nowrap').css('border','1px none red').css('padding','10px');
	
	if($('.filtro1Principal input').val() ==''){ $('#filtro').val('YO SOLO SE QUE NO SE NADA'); }else{ $('#filtro').val('%%');oTableP.fnDraw(); }
	
	$('#convenioP1').change(function(e) { oTableP.fnDraw(); });
	
	$('.filtro1Principal').css('left',$('#botonesPrincipal').width() );
	$('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );
		
	window.setTimeout(function(){ $('.filtro1Principal').css('left',$('#botonesPrincipal').width() ); $('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );  },300);
	
	$( window ).resize(function() { $('.filtro1Principal').css('left',$('#botonesPrincipal').width() ); $('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) ); });
	
	var search_boxP = $('.filtro1Principal input');
	var busquedaP = $('.filtro1Principal');
	var data_tP = $('#dataTablePrincipal tbody');
	var info_tP = $('.infoPrincipal *');
	var reseteP = $('#resetePrincipal');
	var div_botonesP = $('.botonesPrincipal');
	var paginacionesP = $('.paginacionPrincipal');
	var cabeceraP = $('#cabecera_tBusquedaPrincipal');
	
	paginacionesP.hide();
	
	search_boxP.focus();
	
	reseteP.click(function(e) { search_boxP.val(''); search_boxP.focus(); $('#filtro').val('YO SOLO SE QUE NO SE NADA'); div_botonesP.hide(); oTableP.fnDraw(); });
	
	$('#clickme').click(function(e) { oTableP.fnDraw(); });

});
</script>

<script>
$(document).ready(function(e) {
	var he1 = $('#referencia').height() - 100; var wi1 = $('#referencia').width() * 0.98;
	
	$('#dialog-verPaciente').dialog({autoOpen:false, modal: true,width:wi1,height:he1,title:'FICHA DEL PACIENTE',closeText: '' });
	
	$('#dialog-confirmaAltaPaciente').dialog({
		autoOpen: false, modal: true, width: 620, height:150, title: 'DATOS GUARDADOS', closeText: '',
		open:function( event, ui ){ $('#dialog-confirmarNuevoPaciente').dialog('close'); 
		window.setTimeout(function(){$('#dialog-confirmaAltaPaciente').dialog('close');},2500); }
	});
	
	$('#dialog-confirmarNM').dialog({
		autoOpen: false, modal: true, width: 620, height:150, title: 'DATOS GUARDADOS', closeText: '',
		open:function( event, ui ){ $('#dialog-agregarM').dialog('close'); 
		window.setTimeout(function(){$('#dialog-confirmarNM').dialog('close');},2500); }
	});
	
	$("#convenioP1").load('files-serverside/genera_conveniosP.php',function(response,status,xhr){if ( status == "success" ) {
		$("#convenioP1").selectmenu({
			position: { my : "center top-110", at: "center top" },
			change: function( event, ui ) {$('#clickme').click();}
		});
	} });
});

function detallesConvenioP(x, c){/*x es el id de la tabla bene pac y c es el nombre del paciente*/ $(document).ready(function(e) {
$("#dialog-agregarM").load("htmls/paciente.php #detallesConvenioP #dataTableDCP", function( response, status, xhr ) {
	if ( status == "success" ) { $('#dataTableDCP').css('font-size','0.8em');
		var heX = ( $('#referencia').height() -100), wiX = $('#referencia').width() * 0.98;
		//if(x==1){var records = 'EL BENEFICIO INCLUYE A TODOS LOS CONCEPTOS';}
		//else{var records = 'EL BENEFICIO NO CUENTA CON CONCEPTOS';}
		var records = 'EL BENEFICIO NO CUENTA CON CONCEPTOS';

		var dat = c.split(';*]');
		$('#dialog-agregarM').dialog({autoOpen:true,modal:true,width:wiX,height:heX,
			title:'DETALLES BENEFICIO '+dat[0]+' PACIENTE '+dat[1],closeText: '',
			create: function( event, ui ) {
				var oTableDB;
				oTableDB = $('#dataTableDCP').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
					"bJQueryUI": true, "bRetrieve": true, "sScrollY": heX-120, "bAutoWidth": true, "bStateSave": false, 
					"bInfo": true, "bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
					"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
					"iDisplayLength": 3000, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
					"sAjaxSource": "js/datatable-serverside/detallesBeneficio.php",
					"fnServerParams": function (aoData, fnCallback) { 
						var idB = x; aoData.push(  {"name": "idB", "value": idB } ); 
					}, "sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
					"sZeroRecords": records, 
					"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>CENCEPTOS: _MAX_", 
					"sSearch": "BUSCAR" }
				});//fin datatable
				$('.DataTables_sort_icon').remove();
			},//fin create
			close: function( event, ui ) { $( "#dialog-agregarM" ).dialog( "destroy" ); }
		});
	}
});
}); }

function asignarMiConvenio(idPa, nombrePa){ $(document).ready(function(e) { //alert(idPa+' '+nombrePa);
	$("#dialog-buscarConvenio").load("htmls/buscarConvenio.php", function(response, status, xhr){ if(status=="success"){
		var he1 = $('#referencia').height() - 100; var wi1 = $('#referencia').width() * 0.98;
			
	$('#dialog-buscarConvenio').dialog({
		autoOpen: true, modal: true, width: wi1, height:he1, title: 'LISTA DE BENEFICIOS DISPONIBLES', closeText: '',
			open:function( event, ui ){
				var oTableC2;
				oTableC2 = $('#dataTableSC').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, ordering: false,
					"destroy":true, "bJQueryUI":true, "bRetrieve": true, "sScrollY": $('#dialog-buscarConvenio').height()-50,
					"bAutoWidth": true, "bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "asc"]],
					"aoColumns": [{ "bSortable": false }, { "bSortable": false }],
					"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
					"sAjaxSource": "js/datatable-serverside/buscar_convenios.php",
					"fnServerParams": function (aoData, fnCallback) { 
						var idPac = idPa; aoData.push(  {"name": "idP", "value": idPac } ); 
					},
					"sDom": '<"filtroBC">l<"infoBC">r<"data_tBC"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
					"sZeroRecords":"EL PACIENTE NO CUENTA CON BENEFICIOS PARA ASIGNAR","sInfo":"MOSTRADOS: _END_", 
					"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>CONVENIOS: _MAX_","sSearch": "BUSCAR" }
				});//fin datatable
				$('#miClick6').click(function(e){oTableC2.fnDraw();}); oTableC2.fnDraw(); $('.DataTables_sort_icon').remove();
			},
			close:function( event, ui ){
				$("#dialog-buscarConvenio").empty(); $('#dialog-buscarConvenio').dialog('destroy');
			},
			buttons:{ }, closeOnEscape:true
		});
	}});
	
	$('#dialog-asignacionConvenio').dialog({
		autoOpen: false, modal: true, closeOnEscape: false, width: 700, height:450, 
		title: 'ASIGNAR EL BENEFICIO AL PACIENTE', closeText: '', dialogClass: 'no-close',
		open:function( event, ui ){
			$('#dialog-asignacionConvenio input, #dialog-asignacionConvenio select, #dialog-asignacionConvenio textarea').addClass('campoITtab');
			$('#pacienteAC').val(nombrePa); $('#idP_AC').val(idPa);
		},
		close:function( event, ui ){
			$('#miClick1').click(); $('.calendario').val(''); $('#miClick6').click(); $('#clickme').click();
			$('#fechaIC').val($('#today').val()); $('form label.error').hide();$('*').removeClass('error'); 
		},
		buttons: {
			Asignar: function() {
				if($('#form-asignaC').valid()){
					var datosAC = $('#form-asignaC').serialize();
					$.post('files-serverside/asignaConvenio.php', datosAC).done(function( data ) { 
						if (data == 1){ 
							$('#dialog-asignacionConvenio').dialog('close'); $('#dialog-buscarConvenio').dialog('close');
							$('#miClick1c').click(); 
						}else{alert(data);} });
				}
			}, Cancelar: function() {  $('#dialog-asignacionConvenio').dialog('close'); }
		}
	});
});}

function verConvenios(x, p){/*x es el id del paciente y p es el nombre del paciente*/ $(document).ready(function(e) {
	$("#dialog-conveniosP").load("htmls/paciente.php #conveniosP #dataTableC1", function( response, status, xhr ) {
		if ( status == "success" ) { $('#dataTableC1').css('font-size','0.8em');
			
			$('#addConvenio').click(function(e) { asignarMiConvenio(x, p) });
			
			var heX = ( $('#referencia').height() )- 100; var wiX = $('#referencia').width() * 0.98;
			
			$('#dialog-conveniosP').dialog({ autoOpen: true, modal: true, width: wiX, height: heX, 
				title: 'BENEFICIOS DEL PACIENTE '+p, closeText: '',
				create: function( event, ui ) {
					var oTableC5;
					oTableC5 = $('#dataTableC1').dataTable({
						"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
						"bJQueryUI": true, "bRetrieve": true, "sScrollY": heX-120, "bAutoWidth": true, "bStateSave": false, 
						"bInfo": true, "bFilter": false, "aaSorting": [[0, "asc"]],ordering: false,
						"aoColumns": [
							{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
							{"bSortable":false}
						],
						"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
						"sAjaxSource": "js/datatable-serverside/conveniosP.php",
						"fnServerParams": function (aoData, fnCallback) { 
							var idP = x; aoData.push(  {"name": "idP", "value": idP } ); 
						}, "sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', 
						"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
						"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
						"sZeroRecords": "EL PACIENTE NO CUENTA CON BENEFICIOS", "sInfo": 
						"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>BENEFICIOS: _MAX_", 
						"sSearch": "BUSCAR" }
					});//fin datatable
					$('#miClick1c').click(function(e){oTableC5.fnDraw();}); $('.DataTables_sort_icon').remove();
				},//fin create
				close: function( event, ui ) { $( "#dialog-conveniosP" ).dialog( "destroy" ); }
			});
		}
	});
}); }
</script>

<script>
function nuevoMedicoExt(){ $(document).ready(function(e) {
$("#dialog-nuevo").load("htmls/nuevo_medicoExt.php",function(response,status,xhr){ if(status=="success"){
	$('#dialog-nuevo input').addClass('campoITtab');
	var he = ( $('#referencia').height() )- 100; var wi = $('#referencia').width() * 0.98;
	$('#dialog-nuevo').dialog({
		title:'AGREGAR UN NUEVO MÉDICO EXTERNO',modal:true,autoOpen:true,closeText:'',width:wi,height:he,closeOnEscape:true,
		dialogClass:'',
		open:function(event,ui){
			$("#especialidadU").load('../usuarios/files-serverside/genera_especialidades.php',function(response,status,xhr){ 
				if(status=="success"){$("#especialidadU").val(1);}
			});
			$('#fnacUs').datepicker({
				changeMonth: true, changeMonth: true, nextText: "Siguiente", prevText: "Anterior", showAnim : "slideDown", changeYear: true, maxDate: +0, minDate: -43800, dateFormat: "dd/mm/yy",
				dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ], dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
				monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septimbre", "Octubre", "Noviembre", "Diciembre" ],
				monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"] 
			}).css('text-align','center');
	
			$('#id_u_nm').val($('#idUser').val());
			$('#sucursalUs').val($('#sucursalU').val());
			$('#form-nmE').validate({
				rules:{ 
					clave_nmE:{ 
						required:true, 
						remote:{ 
							url: 'files-serverside/checkClaveNME.php?id_dx='+$('#id_u_nm').val(), 
							type: "post", data: { clave:function(){ return $('#clave_nmE').val(); } } 
						}, 
						minlength: 4 
					},
					username:{ required:true, remote:{ url: '../usuarios/files-serverside/checkUserUsuario.php?idU='+$('#idPacienteN').val(), type: "post", data: { user:function(){ return $('#username').val(); } } }, minlength: 4 }
				},
				messages:{ 
					clave_nmE:{ 
						required: 'Se debe ingresar la clave del médico externo.', 
						remote:'Esta clave ya está en uso, favor de intentar con otra.', 
						minlength:'La clave consta de 4 caracteres' 
					},
					username:{ required: 'SE DEBE DE INGRESAR EL NOMBRE DE USUARIO.', remote:'ESTE NOMBRE DE USUARIO YA ESTA EN USO, FAVOR DE INTENTAR CON OTRO', minlength:'EL NOMBRE DE USUARIO CONSTA DE MÍNIMO 4 CARACTERES' }
				}
			}); 
		},
		close:function(event,ui){ document.getElementById('form-nmE').reset(); $("#dialog-nuevo #form-nmE").remove();},
		buttons:{
			"Guardar": function() {
				if( $('#form-nmE').valid() ){
					var datosNME = $('#form-nmE').serialize(); 
					$.post('files-serverside/guardarNME.php',datosNME).done(function(data){ if(data == 1){
						$('#texto-informar').text('¡EL NUEVO MÉDICO EXTERNO SE HA GUARDADO SATISFACTORIAMENTE!');
						$('#dialog-informar').dialog({
							autoOpen: true, modal: true, width: 600, height:200, title: 'DATOS GUARDADOS', closeText: '',
							open:function( event, ui ){ 
								$('#dialog-nuevo').dialog('close'); $('#clickme_bme').click(); 
								window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000); 
							}
						});
					}else{alert(data);} });
				}
			},
			"Cancelar": function() { $('#dialog-nuevo').dialog('close'); }
		}
	}); //fin de dialog-nuevo
} });
}); }

function historiaCvacia(idP,control){ $(document).ready(function(e) {/*si control es 1 al cerrar la ventana abre VerHC*/
	$("#tabs-1a *,#tabs-2a *,#tabs-3a *,#tabs-4a *").css('font-size','0.98em');
	$('#idUsuario_hc').val($('#idUser').val()); $('#formHistoriaClinica').validate({ignore: 'hidden'});
	$('#tabs-1a input, #tabs-1a select, #tabs-1a textarea').addClass('campoITtab');
	$('#idPaciente_hc').val(idP); var datosIDP = {idP:idP, idC:1}
  $.post('../consultas/files-serverside/datosSV.php',datosIDP).done(function(data){ var datos = data.split(';*-');
	var datosMiHC = { idP:idP }
	$.post('../consultas/files-serverside/datosHC.php',datosMiHC).done(function(dataHC){ var datosHC = dataHC.split(';*-'); 
	
	$('.estatusVive').load("../consultas/files-serverside/cargar_estatus_vive.php", function( response, status, xhr ) { 
		$('#estatus_padre').val(datosHC[0]);$('#estatus_madre').val(datosHC[5]);$('#estatus_conyugue').val(datosHC[15]);
		$('#formHistoriaClinica select.estatusVive').change(function(e) { 
			if($(this).val()!=''){ $(this).addClass('formatoHC');}
			else{ $(this).removeClass('formatoHC');} 
		});
		$('#formHistoriaClinica select.estatusVive').each(function(index, element) { 
			if($(this).val()!=''){ $(this).addClass('formatoHC');}else{ $(this).removeClass('formatoHC');} 
		}); 
	});
	
	$('.enfermedad').load("../consultas/files-serverside/cargar_enfermedades.php", function( response, status, xhr ) { 
		$('#ahf_padre_1').val(datosHC[1]);$('#ahf_padre_2').val(datosHC[2]);$('#ahf_padre_3').val(datosHC[3]);
		$('#ahf_padre_4').val(datosHC[4]);$('#ahf_madre_1').val(datosHC[6]);$('#ahf_madre_2').val(datosHC[7]);
		$('#ahf_madre_3').val(datosHC[8]);$('#ahf_madre_4').val(datosHC[9]);$('#noHnos').val(datosHC[10]);
		$('#ahf_hnos_1').val(datosHC[11]);$('#ahf_hnos_2').val(datosHC[12]);$('#ahf_hnos_3').val(datosHC[13]);
		$('#ahf_hnos_4').val(datosHC[14]);$('#ahf_conyugue_1').val(datosHC[16]);$('#ahf_conyugue_2').val(datosHC[17]);
		$('#ahf_conyugue_3').val(datosHC[18]);$('#ahf_conyugue_4').val(datosHC[19]);$('#noHijos').val(datosHC[20]);
		$('#ahf_hijos_1').val(datosHC[21]);$('#ahf_hijos_2').val(datosHC[22]);$('#ahf_hijos_3').val(datosHC[23]);
		$('#ahf_hijos_4').val(datosHC[24]);$('#ahf_notas').val(datosHC[25]);$('#enfermedad1').val(datosHC[63]);
		$('#enfermedad2').val(datosHC[64]);$('#enfermedad3').val(datosHC[65]);$('#enfermedad4').val(datosHC[66]);
		window.setTimeout(function(){
			$('#formHistoriaClinica select').change(function(e) { if($(this).val()!=''){ $(this).addClass('formatoHC');}else{ $(this).removeClass('formatoHC');} });
			$('#formHistoriaClinica select').each(function(index, element) { if($(this).val()!=''){ $(this).addClass('formatoHC');}else{ $(this).removeClass('formatoHC');} }); 
			$('#formHistoriaClinica input[type = text],#formHistoriaClinica textarea').keyup(function(e) { 
				if($(this).val()!=''){ $(this).addClass('formatoHC').css('color','black'); }
				else{ $(this).removeClass('formatoHC').css('color','black'); } 
			});
			$('#formHistoriaClinica input[type = text],#formHistoriaClinica textarea').each(function(index, element) { if($(this).val()!=''){ $(this).addClass('formatoHC').css('color','black');}else{ $(this).removeClass('formatoHC').css('color','black');} }); 
		},700);
	});
	$('#cirugia1').val(datosHC[67]); $('#cirugia2').val(datosHC[68]); $('#cirugia3').val(datosHC[69]);
	$('#transfusiones').val(datosHC[70]);$('#app_notas').val(datosHC[71]);$('#menarca').val(datosHC[72]);
	$('#ritmo').val(datosHC[73]);$('#duracionR').val(datosHC[74]);$('#fur').val(datosHC[75]);
	$('#ivsa').val(datosHC[76]);$('#gestas').val(datosHC[77]);$('#partos').val(datosHC[78]);
	$('#cesareas').val(datosHC[79]);$('#abortos').val(datosHC[80]);$('#anticonceptivo').val(datosHC[81]);
	$('#tiempo_uso').val(datosHC[83]);$('#doc').val(datosHC[84]);
	$('#colposcopiaHC').val(datosHC[85]);$('#mastografiaHC').val(datosHC[86]);$('#ago_notas').val(datosHC[87]);
		
	$('.adiccion').load("../consultas/files-serverside/cargar_adicciones.php", function( response, status, xhr ) { 
		$('#adiccion1').val(datosHC[26]);$('#adiccion2').val(datosHC[27]);$('#adiccion3').val(datosHC[28]); 
	});
	$('.deporte').load("../consultas/files-serverside/cargar_deportes.php", function( response, status, xhr ) { 
		$('#deporte1').val(datosHC[35]);$('#deporte2').val(datosHC[36]); 
	});
	$('.inicio').load("../consultas/files-serverside/cargar_inicios.php", function( response, status, xhr ) { 
		$('#inicio_adiccion1').val(datosHC[29]);$('#inicio_adiccion2').val(datosHC[30]);$('#inicio_adiccion3').val(datosHC[31]);
	});
	$('.frecuencia').load("../consultas/files-serverside/cargar_frecuencias.php", function( response, status, xhr ) { 
		$('#frecuencia_deporte1').val(datosHC[37]);$('#frecuencia_deporte2').val(datosHC[38]); 
		$('#frecuencia_adiccion1').val(datosHC[32]);$('#frecuencia_adiccion2').val(datosHC[33]); 
		$('#frecuencia_adiccion3').val(datosHC[34]);$('#apnp_notas').val(datosHC[39]);
	});
	
	$('.recreacion').load("../consultas/files-serverside/cargar_recreaciones.php", function( response, status, xhr ) { 
		$('#recreacion1').val(datosHC[40]);$('#recreacion2').val(datosHC[41]);$('#recreacion3').val(datosHC[42]); 
		$('#recreacion4').val(datosHC[43]);$('#recreacion5').val(datosHC[44]);$('#recreacion6').val(datosHC[45]);
	});
	
	$('#vivienda_hc').load("../consultas/files-serverside/cargar_viviendas.php", function( response, status, xhr ) { 
		$('#vivienda_hc').val(datosHC[46]);$('#habitantes').val(datosHC[47]); 
	});
	
	$('.servicio_hc').load("../consultas/files-serverside/cargar_servicios.php", function( response, status, xhr ) { 
		$('#servicios1_hc').val(datosHC[50]);$('#servicios2_hc').val(datosHC[51]);$('#servicios3_hc').val(datosHC[52]); 
		$('#servicios4_hc').val(datosHC[53]);
	});
	
	$('.matV').load("../consultas/files-serverside/cargar_mat_vivienda.php", function( response, status, xhr ) { 
		$('#mat_vivienda1').val(datosHC[48]);$('#mat_vivienda2').val(datosHC[49]);
	});
	$('#aseo_personal').load("../consultas/files-serverside/cargar_aseo_personal.php", function( response, status, xhr ) { 
		$('#aseo_personal').val(datosHC[54]); 
	});
	
	$('.vacuna').load("../consultas/files-serverside/cargar_vacunas.php", function( response, status, xhr ) { 
		$('#vacunas1').val(datosHC[55]);$('#vacunas2').val(datosHC[56]);$('#vacunas3').val(datosHC[57]); 
		$('#observacionesVacunas').val(datosHC[58]);
	}); 
	$('#hrs_dormir').val(datosHC[59]);
	
	$('#alimentacion_hc').load("../consultas/files-serverside/cargar_alimentaciones.php", function( response, status, xhr ) { 
		$('#alimentacion_hc').val(datosHC[60]); 
	});
	$('.mascota').load("../consultas/files-serverside/cargar_mascotas.php", function( response, status, xhr ) { 
		$('#mascota1').val(datosHC[61]);$('#mascota2').val(datosHC[62]); 
	});
	$('#tipo_anticon').load("../consultas/files-serverside/cargar_anticonceptivos.php", function( response, status, xhr ) { 
		$('#tipo_anticon').val(datosHC[82]); 
	});
		
	});
	
  }); 
}); }

function graficasSV(idPa, de){ $(document).ready(function(e) {
	if(de==0){
		window.setTimeout(function(){ 
			$('.miCanva').css('width',($('#tabs_sv').width()/2)-50);
			$('.miCanva').css('height',($('#tabs_sv').height()/2)-80);
		},200);
	}
	if(de==1){
		window.setTimeout(function(){ 
			$('.miCanva').css('width',($('#grafiasSV').width()/2)-50);
			$('.miCanva').css('height',($('#grafiasSV').height()/2)-80); 
		},200);
	}
	if(de==3){
		window.setTimeout(function(){ 
			$('.miCanva').css('width',($('#tabs-1').width()/2)-50);
			$('.miCanva').css('height',($('#tabs-1').height()/2)-90);
		},200);
	}
	
		var datosCHa = {idP:idPa}
		$.post('../consultas/files-serverside/datosCharts.php',datosCHa).done(function(data){ var datosCH1 = data.split(';*');  var ctx = $("#myChartIMC").get(0).getContext("2d"); //alert(datosCH1[1]); // This will get the first returned node in the jQuery collection.
			var dataCH = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0.4)", strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
					{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
					{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
				]
			};
			var myNewChart = new Chart(ctx);
			var myLineChart = new Chart(ctx).Line(dataCH, {
				scaleShowGridLines : true,scaleGridLineColor: "rgba(0,0,0,.05)", scaleGridLineWidth : 1, scaleShowHorizontalLines: true, scaleShowVerticalLines: true, bezierCurve : true, bezierCurveTension : 0.4, pointDot : true, pointDotRadius : 4, 
				pointDotStrokeWidth : 1, pointHitDetectionRadius : 20, datasetStroke : true, datasetStrokeWidth : 2, datasetFill : true,
				legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
			});
			var a = datosCH1[1]; var subD = datosCH1[1].split(','); var subE = datosCH1[0].split(',');//alert(datosCH1[2]);
			for(var i = 0; i < datosCH1[2]; i++){ var b = i+1;  var a = subD[i]+',18.5, 24.9'; var codeToRun = 'window.setTimeout(function(){myLineChart.addData(['+a+'], "'+subE[i]+'"); },'+b+'000);'; /*alert(codeToRun); */ eval(codeToRun);
				if(datosCH1[2]==1){var codeToRun1 = 'window.setTimeout(function(){myLineChart.addData(['+a+'], "'+subE[i]+'"); },'+b+'500);';eval(codeToRun1);}
				if(i==0){window.setTimeout(function(){myLineChart.removeData(); window.setTimeout(function(){myLineChart.removeData(); },100);},2100); }
			}
		});
		$.post('../consultas/files-serverside/datosChartsTA.php',datosCHa).done(function(data){ var datosCH2 = data.split(';*');  var ctxTA = $("#myChartTA").get(0).getContext("2d"); //alert(datosCH2[3]); // This will get the first returned node in the jQuery collection.
			var dataCH2 = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0.4)", strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
					{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
					{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
				]
			};
			var myNewChart2 = new Chart(ctxTA);
			var myLineChart2 = new Chart(ctxTA).Line(dataCH2, {
				scaleShowGridLines : true, scaleGridLineColor : "rgba(0,0,0,.05)", scaleGridLineWidth : 1, scaleShowHorizontalLines: true, scaleShowVerticalLines: true, bezierCurve : true, bezierCurveTension : 0.4, pointDot : true, pointDotRadius : 4, 
				pointDotStrokeWidth : 1, pointHitDetectionRadius : 20, datasetStroke : true, datasetStrokeWidth : 2, datasetFill : true, 
				legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
			});
			var a = datosCH2[1]; var subD1 = datosCH2[1].split(','); var subE1 = datosCH2[0].split(','); var vMin = datosCH2[3].split(','); var vMax = datosCH2[4].split(',');//alert(datosCH1[2]);
			for(var i = 0; i < datosCH2[2]; i++){ var b1 = i+1;  var a1 = subD1[i]+','+vMin[i]+', '+vMax[i]; var codeToRun = 'window.setTimeout(function(){myLineChart2.addData(['+a1+'], "'+subE1[i]+'"); },'+b1+'000);'; /*alert(codeToRun); */ eval(codeToRun);
				if(datosCH2[2]==1){var codeToRun1 = 'window.setTimeout(function(){myLineChart2.addData(['+a1+'], "'+subE1[i]+'"); },'+b1+'500);';eval(codeToRun1);}
				if(i==0){window.setTimeout(function(){myLineChart2.removeData(); window.setTimeout(function(){myLineChart2.removeData(); },100);},2100); }
			}
		});
		$.post('../consultas/files-serverside/datosChartsFR.php',datosCHa).done(function(data){ var datosCH3 = data.split(';*');  var ctxFR = $("#myChartFR").get(0).getContext("2d"); //alert(datosCH1[1]); // This will get the first returned node in the jQuery collection.
			var dataCH3 = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0.4)", strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
					{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
					{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
				]
			};
			var myNewChart3 = new Chart(ctxFR);
			var myLineChart3 = new Chart(ctxFR).Line(dataCH3, {
				scaleShowGridLines : true, scaleGridLineColor : "rgba(0,0,0,.05)", scaleGridLineWidth : 1, scaleShowHorizontalLines: true, scaleShowVerticalLines: true, bezierCurve : true, bezierCurveTension : 0.4, pointDot : true, pointDotRadius : 4, 
				pointDotStrokeWidth : 1, pointHitDetectionRadius : 20, datasetStroke : true, datasetStrokeWidth : 2, datasetFill : true,
				legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
			});
			var a = datosCH3[1]; var subD2 = datosCH3[1].split(','); var subE2 = datosCH3[0].split(','); var vMin1 = datosCH3[3].split(','); var vMax1 = datosCH3[4].split(',');//alert(datosCH1[2]);
			for(var i = 0; i < datosCH3[2]; i++){ var b2 = i+1;  var a2 = subD2[i]+','+vMin1[i]+', '+vMax1[i]; var codeToRun = 'window.setTimeout(function(){myLineChart3.addData(['+a2+'], "'+subE2[i]+'"); },'+b2+'000);'; /*alert(codeToRun); */ eval(codeToRun);
				if(datosCH3[2]==1){var codeToRun1 = 'window.setTimeout(function(){myLineChart3.addData(['+a2+'], "'+subE2[i]+'"); },'+b2+'500);';eval(codeToRun1);}
				if(i==0){window.setTimeout(function(){myLineChart3.removeData(); window.setTimeout(function(){myLineChart3.removeData(); },100);},2100); }
			}
		});
		$.post('../consultas/files-serverside/datosChartsFC.php',datosCHa).done(function(data){ var datosCH4 = data.split(';*');  var ctxFC = $("#myChartFC").get(0).getContext("2d"); //alert(datosCH1[1]); // This will get the first returned node in the jQuery collection.
			var dataCH4 = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0.4)", strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
					{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
					{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
				]
			};
			var myNewChart4 = new Chart(ctxFC);
			var myLineChart4 = new Chart(ctxFC).Line(dataCH4, {
				scaleShowGridLines : true, scaleGridLineColor : "rgba(0,0,0,.05)", scaleGridLineWidth : 1, scaleShowHorizontalLines: true, scaleShowVerticalLines: true, bezierCurve : true, bezierCurveTension : 0.4, pointDot : true, pointDotRadius : 4, 
				pointDotStrokeWidth : 1, pointHitDetectionRadius : 20, datasetStroke : true, datasetStrokeWidth : 2, datasetFill : true,
				legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
			});
			var a = datosCH4[1]; var subD3 = datosCH4[1].split(','); var subE3 = datosCH4[0].split(','); var vMin2 = datosCH4[3].split(','); var vMax2 = datosCH4[4].split(',');//alert(datosCH1[2]);
			for(var i = 0; i < datosCH4[2]; i++){ var b3 = i+1;  var a3 = subD3[i]+','+vMin2[i]+', '+vMax2[i]; var codeToRun = 'window.setTimeout(function(){myLineChart4.addData(['+a3+'], "'+subE3[i]+'"); },'+b3+'000);'; /*alert(codeToRun); */eval(codeToRun);
				if(datosCH4[2]==1){var codeToRun1 = 'window.setTimeout(function(){myLineChart4.addData(['+a3+'], "'+subE3[i]+'"); },'+b3+'500);';eval(codeToRun1);}
				if(i==0){window.setTimeout(function(){myLineChart4.removeData(); window.setTimeout(function(){myLineChart4.removeData(); },100);},2100); }
			}
		});
}); }//fin de las gráficas SV

function cargarSV(idPa){$(document).ready(function(e) {
	$('#idUsuario_sv').val($('#idUser').val());
	graficasSV(idPa,3);
	var datosIDPa = {idP:idPa, idC:1}
	$.post('../consultas/files-serverside/datosSV.php',datosIDPa).done(function(data){ 
		var datos3 = data.split(';*-'); $('#pacienteSV').val(datos3[0]);$('#edadSV').val(datos3[1]);$('#sexoSV').val(datos3[2]);
		$('#pesoSV').val(datos3[3]);$('#tallaSV').val(datos3[4]);$('#imcSV').val(datos3[5]);$('#cinturaSV').val(datos3[6]);
		$('#tSV').val(datos3[7]);$('#aSV').val(datos3[8]);
		$('#frSV').val(datos3[9]);$('#fcSV').val(datos3[10]);$('#tempSV').val(datos3[11]);$('#notasSV').val(datos3[12]);
		$('#miTabsH #tabs-1').css('height',$('#tabs-1').height());
		$('#grafiasSV').css('height',$('#miTabsH #tabs-1').height());
		$('#tabs_sv #tabs-2-1').click(function(e) { 
			$('#miTabsH #tabs-2').css('height',$('#miTabsH #tabs-1').height());
			$('#miIMC').text($('#imcSV').val()); $('#miMedidaCintura').text($('#cinturaSV').val());
			if( $('#imcSV').val() >= 18.5 & $('#imcSV').val() < 25 ){
				$('.normalIMC').addClass('formatoRangosIMC');
				$('#miRiesgoP').text('no está en riesgo latente');
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){ $('.imc_1_1').addClass('formatoRangosIMC');}
					else if( $('#cinturaSV').val() > 80 ){ $('.imc_1_2').addClass('formatoRangosIMC'); }
					else{$('.imc_1_1, .imc_1_2').removeClass('formatoRangosIMC');}
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){ $('.imc_1_1').addClass('formatoRangosIMC'); }
					else if( $('#cinturaSV').val() > 90 ){ $('.imc_1_2').addClass('formatoRangosIMC'); }
					else{$('.imc_1_1, .imc_1_2').removeClass('formatoRangosIMC');}
				}
			} 
			else if( $('#imcSV').val() >= 25 & $('#imcSV').val() < 30 ){
				$('.sobrepesoIMC').addClass('formatoRangosIMC');
				$('#miRiesgoP').text('tiene riesgo moderado');
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){ $('.imc_2_1').addClass('formatoRangosIMC'); }
					else if( $('#cinturaSV').val() > 80 ){ $('.imc_2_2').addClass('formatoRangosIMC'); }
					else{$('.imc_2_1, .imc_2_2').removeClass('formatoRangosIMC');}
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){ $('.imc_2_1').addClass('formatoRangosIMC'); }
					else if( $('#cinturaSV').val() > 90 ){ $('.imc_2_2').addClass('formatoRangosIMC'); }
					else{$('.imc_2_1, .imc_2_2').removeClass('formatoRangosIMC');}
				}
			} 
			else if( $('#imcSV').val() >= 30 & $('#imcSV').val() < 35 ){
				$('.obesidad1IMC').addClass('formatoRangosIMC');
				$('#miRiesgoP').text('tiene riesgo alto').css('color','red');
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){ $('.imc_3_1').addClass('formatoRangosIMC'); }
					else if( $('#cinturaSV').val() > 80 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
					else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){ $('.imc_3_1').addClass('formatoRangosIMC'); }
					else if( $('#cinturaSV').val() > 90 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
					else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
				}
			} 
			else if( $('#imcSV').val() >= 35 & $('#imcSV').val() < 40 ){
				$('.obesidad2IMC').addClass('formatoRangosIMC');
				$('#miRiesgoP').text('tiene riesgo muy alto').css('color','red');
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){ $('.imc_3_1').addClass('formatoRangosIMC'); }
					else if( $('#cinturaSV').val() > 80 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
					else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){ $('.imc_3_1').addClass('formatoRangosIMC'); }
					else if( $('#cinturaSV').val() > 90 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
					else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
				}
			} 
			else if( $('#imcSV').val() >= 40 ){
				$('.obesidad3IMC').addClass('formatoRangosIMC');
				$('#miRiesgoP').text('tiene riesgo extremadamente alto').css('color','red');
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){ $('.imc_4_1').addClass('formatoRangosIMC'); }
					else if( $('#cinturaSV').val() > 80 ){ $('.imc_4_2').addClass('formatoRangosIMC'); }
					else{$('.imc_4_1, .imc_4_2').removeClass('formatoRangosIMC');}
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){ $('.imc_4_1').addClass('formatoRangosIMC'); }
					else if( $('#cinturaSV').val() > 90 ){ $('.imc_4_2').addClass('formatoRangosIMC'); }
					else{$('.imc_4_1, .imc_4_2').removeClass('formatoRangosIMC');}
				}
			} else{$('.sobrepesoIMC').removeClass('formatoRangosIMC'); }
		});
		$('#tabs_sv #tabs-3-1').click(function(e) {
			if( $('#imcSV').val() >= 18.5 & $('#imcSV').val() < 25 ){
				$('#recomendacionRN').show();
				$('#recomendacionSP, #recomendacionOB').hide();
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){
						$('#miRiesgoE').text('sin riesgo');
					}else if( $('#cinturaSV').val() > 80 ){
						$('#miRiesgoE').text('con riesgo alto');
					} else{ }
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){
						$('#miRiesgoE').text('sin riesgo');
					}else if( $('#cinturaSV').val() > 90 ){
						$('#miRiesgoE').text('con riesgo alto');
					} else{ }
				}
			} 
			else if( $('#imcSV').val() >= 25 & $('#imcSV').val() < 30 ){
				$('#recomendacionSP').show();
				$('#recomendacionRN, #recomendacionOB').hide();
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){
						$('#miRiesgoE').text('con riesgo moderado');
					}else if( $('#cinturaSV').val() > 80 ){
						$('#miRiesgoE').text('con riesgo alto');
					} else{ }
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){
						$('#miRiesgoE').text('con riesgo moderado');
					}else if( $('#cinturaSV').val() > 90 ){
						$('#miRiesgoE').text('con riesgo alto');
					} else{ }
				}
			} 
			else if( $('#imcSV').val() >= 30 & $('#imcSV').val() < 35 ){
				$('#recomendacionOB').show();
				$('#recomendacionRN, #recomendacionSP').hide();
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){
						$('#miRiesgoE').text('con alto a muy alto riesgo');
					}else if( $('#cinturaSV').val() > 80 ){
						$('#miRiesgoE').text('con muy alto riesgo');
					} else{ }
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){
						$('#miRiesgoE').text('con alto a muy alto riesgo');
					}else if( $('#cinturaSV').val() > 90 ){
						$('#miRiesgoE').text('con muy alto riesgo');
					} else{ }
				}
			} 
			else if( $('#imcSV').val() >= 35 & $('#imcSV').val() < 40 ){
				$('#recomendacionOB').show();
				$('#recomendacionRN, #recomendacionSP').hide();
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){ $('#miRiesgoE').text('con alto a muy alto riesgo'); }
					else if( $('#cinturaSV').val() > 80 ){ $('#miRiesgoE').text('con muy alto riesgo'); } 
					else{ }
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){ $('#miRiesgoE').text('con alto a muy alto riesgo'); }
					else if( $('#cinturaSV').val() > 90 ){ $('#miRiesgoE').text('con muy alto riesgo'); } 
					else{ }
				}
			} 
			else if( $('#imcSV').val() >= 40 ){
				$('#recomendacionOB').show();
				$('#recomendacionRN, #recomendacionSP').hide();
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){ $('#miRiesgoE').text('con riesgo extremadamente alto'); }
					else if( $('#cinturaSV').val() > 80 ){ $('#miRiesgoE').text('con riesgo extremadamente alto'); }
					else{ }
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){ $('#miRiesgoE').text('con riesgo extremadamente alto'); }
					else if( $('#cinturaSV').val() > 90 ){ $('#miRiesgoE').text('con riesgo extremadamente alto'); } 
					else{ }
				}
			} else{ }
		}); 
		$('#tabs_sv #tabs-4-1').click(function(e) {
			var oTableSV;
			oTableSV = $('#dataTableSV').dataTable({
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
					$('*').removeClass('sorting_desc');
					$('.DataTables_sort_icon').remove(); 
				},
				"destroy":true, "bJQueryUI":true, "bRetrieve":true, "sScrollY": $('#miTabsH #tabs-1').height(), "bAutoWidth":true,
				"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]], ordering: false,
				"aoColumns":[
					{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
					{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
					{ "bSortable": false }, { "bSortable": false }
				],
				"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
				"sAjaxSource": "../consultas/datatable-serverside/signos_vitales.php",
				"fnServerParams":function(aoData, fnCallback) { var idP = idPa; aoData.push(  {"name": "idP", "value": idP } ); },
				"sDom": '<"filtroSV">l<"infoSV">r<"data_tSV"t>', "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"oLanguage":{
					"sLengthMenu":"MONSTRANDO _MENU_ records per page","sZeroRecords":"EL PACIENTE NO CUENTA CON SIGNOS VITALES",
					"sInfo":"MOSTRADOS: _END_","sInfoEmpty":"MOSTRADOS: 0","sInfoFiltered":"<br/>REGISTROS: _MAX_",
					"sSearch": "BUSCAR" 
				}
			});//fin datatable
		});
		
		$('#tomarNSV').hide(); $('#cancelNSV,#saveNSV').hide();

		$('#tomarNSV').click(function(event) { 
			event.preventDefault(); 
			window.setTimeout(function(){signosVvacios(idPa,1)},200); 
		});
		$('#tomarNSV').button({ icons:{ primary:'ui-icon-document' } });
		$('#tabs_sv ul').removeClass('ui-widget-header');
				
	});
	$('#tabs-4-1s').click(function(e) {
		var oTableSV;
		oTableSV = $('#dataTableSV').dataTable({
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { $('.DataTables_sort_icon').remove(); },
			"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs_sv').height()-100, "bAutoWidth": true, 
			"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]], ordering: false,
			"aoColumns":[
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }, { "bSortable": false }
			],
			"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
			"sAjaxSource": "datatable-serverside/signos_vitales.php",
			"fnServerParams": function (aoData, fnCallback) { var idP = idPa; aoData.push(  {"name": "idP", "value": idP } ); },
			"sDom": '<"filtroSV">l<"infoSV">r<"data_tSV"t>', "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
			"oLanguage":{
				"sLengthMenu":"MONSTRANDO _MENU_ records per page","sZeroRecords":"EL PACIENTE NO CUENTA CON SIGNOS VITALES",
				"sInfo":"MOSTRADOS: _END_","sInfoEmpty":"MOSTRADOS: 0","sInfoFiltered":"<br/>REGISTROS: _MAX_","sSearch": "BUSCAR" 
			}
		});//fin datatable
	});
});}//Fin cargarSV

function rDX(idC,no,nP,f,a,r){$(document).ready(function(e){//idC es el id del concepto y no es el tipo de concepto.VER EL RESULTADO
	if(no == 1){var c = 'CONSULTA.';}else{var c = 'ESTUDIO.';}
	var heR = $('#referencia').height() - 100, wiR = $('#referencia').width() * 0.98, tituloR = c+' PACIENTE: '+nP+'. '+f;
	
	$('#dialog-rDX').dialog({
		autoOpen: false, modal: true, width: wiR, height: heR, title: tituloR, closeText: '', 
		closeOnEscape: true, dialogClass: '',
		buttons: { }, 
		open: function( event, ui ) { },
		close: function( event, ui ) { $('#dialog-rDX').empty(); }
	});
	
	switch(no){
		case 1://consulta
			$("#dialog-rDX").load("../consultas/htmls/consultaH.php #tabs_c_h", function(response,status,xhr){if ( status == "success" ) { 
				$('#tabs_c_h *').css('font-size','0.98em');
				$("#dialog-rDX").tabs({active: 0});
				$('#dialog-rDX ul').removeClass('ui-widget-header');
				$('#tabs_c_h input, #tabs_c_h select, #tabs_c_h textarea').addClass('campoITtab');
				$('#tabs_c_h input, #tabs_c_h select, #tabs_c_h textarea').prop('disabled',true);
				var oTableDXh;
				oTableDXh = $('#dataTableDXh').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
						$('#tabs-1hc span.DataTables_sort_icon').remove();
					},
					"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-1hc').height()-200, 
					"bAutoWidth": true, "bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
					"aoColumns": [{ "bSortable": false }, { "bSortable": false }], "iDisplayLength": 30000, 
					"bLengthChange": false, "bProcessing": true, "bServerSide": true, ordering: false,
					"sAjaxSource": "../consultas/datatable-serverside/diagnosticos.php",
					"fnServerParams": function (aoData, fnCallback) { 
						var aleatorio = a; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
					},
					"sDom": '<"filtroDX">l<"infoDX">r<"data_tDX"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
					"sZeroRecords":"LA CONSULTA NO CUENTA CON DIAGNÓSTICOS","sInfo":"MOSTRADOS: _END_", 
					"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_","sSearch": "BUSCAR" }
				});/*fin datatable*/ $('#clickmeDXh').click(function(e) { oTableDXh.fnDraw(); });//FIn DT DX
				//DT Receta
				$('#tabs-2-hc').click(function(e) {
					var oTableMedih;
					oTableMedih = $('#dataTableMedih').dataTable({
						"fnDrawCallback": function ( oSettings ) { 
							$('#tabs-2hc span.DataTables_sort_icon').remove();
							if ( oSettings.bSorted || oSettings.bFiltered ) { 
								for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ ) { 
									$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 ); 
								} 
							} 
						},
						"bJQueryUI": true, "sScrollY": $('#tabs-2hc').height()-200, "bAutoWidth": true, "destroy": true,
						columns: [
							{ data: "medicamentos.id_med", orderable: false },
							{ data: "medicamentos.nombre_generico_med", "sClass": "left1" },
							{ data: "medicamentos.descripcion_med", "sClass": "left1" },
							{ data: "medicamentos.cantidad_med" },
							{ data: "medicamentos_receta.cantidad_mr" },
							{ data: "unidades.unidad_un", editField: "medicamentos_receta.unidad_mr" },
							{ data: "medicamentos_receta.periodicidad_mr" },
							{ data: "medicamentos_receta.duracion_mr" }
						], 
						"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
						ajax: { url: "../Editor-PHP-1.4.0/examples/php/receta.php?aleatorio="+a, type: 'POST' },
						"sDom": '<"filtroDX">l<"infoDX">r<"data_tDX"t>', 
						"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
						"oLanguage":{
							"sLengthMenu":"MONSTRANDO _MENU_ records per page",
							"sZeroRecords":"LA RECETA DE LA CONSULTA NO CUENTA CON MEDICAMENTOS",
							"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", 
							"sInfoFiltered": "<br/>MEDICAMENTOS: _MAX_","sSearch": "BUSCAR" 
						}
					});/*fin datatable*/ $('#clickmeMedih').click(function(e) { oTableMedih.fnDraw(); });
				});
				//Fin DT Receta
			}});//Fin de  load
			
			$('#dialog-rDX').dialog({
				autoOpen: true, buttons: { }, 
				close: function( event, ui ) {  $("#dialog-rDX").tabs("destroy"); }
			});
		break;
		case 2://Estudio de endoscopía o laboratorio
			var x1=idC, x='../laboratorio/takeArchivos/pdf/'+idC+'.pdf'; 
			$("#dialog-rDX").load('../laboratorio/htmls/miPDF.php #tablaMiPDF', function( response, status, xhr ) { 
			if ( status == "success" ) {
				$('a.media').media({width:wiR, height:heR-35, src:x});
			} });
			$('#dialog-rDX').dialog('open');
		break;
		case 3://Estudio de imagen
			$("#dialog-rDX").load("../consultas/htmls/estudio_imagenH.php #tabs_i_h", function(response,status,xhr){if ( status == "success" ) { 
				$('#tabs_i_h *').css('font-size','0.98em');
				$("#dialog-rDX").tabs({active: 0});
				$('#dialog-rDX ul').removeClass('ui-widget-header');
				$('#tabs_i_h input, #tabs_i_h select, #tabs_i_h textarea').addClass('campoITtab');
				$('#tabs_i_h input, #tabs_i_h select, #tabs_i_h textarea').prop('disabled',true);
				var dato = { idE:idC }
				$.post('../imagen/files-serverside/datosInterpretar.php', dato, processData);
				function processData(data) {
					console.log(data);
					var datos = data.split(';*-');
					//document.getElementById('form-captura').reset();
					$('.myPacienteP').html(datos[0]);
					$('.myReferenciaP').html(datos[1]);
					$('.myEdadP').html(datos[2]);
					$('.mySexoP').html(datos[3]);
					$('.myFechaP').html(datos[4]);
					$('.myDiagnosticoP').html(datos[5]);//alert(data);
					$('.myNotaP').html(datos[6]);
					$('.myUnidadMedicaP').html('CLÍNICA SAN ANTONIO');
					$('.myMedicoP').html(datos[7]);
					$('.myEstudioP').html(datos[8]);
					$('.nombreDR').html(datos[9]);
					$('.puestoDR').html('MÉDICO RADIÓLOGO');
					$('.cedula').html(datos[10]);
					$('.myFnacP').html(datos[14]);
					//$('.firmaDR').html('<img src="../usuarios/takePicture/firmas/'+datos[11]+'" width="" height="65">');
					if(datos[15]==1){$('.dr').html('DRA.');}else if(datos[15]==2){$('.dr').html('DR.');}
				}
				try {
				var domainName = window.parent.parent.iframeData.domainName;
				document.domain = "sigma-csa.noip.me";
				alert(document.domain);
				}
				//Access violation
				catch (err) { alert(err);
					document.domain = window.location.hostname.replace('www.', '');
				}
				
				var serie = 'http://sigma-csa.noip.me:8080/oviyam2/viewer.html?patientID='+r;
				var url = window.location.href;
				var myL = url.split('http://');
				var myL1 = myL[1].split('/'); var koby = myL1[0].split(':8888'); //alert(myL1[0]);
				var link_1 = koby[0]+koby[1];
				//var serie = 'http://'+myL1[0]+':8080/oviyam2/viewer.html?patientID='+r;
				var serie = 'http://'+link_1+':8080/oviyam2/viewer.html?patientID='+r;
				//$("#serie").load(serie);
				
				$('#serie').prop('src',serie);
			} });
			$('#dialog-rDX').dialog({
				autoOpen: true, 
				buttons: { /*'Guardar y finalizar': function() { }, 'Salir sin guardar': function() { }*/ }, 
				close: function( event, ui ) {  $("#dialog-rDX").tabs("destroy"); }
			});
		break;
	}
}); }

$('#dialog-confirmar').dialog({
	title: 'CONFIRMACIÓN',modal:true, autoOpen:false, closeText:'', width:500, height:250,closeOnEscape:true,dialogClass:'',
  	buttons: { "CERRAR": function() { $(this).dialog('close'); } }, 
		open:function( event, ui ){ window.setTimeout(function(){$('#dialog-confirmar').dialog('close');},2000); }, 
	close:function( event, ui ){ }
});

$('#dialog-terapia').dialog({
	title: 'ASIGNAR PLAN DE REHABILITACIÓN AL PACIENTE',modal:true, autoOpen:false, closeText:'', width:700, height:260,
	closeOnEscape:false, dialogClass:'',
  	buttons: { 
		"Asignar": function() {
			if($('#form-terapia').valid()){
				var datos = $('#form-terapia').serialize();
				$.post('files-serverside/terapiaPaciente.php',datos).done(function(data){
					if(data == 1){
						$('#dialog-confirmar').dialog('open');
						$('#dialog-terapia').dialog('close');
						$('#dialog-verPaciente').dialog('close');
					}else{alert(data); $('#dialog-terapia').dialog('close'); $('#dialog-verPaciente').dialog('close');}
				});
			}
		}, 
		"Cancelar": function() { $(this).dialog('close'); } 
  	},
  	open:function( event, ui ){ },
	close:function( event, ui ){ document.getElementById('form-terapia').reset(); $('#dialog-nivel2').dialog('close'); }
});
			   
function verPaciente(x){//x es el id del paciente q seleccionamos
 $(document).ready(function(e) { //alert(x);
 	 $('.idP_fichaP').val(x); $('#nombreFotoT').val(''); $('#idPacienteN').val(x);
	 var nowY = new Date().getTime(), dY = new Date();
	 
	 var datos ={idP:x, tempN:dY.format('Y-m-d-H-i-s-u').substring(0,22)}
	 $.post('files-serverside/fichaPaciente.php',datos).done(function(data1){ //alert(data1);
		var datosI = data1.split('*}'); //$('#tabs-4-1').hide(); //ocultamos pestaña de expediente del paciente, no está terminada
		
		$('#nuevo_o_viejo_u').val(1); $('#temporal_s').val(datosI[38]); $('#nssP').val(datosI[59]); siempre(datosI[56],datosI[57]);
		
		if(datosI[37]==1){
			var datos = {aleatorio:datosI[38]}
			$.post('files-serverside/datosFoto.php',datos).done(function( data ){ 
				var t = "<div style='background-image:url(fotos/files/"+data+"."+datosI[58]+"?"+Math.round(Math.random()*1000)+");background-size:contain;background-repeat:no-repeat;background-position:center;background-color:white; width:100%; height:100%; cursor:;' class='conFoto' onClick=''></div>";
				$('#foto_usuario').html(t);
			});
		}
		$('#fotoU').val(datosI[37]); $('#b_subir_foto').click(function(e){ reFoto1(); });
		
		//Mandamos a una terapia
		$('#aTerapia').click(function(e){ 
			$('#id_paciente_tera').val(x);$('#id_usuario_tera').val($('#idUser').val());$('#dialog-terapia').dialog('open');
		});
		
		var he = $('#referencia').height() - $('#header').height()-50; var wi = $('#referencia').width()*0.98;
		
		var title = 'PACIENTE '+datosI[1]+' '+datosI[2]+' '+datosI[3]+' REGISTRADO POR '+datosI[40]+' '+datosI[41]; 
		$('#dialog-verPaciente').dialog({
		  title: title, modal: true, autoOpen: false, closeText: '', width: wi, height: he, closeOnEscape: true,
		  dialogClass:'',
		  buttons: { },
		  open:function( event, ui ){
			  $('.miTab').css('height',100);
			  $('.t_uno').css('height',$('#dialog-verPaciente').height()-50);
			  $('#nombreP').focus(); $('#tabs-1-1').click(function(e) { $('#nombreP').focus(); });
			  $("#miTabsH").tabs({active: 0}); 
			  $('#pestanas1, #pestanas').removeClass('ui-widget-header');
			  $('#tabs-1h').load('../consultas/htmls/signos_vitales.php',function(response,status,xhr){ if(status=="success"){
				  $("#tabs-1h").tabs({active: 0});
				  $('#tabs_sv ul').removeClass('ui-widget-header');
				  $('#tabs_sv #tabs-1 table,#tabs_sv #tabs-2 table,#tabs_sv #tabs-3 table,#tabs_sv #tabs-4 table').css('background-color','#DCDDDE','color','white');
				  $('#editarPac,#savePac,#cancelSavePac,#cancelEditPac,#updatePac,#aTerapia').button({});
				  $('#tabs_sv #tabs-1,#tabs_sv #tabs-2,#tabs_sv #tabs-3,#tabs_sv #tabs-4').css('width',$('#fichaPaciente').width()-6);
				  cargarSV(x);
				  historiaCvacia(x,0);
			  }});
			  $('#tabs-2h').load('../consultas/htmls/historia_clinicaC.php',function(response,status,xhr){if(status=="success"){
				$("#tabs-2h").tabs({active: 0});
				$('.ui-tabs-nav').removeClass('ui-widget-header');
				$('#b_editarHC,#b_actualizarHC,#b_cancelHC').hide();
			  }});
			  $('#tabs-3-1h').click(function(e) {
				//para consultas
				var oTableHCo;
				oTableHCo = $('#dataTableHCo').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
						$('#tabs-5 span.DataTables_sort_icon').remove();
					}, ordering: false,
					"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-5').height()-50, 
					"bAutoWidth": true, "bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
					"aoColumns": [
						{ "bSortable": false }, { "bSortable": false }, 
						{ "bSortable": false, "sClass": "left1" }, { "bSortable": false, "sClass": "left1" }
					],
					"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
					 "sAjaxSource": "../consultas/datatable-serverside/historial_consultas.php",
					"fnServerParams": function (aoData, fnCallback) { 
						var aleatorio = x; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
					},
					"sDom": '<"filtroDX">l<"infoDX">r<"data_tDX"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage":{
						"sLengthMenu":"MONSTRANDO _MENU_ records per page",
						"sZeroRecords":"EL PACIENTE NO CUENTA CON UN HISTORIAL CLÍNICO",
						"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", 
						"sInfoFiltered": "<br/>CONSULTAS: _MAX_","sSearch": "BUSCAR" 
					}
				});/*fin datatable*/ $('#clickmeHCo').click(function(e) { oTableHCo.fnDraw(); });
			  });
			  $('#tabs-4-1h').click(function(e) { 
				//para imagen
				var oTableHIm;
				oTableHIm = $('#dataTableHIm').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
						$('span.DataTables_sort_icon').remove();
					}, ordering: false,
					"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-5').height()-70, 
					"bAutoWidth":true,"bStateSave":false,"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
					"aoColumns": [
						{ "bSortable": false }, { "bSortable": false }, 
						{ "bSortable": false, "sClass": "left1" }, { "bSortable": false, "sClass": "left1" }
					],
					"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
					 "sAjaxSource": "../consultas/datatable-serverside/historial_imagen.php",
					"fnServerParams": function (aoData, fnCallback) { 
						var aleatorio = x; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
					},
					"sDom": '<"filtroDX">l<"infoDX">r<"data_tDX"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage":{
						"sLengthMenu":"MONSTRANDO _MENU_ records per page",
						"sZeroRecords":"EL PACIENTE NO CUENTA CON UN HISTORIAL CLÍNICO",
						"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", 
						"sInfoFiltered": "<br/>CONSULTAS: _MAX_","sSearch": "BUSCAR" 
					}
				});/*fin datatable*/ $('#clickmeHIm').click(function(e) { oTableHIm.fnDraw(); });
				//Fin del expediente de imagen
			  });
			  $('#tabs-5-1h').click(function(e) { 
				//para Laboratorio
				var oTableHLa;
				oTableHLa = $('#dataTableHLa').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
						$('span.DataTables_sort_icon').remove();
					}, ordering: false,
					"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-5').height()-50, 
					"bAutoWidth":true,"bStateSave": false, "bInfo":true,"bFilter": true, "aaSorting": [[0, "desc"]],
					"aoColumns": [
						{ "bSortable": false }, { "bSortable": false }, 
						{ "bSortable": false, "sClass": "left1" }, { "bSortable": false, "sClass": "left1" }
					],
					"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
					 "sAjaxSource": "../consultas/datatable-serverside/historial_laboratorio.php",
					"fnServerParams": function (aoData, fnCallback) { 
						var aleatorio = x; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
					},
					"sDom": '<"filtroDX">l<"infoDX">r<"data_tDX"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage":{
						"sLengthMenu":"MONSTRANDO _MENU_ records per page",
						"sZeroRecords":"EL PACIENTE NO CUENTA CON UN HISTORIAL CLÍNICO",
						"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", 
						"sInfoFiltered": "<br/>CONSULTAS: _MAX_","sSearch": "BUSCAR" 
					}
				});/*fin datatable*/ $('#clickmeHLa').click(function(e) { oTableHLa.fnDraw(); });
				//Fin del expediente de Laboratorio
			  });
			  $('#tabs-6-1h').click(function(e) { 
				//para endoscopía
				var oTableHEn;
				oTableHEn = $('#dataTableHEn').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
						$('span.DataTables_sort_icon').remove();
					}, ordering: false,
					"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-5').height()-50, 
					"bAutoWidth":true,"bStateSave":false,"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
					"aoColumns": [
						{ "bSortable": false }, { "bSortable": false }, 
						{ "bSortable": false, "sClass": "left1" }, { "bSortable": false, "sClass": "left1" }
					],
					"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
					 "sAjaxSource": "../consultas/datatable-serverside/historial_endoscopia.php",
					"fnServerParams": function (aoData, fnCallback) { 
						var aleatorio = x; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
					},
					"sDom": '<"filtroDX">l<"infoDX">r<"data_tDX"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage":{
						"sLengthMenu":"MONSTRANDO _MENU_ records per page",
						"sZeroRecords":"EL PACIENTE NO CUENTA CON UN HISTORIAL CLÍNICO",
						"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", 
						"sInfoFiltered": "<br/>CONSULTAS: _MAX_","sSearch": "BUSCAR" 
					}
				});/*fin datatable*/ $('#clickmeHEn').click(function(e) { oTableHEn.fnDraw(); });
				//Fin del expediente de endoscopía
			  });
			  $('#tabs-7-1h').click(function(e) { 
				//para Servicios
				var oTableHSe;
				oTableHSe = $('#dataTableHSe').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
						$('span.DataTables_sort_icon').remove();
					}, ordering: false,
					"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-5').height()-50, 
					"bAutoWidth":true,"bStateSave":false,"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
					"aoColumns": [
						{ "bSortable": false }, { "bSortable": false }, 
						{ "bSortable": false, "sClass": "left1" }, { "bSortable": false, "sClass": "left1" }
					],
					"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
					 "sAjaxSource": "../consultas/datatable-serverside/historial_servicios.php",
					"fnServerParams": function (aoData, fnCallback) { 
						var aleatorio = x; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
					},
					"sDom": '<"filtroDX">l<"infoDX">r<"data_tDX"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage":{
						"sLengthMenu":"MONSTRANDO _MENU_ records per page",
						"sZeroRecords":"EL PACIENTE NO CUENTA CON UN HISTORIAL CLÍNICO",
						"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", 
						"sInfoFiltered": "<br/>CONSULTAS: _MAX_","sSearch": "BUSCAR" 
					}
				});/*fin datatable*/ $('#clickmeHSe').click(function(e) { oTableHSe.fnDraw(); });
				//Fin del expediente de Servicios
			  });
			  
			  $('.t_uno').css('height',$('#dialog-verPaciente').height()-50);
			  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {
					validateOn:["blur"], isRequired:false, useCharacterMasking:true
				});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "phone_number", {
					validateOn:["blur"], isRequired:false, useCharacterMasking:true
				});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "phone_number", {
					validateOn:["blur"], isRequired:false, useCharacterMasking:true
				});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {
					validateOn:["blur", "change"], minChars:18, maxChars:18
				});
				$('#telmovilP, #telparticularP, #telefonoTrabajoP').focusout(function(e) { 
					if($(this).val()=='('){$(this).val('');} 
				}); 
	
			  $('.botonesSaveP').hide(); $('.botonesUpdateP, .botonesTerapiaP').show();
			  $('#formGenerales input, #dialog-verPaciente select, #dialog-verPaciente textarea').prop('disabled',true);
			  $('#cancelEditPac, #updatePac').hide();
				
			  $('#editarPac').click(function(e) {
					$('#formGenerales input, #dialog-verPaciente select,#dialog-verPaciente textarea').prop('disabled',false);
					$('#cancelEditPac, #updatePac').show(); $('#nombreP').focus();
					$('#editarPac,#aTerapia').hide();
				});
				$('#cancelEditPac').click(function(e) {
					$('#formGenerales input, #dialog-verPaciente select, #dialog-verPaciente textarea').prop('disabled',true);
					$('#cancelEditPac, #updatePac').hide();
					$('#editarPac,#aTerapia').show();
				});
				$('#updatePac').click(function(e) {
					if($('#formGenerales').valid()){ 
						var datosP = $('#formGenerales').serialize();
						$.post('files-serverside/updatePacienteG.php',datosP).done(function( data ) {
							if (data==1){//si el paciente se Actualizó 
								$('#dialog-verPaciente').dialog('close');$('#clickme').click();
								$('#dialog-confirmaciones').dialog({
									autoOpen: true, modal:true, width:620, height:150, title:'DATOS ACTUALIZADOS', closeText:'',
									open:function( event, ui ){$('#texto-confirmaciones').text('LOS DATOS DEL PACIENTE HAN SIDO ACTUALIZADOS'); window.setTimeout(function(){$('#dialog-confirmaciones').dialog('close');},2500); }
								});
							}
							else{alert(data);}
						});//se actualiza al paciente
					}
				});
				
			window.setTimeout(function(){
				$('#pestanas').removeClass('ui-widget-header'); 
				$('#formGenerales input, #dialog-verPaciente select, #dialog-verPaciente textarea').addClass('campoITtab');
				
				$('.pActivo').show();$("#dialog-verPaciente").tabs({active: 0, heightStyle: "auto"});
				
				$('#dialog-verPaciente input, #dialog-verPaciente select, #dialog-verPaciente textarea').addClass('campoITtab');
				$('.idUsuarioP').val($('#idUsuario').val()); $('.pActivo').show(); $('#tabs-5-1').show(); 
				//ponemos los valores INICIALES DE LA FICHA DEL PACIENTE //window.setTimeout(function(){},1000);

				
				
				
				
				
				//Datos de dirección
				$('#estadoP').val(datosI[28]);var idB = $("#estadoP").find(':selected').text();
				$("#municipioP").load('files-serverside/genera_municipios.php?id='+escape(idB),function(response,status,xhr){
				  if ( status == "success" ) { 
						$('#municipioP').val(datosI[29]);var idM1 = $("#municipioP").find(':selected').text();
						var id1E = $("#estadoP").find(':selected').text();
						$("#coloniaP").load('files-serverside/genera_colonias.php?idM='+escape(idM1)+'&idE='+escape(id1E),
						function( response, status, xhr ) {
						  if ( status == "success" ) { 
								$('#coloniaP').val(datosI[30]);var idCx = $("#coloniaP").find(':selected').text();
								var idEx = $("#estadoP").find(':selected').text();
								var idMx = $("#municipioP").find(':selected').text();
								$("#cpP").load('files-serverside/genera_cp.php?idC='+escape(idCx)+'&idE='+escape(idEx)+'&idM='+escape(idMx));
						  }
						});
				  }
				});
				
				//Datos de FISCAL
				$('#estadoPF').val(datosI[47]);var idBF = $("#estadoPF").find(':selected').text();
				$("#municipioPF").load('files-serverside/genera_municipios.php?id='+escape(idBF), function( response, status, xhr ) {
				  if ( status == "success" ) { 
						$('#municipioPF').val(datosI[48]);var idM1F = $("#municipioPF").find(':selected').text();var id1EF = $("#estadoPF").find(':selected').text();
						$("#coloniaPF").load('files-serverside/genera_colonias.php?idM='+escape(idM1F)+'&idE='+escape(id1EF), function( response, status, xhr ) {
							  if ( status == "success" ) { 
									$('#coloniaPF').val(datosI[49]);var idCxF = $("#coloniaPF").find(':selected').text();var idExF = $("#estadoPF").find(':selected').text();var idMxF = $("#municipioPF").find(':selected').text();
									$("#cpPF").load('files-serverside/genera_cp.php?idC='+escape(idCxF)+'&idE='+escape(idExF)+'&idM='+escape(idMxF));
							  }
						});
				  }
				});
				$('#callePF').val(datosI[44]);$('#noExtPF').val(datosI[45]);$('#noIntPF').val(datosI[46]);
				
				$('#telefonoTrabajoP').val(datosI[12]);$('#extensionTelTraP').val(datosI[13]);$('#avisarP').val(datosI[15]);$('#telefonoEmergenciaP').val(datosI[16]);$('#emailPF').val(datosI[18]);
				$('#nsocioeconomicoP').val(datosI[4]);$('#escolaridadP').val(datosI[22]);$('#ocupacionP').val(datosI[23]);$('#religionP').val(datosI[9]);$('#etniaP').val(datosI[8]);$('#discapacidadP').val(datosI[7]);$('#tabs-5-1').show();
			},100);
				
			}, close:function( event, ui ){ $( "#dialog-verPaciente" ).tabs( "destroy" );$('#dialog-verPaciente').empty();cargaFicha(); }
		});
		$('.rnacido').hide();
		$('#dialog-verPaciente').dialog('open');
	});//guardamso al nuevo paciente
 });
}//fin verPaciente

function activa(){ $(document).ready(function(e) {
	if($('#fichaNV').val()!='' & $('#horaNV').val()!=''){ $("#dialog-nuevaVisita").tabs({ active: 0, disabled: [ 7 ] });
	}else{$("#dialog-nuevaVisita").tabs({ active: 0, disabled: [ 1,2,3,4,5,6,7 ] });}
}); }

function reFoto1(){ $('#fileupload_foto').click(); }

function siempre(la,lo){
	cargaFoto();
	var i=0; $('#nvo_cto, .eliminar_cto, #b_subir_foto').click(function(event) { event.preventDefault(); });
	$('#tabs-2-1').click(function(e) {
	  if(i%2==0){i++;
	  var map = new google.maps.Map(document.getElementById('map'), {
		center: new google.maps.LatLng(la, lo), zoom: 16, scrollwheel: false //Cuautla :3
	  });
	  marker = new google.maps.Marker({
		map: map, draggable: true, animation: google.maps.Animation.DROP, position: new google.maps.LatLng(la, lo)
	  });

	  $('#p_latitud').text(redondear(la,4)); $('#p_latitud_s').val(la);
	  $('#p_longitud').text(redondear(lo,4)); $('#p_longitud_s').val(lo);
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

function nuevaVisita(i){//i es el id del paciente
$(document).ready(function(e) {//alert(i);
	$("#dialog-nuevaVisita").load("htmls/nueva_visita.php #tabs_nv",function(response, status, xhr ) {if ( status == "success" ){
		$("#procedenciaNV").load('genera/procedencia.php',function(response,status,xhr){if(status=="success"){
			$("#procedenciaNV").val(1);
		}});
		$('#dialog-indicacionesLab').dialog({
			autoOpen: false, modal: true, width: 800, height:600, title: 'INDICACIONES PARA EL PACIENTE DE LOS ESTUDIOS DE LABORATORIO', closeText: '',
			open:function( event, ui ){
				var datosIL = {aleatorio : $('#numeroTemporalNV').val() }
				$.post('files-serverside/indicacionesEstudiosL.php',datosIL).done(function( data ) {
					var datosIL = data.split(';}');
					$('#pacienteIL').text(datosIL[0]); $('#fechaIL').text(datosIL[1]);
				});
			
				var oTableILab; 
				oTableILab = $('#dataTableIL').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
					"sScrollY": $('#dialog-indicacionesLab').height()-120, "bStateSave": false, "bInfo": true, 
					"bFilter": true, "aaSorting": [[1, "asc"]], ordering: false, "bRetrieve": true,
					"aoColumns": [
						{ "bSortable": false }, { "bSortable": false }
					], "iDisplayLength": 50, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
					"sDom": '<"toolbarBMC"><"filtroBMC">lr<"data_tBMC"t><"infoBMC">S', 
					"sAjaxSource": "js/datatable-serverside/buscar_indicacionesLab.php",
					"fnServerParams": function (aoData, fnCallback) { 
						var aleatorio = $('#numeroTemporalNV').val();
						aoData.push( {"name": "aleatorio", "value": aleatorio } ); 
					},
					"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
					"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
					"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADAS: _END_", 
					"sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "<br/>INDICACIONES: _MAX_", "sSearch": "" }
				});/*fin datatable */ $('#miClickIL').click(function(e) { oTableILab.fnDraw(); });
			}, 
			buttons: { 
				"Imprimir": function() { $('#indicacionesLabo').printElement(); },
				"Cerrar": function() { $('#dialog-indicacionesLab').dialog('close'); } 
			}
		});
		
		$('#cancelSaveOV, #indicacionesLab').click(function(event) { event.preventDefault(); });
		$('#cancelSaveOV').button({icons:{primary:"ui-icon-cancel"},text:true});
		$('#indicacionesLab').button({icons:{primary:"ui-icon-info"},text:true}); $('#indicacionesLab').button('disable');
		$('#indicacionesLab').click(function(e) { $('#dialog-indicacionesLab').dialog('open'); });
		$('#checkbox-ag').checkboxradio({ icon: false });
		$('#checkbox-ag').click(function(e) {
			cancelarOV1($('#numeroTemporalNV').val());
            if($(this).prop('checked')==true){
				$('#agendarOV').val(1);
				$("#dialog-nuevaVisita").tabs({ active: 0, disabled: [ 1,2,3,4,5,6,7 ] });
				$('.agendita').show(); $('#fichaNV').focus();
			} 
			else{
				$('#agendarOV').val(0);
				$("#dialog-nuevaVisita").tabs({ active: 0, disabled: [ 7 ] });
				$('.agendita').hide();
			}
        });
		
		$('#fichaNV').datepicker({
			showButtonPanel: false, currentText: "Now", dateFormat: "yy-mm-dd", changeMonth: true, buttonText: "Choose",
			dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ],
			dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ], nextText: "Siguiente", prevText: "Anterior",
			dayNamesShort: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],
			monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
			monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
			showAnim: "fold", onSelect:function(){ activa(); }, minDate: -100000
		});
		
		$('#horaNV').change(function(e) { activa(); });
		
		$('#idPaciente_nv').val(i);
		var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {
			validateOn:["blur", "change"], useCharacterMasking:true, minValue:0, maxValue:100
		});
		
		$('#descuentoC_NV, #urgeCo').prop('disabled',true);
		$('#justificacionDeC_NV').val(''); $('#cargoUrgencia_NV').val(0);
		
		$('.justifDC').hide();
		
		$('#descuentoC_NV').focus(function(e) {
            if($(this).val()==0){$(this).val('');}
        }).focusout(function(e) {
            if($(this).val()==''){$(this).val(0);}
        }).keyup(function(e) {
            if($(this).val()<0){$(this).val(0);}
			if($(this).val()>100){$(this).val(100);}
			if($(this).val()>0 & $(this).val()<=100){
				$('.justifDC').show();
				var descuentoConsulta = ($(this).val() * $('#costoMC_NV').val())/parseFloat(100);
				$('#descuentoAdC_NV').val(descuentoConsulta);
				var totalConsulta = parseFloat($('#subtotalC_NV').val()) - parseFloat($('#descuentoAdC_NV').val()) + parseFloat($('#cargoUrgencia_NV').val());
				$('#totalC_NV').val(totalConsulta);
			}
			else{
				$('.justifDC').hide(); $('#justificacionDeC_NV').val('');
				$('#descuentoAdC_NV').val(0);
				var totalConsulta = parseFloat($('#subtotalC_NV').val()) + parseFloat($('#cargoUrgencia_NV').val());
				$('#totalC_NV').val(totalConsulta);
			}
        });
		
		$('#formNVisita').validate({ ignore:'hidden'} );
		$('#dialog-nuevaVisita input, #dialog-nuevaVisita select, #dialog-nuevaVisita textarea').addClass('campoITtab'); 
		$("#dialog-nuevaVisita").tabs({
			active: 0,
			disabled: [ 7 ], heightStyle: "content"
		});
		
		$('#idUsuario_nv').val($('#idUser').val()); var nv = new Date(); 
		$('#numeroTemporalNV').val(nv.format('Y-m-d-H-i-s-u').substring(0,22)); var cuad = 30;
		$('.botonNV').click(function(e) { e.preventDefault(); }); 

		$('.calendario').datepicker({
			changeMonth: true, changeMonth: true, nextText: "Siguiente", prevText: "Anterior", showAnim : "slideDown", 
			changeYear: true, maxDate: +1850, minDate: -365, dateFormat: "dd/mm/yy",
			dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ], 
			dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
			monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septimbre", "Octubre", 
			"Noviembre", "Diciembre" ], monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", 
			"Nov", "Dic"],
		}).css('text-align','center');
		
		$('#urgeCo').click(function(e) {if($(this).prop('checked')==true){$('#urgenteCo').val(1);}else{$('#urgenteCo').val(0);}});
		
		var idP = {idP : i, idU:$('#idUsuario_nv').val()}
		$.post('files-serverside/datosPacienteNuevaVisita.php',idP).done(function( data ) {
			var datos = data.split(';'); var titulo = 'NUEVA VISITA. PACIENTE '+datos[0]+' '+datos[2]+' '+datos[1]; 
			$('#idPaciente').val(i); $('#sucursalNV').val(datos[6]);//alert(datos[6]);
			$('#pacienteNV').val(datos[0]);	$('#sexoNV').val(datos[2]);	$('#edadNV').val(datos[1]);
			$('#sucursalNV').load('genera/genera_sucursales_ov.php?idU='+$('#idUser').val(), function(response,status,xhr){
				if (status = "success"){
					$('#sucursalNV').val(datos[6]);
					$('#sucursalNV').change(function(e) {
                        $('#cargoAdC_NV, #p_descuento_NV, #d_descuento_NV').prop('readonly',true); $('#cargoAdC_NV').val('');
						eliminarConsulta($('#numeroTemporalNV').val());$('#b_eliminarCoNV').hide(); $('#id_medicoCo').val('');
						$('#bBuscarConsulta').hide(); $('#descuentoC_NV, #urgeCo').prop('disabled',true);
						$('#justificacionDeC_NV').val(''); $('#cargoUrgencia_NV').val(0);
						$('.justifDC, .cargoU').hide();
						
						$('#cargoAdI_NV,#p_descuentoI_NV,#d_descuentoI_NV').prop('readonly',true); 
						$('#cargoAdI_NV,#p_descuentoI_NV,#d_descuentoI_NV,#t_descuentoI_NV').val('');
						eliminarEstudios($('#numeroTemporalNV').val());
						$('#b_eliminarImNV').hide();$('#b_estudiosImagenNV').hide();
						
						$('#cargoAdL_NV,#p_descuentoL_NV,#d_descuentoL_NV,#t_descuentoL_NV').prop('readonly',true);
						$('#cargoAdL_NV,#p_descuentoL_NV,#d_descuentoL_NV').val('');
						eliminarEstudiosLab($('#numeroTemporalNV').val());$('#b_estudiosLabNV').hide();
						$('#b_eliminarLaNV').hide();
						
						$('#cargoAdS_NV,#p_descuentoS_NV,#d_descuentoS_NV,#t_descuentoS_NV').prop('readonly',true); 
						$('#cargoAdS_NV,#p_descuentoS_NV,#d_descuentoS_NV').val('');
						eliminarServicios($('#numeroTemporalNV').val());
						$('#b_eliminarSeNV').hide();$('#id_pMedico').val('');
						$('#b_serviciosSNV').hide();
                    });
				}
			});
			$('#convenioNV').load('files-serverside/genera_conveniosPOV.php?idP='+i, function(response,status,xhr){
				if (status = "success"){ }
			}); //incluimos el indice del paciente
			
			if(datos[7]==1){ var exti = datos[9]; //alert(exti);
				var datosW = {aleatorio:datos[10]}
				$.post('files-serverside/datosFoto.php',datosW).done(function( data ){ 
					var t = "<div style='background-image:url(fotos/files/"+data+"."+exti+"?"+Math.round(Math.random()*1000)+");background-size:contain;background-repeat:no-repeat;background-position:center;background-color:white; width:100%; height:100%; cursor:;' class='conFoto' onClick=''></div>";
					$('#gallery').html(t);
				});
			}else{
				$('#gallery').css('background-color','rgba(255,255,255,0.6)').text('SIN FOTO');
			}
			
			window.setTimeout(function(){$("#dialog-nuevaVisita").css('overflow','hidden');},200);
			
			//Para escoger la consulta del catálogo de conceptos
			$('#bBuscarConsulta').click(function(e) {
				$("#dialog-buscaMedico").load("htmls/buscarConsulta.php #buscarConsulta", function( response, status, xhr ) { 
				if ( status == "success" ) {
					var he3 = $('#referencia').height() - 100; var wi3 = $('#referencia').width() * 0.98;
					$('#dialog-buscaMedico').dialog({ 
						title: 'BUSCAR LA CONSULTA', modal: true, autoOpen: true, closeText: '', width: wi3, height: he3, closeOnEscape: false, dialogClass: 'no-close',
						buttons: {
						"Aceptar": function() {
						   if($('.selected2').length >0 & $('#idUsadaConsulta').val()!=1){
							    $('#errorSeleccionConsulta').hide(); 
								$('#especialidadMC_NV').val($('#especialidadCT').val());$('#costoMC_NV').val($('#costoCT').val());
								$('#idAreaConsulta').val($('#idAreaConsultaT').val());
								$('#beneficio_NV').val($('#beneficioCT').val());
								$('#idConBene').val($('#idConBeneT').val());
								$('#idConcepto').val($('#idConceptoT').val()); $('#idBeneficioC').val($('#idBeneficioCT').val());
								$('#cargoAdC_NV,#p_descuento_NV,#d_descuento_NV').val(''); 
								$('#subtotalC_NV, #totalC_NV').val($('#costoCT').val());
								$('#cargoAdC_NV, #p_descuento_NV, #d_descuento_NV').prop('readonly',false);
								//guardamos en tabla venta de conceptos temporalmente a la consulta con el número aleatorio
								//i es el id del paciente
								guardarConsulta(
									$('#numeroTemporalNV').val(), i, $('#idUsuario_nv').val(), 
									$('#id_medicoCo').val(), $('#costoMC_NV').val(), $('#idBeneficioC').val(), 
									$('#totalC_NV').val(), 4, $('#idAreaConsulta').val(), 
									$('#idConcepto').val(),$('#sucursalNV').val(), $('#motivoC_NV').val(), $('#idConBene').val()
								);
								$('#dialog-buscaMedico').dialog('close');
						   }else{
						   	$('#errorSeleccionConsulta').hide().show('shake'); 
						   }
						},
						"Cancelar": function() { $('#dialog-buscaMedico').dialog('close'); }
					  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscaMedico').empty(); },
					  open:function( event, ui ){ 
						var oTableBMC1; 
						oTableBMC1 = $('#dataTableBConsulta').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
							"sScrollY": $('#dialog-buscaMedico').height()-90, "bStateSave": false, "bInfo": true, 
							"bFilter": true, "aaSorting": [[1, "asc"]], ordering: false,
							"bRetrieve": true,
							"aoColumns": [
								{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
							], "iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
							"sDom": '<"toolbarBMC"><"filtroBMC">lr<"data_tBMC"t><"infoBMC"i>S', 
							"sAjaxSource": "js/datatable-serverside/buscar_consulta.php",
							"fnServerParams": function (aoData, fnCallback) { 
							   	var idConvenio = $('#beneficioConsulta').val(), aleatorio = $('#numeroTemporalNV').val();
								var idMedico = $('#id_medicoCo').val(), idP = i;
								if(idConvenio==null){idConvenio=0;} //alert(idConvenio);
								aoData.push( {"name": "idConvenio", "value": idConvenio } );
								aoData.push( {"name": "aleatorio", "value": aleatorio } );
								aoData.push( {"name": "idMedico", "value": idMedico } ); 
								aoData.push( {"name": "idP", "value": idP } ); 
							},
							"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
							"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
							"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
							"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", "sSearch": "" }
						});/*fin datatable */ $('#clickme_bc').click(function(e) { oTableBMC1.fnDraw(); });
						
						$(".pieTablaBMCo input").keyup( function () { /* Filter on the column (the index) of this element */
							oTableBMC1.fnFilter( this.value, $(".pieTablaBMCo input").index(this) );
						});
						 	
						$('.filtroBMC input').attr("placeholder", "BUSQUE UNA CONSULTA AQUÍ, Y DELE CLIC PARA SEECCIONARLA...").addClass('placeHolder');
						$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
						$('.filtroBMC input').css('width',($('#dialog-buscaMedico').width() * 1) ); $('.filtroBMC').css('left',-16);
						$("div.toolbarBMC").css('white-space','nowrap').css('padding','0px');
						
						var tableBM = $('#dataTableBConsulta').DataTable();
						$('#dataTableBConsulta tbody').on('click','tr',function(){
							if($(this).hasClass('selected2')){$(this).removeClass('selected2');}
							else{
								tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
								$('#errorSeleccionConsulta').hide();
							}
						});
						
						$('#dataTableBConsulta tbody').on( 'click', 'tr', function () { 
							var nTdsBMC = $('td', this);
							var xl = $(nTdsBMC[3]).html().split('"'); var xl1 = $(nTdsBMC[0]).html().split('"');
							var idAreaCo = $(nTdsBMC[1]).html().split('"'); 
							var idCo_be = $(nTdsBMC[2]).html().split('"');
							var usadoC = $(nTdsBMC[0]).html().split('class="'); 
							if(typeof(usadoC[1]) != "undefined" && usadoC[1] !== null) {
								$('#idUsadaConsulta').val(1);
							}else{$('#idUsadaConsulta').val(0);}
							$('#idConBeneT').val(idCo_be[1]);
							
							$('#especialidadCT').val($(nTdsBMC[0]).text()); $('#costoCT').val($(nTdsBMC[2]).text());
							$('#beneficioCT').val($(nTdsBMC[3]).text()); //alert($(nTdsBMC[0]).text());
							$('#idBeneficioCT').val(xl[1]); $('#idConceptoT').val(xl1[1]); $('#idAreaConsultaT').val(idAreaCo[1]);
						});
						
						$("#beneficioConsulta").load("genera/beneficiosP.php?idP="+$('#idPaciente_nv').val(), 
						function( response, status, xhr ) { 
							if ( status == "success" ) {
								$('#beneficioConsulta').change(function(e) {
                      				$('#clickme_bc').click();
                                });
							} 
						});
						$('#cargoAdC_NV').keyup(function(e) {
							totalC($('#subtotalC_NV').val(),$(this).val(),$('#p_descuento_NV').val(),$('#d_descuento_NV').val());
                        });
						$('#cargoAdC_NV').focusout(function(e) {
							totalC($('#subtotalC_NV').val(),$(this).val(),$('#p_descuento_NV').val(),$('#d_descuento_NV').val()); 
						});
						
						$('#p_descuento_NV').keyup(function(e) {
                            totalC($('#subtotalC_NV').val(),$('#cargoAdC_NV').val(),$(this).val(),$('#d_descuento_NV').val());
                        });
						$('#p_descuento_NV').focusout(function(e) {
							totalC($('#subtotalC_NV').val(),$('#cargoAdC_NV').val(),$(this).val(),$('#d_descuento_NV').val());
						});
						
						$('#d_descuento_NV').keyup(function(e) {
                            totalC($('#subtotalC_NV').val(),$('#cargoAdC_NV').val(),$('#p_descuento_NV').val(),$(this).val());
                        });
						$('#d_descuento_NV').focusout(function(e) {
                            totalC($('#subtotalC_NV').val(),$('#cargoAdC_NV').val(),$('#p_descuento_NV').val(),$(this).val());
                        });
					  }
					});
				}});
			});
			//Fin escoger consulta de catálogo de conceptos
			$('#b_medicoConsultaNV').click(function(e) {
				$("#dialog-buscaMedico").load("htmls/dialogBuscarMedico.php #buscarMedicoX", function( response, status, xhr ) { 
				if ( status == "success" ) {
					var he3 = $('#referencia').height() - 100; var wi3 = $('#referencia').width() * 0.98;
					$('#dialog-buscaMedico').dialog({ 
						title:'BUSCAR AL PERSONAL MÉDICO PARA LA CONSULTA',modal:true, autoOpen: true, closeText: '', width: wi3, 
						height: he3, closeOnEscape: false, dialogClass: 'no-close',
						buttons: {
						"Aceptar": function() {
						   if($('.selected2').length >0){$('#errorSeleccionMédico').hide(); $('#b_eliminarCoNV').show();
						    $('#bBuscarConsulta').show(); $('#id_medicoCo').val($('#idMedicoConsultaT').val());
						    $('#especialidadMC_V').val($('#especialidadMedicoConsultaT').val());
							$('#medicoMC_NV').val($('#nombreMedicoConsultaT').val()); 
							$('#dialog-buscaMedico').dialog('close');
						   }else{ $('#errorSeleccionMédico').hide().show('shake'); }
						},
						"Cancelar": function() { $('#dialog-buscaMedico').dialog('close'); }
					  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscaMedico').empty(); },
					  open:function( event, ui ){ 
					  	var oTableBMC1;
						oTableBMC1 = $('#dataTableBMConsulta').dataTable({
							"bJQueryUI": true, "bRetrieve": true, ordering: false,
							"sScrollY": $('#dialog-buscaMedico').height()-90, "bStateSave": false, "bInfo": true, 
							"bFilter": true, "aaSorting": [[1, "asc"]],
							"aoColumns": [
								{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
							], "iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
							"sDom": '<"toolbarBMC"><"filtroBMC">lr<"data_tBMC"t><"infoBMC"i>S', 
							"sAjaxSource": "js/datatable-serverside/buscar_medico_consulta.php", 
							"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
							"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
							"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
							"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", "sSearch": "" }
						});//fin datatable
						
						$(".pieTablaBMCo input").keyup( function () { /* Filter on the column (the index) of this element */
							oTableBMC1.fnFilter( this.value, $(".pieTablaBMCo input").index(this) );
						});
						 	
						$('.filtroBMC input').attr("placeholder", "BUSQUE AL PERSONAL MÉDICO AQUÍ, Y DELE CLIC PARA SEECCIONARLO...").addClass('placeHolder');
						$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
						$('.filtroBMC input').css('width',($('#dialog-buscaMedico').width() * 1));$('.filtroBMC').css('left',-16);
						$("div.toolbarBMC").css('white-space','nowrap').css('padding','8px');
						
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
							$('#idMedicoConsultaT').val(idConsulta[1]);
							var nMedico = $(nTdsBMC[0]).text()+' '+$(nTdsBMC[1]).text()+' '+$(nTdsBMC[2]).text();
							$('#nombreMedicoConsultaT').val(nMedico); $('#especialidadMedicoConsultaT').val($(nTdsBMC[3]).text());
						}); //con la clave del médico sacamos su id
					  }
					});
				}});
			});
			$('#b_eliminarCoNV').click(function(e) {
				$('#textoPreguntar').text('¿ESTÁ SEGURO DE QUE DESEA ELIMINAR LA CONSULTA MÉDICA DE LA ORDEN DE VENTA?'); 
				$('#dialog-preguntar').dialog({ title: 'CANCELAR LA CONSULTA MÉDICA', modal: true, autoOpen: true, 
					closeText: '', width: 700, height: 200, closeOnEscape: true, dialogClass: '',
					buttons:{
						"Si":function(){
							$('#cargoAdC_NV, #p_descuento_NV, #d_descuento_NV').prop('readonly',true); $('#cargoAdC_NV').val('');
							eliminarConsulta($('#numeroTemporalNV').val());$('#b_eliminarCoNV').hide(); $('#id_medicoCo').val('');
							$('#dialog-preguntar').dialog('close'); $('#bBuscarConsulta').hide();
							$('#descuentoC_NV, #urgeCo').prop('disabled',true);
							$('#justificacionDeC_NV').val(''); $('#cargoUrgencia_NV').val(0);
							$('.justifDC, .cargoU').hide();
						}, 
						"No":function(){$(this).dialog('close');}} });
			});
			$('#tabs-3-1').click(function(e) { $('#clickmeI').click();
               var oTableENV;
				oTableENV = $('#dataTableEstudiosI').dataTable({ "bJQueryUI": true, "bRetrieve": true, ordering: false,
				"sScrollY": $('#contenedorENV').height()+50, "bStateSave": false, "bInfo": false, "bFilter": false, 
				"aaSorting": [[1, "asc"]],
				"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }], "iDisplayLength": 300, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
				"sDom": '<"toolbarENV"><"filtroENV"f>lr<"data_tENV"t><"infoENV"i>S', 
				"sAjaxSource": "js/datatable-serverside/estudios_imagen_nv.php", 
				"fnServerParams": function (aoData, fnCallback) { 
					var aleatorio = $('#numeroTemporalNV').val(); 
					aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
				},
				"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
				"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
				"sZeroRecords": "EL PACIENTE NO CUENTA CON ESTUDIOS DE IMAGEN EN LA ORDEN DE VENTA", "sInfo": "MOSTRADOS: _END_", 
				"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS: _MAX_", "sSearch": "" }
				});/*fin datatable*/  $('#clickmeI').click(function(e) { oTableENV.fnDraw(); });
            });
			$('#b_estudiosImagenNV').click(function(e) {
                $("#dialog-buscaMedico").load("htmls/dialogBuscarEstudiosI.php #buscarEstudiosX", 
				function( response, status, xhr ) { if ( status == "success" ) {
					var he3 = $('#referencia').height() - 100, wi3 = $('#referencia').width() * 0.98;
					$('#dialog-buscaMedico').dialog({ 
						title: 'BUSCAR LOS ESTUDIOS DE IMAGEN', modal: true, autoOpen: true, closeText: '', width: wi3, 
						height: he3, closeOnEscape: false, dialogClass: 'no-close',
						buttons: {
							"Aceptar": function() {
								checarHayEstudios($('#numeroTemporalNV').val(), 4, 2); 
							},
							"Cerrar": function() { $('#dialog-buscaMedico').dialog('close'); }
					  	}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscaMedico').empty(); },
					  	open:function( event, ui ){ var oTableBEI1;
							oTableBEI1 = $('#dataTableBEImagen').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
							"sScrollY": ($('#dialog-buscaMedico').height()-155)/2, "bStateSave": false, "bInfo": true, 
							"bFilter": true, "aaSorting": [[1, "asc"]], ordering: false,
							"aoColumns":[{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false}], 
							"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
							"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
							"sAjaxSource": "js/datatable-serverside/buscar_estudios_imagen.php", 
							"fnServerParams": function (aoData, fnCallback) { 
							   	var idConvenio = $('#beneficioImagen').val(), aleatorio = $('#numeroTemporalNV').val();
								var idSucursal = $('#sucursalNV').val(), idP = i;
								if(idConvenio==null){idConvenio=0;}
								aoData.push( {"name": "aleatorio", "value": aleatorio } );
								aoData.push( {"name": "idConvenio", "value": idConvenio } );
								aoData.push( {"name": "idSucursal", "value": idSucursal } );
								aoData.push( {"name": "idP", "value": idP } );
							},
							"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
							"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
							"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
							"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS: _MAX_", "sSearch": "" }
						}); $('#clickme_bei').click(function(e) { oTableBEI1.fnDraw(); });//fin datatable
						$(".pieTablaBEIm input").keyup( function () { /* Filter on the column (the index) of this element */
							oTableBEI1.fnFilter( this.value, $(".pieTablaBEIm input").index(this) );
						} );
							
						$('.filtroBMC input').attr("placeholder", "BUSQUE LOS ESTUDIOS AQUÍ, Y DELE CLIC PARA SEECCIONARLOS...").addClass('placeHolder');
						$('.infoBMC').hide(); $('.filtroBMC input').focus(); $('.filtroBMC input').css('width', ($('#dialog-buscaMedico').width() -16) ).hide(); $('.filtroBMC').css('left',-32);
						
						$("div.toolbarBMC").css('white-space','nowrap').css('padding','-8');
						
						var tableBM = $('#dataTableBEImagen').DataTable();
						$('#dataTableBEImagen tbody').on('click','tr',function(){
							if($(this).hasClass('selected2')){$(this).removeClass('selected2');}
							else{
								tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
								$('#errorSeleccionEstudios').hide();
							}
						});
						
						$('#dataTableBEImagen tbody').on( 'click', 'tr', function () { 
							var nTdsESNV = $('td', this); 
							var idEst = $(nTdsESNV[0]).html().split('"'), precioTo = $(nTdsESNV[1]).html().split('"');
							var idConvenio = $(nTdsESNV[3]).html().split('"'), idCo_beI = $(nTdsESNV[2]).html().split('"');
							
							var usadoI = $(nTdsESNV[0]).html().split('class="'); 
							if(typeof(usadoI[1]) != "undefined" && usadoI[1] !== null) { //alert(1);
							}else{
								$('#idConBeneIT').val(idCo_beI[1]); //alert($('#sucursalOV').val());
								subirEstudio(idEst[1], $('#numeroTemporalNV').val(), i, $('#idUsuario_nv').val(), 
									$('#id_medicoIm').val(),idConvenio[1],$('#sucursalNV').val(),$('#observacionesI_NV').val(), 
									2, precioTo[1], 4, $('#idConBeneIT').val()
								);
							}
						}); //con la clave del médico sacamos su id
						
						$("#beneficioImagen").load("genera/beneficiosP.php?idP="+$('#idPaciente_nv').val(), 
						function( response, status, xhr ) { 
							if ( status == "success" ) {
								$('#beneficioImagen').change(function(e) {
                      				$('#clickme_bei').click();
                                });
							} 
						});
						$('#cargoAdI_NV').keyup(function(e) {
							totalI($('#subtotalI_NV').val(),$(this).val(),$('#p_descuentoI_NV').val(),$('#d_descuentoI_NV').val());
                        });
						$('#cargoAdI_NV').focusout(function(e) {
							totalI($('#subtotalI_NV').val(),$(this).val(),$('#p_descuentoI_NV').val(),$('#d_descuentoI_NV').val());
						});
						
						$('#p_descuentoI_NV').keyup(function(e) {
                            totalI($('#subtotalI_NV').val(),$('#cargoAdI_NV').val(),$(this).val(),$('#d_descuentoI_NV').val());
                        });
						$('#p_descuentoI_NV').focusout(function(e) {
							totalI($('#subtotalI_NV').val(),$('#cargoAdI_NV').val(),$(this).val(),$('#d_descuentoI_NV').val());
						});
						
						$('#d_descuentoI_NV').keyup(function(e) {
                            totalI($('#subtotalI_NV').val(),$('#cargoAdI_NV').val(),$('#p_descuentoI_NV').val(),$(this).val());
                        });
						$('#d_descuentoI_NV').focusout(function(e) {
                            totalI($('#subtotalI_NV').val(),$('#cargoAdI_NV').val(),$('#p_descuentoI_NV').val(),$(this).val());
                        });
						
						var oTableESI1;
						oTableESI1 = $('#dataTableESImagen').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
						"sScrollY": ($('#dialog-buscaMedico').height()-155)/2, "bStateSave": false, "bInfo": false, 
						"bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
						"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
							calcularTotalesIm($('#numeroTemporalNV').val()); 
						},
						"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
						{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }], "iDisplayLength": 30, 
						"bLengthChange": false, "bProcessing": false, "bServerSide": true,
						"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
						"sAjaxSource": "js/datatable-serverside/estudios_seleccionados_imagen.php", 
						"fnServerParams": function (aoData, fnCallback) { 
							var aleatorio = $('#numeroTemporalNV').val(); 
							aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
						},
						"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
						"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
						"sZeroRecords":"SIN COINCIDENCIAS - LO SENTIMOS","sInfo": "MOSTRADOS: _END_","sInfoEmpty": "MOSTRADOS: 0",
						"sInfoFiltered": "<br/>MÉDICOS: _MAX_", "sSearch": "" }
						});/*fin datatable*/ $('#clickmeESI').click(function(e) { oTableESI1.fnDraw(); });
					  }
					});
				} });
            });
			$('#b_medicoImagenNV').click(function(e) {
				$("#dialog-buscaMedico").load("htmls/dialogBuscarMedico.php #buscarMedicoX", function( response, status, xhr ) { if ( status == "success" ) {
						
					var he3 = $('#referencia').height() - 100, wi3 = $('#referencia').width() * 0.98;
					$('#dialog-buscaMedico').dialog({ 
						title: 'BUSCAR EL MÉDICO PARA LOS ESTUDIOS DE IMAGEN', modal: true, autoOpen: true, closeText: '', 
						width: wi3, height: he3, closeOnEscape: false, dialogClass: 'no-close',
						buttons: {
						"Continuar": function() {
						   if($('.selected2').length >0){
						   	$('#errorSeleccionMédico').hide(); $('#b_eliminarImNV').show();
							$('#id_medicoIm').val($('#id_medicoImT').val()); 
							$('#medicoMI_NV').val($('#medicoMI_NVT').val());
							$('#dialog-buscaMedico').dialog('close'); $('#b_estudiosImagenNV').show();
						   }else{ 
						   		$('#b_estudiosImagenNV').hide(); $('#errorSeleccionMédico').hide().show('shake'); 
						   		$('#id_medicoIm').val(''); $('#b_eliminarImNV').hide(); 
						   }
						},
						"Nuevo médico externo": function() { nuevoMedicoExt(); },
						"Cancelar": function() { $('#dialog-buscaMedico').dialog('close'); }
					  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscaMedico').empty(); },
					  open:function( event, ui ){ var oTableBMI1;
						oTableBMI1 = $('#dataTableBMConsulta').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
							"sScrollY": $('#dialog-buscaMedico').height()-90, "bStateSave": false, "bInfo": true, 
							"bFilter": true, "aaSorting": [[1, "asc"]], ordering: false,
							"aoColumns": [
								{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
								{ "bSortable": false }
							], 
							"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
							"sDom": '<"toolbarBMC"><"filtroBMC">lr<"data_tBMC"t><"infoBMC"i>S', 
							"sAjaxSource": "js/datatable-serverside/buscar_medico_estudios.php", 
							"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
							"oLanguage": { 
								"sLengthMenu": "MONSTRANDO _MENU_ records per page", 
								"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", "sSearch": "" 
							}
						});/*fin datatable*/ $('#clickme_bme').click(function(e) { oTableBMI1.fnDraw(); });
						
						$(".pieTablaBMCo input").keyup( function () { /* Filter on the column (the index) of this element */
							oTableBMI1.fnFilter( this.value, $(".pieTablaBMCo input").index(this) );
						} );
						
						$('.filtroBMC input').attr("placeholder", "BUSQUE UN MÉDICO AQUÍ, Y DELE CLIC PARA SEECCIONARLO...").addClass('placeHolder');
						$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
						$('.filtroBMC input').css('width', ($('#dialog-buscaMedico').width() * 1) );$('.filtroBMC').css('left',-16);
						$("div.toolbarBMC").css('white-space','nowrap').css('padding','8px');
						
						var tableBM = $('#dataTableBMConsulta').DataTable();
						
						$('#dataTableBMConsulta tbody').on('click','tr',function(){
							if($(this).hasClass('selected2')){
								$(this).removeClass('selected2');}
							else{
								tableBM.$('tr.selected2').removeClass('selected2');
								$(this).addClass('selected2');$('#errorSeleccionMédico').hide();
							}
						});
						
						$('#dataTableBMConsulta tbody').on( 'click', 'tr', function () {
							var nTdsBMC = $('td', this);
							var idMedIm = $(nTdsBMC[0]).html().split('"');
							var nombreMim = $(nTdsBMC[0]).text()+' '+$(nTdsBMC[1]).text()+' '+$(nTdsBMC[2]).text();
							$('#id_medicoImT').val(idMedIm[1]); $('#medicoMI_NVT').val(nombreMim);
						});
					  }
					});
				}});
			});
			$('#b_eliminarImNV').click(function(e) {
				$('#textoPreguntar').text('¿ESTÁ SEGURO DE QUE DESEA ELIMINAR LOS ESTUDIOS DE IMAGEN DE LA ORDEN DE VENTA?'); 
				$('#dialog-preguntar').dialog({ title: 'ELIMINACIÓN DE LOS ESTUDIOS DE IMAGEN', modal: true, autoOpen: true, 
					closeText: '', width: 700, height: 200, closeOnEscape: true, dialogClass: '',
					buttons:{
						"Si":function(){ 
							$('#cargoAdI_NV,#p_descuentoI_NV,#d_descuentoI_NV').prop('readonly',true); 
							$('#cargoAdI_NV,#p_descuentoI_NV,#d_descuentoI_NV,#t_descuentoI_NV').val('');
							eliminarEstudios($('#numeroTemporalNV').val());
							$('#b_eliminarImNV').hide();$('#b_estudiosImagenNV').hide();$('#dialog-preguntar').dialog('close'); },
						"No":function(){$(this).dialog('close');}
					} 
				});
			});
			$('#tabs-4-1').click(function(e) { $('#clickmeL').click();
               var oTableELNV;
				oTableELNV = $('#dataTableEstudiosL').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
				"sScrollY": $('#contenedorELNV').height()+50, "bStateSave": false, "bInfo": false, "bFilter": false, 
				"aaSorting": [[1, "asc"]], "aoColumns": [{ "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }], "iDisplayLength": 300, 
				"bLengthChange": false, "bProcessing": false, "bServerSide": true, ordering: false,
				"sDom": '<"toolbarELNV"><"filtroELNV"f>lr<"data_tELNV"t><"infoELNV"i>S', 
				"sAjaxSource": "js/datatable-serverside/estudios_lab_nv.php", 
				"fnServerParams": function (aoData, fnCallback) { 
					var aleatorio = $('#numeroTemporalNV').val(); 
					aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
				},
				"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
				"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
				"sZeroRecords": "EL PACIENTE NO CUENTA CON ESTUDIOS DE LABORATORIO EN LA ORDEN DE VENTA", 
				"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS: _MAX_", "sSearch": "" }
				});/*fin datatable*/  $('#clickmeL').click(function(e) { oTableELNV.fnDraw(); });
            });
			$('#b_estudiosLabNV').click(function(e) {
                $("#dialog-buscaMedico").load("htmls/dialogBuscarEstudiosI.php #buscarEstudiosX", 
				function( response, status, xhr ) { if ( status == "success" ) {
					var he3 = $('#referencia').height() - 100, wi3 = $('#referencia').width() * 0.98;
					$('#dialog-buscaMedico').dialog({ 
						title: 'BUSCAR LOS ESTUDIOS DE LABORATORIO', modal: true, autoOpen: true, closeText: '', width: wi3, 
						height: he3, closeOnEscape: false, dialogClass: 'no-close',
						buttons: { 
							"Aceptar": function() { checarHayEstudios($('#numeroTemporalNV').val(), 3, 1); }, 
							"Cerrar": function() { $('#dialog-buscaMedico').dialog('close'); }
					  	}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscaMedico').empty(); checarHayEstudios($('#numeroTemporalNV').val(), 3, 1); },
					  	open:function( event, ui ){ var oTableBEL1;
						oTableBEL1 = $('#dataTableBEImagen').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
						"sScrollY": ($('#dialog-buscaMedico').height()-155)/2, "bStateSave": false, "bInfo": true, 
						"bFilter": true, "aaSorting": [[1, "asc"]], "aoColumns": [{ "bSortable": false }, { "bSortable": false }, 
						{ "bSortable": false }, { "bSortable": false }], "iDisplayLength": 30, "bLengthChange": false, 
						"bProcessing": false, "bServerSide": true, ordering: false,
						"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
						"sAjaxSource": "js/datatable-serverside/buscar_estudios_lab.php",
						"fnServerParams": function (aoData, fnCallback) { 
							var idConvenio = $('#beneficioImagen').val(), aleatorio = $('#numeroTemporalNV').val();
							var idSucursal = $('#sucursalNV').val(), idP = i;
							if(idConvenio==null){idConvenio=0;}
							aoData.push( {"name": "aleatorio", "value": aleatorio } );
							aoData.push( {"name": "idConvenio", "value": idConvenio } );
							aoData.push( {"name": "idSucursal", "value": idSucursal } );
							aoData.push( {"name": "idP", "value": idP } );
						},
						"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
						"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
						"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
						"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", "sSearch": "" }
						}); $('#clickme_bei').click(function(e){oTableBEL1.fnDraw();}); //fin datatable
						$(".pieTablaBEIm input").keyup( function () { /* Filter on the column (the index) of this element */
							oTableBEL1.fnFilter( this.value, $(".pieTablaBEIm input").index(this) );
						} );
						$('.filtroBMC input').attr("placeholder", "BUSQUE LOS ESTUDIOS AQUÍ, Y DELE CLIC PARA SEECCIONARLOS...").addClass('placeHolder');
						$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
						$('.filtroBMC input').css('width', ($('#dialog-buscaMedico').width() -16) ).hide(); 
						$('.filtroBMC').css('left',-32);
						
						var tableBM = $('#dataTableBEImagen').DataTable();
						$('#dataTableBEImagen tbody').on('click','tr',function(){
							if($(this).hasClass('selected2')){ $(this).removeClass('selected2'); }
							else{
								tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
								$('#errorSeleccionEstudios').hide();
							}
						});
						
						$('#dataTableBEImagen tbody').on( 'click', 'tr', function () { 
							var nTdsESNV = $('td', this); 
							var idEst = $(nTdsESNV[0]).html().split('"'), precioTo = $(nTdsESNV[1]).html().split('"');
							var idConvenio = $(nTdsESNV[3]).html().split('"'), idCo_beL = $(nTdsESNV[2]).html().split('"');
							
							var usadoL = $(nTdsESNV[0]).html().split('class="'); 
							if(typeof(usadoL[1]) != "undefined" && usadoL[1] !== null) { //alert(1);
							}else{
								$('#idConBeneLT').val(idCo_beL[1]);
								subirEstudio(idEst[1], $('#numeroTemporalNV').val(), i, $('#idUsuario_nv').val(), 
									$('#id_medicoLab').val(),idConvenio[1],$('#sucursalNV').val(),$('#observacionesL_NV').val(), 
									1, precioTo[1], 3, $('#idConBeneLT').val()
								);
							}
						}); //con la clave del médico sacamos su id
						
						$("#beneficioImagen").load("genera/beneficiosP.php?idP="+$('#idPaciente_nv').val(), 
						function( response, status, xhr ) { if ( status == "success" ) {
								$('#beneficioImagen').change(function(e) { $('#clickme_bei').click(); });
						} });
						$('#cargoAdL_NV').keyup(function(e) {
						  totalL($('#subtotalL_NV').val(),$(this).val(),$('#p_descuentoL_NV').val(),$('#d_descuentoL_NV').val());
                        });
						$('#cargoAdL_NV').focusout(function(e) {
						  totalL($('#subtotalL_NV').val(),$(this).val(),$('#p_descuentoL_NV').val(),$('#d_descuentoL_NV').val());
						});
						
						$('#p_descuentoL_NV').keyup(function(e) {
                            totalL($('#subtotalL_NV').val(),$('#cargoAdL_NV').val(),$(this).val(),$('#d_descuentoL_NV').val());
                        });
						$('#p_descuentoL_NV').focusout(function(e) {
							totalL($('#subtotalL_NV').val(),$('#cargoAdL_NV').val(),$(this).val(),$('#d_descuentoL_NV').val());
						});
						
						$('#d_descuentoL_NV').keyup(function(e) {
                            totalL($('#subtotalL_NV').val(),$('#cargoAdL_NV').val(),$('#p_descuentoL_NV').val(),$(this).val());
                        });
						$('#d_descuentoL_NV').focusout(function(e) {
                            totalL($('#subtotalL_NV').val(),$('#cargoAdL_NV').val(),$('#p_descuentoL_NV').val(),$(this).val());
                        });
						
						var oTableESL1;
						oTableESL1 = $('#dataTableESImagen').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
						"sScrollY": ($('#dialog-buscaMedico').height()-155)/2, "bStateSave": false, "bInfo": false, 
						"bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
						"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
							calcularTotalesLab($('#numeroTemporalNV').val()); 
						},
						"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
							{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }
						], 
						"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
						"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
						"sAjaxSource": "js/datatable-serverside/estudios_seleccionados_lab.php", 
						"fnServerParams": function (aoData, fnCallback) { 
							var aleatorio = $('#numeroTemporalNV').val(); 
							aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
						},
						"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
						"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
							"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
							"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", "sSearch": "" 
						}
						});/*fin datatable*/ $('#clickmeESI').click(function(e) { oTableESL1.fnDraw(); });
					  }
					});
				} });
            });
			$('#b_medicoLabNV').click(function(e) {
				$("#dialog-buscaMedico").load("htmls/dialogBuscarMedico.php #buscarMedicoX", function( response, status, xhr ) { 
				if ( status == "success" ) {
					var he3 = $('#referencia').height() - 100, wi3 = $('#referencia').width() * 0.98;
					$('#dialog-buscaMedico').dialog({ 
						title: 'BUSCAR EL MÉDICO PARA LOS ESTUDIOS DE LABORATORIO', modal: true, autoOpen: true, closeText: '', 
						width: wi3, height: he3, closeOnEscape: false, dialogClass: 'no-close',
						buttons: {
							"Continuar": function() {
							   if($('.selected2').length >0){
								   	$('#errorSeleccionMédico').hide(); $('#b_eliminarLaNV').show();
									$('#id_medicoLab').val($('#id_medicoLabT').val()); 
									$('#medicoML_NV').val($('#medicoML_NVT').val());
									$('#dialog-buscaMedico').dialog('close'); $('#b_estudiosLabNV').show();
							   }else{ 
							   		$('#b_estudiosLabNV').hide(); $('#errorSeleccionMédico').hide().show('shake'); 
									$('#id_medicoLab').val(''); $('#b_eliminarLaNV').hide();
								}
							},
							"Nuevo médico externo": function() { nuevoMedicoExt(); },
							"Cancelar": function() { $('#dialog-buscaMedico').dialog('close'); }
					  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscaMedico').empty(); },
					  open:function( event, ui ){ var oTableBML1;
						oTableBML1 = $('#dataTableBMConsulta').dataTable({ 
							"bJQueryUI": true, "bRetrieve": true,  "sScrollY": $('#dialog-buscaMedico').height()-90, 
							"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[1, "asc"]],
							"aoColumns":[ {"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false} ], 
							"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
							"sDom": '<"toolbarBMC"><"filtroBMC">lr<"data_tBMC"t><"infoBMC"i>S', ordering: false,
							"sAjaxSource": "js/datatable-serverside/buscar_medico_estudios.php", 
							"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
							"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
								"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", "sSearch": "" 
							}
						});/*fin datatable*/ $('#clickme_bme').click(function(e) { oTableBML1.fnDraw(); });
						
						$(".pieTablaBMCo input").keyup( function () { /* Filter on the column (the index) of this element */
							oTableBML1.fnFilter( this.value, $(".pieTablaBMCo input").index(this) );
						} );
						
						$('.filtroBMC input').attr("placeholder", "BUSQUE UN MÉDICO AQUÍ, Y DELE CLIC PARA SEECCIONARLO...").addClass('placeHolder');
						$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
						$('.filtroBMC input').css('width', ($('#dialog-buscaMedico').width() * 1) ); 
						$('.filtroBMC').css('left',-16);
						$("div.toolbarBMC").css('white-space','nowrap').css('padding','8px');
						
						var tableBM = $('#dataTableBMConsulta').DataTable();
						$('#dataTableBMConsulta tbody').on('click','tr',function(){
							if($(this).hasClass('selected2')){
								$(this).removeClass('selected2');
							}else{
								tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
								$('#errorSeleccionMédico').hide();
							}
						});
						
						$('#dataTableBMConsulta tbody').on( 'click', 'tr', function () {
							var nTdsBMC = $('td', this);
							var idMedLa = $(nTdsBMC[0]).html().split('"');
							var nombreMla = $(nTdsBMC[0]).text()+' '+$(nTdsBMC[1]).text()+' '+$(nTdsBMC[2]).text();
							$('#id_medicoLabT').val(idMedLa[1]); $('#medicoML_NVT').val(nombreMla); 
						}); 
					  }
					});
				}});
			});
			$('#b_eliminarLaNV').click(function(e) {
				$('#textoPreguntar').text('¿ESTÁ SEGURO DE ELIMINAR LOS ESTUDIOS DE LABORATORIO DE LA ORDEN DE VENTA?');
				
				$('#dialog-preguntar').dialog({ title: 'ELIMINACIÓN DE LOS ESTUDIOS DE LABORATORIO', modal: true, autoOpen: true,
				closeText: '', width: 700, height: 200, closeOnEscape: true, dialogClass: '',
				buttons:{
					"Si":function(){ 
						$('#cargoAdL_NV,#p_descuentoL_NV,#d_descuentoL_NV,#t_descuentoL_NV').prop('readonly',true);
						$('#cargoAdL_NV,#p_descuentoL_NV,#d_descuentoL_NV').val('');
						eliminarEstudiosLab($('#numeroTemporalNV').val());$('#b_estudiosLabNV').hide();$('#b_eliminarLaNV').hide();
						$('#dialog-preguntar').dialog('close'); 
					}, 
					"No":function(){$(this).dialog('close');}} });
			});
			
			$('#tabs-5-1').click(function(e) { $('#clickmeS').click();
               var oTableSNV;
				oTableSNV = $('#dataTableServiciosS').dataTable({ 
					"bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#contenedorSNV').height()+50, "bStateSave": false, 
					"bInfo": false, "bFilter": false, "aaSorting": [[1, "asc"]], ordering: false,
					"aoColumns": [
						{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
						{ "bSortable": false }
					], "iDisplayLength": 300, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
					"sDom": '<"toolbarELNV"><"filtroELNV"f>lr<"data_tELNV"t><"infoELNV"i>S', 
					"sAjaxSource": "js/datatable-serverside/servicios_nv.php", 
					"fnServerParams": function (aoData, fnCallback) { 
						var aleatorio = $('#numeroTemporalNV').val(); 
						aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
					}, "aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
					"oLanguage":{ 
						"sLengthMenu": "MONSTRANDO _MENU_ records per page", 
						"sZeroRecords": "EL PACIENTE NO CUENTA CON SERVICIOS EN LA ORDEN DE VENTA","sInfo":"MOSTRADOS: _END_",
						"sInfoEmpty": "MOSTRADOS: 0","sInfoFiltered": "<br/>SERVICIOS: _MAX_", "sSearch": "" 
					}
				});/*fin datatable*/  $('#clickmeS').click(function(e) { oTableSNV.fnDraw(); });
            });
			$('#b_serviciosSNV').click(function(e) {
                $("#dialog-buscaMedico").load("htmls/dialogBuscarEstudiosI.php #buscarServiciosX", 
				function( response, status, xhr ) { if ( status == "success" ) {
					var he3 = $('#referencia').height() - 100, wi3 = $('#referencia').width() * 0.98;
					$('#dialog-buscaMedico').dialog({ 
						title: 'BUSCAR LOS SERVICIOS', modal: true, autoOpen: true, closeText: '', width: wi3, height: he3,
						closeOnEscape: false, dialogClass: 'no-close',
						buttons: {
							"Aceptar": function() { checarHayEstudios($('#numeroTemporalNV').val(), 2, 0); },
							"Cerrar": function() { $('#dialog-buscaMedico').dialog('close'); }
					  	}, create: function( event, ui ) {}, 
						close:function( event, ui ){ $('#dialog-buscaMedico').empty(); $('#clickmeS').click(); },
					  	open:function( event, ui ){ var oTableBS1;
							oTableBS1 = $('#dataTableBEImagen').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
							"sScrollY": ($('#dialog-buscaMedico').height()-155)/2, "bStateSave": false, "bInfo": true, 
							"bFilter": true, "aaSorting": [[1, "asc"]], ordering: false,
							"aoColumns": [
								{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
							], 
							"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
							"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
							"sAjaxSource": "js/datatable-serverside/buscar_servicios.php",
							"fnServerParams": function (aoData, fnCallback) { 
							   	var idConvenio = $('#beneficioServicios').val(), aleatorio = $('#numeroTemporalNV').val();
								var idSucursal = $('#sucursalNV').val(), idP = i;
								if(idConvenio==null){idConvenio=0;}
								aoData.push( {"name": "aleatorio", "value": aleatorio } ); 
								aoData.push( {"name": "idConvenio", "value": idConvenio } );
								aoData.push( {"name": "idP", "value": i } );
								aoData.push( {"name": "idSucursal", "value": idSucursal } );
							},
							"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
							"oLanguage": { 
								"sLengthMenu": "MONSTRANDO _MENU_ records per page", 
								"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", "sSearch": "" 
							}
						}); $('#clickme_bs').click(function(e) {oTableBS1.fnDraw();});//fin datatable
						
						$(".pieTablaBEIm input").keyup( function () { /* Filter on the column (the index) of this element */
							oTableBS1.fnFilter( this.value, $(".pieTablaBEIm input").index(this) );
						} );
						$('.filtroBMC input').attr("placeholder", "BUSQUE LOS SERVICIOS AQUÍ, Y DELE CLIC PARA SEECCIONARLOS...").addClass('placeHolder');
						$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
						$('.filtroBMC input').css('width', ($('#dialog-buscaMedico').width() -16) ).hide(); 
						$('.filtroBMC').css('left',-32);
						
						var tableBM = $('#dataTableBEImagen').DataTable();
						$('#dataTableBEImagen tbody').on('click','tr',function(){
							if($(this).hasClass('selected2')){
								$(this).removeClass('selected2');
							}else{
								tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
								$('#errorSeleccionEstudios').hide();
							}
						});
						
						$('#dataTableBEImagen tbody').on( 'click', 'tr', function () { 
							var nTdsESNV = $('td', this); 
							var idSer = $(nTdsESNV[0]).html().split('"'), precioTo = $(nTdsESNV[1]).html().split('"');
							var idConvenio = $(nTdsESNV[3]).html().split('"'), idDeprtamento = $(nTdsESNV[2]).html().split('"');
							var idDepto = idDeprtamento[1].split(';'), idCo_beS = idDepto[1];
							
							var usadoS = $(nTdsESNV[0]).html().split('class="'); 
							if(typeof(usadoS[1]) != "undefined" && usadoS[1] !== null) { //alert(1);
							}else{
								$('#idConBeneST').val(idCo_beS);
								subirServicio(idSer[1], $('#numeroTemporalNV').val(), i, $('#idUsuario_nv').val(), 
									$('#id_pMedico').val(),idConvenio[1],$('#sucursalNV').val(),$('#observacionesS_NV').val(), 
									idDepto[0], precioTo[1], 2, $('#idConBeneST').val()
								);
							}
						}); //con la clave del médico sacamos su id
						
						$("#beneficioServicios").load("genera/beneficiosP.php?idP="+$('#idPaciente_nv').val(), 
						function( response, status, xhr ) { 
							if ( status == "success" ) {
								$('#beneficioServicios').change(function(e) {
                      				$('#clickme_bs').click();
                                });
							} 
						});
						$('#cargoAdS_NV').keyup(function(e) {
						  totalS($('#subtotalS_NV').val(),$(this).val(),$('#p_descuentoS_NV').val(),$('#d_descuentoS_NV').val());
                        });
						$('#cargoAdS_NV').focusout(function(e) {
						  totalS($('#subtotalS_NV').val(),$(this).val(),$('#p_descuentoS_NV').val(),$('#d_descuentoS_NV').val());
						});
						
						$('#p_descuentoS_NV').keyup(function(e) {
                            totalS($('#subtotalS_NV').val(),$('#cargoAdS_NV').val(),$(this).val(),$('#d_descuentoS_NV').val());
                        });
						$('#p_descuentoS_NV').focusout(function(e) {
							totalS($('#subtotalS_NV').val(),$('#cargoAdS_NV').val(),$(this).val(),$('#d_descuentoS_NV').val());
						});
						
						$('#d_descuentoS_NV').keyup(function(e) {
                            totalS($('#subtotalS_NV').val(),$('#cargoAdS_NV').val(),$('#p_descuentoS_NV').val(),$(this).val());
                        });
						$('#d_descuentoS_NV').focusout(function(e) {
                            totalS($('#subtotalS_NV').val(),$('#cargoAdS_NV').val(),$('#p_descuentoS_NV').val(),$(this).val());
                        });
						
						var oTableSER1;
						oTableSER1 = $('#dataTableESImagen').dataTable({ 
							"bJQueryUI": true, "bRetrieve": true, "sScrollY": ($('#dialog-buscaMedico').height()-155)/2,
							"bStateSave": false, "bInfo": false, "bFilter": false, "aaSorting": [[0, "asc"]],
							"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
								calcularTotalesServicios($('#numeroTemporalNV').val()); 
							}, ordering: false,
							"aoColumns": [
								{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
								{ "bSortable": false }, { "bSortable": false }
							], "iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
							"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
							"sAjaxSource": "js/datatable-serverside/servicios_seleccionados.php", 
							"fnServerParams": function (aoData, fnCallback) { 
								var aleatorio = $('#numeroTemporalNV').val(); 
								aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
							}, "aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
							"oLanguage": { 
								"sLengthMenu": "MONSTRANDO _MENU_ records per page", 
								"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", "sSearch": "" 
							}
						});/*fin datatable*/ $('#clickmeESI').click(function(e) { oTableSER1.fnDraw(); });
					  }
					});
				}});
            });
			$('#b_personalMedicoLabNV').click(function(e) {
					$("#dialog-buscaMedico").load("htmls/dialogBuscarPersonalM.php #buscarMedicoX", 
					function( response, status, xhr ) { if ( status == "success" ) {
						var he3 = $('#referencia').height() - 100, wi3 = $('#referencia').width() * 0.98;
						$('#dialog-buscaMedico').dialog({ 
							title: 'BUSCAR AL MÉDICO REFERIDO PARA LOS SERVICIOS', modal: true, autoOpen: true, closeText: '', 
							width: wi3, height: he3, closeOnEscape: false, dialogClass: 'no-close',
							buttons: {
								"Aceptar": function() {
								   if($('.selected2').length >0){
									   	$('#errorSeleccionMédico').hide(); $('#b_eliminarSeNV').show();
										$('#id_pMedico').val($('#id_pMedicoT').val());
										$('#medicoPMS_NV').val($('#medicoPMS_NVT').val());
										$('#puestoPMS_NV_NV').val($('#puestoPMS_NV_NVT').val());
										$('#dialog-buscaMedico').dialog('close'); $('#b_serviciosSNV').show();
								   }else{ 
								   		$('#b_serviciosSNV').hide();$('#errorSeleccionMédico').hide().show('shake'); 
										$('#id_pMedico').val(''); $('#b_eliminarSeNV').hide();
									}
								},
								"Cancelar": function() { $('#dialog-buscaMedico').dialog('close'); }
						  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscaMedico').empty(); },
						  open:function( event, ui ){ var oTableBPMS1;
							oTableBPMS1 = $('#dataTableBMConsulta').dataTable({ 
								"bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#dialog-buscaMedico').height()-90, 
								"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[1, "asc"]],
								"aoColumns": [
									{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
								], "iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
								"sDom": '<"toolbarBMC"><"filtroBMC">lr<"data_tBMC"t><"infoBMC"i>S', ordering: false,
								"sAjaxSource": "js/datatable-serverside/buscar_pmedico_servicios.php", 
								"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
								"oLanguage": { 
									"sLengthMenu": "MONSTRANDO _MENU_ records per page", 
									"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
									"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>PERSONAL: _MAX_", "sSearch": "" 
								}
							});//fin datatable
							$(".pieTablaBMCo input").keyup( function () { /* Filter on the column (the index) of this element */
								oTableBPMS1.fnFilter( this.value, $(".pieTablaBMCo input").index(this) );
							} );
						
							$('.filtroBMC input').attr("placeholder", "BUSQUE AL MÉDICO AQUÍ, Y DELE CLIC PARA SEECCIONARLO...").addClass('placeHolder');
							$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
							$('.filtroBMC input').css('width', ($('#dialog-buscaMedico').width() * 1) ); 
							$('.filtroBMC').css('left',-16);
							$("div.toolbarBMC").css('white-space','nowrap').css('padding','8px');
							
							var tableBM = $('#dataTableBMConsulta').DataTable();
							$('#dataTableBMConsulta tbody').on('click','tr',function(){
								if($(this).hasClass('selected2')){
									$(this).removeClass('selected2');
								}else{
									tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
									$('#errorSeleccionMédico').hide();
								}
							});
							
							$('#dataTableBMConsulta tbody').on( 'click', 'tr', function () { 
								var nTdsBMC = $('td', this); var idPM = $(nTdsBMC[0]).html().split('"');
								$('#id_pMedicoT').val(idPM[1]); $('#puestoPMS_NV_NVT').val($(nTdsBMC[3]).text());
								var nombrePM = $(nTdsBMC[0]).text()+' '+$(nTdsBMC[1]).text()+' '+$(nTdsBMC[2]).text();
								$('#medicoPMS_NVT').val(nombrePM);
							}); //con la clave del médico sacamos su id
						  }
						});
					}});
				});
				$('#b_eliminarSeNV').click(function(e) {
					$('#textoPreguntar').text('¿ESTÁ SEGURO DE ELIMINAR LOS SERVICIOS MÉDICOS DE LA ORDEN DE VENTA?'); 
					$('#dialog-preguntar').dialog({ 
						title: 'ELIMINACIÓN DE LOS SERVICIOS', modal: true, autoOpen: true, closeText: '', width: 700, height: 200, 
						closeOnEscape: true, dialogClass: '',
						buttons:{
							"Si":function(){ 
								$('#cargoAdS_NV,#p_descuentoS_NV,#d_descuentoS_NV,#t_descuentoS_NV').prop('readonly',true); 
								$('#cargoAdS_NV,#p_descuentoS_NV,#d_descuentoS_NV').val('');
								eliminarServicios($('#numeroTemporalNV').val());
								$('#b_eliminarSeNV').hide();$('#id_pMedico').val('');
								$('#b_serviciosSNV').hide();$('#dialog-preguntar').dialog('close');
							},
							"No":function(){$(this).dialog('close');}
						} 
					});
				});
				
			$('#tabs-8-1').click(function(e) { $('#clickmeE').click();
               var oTableEENV;
				oTableEENV = $('#dataTableEstudiosE').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
				"sScrollY": $('#contenedorENDV').height()+50, "bStateSave": false, "bInfo": false, "bFilter": false, 
				"aaSorting": [[1, "asc"]], "aoColumns": [{ "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }], "iDisplayLength": 300, 
				"bLengthChange": false, "bProcessing": false, "bServerSide": true, ordering: false,
				"sDom": '<"toolbarELNV"><"filtroELNV"f>lr<"data_tELNV"t><"infoELNV"i>S', 
				"sAjaxSource": "js/datatable-serverside/estudios_end_nv.php", 
				"fnServerParams": function (aoData, fnCallback) { 
					var aleatorio = $('#numeroTemporalNV').val(); 
					aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
				},
				"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
				"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
				"sZeroRecords": "EL PACIENTE NO CUENTA CON ESTUDIOS DE ENDOSCOPIA EN LA ORDEN DE VENTA", 
				"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS: _MAX_", "sSearch": "" }
				});/*fin datatable*/  $('#clickmeE').click(function(e) { oTableEENV.fnDraw(); });
            });
			$('#b_estudiosEndoNV').click(function(e) {
                $("#dialog-buscaMedico").load("htmls/dialogBuscarEstudiosE.php #buscarEstudiosX", 
				function( response, status, xhr ) { if ( status == "success" ) {
					var he3 = $('#referencia').height() - 100, wi3 = $('#referencia').width() * 0.98;
					$('#dialog-buscaMedico').dialog({ 
						title: 'BUSCAR LOS ESTUDIOS DE ENDOSCOPÍA', modal: true, autoOpen: true, closeText: '', width: wi3, 
						height: he3, closeOnEscape: false, dialogClass: 'no-close',
						buttons: { 
							"Aceptar": function() { checarHayEstudios($('#numeroTemporalNV').val(), 5, 15); }, 
							"Cerrar": function() { $('#dialog-buscaMedico').dialog('close'); }
					  	}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscaMedico').empty(); },
					  	open:function( event, ui ){ var oTableBEL1;
						oTableBEL1 = $('#dataTableBEEndoscopia').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
						"sScrollY": ($('#dialog-buscaMedico').height()-155)/2, "bStateSave": false, "bInfo": true, 
						"bFilter": true, "aaSorting": [[1, "asc"]], "aoColumns": [{ "bSortable": false }, { "bSortable": false }, 
						{ "bSortable": false }, { "bSortable": false }], "iDisplayLength": 30, "bLengthChange": false, 
						"bProcessing": false, "bServerSide": true, ordering: false,
						"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
						"sAjaxSource": "js/datatable-serverside/buscar_estudios_endo.php",
						"fnServerParams": function (aoData, fnCallback) { 
							var idConvenio = $('#beneficioEndoscopia').val(), aleatorio = $('#numeroTemporalNV').val();
							if(idConvenio==null){idConvenio=0;}
							aoData.push( {"name": "aleatorio", "value": aleatorio } ); 
							aoData.push( {"name": "idConvenio", "value": idConvenio } );							
						},
						"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
						"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
						"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
						"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS: _MAX_", "sSearch": "" }
						}); $('#clickme_bee').click(function(e){oTableBEL1.fnDraw();}); //fin datatable
						$(".pieTablaBEIm input").keyup( function () { /* Filter on the column (the index) of this element */
							oTableBEL1.fnFilter( this.value, $(".pieTablaBEIm input").index(this) );
						} );
						$('.filtroBMC input').attr("placeholder", "BUSQUE LOS ESTUDIOS AQUÍ, Y DELE CLIC PARA SEECCIONARLOS...").addClass('placeHolder');
						$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
						$('.filtroBMC input').css('width', ($('#dialog-buscaMedico').width() -16) ).hide(); 
						$('.filtroBMC').css('left',-32);
						
						var tableBM = $('#dataTableBEEndoscopia').DataTable();
						$('#dataTableBEEndoscopia tbody').on('click','tr',function(){
							if($(this).hasClass('selected2')){
								$(this).removeClass('selected2');
							}
							else{
								tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
								$('#errorSeleccionEstudios').hide();
							}
						});
						
						$('#dataTableBEEndoscopia tbody').on( 'click', 'tr', function () { 
							var nTdsESNV = $('td', this); 
							var idEst = $(nTdsESNV[0]).html().split('"'), precioTo = $(nTdsESNV[1]).html().split('"');
							var idCo_beE = $(nTdsESNV[2]).html().split('"'), idConvenio = $(nTdsESNV[3]).html().split('"');
							
							var usadoE = $(nTdsESNV[0]).html().split('class="'); 
							if(typeof(usadoE[1]) != "undefined" && usadoE[1] !== null) { //alert(1);
							}else{
								$('#idConBeneET').val(idCo_beE[1]);
							
								subirEstudio(idEst[1], $('#numeroTemporalNV').val(), i, $('#idUsuario_nv').val(), 
									$('#id_medicoEn').val(),idConvenio[1],$('#sucursalNV').val(),$('#observacionesE_NV').val(), 
									15, precioTo[1], 5, $('#idConBeneET').val()
								);
							}
						}); //con la clave del médico sacamos su id
						
						$("#beneficioEndoscopia").load("genera/beneficiosP.php?idP="+$('#idPaciente_nv').val(), 
						function( response, status, xhr ) { 
							if ( status == "success" ) {
								$('#beneficioEndoscopia').change(function(e) { $('#clickme_bee').click(); });
							} 
						});
						
						var oTableESL1;
						oTableESL1 = $('#dataTableESEndo').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
						"sScrollY": ($('#dialog-buscaMedico').height()-155)/2, "bStateSave": false, "bInfo": false, 
						"bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
						"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
							calcularTotalesEnd($('#numeroTemporalNV').val()); 
						},
						"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
							{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }
						], 
						"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
						"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
						"sAjaxSource": "js/datatable-serverside/estudios_seleccionados_endo.php", 
						"fnServerParams": function (aoData, fnCallback) { 
							var aleatorio = $('#numeroTemporalNV').val(); 
							aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
						},
						"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
						"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
							"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
							"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS: _MAX_", "sSearch": "" 
						}
						});/*fin datatable*/ $('#clickmeESE').click(function(e) { oTableESL1.fnDraw(); });
					  }
					});
				} });
            });
			$('#b_medicoEndoscopiaNV').click(function(e) {
				$("#dialog-buscaMedico").load("htmls/dialogBuscarMedico.php #buscarMedicoX", function( response, status, xhr ) { 
				if ( status == "success" ) {
					var he3 = $('#referencia').height() - 100, wi3 = $('#referencia').width() * 0.98;
					$('#dialog-buscaMedico').dialog({ 
						title: 'BUSCAR EL MÉDICO PARA LOS ESTUDIOS DE ENDOSCOPÍA', modal: true, autoOpen: true, closeText: '', 
						width: wi3, height: he3, closeOnEscape: false, dialogClass: 'no-close',
						buttons: {
							"Continuar": function() {
							   if($('.selected2').length >0){
								   	$('#errorSeleccionMédico').hide(); $('#b_eliminarEnNV').show();
									$('#id_medicoEn').val($('#id_medicoEnT').val()); 
									$('#medicoEn_NV').val($('#medicoEn_NVT').val());
									$('#dialog-buscaMedico').dialog('close'); $('#b_estudiosEndoNV').show();
							   }else{ 
							   		$('#b_estudiosEndoNV').hide(); $('#errorSeleccionMédico').hide().show('shake'); 
									$('#id_medicoEn').val(''); $('#b_eliminarEnNV').hide();
								}
							},
						"Cancelar": function() { $('#dialog-buscaMedico').dialog('close'); },
						"Nuevo médico externo": function() { 
							$("#dialog-nuevo").load("htmls/nuevo_medicoExt.php #form-nmE", function( response, status, xhr ) { 
							if ( status == "success" ) { 
								$('#form-nmE input, #form-nmE select, #form-nmE textarea').addClass('campoITtab');
								nuevoMedicoExt();
							} });//fin de load
						}
					  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscaMedico').empty(); },
					  open:function( event, ui ){ var oTableBML1;
						oTableBML1 = $('#dataTableBMConsulta').dataTable({ 
							"bJQueryUI": true, "bRetrieve": true,  "sScrollY": $('#dialog-buscaMedico').height()-135, 
							"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[1, "asc"]],
							"aoColumns":[ {"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false} ], 
							"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
							"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', ordering: false,
							"sAjaxSource": "js/datatable-serverside/buscar_medico_estudios.php", 
							"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
							"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
								"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", "sSearch": "" 
							}
						});/*fin datatable*/ $('#clickme_bme').click(function(e) { oTableBML1.fnDraw(); });
						
						$(".pieTablaBMCo input").keyup( function () { /* Filter on the column (the index) of this element */
							oTableBML1.fnFilter( this.value, $(".pieTablaBMCo input").index(this) );
						} );
						
						$('.filtroBMC input').attr("placeholder", "BUSQUE UN MÉDICO AQUÍ, Y DELE CLIC PARA SEECCIONARLO...").addClass('placeHolder');
						$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
						$('.filtroBMC input').css('width', ($('#dialog-buscaMedico').width() * 1) ); 
						$('.filtroBMC').css('left',-16);
						$("div.toolbarBMC").css('white-space','nowrap').css('padding','8px');
						
						var tableBM = $('#dataTableBMConsulta').DataTable();
						$('#dataTableBMConsulta tbody').on('click','tr',function(){
							if($(this).hasClass('selected2')){
								$(this).removeClass('selected2');
							}else{
								tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
								$('#errorSeleccionMédico').hide();
							}
						});
						
						$('#dataTableBMConsulta tbody').on( 'click', 'tr', function () {
							var nTdsBMC = $('td', this);
							var idMedLa = $(nTdsBMC[0]).html().split('"');
							var nombreMla = $(nTdsBMC[0]).text()+' '+$(nTdsBMC[1]).text()+' '+$(nTdsBMC[2]).text();
							$('#id_medicoEnT').val(idMedLa[1]); $('#medicoEn_NVT').val(nombreMla); 
						}); 
					  }
					});
				}});
			});
			$('#b_eliminarEnNV').click(function(e) {
				$('#textoPreguntar').text('¿Esta seguro de que desea eliminar a los estudios de endoscopía de la orden de venta?');
				
				$('#dialog-preguntar').dialog({ title: 'ELIMINACIÓN DE LOS ESTUDIOS DE ENDOSCOPÍA', modal: true, autoOpen: true,
				closeText: '', width: 700, height: 200, closeOnEscape: true, dialogClass: '',
				buttons:{
					"Si":function(){ $('#cargoAdE_NV').prop('readonly',true); $('#cargoAdE_NV').val('');
						eliminarEstudiosEnd($('#numeroTemporalNV').val());$('#b_estudiosEndoNV').hide();$('#b_eliminarEnNV').hide();
						$('#dialog-preguntar').dialog('close'); 
					}, 
					"No":function(){$(this).dialog('close');}} });
			});
				
				$('#tabs-6-1').click(function(e) { $('#clickmeT').click(); var oTableTNV;
					//checamos si la ov tiene al menos un concepto, si lo tiene entonces el boton de pagar aparece
					var datosCon = {noAleatorio:$('#numeroTemporalNV').val()}
					$.post('files-serverside/checarHayConceptos.php',datosCon).done(function( data ) { 
						if(data >0){ $('#pagarOV').show(); }
						else{ $('#pagarOV').hide(); }
					});
					$('#pagarOV').click(function(event) { event.preventDefault(); });
					$('#pagarOV').button({icons:{primary:"ui-icon-disk"},text:true});
					$('#pagarOV').click(function(e) {
                        $("#dialog-buscaMedico").load("htmls/dialogPagarOV.php #pagarOV", function( response, status, xhr ) { 
						if ( status == "success" ) { 
							$('#pagarOV input').addClass('campoITtab1');
							$('#pagarOV select').addClass('campoITtab');
							$('#montoPagarP').keyup(function(e) {
                                if( parseFloat($('#montoPagarP').val()) > parseFloat($('#granTotalP').val()) ){
									$('#montoPagarP').val($('#granTotalP').val());
								}
                            });
							$('#adeudoTotalP').val($('#totalPagarT_NV').val());
							$('#montoPagarP').keyup(function(e) {
                                $('#pagaConP, #cambioP').val('');
                            });
							$('#pagaConP').keyup(function(e) {
							 if( $(this).val() > parseFloat($('#montoPagarP').val()) ){
							 $('#cambioP').val(redondear(parseFloat($('#pagaConP').val())-parseFloat($('#montoPagarP').val()),2));
							 }else{$('#cambioP').val('')}
                            });
							$('#granTotalP').val($('#adeudoTotalP').val());
							$('#formaPagoP').load("genera/formas_pago.php",function(response,status,xhr){
								$('#formaPagoP').change(function(e) { 
									$('#montoPagarP, #pagaConP, #cambioP').val('');
                                    if($(this).val()!=''){ //$('#montoPagarP').prop('readonly',false);
										$('#facturarP').prop('disabled',false);
									}else{ $('#montoPagarP').prop('readonly',true);
										$('#facturarP').val('');
										$('#facturarP').prop('disabled',true);
										$('#ivaP').val(0);
										$('#granTotalP').val($('#adeudoTotalP').val());
									}
									
									if($(this).val()==4){$('#numeroCheque').show();$('#noChequeP').focus();}
									else{$('#numeroCheque').hide();}
									
									if($(this).val()==1){
										$('#pagaConP').prop('readonly',false); 
									}else{$('#pagaConP').prop('readonly',true);}
                                });
								 window.setTimeout(function(){
								  	$('#formaPagoP').val(1);
									$('#facturarP').prop('disabled',false);
									$('#facturarP').val(0);
									$('#montoPagarP').prop('readonly',false);
									$('#montoPagarP').focus();
									$('#pagaConP').prop('readonly',false); 
								  },200);
							});
							$('#facturarP').change(function(e) { 
								if($(this).val()!=''){
									$('#montoPagarP').prop('readonly',false);
									$('#montoPagarP').focus();
								}else{
									$('#montoPagarP').val('');
									$('#montoPagarP').prop('readonly',true);
								}
								
								if($(this).val()==1){
									var iva = parseFloat($('#adeudoTotalP').val())*0.16; 
									$('#ivaP').val(redondear(iva,2)); 
									var xiva = $('#ivaP').val().split('.'); //alert(xiva);
									var x_1 = xiva[0], x_2 = xiva[1]; //alert(x_1); alert(x_2);
									if(x_2 > 0){
										if(x_2 <= 50){
											x_2 = 50;
											var tIva = x_1+'.'+x_2;
										}
										if(x_2 > 50){
											x_2 = 00; x_1=parseFloat(x_1)+parseFloat(1);
											var tIva = x_1+'.'+x_2;
										}
									}else{var tIva = x_1;}
									$('#ivaP').val(tIva);
									var miTotal = parseFloat($('#adeudoTotalP').val()) + parseFloat($('#ivaP').val());
									$('#granTotalP').val(redondear(miTotal,2));
									$('#montoPagarP,#pagaConP,#cambioP').val('');
								}
								if($(this).val()==0){
									$('#ivaP').val(0);
									$('#granTotalP').val($('#adeudoTotalP').val());
									$('#montoPagarP,#pagaConP,#cambioP').val('');
								}
							});
							
							var titleDP = 'PAGO. PACIENTE '+$('#pacienteNV').val();
							$('#form-pagar').validate({ });
							var hx = $('#referencia').height() - 100, wx = $('#referencia').width() * 0.98;
							$('#dialog-buscaMedico').dialog({ 
								title: titleDP, modal: true, autoOpen:true,closeText: '',
								width: 550, height: 530, closeOnEscape: false, dialogClass: 'no-close',
								buttons: {
									"Pagar": function() { if( $('#form-pagar').valid() ){
										guardarOrdenVenta($('#numeroTemporalNV').val());
									} },
								"Cancelar": function() { $('#dialog-buscaMedico').dialog('close'); }
							  }, create: function( event, ui ) {}, 
							  close:function( event, ui ){ $('#dialog-buscaMedico').empty(); },
							  open: function(event, ui){
								 
							  }
							});//fin dialog pagar OV
						}
						});
                    });
					
					oTableTNV = $('#dataTableTotalesNV').dataTable({ 
						"bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#contenedorTNV').height()+50, "bStateSave": false, 
						"bInfo": false, "bFilter": false, "aaSorting": [[1, "asc"]], ordering: false,
						"aoColumns": [
							{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
							{ "bSortable": false }, { "bSortable": false }
						], "iDisplayLength": 300, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
						"sDom": '<"toolbarELNV"><"filtroELNV"f>lr<"data_tELNV"t><"infoELNV"i>S', 
						"sAjaxSource": "js/datatable-serverside/totales_nv.php", 
						"fnServerParams": function (aoData, fnCallback) { 
							var aleatorio = $('#numeroTemporalNV').val(); 
							aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
						}, "aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
						"oLanguage":{ 
							"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "LA ORDEN DE VENTA ESTA VACÍA",
							"sInfo":"MOSTRADOS: _END_","sInfoEmpty": "MOSTRADOS: 0",
							"sInfoFiltered": "<br/>SERVICIOS: _MAX_", "sSearch": "" 
						}
					});/*fin datatable*/  $('#clickmeT').click(function(e) { oTableTNV.fnDraw(); }); 
					calcularTotalesTo($('#numeroTemporalNV').val(),$('#p_descuentoT_NV').val(),$('#d_descuentoT_NV').val());
					
					$('#p_descuentoT_NV, #d_descuentoT_NV').keyup(function(e) {
                        calcularTotalesTo($('#numeroTemporalNV').val(),$('#p_descuentoT_NV').val(),$('#d_descuentoT_NV').val());
                    });
					
					$('#pagoT_NV').keyup(function(e) {
						if(parseFloat($(this).val())>parseFloat(
							$('#totalPagarT_NV').val())){$(this).val($('#totalPagarT_NV').val()); $('#saldoT_NV').val(0);
						}
						else{
							$('#saldoT_NV').val( parseFloat($('#totalPagarT_NV').val())-parseFloat($('#pagoT_NV').val())); 
							if( !parseFloat($('#saldoT_NV').val()) & ( parseFloat($('#totalPagarT_NV').val()) !=  parseFloat($('#pagoT_NV').val()) ) ){ $('#saldoT_NV').val($('#totalPagarT_NV').val());} 
						} 
					});
				});
			
			var he1 = $('#referencia').height() - 100, wi1 = $('#referencia').width() * 0.98;
			$('#dialog-nuevaVisita').dialog({
				autoOpen: true, modal: true, width: wi1, height: he1, title: titulo, closeText: '', closeOnEscape: false, 
				dialogClass: 'no-close',
				buttons: { }, 
			  	open: function( event, ui ) { $('.cargoU').hide();
					$('#tabs-1').addClass('mitabV');
					$('#cancelSaveOV').click(function(e) {
						$('#textoPreguntar').text('¿ESTÁ SEGURO DE CANCELAR LA ORDEN DE VENTA DEFINITIVAMENTE?'); 
						$('#dialog-preguntar').dialog({ title: 'CANCELACIÓN DE LA ORDEN DE VENTA', modal: true, autoOpen: true,
							closeText: '', width: 600, height: 200, closeOnEscape: true, dialogClass: '',
							buttons:{
								"Si":function(){cancelarOV($('#numeroTemporalNV').val());$('#dialog-preguntar').dialog('close');},
								"No":function(){$(this).dialog('close'); }
							} 
						});
					});
				  
				  $('.ui-tabs-nav').removeClass('ui-widget-header');
				  $('.tTabs').css('height',$("#dialog-nuevaVisita").height()-45);
				  
				  $("#ticket").load("htmls/ticket.php #tablaTicket",function(response,status,xhr ){if( status == "success" ){ 
					var oTableC5t;
					oTableC5t = $('#dataTableResumenT').dataTable({
						"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
						"bProcessing": false,"bDestroy": true,"bAutoWidth": true,"sScrollY": '100%', "bScrollCollapse": false,
						"bSort": false, "bStateSave": false, "bInfo": false, "bFilter": false, "aaSorting": [[0, "asc"]],
						"paging": false,
						"aoColumns": [
							{ "bSortable": false }, { "bVisible": false }, { "bVisible": false }, { "bSortable": false }, 
							{ "bVisible": false }, { "bSortable": false }
						],
						"iDisplayLength": 300, "bLengthChange": false, "bServerSide": true, 
						"sAjaxSource": "js/datatable-serverside/totales_nvTi.php",
						"fnServerParams": function (aoData, fnCallback) { 
							var aleatorio = $('#numeroTemporalNV').val(); 
							aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
						}, "sDom": '<"filtroCt"><"infoCt"><"data_tCt"t>', 
						"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
						"oLanguage": { 
							"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "LA ORDEN DE VENTA ESTA VACIA", 
							"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " CONCEPTOS: _MAX_", 
							"sSearch": "BUSCAR" 
						}
					});/*fin datatable*/$('#clickmeTiC').click(function(e) { oTableC5t.fnDraw(); });
				  } });
				  
				  $("#remision").load("htmls/ticket.php #notaRemision",function(response,status,xhr ){if( status == "success" ){ 
					var oTableRe;
					oTableRe = $('#dataTableRemision').dataTable({"bJQueryUI": true, ordering: false,
						"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
						"bProcessing" : false,"bDestroy" : true,"bAutoWidth" : true,"sScrollY": '100%', "bScrollCollapse": false,
						"bSort" : false, "bStateSave": false, "bInfo": false, "bFilter": false, "aaSorting": [[0, "asc"]],
						"paging": false,
						"aoColumns": [
							{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
						],
						"iDisplayLength": 300, "bLengthChange": false, "bServerSide": true, 
						"sAjaxSource": "js/datatable-serverside/totales_nvRe.php",
						"fnServerParams": function (aoData, fnCallback) { 
							var aleatorio = $('#numeroTemporalNV').val(); 
							aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
						}, "sDom": '<"filtroCt"><"infoCt"><"data_tCt"t>', 
						"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
						"oLanguage": { 
							"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "LA ORDEN DE VENTA ESTA VACIA", 
							"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " CONCEPTOS: _MAX_", 
							"sSearch": "BUSCAR" 
						}
					});/*fin datatable*/$('#clickmeRem').click(function(e) { oTableRe.fnDraw(); });
				  } });
			  	}, 
			  	close: function( event, ui ) { 
					$('#dialog-nuevaVisita').empty();$("#dialog-nuevaVisita").tabs("destroy"); $("#dialog-nuevaVisita").remove(); 
					$('#dialog-confirmacion1').prepend('<div id="dialog-nuevaVisita" style="display:none;"> </div>');
			  	}
			});
		});
	} });
}); //Fin de Ready
}//Fin de la nueva Visita
function eliminarConsulta(noTemp){ $(document).ready(function(e){ 
	var datosECNV = {noTemp:noTemp}
	$.post('files-serverside/eliminarConsulta.php',datosECNV).done(function( data ) { 
		if (data==1){ 
			$('#tabs-2 input,#tabs-2 textarea').val('');
			$('#tabs-2 .cero').val(0);
		} else{alert(data);} });
});}/*Fin de guardarConsulta*/ /*Fin de ready*/

function guardarConsulta(noTemp, idP, idUsuario, idMedico, precioCo, idConvenio, total, idDepartamento, idArea, idC, idSucursal, motivo,id_con_bene){ $(document).ready(function(e) {
    var datosCNV = {noTemp:noTemp, idP:idP, idU:idUsuario, idMedico:idMedico, precioCo:precioCo, idConvenio:idConvenio, total:total, idDepartamento:idDepartamento, idArea:idArea, idC:idC, idSucursal:idSucursal, motivo:motivo, id_con_bene:id_con_bene,
	fechaC:$('#fichaNV').val()+' '+$('#horaNV').val(), agendar:$('#agendarOV').val() }
	
	$.post('files-serverside/guardarConsulta.php',datosCNV).done(function( data ) { 
		if (data==1){ } else{if (data!=''){ alert(data);} } 
	});//guardamso al nuevo paciente
});}/*Fin de guardarConsulta*/ /*Fin de ready*/

function subirEstudio(idE, noAleatorio, idP, idU, idMedico, idConvenio, idSucursal, observaciones, departamento,p,t,id_con_bene){ 
$(document).ready(function(e) {
	var datosSENV = {noAleatorio:noAleatorio, idP:idP, idU:idU, idMedico:idMedico, idE:idE, agendar:$('#agendarOV').val(),
		idConvenio:idConvenio, idSucursal:idSucursal, observaciones:observaciones, departamento:departamento,
		precioTo:p,tipoConcepto:t,id_con_bene:id_con_bene,fechaC:$('#fichaNV').val()+' '+$('#horaNV').val()
	}
	$.post('files-serverside/guardarEstudioNV.php',datosSENV).done(function( data ) { 
		if (data==1){ 
			$('#clickmeESI,#clickmeESE').click();$('#clickmeI,#clickmeL,#clickmeE,#clickme_bei,#clickme_bs,#clickme_bee').click();
		} 
		else{alert(data);} 
	});
});}

function subirServicio(idS, noAleatorio, idP, idU, idMedico, idConvenio, idSucursal, observaciones, departamento,p,t,id_con_bene){
$(document).ready(function(e) { //alert(idS);
	var datosSENV = {noAleatorio:noAleatorio, idP:idP, idU:idU, idMedico:idMedico, idE:idS, agendar:$('#agendarOV').val(),
		idConvenio:idConvenio, idSucursal:idSucursal, observaciones:observaciones, departamento:departamento, 
		precioTo:p, tipoConcepto:t, id_con_bene:id_con_bene, fechaC:$('#fichaNV').val()+' '+$('#horaNV').val()
	}
	$.post('files-serverside/guardarEstudioNV.php',datosSENV).done(function( data ) { 
		if (data==1){ $('#clickmeESI').click(); $('#clickmeI, #clickmeL,#clickme_bs').click(); } 
		else{alert(data);} 
	});
});}

function checarHayEstudios(noAleatorio, tipoItem, departamento){ 
$(document).ready(function(e) { 
	var datosChecaINV = {noAleatorio:noAleatorio, tipoItem:tipoItem, departamento:departamento}
	$.post('files-serverside/checarHayEstudios.php',datosChecaINV).done(function( data ) { 
		if(data >0){ 
			$('#errorSeleccionEstudios').hide(); $('#dialog-buscaMedico').dialog('close');
			if(tipoItem == 4){
				$('#cargoAdI_NV,#p_descuentoI_NV,#d_descuentoI_NV,#t_descuentoI_NV').val(''); 
				$('#cargoAdI_NV,#p_descuentoI_NV,#d_descuentoI_NV').prop('readonly',false);
				$('#totalI_NV').val(parseFloat($('#subtotalI_NV').val()));
			}
			if(tipoItem == 3){
				$('#cargoAdL_NV,#p_descuentoL_NV,#d_descuentoL_NV,#t_descuentoL_NV').val(''); 
				$('#cargoAdL_NV,#p_descuentoL_NV,#d_descuentoL_NV').prop('readonly',false);
				$('#indicacionesLab').button('enable');
				$('#totalL_NV').val(parseFloat($('#subtotalL_NV').val()));
			}
			if(tipoItem == 2){
				$('#cargoAdS_NV,#p_descuentoS_NV,#d_descuentoS_NV,#t_descuentoS_NV').val('');
				$('#cargoAdS_NV,#p_descuentoS_NV,#d_descuentoS_NV').prop('readonly',false);
				$('#totalS_NV').val(parseFloat($('#subtotalS_NV').val()));
			}
			if(tipoItem == 5){
				$('#cargoAdE_NV').val(''); $('#cargoAdE_NV').prop('readonly',false);
				$('#totalE_NV').val(parseFloat($('#subtotalE_NV').val()));
			}
		}
		else{ $('#errorSeleccionEstudios').hide().show('shake'); if(tipoItem == 3){$('#indicacionesLab').button('disable');} } 
	}); 
});}

function borrarItemNV(idConcepto){
	var datosBINV = {idConcepto:idConcepto}
	$.post('files-serverside/eliminarItem.php',datosBINV).done(function( data ) { 
	if (data==1){ 
		$('#clickmeESI,#clickmeESE').click();
		$('#clickmeI,#clickmeL,#clickmeS,#clickmeE,#clickme_bei,#clickme_bs,#clickme_bee').click();
	} 
	else{alert(data);} });
}

function calcularTotalesIm(noAleatorio){$(document).ready(function(e){ 
	var datosEINV = {noAleatorio:noAleatorio}
	$.post('files-serverside/datosTotalesIm.php',datosEINV).done(function( data ) {
		if(!parseFloat(data)){
			data = 0;
			$('#subtotalI_NV').val(data);$('#totalI_NV').val(data); 
		}else{$('#subtotalI_NV').val(data);$('#totalI_NV').val(data); }
	});
});}

function eliminarEstudios(noTemp){ $(document).ready(function(e) { 
	var datosEEINV = {noTemp:noTemp}
	$.post('files-serverside/eliminarEstudiosImagen.php',datosEEINV).done(function( data ) { 
		if (data==1){ 
			$('#tabs-3 input,#tabs-3 textarea').val(''); $('#tabs-3 .cero').val(0); $('#clickmeI').click();
			$('#cargoAdI_NV,#p_descuentoI_NV,#d_descuentoI_NV,#t_descuentoI_NV').val('');
		} 
		else{alert(data);} });
});}/*Fin de guardarConsulta*/ /*Fin de ready*/ 
function calcularTotalesLab(noAleatorio){$(document).ready(function(e){
	var datosEINV = {noAleatorio:noAleatorio}
	$.post('files-serverside/datosTotalesLab.php',datosEINV).done(function( data ) {
		if(!parseFloat(data)){
			data = 0;
			$('#subtotalL_NV').val(data);$('#totalL_NV').val(data);  
		}else{$('#subtotalL_NV').val(data);$('#totalL_NV').val(data); }
	});
});}
function calcularTotalesEnd(noAleatorio){$(document).ready(function(e){
	var datosEINV = {noAleatorio:noAleatorio}
	$.post('files-serverside/datosTotalesEndo.php',datosEINV).done(function( data ) {
		if(!parseFloat(data)){
			data = 0;
			$('#subtotalE_NV').val(data);$('#totalE_NV').val(data);  
		}else{$('#subtotalE_NV').val(data);$('#totalE_NV').val(data); }
	});
});}
function eliminarEstudiosLab(noTemp){ $(document).ready(function(e) { 
	var datosEEINV = {noTemp:noTemp}
	$.post('files-serverside/eliminarEstudiosLaboratorio.php',datosEEINV).done(function( data ) { 
		if (data==1){ 
			$('#tabs-4 input,#tabs-4 textarea').val(''); $('#tabs-4 .cero').val(0); $('#clickmeL').click();
			$('#cargoAdL_NV,#p_descuentoL_NV,#d_descuentoL_NV,#t_descuentoL_NV').val('');
		} 
		else{alert(data);} });
});}
function eliminarEstudiosEnd(noTemp){ $(document).ready(function(e) { 
	var datosEEINV = {noTemp:noTemp}
	$.post('files-serverside/eliminarEstudiosEndoscopia.php',datosEEINV).done(function( data ) { 
		if (data==1){ 
			$('#tabs-4 input,#tabs-4 textarea').val(''); $('#tabs-4 .cero').val(0); $('#clickmeL').click();
			$('#cargoAdL_NV').val('');
		} 
		else{alert(data);} });
});}
function calcularTotalesServicios(noAleatorio){$(document).ready(function(e){ 
	var datosSNV = {noAleatorio:noAleatorio}
	$.post('files-serverside/datosTotalesServicios.php',datosSNV).done(function( data ) {
		if(!parseFloat(data)){
			data = 0;
			$('#subtotalS_NV').val(data);$('#totalS_NV').val(data);  
		}else{$('#subtotalS_NV').val(data);$('#totalS_NV').val(data); } 
	});
});}
function eliminarServicios(noTemp){ $(document).ready(function(e) { 
	var datosEEINV = {noTemp:noTemp}
	$.post('files-serverside/eliminarServicios.php',datosEEINV).done(function( data ) { 
		if (data==1){ 
			$('#tabs-5 input,#tabs-5 textarea').val(''); $('#tabs-5 .cero').val(0); $('#clickmeS').click();
			$('#cargoAdS_NV,#p_descuentoS_NV,#d_descuentoS_NV,#t_descuentoS_NV').val('');
		} else{alert(data);} 
	});
});}/*Fin de guardarConsulta*/ /*Fin de ready*/ 

function calcularTotalesTo(noAleatorio, dP, dD){$(document).ready(function(e){
	$('#totalC_T_NV').val($('#totalC_NV').val()); 
	$('#totalI_T_NV').val($('#totalI_NV').val()); 
	$('#totalL_T_NV').val($('#totalL_NV').val());
	$('#totalS_T_NV').val($('#totalS_NV').val());
	var tot1 = parseFloat($('#totalC_T_NV').val())+parseFloat($('#totalI_T_NV').val())+parseFloat($('#totalL_T_NV').val())+parseFloat($('#totalS_T_NV').val());
	$('#sTotal_T_NV').val(tot1);
	
	if(!parseInt(dP)){ dP=0;}
	if(!parseFloat(dD)){ dD=0;}
	
	var descuentos = (parseInt(dP)*parseFloat(0.01));
	 
	var tot=parseFloat($('#totalC_T_NV').val())+parseFloat($('#totalI_T_NV').val())+parseFloat($('#totalL_T_NV').val())+parseFloat($('#totalS_T_NV').val()) - parseFloat(dD);
	
	var tDescuentoT1 = (parseFloat(tot) * parseFloat(descuentos));
	
	tot = parseFloat(tot) - (parseFloat(tot) * parseFloat(descuentos));
	
	if(!parseFloat(tot)){
		tot = 0;$('#totalPagarT_NV, #saldoT_NV').val(tot);
	}else{$('#totalPagarT_NV, #saldoT_NV').val(tot);}
	
	var tDescuentoC = 0, tDescuentoI = 0, tDescuentoL = 0, tDescuentoS = 0, tDescuentoT = 0;
	if(!parseFloat($('#t_descuento_NV').val())){tDescuentoC = 0;}else{tDescuentoC = parseFloat($('#t_descuento_NV').val());}
	
	if(!parseFloat($('#t_descuentoI_NV').val())){tDescuentoI = 0;}else{tDescuentoI = parseFloat($('#t_descuentoI_NV').val());}
	
	if(!parseFloat($('#t_descuentoL_NV').val())){tDescuentoL = 0;}else{tDescuentoL = parseFloat($('#t_descuentoL_NV').val());}
	
	if(!parseFloat($('#t_descuentoS_NV').val())){tDescuentoS = 0;}else{tDescuentoS = parseFloat($('#t_descuentoS_NV').val());}
	
	if(!parseFloat(dD)){tDescuentoT = 0;}else{tDescuentoT = parseFloat(dD);}
	
	$('#t_descuentoT_NV').val(parseFloat(tDescuentoC)+parseFloat(tDescuentoI)+parseFloat(tDescuentoL)+parseFloat(tDescuentoS)+parseFloat(tDescuentoT)+parseFloat(tDescuentoT1));
});}

function cancelarOV(noTemp){ $(document).ready(function(e) { var datosCOV = {noTemp:noTemp}
	eliminarConsulta(noTemp); eliminarEstudios(noTemp); eliminarEstudiosLab(noTemp); eliminarServicios(noTemp);
	$('#dialog-nuevaVisita').dialog('close');$('#tabs-6 input,#tabs-6 textarea').val('');$('#tabs-6 .cero').val(0);
	$('#clickmeT').click(); 
});}/*Fin de cancelarOV*/ /*Fin de ready*/
function cancelarOV1(noTemp){ $(document).ready(function(e) { var datosCOV = {noTemp:noTemp}
	eliminarConsulta(noTemp); eliminarEstudios(noTemp); eliminarEstudiosLab(noTemp); eliminarServicios(noTemp);
	$('#tabs-6 input,#tabs-6 textarea').val('');$('#tabs-6 .cero').val(0); $('#clickmeT').click();
	$('#b_eliminarCoNV,#bBuscarConsulta,#b_eliminarImNV,#b_estudiosImagenNV,#b_eliminarLaNV,#b_estudiosLabNV,#b_eliminarSeNV,#b_serviciosSNV').hide();
});}/*Fin de cancelarOV*/ /*Fin de ready*/
function campos(x,id){ $(document).ready(function(e) { 
	if(!parseFloat(x) & x!=0){$('#pagoT_NV').val('');}
	else{$('#pagoT_NV').val(parseFloat(x).toFixed(2));} 
});}

function guardarOrdenVenta(noTemp){
	if($('#formNVisita').valid()){
		var datosSOV = {
			noTemp:noTemp,sucursal:$('#sucursalNV').val(),idPaciente:$('#idPaciente_nv').val(),idUsuario:$('#idUsuario_nv').val(),
			subtotalC:$('#subtotalC_NV').val(),totalC:$('#totalC_NV').val(),motivoC:$('#motivoC_NV').val(),
			cargoAC:$('#cargoAdC_NV').val(), medicoC:$('#id_medicoCo').val(),
			subtotalI:$('#subtotalI_NV').val(),totalI:$('#totalI_NV').val(), observacionesI:$('#observacionesI_NV').val(),
			cargoAI:$('#cargoAdI_NV').val(), medicoI:$('#id_medicoIm').val(),
			subtotalL:$('#subtotalL_NV').val(),totalL:$('#totalL_NV').val(),observacionesL:$('#observacionesL_NV').val(),
			cargoAL:$('#cargoAdL_NV').val(), medicoL:$('#id_medicoLab').val(),
			subtotalE:$('#subtotalE_NV').val(),totalE:$('#totalE_NV').val(),observacionesE:$('#observacionesE_NV').val(),
			cargoAE:$('#cargoAdE_NV').val(), medicoE:$('#id_medicoEn').val(),
			subtotalS:$('#subtotalS_NV').val(),totalS:$('#totalS_NV').val(),observacionesS:$('#observacionesS_NV').val(),
			cargoAS:$('#cargoAdS_NV').val(), medicoS:$('#id_pMedico').val(),
			subtotal:$('#adeudoTotalP').val(),iva:$('#ivaP').val(),
			totalPagar:$('#granTotalP').val(),suPago:$('#montoPagarP').val(),formaPago:$('#formaPagoP').val(),
			facturada:$('#facturarP').val(),noCheque:$('#noChequeP').val(),descuentoT:$('#t_descuentoT_NV').val(),
			p_desc_cta:$('#p_descuento_NV').val(),desc_d_cta:$('#d_descuento_NV').val(),t_desc_cta:$('#t_descuento_NV').val(),
			p_desc_img:$('#p_descuentoI_NV').val(),desc_d_img:$('#d_descuentoI_NV').val(),t_desc_img:$('#t_descuentoI_NV').val(),
			p_desc_lab:$('#p_descuentoL_NV').val(),desc_d_lab:$('#d_descuentoL_NV').val(),t_desc_lab:$('#t_descuentoL_NV').val(),
			p_desc_ser:$('#p_descuentoS_NV').val(),desc_d_ser:$('#d_descuentoS_NV').val(),t_desc_ser:$('#t_descuentoS_NV').val(),
			p_desc_gra:$('#p_descuentoT_NV').val(),desc_d_gra:$('#d_descuentoT_NV').val(),t_desc_gra:$('#t_descuentoT_NV').val(),
			fechaC:$('#fichaNV').val()+' '+$('#horaNV').val(), fechaC1:$('#fichaNV').val(),agendar:$('#agendarOV').val(),
			procedencia:$('#procedenciaNV').val()
		}
		$.post('files-serverside/saveOrdenVenta.php',datosSOV).done(function(data){
			if(data==1){$('#clickmeTiC').click(); $('#clickmeRem').click(); $('#clickme').click();
				var datosTi = {noAleatorio:$('#numeroTemporalNV').val()}
				$.post('files-serverside/datosTicketNV.php',datosTi).done(function(data){
					var datosT = data.split(';}'); if(datosT[5]==''){datosT[5]=0;} //alert(data);
					//para el ticket
					$('#fechaT').text(datosT[0]);$('#referenciaT').text(datosT[1]);$('#pacienteT').text(datosT[2]);
					$('#adicionalesT').text(datosT[10]);$('#totalT').text(datosT[4]);$('#pagoT').text($('#montoPagarP').val());
					$('#saldoT').text(datosT[6]);$('#usuarioIT').text(datosT[7]);$('#fechaIT').text(datosT[8]);
					$('#horaIT').text(datosT[9]); $('#formaPagoT').text(datosT[11]);$('#cantidadLetraT').text(nn(datosT[4]));
					$('#municipioS').text(datosT[16]);$('#calleSucursal').text(datosT[19]);$('#coloniaSucursal').text(datosT[18]);
					$('#cpSucursal').text(datosT[20]);$('#telefonoSucursal').text(datosT[21]);
					$('#municipioSucursal').text(datosT[17]);$('#estadoSucursal').text(datosT[15]);
					$('#sitioS').text(datosT[22]);$('#emailSucursal').text(datosT[23]);$('#descuentoT').text(datosT[24]);
					$('#subTotalT').text(parseFloat(datosT[4])+parseFloat(datosT[24]));
					if(datosT[25]>0){
						x='../sucursales/logotipos/files/'+datosT[26]+'.'+datosT[27]+'?'+Math.round(Math.random()*1000);
						$('#myLogoS').html('<img src='+x+' width="150" style="border:5px none white; background-color:rgba(255, 255, 255, 1);">');
					}
					
					$('#textoPreguntar').text('LA ORDEN DE VENTA SE HA GENERADO CORRECTAMENTE.'); 
					$('#tablaTOV').replaceWith($('#contenedorTNV').html());$('#dialog-nuevaVisita').dialog('close');
					$('#tablaTicket *').css('font-size','0.98em');
					//para la remisión
					$('#nombreRp').text(datosT[2]); $('#rfcRp').text(datosT[13]); $('#referenciaOVR').text(datosT[1]);
					$('#diraccionPR').text(datosT[14]);$('#fechaOVR').text(datosT[8]);$('#direccionClinicaRemision').text();
					$('#cantidadLetraRemision').text(nn(datosT[4])); $('#totalRemision').text(datosT[4]); 
					$('#notaRemision *').css('font-size','0.95em');
					
					$('#dialog-preguntar').dialog({ title: 'ORDEN DE VENTA GENERADA', modal: true, autoOpen: true, 
						closeText: '', width: 600, height: 200, closeOnEscape: true, dialogClass: '',
						buttons:{
							"Imprimir ticket":function(){ $('#ticket').show().printElement(); },
							"Cerrar":function(){$('#dialog-preguntar').dialog('close');$('#dialog-buscaMedico').dialog('close'); }
						},open:function( event, ui ) { $('#ticket').hide();$('#remision').hide(); }, 
						close:function( event, ui ) { 
							$('#dialog-buscaMedico').dialog('close'); $('#ticket').empty();$('#remision').empty();
						}
					});
				});
			}else{}
		}); 
	}
}

function reimpresionTicket(ref, ale){ $(document).ready(function(e) { //alert(ale);
	$("#ticket").load("htmls/ticket.php #tablaTicket",function(response,status,xhr ){if( status == "success" ){ 
		var oTableC5t;
		oTableC5t = $('#dataTableResumenT').dataTable({
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
			"bProcessing" : false,"bDestroy" : true,"bAutoWidth" : false,"sScrollY": '100%', "bScrollCollapse": false,
			"bSort" : false, "bStateSave": false, "bInfo": false, "bFilter": false, "aaSorting": [[0, "asc"]],
			"paging": false,
			"aoColumns": [
				{ "bSortable": false }, { "bVisible": false }, { "bVisible": false }, { "bSortable": false }, 
				{ "bVisible": false }, { "bSortable": false }
			],
			"iDisplayLength": 300, "bLengthChange": false, "bServerSide": true, 
			"sAjaxSource": "js/datatable-serverside/totales_nvTi.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var aleatorio = ale; 
				aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
			}, "sDom": '<"filtroCt"><"infoCt"><"data_tCt"t>', 
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
			"oLanguage": { 
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "LA ORDEN DE VENTA ESTA VACIA", 
				"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " CONCEPTOS: _MAX_", 
				"sSearch": "BUSCAR" 
			}
		});/*fin datatable*/$('#clickmeTiC').click(function(e) { oTableC5t.fnDraw(); });
	  } });
	  
	var datosTi = {noAleatorio:ale}
	$.post('files-serverside/datosTicketNV.php',datosTi).done(function(data){
		var datosT = data.split(';}'); if(datosT[5]==''){datosT[5]=0;} //alert(data);
		$('#ticket').hide();
		//para el ticket
		$('#fechaT').text(datosT[0]);$('#referenciaT').text(datosT[1]);$('#pacienteT').text(datosT[2]);
		$('#adicionalesT').text(datosT[10]);$('#totalT').text(datosT[4]);$('#pagoT').text(parseFloat(datosT[4])-parseFloat(datosT[6]));
		$('#saldoT').text(datosT[6]);$('#usuarioIT').text(datosT[7]);$('#fechaIT').text(datosT[8]);
		$('#horaIT').text(datosT[9]); $('#formaPagoT').text(datosT[11]);$('#cantidadLetraT').text(nn(datosT[4]));
		$('#municipioS').text(datosT[16]);$('#calleSucursal').text(datosT[19]);$('#coloniaSucursal').text(datosT[18]);
		$('#cpSucursal').text(datosT[20]);$('#telefonoSucursal').text(datosT[21]);
		$('#municipioSucursal').text(datosT[17]);$('#estadoSucursal').text(datosT[15]);
		$('#sitioS').text(datosT[22]);$('#emailSucursal').text(datosT[23]);$('#descuentoT').text(datosT[24]);
		$('#subTotalT').text(parseFloat(datosT[4])+parseFloat(datosT[24]));
		
		if(datosT[25]>0){
			x='../sucursales/logotipos/files/'+datosT[26]+'.'+datosT[27]+'?'+Math.round(Math.random()*1000);
			$('#myLogoS').html('<img src='+x+' width="150" style="border:5px none white; background-color:rgba(255, 255, 255, 1);">');
		}
		
		$('#tablaTicket *').css('font-size','0.98em');
		window.setTimeout(function(){
			$('#ticket').show().printElement();window.setTimeout(function(){$('#ticket').empty();},200);}
		,200);
		
	});
}); }

//función para la info de detalle de cada registro
function fnFormatDetails ( oTable, nTr, x) { var aData = oTable.fnGetData( nTr ); var sOut = x; return sOut; }

function historialPaciente(dataH){
	var dataHV = dataH.split(';]{'); var idP = dataHV[0]; var nombreP = dataHV[1];//alert(idP);
	$("#dialog-historial").load("htmls/historial_visitas.php", function( response, status, xhr ) { 
	if ( status == "success" ) { 
		$('#dataTableHistorial input, #dataTableHistorial select, #dataTableHistorial textarea').addClass('campoITtab');
		$(':checkbox').removeClass('campoITtab');
		$('#dialog-historial').dialog({
			title:'HISTORIAL DE VISITAS DE '+nombreP,modal:true,autoOpen:true,closeText:'',
			width:$('#referencia').width()*0.98,height:$('#referencia').height()-$('#header').height()-50,
			closeOnEscape:true,dialogClass:'',
			open:function(event,ui){
				$('#facturados').click(function(e) {
                    if($(this).prop('checked')==true){ $('#miFacturados').val('1'); $('#clickme_hv').click(); }
					else{ $('#miFacturados').val('0,1'); $('#clickme_hv').click(); }
                });
				
				$('#saldazos').click(function(e) {
                    if($(this).prop('checked')==true){ $('#miSaldazos').val('1'); $('#clickme_hv').click(); }
					else{ $('#miSaldazos').val('0'); $('#clickme_hv').click(); }
                });
				/* * Insert a 'details' column to the table */
				var nCloneTh = document.createElement( 'th' );
				var nCloneTd = document.createElement( 'td' );
				nCloneTd.innerHTML = '<img src="../DataTables-1.9.1/examples/examples_support/details_open.png">';
				nCloneTd.className = "center";
				 
				$('#dataTableHistorial thead tr').each( function () { this.insertBefore( nCloneTh, this.childNodes[0] ); });
				 
				$('#dataTableHistorial tbody tr').each(function(){this.insertBefore(nCloneTd.cloneNode(true),this.childNodes[0]);});
				var hH = $('#dialog-historial').height()-50;
				var oTableHV = $('#dataTableHistorial').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
					"bProcessing" : false,"bDestroy" : true,"bAutoWidth" : false,"sScrollY": hH, "bScrollCollapse": false,
					"bSort" : false, "bStateSave": false, "bInfo": false, "bFilter": false, 
					"aaSorting": [[1, "asc"]],"paging": false, ordering: false, "bJQueryUI": true,
					"aoColumns": [
						{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
						{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false },
						{ "bSortable": false }, { "bSortable": false }, { "bSortable": false } 
					],
					"iDisplayLength": 500, "bLengthChange": false, "bServerSide": true, 
					"sAjaxSource": "datatable-serverside/historial_visitas.php", 
					"fnServerParams": function (aoData, fnCallback) { 
						var idPaciente = idP; aoData.push(  {"name": "idPac", "value": idPaciente } );
						var facturado = $('#miFacturados').val(); aoData.push(  {"name": "facturado", "value": facturado } );
						var zaldazos = $('#miSaldazos').val(); aoData.push(  {"name": "zaldazos", "value": zaldazos } );
					},
					"sDom": '<"filtroCt"><"infoCt"><"data_tCt"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage": { 
						"sLengthMenu": "MONSTRANDO _MENU_ records per page",
						"sZeroRecords": "EL PACIENTE NO CUENTA CON HISTORIAL DE VISITAS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>VISITAS: _MAX_", "sSearch": "BUSCAR" }
				});/*fin datatable*/$('#clickme_hv').click(function(e) { oTableHV.fnDraw(); });
				
					/* Add event listener for opening and closing details * Note that the indicator for showing which row is open is not controlled by DataTables, * rather it is done here */
					$(document).delegate('#dataTableHistorial tbody td img','click', function () { 
						var nTr = $(this).parents('tr')[0]; var aDataOPC = oTableHV.fnGetData( nTr );//alert(aDataOPC);
						if(aDataOPC != null){
							if ( oTableHV.fnIsOpen(nTr) ) { 
								this.src = "../DataTables-1.9.1/examples/examples_support/details_open.png";oTableHV.fnClose( nTr );
							}
							else
							{ /* Open this row */
								var aData = oTableHV.fnGetData( nTr );
								this.src = "../DataTables-1.9.1/examples/examples_support/details_close.png";
								var datoDHV ={ ref:aData[2] }
								$.post('datatable-serverside/datosAdicionalesHV.php',datoDHV,processDataDHV).error('ouch');
								function processDataDHV(dataHV) { console.log(dataHV);
									var text = dataHV.split('/{];');
									oTableHV.fnOpen( nTr, fnFormatDetails(oTableHV, nTr, dataHV), 'details' );
								} // end processDataDHV
							}
						}
					} ); // fin  Add event listener for opening and closing details	
			},
			close:function(event,ui){ $("#dialog-historial").empty(); },
			buttons:{ /*"Cerrar": function() { $('#dialog-historial').dialog('close'); }*/ }
		}); //fin de dialog-historial
	} });//fin de load
}

function historialPagos(ref,paci){ $(document).ready(function(e) {
	var he = $('#referencia').height() - 100; var wi = $('#referencia').width() * 0.98;
	
	$('#dialog-historialPagos').dialog({ 
		autoOpen: true, modal: true,width:wi,height:he,title:'HISTORIAL DE PAGOS REFERENCIA '+ref+'. '+paci,closeText: '',
		open:function(event,ui){
			var he9 = $('#dialog-historialPagos').height()-50;
			var oTableHP = $('#dataTableHP').dataTable({
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
				"bProcessing" : false,"bDestroy" : true,"bAutoWidth" : false,"sScrollY": he9, "bScrollCollapse": false,
				"bSort" : false, "bStateSave": false, "bInfo": false, "bFilter": false, 
				"aaSorting": [[1, "asc"]],"paging": false, ordering: false, "bJQueryUI": true,
				"aoColumns": [
					{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
					{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }
				],
				"iDisplayLength": 500, "bLengthChange": false, "bServerSide": true, 
				"sAjaxSource": "datatable-serverside/historial_pagos.php", 
				"fnServerParams": function (aoData, fnCallback) { 
					var referenciaHP = ref; aoData.push(  {"name": "referencia", "value": ref } );
				},
				"sDom": '<"filtroCt"><"infoCt"><"data_tCt"t>', 
				"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"oLanguage": { 
					"sLengthMenu": "MONSTRANDO _MENU_ records per page",
					"sZeroRecords": "EL PACIENTE NO CUENTA CON HISTORIAL DE PAGOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>PAGOS: _MAX_", "sSearch": "BUSCAR" }
			});/*fin datatable*/$('#miClickHP').click(function(e) { oTableHP.fnDraw(); });
		} 
	});
}); }

function totalC(st, ca, dP, dD){ $(document).ready(function(e) {
    var total = 0, stotal = 0, cargos = 0, descuentos = 0;
	if( st > 0){
		if(!parseFloat(ca)){ ca=0;}
		if(!parseInt(dP)){ dP=0;}
		if(!parseFloat(dD)){ dD=0;}
		cargos = (parseFloat(ca) - parseFloat(dD));
		descuentos = (parseInt(dP)*parseFloat(0.01)); //tiende a 0 cuando dP es 0
		stotal = (parseFloat(st) + parseFloat(cargos));
		total = parseFloat(stotal) - (parseFloat(stotal) * parseFloat(descuentos));
	}else{total = 0.00;}
	$('#totalC_NV').val( parseFloat(total) );
	var descuentoSolo = 0;
	
	if(dP==0){ if(dD==0){descuentoSolo = 0;}else{descuentoSolo = dD;}
	}else{ if(dD==0){descuentoSolo = 0;}else{descuentoSolo = dD;} }
	
	$('#t_descuento_NV').val( parseFloat(parseFloat(stotal) * parseFloat(descuentos)) + parseFloat(descuentoSolo) );
});	}

function totalI(st, ca, dP, dD){ $(document).ready(function(e) {
    var total = 0, stotal = 0, cargos = 0, descuentos = 0;
	if( st > 0){
		if(!parseFloat(ca)){ ca=0;}
		if(!parseInt(dP)){ dP=0;}
		if(!parseFloat(dD)){ dD=0;}
		cargos = (parseFloat(ca) - parseFloat(dD));
		descuentos = (parseInt(dP)*parseFloat(0.01));
		stotal = (parseFloat(st) + parseFloat(cargos));
		total = parseFloat(stotal) - (parseFloat(stotal) * parseFloat(descuentos));
	}else{total = 0.00;}
	$('#totalI_NV').val( parseFloat(total) );
	var descuentoSolo = 0;
	
	if(dP==0){ if(dD==0){descuentoSolo = 0;}else{descuentoSolo = dD;}
	}else{ if(dD==0){descuentoSolo = 0;}else{descuentoSolo = dD;} }
	
	$('#t_descuentoI_NV').val( parseFloat(parseFloat(stotal) * parseFloat(descuentos)) + parseFloat(descuentoSolo) );
});	}

function totalL(st, ca, dP, dD){ $(document).ready(function(e) {
    var total = 0, stotal = 0, cargos = 0, descuentos = 0;
	if( st > 0){
		if(!parseFloat(ca)){ ca=0;}
		if(!parseInt(dP)){ dP=0;}
		if(!parseFloat(dD)){ dD=0;}
		cargos = (parseFloat(ca) - parseFloat(dD));
		descuentos = (parseInt(dP)*parseFloat(0.01));
		stotal = (parseFloat(st) + parseFloat(cargos));
		total = parseFloat(stotal) - (parseFloat(stotal) * parseFloat(descuentos));
	}else{total = 0.00;}
	$('#totalL_NV').val( parseFloat(total) );
	var descuentoSolo = 0;
	
	if(dP==0){ if(dD==0){descuentoSolo = 0;}else{descuentoSolo = dD;}
	}else{ if(dD==0){descuentoSolo = 0;}else{descuentoSolo = dD;} }
	
	$('#t_descuentoL_NV').val( parseFloat(parseFloat(stotal) * parseFloat(descuentos)) + parseFloat(descuentoSolo) );
});	}

function totalS(st, ca, dP, dD){ $(document).ready(function(e) {
    var total = 0, stotal = 0, cargos = 0, descuentos = 0;
	if( st > 0){
		if(!parseFloat(ca)){ ca=0;}
		if(!parseInt(dP)){ dP=0;}
		if(!parseFloat(dD)){ dD=0;}
		cargos = (parseFloat(ca) - parseFloat(dD));
		descuentos = (parseInt(dP)*parseFloat(0.01));
		stotal = (parseFloat(st) + parseFloat(cargos));
		total = parseFloat(stotal) - (parseFloat(stotal) * parseFloat(descuentos));
	}else{total = 0.00;}
	$('#totalS_NV').val( parseFloat(total) );
	var descuentoSolo = 0;
	
	if(dP==0){ if(dD==0){descuentoSolo = 0;}else{descuentoSolo = dD;}
	}else{ if(dD==0){descuentoSolo = 0;}else{descuentoSolo = dD;} }
	
	$('#t_descuentoS_NV').val( parseFloat(parseFloat(stotal) * parseFloat(descuentos)) + parseFloat(descuentoSolo) );
});	}

function cancelar_ov(idVC,nombreP,refe){ $(document).ready(function(e) {
	$('#dialog-cancelOV').dialog({ title: 'CANCELAR ORDEN DE VENTA. '+nombreP, modal: true, autoOpen: true, 
		closeText: '', width: 700, height: 210, closeOnEscape: true, dialogClass: '',
		buttons:{
			"Si":function(){ 
				if($('#confirmaCOV').prop('checked')==true){
					var datosCOV = {refe:refe}
					$.post('files-serverside/cancelarOV.php',datosCOV).done(function( data ) { 
						if (data==1){ 
							$('#dialog-confirmarCOV').dialog({ title: 'ORDEN DE VENTA CANCELADA', modal: true, autoOpen: true, 
								closeText: '', width: 600, height: 200, closeOnEscape: true, dialogClass: '',
								buttons:{ "Cerrar":function(){ $('#dialog-confirmarCOV').dialog('close'); } },
								open:function( event, ui ) { 
									window.setTimeout(function(){$('#dialog-confirmarCOV').dialog('close');},1500);
									$('#dialog-cancelOV').dialog('close');
								}, close:function( event, ui ) { $('#clickme_hv, #clickme').click(); }
							});
						} else{alert(data);} 
					});
				} else{ $('#debeConfirmarCOV').hide().show('shake');}
			}, "No":function(){$('#dialog-cancelOV').dialog('close');}
		},
		open:function( event, ui ) { 
			$('#pacienteCancelOV').text(nombreP); $('#refCancelOV').text(refe);
			$('#confirmaCOV').click(function(e) { $('#debeConfirmarCOV').hide();});
		}, close:function( event, ui ) { $('#debeConfirmarCOV').hide(); $('#confirmaCOV').prop('checked',false); }
	});
}); }

function CancelItem(id, ref, concept){ //id es el id de vc
	$('#dialog-eliminarItem').dialog({ title: 'ELIMINAR CONCEPTO', modal: true, autoOpen: true, closeText: '', width: 700, 
		height: 230, closeOnEscape: true, dialogClass: '',
		buttons:{
			"Aceptar":function(){
				if($('#confirmaCOV1').prop('checked')==true){
					var datos = {id:id}
					$.post('files-serverside/eliminarItemOV.php',datos).done(function( data ) { if (data==1){ 
						$('#dialog-confirmarAlgo').dialog({ title:'CONCEPTO ELIMINADO', modal:true, autoOpen: true, closeText: '',
							width: 600, height: 200, closeOnEscape: true, dialogClass: '',
							buttons:{
								"Cerrar":function(){ $('#dialog-confirmarAlgo').dialog('close'); }
							},open:function( event, ui ) {
								$('#textoAlgo').text('¡EL CONCEPTO SE HA ELIMINADO SATISFACTORIAMENTE!');
								$('#dialog-eliminarItem').dialog('close');$('#clickme_hv').click();
								window.setTimeout(function(){$('#dialog-confirmarAlgo').dialog('close');},1500);
							    document.getElementById('form-eliminarItem').reset();$('#debeConfirmarCOV1').hide();
							}, 
							close:function( event, ui ) { $('.'+id).remove(); }
						});
					} else{alert(data);} });
				}else{ $('#debeConfirmarCOV1').hide().show('shake');}
			},
			"Cancelar":function(){ $('#dialog-eliminarItem').dialog('close'); }
		},
		open:function( event, ui ){ $('#conceptoCancel').text(concept); $('.refCancelOV').text(ref); }, 
		close:function( event, ui ){ }
	});
}

function delete_documento(id_doc, nombre_doc, tipo_doc){ $(document).ready(function(e) {//alert(tipo_doc);
$("#dialog-nivel2").load("htmls/eliminacion.php", function( response, status, xhr ) { if ( status == "success" ) { 
	$('#dialog-nivel2').dialog({ title: 'ELIMINAR DOCUMENTO', modal: true, autoOpen: true, closeText: '', width: 700, 
		height: 230, closeOnEscape: true, dialogClass: '',
		buttons:{
			"Aceptar":function(){
				if($('#confirmaEA').prop('checked')==true){
					var datos = {id:id_doc, tipo:tipo_doc}
					$.post('files-serverside/eliminarDocu.php',datos).done(function( data ) { if (data==1){ 
						$('#dialog-confirmarAlgo').dialog({ title:'DOCUMENTO ELIMINADO',modal:true, autoOpen: true, closeText: '',
							width: 600, height: 200, closeOnEscape: true, dialogClass: '',
							buttons:{ "Cerrar":function(){ $('#dialog-confirmarAlgo').dialog('close'); } },
							open:function( event, ui ) {
								$('#textoAlgo').text('¡EL DOCUMENTO SE HA ELIMINADO SATISFACTORIAMENTE!');
							    document.getElementById('form-eliminarAlgo').reset();$('#debeConfirmarCOEA').hide();
								window.setTimeout(function(){$('#dialog-confirmarAlgo').dialog('close');},1500);
								$('#dialog-nivel2').dialog('close');$('#clickmeDocs').click();
							}, close:function( event, ui ) { $('#clickmeDocs').click(); }
						});
					} else{alert(data);} });
				}else{
					$('#debeConfirmarCOEA').hide().show('shake');
					window.setTimeout(function(){$('#debeConfirmarCOEA').hide()},1500);
				}
			}, "Cancelar":function(){ $('#dialog-nivel2').dialog('close'); }
		},
		open:function(event,ui){$('#texto_eliminar_algo').html('¿ESTÁ SEGURO QUE DESEA ELIMINAR EL DOCUMENTO '+nombre_doc+'?');}, 
		close:function( event, ui ){ $('#dialog-nivel2').empty(); $('#tabla_eliminar_algo').remove(); }
	});
} });
}); }

function computeTotalDistance(result) { var total = 0,  myroute = result.routes[0];
  for (var i = 0; i < myroute.legs.length; i++) { total += myroute.legs[i].distance.value; }
  total = total / 1000; document.getElementById('total').innerHTML = total + ' km';
}

function ubicacion(idU, nombreU){ $(document).ready(function(e){
$("#dialog-nivel1").load("htmls/paciente.php #ubicacion", function( response, status, xhr ) { if ( status == "success" ) {
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel1').dialog({ 
		title:'UBICACIÓN DEL PACIENTE '+nombreU,modal:true,autoOpen:true,closeText:'',width:w,height:h,closeOnEscape:true,
		dialogClass:'', 
		buttons:{
			"CÓMO LLEGAR":function(){ var datosP = {idU:idU}
				$.post('files-serverside/datosUbicacion.php',datosP).done(function(data){ var datosP = data.split('{}*');
					$('#right-panel').css('height',$('#indicaciones_map').height())-4;
					$('#indicaciones_map').css('min-width',240);
					$('#right-panel').html('<p>Distancia total: <span id="total"></span></p>');
					
					var la1 = datosP[0], lo1 = datosP[1]; 
					var map = new google.maps.Map(document.getElementById('map1'), {
						center: new google.maps.LatLng(la1, lo1), zoom: 16, scrollwheel: false //Cuautla :3
					});
					var directionsService = new google.maps.DirectionsService;
  					var directionsDisplay = new google.maps.DirectionsRenderer({
						draggable: false, map: map, panel: document.getElementById('right-panel')
					});
					directionsDisplay.addListener('directions_changed', function() {
    					computeTotalDistance(directionsDisplay.getDirections());
  					});
					directionsDisplay.setMap(map);
					marker = new google.maps.Marker({
						map:map,draggable:false, animation: google.maps.Animation.DROP, position: new google.maps.LatLng(la1, lo1)
					});
					var infoWindow = new google.maps.InfoWindow({map: map});
					// Try HTML5 geolocation.
					  if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(function(position) {
						  var pos = { lat: position.coords.latitude, lng: position.coords.longitude };
					
						  map.setCenter(pos);//infoWindow.setContent('Location found.');infoWindow.setPosition(pos);
						  marker = new google.maps.Marker({
								map:map,draggable:false, animation: google.maps.Animation.DROP, 
								position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
						  });
						  var selectedMode = document.getElementById('mode').value;
						  directionsService.route({
							origin: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
							//transitOptions: TransitOptions, 
							drivingOptions: { departureTime: new Date(Date.now()),   trafficModel: "optimistic" },
							destination: new google.maps.LatLng(la1, lo1),
							travelMode: google.maps.TravelMode[selectedMode], avoidTolls: true
						  }, function(response, status) {
							if (status === google.maps.DirectionsStatus.OK) { directionsDisplay.setDirections(response);
							} else { window.alert('Directions request failed due to ' + status); }
						  });
						}, function() { handleLocationError(true, infoWindow, map.getCenter()); });
					  } else { // Browser doesn't support Geolocation
						//handleLocationError(false, infoWindow, map.getCenter());
						infoWindow.setPosition(map.getCenter());
  						infoWindow.setContent(false ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
					  }
				});	
			}
		},
		open:function(event, ui){ var datosP = {idU:idU}
			$.post('files-serverside/datosUbicacion.php',datosP).done(function(data){ var datosP = data.split('{}*');
				if (navigator.geolocation) { //alert(9);
				var la1 = datosP[0], lo1 = datosP[1]; 
				var map = new google.maps.Map(document.getElementById('map1'), {
					center: new google.maps.LatLng(la1, lo1), zoom: 16, scrollwheel: false //Cuautla :3
				}); var infoWindow = new google.maps.InfoWindow({map: map});
				marker = new google.maps.Marker({
					map: map, draggable: false, animation: google.maps.Animation.DROP, position: new google.maps.LatLng(la1, lo1)
				});
				}
			});		
		}, 
		close:function(event,ui){$('#dialog-nivel1').empty(); /*$("#dialog-nivel1").tabs("destroy");*/ }
	});
} });
}); }

function initMap() { }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbPi4G3-wjEbEt_77OmTBhxWvmR23ds9Q&signed_in=true&callback=initMap"
	async defer>
</script>