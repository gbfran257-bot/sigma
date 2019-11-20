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
<link href="../css/pacientes.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.11.4/flick/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../DataTables-1.10.5/media/css/jquery.dataTables.css">

<script src="../jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.11.4/jquery-ui.js"></script>
<script src="../jquery-ui-1.11.4/external/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.5/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../jquery-ui-1.11.4/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.11.4/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/calcula_edad.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/redondea.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../funciones/js/stdlib.js"></script>
<script src="../funciones/js/generador_rfc.js"></script>
<script src="../funciones/js/cantidad_a_letra.js"></script>
<script type="text/javascript" src="imagenes/ajaxupload.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../chart_1.0.2/Chart.min.js"></script>
<script type="text/javascript" src="../funciones/js/jquery.media.js"></script> 
<script type="text/javascript" src="../funciones/js/jquery.fileDownload.js"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script>
$(document).tooltip({position:{my:"center bottom-20",at:"center top",using:function(position,feedback){$(this).css(position);} } });

$(document).ready(function(e) {
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
		
	$('#misDatosUsuario').hide(); var dj = 1;
	
	$('.miUsuario').click( function(e) { dj++; if(dj%2==0){ $('#misDatosUsuario').stop().show('explode','slow'); }else{ $('#misDatosUsuario').stop().hide('explode','slow'); } });
	
	var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75); var cy = $('#header table').height() - 4;

	$('#misDatosUsuario').css('right',cx).css('top',cy);
	cargaFicha();
	
	//esto va despues de la función que carga la ficha del paciente		
	$( window ).resize(function(e) {
        var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75); var cy = $('#header table').height() - 4;
	
		$('#misDatosUsuario').css('right',cx).css('top',cy);
		
		var he = $('#referencia').height() - 200; var wi = $('#referencia').width() * 0.98;
		$("#dialog-confirmarNuevoPaciente").tabs({active: 0}); 
		$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
		
		$('.tabs').css('width',wi/7.5);
    });
	
	$('#dialog-nadaOV').dialog({ autoOpen: false, modal: true, closeOnEscape: true, width: 500, height:200, 
		title: 'REVISE LA ORDEN DE VENTA', closeText: '', dialogClass: 'no-close', 
		buttons: { Cerrar: function() {  $('#dialog-nadaOV').dialog('close'); } } 
	});
	
	$('#addMedico').button({ icons: { primary: "ui-icon-plusthick" }, text: true });
});

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
			$("#dialog-verPaciente").css('width',wi).css('height',he);
						
			//inicializamos el formulario del paciente
			$('.4d').hide();
			$("#bancoPF").load("genera/bancos.php", function( response, status, xhr ) { 
				if ( status == "success" ) { 
					$('#bancoPF').change(function(e) {
                        if($(this).val()!=''){
							$('.4d').show(); $('#digitos4B').focus();
						}else{
							$('.4d').hide();
						}
                    });
				}
			});
			
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
											autoOpen:true, modal:true, width:600, height:200, title:'DATOS GUARDADOS', closeText:'',
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
											autoOpen:true, modal:true, width:600, height:200, title:'DATOS GUARDADOS', closeText:'',
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
			$("#tSangreP").load('files-serverside/genera_tsangre.php',function(response,status,xhr){if(status=="success") {
				
			} });
			$("#sucursalP").load('files-serverside/genera_sucursales.php?idS='+$('#sucursalU').val());
			$("#tsanguineoP").load('files-serverside/genera_tsangre.php');
			
			$("#estadoP,#estadoPF").load('files-serverside/genera_estados.php',function(response,status,xhr){if(status=="success") {
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
						$("#entidadNacimientoP").load('files-serverside/genera_nada.php', function( response, status, xhr ) { 
							//if ( status == "success" ) { if( $('#formGenerales').valid() ){} } 
						});
						$('#curpP, #rfcP').val('');
					}
                });
				$('#fnacP, #sexoP').change(function(e) {
                    if($('#fnacP').val()!='' & $('#sexoP').val()!='' & $('#nombreP').val()!='' & $('#apaternoP').val()!=''){ 
						$("#entidadNacimientoP").load('files-serverside/genera_estadosEN.php', function( response, status, xhr ) { 
							if ( status == "success" ) { } 
						});
					}else{ 
						$("#entidadNacimientoP").load('files-serverside/genera_nada.php', function( response, status, xhr ) { 
							//if ( status == "success" ) { if( $('#formGenerales').valid() ){} } 
						});
						$('#curpP, #rfcP').val('');
					}
                });
				//Fin funciones calcular rfc y crup
				
				$("#estadoP").change(function(event){ $('#municipioP, #coloniaP').change();
					var id = $("#estadoP").find(':selected').text();//alert(id);
					$("#municipioP").load('files-serverside/genera_municipios.php?id='+escape(id),function(response, status, xhr ) {
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
					$("#municipioPF").load('files-serverside/genera_municipios.php?id='+escape(idF),function(response,status,xhr) {
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
			
			$('#addConvenio').button({ icons: { primary: "ui-icon-plusthick" }, text: false });
			
			$('form').submit(function(event) { event.preventDefault(); });
			
			var he1 = $('#referencia').height() - 100; var wi1 = $('#referencia').width() * 0.98;
			
			$('#upload').button({ icons: { primary: "ui-icon-image" }, text: true, label: "Agregar fotografía" });
		}
	});//fin load
	$('#formGenerales input, #dialog-verPaciente select, #dialog-verPaciente textarea').addClass('campoITtab');
	return true;
}); }//fin ready //fin cargarFicha()

