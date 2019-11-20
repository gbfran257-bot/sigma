<?php require_once('../Connections/horizonte.php'); ?>
<?php
//initialize the session
ini_set("session.cookie_lifetime","7200");
ini_set("session.gc_maxlifetime","7200");
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
  if ($logoutGoTo) { header("Location: $logoutGoTo"); exit;}
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
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../imagenes/favicon.ico">
<meta charset="utf-8">
<title>ENFERMERÍA</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../css/caja.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link href="../jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">
<link href="../DataTables-1.10.5/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet">
<link href="../Editor-PHP-1.4.0/css/dataTables.editor.css" rel="stylesheet">

<script src="../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.5/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="../Editor-PHP-1.4.0/js/dataTables.editor.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/retardo.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../jQuery-TE_v.1.4.0/uncompressed/jquery-te-1.4.0.js" charset="utf-8" type="text/javascript"></script>
<script src="../chart_1.0.2/Chart.min.js"></script>
<script src="../funciones/js/jquery.media.js" type="text/javascript"></script> 
<script src="../funciones/js/jquery.fileDownload.js" type="text/javascript" ></script>

<script>
$( document ).tooltip({ extraClass: "arrow", position: { my: "center bottom-10",	at: "center top" } });

$(document).ready(function(e) {
	$('#form-captura').validate({ rules:{ diagnostico:{ required:true } }, messages:{ diagnostico:{ required:'Debe ingresar el diagnóstico' } } });
	
	setInterval(function(){$.post('../remote_files/refresh_session.php'); },500000);
	
	$('#verMenu').click(function(e){window.location='../menu.php?menu=mh';}); 
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

<script type="text/javascript">
//para fintro individual por campo de texto
var asInitVals = new Array();
//fin para filtro individual por campo de texto

$(document).ready(function() {
	
	var tam = $('#referencia').height() - 145;
	
	oTable = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {  
			myFunction(); $('span.DataTables_sort_icon').remove();
		},
		"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, 
		"bStateSave": false, "bInfo": false, "bFilter": true, "aaSorting": [[0, "asc"]],
		"aoColumns": [
			{ "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bVisible": false }, { "bSortable": false }, 
			{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
		],
		"iDisplayLength": 1000, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info"i>',
		 "sAjaxSource": "datatable-serverside/consultas.php?idU="+$('#idUser').val(),
		"fnServerParams": function (aoData, fnCallback) { 
			var de = document.getElementById('fechaDe').value+' 00:00:00'; 
			var a = $('#fechaA').val()+' 23:59:59';
			var accesoU = $('#accesoU').val();
			var idU = $('#idUser').val();
			aoData.push(  {"name": "min", "value": de } ); 
			aoData.push(  {"name": "max", "value": a } );
			aoData.push(  {"name": "accesoU", "value": accesoU } );
			aoData.push(  {"name": "idU", "value": idU } );
		},
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": { 
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "MOSTRADAS: _END_", "sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "&nbsp;TOTAL DE CONSULTAS: _MAX_", 
			"sSearch": "BUSCAR" 
		}
	});//fin data table
	
	$('#clickme').click(function(e) { oTable.fnDraw(); myFunction(); });
	
	window.setTimeout(function(){
		$('#sPaciente8').val('ASOCIACION MEDICA'); oTable.fnFilter('ASOCIACION MEDICA',$("tfoot input").index(5));
	},500);
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { oTable.fnFilter( this.value, $("tfoot input").index(this) ); } );
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus(function(){if(this.className=="search_init"){ this.className = ""; this.value = "";myFunction(); } } );
     
    $("tfoot input").blur( function (i) { if ( this.value == "" ) { this.className = "search_init"; this.value = asInitVals[$("tfoot input").index(this)];myFunction(); } } );
	
	$('#radio1').click(function(e) { $('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); });
	
	$('#radio2').click(function(e) { $('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); });
	$( "#fechaDe" ).datepicker({ defaultDate: "-1", maxDate: +0, onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); }, "onSelect": function(date) { min = date+' 00:00:00'; oTable.fnDraw(); } }).css('max-width','100px');
	$( "#fechaA" ).datepicker({ defaultDate: "+0", maxDate: +0, onClose: function( selectedDate ) { $( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); }, "onSelect": function(date) { max = date+' 23:59:59'; oTable.fnDraw(); } }).css('max-width','100px');
			
});

</script>
<script>
jQuery(function($){
    $.datepicker.regional['es'] = {//dateFormat: 'mm/dd/yy',
        closeText: 'Cerrar', changeMonth: true, changeYear: true, numberOfMonths: 3, dateFormat: "yy-mm-dd", prevText: '&#x3c;Ant', nextText: 'Sig&#x3e;', currentText: 'Hoy',
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun', 'Jul','Ago','Sep','Oct','Nov','Dic'], dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'], dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'], weekHeader: 'Sm', firstDay: 1, isRTL: false, showMonthAfterYear: false, yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['es']);
});
$(document).ready(function(e) {
	$('#divRangoFechas').css('width','80%').css('float','left').css('border-width','1px').css('border-style','none').css('color','white'); $( '#rangosFechas' ).buttonset().css('font-size','0.9em'); $('.rad').css('font-size','0.8em'); $('#input').jqte();
});
</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="fechaHoy" type="hidden" id="fechaHoy" value="<?php echo date("d/m/Y"); ?>">
<input name="nombreTempPdf" id="nombreTempPdf" type="hidden" value="">
<input name="id_vc_ini" id="id_vc_ini" type="hidden" value="">
<input name="usuario_ini" id="usuario_ini" type="hidden" value="<?php echo $row_usuario['usuario_u']; ?>">
<input name="campoUrl" id="campoUrl" type="hidden" value="">

<div id="header" class="header">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_enfermeria.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">ENFERMERÍA</span></td>
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
  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTable" class="tablilla">
    <thead id="cabecera_tBusquedaP">
      <tr class="titulos_dataceldas">
        <th id="clickme" width="40px">REFERENCIA</th>
        <th nowrap width="210">PACIENTE</th>
        <th nowrap width="">MÉDICO</th>
     	<th width="100px">ESPECIALIDAD</th>
        <th nowrap width="60px">S-V</th>
		<th nowrap width="40px">H-C</th>
		<th>CONCEPTO</th>
        <th width="10px">ESTATUS</th>
        <th width="">DEPARTAMENTO</th>
      </tr>
    </thead>
    <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
    	<tr>
        	<td><input name="sPaciente" id="sPaciente" type="text" placeholder="Referencia" class="search_init" style="width:90%;" /></td>
        	<td><input name="sPaciente1" id="sPaciente1" type="text" placeholder="Paciente" class="search_init" style="width:90%;" /></td>
        	<td><input name="sPaciente2" id="sPaciente2" type="text" placeholder="Médico" class="search_init" style="width:90%;" /></td>
        	<td><input name="sPaciente3" id="sPaciente3" type="text" placeholder="Especialidad" class="search_init" style="width:90%;" /></td>
     		<td><input name="sPaciente4" id="sPaciente4" type="hidden" value=""></td>
			<td><input name="sPaciente5" id="sPaciente5" type="hidden" value=""></td>
        	<td>
            <input name="sPaciente52" id="sPaciente52" type="hidden" value="">
            <input name="sPaciente7" id="sPaciente7" type="text" placeholder="Concepto" class="search_init" style="width:90%;" />
            </td>
            <td>
            <input name="sPaciente6" id="sPaciente6" type="text" placeholder="Estatus" class="search_init" style="width:90%;" />
            </td>
            <td><input name="sPaciente8" id="sPaciente8" type="text" placeholder="Departamento" class="search_init" style="width:90%;" /></td>
        </tr>
    </tfoot>
  </table>
  
<div id="divRangoFechas" style="border:2px none red; display:block; width:60%; float:left;">
  <table width="100%" border="0" cellpadding="4" cellspacing="0" style="color:black;">
  <tr>
    <td width="10px">De </td>
    <td width="1%">
    	<input style="height:80%; font-size:1.1em; border-radius:4px;" name="fechaDe" class="fechas" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly >
    </td>
    <td width="10px">A </td>
    <td width="1%">
    	<input style="height:80%; font-size:1.1em; border-radius:4px;" name="fechaA" type="text" class="fechas" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly >
    </td>
    <td id="rangosFechas">
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label>
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
  </tr>
</table>
</div>
  
</div>

<div id="dialog" style="display:none;"> </div>
<div id="dialog1" style="display:none;"> </div>
<div id="dialog-buscar" style="display:none;"> </div>
<div id="dialog-preguntar" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" valign="middle" height="100%"><span id="texto-preguntar" style="text-align:justify;"></span></td></tr></table></div>
<div id="dialog-informar" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" valign="middle" height="100%"><span id="texto-informar"></span></td></tr></table></div>
<div id="dialog-receta" style="display:none;"> </div>
<div id="dialog-graficas" style="display:none;"> </div>
<div id="dialog-nuevo" style="display:none;"> </div>

<div id="dialog-rDX" style="display:none;"> </div>

</body>
</html>

<?php mysql_free_result($usuario); ?>

<script>
function historiaCvacia(idP,control){ $(document).ready(function(e) {/*si control es 1 al cerrar la ventana abre VerHC*/
	$("#dialog").load("../consultas/htmls/historia_clinicaC.php #tabs_hc", function( response, status, xhr ) {if( status == "success" ){
		$('#b_editarHC').button({ icons:{primary:'ui-icon-pencil'} });
		$('#b_actualizarHC').button({ icons:{primary:'ui-icon-refresh'} });
		$('#b_cancelHC').button({ icons:{primary:'ui-icon-cancel'} });
		$('.botonC').click(function(event) { event.preventDefault(); });
		$('#b_actualizarHC, #b_cancelHC').hide();
		$('#b_editarHC').click(function(e) {
			$('#tabs_hc input, #tabs_hc select, #tabs_hc textarea').prop('disabled',false); 
			$('#b_actualizarHC, #b_cancelHC').show(); $('#b_editarHC').hide();
		});
		$('#b_cancelHC').click(function(e) {
			$('#tabs_hc input, #tabs_hc select, #tabs_hc textarea').prop('disabled',true); 
			$('#b_actualizarHC, #b_cancelHC').hide(); $('#b_editarHC').show(); $('#tabs-2-1').click();
		});
		$('#b_actualizarHC').click(function(e) { 
			var datosHC1 = $('#formHistoriaClinica').serialize();
			$.post('../consultas/files-serverside/actualizarHC.php',datosHC1).done(function(data){ if(data==1){
				$('#texto-informar').text('La historia clínica se ha guardado correctamente.'); 
				$('#b_cancelHC').click();
				
				$('#dialog-informar').dialog({autoOpen:true,modal:true,width:500,height:150,
					title:'HISTORIA CLÍNICA ACTUALIZADA',closeText:'', buttons:{},
					open:function(event, ui){ 
						window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000); 
					}
				});
			}else{alert(data);} });
		});
								
		$("#dialog *").css('font-size','0.98em');
		$('#idUsuario_hc').val($('#idUser').val()); $('#formHistoriaClinica').validate({ignore: 'hidden'});
		$('#dialog input, #dialog select, #dialog textarea').addClass('campoITtab'); $("#dialog").tabs({active: 0}); 
		$('#tabs-5-1').hide();
		$('#idPaciente_hc').val(idP); var datosIDP = {idP:idP, idC:1}
	  $.post('files-serverside/datosSV.php',datosIDP).done(function(data){ var datos = data.split(';*-');
	  	var datosMiHC = { idP:idP }
		$.post('files-serverside/datosHC.php',datosMiHC).done(function(dataHC){ var datosHC = dataHC.split(';*-'); 
		
	  	$('.estatusVive').load("files-serverside/cargar_estatus_vive.php", function( response, status, xhr ) { 
			$('#estatus_padre').val(datosHC[0]);$('#estatus_madre').val(datosHC[5]);$('#estatus_conyugue').val(datosHC[15]);
			$('#formHistoriaClinica select.estatusVive').change(function(e) { 
				if($(this).val()!=''){ $(this).addClass('formatoHC');}
				else{ $(this).removeClass('formatoHC');} 
			});
			$('#formHistoriaClinica select.estatusVive').each(function(index, element) { 
				if($(this).val()!=''){ $(this).addClass('formatoHC');}else{ $(this).removeClass('formatoHC');} 
			}); 
		});
		
		$('.enfermedad').load("files-serverside/cargar_enfermedades.php", function( response, status, xhr ) { 
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
					if($(this).val()!=''){ 
						$(this).addClass('formatoHC').css('color','black');
					}
					else{ 
						$(this).removeClass('formatoHC').css('color','black');
					} 
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
			
		$('.adiccion').load("files-serverside/cargar_adicciones.php", function( response, status, xhr ) { 
			$('#adiccion1').val(datosHC[26]);$('#adiccion2').val(datosHC[27]);$('#adiccion3').val(datosHC[28]); 
		});
		$('.deporte').load("files-serverside/cargar_deportes.php", function( response, status, xhr ) { 
			$('#deporte1').val(datosHC[35]);$('#deporte2').val(datosHC[36]); 
		});
		$('.inicio').load("files-serverside/cargar_inicios.php", function( response, status, xhr ) { 
			$('#inicio_adiccion1').val(datosHC[29]);$('#inicio_adiccion2').val(datosHC[30]);$('#inicio_adiccion3').val(datosHC[31]);
		});
		$('.frecuencia').load("files-serverside/cargar_frecuencias.php", function( response, status, xhr ) { 
			$('#frecuencia_deporte1').val(datosHC[37]);$('#frecuencia_deporte2').val(datosHC[38]); 
			$('#frecuencia_adiccion1').val(datosHC[32]);$('#frecuencia_adiccion2').val(datosHC[33]); 
			$('#frecuencia_adiccion3').val(datosHC[34]);$('#apnp_notas').val(datosHC[39]);
		});
		
		$('.recreacion').load("files-serverside/cargar_recreaciones.php", function( response, status, xhr ) { 
			$('#recreacion1').val(datosHC[40]);$('#recreacion2').val(datosHC[41]);$('#recreacion3').val(datosHC[42]); 
			$('#recreacion4').val(datosHC[43]);$('#recreacion5').val(datosHC[44]);$('#recreacion6').val(datosHC[45]);
		});
		
		$('#vivienda_hc').load("files-serverside/cargar_viviendas.php", function( response, status, xhr ) { 
			$('#vivienda_hc').val(datosHC[46]);$('#habitantes').val(datosHC[47]); 
		});
		
		$('.servicio_hc').load("files-serverside/cargar_servicios.php", function( response, status, xhr ) { 
			$('#servicios1_hc').val(datosHC[50]);$('#servicios2_hc').val(datosHC[51]);$('#servicios3_hc').val(datosHC[52]); 
			$('#servicios4_hc').val(datosHC[53]);
		});
		
		$('.matV').load("files-serverside/cargar_mat_vivienda.php", function( response, status, xhr ) { 
			$('#mat_vivienda1').val(datosHC[48]);$('#mat_vivienda2').val(datosHC[49]);
		});
		$('#aseo_personal').load("files-serverside/cargar_aseo_personal.php", function( response, status, xhr ) { 
			$('#aseo_personal').val(datosHC[54]); 
		});
		
		$('.vacuna').load("files-serverside/cargar_vacunas.php", function( response, status, xhr ) { 
			$('#vacunas1').val(datosHC[55]);$('#vacunas2').val(datosHC[56]);$('#vacunas3').val(datosHC[57]); 
			$('#observacionesVacunas').val(datosHC[58]);
		}); 
		$('#hrs_dormir').val(datosHC[59]);
		
		$('#alimentacion_hc').load("files-serverside/cargar_alimentaciones.php", function( response, status, xhr ) { 
			$('#alimentacion_hc').val(datosHC[60]); 
		});
		$('.mascota').load("files-serverside/cargar_mascotas.php", function( response, status, xhr ) { 
			$('#mascota1').val(datosHC[61]);$('#mascota2').val(datosHC[62]); 
		});
		$('#tipo_anticon').load("files-serverside/cargar_anticonceptivos.php", function( response, status, xhr ) { 
			$('#tipo_anticon').val(datosHC[82]); 
		});
			
		});
		
		var he1 = $('#referencia').height() - 100, wi1 = $('#referencia').width() * 0.96, 
		titulo1 = 'HISTORIA CLÍNICA. PACIENTE: '+datos[0];
		$('#dialog').dialog({
			autoOpen:true,modal:true,width:wi1,height:he1,title:titulo1,closeText:'', closeOnEscape: true,
			buttons: {
			 //'Actualizar': function() { }, 'Cancelar': function() { $('#dialog').dialog('close'); }
		    },
			open: function( event, ui ) { 
				$('#tabs_hc ul').removeClass('ui-widget-header');
				$('#updateHC').click(function(event) {
                    event.preventDefault();
					var datosHC = $('#formHistoriaClinica').serialize();
					$.post('files-serverside/actualizarHC.php',datosHC).done(function(data){ if(data==1){
						$('#texto-informar').text('La historia clínica se ha guardado correctamente.'); $('#dialog').dialog('close');
						$('#dialog-informar').dialog({autoOpen:true,modal:true,width:500,height:150,
						title:'HISTORIA CLÍNICA ACTUALIZADA',closeText:'',open:function(event, ui){$('#clickme').click(); 
						window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000); } });
					}else{alert(data);} });
                });
				$('#updateHC').button({
					icons:{
						primary:'ui-icon-refresh'
					}
				});
			}, 
			close: function( event, ui ) {
				$("#dialog").tabs("destroy"); $('#dialog').empty(); 
				if(control==1){window.setTimeout(function(){verHistoriaC(idP)},200);} 
			}
		});
	  });
	} });
}); }
function imc(a,b){ 
	var imc; imc=redondear((parseFloat(a)/(parseFloat(b)*parseFloat(b))),2); 
	if (imc>0 & imc<10000){ document.getElementById('imcSV').value=imc;
	}else{ document.getElementById('imcSV').value=''; } 
}

function checarEscala(id){ $(document).ready(function(e) {//if($('#'+id).val()>0){ }else{}
	var x = 0; $('.escala_g').each(function(index, element) { x = parseInt(x) + parseInt($(this).val()); });
	$('#total_escala_g').text(x); $('.'+id).text($('#'+id).val());
}); }

function signosVvacios(idP,control){ $(document).ready(function(e) {//si control es 1 al cerrar la ventana abre VerSignos
	$("#dialog").load("../consultas/htmls/signos_vitales.php #tabs_sv",function(response,status,xhr) {if( status == "success" ){ 
		$('#idUsuario_sv').val($('#idUser').val()); $('#formSignosVitales').validate({ignore: 'hidden'});
		$('#dialog input, #dialog select, #dialog textarea').addClass('campoITtab'); $("#dialog").tabs({active: 0});
		$('#dialog #tabs-2-1,#dialog #tabs-3-1, #dialog #tabs-4-1, #dialog #tabs-5-1').hide(); 
		$('.texto_tomasv').text('SIGNOS VITALES');
		//$('#notasSV').replaceWith('<span>'+datos3[12]+'</span>');
		var datosIDP = {idP:idP,idC:1}
	  $.post('files-serverside/datosSV.php',datosIDP).done(function(data){ 
	  	var datos = data.split(';*-'); $('#pacienteSV').val(datos[0]); $('#edadSV').val(datos[1]); $('#sexoSV').val(datos[2]);
		
		var he1 = $('#referencia').height() - $('.botones').height() - 100, wi1 = $('#referencia').width() * 0.96, 
		titulo1 = 'NUEVOS SIGNOS VITALES. PACIENTE: '+datos[0];
		$('#dialog').dialog({
			autoOpen: true, modal: true, width: wi1, height: he1, title: titulo1, closeText: '', closeOnEscape: false, 
			dialogClass: 'no-close', buttons: { }, 
			open: function(event, ui){
				$('#tabs_sv ul').removeClass('ui-widget-header'); $('#tomarNSV').hide(); $('#cancelNSV,#saveNSV').show();
				
				$('#cancelNSV').click(function(event) { event.preventDefault(); $('#dialog').dialog('close'); });
				$('#cancelNSV').button({ icons:{ primary:'ui-icon-cancel' } });
				
				$('#saveNSV').click(function(event) { event.preventDefault(); if($('#formSignosVitales').valid()){
					var datosSsv={
						idPx1:idP,idU:$('#idUsuario_sv').val(),peso:$('#pesoSV').val(),talla:$('#tallaSV').val(),
						cintura:$('#cinturaSV').val(),imc:$('#imcSV').val(),t:$('#tSV').val(),a:$('#aSV').val(),
						fr:$('#frSV').val(),fc:$('#fcSV').val(), temp:$('#tempSV').val(),notas:$('#notasSV').val(),
						oximetria:$('#oxiSV').val(), aocular:$('#abertura_ocular').val(),rverbal:$('#respuesta_verbal').val(),
						rmotriz:$('#respuesta_motriz').val()
					}
					var sumi = 0, valido = 1;
					$('.escala_g').each(function(index, element){ sumi=parseInt(sumi) + parseInt($(this).val()); });
					if(sumi==0){valido=1;}else{$('.escala_g').each(function(index,element){if($(this).val()==0){valido=0;}});}
					
					if(valido==1){
						$.post('files-serverside/guardarSV.php',datosSsv).done(function(data){ if(data==1){ $('#clickme').click();
							if(control==2){
								$('#pesoC').val($('#pesoSV').val());$('#tallaC').val($('#tallaSV').val());
								$('#imcC').val($('#imcSV').val());$('#cinturaC').val($('#cinturaSV').val());
								$('#tC').val($('#tSV').val());$('#aC').val($('#aSV').val());
								$('#frC').val($('#frSV').val());$('#fcC').val($('#fcSV').val());
								$('#tempC').val($('#tempSV').val()); $('#notasC').val($('#notasSV').val());
								$('#fechaSignosC').val($('#fechaHoy').val()); $('#oxiSV').val('hola');
							}
							$('#texto-informar').text('Los signos vitales se han guardado correctamente.');
							$('#dialog').dialog('close');
							$('#dialog-informar').dialog({
								title:'DATOS GUARDADOS',modal:true,autoOpen:true,closeText:'',width:600, height:200,
								closeOnEscape:true,dialogClass:'',
								open:function(event,ui){
									window.setTimeout(function(){$('#dialog-informar').dialog('close');},2500);
								}
							});
						} else{alert(data);} });
					}else{$('.escala_g').each(function(index, element){ $(this).addClass('error'); });}
				} });
				
				$('#saveNSV').button({ icons:{ primary:'ui-icon-disk' } });
			}, 
			close: function(event,ui){
				$("#dialog").tabs("destroy"); $('#dialog').empty(); 
				if(control==1){window.setTimeout(function(){verSignosV(idP)},200);} 
			}
		});
		$('#pesoSV').keyup(function(e){if($(this).val()>0 & $(this).val()<650){imc($(this).val(),document.getElementById('tallaSV').value);}});$('#tallaSV').keyup(function(e){if($(this).val()>0 & $(this).val()<3){imc(document.getElementById('pesoSV').value,$(this).val());}});
	  });
	} });
}); }

function cargarSV(idPa){$(document).ready(function(e) {
	$('#idUsuario_sv').val($('#idUser').val());
	graficasSV(idPa,3);
	var datosIDPa = {idP:idPa, idC:1}
	$.post('files-serverside/datosSV.php',datosIDPa).done(function(data){ 
		var datos3 = data.split(';*-'); $('#pacienteSV').val(datos3[0]);$('#edadSV').val(datos3[1]);$('#sexoSV').val(datos3[2]);
		$('#pesoSV').val(datos3[3]);$('#tallaSV').val(datos3[4]);$('#imcSV').val(datos3[5]);$('#cinturaSV').val(datos3[6]);
		$('#tSV').val(datos3[7]);$('#aSV').val(datos3[8]);
		$('#frSV').val(datos3[9]);$('#fcSV').val(datos3[10]);$('#tempSV').val(datos3[11]);$('#notasSV').val(datos3[12]);
		$('#tabs-2-1s').click(function(e) { //alert(9);
			$('#miIMC').text($('#imcSV').val()); $('#miMedidaCintura').text($('#cinturaSV').val());
			if( $('#miIMC').text() >= 18.5 & $('#miIMC').text() < 25 ){
				$('.normalIMC').addClass('formatoRangosIMC');
				$('#miRiesgoP').text('no está en riesgo latente'); //alert($('#sexoSV').val());
				if($('#campo_sx_sv span').text()=='FEMENINO'){
					if( $('#miMedidaCintura').text() < 80 ){ $('.imc_1_1').addClass('formatoRangosIMC');
					}else if( $('#miMedidaCintura').text() > 80 ){ $('.imc_1_2').addClass('formatoRangosIMC'); }
					else{$('.imc_1_1, .imc_1_2').removeClass('formatoRangosIMC');}
				}else if($('#campo_sx_sv span').text()=='MASCULINO')
				{
					if( $('#miMedidaCintura').text() < 90 ){ $('.imc_1_1').addClass('formatoRangosIMC');
					}else if( $('#miMedidaCintura').text() > 90 ){ $('.imc_1_2').addClass('formatoRangosIMC'); }
					else{$('.imc_1_1, .imc_1_2').removeClass('formatoRangosIMC');}
				}
			} 
			else if( $('#miIMC').text() >= 25 & $('#miIMC').text() < 30 ){ //alert($('#sexoSV').val());
				$('.sobrepesoIMC').addClass('formatoRangosIMC');
				$('#miRiesgoP').text('tiene riesgo moderado');
				if($('#campo_sx_sv span').text()=='FEMENINO'){
					if( $('#miMedidaCintura').text() < 80 ){ $('.imc_2_1').addClass('formatoRangosIMC');
					}else if( $('#miMedidaCintura').text() > 80 ){ $('.imc_2_2').addClass('formatoRangosIMC'); }
					else{$('.imc_2_1, .imc_2_2').removeClass('formatoRangosIMC');}
				}else if($('#campo_sx_sv span').text()=='MASCULINO')
				{
					if( $('#miMedidaCintura').text() < 90 ){ $('.imc_2_1').addClass('formatoRangosIMC');
					}else if( $('#miMedidaCintura').text() > 90 ){ $('.imc_2_2').addClass('formatoRangosIMC'); }
					else{$('.imc_2_1, .imc_2_2').removeClass('formatoRangosIMC');}
				}
			} 
			else if( $('#imcSV').val() >= 30 & $('#imcSV').val() < 35 ){
				$('.obesidad1IMC').addClass('formatoRangosIMC');
				$('#miRiesgoP').text('tiene riesgo alto');
				if($('#campo_sx_sv span').text()=='FEMENINO'){
					if( $('#miMedidaCintura').text() < 80 ){ $('.imc_3_1').addClass('formatoRangosIMC');
					}else if( $('#miMedidaCintura').text() > 80 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
					else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
				}else if($('#campo_sx_sv span').text()=='MASCULINO')
				{
					if( $('#miMedidaCintura').text() < 90 ){ $('.imc_3_1').addClass('formatoRangosIMC');
					}else if( $('#miMedidaCintura').text() > 90 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
					else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
				}
			} 
			else if( $('#imcSV').val() >= 35 & $('#imcSV').val() < 40 ){
				$('.obesidad2IMC').addClass('formatoRangosIMC');
				$('#miRiesgoP').text('tiene riesgo muy alto');
				if($('#campo_sx_sv span').text()=='FEMENINO'){
					if( $('#miMedidaCintura').text() < 80 ){ $('.imc_3_1').addClass('formatoRangosIMC');
					}else if( $('#miMedidaCintura').text() > 80 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
					else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
				}else if($('#campo_sx_sv span').text()=='MASCULINO')
				{
					if( $('#miMedidaCintura').text() < 90 ){ $('.imc_3_1').addClass('formatoRangosIMC');
					}else if( $('#miMedidaCintura').text() > 90 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
					else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
				}
			} 
			else if( $('#imcSV').val() >= 40 ){
				$('.obesidad3IMC').addClass('formatoRangosIMC');
				$('#miRiesgoP').text('tiene riesgo extremadamente alto');
				if($('#campo_sx_sv span').text()=='FEMENINO'){
					if( $('#miMedidaCintura').text() < 80 ){ $('.imc_4_1').addClass('formatoRangosIMC');
					}else if( $('#miMedidaCintura').text() > 80 ){ $('.imc_4_2').addClass('formatoRangosIMC'); }
					else{$('.imc_4_1, .imc_4_2').removeClass('formatoRangosIMC');}
				}else if($('#campo_sx_sv span').text()=='MASCULINO')
				{
					if( $('#miMedidaCintura').text() < 90 ){ $('.imc_4_1').addClass('formatoRangosIMC');
					}else if( $('#miMedidaCintura').text() > 90 ){ $('.imc_4_2').addClass('formatoRangosIMC'); }
					else{$('.imc_4_1, .imc_4_2').removeClass('formatoRangosIMC');}
				}
			} else{$('.sobrepesoIMC').removeClass('formatoRangosIMC'); }
		});
		$('#tabs-3-1s').click(function(e) {
			if( $('#imcSV').val() >= 18.5 & $('#imcSV').val() < 25 ){
				$('#recomendacionRN').show();
				$('#recomendacionSP, #recomendacionOB').hide();
				if($('#campo_sx_sv span').text()=='FEMENINO'){
					if( $('#miMedidaCintura').text() < 80 ){ $('#miRiesgoE').text('sin riesgo');
					}else if( $('#miMedidaCintura').text() > 80 ){ $('#miRiesgoE').text('con riesgo alto');
					} else{ }
				}else if($('#campo_sx_sv span').text()=='MASCULINO')
				{
					if( $('#miMedidaCintura').text() < 90 ){ $('#miRiesgoE').text('sin riesgo');
					}else if( $('#miMedidaCintura').text() > 90 ){ $('#miRiesgoE').text('con riesgo alto');
					} else{ }
				}
			} 
			else if( $('#imcSV').val() >= 25 & $('#imcSV').val() < 30 ){
				$('#recomendacionSP').show();
				$('#recomendacionRN, #recomendacionOB').hide();
				if($('#campo_sx_sv span').text()=='FEMENINO'){
					if( $('#miMedidaCintura').text() < 80 ){ $('#miRiesgoE').text('con riesgo moderado');
					}else if( $('#miMedidaCintura').text() > 80 ){ $('#miRiesgoE').text('con riesgo alto');
					} else{ }
				}else if($('#campo_sx_sv span').text()=='MASCULINO')
				{
					if( $('#miMedidaCintura').text() < 90 ){ $('#miRiesgoE').text('con riesgo moderado');
					}else if( $('#miMedidaCintura').text() > 90 ){ $('#miRiesgoE').text('con riesgo alto');
					} else{ }
				}
			} 
			else if( $('#imcSV').val() >= 30 & $('#imcSV').val() < 35 ){
				$('#recomendacionOB').show();
				$('#recomendacionRN, #recomendacionSP').hide();
				if($('#campo_sx_sv span').text()=='FEMENINO'){
					if( $('#miMedidaCintura').text() < 80 ){ $('#miRiesgoE').text('con alto a muy alto riesgo');
					}else if( $('#miMedidaCintura').text() > 80 ){ $('#miRiesgoE').text('con muy alto riesgo');
					} else{ }
				}else if($('#campo_sx_sv span').text()=='MASCULINO')
				{
					if( $('#miMedidaCintura').text() < 90 ){ $('#miRiesgoE').text('con alto a muy alto riesgo');
					}else if( $('#miMedidaCintura').text() > 90 ){ $('#miRiesgoE').text('con muy alto riesgo');
					} else{ }
				}
			} 
			else if( $('#imcSV').val() >= 35 & $('#imcSV').val() < 40 ){
				$('#recomendacionOB').show();
				$('#recomendacionRN, #recomendacionSP').hide();
				if($('#campo_sx_sv span').text()=='FEMENINO'){
					if( $('#miMedidaCintura').text() < 80 ){ $('#miRiesgoE').text('con alto a muy alto riesgo');
					}else if( $('#miMedidaCintura').text() > 80 ){ $('#miRiesgoE').text('con muy alto riesgo');
					} else{ }
				}else if($('#campo_sx_sv span').text()=='MASCULINO')
				{
					if( $('#miMedidaCintura').text() < 90 ){ $('#miRiesgoE').text('con alto a muy alto riesgo');
					}else if( $('#miMedidaCintura').text() > 90 ){ $('#miRiesgoE').text('con muy alto riesgo');
					} else{ }
				}
			} 
			else if( $('#imcSV').val() >= 40 ){
				$('#recomendacionOB').show();
				$('#recomendacionRN, #recomendacionSP').hide();
				if($('#campo_sx_sv span').text()=='FEMENINO'){
					if( $('#miMedidaCintura').text() < 80 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto');
					}else if( $('#miMedidaCintura').text() > 80 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto');
					} else{ }
				}else if($('#campo_sx_sv span').text()=='MASCULINO')
				{
					if( $('#miMedidaCintura').text() < 90 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto');
					}else if( $('#miMedidaCintura').text() > 90 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto');
					} else{ }
				}
			} else{ }
		});
		
		$('#tomarNSV').show(); $('#cancelNSV,#saveNSV').hide();

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
			"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
			"aoColumns":[
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }
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

function verSignosV(idPa){
	$("#dialog").load("../consultas/htmls/signos_vitales.php #tabs_sv",function(response, status, xhr){if( status == "success" ){ 
		$('#idUsuario_sv').val($('#idUser').val()); $("#dialog").tabs({active: 0});
		$('#dialog input, #dialog select, #dialog textarea').addClass('campoITtab'); 
		$("#dialog div:nth-child(1)").css('border','1px inset white');
		$('#campo_paciente_sv').css('width','1%','white-space','nowrap');
		$('#campo_sx_sv').parent().append('<td width="90%"></td>');
		
		graficasSV(idPa,0);
		
		var datosIDPa = {idP:idPa, idC:1}
		$.post('files-serverside/datosSV.php',datosIDPa).done(function(data){ 
			var datos3 = data.split(';*-'); 
			$('#pacienteSV').replaceWith('<span>'+datos3[0]+'</span>');$('#edadSV').replaceWith('<span>'+datos3[1]+'</span>');
			$('#sexoSV').replaceWith('<span align="left">'+datos3[2]+'</span>');$('#frSV').val(datos3[9]);
			$('#pesoSV').val(datos3[3]);$('#tallaSV').val(datos3[4]);$('#imcSV').val(datos3[5]);$('#cinturaSV').val(datos3[6]);
			$('#tSV').val(datos3[7]);$('#aSV').val(datos3[8]); $('#fcSV').val(datos3[10]);$('#tempSV').val(datos3[11]);
			$('#notasSV').replaceWith('<span>'+datos3[12]+'</span>'); $('#texto_notas_sv').text('NOTAS: ');
			$('#oxiSV').val(datos3[17]); $('#abertura_ocular').val(datos3[18]); $('#respuesta_verbal').val(datos3[19]); 
			$('#respuesta_motriz').val(datos3[20]); $('#ocular_val').text(datos3[18]); $('#verbal_val').text(datos3[19]);
			$('#motriz_val').text(datos3[20]); 
			$('#total_escala_g').text(parseInt(datos3[18])+parseInt(datos3[19])+parseInt(datos3[20]));
			
			var he1 = $('#referencia').height() - $('.botones').height() - 100, wi1 = $('#referencia').width() * 0.96, 
				titulo = 'SIGNOS VITALES. FECHA: '+datos3[13]+' PACIENTE: '+datos3[0];
			
			$('#dialog').dialog({
				autoOpen:true,modal:true,width:wi1,height:he1,title:titulo,closeText:'',closeOnEscape: true,dialogClass: '',
				buttons:{ /*'Nuevos': function() { }, 'Cerrar': function() { $('#dialog').dialog('close'); } */ }, 
				open:function(event,ui){ //Para calcular los riesgos y recomendaciones
					$('#tabla_sv input').prop('readonly','readonly');
					$('.escala_g').prop('disabled','disabled');
					$('#tabs-2-1').click(function(e) {
						$('#miIMC').text($('#imcSV').val()); $('#miMedidaCintura').text($('#cinturaSV').val());
                        if( $('#miIMC').text() >= 18.5 & $('#miIMC').text() < 25 ){
							$('.normalIMC').addClass('formatoRangosIMC');
							$('#miRiesgoP').text('no está en riesgo latente');
							if($('#campo_sx_sv span').text()=='FEMENINO'){
								if( $('#miMedidaCintura').text() < 80 ){$('.imc_1_1').addClass('formatoRangosIMC');
								}else if( $('#miMedidaCintura').text() > 80 ){ $('.imc_1_2').addClass('formatoRangosIMC'); }
								else{$('.imc_1_1, .imc_1_2').removeClass('formatoRangosIMC');}
							}else if($('#campo_sx_sv span').text()=='MASCULINO')
							{
								if( $('#miMedidaCintura').text() < 90 ){ $('.imc_1_1').addClass('formatoRangosIMC');
								}else if( $('#miMedidaCintura').text() > 90 ){ $('.imc_1_2').addClass('formatoRangosIMC'); }
								else{$('.imc_1_1, .imc_1_2').removeClass('formatoRangosIMC');}
							}
						} 
						else if( $('#miIMC').text() >= 25 & $('#miIMC').text() < 30 ){
							$('.sobrepesoIMC').addClass('formatoRangosIMC');
							$('#miRiesgoP').text('tiene riesgo moderado');
							if($('#campo_sx_sv span').text()=='FEMENINO'){
								if( $('#miMedidaCintura').text() < 80 ){ $('.imc_2_1').addClass('formatoRangosIMC');
								}else if( $('#miMedidaCintura').text() > 80 ){ $('.imc_2_2').addClass('formatoRangosIMC'); }
								else{$('.imc_2_1, .imc_2_2').removeClass('formatoRangosIMC');}
							}else if($('#campo_sx_sv span').text()=='MASCULINO')
							{
								if( $('#miMedidaCintura').text() < 90 ){ $('.imc_2_1').addClass('formatoRangosIMC');
								}else if( $('#miMedidaCintura').text() > 90 ){ $('.imc_2_2').addClass('formatoRangosIMC'); }
								else{$('.imc_2_1, .imc_2_2').removeClass('formatoRangosIMC');}
							}
						} 
						else if( $('#miIMC').text() >= 30 & $('#miIMC').text() < 35 ){
							$('.obesidad1IMC').addClass('formatoRangosIMC');
							$('#miRiesgoP').text('tiene riesgo alto');
							if($('#campo_sx_sv span').text()=='FEMENINO'){
								if( $('#miMedidaCintura').text() < 80 ){ $('.imc_3_1').addClass('formatoRangosIMC');
								}else if( $('#miMedidaCintura').text() > 80 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
								else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
							}else if($('#campo_sx_sv span').text()=='MASCULINO')
							{
								if( $('#miMedidaCintura').text() < 90 ){ $('.imc_3_1').addClass('formatoRangosIMC');
								}else if( $('#miMedidaCintura').text() > 90 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
								else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
							}
						} 
						else if( $('#miIMC').text() >= 35 & $('#miIMC').text() < 40 ){
							$('.obesidad2IMC').addClass('formatoRangosIMC');
							$('#miRiesgoP').text('tiene riesgo muy alto');
							if($('#campo_sx_sv span').text()=='FEMENINO'){
								if( $('#miMedidaCintura').text() < 80 ){ $('.imc_3_1').addClass('formatoRangosIMC');
								}else if( $('#miMedidaCintura').text() > 80 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
								else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
							}else if($('#campo_sx_sv span').text()=='MASCULINO')
							{
								if( $('#miMedidaCintura').text() < 90 ){ $('.imc_3_1').addClass('formatoRangosIMC');
								}else if( $('#miMedidaCintura').text() > 90 ){ $('.imc_3_2').addClass('formatoRangosIMC'); }
								else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
							}
						} 
						else if( $('#miIMC').text() >= 40 ){
							$('.obesidad3IMC').addClass('formatoRangosIMC');
							$('#miRiesgoP').text('tiene riesgo extremadamente alto');
							if($('#campo_sx_sv span').text()=='FEMENINO'){
								if( $('#miMedidaCintura').text() < 80 ){ $('.imc_4_1').addClass('formatoRangosIMC');
								}else if( $('#miMedidaCintura').text() > 80 ){ $('.imc_4_2').addClass('formatoRangosIMC'); }
								else{$('.imc_4_1, .imc_4_2').removeClass('formatoRangosIMC');}
							}else if($('#campo_sx_sv span').text()=='MASCULINO')
							{
								if( $('#miMedidaCintura').text() < 90 ){ $('.imc_4_1').addClass('formatoRangosIMC');
								}else if( $('#miMedidaCintura').text() > 90 ){ $('.imc_4_2').addClass('formatoRangosIMC'); }
								else{$('.imc_4_1, .imc_4_2').removeClass('formatoRangosIMC');}
							}
						} else{$('.sobrepesoIMC').removeClass('formatoRangosIMC'); }
                    });
					$('#tabs-3-1').click(function(e) {
                        if( $('#miIMC').text() >= 18.5 & $('#miIMC').text() < 25 ){
							$('#recomendacionRN').show();
							$('#recomendacionSP, #recomendacionOB').hide();
							if($('#campo_sx_sv span').text()=='FEMENINO'){
								if( $('#miMedidaCintura').text() < 80 ){ $('#miRiesgoE').text('sin riesgo');
								}else if( $('#miMedidaCintura').text() > 80 ){ $('#miRiesgoE').text('con riesgo alto');
								} else{ }
							}else if($('#campo_sx_sv span').text()=='MASCULINO')
							{
								if( $('#miMedidaCintura').text() < 90 ){ $('#miRiesgoE').text('sin riesgo');
								}else if( $('#miMedidaCintura').text() > 90 ){ $('#miRiesgoE').text('con riesgo alto');
								} else{ }
							}
						} 
						else if( $('#miIMC').text() >= 25 & $('#miIMC').text() < 30 ){
							$('#recomendacionSP').show();
							$('#recomendacionRN, #recomendacionOB').hide();
							if($('#campo_sx_sv span').text()=='FEMENINO'){
								if( $('#miMedidaCintura').text() < 80 ){ $('#miRiesgoE').text('con riesgo moderado');
								}else if( $('#miMedidaCintura').text() > 80 ){ $('#miRiesgoE').text('con riesgo alto');
								} else{ }
							}else if($('#campo_sx_sv span').text()=='MASCULINO')
							{
								if( $('#miMedidaCintura').text() < 90 ){ $('#miRiesgoE').text('con riesgo moderado');
								}else if( $('#miMedidaCintura').text() > 90 ){ $('#miRiesgoE').text('con riesgo alto');
								} else{ }
							}
						} 
						else if( $('#miIMC').text() >= 30 & $('#miIMC').text() < 35 ){
							$('#recomendacionOB').show();
							$('#recomendacionRN, #recomendacionSP').hide();
							if($('#campo_sx_sv span').text()=='FEMENINO'){
								if( $('#miMedidaCintura').text() < 80 ){ $('#miRiesgoE').text('con alto a muy alto riesgo');
								}else if( $('#miMedidaCintura').text() > 80 ){ $('#miRiesgoE').text('con muy alto riesgo');
								} else{ }
							}else if($('#campo_sx_sv span').text()=='MASCULINO')
							{
								if( $('#miMedidaCintura').text() < 90 ){ $('#miRiesgoE').text('con alto a muy alto riesgo');
								}else if( $('#miMedidaCintura').text() > 90 ){ $('#miRiesgoE').text('con muy alto riesgo');
								} else{ }
							}
						} 
						else if( $('#miIMC').text() >= 35 & $('#miIMC').text() < 40 ){
							$('#recomendacionOB').show();
							$('#recomendacionRN, #recomendacionSP').hide();
							if($('#campo_sx_sv span').text()=='FEMENINO'){
								if( $('#miMedidaCintura').text() < 80 ){ $('#miRiesgoE').text('con alto a muy alto riesgo');
								}else if( $('#miMedidaCintura').text() > 80 ){ $('#miRiesgoE').text('con muy alto riesgo');
								} else{ }
							}else if($('#campo_sx_sv span').text()=='MASCULINO')
							{
								if( $('#miMedidaCintura').text() < 90 ){ $('#miRiesgoE').text('con alto a muy alto riesgo');
								}else if( $('#miMedidaCintura').text() > 90 ){ $('#miRiesgoE').text('con muy alto riesgo');
								} else{ }
							}
						} 
						else if( $('#miIMC').text() >= 40 ){
							$('#recomendacionOB').show();
							$('#recomendacionRN, #recomendacionSP').hide();
							if($('#campo_sx_sv span').text()=='FEMENINO'){
								if($('#miMedidaCintura').text()<80){ $('#miRiesgoE').text('con  riesgo extremadamente alto');
								}else if($('#miMedidaCintura').text()>80){$('#miRiesgoE').text('con  riesgo extremadamente alto');
								} else{ }
							}else if($('#campo_sx_sv span').text()=='MASCULINO')
							{
								if( $('#miMedidaCintura').text() < 90 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto');
								}else if($('#miMedidaCintura').text()>90){$('#miRiesgoE').text('con  riesgo extremadamente alto');
								} else{ }
							}
						} else{ }
                    });
					
					$('#tomarNSV').show(); $('#cancelNSV,#saveNSV').hide();

					$('#tomarNSV').click(function(event) { 
						event.preventDefault(); $('#dialog').dialog('close'); 
						window.setTimeout(function(){signosVvacios(idPa,1)},200); 
					});
					$('#tomarNSV').button({ icons:{ primary:'ui-icon-document' } });
					$('#tabs_sv ul').removeClass('ui-widget-header');
				}, 
				close: function( event, ui ) {;$("#dialog").tabs("destroy");$('#dialog').empty(); }
			});
		});
		$('#tabs-4-1').click(function(e) {
            var oTableSV;
			oTableSV = $('#dataTableSV').dataTable({
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { $('.DataTables_sort_icon').remove(); },
				"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#dialog').height()-100, "bAutoWidth": true,
				"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
				"aoColumns":[
					{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
					{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
					{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }
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
	} });//Fin fe load signos vitales
} //Fin signos vitales dialog

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
			$('.miCanva').css('width',($('#tabs_c').width()/2)-50);
			$('.miCanva').css('height',($('#tabs_c').height()/2)-90);
		},200);
	}
	
		var datosCHa = {idP:idPa}
		$.post('files-serverside/datosCharts.php',datosCHa).done(function(data){ var datosCH1 = data.split(';*');  var ctx = $("#myChartIMC").get(0).getContext("2d"); //alert(datosCH1[1]); // This will get the first returned node in the jQuery collection.
			var dataCH = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", strokeColor: "rgba(255,102,51,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
					{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",strokeColor: "rgba(53,148,182,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
					{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",strokeColor: "rgba(53,148,182,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
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
		$.post('files-serverside/datosChartsTA.php',datosCHa).done(function(data){ var datosCH2 = data.split(';*');  var ctxTA = $("#myChartTA").get(0).getContext("2d"); //alert(datosCH2[3]); // This will get the first returned node in the jQuery collection.
			var dataCH2 = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", strokeColor: "rgba(255,102,51,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
					{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",strokeColor: "rgba(53,148,182,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
					{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",strokeColor: "rgba(53,148,182,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
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
		$.post('files-serverside/datosChartsFR.php',datosCHa).done(function(data){ var datosCH3 = data.split(';*');  var ctxFR = $("#myChartFR").get(0).getContext("2d"); //alert(datosCH1[1]); // This will get the first returned node in the jQuery collection.
			var dataCH3 = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", strokeColor: "rgba(255,102,51,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
					{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",strokeColor: "rgba(53,148,182,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
					{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",strokeColor: "rgba(53,148,182,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
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
		$.post('files-serverside/datosChartsFC.php',datosCHa).done(function(data){ var datosCH4 = data.split(';*');  var ctxFC = $("#myChartFC").get(0).getContext("2d"); //alert(datosCH1[1]); // This will get the first returned node in the jQuery collection.
			var dataCH4 = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", strokeColor: "rgba(255,102,51,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
					{label:"MÍNIMO",fillColor:"rgba(0,0,0,0)",strokeColor: "rgba(53,148,182,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
					{label:"MÁXIMO",fillColor:"rgba(255,255,255,0)",strokeColor: "rgba(53,148,182,1)",pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
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

function myFunction(){ setTimeout(function(){ $(document).ready(function(e) {
	var allBotonesIcono = $('.botonaso'); allBotonesIcono.css('width','25px').css('height','25px');
	
	$('.icono_proceso').button({ icons: { primary: "ui-icon-gear"}, text: false });
	$('.icono_realizado').button({ icons: { primary: "ui-icon-gear"}, text: false });
	$('.icono_capturado').button({ icons: { primary: "ui-icon-document"}, text: false });
	$('.icono_interpretado').button({ icons: { primary: "ui-icon-check"}, text: false });
	$('.icono_imprimir').button({ icons: { primary: "ui-icon-print"}, text: false });
	$('.miPDF').button({ icons: { primary: "ui-icon-document"}, text: false });
	$('.updatePDF').button({ icons: { primary: "ui-icon-refresh"}, text: false });
	$('.icono_vacio').button({ icons: { primary: "ui-icon-help"}, text: false });
	$('.icono_atender').button({ icons: { primary: "ui-icon-circle-check"}, text: false });
	$('.icono_verInfo').button({ icons: { primary: "ui-icon-info"}, text: false });
	
	$('.botonaso').click(function(event) { event.preventDefault(); });
}); },9); }//fin myFunction
</script>