function asignarConvenio(idC, nC){ $(document).ready(function(e) { $('#idC_AC').val(idC); $('#convenioAC').val(nC); $('#dialog-asignacionConvenio').dialog('open'); }); }
</script>

<script>
  $.widget( "ui.timespinner", $.ui.spinner, {
	options: { step: 60 * 1000, /*seconds*/ page: 60 /*hours*/ },
	_parse: function( value ) { if ( typeof value === "string" ) { if ( Number( value ) == value ) { return Number( value ); } return +Globalize.parseDate( value ); } return value; },
	_format: function( value ) { return Globalize.format( new Date(value), "t" ); }
  });
</script>

<script>

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
$(document).ready(function(e) { $('#miMenu').hide(); $('#verMenu').click(function(e) { verMenu(); }); });
function verMenu(){ $(document).ready(function(e) { $('#miMenu').show('fold','slow'); $('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">PACIENTES</span>'); }); }
function ocultarMenu(){ $(document).ready(function(e) { $('#miMenu').hide('fold','slow'); $('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">PACIENTES</span>'); }); }
$(document).ready(function(e) { $("#upload").button({ icons: { primary: "ui-icon-image" }, text: true }); });
</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; border: 1px solid red; z-index:1000000000000000000000;"> </div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="sucursalU" type="hidden" id="sucursalU" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="indicePaciente" type="hidden" id="indicePaciente">
<input name="sucursalOV" type="hidden" id="sucursalOV" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="today" id="today" type="hidden" value="<?php echo date("d/m/Y"); ?>"> <input name="filtro" id="filtro" type="hidden" value="YO SOLO SE QUE NO SE NADA">

<input name="precioTemp" id="precioTemp" type="hidden" value="0"> <input name="urgeAtender1" id="urgeAtender1" type="hidden" value="0"> <input name="contaItems" id="contaItems" type="hidden" value="0"><input name="estado_pago_ov" id="estado_pago_ov" type="hidden" value="0">

<div id="header" class="header" style="display:;">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" class="iconito"><img src="../imagenes/iconitos/_iconoPacientes.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">PACIENTES</span></td>
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
    <table width="100%" border="0" cellspacing="0" cellpadding="6">
        <tr>
            <td>
            <?php if($row_usuario['foto_u'] == 1){?>
                <img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="80">
            <?php }else{?>
                <img class="fotoUsuario" id="miFotoUsuario" src="../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="80">
            <?php }?>
            </td>
            <td align="left" valign="top" class="nombreUsuario"><?php echo $row_usuario['nombre_u']." ".$row_usuario['apaterno_u']." ".$row_usuario['amaterno_u']; ?> </td>
        </tr>
    </table>
    
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr> <td style="font-weight:bold;" align="center"><?php echo $row_nombreSucursalUsuario['nombre_su']; ?></td> </tr>
        <tr> <td style="font-size:0.8em;" align="center"><?php echo $row_nombreDepartamentoUsuario['nombre_d']; ?></td> </tr>
        <tr> <td style="font-size:0.8em;" align="center"><span style="text-decoration:underline; cursor:pointer;"><a href="<?php echo $logoutAction ?>">CERRAR SESIÓN</a></span></td> </tr>
    </table>
    </div>
        </td>
      </tr>
    </table>
</div>

<div id="miMenu" class="miMenu" align="center">
<table width="98%" height="100%" border="0" cellspacing="0" cellpadding="0" class=""> 
<tr valign="middle" align="center" class="fondoMenu">
    <td class="eii">
    <img title="Menú terapia" src="../imagenes/submenu/_terapia.png" width="90" onClick="window.location='../menu_terapia.php'">
    </td>
    <td class="eid"><img title="Inicio" src="../imagenes/submenu/_inicio.png" width="90" onClick="window.location='../menu.php'"></td>
</tr> </table>
</div>

<div class="contenido" id="contenido" align="center">
<table width="90%" height="100%" border="0" cellpadding="4" cellspacing="2" id="dataTablePrincipal" class="tablilla"> 
<thead id="cabecera_tBusquedaPrincipal" class="">
  <tr bgcolor="#FF6633" style="font-size:1.3em;">
    <th id="clickme"class="titulosTabs"align="center" nowrap width="10px" style="color:white;">
    	<span title="Consentimiento informado">CI</span>
    </th>
    <th class="titulosTabs" align="center" style="color:white;" width="10px">FÓLIO</th>
    <th class="titulosTabs" align="center" style="color:white;">NOMBRE</th>
    <th class="titulosTabs" align="center" width="100px" style="color:white;">EDAD</th>
    <th class="titulosTabs" align="center" style="color:white;">SEXO</th>
    <th class="titulosTabs" align="center" style="color:white;" width="110px">TELÉFONO</th>
    <th class="titulosTabs" align="center" width="10px" style="color:white;">U.MÉDICA</th>
    <th class="titulosTabs" align="center" width="5px" style="color:white;"><span title="LISTA DE BENEFICIOS">BNFS</span></th>
    <th class="titulosTabs" align="center" width="5px" style="color:white;">VISITA</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> </table>
</div>

<div id="dialog-verPaciente" style="display:none; overflow:hidden;"> </div>

<div id="dialog-confirmarAlgo" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2"> <tr> <td align="center" valign="middle"><span id="textoAlgo"></span></td> </tr> </table> </div>

<div id="dialog-nuevaVisita" style="display:none;"> </div>

<div id="dialog-buscaMedico" title="BUSCAR MÉDICO" style="display:none;"> </div>

<div id="dialog-confirmaciones" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" valign="middle" height="100%"><span id="texto-confirmaciones">GUARDADO SATISFACTORIAMENTE</span></td></tr></table></div>

<div id="dialog-confirmacion" style="display:none;">
<p class="textoMsjConfirmacion">¡LA ORDEN SE HA REGISTRADO CORRECTAMENTE!</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><input name="contadorX" id="contadorX" type="hidden"> <tr>
    <td><span id="imprimeTicket" class="miRecibo" style="cursor:pointer; font-style:italic; color:rgba(255,0,0,0.9); display:none; text-decoration:underline;">IMPRIMIR TICKET</span></td>
    <td><span class="miRecibo" style="cursor:pointer; font-style:italic; color:rgba(255,0,0,0.9); display:none; text-decoration:underline;">IMPRIMIR HOJA</span></td>
</tr> </table>
</div>

<div id="dialog-confirmacion1" style="display:none;"> <p class="textoMsjConfirmacion1">Guardando Datos...</p> ¡Por favor espere! </div>

<div id="dialog-preguntar" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3"> <tr> <td align="left"><span id="textoPreguntar">¿ESTA SEGURO QUE</span></td> </tr> </table></div>

<div id="dialog-nuevo" style="display:none;"> </div>

<div id="dialog-informar" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="middle" height="100%"><span id="texto-informar"></span></td></tr></table></div>

<div id="dialog-historial" style="display:none;"> </div>

<div id="dialog-ci" style="display:none;"> 
<table width="100%" border="1" cellspacing="8" cellpadding="5">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td width="1px">DIF</td>
        <td align="center">
        SISTEMA NACIONAL PARA EL DESARROLLO INTEGRAL DE A FAMILIA<br>
        DIRECIÓN GENERAL DE REHABILITACIÓN<br>
        DIRECCIÓN DE REHABILITACIÓN<br>
        SUBDIRECCIÓN DE UNIDADES OPERATIVAS EN LOS ESTADOS
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    	H.H. CUAUTLA, MOR. A <span id="fechaCId">8</span> de <span id="fCIm">MARZO</span> del <span id="fCIa">2016</span>. 
        HORA: <span id="fCIh">9:00 hrs</span>
    </td>
  </tr>
  <tr>
    <td align="center">
    	CARTA DE CONSENTIMIENTO INFORMADO
    </td>
  </tr>
  <tr>
    <td align="justify">
    Por este conducto DOY MI CONSENTIMIENTO para recibir la valoración y el tratamiento médico rehabilitatorio necesario, toda vez que el médico responsable me explique lo relacionado con mi padecimiento, el tipo de tratamiento que recibiré, las secuelas y posibles riesgos que pudiera presentar como consecuencia de mi padecimiento y del tratamiento rehabilitatorio, así mismo autorizo al personal de salud para la atención de contingéncias y urgencias derivadas del tratamiento.<br><br>
    Me comprometo a RESPETAR las citas que me otorgue el Centro de Rehabilitación Integral Cuautla, Morelos, presentarme con el carnet vigente y acudor a los servicios a donde me envíen. Así mismo, tengo el derecho a acudir a mi médico responsable en éste Centro para que aclare mis dudas en el consultorio y horario correspondiente.
    </td>
  </tr>
  <tr>
    <td align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td>Nombre del paciente: <span id="nombrePci"></span></td>
      </tr>
      <tr>
        <td>Diagnóstico: <span id="dxPci"></span></td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td>Edas: <span id="dxPci"></span></td>
            <td>Género: <span id="dxPci"></span></td>
            <td>No Exp: <span id="dxPci"></span></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        Domicilio: <span id="domicilioPci"></span>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td>NOMBRE DEL RESPONSABLE DEL MENOR O PERSONA CON DISCAPACIDAD</td>
      </tr>
      <tr>
        <td>Nombre <span id="tutorMEnor"></span> Parentesco <span id="parentescoTutor"></span></td>
      </tr>
      <tr>
        <td>Edad <span id="edadTutor"></span> Género <span id="generoTutor"></span></td>
      </tr>
      <tr>
        <td>Domicilio <span id="domicilioTutor"></span></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="left">
    MÉDICO<br>
    Nombre del Médico Responsable:
    </td>
  </tr>
  <tr>
    <td align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td>TESTIGO</td>
      </tr>
      <tr>
        <td>Nombre <span id="nombretestigo"></span></td>
      </tr>
      <tr>
        <td>Edad <span id="edadtestigo"></span> Parentesco <span id="parentescotestigo"></span> Teléfono <span id="teltestigo"></span></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td align="center">FIRMA DEL PACIENTE O RESPONSABLE</td>
        <td align="center">FIRMA DEL MÉDICO</td>
        <td align="center">FIRMA TESTIGO</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</div>

<input name="miFacturados" id="miFacturados" type="hidden" value="0,1">
<input name="miSaldazos" id="miSaldazos" type="hidden" value="0">

</body>
</html>

<?php mysql_free_result($usuario); mysql_free_result($nombreSucursalUsuario); mysql_free_result($nombreDepartamentoUsuario); ?>

<script type="text/javascript">
function misPacientes(){ $(document).ready(function(e) {
	window.setTimeout(function(){
		var allBotonesIcono = $('.botonaso'); allBotonesIcono.css('width','25px').css('height','25px');
		
		$('.icono_proceso').button({      icons: { primary: "ui-icon-gear"},     text: false });
        $('.icono_realizado').button({    icons: { primary: "ui-icon-comment"},     text: false });
	    $('.icono_capturado').button({    icons: { primary: "ui-icon-check"},     text: false });
	    $('.icono_interpretado').button({ icons: { primary: "ui-icon-search"},   text: false });
		$('.icono_imprimir').button({     icons: { primary: "ui-icon-print"},    text: false });
		$('.icono_entregar').button({     icons: { primary: "ui-icon-person"},    text: false });
		$('.icono_cargado').button({     icons: { primary: "ui-icon-document"},    text: false });
		$('.miPDF').button({              icons: { primary: "ui-icon-document"}, text: false });
		$('.updatePDF').button({          icons: { primary: "ui-icon-refresh"},  text: false });
		
		$('.botonaso').click(function(event) { event.preventDefault(); });	
	},9); 
});}

$(document).ready(function() {				
	var oTableP;
	var tamP = $('#referencia').height() - 170;
	oTableP = $('#dataTablePrincipal').dataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true,ordering: false, "bJQueryUI": false,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { misPacientes(); },
		"aoColumns": [
			{ "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }, { "bVisible": false }, 
			{ "bSortable": false }, { "bSortable": false }, { "bVisible": false }, { "bVisible": false }
		],
		
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"iS>',
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
	
	$('#addPacientePrincipal').css('height', $('.filtro1Principal input').height() -10);
	$('.filtro1Principal input').attr("placeholder", "BUSQUE UN PACIENTE AQUÍ...").addClass('placeHolder');
	
	//ponemos los botones de reset y de añadir un paciente de la tabla principal de busqueda de pacientes
	$("div.toolbar").css('white-space','nowrap').css('border','1px none red').css('padding','10px');
	
	if($('.filtro1Principal input').val() ==''){ $('#filtro').val('YO SOLO SE QUE NO SE NADA'); }else{ $('#filtro').val('%%');oTableP.fnDraw(); }
		
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
	
	$('#ocultarFP').hide();
	
	if($('.filtro1Principal input').val() ==''){ div_botonesP.hide(); $('#ocultarFP').hide();
	}else{ div_botonesP.show(); $('#ocultarFP').show(); }
	
	paginacionesP.hide();
	
	search_boxP.focus();
	
	search_boxP.keyup(function(e) {
    	if( $(this).val() == '' ){ $('#filtro').val('YO SOLO SE QUE NO SE NADA'); $('#ocultarFP').hide(); div_botonesP.hide(); oTableP.fnDraw();
		}else { $('#filtro').val('%%'); $('#ocultarFP').show(); div_botonesP.show(); oTableP.fnDraw(); }
    });
	
	reseteP.click(function(e) { search_boxP.val(''); search_boxP.focus(); $('#filtro').val('YO SOLO SE QUE NO SE NADA'); div_botonesP.hide(); oTableP.fnDraw(); });
	
	$('#clickme').click(function(e) { oTableP.fnDraw(); });

});
</script>

<script>
$(document).ready(function(e) {
	var he1 = $('#referencia').height() - 100; var wi1 = $('#referencia').width() * 0.98;
	
	$('#dialog-verPaciente').dialog({ autoOpen: false, modal:true,width:wi1,height:he1,title:'FICHA DEL PACIENTE',closeText:'' });
	
	$('#dialog-ci').dialog({ autoOpen: false, modal:true,width:wi1,height:he1,title:'CONSENTIMIENTO INFORMADO',closeText:'' });
		
});
</script>

<script>
function SubirPhoto(a,b){//si el paciente cuenta con fotografía. A es el id del paciente, b es el nombre que tiene la fotografía y x es de nuevo el id del paciente
	$(document).ready(function(e) { //alert('cargar foto, el id del paciente es '+a+' el nombre del archivo de la foto es '+b); //Todo el pedo de la fotografía del perfil
		var button = $('#upload'), interval;
		new AjaxUpload(button,{
			action: 'imagenes/procesa.php?action='+b+'&idP='+a, 
			name: 'image',
			onChange : function(file, ext){ if(openFile(file)==0){/*si el archivo no es una imagen */ $('#upload').button({ icons: { primary: "ui-icon-alert" }, text: true, label: "Archivo no válido" }); return false; /*se cancela */} },
			onSubmit : function(file, ext){ button.text('Subiendo'); interval = window.setInterval(function(){ var text = button.text(); if (text.length < 11){ button.text(text + '.');	} else { button.text('Subiendo'); } }, 200); },
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
		$('#upload').button({ icons: { primary: "ui-icon-image" }, text: true, label: "Agregar fotografía" }).show();//alert('no hay foto y el id del paciente es '+datosI[39]);
		return SubirPhoto(a,b);
    });
}
function cargarPhoto(a,b){//a es el id del paciente y b es el nombre de la foto
$(document).ready(function(e) {//alert('Procesa en ver paciente cargar foto existente');
    $("#gallery").load("imagenes/procesa.php?action=listFotos&idPac="+a, function( response, status, xhr ) { if ( status == "success" ) { $('#gallery .eliminame1').click(function(e) { return eliminarPhoto(a,b); }); } });return;
});
}
function eliminarPhoto(a,b){//a es el id del paciente y b es el nombre de la foto
$(document).ready(function(e) {
	var a1 = $('#gallery .eliminame1'); //alert(a.attr('name'));	
	$.get("imagenes/procesa.php?action=eliminar1",{idP:a, nombreF:b},function(){//alert('Procesa en ver paciente eliminar foto existente');
		a1.parent().fadeOut("slow"); //alert(a.attr('name'));//alert(x+'5');
		$('#upload').button({ icons: { primary: "ui-icon-image" }, text: true, label: "Agregar fotografía" }).show();
		$('#hayFoto').val(0); $('#nombreFotoT').val(''); $('#idPacienteN').val(''); $('#idPacienteN').val(a);
		var now = new Date().getTime(); var d = new Date();
		return photoNo(a,d.format('Y-m-d-H-i-s-u').substring(0,22),a);
	});
});
}

function verPaciente(x){//x es el id del paciente q seleccionamos
 $(document).ready(function(e) { //alert(x);
 $('.idP_fichaP').val(x); $('#idPacienteN').val(''); $('#nombreFotoT').val('');
	$('#idPacienteN').val(x);//asignamos el id del paciente a la variable para saber cual paciente actualizar por su id
	 var datos ={idP:x}
	 
	 $.post('files-serverside/fichaPaciente.php',datos).done(function( data1 ) {
		if (data1 != "ok"){
			var datosI = data1.split('*}'); //alert(datosI[42]);
			var he = $('#referencia').height() - $('#header').height()-50; var wi = $('#referencia').width() * 0.98;
			
			var title = 'PACIENTE '+datosI[1]+' '+datosI[2]+' '+datosI[3]+' REGISTRADO POR '+datosI[40]+' '+datosI[41]; $('#pacienteAC').val(datosI[1]+' '+datosI[2]+' '+datosI[3]);
			$('#dialog-verPaciente').dialog({
			  title: title, modal: true, autoOpen: false, closeText: '', width: wi, height: he, closeOnEscape: true,
			  dialogClass:'',
			  buttons: { /*"ACTUALIZAR": function() { }, "CERRAR": function() { $(this).dialog('close'); }*/ },
			  create: function( event, ui ) {},
			  open:function( event, ui ){
				  $('.ingreso, .egreso').css('width','100px');
				  $('.miTab').css('height',100);
				  $('#nombreP').focus(); $('#tabs-1-1').click(function(e) { $('#nombreP').focus(); });
				  $("#miTabsH").tabs({active: 0});
				  window.setTimeout(function(){$('.tablaTS').css('height',$('#dialog-verPaciente').height()-100);},100);
				  
				  $('#pestanas1').removeClass('ui-widget-header');
				  
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
		
				  $('.botonesSaveP').hide(); $('.botonesUpdateP').show();
				  //$('#formGenerales input, #dialog-verPaciente select, #dialog-verPaciente textarea').prop('disabled',true);
				  $('#cancelEditPac, #updatePac').hide();
										
				window.setTimeout(function(){
					$('#pestanas').removeClass('ui-widget-header'); 
					$('#formGenerales input, #dialog-verPaciente select, #dialog-verPaciente textarea').addClass('campoITtab');
					
					$('.pActivo').show();$("#dialog-verPaciente").tabs({active: 0, heightStyle: "auto"});
					
					if(datosI[37]==1){//Si el paciente tiene fotografía //Si el paciente tiene fotografía, entonces la carga // Listar  fotos que hay en mi tabla
						photoSi(datosI[39],datosI[38],x);
					}else{//Si el paciente NO tiene fotografía
						var now = new Date().getTime(); var d = new Date(); 
						photoNo(datosI[39],d.format('Y-m-d-H-i-s-u').substring(0,22),x);
					}
					$('#dialog-verPaciente input, #dialog-verPaciente select, #dialog-verPaciente textarea').addClass('campoITtab');
					$('.idUsuarioP').val($('#idUsuario').val()); $('.pActivo').show(); 
					//ponemos los valores INICIALES DE LA FICHA DEL PACIENTE //window.setTimeout(function(){},1000);
					//$("#entidadNacimientoP, #sucursalP").prop('disabled',true);
					var fechaN1 = datosI[20].split('/'); var fxD = fechaN1[0], fxM = fechaN1[1], fxY = fechaN1[2];
					if(fxD.length == 1){fxD = '0'+fxD;} if(fxM.length == 1){fxM = '0'+fxM;}
					$('#rfcPF').val(datosI[51]);$('#bancoPF').val(datosI[52]);$('#digitos4B').val(datosI[53]);
					if($('#bancoPF').val()!=''){$('.4d').show();}else{$('.4d').hide();}
					$("#fnacP").val(fxD+'/'+fxM+'/'+fxY); //$("#fnacP").val(datosI[20]);
					$('#tSangreP').val(datosI[6]);//HEY
					$('#nombreP').val(datosI[1]);$('#apaternoP').val(datosI[2]);$('#amaternoP').val(datosI[3]);$("#sexoP").val(datosI[19]);$("#nacionalidadP").val(datosI[24]);$('#edadP').val(calcular_edad(datosI[20]));
					$('#telmovilP').val(datosI[10]);$('#telparticularP').val(datosI[11]);$('#sucursalP').val(datosI[17]);$('#notasP').val(datosI[21]);$('#tsanguineoP').val(datosI[6]); $('#curpP').val(datosI[0]);$('#rfcP').val(datosI[14]);
					
					$("#entidadNacimientoP").load('files-serverside/genera_estados.php', function( response, status, xhr ) { 
						if ( status == "success" ) { $('#entidadNacimientoP').val(datosI[42]); } 
					});
					
					$('#razonPF').val(datosI[43]);
					
					//Datos de dirección
					$('#estadoP').val(datosI[28]);var idB = $("#estadoP").find(':selected').text();
					$("#municipioP").load('files-serverside/genera_municipios.php?id='+escape(idB),function(response,status, xhr ) {
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
					$('#calleP').val(datosI[25]);$('#noExtP').val(datosI[26]);$('#noIntP').val(datosI[27]);
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
					$('#nsocioeconomicoP').val(datosI[4]);$('#escolaridadP').val(datosI[22]);$('#ocupacionP').val(datosI[23]);$('#religionP').val(datosI[9]);$('#etniaP').val(datosI[8]);$('#discapacidadP').val(datosI[7]);
				},100);
					
				}, close:function( event, ui ){ $( "#dialog-verPaciente" ).tabs( "destroy" );$('#dialog-verPaciente').empty();cargaFicha(); }
			});
			$('.rnacido').hide();
			$('#dialog-verPaciente').dialog('open');
		}else{alert(data);}
	});//guardamso al nuevo paciente
 });
}//fin verPaciente

function campos(x,id){ $(document).ready(function(e) { 
	if(!parseFloat(x) & x!=0){$('#pagoT_NV').val('');}
	else{$('#pagoT_NV').val(parseFloat(x).toFixed(2));} 
});}

//función para la info de detalle de cada registro
function fnFormatDetails ( oTable, nTr, x) { var aData = oTable.fnGetData( nTr ); var sOut = x; return sOut; }

function consentimientoI(idP, nombreP){ $(document).ready(function(e) {
	$('#dialog-ci').dialog('open');
	$('#nombrePci').text(nombreP);
});}
</script>