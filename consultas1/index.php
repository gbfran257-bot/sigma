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
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../imagenes/empresa/favicon.ico">
<meta charset="utf-8">

<?php if(isset($_GET['op'])){ ?>
<title>SERVICIOS MÉDICOS</title>
<?php }else{ ?>
<title>CONSULTAS MÉDICAS</title>
<?php } ?>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link href="../jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">
<link href="../DataTables-1.10.5/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet">
<link href="../Editor-PHP-1.4.0/css/dataTables.editor.css" rel="stylesheet">

<script src="../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.5/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="../Editor-PHP-1.4.0/js/dataTables.editor.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/retardo.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../jQuery-TE_v.1.4.0/uncompressed/jquery-te-1.4.0.js" charset="utf-8"></script>
<script src="../chart_1.0.2/Chart.min.js" type="text/javascript"></script>
<script src="../funciones/js/jquery.media.js" type="text/javascript"></script> 
<script src="../funciones/js/jquery.fileDownload.js" type="text/javascript"></script>

<script>
$( document ).tooltip({ extraClass: "arrow", position: { my: "center bottom-10", at: "center top" } });

$(document).ready(function(e) {
	$('#form-captura').validate({ rules:{ diagnostico:{ required:true } }, messages:{ diagnostico:{ required:'Debe ingresar el diagnóstico' } } });
	
	<?php if(isset($_GET['op'])){ ?>
	$('#verMenu').click(function(e){window.location='../menu.php?menu=ms';});
	<?php }else{ ?>
	$('#verMenu').click(function(e){window.location='../menu.php?menu=mc';});
	<?php } ?>
	
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
	//Refrescamos la sesión para que no caduque, aunque no se refresque la ventana
	setInterval(function(){$.post('../remote_files/refresh_session.php'); },500000);
	
	var tam = $('#referencia').height() - 145;
	
	oTable = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {  
			myFunction(); miConta(); $('span.DataTables_sort_icon').remove();
		},
		"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, 
		"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [
			{ "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }, { "bVisible": false }, 
			{ "bVisible": false }, { "bSortable": false }, { "bSortable": false }, { "bVisible": false }, { "bSortable": false }
		],
		"iDisplayLength": 1000, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info">',
		<?php if(isset($_GET['op'])){ ?>
		"sAjaxSource": "datatable-serverside/consultas_s.php?idU="+$('#idUser').val(),
		<?php }else{ ?>
		"sAjaxSource": "datatable-serverside/consultas.php?idU="+$('#idUser').val(),
		<?php } ?>
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
		"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
		"sInfo": "MOSTRADAS: _END_", "sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "&nbsp;TOTAL DE CONSULTAS: _MAX_", 
		"sSearch": "BUSCAR" }
	});//fin data table
	
	$('#clickme').click(function(e) { oTable.fnDraw(); myFunction(); });
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { oTable.fnFilter( this.value, $("tfoot input").index(this) ); } );
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus(function(){if( this.className == "search_init" ){this.className=""; this.value="" ;myFunction(); } } );
     
    $("tfoot input").blur( function (i) { if ( this.value == "" ) { this.className = "search_init"; this.value = asInitVals[$("tfoot input").index(this)];myFunction(); } } );
		
	$('#radio1').click(function(e) { $('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); });
	
	$('#radio2').click(function(e) { $('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); });
	$( "#fechaDe" ).datepicker({ defaultDate: "-1", maxDate: +0, onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); }, "onSelect": function(date) { min = date+' 00:00:00'; oTable.fnDraw(); } }).css('max-width','100px');
	$( "#fechaA" ).datepicker({ defaultDate: "+0", maxDate: +0, onClose: function( selectedDate ) { $( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); }, "onSelect": function(date) { max = date+' 23:59:59'; oTable.fnDraw(); } }).css('max-width','100px');
			
});
function miConta(){ $(document).ready(function(e) { //window.setTimeout(function(){
		$('.miConta').each(function(index, element) { var idX = '#'+$(this).prop('id'); var miTime = {time : $(this).prop('lang')}
		<?php if(isset($_GET['op'])){ ?>
		$.post('files-serverside/contador_s.php',miTime).done(function(data){ });
		<?php }else{ ?>
		$.post('files-serverside/contador.php',miTime).done(function(data){ /*$(idX).text(data); $('#clickme').click();*/ });
		<?php } ?>
		
	});//miConta();
//},240000); 
}); } //Cambia el contador cada 240 seg
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
	$( '#rangosFechas' ).buttonset(); $('.rad').css('font-size','0.8em'); 
});
</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="fechaHoy" type="hidden" id="fechaHoy" value="<?php echo date("d/m/Y"); ?>">
<input name="idPacs" type="hidden" id="idPacs" value="">
<input name="nombreTempPdf" id="nombreTempPdf" type="hidden" value="">
<input name="id_vc_ini" id="id_vc_ini" type="hidden" value="">
<input name="usuario_ini" id="usuario_ini" type="hidden" value="<?php echo $row_usuario['usuario_u']; ?>">
<input name="campoUrl" id="campoUrl" type="hidden" value="">

<div id="header" class="header">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
      	<?php if(isset($_GET['op'])){ ?>
		<td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_iconoServicios.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">SERVICIOS MÉDICOS</span></td>
		<?php }else{ ?>
		<td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_iconoResultados.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">CONSULTAS MÉDICAS</span></td>
		<?php } ?>
        
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

<div class="contenido" id="contenido" align="center" style="margin-top:39px;">
  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTable" class="tablilla">
    <thead id="cabecera_tBusquedaP">
      <tr class="titulos_dataceldas">
        <th id="clickme" width="40px">REFERENCIA</th>
        <th>PACIENTE</th>
        <th>PERSONAL MÉDICOMÉDICO</th>
        <?php if(isset($_GET['op'])){ ?>
		<th width="120px" nowrap>CONCEPTO</th>
		<?php }else{ ?>
		<th width="120px" nowrap>ESPECIALIDAD</th>
		<?php } ?>
        <th nowrap width="60px">S-V</th>
		<th nowrap width="40px">H-C</th>
        <th width="10px">ESTATUS</th>
		<th width="10px">TIEMPO</th>
        <th width="10px">ATENDER</th>
        <th width="10px">SUCURSAL</th>
      </tr>
    </thead>
    <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
    <tr>
        <td><input name="sPaciente" id="sPaciente" type="text" value="-Referencia-" class="search_init" style="width:90%;" /></td>
        <td><input name="sPaciente1" id="sPaciente1" type="text" value="-Paciente-" class="search_init" style="width:90%;" /></td>
        <td><input name="sPaciente2" id="sPaciente2" type="text" value="-Personal médico-" class="search_init" style="width:90%;" /></td>
        <?php if(isset($_GET['op'])){ ?>
		<td><input name="sPaciente3" id="sPaciente3" type="text" value="-Concepto-" class="search_init" style="width:90%;" /></td>
		<?php }else{ ?>
		<td><input name="sPaci3" id="sPaci3" type="text" value="-Especialidad-" class="search_init" style="width:90%;" /></td>
		<?php } ?>
        <td><!--<input name="sPaciente4" id="sPaciente4" type="hidden" value=""> --></td>
        <td><!--<input name="sPaciente5" id="sPaciente5" type="hidden" value=""> --></td>
        <td>
            <input name="sPaciente4" id="sPaciente4" type="hidden" value="">
            <input name="sPaciente5" id="sPaciente5" type="hidden" value="">
            <input name="sPaciente6" id="sPaciente6" type="text" value="-Estatus-" class="search_init" style="width:90%;" />
        </td>
        <td><input name="sPaciente7" id="sPaciente7" type="hidden" value=""></td>
        <td><input name="sPaciente8" id="sPaciente8" type="hidden" value=""></td>
        <td>
        	<input name="sPaciente10" id="sPaciente10" type="hidden" value="">
        	<input name="sPaciente9" id="sPaciente9" type="text" value="-Sucursal-" class="search_init" style="width:90%;" />
        </td>
    </tr>
    </tfoot>
  </table>
  
<div id="divRangoFechas" style="text-align:left;">
  <table width="100%" border="0" cellpadding="4" cellspacing="0" style="color:black; float:left;">
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
<div id="dialog-informar1" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" valign="middle" height="100%"><span id="texto-informar1"></span></td></tr></table></div>
<div id="dialog-receta" style="display:none;"> </div>
<div id="dialog-graficas" style="display:none;"> </div>
<div id="dialog-nuevo" style="display:none;"> </div>

<div id="dialog-rDX" style="display:none;"> </div>
<div id="dialog-graafis" style="display:none;"> </div>
<div id="dialog-historiales" style="display:none;"> </div>

<div id="dialog-img" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td id="miImg" align="center" valign="middle"></td> </tr>
</table>
</div>

<div id="dialog-hospitalizar" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr> <td align="justify">¿Esta seguro de mandar a hospitalizar al paciente <span class="pacienteHospi"></span>?</td> </tr>
  <tr> <td align="left">
  	<form action="" method="post" name="formHospi" id="formHospi" target="_self">
    	Confirmar <input name="confirmarHospi" type="checkbox" value="" id="confirmarHospi">
    </form>
  </td> </tr>
  <tr> <td align="center" style="font-size:0.7em; color:red;">
  	<span style="display:none;" id="errorHospi">Debe confirmar la instrucción.</span>
  </td> </tr>
</table>
</div>

<div id="dialog-confirmacion" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td id="textoConfirma">¡El estudio se ha transferido satisfactoriamente!</td> </tr>
</table>
</div>

<div id="dialog-nivel1" class="dialogos"></div> 
<div id="dialog-nivel2" class="dialogos"></div>
<div id="dialog-nivel3" class="dialogos"></div>
<div id="dialog-auxiliar" class="dialogos"></div>

</body>
</html>

<?php mysql_free_result($usuario); ?>

<script>
function receta(noAleatorio){ $(document).ready(function(e) {
	$("#dialog-receta").load("htmls/receta.php #receta",function(response, status, xhr){ var datosR = {noAleatorio:noAleatorio } 
		$.post('files-serverside/datosReceta.php',datosR).done(function(data){ var datosR = data.split(';*-');//alert(datosR[18]);
			$('#pacienteR').text(datosR[0]);$('#edadR').text(datosR[1]);$('#sexoR').text(datosR[2]);$('#pesoR').text(datosR[3]);$('#tallaR').text(datosR[4]);$('#imcR').text(datosR[5]);$('#cinturaR').text(datosR[6]);$('#fechaR').html(datosR[18]);
			$('#tempR').text(datosR[7]);$('#tR').text(datosR[8]);$('#aR').text(datosR[9]);$('#fcR').text(datosR[10]);$('#frR').text(datosR[11]);$('#notaR').text(datosR[12]);$('#sexoDrR').text(datosR[13]); $('#especialidadR').text(datosR[17]);
			$('#medicoR').text(datosR[14]);$('#cpR').text(datosR[15]);$('#contenedorDTMr').html(datosR[16]);
			window.setTimeout(function(){$('#dialog-receta').show().printElement().hide();},200);
		});	
	}); 
}); }
function finalizarConsulta(noAleatorio){ $(document).ready(function(e) {
	var datosFC = {noAleatorio:noAleatorio} //para guardar es necesario que ponga una nota de evolución.
	if($('#tabs-3 .jqte_editor').html()!=''){
		$('#texto-informar').text('¿Está seguro de que desea finalizar la consulta?');
		$('#dialog-informar').dialog({
			autoOpen:true,modal:true,width:600,height:200,title:'FINALIZAR LA CONSULTA',closeText:'',closeOnEscape:false,
			dialogClass:'no-close',
			open:function( event, ui ){ },
			buttons:{ 
				'Si': function(){
					var datosGC = {
						noAleatorio:noAleatorio, idU:$('#idUser').val(),observacionesC:$('#observacionesC').val(),
						notaDictamen:$('#tabs-3 .jqte_editor').html(),notaReceta:$('#notaMedicamentosC').val(), 
						idP:$('#idPaciente_c').val(), recetaR:$('#tabs-7 .jqte_editor').html(), 
						indiF:$('#tabs-4 .jqte_editor').html()
					} 
					$.post('files-serverside/finalizarConsulta.php',datosGC).done(function(data){ if(data == 1){
						$('#texto-informar1').text('La consulta se ha finalizado satisfactoriamente.');
						$('#dialog-informar1').dialog({
							autoOpen: true, modal: true, width: 600, height:150, title: 'CONSULTA FINALIZADA', closeText: '', buttons:{},closeOnEscape:false, dialogClass:'no-close',
							open:function( event, ui ){ 
								$('#clickme').click();
								$('#imprimirNotaE').show();
								$('#imprimirRecetaF').show();
								$('#imprimirRecetaT').show();
								$('#salvarConsulta, #finalizarConsulta, #hospitalizarP').hide();$('#celdaVideo').hide();
								$('#dialog-informar').dialog('close');
								window.setTimeout(function(){$('#dialog-informar1').dialog('close');},2000);
							},
							close:function( event, ui ){ window.location.reload(); }
						});
					}else{alert(data);} });
					$('.miMedi').each(function(index, element) { //alert($(this).prop('lang'));
						var datoM = {idM:$(this).prop('lang'),indiM:$(this).val()}
						$.post('files-serverside/guardarIndiccionesM.php',datoM).done(function(data){ });
					});
				},
				'No': function(){$('#dialog-informar').dialog('close');}
			}
		});
	}else{
		$('#texto-informar').text('Debe ingresar la nota de evolución para poder finalizar la consulta.');
		$('#dialog-informar').dialog({
			autoOpen: true, modal: true, width: 600, height:150, title: 'ERROR', closeText: '',
			open:function( event, ui ){ 
				$('#clickme').click();
				$('#imprimirNotaE').show();
				$('#imprimirRecetaF').show();
				$('#imprimirRecetaT').show();
				window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000);
			},
			buttons:{ }
		});	
	} 
});}
function salvarConsulta(noAleatorio){ $(document).ready(function(e) { //alert($('#tabs-4 .jqte_editor').html());
	var datosFC = {noAleatorio:noAleatorio}
	//para guardar es necesario que ponga una nota de evolución.
	if($('#tabs-3 .jqte_editor').html()!=''){
		var datosGC = {
			noAleatorio:noAleatorio, idU:$('#idUser').val(),observacionesC:$('#observacionesC').val(),
			notaDictamen:$('#tabs-3 .jqte_editor').html(),notaReceta:$('#notaMedicamentosC').val(), 
			idP:$('#idPaciente_c').val(), recetaR:$('#tabs-7 .jqte_editor').html(), indiF:$('#tabs-4 .jqte_editor').html()
		} 
		$.post('files-serverside/salvarConsulta.php',datosGC).done(function(data){ if(data == 1){
			$('#texto-informar').text('Los datos de la consulta se han guardado satisfactoriamente.');
			$('#dialog-informar').dialog({
				autoOpen: true, modal: true, width: 600, height:150, title: 'DATOS GUARDADOS', closeText: '', buttons:{},
				open:function( event, ui ){ 
					$('#clickme').click();
					$('#imprimirNotaE').hide();
					$('#imprimirRecetaF').hide();
					$('#imprimirRecetaT').hide();
					window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000);
				}
			});
		}else{alert(data);} });
		$('.miMedi').each(function(index, element) {
            var datoM = {idM:$(this).prop('lang'),indiM:$(this).val()}
			$.post('files-serverside/guardarIndiccionesM.php',datoM).done(function(data){ });
        });
	}else{
		$('#texto-informar').text('Debe ingresar la nota de evolución para poder guardar la consulta.');
		$('#dialog-informar').dialog({
			autoOpen: true, modal: true, width: 600, height:150, title: 'ERROR', closeText: '',
			open:function( event, ui ){ 
				$('#clickme').click();
				$('#imprimirNotaE').show();
				$('#imprimirRecetaF').show();
				$('#imprimirRecetaT').show();
				window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000);
			},
			buttons:{ }
		});	
	} 
});}
function borrarDX(idDX){ $(document).ready(function(e) { var datosBDX = {idDX:idDX}
	$.post('files-serverside/eliminarDX.php',datosBDX).done(function( data ) { if (data==1){ $('#clickmeDXS, #clickmeDX').click(); } else{alert(data);} });
});}
function borrarMed(idMEDC){ $(document).ready(function(e) { var datosBMEDC = {idMEDC:idMEDC}
	$.post('files-serverside/eliminarMed.php',datosBMEDC).done(function( data ) { if (data==1){ $('#clickmeMS, #clickmeMedi').click(); } else{alert(data);} });
});}
function checarHayDX(noAleatorio){ $(document).ready(function(e) { var datosChecaDX = {noAleatorio:noAleatorio}
	$.post('files-serverside/checarHayDX.php',datosChecaDX).done(function( data ) { if(data >0){$('#errorSeleccionDX').hide();  $('#dialog-buscar').dialog('close'); }else{ $('#errorSeleccionDX').hide().show('shake'); } }); 
});}
function checarHayMedi(noAleatorio){ $(document).ready(function(e) { var datosChecaMedi = {noAleatorio:noAleatorio}
	$.post('files-serverside/checarHayMedi.php',datosChecaMedi).done(function( data ) { if(data >0){$('#errorSeleccionMedicamentos').hide();  $('#dialog-buscar').dialog('close'); }else{ $('#errorSeleccionMedicamentos').hide().show('shake'); } }); 
});}
function subirDX(claveDX, noAleatorio, idP, idU){ $(document).ready(function(e) { var datosSDX = {noAleatorio:noAleatorio, idP:idP, idU:idU, claveDX:claveDX}
	$.post('files-serverside/guardarDX.php',datosSDX).done(function( data ) { if (data==1){ $('#clickmeDXS').click(); $('#clickmeDX').click(); } else{alert(data);} });
});}
function subirMED(claveMED, noAleatorio, idP, idU){ $(document).ready(function(e) { var datosSMED = {noAleatorio:noAleatorio, idP:idP, idU:idU, claveMED:claveMED}
	$.post('files-serverside/guardarMED.php',datosSMED).done(function( data ) { if (data==1){ $('#clickmeMS').click(); $('#clickmeMedi').click(); } else{alert(data);} });
});}

function history(idP, idC, tipo){ $(document).ready(function(e) { //idC es el id pero de la consulta
	var datosH = {idP:idP, idE:idC}
	$.post('files-serverside/datosHistorial.php',datosH).done(function(data){ 
		var datosH = data.split('*;'), titleH = '';
		switch(tipo){
			case 'h': titleH = 'RESUMEN HISTORIA CLÍNICA. '+datosH[0]+' '+datosH[1]; break;
			case 'l': titleH = 'HISTORIAL LABORATORIO. '+datosH[0]+' '+datosH[1]; break;
			case 'u': titleH = 'HISTORIAL ULTRASONIDO. '+datosH[0]+' '+datosH[1]; break;
			case 'i': titleH = 'HISTORIAL IMAGEN. '+datosH[0]+' '+datosH[1]; break;
			case 'o': titleH = 'HISTORIAL OTROS SERVICIOS. '+datosH[0]+' '+datosH[1]; break;
			case 'n': titleH = 'HISTORIAL NOTAS EVOLUCIÓN. '+datosH[0]+' '+datosH[1]; break;
		}
		var heH = $('#referencia').height() - 95, wiH=$('#referencia').width() * 0.98; //alert(wiH);
		$('#dialog-historiales').dialog({
			autoOpen:true,modal:true, width:wiH, height:heH, title:titleH, closeText: '', closeOnEscape: true,dialogClass: '',
			show: { effect: "blind", duration: 600 }, hide: { effect: "fold", duration: 600 },
			open:function( event, ui ){
				$("#dialog-historiales").load("htmls/historiales.php #dHistory", function( response, status, xhr ) { 
					$('.botonControl').click(function(event){ event.preventDefault(); });
					$('#cAntes').button({ icons: { primary: "ui-icon-seek-prev" }, text: false });
					$('#cSiguiente').button({ icons: { primary: "ui-icon-seek-next" }, text: false });
					$('#cActual').button({ icons: { primary: "ui-icon-seek-end" }, text: false });
					$("#tabs_hist").tabs({active: 0});
					$('#tabs_hist ul').removeClass('ui-widget-header');
					
					switch(tipo){
						case 'h': 
							$('#listasHistorial').hide(); $('#thi-1-1').text('HISTORIA CLÍNICA');$('#contenedorControles').hide();
							$('#tah2').hide();$('#tah3').hide();$('#tah4').hide(); 
							$('#tabs-1hi').html(datosH[3]).css('font-size','0.8em');
						break;
						case 'l':
							$('#tabs-1hi').css('border','1px none red').css('height',$('#dialog-historiales').height()-75);
							$('#tituloListaH').text('Historial de laboratorio'); $('#thi-1-1').text('RESULTADO');
							$('#tah2').hide();$('#tah3').hide();$('#tah4').hide();
							rDX1(datosH[4],1,idP,datosH[5]);
							
							var oTableHil;
							oTableHil = $('#dataTableHis').dataTable({
								"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
									$('#dialog-historiales span.DataTables_sort_icon').remove();
								},
								"destroy":true,"bJQueryUI":true,"bRetrieve":true,"bAutoWidth":true,"bStateSave":false,
								"sScrollY":$('#contenedorDTHI').height()-25,
								"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]], 
								"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }], 
								"iDisplayLength": 300000, "bLengthChange": false, "bProcessing": true, 
								"bServerSide": true,"sAjaxSource": "datatable-serverside/historial_laboratorio1.php",
								"fnServerParams": function (aoData, fnCallback) { 
									var aleatorio = idP, idC = idC;
									aoData.push(  {"name": "aleatorio", "value": aleatorio } );
									aoData.push(  {"name": "idC", "value": idC } );
								},
								"sDom": '<"filtroDX1">l<"infoDX1">r<"data_tDX1"t>', 
								"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
								"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
								"sZeroRecords":"NO HAY HISTORIAL DE ESTUDIOS DE LABORATORIO","sInfo":"MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS: _MAX_","sSearch": "BUSCAR" }
							}); $('#clickmeHis').click(function(e) { oTableHil.fnDraw(); });
							$('#cAntes').click(function(e) {//obtenemos el id anterior pasando el id actual
                                var datosLA = {idP:idP, idC:$('#idControl').val()} //alert($('#idControl').val());
								$.post('files-serverside/idLAnterior.php',datosLA).done(function(data){
									var dati = data.split('*}[');
									if(data!=''){rDX1(dati[0],0,idP,dati[1]);}
								});
                            });
							$('#cSiguiente').click(function(e) {//obtenemos el id siguiente pasando el id actual
                                var datosLS = {idP:idP, idC:$('#idControl').val()}
								$.post('files-serverside/idLSiguiente.php',datosLS).done(function(data){
									var dati = data.split('*}[');
									if(data!=''){rDX1(dati[0],0,idP,dati[1]);}
								});
                            });
						break;
						case 'u':
							$('#tabs-1hi').css('border','1px none red').css('height',$('#dialog-historiales').height()-75);
							$('#tituloListaH').text('Historial de ultrasonidos');
							$('#thi-1-1').text('INTERPRETACIÓN'); $('#thi-2-1').text('IMÁGENES');
							$('#tah3').hide();$('#tah4').hide();
							rDXu(datosH[6],1,idP);
							
							var oTableHil;
							oTableHil = $('#dataTableHis').dataTable({
								"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
									$('#dialog-historiales span.DataTables_sort_icon').remove();
								},
								"destroy":true,"bJQueryUI":true,"bRetrieve":true,"bAutoWidth":true,"bStateSave":false,
								"sScrollY":$('#contenedorDTHI').height()-25,
								"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]], 
								"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }], 
								"iDisplayLength": 300000, "bLengthChange": false, "bProcessing": true, 
								"bServerSide": true,"sAjaxSource": "datatable-serverside/historial_usg.php",
								"fnServerParams": function (aoData, fnCallback) { 
									var aleatorio = idP, idC = idC;
									aoData.push(  {"name": "aleatorio", "value": aleatorio } );
									aoData.push(  {"name": "idC", "value": idC } );
								},
								"sDom": '<"filtroDX1">l<"infoDX1">r<"data_tDX1"t>', 
								"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
								"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
								"sZeroRecords":"NO HAY HISTORIAL DE ESTUDIOS DE ULTRASONIO","sInfo":"MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS: _MAX_","sSearch": "BUSCAR" }
							}); $('#clickmeHis').click(function(e) { oTableHil.fnDraw(); });
							$('#cAntes').click(function(e) {//obtenemos el id anterior pasando el id actual
                                var datosUA = {idP:idP, idC:$('#idControl').val()} //alert($('#idControl').val());
								$.post('files-serverside/idUAnterior.php',datosUA).done(function(data){
									if(data!=''){rDXu(data,0,idP);}
								});
                            });
							$('#cSiguiente').click(function(e) {//obtenemos el id siguiente pasando el id actual
                                var datosUS = {idP:idP, idC:$('#idControl').val()}
								$.post('files-serverside/idUSiguiente.php',datosUS).done(function(data){
									if(data!=''){rDXu(data,0,idP);}
								});
                            });
						break;
						case 'i':
							$('#tituloListaH').text('Historial de imagen');
							$('#thi-1-1').text('INTERPRETACIÓN'); $('#thi-2-1').text('IMÁGENES CAPTURAS');
							$('#tah3').hide();$('#tah4').hide(); //$('#thi-2-1').hide(); alert(datosH[9]);
							rDXi(datosH[9],1,idP);
							$('#cAntes').click(function(e) {//obtenemos el id anterior pasando el id actual
								var datosIA = {idP:idP, idC:$('#idControl').val()} //alert($('#idControl').val());
								$.post('files-serverside/idIAnterior.php',datosIA).done(function(data){
									if(data!=''){rDXi(data,0,idP);}//alert(data);
								});
							});
							$('#cSiguiente').click(function(e) {//obtenemos el id siguiente pasando el id actual
								//alert($('#idControl').val());
								var datosIS = {idP:idP, idC:$('#idControl').val()}
								$.post('files-serverside/idISiguiente.php',datosIS).done(function(data){//alert(data);
									if(data!=''){rDXi(data,0,idP);}
								});
							});
							
							var oTableHil;
							oTableHil = $('#dataTableHis').dataTable({
								"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
									$('#dialog-historiales span.DataTables_sort_icon').remove();
								},
								"destroy":true,"bJQueryUI":true,"bRetrieve":true,"bAutoWidth":true,"bStateSave":false,
								"sScrollY":$('#contenedorDTHI').height()-50,
								"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]], 
								"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }], 
								"iDisplayLength": 300000, "bLengthChange": false, "bProcessing": true, 
								"bServerSide": true,"sAjaxSource": "datatable-serverside/historial_imagen1.php",
								"fnServerParams": function (aoData, fnCallback) { 
									var aleatorio = idP, idC = idC;
									aoData.push(  {"name": "aleatorio", "value": aleatorio } );
									aoData.push(  {"name": "idC", "value": idC } );
								},
								"sDom": '<"filtroDX1">l<"infoDX1">r<"data_tDX1"t>', 
								"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
								"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
								"sZeroRecords":"NO HAY HISTORIAL DE ESTUDIOS DE IMAGEN","sInfo":"MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS: _MAX_","sSearch": "BUSCAR" }
							}); $('#clickmeHis').click(function(e) { oTableHil.fnDraw(); });
						break;
						case 'o':
							$('#tituloListaH').text('Historial de otros servicios'); $('#tah2').hide();
							rDXno(datosH[8],1,idP);
							
							var oTableHil;
							oTableHil = $('#dataTableHis').dataTable({
								"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
									$('#dialog-historiales span.DataTables_sort_icon').remove();
								},
								"destroy":true,"bJQueryUI":true,"bRetrieve":true,"bAutoWidth":true,"bStateSave":false,
								"sScrollY":$('#contenedorDTHI').height()-50,
								"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]], 
								"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }], 
								"iDisplayLength": 300000, "bLengthChange": false, "bProcessing": true, 
								"bServerSide": true,"sAjaxSource": "datatable-serverside/historial_servicios1.php",
								"fnServerParams": function (aoData, fnCallback) { 
									var aleatorio = idP, idC = idC;
									aoData.push(  {"name": "aleatorio", "value": aleatorio } );
									aoData.push(  {"name": "idC", "value": idC } );
								},
								"sDom": '<"filtroDX1">l<"infoDX1">r<"data_tDX1"t>', 
								"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
								"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
								"sZeroRecords":"NO HAY HISTORIAL DE OTROS SERVICIOS","sInfo":"MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>SERVICIOS: _MAX_","sSearch": "BUSCAR" }
							}); $('#clickmeHis').click(function(e) { oTableHil.fnDraw(); });
							$('#cAntes').click(function(e) {//obtenemos el id anterior pasando el id actual
                                var datosCA = {idP:idP, idC:$('#idControl').val()} //alert($('#idControl').val());
								$.post('files-serverside/idOAnterior.php',datosCA).done(function(data){
									if(data!=''){rDXno(data,0,idP);}
								});
                            });
							$('#cSiguiente').click(function(e) {//obtenemos el id siguiente pasando el id actual
                                var datosCS = {idP:idP, idC:$('#idControl').val()}
								$.post('files-serverside/idOSiguiente.php',datosCS).done(function(data){
									if(data!=''){rDXno(data,0,idP);}
								});
                            });
						break;
						case 'n':
							$('#tituloListaH').text('Historial de notas médicas');
							rDXn(datosH[7],1,idP); //alert(datosH[7]);
							
							var oTableHil;
							oTableHil = $('#dataTableHis').dataTable({
								"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
									$('#dialog-historiales span.DataTables_sort_icon').remove();
								},
								"destroy":true,"bJQueryUI":true,"bRetrieve":true,"bAutoWidth":true,"bStateSave":false,
								"sScrollY":$('#contenedorDTHI').height()-50,
								"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]], 
								"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }], 
								"iDisplayLength": 300000, "bLengthChange": false, "bProcessing": true, 
								"bServerSide": true,"sAjaxSource": "datatable-serverside/historial_consultas1.php",
								"fnServerParams": function (aoData, fnCallback) { 
									var aleatorio = idP, idC = idC;
									aoData.push(  {"name": "aleatorio", "value": aleatorio } );
									aoData.push(  {"name": "idC", "value": idC } );
								},
								"sDom": '<"filtroDX1">l<"infoDX1">r<"data_tDX1"t>', 
								"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
								"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
								"sZeroRecords":"NO HAY HISTORIAL DE NOTAS DE EVOLUCIÓN","sInfo":"MOSTRADAS: _END_", 
								"sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "<br/>NOTAS: _MAX_","sSearch": "BUSCAR" }
							}); $('#clickmeHis').click(function(e) { oTableHil.fnDraw(); });
							$('#cAntes').click(function(e) {//obtenemos el id anterior pasando el id actual
                                var datosCA = {idP:idP, idC:$('#idControl').val()} //alert($('#idControl').val());
								$.post('files-serverside/idCAnterior.php',datosCA).done(function(data){
									if(data!=''){rDXn(data,0,idP);}
								});
                            });
							$('#cSiguiente').click(function(e) {//obtenemos el id siguiente pasando el id actual
                                var datosCS = {idP:idP, idC:$('#idControl').val()}
								$.post('files-serverside/idCSiguiente.php',datosCS).done(function(data){
									if(data!=''){rDXn(data,0,idP);}
								});
                            });
						break;
						case 'e':
							$('#tabs-1hi').css('border','1px none red').css('height',$('#dialog-historiales').height()-75);
							$('#tituloListaH').text('Historial de endoscopías');
							$('#thi-1-1').text('INTERPRETACIÓN'); $('#thi-2-1').text('IMÁGENES');
							$('#tah3').hide();$('#tah4').hide();
							rDXe(datosH[10],1,idP);
							
							var oTableHil;
							oTableHil = $('#dataTableHis').dataTable({
								"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
									$('#dialog-historiales span.DataTables_sort_icon').remove();
								},
								"destroy":true,"bJQueryUI":true,"bRetrieve":true,"bAutoWidth":true,"bStateSave":false,
								"sScrollY":$('#contenedorDTHI').height()-25,"bInfo":true,"bFilter":true,"aaSorting":[[0, "desc"]],
								"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }], 
								"iDisplayLength": 300000, "bLengthChange": false, "bProcessing": true, 
								"bServerSide": true,"sAjaxSource": "datatable-serverside/historial_endo.php",
								"fnServerParams": function (aoData, fnCallback) { 
									var aleatorio = idP, idC = idC;
									aoData.push(  {"name": "aleatorio", "value": aleatorio } );
									aoData.push(  {"name": "idC", "value": idC } );
								},
								"sDom": '<"filtroDX1">l<"infoDX1">r<"data_tDX1"t>', 
								"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
								"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
								"sZeroRecords":"NO HAY HISTORIAL DE ESTUDIOS DE ENDOSCOPÍA","sInfo":"MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS: _MAX_","sSearch": "BUSCAR" }
							}); $('#clickmeHis').click(function(e) { oTableHil.fnDraw(); });
							$('#cAntes').click(function(e) {//obtenemos el id anterior pasando el id actual
                                var datosUA = {idP:idP, idC:$('#idControl').val()} //alert($('#idControl').val());
								$.post('files-serverside/idEAnterior.php',datosUA).done(function(data){
									if(data!=''){rDXe(data,0,idP);}
								});
                            });
							$('#cSiguiente').click(function(e) {//obtenemos el id siguiente pasando el id actual
                                var datosUS = {idP:idP, idC:$('#idControl').val()}
								$.post('files-serverside/idESiguiente.php',datosUS).done(function(data){
									if(data!=''){rDXe(data,0,idP);}
								});
                            });
						break;
						case 'c':
							$('#tabs-1hi').css('border','1px none red').css('height',$('#dialog-historiales').height()-75);
							$('#tituloListaH').text('Historial de colposcopías');
							$('#thi-1-1').text('INTERPRETACIÓN'); $('#thi-2-1').text('IMÁGENES');
							$('#tah3').hide();$('#tah4').hide();
							rDXcol(datosH[11],1,idP); //alert(datosH[11]);
							
							var oTableHil;
							oTableHil = $('#dataTableHis').dataTable({
								"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
									$('#dialog-historiales span.DataTables_sort_icon').remove();
								},
								"destroy":true,"bJQueryUI":true,"bRetrieve":true,"bAutoWidth":true,"bStateSave":false,
								"sScrollY":$('#contenedorDTHI').height()-25,"bInfo":true,"bFilter":true,"aaSorting":[[0, "desc"]],
								"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }], 
								"iDisplayLength": 300000, "bLengthChange": false, "bProcessing": true, 
								"bServerSide": true,"sAjaxSource": "datatable-serverside/historial_colpo.php",
								"fnServerParams": function (aoData, fnCallback) { 
									var aleatorio = idP, idC = idC;
									aoData.push(  {"name": "aleatorio", "value": aleatorio } );
									aoData.push(  {"name": "idC", "value": idC } );
								},
								"sDom": '<"filtroDX1">l<"infoDX1">r<"data_tDX1"t>', 
								"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
								"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
								"sZeroRecords":"NO HAY HISTORIAL DE ESTUDIOS DE COLPOSCOPÍA","sInfo":"MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS: _MAX_","sSearch": "BUSCAR" }
							}); $('#clickmeHis').click(function(e) { oTableHil.fnDraw(); });
							$('#cAntes').click(function(e) {//obtenemos el id anterior pasando el id actual
                                var datosUA = {idP:idP, idC:$('#idControl').val()} //alert($('#idControl').val());
								$.post('files-serverside/idCoAnterior.php',datosUA).done(function(data){
									if(data!=''){rDXcol(data,0,idP);}
								});
                            });
							$('#cSiguiente').click(function(e) {//obtenemos el id siguiente pasando el id actual
                                var datosUS = {idP:idP, idC:$('#idControl').val()}
								$.post('files-serverside/idCoSiguiente.php',datosUS).done(function(data){
									if(data!=''){rDXcol(data,0,idP);}
								});
                            });
						break;
					}
				});
			},
			close:function( event, ui ){ $("#tabs_hist").tabs("destroy"); $('#dialog-historiales').empty(); },
			buttons: {}
		});
	});

}); }

function miImg(idImg){ //alert(idImg);  de las imagenes de la consulta
	var tamHX = $('#referencia').height() - 100;
	var tamWX = $('#referencia').width() * 0.98;
	
	$('#dialog-img').dialog({ 
		autoOpen: true, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: true,
		closeText:'', title: "VISUALIZANDO IMAGEN", dialogClass: '',
		close: function(event, ui){ $('#miImg').html(''); },
		open: function(event, ui){ var miImg = '<img style="border:5px solid white; border-radius:3px" src='+'"'+idImg+'" />'; $('#miImg').html(miImg); }
	});//fin del dialog procesar
}

function cargarImagenesCanvasX(i){//alert(i);
$("#deCanvas").load("img_cslta/procesa.php?action=listFotos1&carpeta="+i,function(response,status,xhr){ if (status == "success" ){
		$('.eliminame1').click(function(event) { event.preventDefault(); });
		$('.eliminame1').button({ icons: { primary: "ui-icon-trash", }, text: false });
		$( ".en_reporte" ).button();
} }); 
window.setTimeout(function(){ $('#divCanvas').css('height',$('#tamHcanvas').val()).css('overflow','scroll');},500);
}

function cargarImagenesReporte(i){//alert(i);
	$("#deCanvas").load("img_cslta/procesa.php?action=listFotos1&carpeta="+i,function(response,status,xhr){
		if (status == "success" ){ //miDivImgs
			window.setTimeout(function(){$('#divCanvas').css('height',$('#tabs-8').height()-30);},500);
		}
	});
}

function eliminarFoto(idI, nombreI){
	var dato = {id:idI, nombre:nombreI}
	$.post("img_cslta/procesa.php?action=eliminar", dato).done(function( data ) {
		cargarImagenesCanvas(data);
		cargarImagenesReporte(data);
	});
}

function reporteFoto(idI, nombreI){
	var datoC = {id:idI}
	$.post("img_cslta/procesa.php?action=checar", datoC).done(function( dataA ) { 
		if(dataA==1){
			if($('#'+nombreI).prop('checked')==true){
				var dato = {id:idI, reportar:1}
				$.post("img_cslta/procesa.php?action=reporte", dato).done(function( data ) { 
					$('#'+nombreI).next().html('<span class="ui-button-text">R</span>');
					cargarImagenesReporte(data);
				});
			}else{
				var dato = {id:idI, reportar:0}
				$.post("img_cslta/procesa.php?action=reporte", dato).done(function( data ) { 
					$('#'+nombreI).next().html('<span class="ui-button-text">NR</span>');
					cargarImagenesReporte(data);
				});
			}
		}else{//ya esta lleno
			if($('#'+nombreI).prop('checked')==false){
				var dato = {id:idI, reportar:0}
				$.post("img_cslta/procesa.php?action=reporte", dato).done(function( data ) { 
					$('#'+nombreI).next().html('<span class="ui-button-text">NR</span>');
					cargarImagenesReporte(data);
				});
			}
		}
	});
}

function hospitalizar(idP,idC, nombreP){ $(document).ready(function(e) {
	$('#dialog-hospitalizar').dialog({
		autoOpen: true, modal: true, width: 750, height:250, title: 'HOSPITALIZAR', closeText: '', closeOnEscape: false, 
		dialogClass: 'no-close', 
		open:function( event, ui ){ $('.pacienteHospi').text(nombreP); },
		close:function( event, ui ){  },
		buttons: {
			'Aceptar':function(){
				if($('#confirmarHospi').prop('checked')==false){
					$('#errorHospi').show('shake');
					window.setTimeout(function(){$('#errorHospi').hide();},1000);
				}else{
					var datosH = {idP:idP, idC:idC, idU:$('#idUser').val()}
					$.post('files-serverside/hospitalizar.php',datosH).done(function(data){
						if(data==1){
							$('#dialog-hospitalizar').dialog('close');
							$('#dialog-confirmacion').dialog({
								autoOpen: true, modal: true, width: 600, height: 150, resizable: false, 
								closeOnEscape: true, 
								closeText:'', title: "CONFIRMACIÓN", dialogClass: '',
								open: function( event, ui ) {
									$('#textoConfirma').text('!El paciente ha sido hospitalizado!');
									window.setTimeout(function(){
										$('#dialog-confirmacion').dialog('close');
										$('#hospitalizarP').hide();
									},2000);
								},
								buttons: ''
							});
						}else{alert(data);}
					});
				}
			},
			'Cancelar':function(){$('#dialog-hospitalizar').dialog('close');}
		}
	});
}); }

function atenderC(idP,idC,opc,concept){ $(document).ready(function(e) {/*si control es 1 al cerrar la ventana abre VerConsulta*/ 
	//opc, si es 1 está pendiente, si es dos está en proceso y si es 3 está finalizada
	var datosCon = {idP:idP, idC:idC}
	$.post('files-serverside/datosSV.php',datosCon).done(function(data){ var datos = data.split(';*-'); //PENDIENTES Y PROCESO
		$('#texto-preguntar').html('¿DESEA ATENDER LA CONSULTA DEL PACIENTE <span style="color:red;">'+datos[0]+'</span>?');
		$('#dialog-preguntar').dialog({
		autoOpen: true, modal: true, width: 500, height:220, title: 'ATENDER LA CONSULTA', closeText: '', closeOnEscape: false, 
		dialogClass: 'no-close', 
		open:function( event, ui ){//Si la consulta ya ha sido atendida, entonces por default le damos click para que se abra
			if(opc==2){$(document.activeElement).click();} 
			if(opc==3){$(document.activeElement).click();}
		},
		close:function( event, ui ){  },
		buttons: {
		 'Si': function() { //Aquí se abre la consulta
		 	var st = opc; if(opc==1){st = 2;}if(opc==3){st = 6;}var datoCo = {idC:idC, idP:idP, idU:$('#idUser').val(),st:st}
			<?php if(isset($_GET['op'])){ ?>
			$.post('files-serverside/procesarConsulta_s.php',datoCo).done(function(data){var datos1=data.split(';*-');
			<?php }else{ ?>
			$.post('files-serverside/procesarConsulta.php',datoCo).done(function(data){ var datos1 = data.split(';*-');
			<?php } ?>
			
				if(datos1[0]==1){ $('#clickme').click();  
					$("#dialog1").load("htmls/consulta.php #tabs_c", function( response, status, xhr ){
						//bloqueamos los campos que no son necesarios mantener abiertos para edición
						$('#tablaSVT input, #tablaNotaSV textarea').prop('readonly','readonly');
						if(opc == 3){
							$('#observacionesC').prop('readonly','readonly');
							$('#celdaVideo, #hospitalizarP').hide();
						}else{$('#tabRevisiones').hide();}
						cargarImagenesCanvas(idC);
						
						//Lo de las imágenes
						var datoG = { idE:idC }
						$.post('files-serverside/datosDXcslta.php', datoG).done(function( dataDX ) {
							//$('#start').button({disabled: true});
							$('#capture, #stop').button({disabled: true});
									
							var datosDX = dataDX.split('*[+');
							//si ya esta hospitalizado bloqueamos el botón
							if(datosDX[2]>0){ $('#hospitalizarP').hide(); }
							
							$('.botonE').button({});
							$('.botonE').click(function(event) { event.preventDefault() });
							
							var k = 0;
							navigator.getUserMedia = navigator.getUserMedia ||  
											 navigator.webkitGetUserMedia || 
											 navigator.mozGetUserMedia || 
											 navigator.msGetUserMedia;
											  
							window.URL = window.URL || 
										 window.webkitURL || 
										 window.mozURL || 
										 window.msURL; 
							var j = datosDX[1]; //el número de la última imagen de la tabla de imágenes de consulta
							
							document.getElementById('start').addEventListener('click', function() {
								var hV = $('#contenedorVideo').height()*0.8, wV = $('#contenedorVideo').width()*0.8;
								$('#video').css('width',wV,'height',hV); 
							  navigator.getUserMedia({
								  video: true
								}, 
								function(stream) {
									videoStream = stream; // Stream the data
									video.src = window.URL.createObjectURL(stream);
									video = document.querySelector('video');
									video.play();
									$('#start').button({disabled: true});
									$('#capture, #stop').button({disabled: false});
								}, 
								function(e) { console.log(e); });   
							}, false);
							
							document.getElementById('stop').addEventListener('click', function() {
								if ( typeof video !== "undefined" && video) {video.pause();}// Pause the video
								if ( typeof videoStream !== "undefined" && videoStream) {videoStream.getTracks()[0].stop();}// Stop the stream
								$('#capture, #stop').button({disabled: true});
								$('#start').button({disabled: false});
											
							}, false);
							
							var button = document.getElementById('capture');
							 
							button.addEventListener('click', function() {
								j++; //alert(j);
								$('#deCanvas').append('<table style="float:left;" width="" border="0" cellspacing="0" cellpadding="3"> <tr> <td align=""><span style="display:block;">Eliminar</span></td> </tr> <tr> <td><canvas id="miFoto'+j+'" width="160" height="120"></canvas></td> </tr> </table>');
							
								var canvas = document.getElementById('miFoto'+j), ctx = canvas.getContext('2d');
								ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
								
								var canvasX = document.getElementById('miFotoX'), ctxX = canvasX.getContext('2d');
								ctxX.drawImage(video, 0, 0, canvasX.width, canvasX.height); //esta va culta en una pestaña que no es visible
								
								var canvas1 = document.getElementById('miFotoX1'), ctx1 = canvas1.getContext('2d');
								ctx1.drawImage(video, 0, 0, canvas1.width, canvas1.height);
								
								var image = new Image();
								image.src = canvas1.toDataURL("image/png");
								var dataURL1 = canvas1.toDataURL();
								//alert(image);
								$('#imagenesEndo').append('<table style="float:left;" width="" border="0" cellspacing="0" cellpadding="3"> <tr> <td align=""> </td> </tr> <tr> <td><img id="miFoto1'+j+'" alt="Right click to save me!"></td> </tr> </table>');
								document.getElementById('miFoto1'+j).src = dataURL1;
								
								var dataURL1 = canvas1.toDataURL();
								$.ajax({
								  type: "POST",
								  url: "files-serverside/guardarImgNormalC.php",
								  data: { imgBase64: dataURL1, cont:j, id:idC }
								}).done(function(o) {
								  console.log('saved'); 
								  // If you want the file to be visible in the browser please modify the callback in javascript. All you
								  // need is to return the url to the file, you just saved and than put the image in your browser.
								});
								
								var dataURL = canvasX.toDataURL();
								$.ajax({
								  type: "POST",
								  url: "files-serverside/guardarImgC.php",
								  data: { imgBase64: dataURL, cont:j, id:idC }
								}).done(function(o) {
								  console.log('saved'); 
								  // If you want the file to be visible in the browser please modify the callback in javascript. All you
								  // need is to return the url to the file, you just saved and than put the image in your browser.
								  cargarImagenesCanvas(idC);
								  cargarImagenesReporte(idC);
								});
								
							}, false);
		
						});
						//Fin de la captura de imágenes
						
						//Cargamos las imágenes capturadas de la consulta
						cargarImagenesReporte(idC);
						
						$('#tabs-1 *').css('font-size','0.98em'); $('#b_graficasSignosC').hide();
						$('#salvarConsulta,#salirSGconsulta,#finalizarConsulta,#hospitalizarP').click(function(event){ 
							event.preventDefault();
						});
						
						if(opc==1){ $('#imprimirNotaE').hide(); $('#imprimirRecetaF').hide(); $('#imprimirRecetaT').hide(); }
						else{ $('#imprimirNotaE').show(); $('#imprimirRecetaF').show(); $('#imprimirRecetaT').show();}
						
						if(opc==3){$('#b_agregarSignosC').hide();}else{$('#b_agregarSignosC').show();}
						
						$('.botonhes').click(function(event){ event.preventDefault(); });
						$('.historialhes').button({ icons: { primary: "" }, text: true });
						$('#verHistorialNotasC').button({ /*icons: { primary: "ui-icon-note" },*/ text: true });
						$('.grafi').button({ icons: { primary: "ui-icon-image" }, text: false });
						
						$('.historialhes').click(function(e) { history(idP, datos[17], $(this).prop('lang')); });
						
						$('#b_agregarSignosC').click(function(e) { signosVvacios(idP,2); }); 
						$('#idPaciente_c').val(idP); 

						$('#salvarConsulta').button({ icons:{ primary:'ui-icon-disk' } });
						$('#finalizarConsulta').button({ icons:{ primary:'ui-icon-check' } });
						$('#salirSGconsulta').button({ icons:{ primary:'ui-icon-cancel' } });
						$('#hospitalizarP').button({ icons:{ primary:'ui-icon-plusthick' } });
						//LA consulta esta en estado Atendida
						
						//Mandar a hospitalizar
						$('#hospitalizarP').click(function(e) { hospitalizar(idP,idC, datos1[5]); });
						//Fin mandar a hospitalizar
						
						//osultamos todos los controles para que no se pueda cambiar nada porque ya esta atendida
						$('#dialog1 #b_agregarSignosC,#dialog1 #b_dictamenC,#dialog1 #b_medicamentosC,#dialog1 #salvarConsulta,#dialog1 #finalizarConsulta,#dialog1 #hospitalizarP').hide();
						$('#salirSGconsulta').click(function(e) { $('#dialog1').dialog('close'); });
						$('#imprimirNotaE').button({ icons:{ primary:'ui-icon-print' },text:false });
						$('#imprimirNotaE').click(function(event) { event.preventDefault(); });
						$('#imprimirRecetaF').button({ icons:{ primary:'ui-icon-print' },text:false });
						$('#imprimirRecetaF').click(function(event) { event.preventDefault(); });
						$('#imprimirRecetaT').button({ icons:{ primary:'ui-icon-print' },text:false });
						$('#imprimirRecetaT').click(function(event) { event.preventDefault(); });
						var cuadri = 24;
						$('#imprimirNotaE').css('width',cuadri).css('height',cuadri);
						$('#imprimirRecetaF').css('width',cuadri).css('height',cuadri);
						$('#imprimirRecetaT').css('width',cuadri).css('height',cuadri);
						
						$('#imprimirNotaE').click(function(e) {
                            $('#dialog-informar').load("htmls/nota_evolucion.php #miNotaE", function( response, status, xhr ) {
							if( status == "success" ){
								var datosNE = {idConsul:idC, idPac: idP}
								$.post('files-serverside/notaEvo.php',datosNE).done(function(data){
									var miDataNE = data.split(';*}-{');
									$('#nombrePNE').text(miDataNE[0]); $('#edadPNE').text(miDataNE[1]);
									$('#sexoPNE').text(miDataNE[2]); $('#domicilioPNE').text(miDataNE[3]);
									$('#folioPNE').text(miDataNE[4]); $('#fechaNE').text(miDataNE[5]);
									$('#fcNE').text(miDataNE[6]); $('#frNE').text(miDataNE[7]); 
									$('#taNE').text(miDataNE[8]); $('#tempNE').text(miDataNE[9]); 
									$('#pesoNE').text(miDataNE[10]); $('#tallaNE').text(miDataNE[11]);
									$('#imcNE').text(miDataNE[12]); $('#notaNE').html(miDataNE[13]);
									$('#alergiasNE').text(miDataNE[14]); $('#doctorNE').html(miDataNE[15]);
									$('#especialidadesDRne').text(miDataNE[16]);//alert(miDataNE[20]);
									if(miDataNE[18]==1){//Para la firma
										var datos = {aleatorio:miDataNE[19]}
										$.post('../usuarios/files-serverside/datosFirma.php',datos).done(function( data ){ 
											var t = "<img src='../usuarios/firmas/files/"+data+"."+miDataNE[20]+"?"+Math.round(Math.random()*1000)+"' height='90%'>";
											$('#firmaDoctorNE').html(t);
										});
									}

									if(miDataNE[21]>0){//Para el membrete encabezado
										xME='../sucursales/membretes/files/'+miDataNE[22]+'.'+miDataNE[23]+'?'+Math.round(Math.random()*1000); var membretDME = 'url('+xME+')'; //alert(membretDME);
										$("#para_encabezado").css('background-image',membretDME).css('background-size','cover').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
									}
									if(miDataNE[24]>0){//Para el membrete encabezado
										xMP='../sucursales/membretes/files/'+miDataNE[25]+'.'+miDataNE[26]+'?'+Math.round(Math.random()*1000); var membretDMP = 'url('+xMP+')'; //alert(membretDME);
										$("#para_pie").css('background-image',membretDMP).css('background-size','cover').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
									}
									
									$('.miEnca').hide();
									
									var h7=$('#referencia').height()-100, w7=$('#referencia').width() * 0.98;
									$('#dialog-informar').dialog({ 
										title: 'IMPRIMIR NOTA MÉDICA', modal: true, autoOpen: true, closeText: '', width: 850,
										height: h7, closeOnEscape: true, dialogClass: '',
										buttons:{ 
											"Imprimir":function(){
												$('.miEnca').show();var hXM=$('#miNotaE').height();$('#miNotaE').height('23.5cm');
												$('#dialog-informar #miNotaE').printElement(); 
												$('.miEnca').hide(); $('#miNotaE').height(hXM);
											},
											"Cerrar": function() { $('#dialog-informar').dialog('close'); }
										}, 
										create:function(event,ui){},close:function( event, ui ){ $('#dialog-informar').empty(); },
										open:function( event, ui ){//$('#miNotaE').addClass('fondo_tab');
											var oTableNE;
											oTableNE = $('#dataTableDNE').dataTable({
												"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
													$('#dialog-informar span.DataTables_sort_icon').remove();
												},
												"destroy":true,"bJQueryUI":true,"bRetrieve":true,
												/*"sScrollY":$('#tabs-3').height()-400,*/"bAutoWidth":true,"bStateSave":false,
												"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
												"aoColumns": [{ "bSortable": false }, { "bSortable": false }], 
												"iDisplayLength": 300,"bLengthChange": false, "bProcessing": true, 
												"bServerSide": true,"sAjaxSource": "datatable-serverside/diagnosticos.php",
												"fnServerParams": function (aoData, fnCallback) { 
													var aleatorio = datos1[4]; 
													aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
												},
												"sDom": '<"filtroDX1">l<"infoDX1">r<"data_tDX1"t>', 
												"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
												"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
												"sZeroRecords":"NO CUENTA CON DIAGNÓSTICOS","sInfo":"MOSTRADOS: _END_", 
												"sInfoEmpty": "MOSTRADOS: 0", 
												"sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_","sSearch": "BUSCAR" }
											});/*fin datatable*/ $('#clickmeDNE').click(function(e) { oTableNE.fnDraw(); });
										}
									});
								});
							}
							});
                        });
						
						$('#imprimirRecetaF').click(function(e) {
                            $('#dialog-informar').load("htmls/receta.php #miRecetaF", function( response, status, xhr ) {
							if( status == "success" ){
								var datosRF = {idConsul:idC, idPac: idP}
								$.post('files-serverside/recetaF.php',datosRF).done(function(data){
									var miDataRF = data.split(';*}-{');
									$('#nombrePRF').text(miDataRF[0]); $('#edadPRF').text(miDataRF[1]);
									$('#sexoPRF').text(miDataRF[2]); $('#domicilioPRF').text(miDataRF[3]);
									$('#folioPRF').text(miDataRF[4]); $('#fechaRF').text(miDataRF[5]); //alert(miDataRF[2]);
									$('#notaRF').html(miDataRF[13]); $('#doctorRF').html(miDataRF[15]);
									$('#especialidadesDRrf').text(miDataRF[16]); $('#indicacionesNE').html(miDataRF[17]);
									
									if(miDataRF[18]==1){
										var datos = {aleatorio:miDataRF[19]}
										$.post('../usuarios/files-serverside/datosFirma.php',datos).done(function( data ){ 
											var t = "<img src='../usuarios/firmas/files/"+data+"."+miDataRF[20]+"?"+Math.round(Math.random()*1000)+"' height='90%'>";
											$('#firmaDoctorRF').html(t);
										});
									}

									if(miDataRF[21]>0){//Para el membrete encabezado
										xME='../sucursales/membretes/files/'+miDataRF[22]+'.'+miDataRF[23]+'?'+Math.round(Math.random()*1000); var membretDME = 'url('+xME+')'; //alert(membretDME);
										$("#para_encabezadoF").css('background-image',membretDME).css('background-size','cover').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
									}
									if(miDataRF[24]>0){//Para el membrete pie
										xMP='../sucursales/membretes/files/'+miDataRF[25]+'.'+miDataRF[26]+'?'+Math.round(Math.random()*1000); var membretDMP = 'url('+xMP+')'; //alert(membretDME);
										$("#para_pieF").css('background-image',membretDMP).css('background-size','cover').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
									}
									
									$('.miEnca').hide();
									
									var h7=$('#referencia').height()-100, w7=$('#referencia').width() * 0.98;
									$('#dialog-informar').dialog({ 
										title: 'IMPRIMIR RECETA (frontal)', modal: true, autoOpen:true, closeText: '', width: 850,
										height: h7, closeOnEscape: true, dialogClass: '',
										buttons:{ 
											"Imprimir": function() { 
												$('.miEnca').show();var hXM1=$('#miRecetaF').height();
												$('#miRecetaF').height('21.5cm');
												$('#dialog-informar #miRecetaF').printElement();
												$('.miEnca').hide(); $('#miRecetaF').height(hXM1);
											},
											"Cerrar": function() { $('#dialog-informar').dialog('close'); }
										}, 
										close:function( event, ui ){ $('#dialog-informar').empty(); },
										open:function( event, ui ){ $('#miRecetaF').addClass('fondo_tab');}
									});
								});
							}
							});
                        });
						
						$('#imprimirRecetaT').click(function(e) {
                            $('#dialog-informar').load("htmls/receta.php #miRecetaT", function( response, status, xhr ) {
							if( status == "success" ){
								var datosRT = {idConsul:idC, idPac: idP}
								$.post('files-serverside/recetaT.php',datosRT).done(function(data){
									var miDataRT = data.split(';*}-{');
									$('#notaRT').html(miDataRT[13]); 
									
									var h7=$('#referencia').height()-100, w7=$('#referencia').width() * 0.98;
									$('#dialog-informar').dialog({ 
										title: 'IMPRIMIR RECETA (reverso)', modal: true, autoOpen: true, closeText: '', width:850,
										height: h7, closeOnEscape: true, dialogClass: '',
										buttons:{ 
											"Imprimir": function() { $('#dialog-informar #miRecetaT').printElement(); },
											"Cerrar": function() { $('#dialog-informar').dialog('close'); }
										}, 
										create:function(event,ui){},close:function( event, ui ){ $('#dialog-informar').empty(); },
										open:function( event, ui ){ }
									});
								});
							}
							});
                        });
						
						$('#b_graficasSignosC').click(function(e) {
                            $("#dialog").load("htmls/signos_vitales.php #grafiasSV", function( response, status, xhr ) {
							if( status == "success" ){
								var he3x=$('#referencia').height()-100, wi3x=$('#referencia').width() * 0.98;
								$('#dialog').dialog({ 
									title: 'GRÁFICAS DE SIGNOS VITALES', modal: true, autoOpen: true, closeText: '', width: wi3x,
									height: he3x, closeOnEscape: true, dialogClass: '',
									buttons:{ }, 
								  	create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog').empty(); }, 
									open:function( event, ui ){ window.setTimeout(function(){graficasSV(idP,1);},200); }
								});
							} });
                        });
						$('#tabs-6-1').click(function(e) {
                            $("#tabs_sv").tabs({active: 0});
							$('#tabs_sv ul').removeClass('ui-widget-header');
                        });
						$('#tabs-2-1').click(function(e) { //HC
                            $("#tabs-2").load("htmls/historia_clinicaC.php #tabs_hc", function( response, status, xhr ) {
							if( status == "success" ){
								$('#b_editarHC').button({ icons:{primary:'ui-icon-pencil'} });
								$('#b_actualizarHC').button({ icons:{primary:'ui-icon-refresh'} });
								$('#b_cancelHC').button({ icons:{primary:'ui-icon-cancel'} });
								
								$('#idUsuario_hc').val($('#idUser').val());$('#formHistoriaClinica').validate({ignore: 'hidden'});
								$('#tabs_hc input, #tabs_hc select, #tabs_hc textarea').addClass('campoITtab'); 
								$("#tabs_hc").tabs({active: 0}); $('.botonC').click(function(event) { event.preventDefault(); });
								$('#tabs_hc input, #tabs_hc select, #tabs_hc textarea').prop('disabled',true); 
								$('#b_actualizarHC, #b_cancelHC').hide(); $('#tabs_hc ul').removeClass('ui-widget-header');
								$('#tabs_hc *').css('font-size','0.97em');
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
									$.post('files-serverside/actualizarHC.php',datosHC1).done(function(data){ if(data==1){
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
							$('#idPaciente_hc').val(idP); var datosIDP = {idP:idP, idC:1}
							  $.post('files-serverside/datosSV.php',datosIDP).done(function(data){ var datos = data.split(';*-');
								var datosMiHC = { idP:idP }
								$.post('files-serverside/datosHC.php',datosMiHC).done(function(dataHC){ 
									var datosHC = dataHC.split(';*-'); 
								
									$('.estatusVive').load("files-serverside/cargar_estatus_vive.php",function(response,status,xhr){
										$('#estatus_padre').val(datosHC[0]);$('#estatus_madre').val(datosHC[5]);
										$('#estatus_conyugue').val(datosHC[15]);
										$('#formHistoriaClinica select.estatusVive').change(function(e) { 
											if($(this).val()!=''){ $(this).addClass('formatoHC'); }
											else{ $(this).removeClass('formatoHC');} 
									});
									$('#formHistoriaClinica select.estatusVive').each(function(index, element) { 
										if($(this).val()!=''){ $(this).addClass('formatoHC');}
										else{ $(this).removeClass('formatoHC');} 
									}); 
								});
								
								$('.enfermedad').load("files-serverside/cargar_enfermedades.php", function(response,status,xhr) {
									$('#ahf_padre_1').val(datosHC[1]);$('#ahf_padre_2').val(datosHC[2]);
									$('#ahf_padre_3').val(datosHC[3]);$('#ahf_padre_4').val(datosHC[4]);
									$('#ahf_madre_1').val(datosHC[6]);$('#ahf_madre_2').val(datosHC[7]);
									$('#ahf_madre_3').val(datosHC[8]);$('#ahf_madre_4').val(datosHC[9]);
									$('#noHnos').val(datosHC[10]);$('#ahf_hnos_1').val(datosHC[11]);
									$('#ahf_hnos_2').val(datosHC[12]);$('#ahf_hnos_3').val(datosHC[13]);
									$('#ahf_hnos_4').val(datosHC[14]);$('#ahf_conyugue_1').val(datosHC[16]);
									$('#ahf_conyugue_2').val(datosHC[17]);$('#ahf_conyugue_3').val(datosHC[18]);
									$('#ahf_conyugue_4').val(datosHC[19]);$('#noHijos').val(datosHC[20]);
									$('#ahf_hijos_1').val(datosHC[21]);$('#ahf_hijos_2').val(datosHC[22]);
									$('#ahf_hijos_3').val(datosHC[23]);$('#ahf_hijos_4').val(datosHC[24]);
									$('#ahf_notas').val(datosHC[25]);$('#enfermedad1').val(datosHC[63]);
									$('#enfermedad2').val(datosHC[64]);$('#enfermedad3').val(datosHC[65]);
									$('#enfermedad4').val(datosHC[66]);
									window.setTimeout(function(){
										$('#formHistoriaClinica select').change(function(e) { 
											if($(this).val()!=''){ $(this).addClass('formatoHC');}
											else{ $(this).removeClass('formatoHC');} 
										});
										$('#formHistoriaClinica select').each(function(index, element) { 
											if($(this).val()!=''){ $(this).addClass('formatoHC');}
											else{ $(this).removeClass('formatoHC');} 
										}); 
										$('#formHistoriaClinica input[type=text],#formHistoriaClinica textarea').keyup(function(e) {
											if($(this).val()!=''){ $(this).addClass('formatoHC').css('color','black');}
											else{ $(this).removeClass('formatoHC').css('color','black');} 
										});
										$('#formHistoriaClinica input[type = text],#formHistoriaClinica textarea').each(function(index, element) { 
											if($(this).val()!=''){ $(this).addClass('formatoHC').css('color','black');}
											else{ $(this).removeClass('formatoHC').css('color','black');} 
										}); 
									},700);
								});
								$('#alergia1').val(datosHC[88]);$('#alergia2').val(datosHC[89]);$('#alergia3').val(datosHC[90]);
								$('#alergia4').val(datosHC[91]);$('#alergia5').val(datosHC[92]);$('#alergia6').val(datosHC[93]);
								$('#cirugia1').val(datosHC[67]); $('#cirugia2').val(datosHC[68]); $('#cirugia3').val(datosHC[69]);
								$('#transfusiones').val(datosHC[70]);$('#app_notas').val(datosHC[71]);$('#menarca').val(datosHC[72]);
								$('#ritmo').val(datosHC[73]);$('#duracionR').val(datosHC[74]);$('#fur').val(datosHC[75]);
								$('#ivsa').val(datosHC[76]);$('#gestas').val(datosHC[77]);$('#partos').val(datosHC[78]);
								$('#cesareas').val(datosHC[79]);$('#abortos').val(datosHC[80]);$('#anticonceptivo').val(datosHC[81]);
								$('#tiempo_uso').val(datosHC[83]);$('#doc').val(datosHC[84]);
								$('#colposcopiaHC').val(datosHC[85]);$('#mastografiaHC').val(datosHC[86]);
								$('#ago_notas').val(datosHC[87]);
									
								$('.adiccion').load("files-serverside/cargar_adicciones.php", function( response, status, xhr ) { 
									$('#adiccion1').val(datosHC[26]);$('#adiccion2').val(datosHC[27]);
									$('#adiccion3').val(datosHC[28]); 
								});
								$('.deporte').load("files-serverside/cargar_deportes.php", function( response, status, xhr ) { 
									$('#deporte1').val(datosHC[35]);$('#deporte2').val(datosHC[36]); 
								});
								$('.inicio').load("files-serverside/cargar_inicios.php", function( response, status, xhr ) { 
									$('#inicio_adiccion1').val(datosHC[29]);$('#inicio_adiccion2').val(datosHC[30]);
									$('#inicio_adiccion3').val(datosHC[31]); 
								});
								$('.frecuencia').load("files-serverside/cargar_frecuencias.php", function( response, status, xhr ){ 
									$('#frecuencia_deporte1').val(datosHC[37]);$('#frecuencia_deporte2').val(datosHC[38]); 
									$('#frecuencia_adiccion1').val(datosHC[32]);$('#frecuencia_adiccion2').val(datosHC[33]); 
									$('#frecuencia_adiccion3').val(datosHC[34]);$('#apnp_notas').val(datosHC[39]);
								});
								
								$('.recreacion').load("files-serverside/cargar_recreaciones.php", function(response, status, xhr ){ 
									$('#recreacion1').val(datosHC[40]);$('#recreacion2').val(datosHC[41]);
									$('#recreacion3').val(datosHC[42]); $('#recreacion4').val(datosHC[43]);
									$('#recreacion5').val(datosHC[44]);$('#recreacion6').val(datosHC[45]);
								});
								
								$('#vivienda_hc').load("files-serverside/cargar_viviendas.php", function( response, status, xhr ) {
									$('#vivienda_hc').val(datosHC[46]);$('#habitantes').val(datosHC[47]); 
								});
								
								$('.servicio_hc').load("files-serverside/cargar_servicios.php", function( response, status, xhr ) {
									$('#servicios1_hc').val(datosHC[50]);$('#servicios2_hc').val(datosHC[51]);
									$('#servicios3_hc').val(datosHC[52]); $('#servicios4_hc').val(datosHC[53]); 
								});
								
								$('.matV').load("files-serverside/cargar_mat_vivienda.php", function( response, status, xhr ) { 
									$('#mat_vivienda1').val(datosHC[48]);$('#mat_vivienda2').val(datosHC[49]);
								});
								$('#aseo_personal').load("files-serverside/cargar_aseo_personal.php",function(response,status,xhr){
									$('#aseo_personal').val(datosHC[54]);
								});
								
								$('.vacuna').load("files-serverside/cargar_vacunas.php", function( response, status, xhr ) { 
									$('#vacunas1').val(datosHC[55]);$('#vacunas2').val(datosHC[56]);$('#vacunas3').val(datosHC[57]);
									 $('#observacionesVacunas').val(datosHC[58]);
								}); 
								$('#hrs_dormir').val(datosHC[59]);
								
								$('#alimentacion_hc').load("files-serverside/cargar_alimentaciones.php",function(response,status,xhr ) { 
									$('#alimentacion_hc').val(datosHC[60]); 
								});
								$('.mascota').load("files-serverside/cargar_mascotas.php", function( response, status, xhr ) { 
									$('#mascota1').val(datosHC[61]);$('#mascota2').val(datosHC[62]); 
								});
								$('#tipo_anticon').load("files-serverside/cargar_anticonceptivos.php",function(response,status,xhr){
									$('#tipo_anticon').val(datosHC[82]);
								});
									
								});
								
							  });
						} });
                        }); //Fin HC
						
						window.setTimeout(function(){ // Para la nota de evolución
							var oTableDX;
							oTableDX = $('#dataTableDX').dataTable({
								"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
									$('#tabs-3 span.DataTables_sort_icon').remove(); $('#notaMedicaC').jqte();
									$('#indiF').jqte();
								},
								"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-3').height()-400, 
								"bAutoWidth":true,"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
								"aoColumns": [{ "bSortable": false }, { "bSortable": false }], "iDisplayLength": 30000, 
								"bLengthChange": false, "bProcessing": true, "bServerSide": true, 
								"sAjaxSource": "datatable-serverside/diagnosticos.php",
								"fnServerParams": function (aoData, fnCallback) { 
									var aleatorio = datos1[4]; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
								},
								"sDom": '<"filtroDX">l<"infoDX">r<"data_tDX"t>', 
								"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
								"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
								"sZeroRecords":"LA CONSULTA NO CUENTA CON DIAGNÓSTICOS","sInfo":"MOSTRADOS: _END_", 
								"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_","sSearch": "BUSCAR" }
							});/*fin datatable*/ $('#clickmeDX').click(function(e) { oTableDX.fnDraw(); });
						},100); var i=0, k = 0;
						$('#tabs-3-1').click(function(e) { //alert(2);
							$('#fc0').text($('#tabs-1 #fcC').val());
							//checamos los valores normales de la FC para poner u ocultar su *
							var datosFC = {idP:idP, idC:datos[17]}
							$.post('files-serverside/datosChartsFC1.php',datosFC).done(function(data){
								  var datoFC = data.split(';*');
								  if($('#fc0').text()>=datoFC[3] & $('#fc0').text()<=datoFC[4]){
									  $('#aFC').hide();
								  }else{$('#aFC').show();}
							});
							$('#fr0').text($('#tabs-1 #frC').val());
							//checamos los valores normales de la FC para poner u ocultar su *
							var datosFR = {idP:idP, idC:datos[17]}
							$.post('files-serverside/datosChartsFR1.php',datosFR).done(function(data){
								  var datoFR = data.split(';*');
								  if($('#fr0').text()>=datoFR[3] & $('#fr0').text()<=datoFR[4]){ $('#aFR').hide(); }
								  else{$('#aFR').show();}
							});
							$('#ta0').text($('#tabs-1 #tC').val()+'/'+$('#tabs-1 #aC').val());
							//checamos los valores normales de la TA para poner u ocultar su *
							var datosTA = {idP:idP, idC:datos[17]}
							$.post('files-serverside/datosChartsTA1.php',datosTA).done(function(data){
								  var datoTA = data.split(';*');
								  if( ($('#tabs-1 #tC').val()>=datoTA[3] & $('#tabs-1 #tC').val()<=datoTA[4]) || ($('#tabs-1 #aC').val()>=datoTA[8] & $('#tabs-1 #aC').val()<=datoTA[9])){
									  $('#aTA').hide();
								  }else{$('#aTA').show();}
							});
							$('#temp0').text($('#tabs-1 #tempC').val());
							//checamos los valores normales de la TEMP para poner u ocultar su *
							  if($('#temp0').text()>=36.5 & $('#temp0').text()<=37.5){
								  $('#aTEMP').hide();
							  }else{$('#aTEMP').show();}
							$('#peso0').text($('#tabs-1 #pesoC').val());
							$('#talla0').text($('#tabs-1 #tallaC').val());
							$('#imc0').text($('#tabs-1 #imcC').val());
							//checamos los valores normales de la TEMP para poner u ocultar su *
							  if($('#imc0').text()>=18.5 & $('#imc0').text()<=24.9){ $('#aIMC').hide(); }
							  else{$('#aIMC').show();}
							//pedimos y carmgamos las alergias
							var datosAl = {idPac:idP, idConsul:datos[17]}
							$.post('files-serverside/notaEvo.php',datosAl).done(function(data){
								  var alergis = data.split(';*}-{'); $('#alergias0').text(alergis[14]);
							});
							
							$('.grafi').prop('lang',datos[17]);//datos[17] es el id de los signos vitales
							
							$('.grafi').click(function(e) {
								$('#dialog-graafis').html('<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2"><tr> <td><canvas width="400" class="miCanvaA" id="myChartA" style=" border:1px none red;"></canvas></td> </tr></table>'); var ww = 0, r1=0, r2=0, r3=0, r4=0;
								if($(this).hasClass('gfc')){ var ww=1; }
								if($(this).hasClass('gfr')){ var ww=2; }
								if($(this).hasClass('gta')){ var ww=3; }
								if($(this).hasClass('gtemp')){ var ww=4; }
								if($(this).hasClass('gpeso')){ var ww=5; }
								if($(this).hasClass('gtalla')){ var ww=6; }
								if($(this).hasClass('gimc')){ var ww=7; }
																		
                                $('#dialog-graafis').dialog({
									autoOpen:true,modal:true,width:850,height:550,closeOnEscape:true,
									title:'MI GRÁFICA',closeText:'', buttons:{},
									close:function(event,ui){ $('#dialog-graafis').empty(); },
									open:function(event, ui){
										switch(ww){
											case 1: //Gráfica de FC
												var datosCHa = {idP:idP, idSV:datos[17]}
												$.post('files-serverside/datosChartsFC1.php',datosCHa).done(function(data){ 
												var datosCH4=data.split(';*'); var ctxFC = $("#myChartA").get(0).getContext("2d");
												
												$('#dialog-graafis').dialog({
													title:'GRÁFICA DE FRECUENCIA CARDIACA. '+datos[0]
												});
												//alert(datosCH1[1]); 
												var dataCH4 = { labels: ["",""],
													datasets: [
														{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", 
														strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
														{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",
														strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)",
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
														{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",
														strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
													]
												};
												var myNewChart4 = new Chart(ctxFC);
												var myLineChart4 = new Chart(ctxFC).Line(dataCH4, {
													scaleShowGridLines : true, scaleGridLineColor : "rgba(0,0,0,.05)", 
													scaleGridLineWidth : 1, scaleShowHorizontalLines: true, 
													scaleShowVerticalLines: true, bezierCurve : true, bezierCurveTension : 0.4, 
													pointDot : true, pointDotRadius : 4, pointDotStrokeWidth : 1, 
													pointHitDetectionRadius : 20, datasetStroke : true, datasetStrokeWidth : 2, 
													datasetFill : true,
													legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
												});
												var a = datosCH4[1], subD3 = datosCH4[1].split(','), subE3 = datosCH4[0].split(',');
												var vMin2 = datosCH4[3].split(','), vMax2 = datosCH4[4].split(',');//alert(datosCH1[2]);
												for(var i = 0; i < datosCH4[2]; i++){ 
													var b3 = i+1;  var a3 = subD3[i]+','+vMin2[i]+', '+vMax2[i]; 
													var codeToRun = 'window.setTimeout(function(){myLineChart4.addData(['+a3+'], "'+subE3[i]+'"); },'+b3+'000);'; /*alert(codeToRun); */eval(codeToRun);
													if(datosCH4[2]==1){
														var codeToRun1 = 'window.setTimeout(function(){myLineChart4.addData(['+a3+'], "'+subE3[i]+'"); },'+b3+'500);';eval(codeToRun1);}
													if(i==0){
														window.setTimeout(function(){myLineChart4.removeData(); 
														window.setTimeout(function(){myLineChart4.removeData(); },100);},2100); 
													}
												}
											});
											break;
											case 2:
												var datosCHa = {idP:idP, idSV:datos[17]}
												$.post('files-serverside/datosChartsFR1.php',datosCHa).done(function(data){ 
												var datosCH3 = data.split(';*'); var ctxFR=$("#myChartA").get(0).getContext("2d");
												//alert(datosCH1[1]);
												$('#dialog-graafis').dialog({
													title:'GRÁFICA DE FRECUENCIA RESPIRATORIA. '+datos[0]
												});
												var dataCH3 = { labels: ["",""],
													datasets: [
														{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", 
														strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)",
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
														{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",
														strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)",
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
														{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",
														strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)",
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
													]
												};
												var myNewChart3 = new Chart(ctxFR);
												var myLineChart3 = new Chart(ctxFR).Line(dataCH3, {
													scaleShowGridLines : true, scaleGridLineColor : "rgba(0,0,0,.05)", 
													scaleGridLineWidth : 1, scaleShowHorizontalLines: true, 
													scaleShowVerticalLines: true, bezierCurve : true, bezierCurveTension : 0.4, 
													pointDot : true, pointDotRadius : 4, pointDotStrokeWidth : 1, 
													pointHitDetectionRadius : 20, datasetStroke : true, datasetStrokeWidth : 2,
													datasetFill : true,
													legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
												});
												var a=datosCH3[1], subD2 = datosCH3[1].split(','), subE2 = datosCH3[0].split(',');
												var vMin1 = datosCH3[3].split(','), vMax1 = datosCH3[4].split(',');

												for(var i = 0; i < datosCH3[2]; i++){ 
													var b2 = i+1, a2 = subD2[i]+','+vMin1[i]+', '+vMax1[i]; 
													var codeToRun = 'window.setTimeout(function(){myLineChart3.addData(['+a2+'], "'+subE2[i]+'"); },'+b2+'000);'; /*alert(codeToRun); */ eval(codeToRun);
													if(datosCH3[2]==1){
														var codeToRun1 = 'window.setTimeout(function(){myLineChart3.addData(['+a2+'], "'+subE2[i]+'"); },'+b2+'500);';eval(codeToRun1);}
													if(i==0){
														window.setTimeout(function(){myLineChart3.removeData(); 
														window.setTimeout(function(){myLineChart3.removeData(); },100);},2100); 
													}
												}
											});
											break;
											case 3:
												var datosCHa = {idP:idP, idSV:datos[17]}
												$.post('files-serverside/datosChartsTA1.php',datosCHa).done(function(data){ 
												var datosCH2 = data.split(';*'), ctxTA = $("#myChartA").get(0).getContext("2d"); 
												//alert(datosCH2[3]);
												$('#dialog-graafis').dialog({ title:'GRÁFICA DE T/A. '+datos[0] }); 
												
												var dataCH2 = { labels: ["",""],
													datasets: [
														{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", 
														strokeColor: "rgba(119,176,204,1)", pointColor: "rgba(119,176,204,1)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
														{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",
														strokeColor: "rgba(119,176,204,0.4)",pointColor: "rgba(119,176,204,0.4)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(119,176,204,0.4)", data: [0, 0] },
														{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",
														strokeColor: "rgba(119,176,204,0.4)",pointColor: "rgba(119,176,204,0.4)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(119,176,204,0.4)", data: [0, 0] },
														{ label: "PACIENTE1", fillColor: "rgba(120,120,120,0)", 
														strokeColor: "rgba(120,120,120,1)", pointColor: "rgba(120,120,120,1)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(120,120,120,1)", data: [0,0] },
														{label:"MÍNIMO1",fillColor:"rgba(111,87,205,0)",
														strokeColor: "rgba(120,120,120,0.4)",pointColor: "rgba(120,120,120,0.4)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(120,120,120,0.4)", data: [0, 0] },
														{label:"MÁXIMO1",fillColor:"rgba(121,187,205,0)",
														strokeColor: "rgba(120,120,120,0.4)",pointColor: "rgba(120,120,120,0.4)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(120,120,120,0.4)", data: [0, 0] }
													]
												};
												var myNewChart2 = new Chart(ctxTA);
												var myLineChart2 = new Chart(ctxTA).Line(dataCH2, {
													scaleShowGridLines : true, scaleGridLineColor : "rgba(0,0,0,.05)", 
													scaleGridLineWidth : 1, scaleShowHorizontalLines: true, 
													scaleShowVerticalLines: true, bezierCurve : true, bezierCurveTension : 0.4, 
													pointDot : true, pointDotRadius : 4, pointDotStrokeWidth : 1, 
													pointHitDetectionRadius : 20, datasetStroke : true, datasetStrokeWidth : 2,
													datasetFill : true, 
													legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
												});
												var a=datosCH2[1], subD1 = datosCH2[1].split(','), subE1 = datosCH2[0].split(',');
												var a_1=datosCH2[6],subD1_1=datosCH2[6].split(','),subE1_1=datosCH2[5].split(',');
												var vMin = datosCH2[3].split(','), vMax = datosCH2[4].split(',');
												var vMin_1 = datosCH2[8].split(','), vMax_1 = datosCH2[9].split(',');
												//alert(datosCH1[2]);
												for(var i = 0; i < datosCH2[2]; i++){ 
													var b1 = i+1;  var a1 = subD1[i]+','+vMin[i]+', '+vMax[i]+','+subD1_1[i]+','+vMin_1[i]+', '+vMax_1[i]; 
													var b1_1 = i+1;  var a1_1 = subD1_1[i]+','+vMin_1[i]+', '+vMax_1[i]; 
													var codeToRun = 'window.setTimeout(function(){myLineChart2.addData(['+a1+'], "'+subE1[i]+'"); },'+b1+'000);'; /*alert(codeToRun); */ eval(codeToRun);
													if(datosCH2[2]==1){
														var codeToRun1 = 'window.setTimeout(function(){myLineChart2.addData(['+a1+'], "'+subE1[i]+'"); },'+b1+'500);';eval(codeToRun1);
													}
													if(i==0){
														window.setTimeout(function(){myLineChart2.removeData(); 
														window.setTimeout(function(){myLineChart2.removeData(); },100);},2100); 
													}
												}
											});
											break;
											case 4:
												var datosCHa = {idP:idP, idSV:datos[17]}
												$.post('files-serverside/datosChartsTemp1.php',datosCHa).done(function(data){ 
												var datosCH4=data.split(';*'); var ctxFC = $("#myChartA").get(0).getContext("2d");
												
												$('#dialog-graafis').dialog({ title:'GRÁFICA DE TEMPERATURA. '+datos[0] });

												var dataCH4 = { labels: ["",""],
													datasets: [
														{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", 
														strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
														{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",
														strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)",
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
														{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",
														strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
													]
												};
												var myNewChart4 = new Chart(ctxFC);
												var myLineChart4 = new Chart(ctxFC).Line(dataCH4, {
													scaleShowGridLines : true, scaleGridLineColor : "rgba(0,0,0,.05)", 
													scaleGridLineWidth : 1, scaleShowHorizontalLines: true, 
													scaleShowVerticalLines: true, bezierCurve : true, bezierCurveTension : 0.4, 
													pointDot : true, pointDotRadius : 4, pointDotStrokeWidth : 1, 
													pointHitDetectionRadius : 20, datasetStroke : true, datasetStrokeWidth : 2, 
													datasetFill : true,
													legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
												});
												var a = datosCH4[1], subD3 = datosCH4[1].split(','), subE3 = datosCH4[0].split(',');
												var vMin2 = datosCH4[3].split(','), vMax2 = datosCH4[4].split(',');//alert(datosCH1[2]);
												for(var i = 0; i < datosCH4[2]; i++){ 
													var b3 = i+1;  var a3 = subD3[i]+','+vMin2[i]+', '+vMax2[i]; 
													var codeToRun = 'window.setTimeout(function(){myLineChart4.addData(['+a3+'], "'+subE3[i]+'"); },'+b3+'000);'; /*alert(codeToRun); */eval(codeToRun);
													if(datosCH4[2]==1){
														var codeToRun1 = 'window.setTimeout(function(){myLineChart4.addData(['+a3+'], "'+subE3[i]+'"); },'+b3+'500);';eval(codeToRun1);}
													if(i==0){
														window.setTimeout(function(){myLineChart4.removeData(); 
														window.setTimeout(function(){myLineChart4.removeData(); },100);},2100); 
													}
												}
											});
											break;
											case 5:
												var datosCHa = {idP:idP, idSV:datos[17]}
												$.post('files-serverside/datosChartsPeso.php',datosCHa).done(function(data){ 
												var datosCH4=data.split(';*'); var ctxFC = $("#myChartA").get(0).getContext("2d");
												
												$('#dialog-graafis').dialog({ title:'GRÁFICA DE PESO. '+datos[0] });

												var dataCH4 = { labels: ["",""],
													datasets: [
														{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", 
														strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
														{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",
														strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)",
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
														{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",
														strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
													]
												};
												var myNewChart4 = new Chart(ctxFC);
												var myLineChart4 = new Chart(ctxFC).Line(dataCH4, {
													scaleShowGridLines : true, scaleGridLineColor : "rgba(0,0,0,.05)", 
													scaleGridLineWidth : 1, scaleShowHorizontalLines: true, 
													scaleShowVerticalLines: true, bezierCurve : true, bezierCurveTension : 0.4, 
													pointDot : true, pointDotRadius : 4, pointDotStrokeWidth : 1, 
													pointHitDetectionRadius : 20, datasetStroke : true, datasetStrokeWidth : 2, 
													datasetFill : true,
													legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
												});
												var a = datosCH4[1], subD3 = datosCH4[1].split(','), subE3 = datosCH4[0].split(',');
												var vMin2 = datosCH4[3].split(','), vMax2 = datosCH4[4].split(',');//alert(datosCH1[2]);
												for(var i = 0; i < datosCH4[2]; i++){ 
													var b3 = i+1;  var a3 = subD3[i]+','+vMin2[i]+', '+vMax2[i]; 
													var codeToRun = 'window.setTimeout(function(){myLineChart4.addData(['+a3+'], "'+subE3[i]+'"); },'+b3+'000);'; /*alert(codeToRun); */eval(codeToRun);
													if(datosCH4[2]==1){
														var codeToRun1 = 'window.setTimeout(function(){myLineChart4.addData(['+a3+'], "'+subE3[i]+'"); },'+b3+'500);';eval(codeToRun1);}
													if(i==0){
														window.setTimeout(function(){myLineChart4.removeData(); 
														window.setTimeout(function(){myLineChart4.removeData(); },100);},2100); 
													}
												}
											});
											break;
											case 6:
												var datosCHa = {idP:idP, idSV:datos[17]}
												$.post('files-serverside/datosChartsTalla.php',datosCHa).done(function(data){ 
												var datosCH4=data.split(';*'); var ctxFC = $("#myChartA").get(0).getContext("2d");
												
												$('#dialog-graafis').dialog({ title:'GRÁFICA DE TALLA. '+datos[0] });
												var dataCH4 = { labels: ["",""],
													datasets: [
														{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", 
														strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
														{label:"MÍNIMO",fillColor:"rgba(111,87,205,0)",
														strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)",
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] },
														{label:"MÁXIMO",fillColor:"rgba(121,187,205,0)",
														strokeColor: "rgba(151,187,205,1)",pointColor: "rgba(151,187,205,1)", 
														pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
														pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] }
													]
												};
												var myNewChart4 = new Chart(ctxFC);
												var myLineChart4 = new Chart(ctxFC).Line(dataCH4, {
													scaleShowGridLines : true, scaleGridLineColor : "rgba(0,0,0,.05)", 
													scaleGridLineWidth : 1, scaleShowHorizontalLines: true, 
													scaleShowVerticalLines: true, bezierCurve : true, bezierCurveTension : 0.4, 
													pointDot : true, pointDotRadius : 4, pointDotStrokeWidth : 1, 
													pointHitDetectionRadius : 20, datasetStroke : true, datasetStrokeWidth : 2, 
													datasetFill : true,
													legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
												});
												var a = datosCH4[1], subD3 = datosCH4[1].split(','), subE3 = datosCH4[0].split(',');
												var vMin2 = datosCH4[3].split(','), vMax2 = datosCH4[4].split(',');
												for(var i = 0; i < datosCH4[2]; i++){ 
													var b3 = i+1;  var a3 = subD3[i]+','+vMin2[i]+', '+vMax2[i]; 
													var codeToRun = 'window.setTimeout(function(){myLineChart4.addData(['+a3+'], "'+subE3[i]+'"); },'+b3+'000);'; /*alert(codeToRun); */eval(codeToRun);
													if(datosCH4[2]==1){
														var codeToRun1 = 'window.setTimeout(function(){myLineChart4.addData(['+a3+'], "'+subE3[i]+'"); },'+b3+'500);';eval(codeToRun1);}
													if(i==0){
														window.setTimeout(function(){myLineChart4.removeData(); 
														window.setTimeout(function(){myLineChart4.removeData(); },100);},2100); 
													}
												}
											});
											break;
											case 7:
												var tit = 'GRÁFICA DE IMC. '+datos[0];
												miGrafo(tit, idP, datos[17], 18.5, 24.9);
											break;
											default:
										}
									}//fin open
								});
                            });
							
							$('#clickmeDX').click(); 
							i++;
							if(i==1){
								window.setTimeout(function(){
									$('#tabs-3 .jqte_editor').css('height',$('#contenedorNM').height()-90);
									$('#tabs-3 .jqte_editor').css('max-height',$('#contenedorNM').height()-90);
								},400);
							}
							
							if(concept=='CERTIFICADO MEDICO ' & opc < 3){
								var datosCer = {idC:idC}
								$.post('files-serverside/datosCM.php',datosCer).done(function(data){ 
									var datosCM=data.split(';}{*');
									$('#tabs-3 .jqte_editor').html('<blockquote style="margin-right: 0px; margin-bottom: 0px; margin-left: 40px; border: none; padding: 0px;"><p class="MsoNoSpacing" style="text-align: justify;"><span lang="ES">POR  MEDIO  DE  LA  PRESENTE  EL QUE   SUSCRIBE   <b> '+datosCM[0]+' </b>MEDICO CON CED. PROF. '+datosCM[1]+'   HACE:</span></p></blockquote><p class="MsoNoSpacing" align="center" style="text-align: center;"><b><span lang="ES" style="font-size: 12pt;">C       E     R     T     I    F     I    C    A   </span></b></p><p class="MsoNoSpacing" style="text-align: justify;"><span lang="ES">QUE '+datosCM[2]+';  OROFARINGE SIN ALTERACIONES,  CON '+datosCM[3]+'. CARDIORESPIRATORIO SIN COMPROMISOS, ABDOMEN BLANDO Y DEPRESIBLE SIN MEGALIAS, BUENA PERISTALSIS, RESTO SIN COMPROMISO GRUPO SANGUINEO TIPO '+datosCM[4]+'.<o:p></o:p></span></p><p class="MsoNoSpacing" style="text-align: justify;"></p><p class="MsoNoSpacing" style="text-align: justify;"><span lang="ES"><b>ANTECEDENTES DE IMPORTANCIA</b></span></p><p class="MsoNoSpacing" style="text-align: justify;"></p><table width="100%" border="0" cellspacing="0" cellpadding="2"> <tbody><tr> <td width="35%">DIABETES MELLITUS</td> <td width="15%">NO</td> <td width="35%">HIPERTENSION ARTERIAL</td> <td width="15%">NO</td> </tr> <tr> <td>NEOPLASIAS</td> <td>NO</td> <td>QUIMICOS</td> <td>NO</td> </tr> <tr> <td>NEUROLOGICOS CRUZADO</td> <td>NO</td> <td>QUIRURGICOS</td> <td>NO</td> </tr> <tr> <td>TRANSFUSIONALES</td> <td>NO</td> <td>TRAUMATICOS</td> <td>NO</td> </tr> <tr> <td>ALERGIAS</td> <td>NO</td> <td>TOXICOMANIAS</td> <td>NO</td> </tr> <tr> <td>AGUDEZA VISUAL</td> <td>NO</td> <td>AGUDEZA AUDITIVA</td> <td>NO</td> </tr> </tbody></table><p></p><p class="MsoNoSpacing" style="text-align: justify;"></p><p class="MsoNoSpacing" style="text-align: justify;"><span lang="ES">    SE EXTIENDE LA PRESENTE COMO <b><u>CERTIFICACION  MEDICA</u></b> '+datosCM[5]+', POR LO CUAL PUEDE REALIZAR CUALQUIER ACTIVIDAD TANTO FISICA COMO INTELECTUAL.</span></p><p class="MsoNoSpacing" style="text-align: justify;"><span lang="ES"><br></span></p><p class="MsoNoSpacing" style="text-align: justify;"></p><p class="MsoNoSpacing" align="center" style="text-align: center;"><b><span lang="ES" style="font-size: 12pt;">ATENTAMENTE:</span></b></p><p class="MsoNoSpacing" align="center" style="text-align: center;"><b><span lang="ES" style="font-size: 12pt;"><br></span></b></p>');
								});
							}
						});
						
						window.setTimeout(function(){ // Para la receta reversa
							$('#notaMedicamentosC').jqte();
							var datosRT = {aleatorioRT:datos1[4]}
							$.post('files-serverside/pedirRT.php',datosRT).done(function(data){ 
								$('#notaMedicamentosC').html(data);
							});
						},100); var k=0;
						$('#tabs-7-1').click(function(e) { 
							k++;
							if(k==1){
								window.setTimeout(function(){
									$('#tabs-7 .jqte_editor').css('height',$('#contenedorIndiR').height()-80);
									$('#tabs-7 .jqte_editor').css('max-height',$('#contenedorIndiR').height()-80);
								},400);
							}
						});
						
						$('#b_dictamenC').click(function(e) {
						$("#dialog-buscar").load("htmls/dialogBuscarDX.php #buscarDiagnosticos",function( response, status, xhr ){
						if ( status == "success" ) {
							var he3 = $('#referencia').height()-$('.botones').height() - 100, wi3=$('#referencia').width() * 0.98;
							$('#dialog-buscar').dialog({ 
								title: 'BUSCAR DIAGNÓSTICOS', modal: true, autoOpen: true, closeText: '', width: wi3, height: he3, 
								closeOnEscape: false, dialogClass: 'no-close',
								buttons:{ //"Nuevo diagnóstico": function() { },
								"Aceptar": function() { checarHayDX(datos1[4]); }, 
								"Cerrar": function() { $('#dialog-buscar').dialog('close'); }
							  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscar').empty(); },
							  open:function( event, ui ){ 
							  	$('#altaDX').click(function(event) {
                                   event.preventDefault();
								   $("#dialog-nuevo").load("htmls/nuevo_dx_med.php #form-dx", function( response, status, xhr ) {
									if ( status == "success" ) { 
										$('#form-dx input, #form-dx select, #form-dx textarea').addClass('campoITtab');
									$('#dialog-nuevo').dialog({
										title:'AGREGAR UN NUEVO DIAGNÓSTICO',modal:true,autoOpen:true,closeText:'',width:800,
										height:370,closeOnEscape:true,dialogClass:'',
										open:function(event,ui){
											$('#id_u_ndx').val($('#idUser').val());
											$('#form-dx').validate({
												rules:{ 
													nombre_ndx:{ 
														required:true, 
														remote:{ 
															url: 'files-serverside/checkNombreDX.php?id_dx='+$('#id_dx_ndx').val(),
															type: "post", data: { dx:function(){ return $('#nombre_ndx').val(); } 
														} 
													} 
												},
												clave_ndx:{ 
													required:true, 
													remote:{ 
														url: 'files-serverside/checkClaveDX.php?id_dx='+$('#id_dx_ndx').val(),
														type: "post", data: { clave:function(){ return $('#clave_ndx').val(); 
													} 
												} 
											}, minlength: 5 }
										},
												messages:{ 
													nombre_ndx:{ 
														required: 'Se debe ingresar el nombre del diagnóstico.', 
														remote:'Este nombre de diagnóstico ya está en uso, favor de intentar con otro.' },
													clave_ndx:{ 
														required: 'Se debe ingresar la clave del diagnóstico.', 
														remote:'Esta clave ya está en uso, favor de intentar con otra.', 
														minlength:'La clave consta de 5 caracteres' }
												}
											}); 
										},
										close:function(event,ui){ document.getElementById('form-dx').reset(); $("#dialog-nuevo").empty();},
										buttons:{
											"Guardar": function() {
												if( $('#form-dx').valid() ){
													var datosDX = $('#form-dx').serialize(); 
													$.post('files-serverside/guardarNDX.php',datosDX).done(function(data){ 
													if(data == 1){
														$('#texto-informar').text('¡El nuevo diagnóstico se ha guardado satisfactoriamente!');
														$('#dialog-informar').dialog({
															autoOpen: true, modal: true, width: 600, height:200, 
															title: 'DATOS GUARDADOS', closeText: '',
															open:function( event, ui ){ $('#dialog-nuevo').dialog('close'); 
																$('#clickmeDX').click(); 
																window.setTimeout(function(){
																	$('#dialog-informar').dialog('close');},2000); 
															},
															buttons:{}
														});
													}else{alert(data);} });
												}
											},
											"Cancelar": function() { $('#dialog-nuevo').dialog('close'); }
										}
									}); //fin de dialog-nuevo
									} });//fin de load
                                });
							  	$('#altaDX').button({
									icons:{primary:'ui-icon-plusthick'}, text:false
								});
							  	var oTableBDX;
								oTableBDX = $('#dataTableBDX').dataTable({ 
								"bJQueryUI": true, "bRetrieve": true, "sScrollY": ($('#dialog-buscar').height()-155)/2,
								"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[1, "asc"]],
								"aoColumns": [{ "bSortable": false }, { "bSortable": false }], "iDisplayLength": 30, 
								"bLengthChange": false, "bProcessing": false, "bServerSide": true, ordering: false,
									"sDom": '<"toolbarBDX"><"filtroBDX"f>lr<"data_tBDX"t><"infoBDX"i>S', 
									"sAjaxSource": "datatable-serverside/buscar_diagnosticos.php", 
									"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
									"oLanguage": { 
										"sLengthMenu": "MONSTRANDO _MENU_ records per page", 
										"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
										"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_", "sSearch": "" 
									}
								});//fin datatable
								$(".pieTablaBDX input").keyup( function () { /* Filter on the column (the index) of this element */ oTableBDX.fnFilter( this.value, $(".pieTablaBDX input").index(this) ); } );
								$('.filtroBDX input').attr("placeholder", "BUSQUE LOS DIAGNÓSTICOS AQUÍ, Y DELE CLIC PARA SEECCIONARLOS...").addClass('placeHolder');
								$('.infoBDX').hide(); $('.filtroBDX input').focus(); $('.filtroBDX input').css('width', ($('#dialog-buscar').width() -16) ).hide(); $('.filtroBDX').css('left',-32);
								
								var tableBDX = $('#dataTableBDX').DataTable();
								$('#dataTableBDX tbody').on('click','tr',function(){if($(this).hasClass('selected2')){$(this).removeClass('selected2');}else{tableBDX.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');$('#errorSeleccionDX').hide();}});
								
								$('#dataTableBDX tbody').on( 'click', 'tr', function () { var nTdsDXS = $('td', this); subirDX($(nTdsDXS[0]).text(), datos1[4], idP, $('#idUser').val() ); }); //con la clave del médico sacamos su id
								
								var oTableSDX;
								oTableSDX = $('#dataTableDXS').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
									"sScrollY": ($('#dialog-buscar').height()-150)/2, "bStateSave": false, "bInfo": false, 
									"bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
									"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {  },
									"aoColumns": [
										{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
										{ "bSortable": false }
									], 
									"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
									"sDom": '<"toolbarDS"><"filtroDS"f>lr<"data_tDS"t><"infoDS"i>S', 
									"sAjaxSource": "datatable-serverside/diagnosticos_seleccionados.php", 
									"fnServerParams": function (aoData, fnCallback) { var aleatorio = datos1[4]; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); }, "aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
									"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_", "sSearch": "" }
								});/*fin datatable*/ $('#clickmeDXS').click(function(e) { oTableSDX.fnDraw(); });
							  }
							});
						}});//FIN LOAD DIALOG BUSCAR
						});//FIN CLICK() BUSCAR DICTAMEN
						var j = 0;
						$('#tabs-4 *').css('font-size','0.97em');
						j++;
						if(j==1){ 
							window.setTimeout(function(){
								var datosMedis = {aleatorioM:datos1[4]}
								$.post('files-serverside/pedirMedis.php',datosMedis).done(function(data){ 
									$('#recetaFrontC').html(data);
								});
							},200);
						}
						
						$('#b_medicamentosC').click(function(e) {
						$("#dialog-buscar").load("htmls/dialogBuscarDX.php #buscarMedicamentos",function( response,status, xhr ) {
						if ( status == "success" ) {
							var he3=$('#referencia').height()-$('.botones').height()-100, wi3 = $('#referencia').width() * 0.98;
							$('#dialog-buscar').dialog({ 
								title: 'BUSCAR MEDICAMENTOS', modal: true, autoOpen: true, closeText: '', width: wi3, height: he3,
								closeOnEscape: false, dialogClass: 'no-close',
								buttons:{//"Nuevo medicamento": function() { },
								"Aceptar": function() { checarHayMedi(datos1[4]); }, 
								"Cerrar": function() { $('#dialog-buscar').dialog('close'); }
							  }, create: function( event, ui ) {}, 
							  close:function( event, ui ){ 
							  	$('#dialog-buscar').empty(); 
								//Que cuando se cierre esta ventana de buscar medicamentos, que los ponga en la receta
								var datosMedis = {aleatorioM:datos1[4]}
								$.post('files-serverside/pedirMedis.php',datosMedis).done(function(data){ 
									$('#recetaFrontC').html(data);
								});
							  },
							  open:function( event, ui ){
								$('#altaMedicamento').button({icons:{primary:'ui-icon-plusthick'},text:false});
								$('#altaMedicamento').click(function(event) {
                                    event.preventDefault();
									$("#dialog-nuevo").load("htmls/nuevo_dx_med.php #form-med", function( response, status, xhr ){
									if ( status == "success" ) { 
										$('#form-med input, #form-med select, #form-med textarea').addClass('campoITtab');
										$("#descripcion_nmed").load('files-serverside/genera_descripcionMed.php');
										$('#dialog-nuevo').dialog({
											title:'AGREGAR UN NUEVO MEDICAMENTO',modal:true,autoOpen:true,closeText:'',width:800,
											height:450,closeOnEscape:true,dialogClass:'',
											open:function(event,ui){ $('#id_u_nmed').val($('#idUser').val());
												$('#form-med').validate({
													rules:{ 
														nombre_nmed:{ 
															required:true, 
															remote:{ 
															url:'files-serverside/checkNombreMed.php?id_dx='+$('#id_med_ndx').val(),
															type:"post", data: { med:function(){ return $('#nombre_nmed').val(); }
															} 
															} 
														},
														clave_nmed:{ 
															required:true, 
															remote:{ 
															url:'files-serverside/checkClaveMed.php?id_dx='+$('#id_med_ndx').val(),
															type:"post", data:{ clave:function(){ return $('#clave_nmed').val(); }
															} 
															}, 
															minlength: 5 
														}
													},
													messages:{ 
														nombre_nmed:{ 
															required: 'Se debe ingresar el nombre del medicamento.',
															remote:'Este nombre de medicamento ya está en uso, favor de intentar con otro.' 
														},
														clave_nmed:{ 
															required: 'Se debe ingresar la clave del medicamento.', 
															remote:'Esta clave ya está en uso, favor de intentar con otra.', 
															minlength:'La clave consta de 5 caracteres' }
													}
												}); 
											},
										close:function(event,ui){ 
											document.getElementById('form-med').reset(); $("#dialog-nuevo").empty();
										},
										buttons:{
											"Guardar": function() {
												if( $('#form-med').valid() ){
													var datosMed = $('#form-med').serialize(); 
													$.post('files-serverside/guardarNDed.php',datosMed).done(function(data){ 
													if(data == 1){
														$('#texto-informar').text('¡El nuevo medicamento se ha guardado satisfactoriamente!');
														$('#dialog-informar').dialog({
															autoOpen: true, modal: true, width: 600, height:200, 
															title: 'DATOS GUARDADOS', closeText: '', buttons:{},
															open:function( event, ui ){ 
																$('#dialog-nuevo').dialog('close'); $('#clickmeMedi').click();
																window.setTimeout(function(){
																	$('#dialog-informar').dialog('close');},2000); 
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
							  	var oTableBMe;
								oTableBMe = $('#dataTableBMedicamentos').dataTable({ 
									"destroy": true, "bJQueryUI": true, "bRetrieve": true, ordering: false,
									"sScrollY": ($('#dialog-buscar').height()-160)/2, "bAutoWidth": true, "bStateSave": false,
									"bInfo": true, "bFilter": true, "aaSorting": [[1, "asc"]], 
									"aoColumns": [
										{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
										{ "bSortable": false }
									], "iDisplayLength": 30, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
									"sDom": '<"filtroBMe"f>l<"infoBMe">r<"data_tBMe"t>', 
									"sAjaxSource": "datatable-serverside/buscar_medicamentos.php",
									"oLanguage": { 
										"sLengthMenu": "MONSTRANDO _MENU_ records per page", 
										"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
										"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MEDICAMENTOS: _MAX_", "sSearch": "" 
									}
								});//fin datatable
								$(".pieTablaBMedi input").keyup( function () {/* Filter on the column (the index) of this element */
									oTableBMe.fnFilter( this.value, $(".pieTablaBMedi input").index(this) ); 
								});
								$('.filtroBMe input').attr("placeholder", "BUSQUE LOS MEDICAMENTOS AQUÍ, Y DELE CLIC PARA SEECCIONARLOS...").addClass('placeHolder');
								$('.infoBMe').hide(); $('.filtroBMe input').focus(); 
								$('.filtroBMe input').css('width',($('#dialog-buscar').width()-16)).hide();
								$('.filtroBMe').css('left',-32);
								
								var tableBMedi = $('#dataTableBMedicamentos').DataTable();
								$('#dataTableBMedicamentos tbody').on('click','tr',function(){
									if($(this).hasClass('selected2')){
										$(this).removeClass('selected2');}
									else{
										tableBMedi.$('tr.selected2').removeClass('selected2');
										$(this).addClass('selected2');
										$('#errorSeleccionMedicamentos').hide();
									}
								});
								
								$('#dataTableBMedicamentos tbody').on( 'click', 'tr', function () { 
									var nTdsMES = $('td', this); 
									subirMED($(nTdsMES[0]).text(), datos1[4], idP, $('#idUser').val() ); }); 
								
								var oTableSMED;
								oTableSMED = $('#dataTableMS').dataTable({ 
									"bJQueryUI": true, "bRetrieve": true, "sScrollY": ($('#dialog-buscar').height()-160)/2,
									"bAutoWidth": true, "bStateSave": false, "bInfo": false, "bFilter": false, 
									"aaSorting": [[0, "asc"]], ordering: false,
									"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {  },
									"aoColumns": [
										{ "bSortable": false },{ "bSortable": false },{ "bSortable": false },
										{ "bSortable": false },{ "bSortable": false }
									], "iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
									"sDom": '<"toolbarDS"><"filtroDS"f>lr<"data_tDS"t><"infoDS"i>S', 
									"sAjaxSource": "datatable-serverside/medicamentos_seleccionados.php", 
									"fnServerParams": function (aoData, fnCallback) { 
										var aleatorio = datos1[4]; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
									}, "aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
									"oLanguage": { 
										"sLengthMenu": "MONSTRANDO _MENU_ records per page", 
										"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
										"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MEDICAMENTOS: _MAX_", "sSearch": "" 
									}
								});/*fin datatable*/ $('#clickmeMS').click(function(e) { oTableSMED.fnDraw(); });
							  }
							});
						}});//FIN LOAD DIALOG BUSCAR
						});//FIN CLICK() BUSCAR MEDICAMENTOS
						
						$('#tabs-5-1').click(function(e) { //el expediente electrónico del paciente
							//para consultas
							var oTableHCo;
							oTableHCo = $('#dataTableHCo').dataTable({
								"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
									$('#tabs-5 span.DataTables_sort_icon').remove();
								},
								"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-5').height()-50, 
								"bAutoWidth": true, "bStateSave":false, "bInfo":true, "bFilter": true, "aaSorting": [[0, "desc"]],
								"aoColumns": [
									{ "bSortable": false }, { "bSortable": false }, 
									{ "bSortable": false, "sClass": "left1" }, { "bSortable": false, "sClass": "left1" }
								],
								"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
								 "sAjaxSource": "datatable-serverside/historial_consultas.php",
								"fnServerParams": function (aoData, fnCallback) { 
									var aleatorio = idP; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
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
							//Fin del expediente de consultas
							$('#tabs-2-1h').click(function(e) {
								//para imagen
								var oTableHIm;
								oTableHIm = $('#dataTableHIm').dataTable({
									"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
										$('span.DataTables_sort_icon').remove();
									},
									"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-5').height()-30, 
									"bAutoWidth":true,"bStateSave":false,"bInfo":true, "bFilter":true, "aaSorting": [[0, "desc"]],
									"aoColumns": [
										{ "bSortable": false }, { "bSortable": false }, 
										{ "bSortable": false, "sClass": "left1" }, { "bSortable": false, "sClass": "left1" }
									],
									"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
									 "sAjaxSource": "datatable-serverside/historial_imagen.php",
									"fnServerParams": function (aoData, fnCallback) { 
										var aleatorio = idP; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
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
							$('#tabs-3-1h').click(function(e) { 
								//para Laboratorio
								var oTableHLa;
								oTableHLa = $('#dataTableHLa').dataTable({
									"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
										$('span.DataTables_sort_icon').remove();
									},
									"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-5').height()-40, 
									"bAutoWidth":true,"bStateSave": false, "bInfo":true,"bFilter": true, "aaSorting": [[0, "desc"]],
									"aoColumns": [
										{ "bSortable": false }, { "bSortable": false }, 
										{ "bSortable": false, "sClass": "left1" }, { "bSortable": false, "sClass": "left1" }
									],
									"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
									 "sAjaxSource": "datatable-serverside/historial_laboratorio.php",
									"fnServerParams": function (aoData, fnCallback) { 
										var aleatorio = idP; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
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
							$('#tabs-4-1h').click(function(e) { 
								//para endoscopía
								var oTableHEn;
								oTableHEn = $('#dataTableHEn').dataTable({
									"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
										$('span.DataTables_sort_icon').remove();
									},
									"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-5').height()-50, 
									"bAutoWidth":true,"bStateSave":false,"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
									"aoColumns": [
										{ "bSortable": false }, { "bSortable": false }, 
										{ "bSortable": false, "sClass": "left1" }, { "bSortable": false, "sClass": "left1" }
									],
									"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
									 "sAjaxSource": "datatable-serverside/historial_endoscopia.php",
									"fnServerParams": function (aoData, fnCallback) { 
										var aleatorio = idP; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
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
							$('#tabs-5-1h').click(function(e) {
								//para Servicios
								var oTableHSe;
								oTableHSe = $('#dataTableHSe').dataTable({
									"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
										$('span.DataTables_sort_icon').remove();
									},
									"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-5').height()-70, 
									"bAutoWidth":true,"bStateSave":false,"bInfo":true, "bFilter":true, "aaSorting": [[0, "desc"]],
									"aoColumns": [
										{ "bSortable": false }, { "bSortable": false }, 
										{ "bSortable": false, "sClass": "left1" }, { "bSortable": false, "sClass": "left1" }
									],
									"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
									 "sAjaxSource": "datatable-serverside/historial_servicios.php",
									"fnServerParams": function (aoData, fnCallback) { 
										var aleatorio = idP; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
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
						});
						$('#idUsuario_c').val($('#idUser').val()); $('#formConsulta').validate({ignore: 'hidden'}); 
						$('#fechaIngresoC').val(datos1[1]); 
						$('#fechaSignosC').val(datos1[2]); $('#motivoC').val(datos1[3]); 
						$('.busqueda').button({
							icons:{primary:"ui-icon-search"},text:false}
						).css('width','25px').css('height','25px');
						$('.eliminacion').button({
							icons:{primary:"ui-icon-trash"},text:false}
						).css('width','25px').css('height','25px'); 
						
						$('.bGraficas').button({ icons: { primary: "ui-icon-image"}, text: true });
						$('.bAgregar').button({ icons: { primary: "ui-icon-plusthick"}, text: true }); 
						$('.bAgregar, .botonC').click(function(event) { event.preventDefault(); });
						$('#dialog1 input, #dialog1 select, #dialog1 textarea').addClass('campoITtab'); 
						$("#dialog1").tabs({active: 3});window.setTimeout(function(){$("#tabs-3-1").click();},200);
						$('#edadC').val(datos[1]); $('#sexoC').val(datos[2]);$('#pacienteC').val(datos[0]); 
						$('#pesoC').val(datos[3]);$('#tallaC').val(datos[4]);$('#imcC').val(datos[5]);
						$('#cinturaC').val(datos[6]); $('#tC').val(datos[7]);$('#aC').val(datos[8]);
						$('#frC').val(datos[9]);$('#fcC').val(datos[10]);$('#tempC').val(datos[11]);$('#notasC').val(datos[12]);
						$('#observacionesC').val(datos[14]);$('#notaMedicaC').val(datos[15]);
						$('#notaMedicamentosC').val(datos[16]); $('#indiF').val(datos[18]);
						
						//Para que nos ponga el número de cosas que hay en los historiales en los botones
						$('#tabs-3-1').click(function(e) {
							var idPx = {idP:idP}
							$.post('files-serverside/datosBotonesHistoriales.php',idPx).done(function(data){ //Para ATENDIDAS!!!
								var datosBP = data.split(';*-'); //alert(data);
								$('#verHistorialLabC').html('<span class="ui-button-text">LAB('+datosBP[0]+')</span>');
								$('#verHistorialUsgC').html('<span class="ui-button-text">USG('+datosBP[1]+')</span>');
								$('#verHistorialImgC').html('<span class="ui-button-text">IMG('+datosBP[2]+')</span>');
								$('#verHistorialEndC').html('<span class="ui-button-text">END('+datosBP[3]+')</span>');
								$('#verHistorialColC').html('<span class="ui-button-text">COL('+datosBP[4]+')</span>');
								$('#verHistorialOtrosC').html('<span class="ui-button-text">OTROS('+datosBP[5]+')</span>');
								$('#verHistorialNotasC').html('<span class="ui-button-text">CNTS('+datosBP[6]+')</span>');
							});
                        });
						
						var he1 = $('#referencia').height() - 95, wi1 = $('#referencia').width() * 0.98,
						titulo2 = 'CONSULTA PACIENTE: '+datos[0]+' EDAD: '+datos[1]; var opcF = datos[19], aleF = datos[20],
						exteF = datos[21];
						if(opc==3){
							var idCx = {idCx:idC}
							$.post('files-serverside/datosSVconsulta.php',idCx).done(function(data){ //Para ATENDIDAS!!!
								var datosSVC = data.split(';*-'); //alert(data);
								$('#pesoC').val(datosSVC[0]);$('#tallaC').val(datosSVC[1]);$('#imcC').val(datosSVC[2]);
								$('#cinturaC').val(datosSVC[3]);$('#tC').val(datosSVC[4]);$('#aC').val(datosSVC[5]);
								$('#frC').val(datosSVC[6]);$('#fcC').val(datosSVC[7]);$('#tempC').val(datosSVC[8]);
								$('#notasC').val(datosSVC[9]);$('#fechaSignosC').val(datosSVC[10]);
							});
							$('#dialog1').dialog({
								autoOpen: true, modal: true, width: wi1, height: he1, title: titulo2, closeText: '', 
								closeOnEscape: true, dialogClass: '',
								buttons: { /*'Imprimir receta': function() { receta(datos1[4]); }, */ }, 
								open: function( event, ui ) {
									if(opcF==1){
										var datos = {aleatorio:aleF}
										$.post('../pacientes/files-serverside/datosFoto.php',datos).done(function( data ){ 
											var t = "<div style='background-image:url(../pacientes/fotos/files/"+data+"."+exteF+"?"+Math.round(Math.random()*1000)+");background-size:contain;background-repeat:no-repeat;background-position:center;background-color:white; width:100%; height:100%; cursor:;' class='conFoto' onClick=''></div>";
											$('#foto_usuario').html(t);
										});
									}
									$('#imprimirReceta').show();
									$('#imprimirReceta').button({icons:{primary:'ui-icon-print'}});
									$('#imprimirReceta').click(function(event) {
                                        event.preventDefault();
										receta(datos1[4]);
                                    });
									$('#tabs_c ul').removeClass('ui-widget-header');
									cargarSV(idP);
									//aquí va lo del expediente electrónico del paciente para la consulta
									$("#tabs-5").tabs({active: 0});
									$('#tabs-5 ul').removeClass('ui-widget-header');
								}, 
								close: function( event, ui ) {;$("#dialog1").tabs("destroy"); $('#dialog1').empty(); }
							});
						}else{
							$('#dialog1').dialog({ //Aquí está en estado PROCESO la consulta
								autoOpen: true, modal: true, width: wi1, height: he1, title: titulo2, closeText: '', 
								closeOnEscape: false, dialogClass: '',
								buttons: { /*'Guardar y finalizar': function() { }, 'Salir sin guardar': function() { } */ }, 
								open: function( event, ui ) {
									$('#imprimirNotaE').hide();
									$('#imprimirRecetaF').hide();
									$('#imprimirRecetaT').hide();
									$('#dialog1 #b_agregarSignosC,#dialog1 #b_dictamenC,#dialog1 #b_medicamentosC,#dialog1 #salvarConsulta,#dialog1 #finalizarConsulta,#dialog1 #hospitalizarP').show();
									$('#tabs_c ul').removeClass('ui-widget-header');
									$('#salvarConsulta, #salirSGconsulta, #finalizarConsulta').show();
									$('#imprimirReceta').hide();
									
									$('#salvarConsulta, #salirSGconsulta, #finalizarConsulta, #hospitalizarP').show();
									$('#salvarConsulta').button({ icons:{ primary:'ui-icon-disk' } });
									$('#finalizarConsulta').button({ icons:{ primary:'ui-icon-check' } });
									$('#salirSGconsulta').button({ icons:{ primary:'ui-icon-cancel' } });
									$('#salvarConsulta').click(function(e) {
                                        if($('#formConsulta').valid()){ salvarConsulta(datos1[4]); }
                                    });
									$('#salirSGconsulta').hide();
									$('#finalizarConsulta').click(function(e) {
                                        if($('#formConsulta').valid()){ finalizarConsulta(datos1[4]); }
                                    });
									$('#salirSGconsulta').click(function(e) { $('#dialog1').dialog('close'); });
									$('#tabs_c ul').removeClass('ui-widget-header');
									cargarSV(idP);
									//aquí va lo del expediente electrónico del paciente para la consulta
									$("#tabs-5").tabs({active: 0});
									$('#tabs-5 ul').removeClass('ui-widget-header');
								}, 
								close: function( event, ui ) {;$("#dialog1").tabs("destroy"); $('#dialog1').empty(); }
							});
						}
					} );
				}else{alert(data);}
			}); $('#dialog-preguntar').dialog('close');
		 }, 'No': function() { $('#dialog-preguntar').dialog('close'); }
		}
	});
	});
}); }

function miGrafo(tit, idP, idSV, vMin, vMax){ $(document).ready(function(e) {
	var datosGrafis = {idP:idP, idSV:idSV}
	$.post('files-serverside/datosChartsA.php',datosGrafis).done(function(data){ 
		var datosGra = data.split(';*');
		$('#dialog-graafis').dialog({ title:tit+datosGra[3] });
		var ctx = $("#myChartA").get(0).getContext("2d");
		
		var dataCH = { labels: ["",""],
			datasets: [
				{ 
					label: "PACIENTE", fillColor: "rgba(220,220,220,0)", strokeColor: "rgba(220,220,220,1)", 
					pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
					pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] 
				},
				{
					label:"MÍNIMO",fillColor:"rgba(111,87,205,0)", strokeColor: "rgba(151,187,205,1)",
					pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
					pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] 
				},
				{
					label:"MÁXIMO",fillColor:"rgba(121,187,205,0)", strokeColor: "rgba(151,187,205,1)",
					pointColor: "rgba(151,187,205,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", 
					pointHighlightStroke: "rgba(151,187,205,1)", data: [0, 0] 
				}
			]
		};
		var myNewChart = new Chart(ctx);
		var myLineChart = new Chart(ctx).Line(dataCH, {
			scaleShowGridLines:true,scaleGridLineColor:"rgba(0,0,0,.05)", scaleGridLineWidth : 1, scaleShowHorizontalLines: true, 
			scaleShowVerticalLines:true,bezierCurve:true,bezierCurveTension : 0.4, pointDot : true, pointDotRadius : 4, 
			pointDotStrokeWidth : 1, pointHitDetectionRadius : 20, datasetStroke : true, datasetStrokeWidth : 2, datasetFill : true,
			legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
		});
		var a=datosGra[1], subD=datosGra[1].split(','), subE=datosGra[0].split(',');
		for(var i = 0; i < datosGra[2]; i++){ 
			var b = i+1;  var a = subD[i]+','+vMin+', '+vMax; 
			var codeToRun='window.setTimeout(function(){myLineChart.addData(['+a+'], "'+subE[i]+'"); },'+b+'000);'; /*alert(codeToRun); */ 
			eval(codeToRun);
			if(datosGra[2]==1){
				var codeToRun1 = 'window.setTimeout(function(){myLineChart.addData(['+a+'], "'+subE[i]+'"); },'+b+'500);';eval(codeToRun1);
			}
			if(i==0){
				window.setTimeout(function(){myLineChart.removeData();window.setTimeout(function(){myLineChart.removeData();},100);},2100); 
			}
		}
	});
});}

function rDXi(idC,co,idP){$(document).ready(function(e){//idC es id concepto y co es el control para cargar la 1er nota ev
	var heR = $('#tabs-1hi').height(), wiR = $('#tabs-1hi').width() * 0.99, x1=idC; 
	$('#tabs-1hi, #tabs-2hi, #tabs-3hi, #tabs-4hi').css('font-size','0.8em');
	
	//Checamos si hay interpretación, imgs capturadas y/o de pacs
	//if(datos[0]<1){$('#tabs-1hi').html('<div>EL ESTUDIO NO CUENTA CON INTERPRETACIÓN</div>');}
	var datosHIm = {idVC:idC}
	$.post('files-serverside/checarIEI.php',datosHIm).done(function(data){//alert(data);
		var datos = data.split(';');
	
		if(datos[1]>0){ 
			$('#thi-2-1').show();
			$('#tabs-2hi').load("../imagen/htmls/fotografias.php",function(response,status,xhr){ if( status == "success" ){
				$('#b_subir_foto').remove();
				var oTableF, tamF = $('#dialog-historiales').height()-100;
				oTableF = $('#dataTableFotos').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
						$('span.DataTables_sort_icon').remove(); $('#dataTableMem_wrapper td').removeClass('sorting_1');
					},
					"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tamF, "bAutoWidth": false, 
					"bInfo": true, "bFilter": false, ordering: false,
					"aoColumns": [ {"bSortable":false},{"bSortable":false},{"bSortable":false},{"bVisible":false} ],
					"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
					"sDom": 't', "sAjaxSource": "../imagen/datatable-serverside/fotos.php",
					"fnServerParams":function(aoData, fnCallback){ var id_s = idC; aoData.push({"name": "id_s", "value": id_s });},
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "EL ESTUDIO NO CUENTA CON FOTOGRAFÍAS",
						"sInfo":"ENCONTRADAS: _END_","sInfoEmpty":"MOSTRADAS: 0","sInfoFiltered":"<br/>FOTOGRAFÍAS: _MAX_", "sSearch": "",
						"oPaginate": {
							"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
							"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
						}
					}
				}); $('#clickmeFo').click(function(e){oTableF.fnDraw();});
				$('#tah2').click(function(e) { $('#clickmeFo').click(); });
			} });
		}else{ $('#thi-2-1').hide(); }
		
		if(datos[2]>0){
			$('#miTabsIMG').append('<button class="ui-button ui-widget ui-corner-all" id="imagenesHPacs">IMÁGENES PACS</button>');
			$('#imagenesHPacs').click(function(event) {
				var url=window.location.href,myL=url.split('http://'),myL1=myL[1].split('/'),koby=myL1[0].split(':8888');
				window.open('http://'+koby[0]+':8080/oviyam2/viewer.html?patientID='+$('#idPacs').val());
			});
		}else{ }
	});
							
	if(idC!=''){
	$('#tabs-1hi').load("htmls/estudio_ultrasonidoH.php #tablaImpresion",function(response,status,xhr){ if( status == "success" ){
		if(co==0){ var datosC = { idP:idP, idC:idC, x:0 } }else{var datosC={idP:idP, idC:idC} }
		$.post('files-serverside/datosInterpretarHi.php',datosC).done(function(dataC){ //alert(idP); dataC es el id de la consulta
			$('#idControl').val(dataC); //alert($('#idControl').val());
			$('.histoi').each(function(index, element) { 
				if($(this).hasClass(dataC)){
				   $(this).parent().parent().addClass('marcadorLista');}
				   else{$(this).parent().parent().removeClass('marcadorLista');
				}
			});
		
			var datosNE = {idConsul:dataC, idPac: idP}
			$.post('files-serverside/datosInterpretarHi1.php',datosNE).done(function(data){
				var datosU = data.split(';*-');
				$('.myPacienteP').html(datosU[0]);
				$('.myReferenciaP').html(datosU[1]);
				$('.myEdadP').html(datosU[2]);
				$('.mySexoP').html(datosU[3]);
				$('.myFechaP').html(datosU[4]);
				$('.myDiagnosticoP').html(datosU[5]);//alert(data);
				$('.myNotaP').html(datosU[6]);
				$('.myMedicoP').html(datosU[7]);
				$('.myEstudioP').html(datosU[8]);
				$('.nombreDR').html(datosU[9]);
				$('.puestoDR').html('MÉDICO RADIÓLOGO');
				$('.cedula').html(datosU[10]);
				$('.myFnacP').html(datosU[14]);
				$('#idPacs').val(datosU[12]); //alert(datosU[12]);
				//$('.firmaDR').html('<img src="../usuarios/takePicture/firmas/'+datos[11]+'" width="" height="65">');
				if(datosU[15]==1){$('.dr').html('DRA.');}else if(datosU[15]==2){$('.dr').html('DR.');}			
			});
			
		});
	}});//alert(datosCo[0]);
	}else{$('#tabs-1hi').html('El paciente no cuenta con estudios de imagen');}
}); }

function cargarImagenesCanvas(i){
$("#deCanvas1").load("files-serverside/procesa.php?action=listFotos1&carpeta="+i,function(response,status,xhr){ if (status == "success" ){
		$('.eliminame1').click(function(event) { event.preventDefault(); });
		$('.eliminame1').button({ icons: { primary: "ui-icon-trash", }, text: false });
		$( ".en_reporte" ).button();
} }); 
window.setTimeout(function(){ $('#divCanvas1').css('height',$('#tabs-1hi').val()).css('overflow','scroll');},500);
}
function cargarImagenesCanvasE(i){
$("#deCanvas1").load("files-serverside/procesaE.php?action=listFotos1&carpeta="+i,function(response,status,xhr){ if (status == "success" ){
		$('.eliminame1').click(function(event) { event.preventDefault(); });
		$('.eliminame1').button({ icons: { primary: "ui-icon-trash", }, text: false });
		$( ".en_reporte" ).button();
} }); 
window.setTimeout(function(){ $('#divCanvas1').css('height',$('#tabs-1hi').val()).css('overflow','scroll');},500);
}
function cargarImagenesCanvasCo(i){
$("#deCanvas1").load("files-serverside/procesaCo.php?action=listFotos1&carpeta="+i,function(response,status,xhr){ if (status == "success" ){
		$('.eliminame1').click(function(event) { event.preventDefault(); });
		$('.eliminame1').button({ icons: { primary: "ui-icon-trash", }, text: false });
		$( ".en_reporte" ).button();
} }); 
window.setTimeout(function(){ $('#divCanvas1').css('height',$('#tabs-1hi').val()).css('overflow','scroll');},500);
}

function rDXu(idC,co,idP){$(document).ready(function(e){//idC es el id del vc y co es el control para cargar el 1er USG
	var heR = $('#tabs-1hi').height(), wiR = $('#tabs-1hi').width() * 0.99, x1=idC; //alert(idC);
	$('#tabs-1hi, #tabs-2hi, #tabs-3hi, #tabs-4hi').css('font-size','0.8em');
	if(idC!=''){
	$('#tabs-1hi').load("htmls/estudio_ultrasonidoH.php #tablaImpresion",function(response,status,xhr){ if( status == "success" ){
		if(co==0){ var datosC = { idP:idP, idC:idC, x:0 } }else{var datosC={idP:idP, idC:idC} }
		$.post('files-serverside/datosInterpretarHu.php',datosC).done(function(dataC){ //alert(idP); dataC es el id de la consulta
			$('#tabs-2hi').html('<div id="divCanvas1"> <table width="100%" style="background-color:white;" border="0" cellspacing="0" cellpadding="2"><tr> <td id="deCanvas1" align="center" valign="top" align="center"></td> </tr> </table> </div>'); //alert(idC);
			window.setTimeout(function(){cargarImagenesCanvas(idC);},700);
			
			$('.ocultaH').hide(); $('#idControl').val(dataC); //alert($('#idControl').val());
			$('.histou').each(function(index, element) { 
					if($(this).hasClass(dataC)){ $(this).parent().parent().addClass('marcadorLista');
					}else{$(this).parent().parent().removeClass('marcadorLista');
				}
			});
			var datosNE = {idConsul:dataC, idPac: idP}
			$.post('files-serverside/datosInterpretarHu1.php',datosNE).done(function(data){
				var datosU = data.split(';*-');
				$('.myPacienteP').html(datosU[0]); $('.myReferenciaP').html(datosU[1]);
				$('.myEdadP').html(datosU[2]); $('.mySexoP').html(datosU[3]);
				$('.myFechaP').html(datosU[4]); $('.myDiagnosticoP').html(datosU[5]);//alert(data);
				$('.myNotaP').html(datosU[6]); $('.myUnidadMedicaP').html('CLÍNICA SAN ANTONIO');
				$('.myMedicoP').html(datosU[7]); $('.myEstudioP').html(datosU[8]);
				$('.nombreDR').html(datosU[9]); $('.puestoDR').html('MÉDICO RADIÓLOGO');
				$('.cedula').html(datosU[10]); $('.myFnacP').html(datosU[14]);
				if(datosU[15]==1){$('.dr').html('DRA.');}else if(datosU[15]==2){$('.dr').html('DR.');}			
			});
		});
	}});//alert(datosCo[0]);
	}else{$('#tabs-1hi').html('El paciente no cuenta con estudios de ultrasonido');}
}); }

function rDXe(idC,co,idP){$(document).ready(function(e){//idC es el id del vc y co es el control para cargar el 1er USG
	var heR = $('#tabs-1hi').height(), wiR = $('#tabs-1hi').width() * 0.99, x1=idC; //alert(idC);
	$('#tabs-1hi, #tabs-2hi, #tabs-3hi, #tabs-4hi').css('font-size','0.8em');
	if(idC!=''){
	$('#tabs-1hi').load("htmls/estudio_ultrasonidoH.php #tablaImpresion",function(response,status,xhr){ if( status == "success" ){
		if(co==0){ var datosC = { idP:idP, idC:idC, x:0 } }else{var datosC={idP:idP, idC:idC} }
		$.post('files-serverside/datosInterpretarHe.php',datosC).done(function(dataC){ //alert(idP); dataC es el id de la consulta
			$('#tabs-2hi').html('<div id="divCanvas1"> <table style="background-color:white;" width="100%" border="0" cellspacing="0" cellpadding="2"><tr> <td id="deCanvas1" align="center" valign="top" align="center"></td> </tr> </table> </div>'); //alert(idC);
			window.setTimeout(function(){cargarImagenesCanvasE(idC);},700);
			
			$('.ocultaH').hide(); $('#idControl').val(dataC); //alert($('#idControl').val());
			$('.histou').each(function(index, element) { 
					if($(this).hasClass(dataC)){ $(this).parent().parent().addClass('marcadorLista');
					}else{$(this).parent().parent().removeClass('marcadorLista');
				}
			});
			var datosNE = {idConsul:idC, idPac: idP}
			$.post('files-serverside/datosInterpretarHe1.php',datosNE).done(function(data){
				var datosU = data.split(';*-');
				$('.myPacienteP').html(datosU[0]); $('.myReferenciaP').html(datosU[1]);
				$('.myEdadP').html(datosU[2]); $('.mySexoP').html(datosU[3]);
				$('.myFechaP').html(datosU[4]); $('.myDiagnosticoP').html(datosU[5]);//alert(data);
				$('.myNotaP').html(datosU[6]); $('.myUnidadMedicaP').html('CLÍNICA');
				$('.myMedicoP').html(datosU[7]); $('.myEstudioP').html(datosU[8]);
				$('.nombreDR').html(datosU[9]); $('.puestoDR').html('MÉDICO');
				$('.cedula').html(datosU[10]); $('.myFnacP').html(datosU[14]);
				if(datosU[15]==1){$('.dr').html('DRA.');}else if(datosU[15]==2){$('.dr').html('DR.');}			
			});
		});
	}});//alert(datosCo[0]);
	}else{$('#tabs-1hi').html('El paciente no cuenta con estudios de endoscopía');}
}); }

function rDXcol(idC,co,idP){$(document).ready(function(e){//idC es el id del vc y co es el control para cargar el 1er USG
	var heR = $('#tabs-1hi').height(), wiR = $('#tabs-1hi').width() * 0.99, x1=idC; //alert(idC);
	$('#tabs-1hi, #tabs-2hi, #tabs-3hi, #tabs-4hi').css('font-size','0.8em');
	if(idC!=''){
	$('#tabs-1hi').load("htmls/estudio_ultrasonidoH.php #tablaImpresion",function(response,status,xhr){ if( status == "success" ){
		if(co==0){ var datosC = { idP:idP, idC:idC, x:0 } }else{var datosC={idP:idP, idC:idC} }
		$.post('files-serverside/datosInterpretarHco.php',datosC).done(function(dataC){//alert(idP); dataC es el id de la consulta
			$('#tabs-2hi').html('<div id="divCanvas1"> <table style="background-color:white;" width="100%" border="0" cellspacing="0" cellpadding="2"><tr> <td id="deCanvas1" align="center" valign="top" align="center"></td> </tr> </table> </div>'); //alert(idC);
			window.setTimeout(function(){cargarImagenesCanvasCo(idC);},700);
			
			$('.ocultaH').hide(); $('#idControl').val(dataC); //alert($('#idControl').val());
			$('.histou').each(function(index, element) { //alert($(this).html());
					if($(this).parent().hasClass(dataC)){ $(this).parent().parent().addClass('marcadorLista');
					}else{$(this).parent().parent().removeClass('marcadorLista');
				}
			});
			var datosNE = {idConsul:idC, idPac: idP}
			$.post('files-serverside/datosInterpretarHe1.php',datosNE).done(function(data){
				var datosU = data.split(';*-');
				$('.myPacienteP').html(datosU[0]); $('.myReferenciaP').html(datosU[1]);
				$('.myEdadP').html(datosU[2]); $('.mySexoP').html(datosU[3]);
				$('.myFechaP').html(datosU[4]); $('.myDiagnosticoP').html(datosU[5]);//alert(data);
				$('.myNotaP').html(datosU[6]); $('.myUnidadMedicaP').html('CLÍNICA');
				$('.myMedicoP').html(datosU[7]); $('.myEstudioP').html(datosU[8]);
				$('.nombreDR').html(datosU[9]); $('.puestoDR').html('MÉDICO');
				$('.cedula').html(datosU[10]); $('.myFnacP').html(datosU[14]);
				if(datosU[15]==1){$('.dr').html('DRA.');}else if(datosU[15]==2){$('.dr').html('DR.');}			
			});
		});
	}});//alert(datosCo[0]);
	}else{$('#tabs-1hi').html('El paciente no cuenta con estudios de colposcopía');}
}); }

function rDXn(idC,co,idP){$(document).ready(function(e){//idC es el id del vc y co es el control para cargar la 1er nota CONSULTA
	var heR = $('#tabs-1hi').height(), wiR = $('#tabs-1hi').width() * 0.99, x1=idC; //alert(idC);
	$('#tabs-1hi, #tabs-2hi, #tabs-3hi, #tabs-4hi').css('font-size','0.8em');
	if(idC!=''){
	$('#tabs-1hi').load("htmls/nota_evolucion1.php #miNotaE",function(response,status,xhr){ if( status == "success" ){
		if(co==0){ var datosC = { idP:idP, idC:idC, x:0 } }else{var datosC={idP:idP, idC:idC} }
		$.post('files-serverside/datosCon.php',datosC).done(function(dataC){ //alert(idP); dataC es el id de la consulta
			$('#idControl').val(dataC); //alert($('#idControl').val());
			$('.histoc').each(function(index, element) { 
				if($(this).hasClass(dataC)){
				   $(this).parent().parent().addClass('marcadorLista');}else{$(this).parent().parent().removeClass('marcadorLista');
				}
			});
			var datosNE = {idConsul:dataC, idPac: idP}
			$.post('files-serverside/notaEvo.php',datosNE).done(function(data){
				var miDataNE = data.split(';*}-{');
				$('#nombrePNE').text(miDataNE[0]); $('#edadPNE').text(miDataNE[1]);
				$('#sexoPNE').text(miDataNE[2]); //$('#domicilioPNE').text(miDataNE[3]);
				$('#folioPNE').text(miDataNE[4]); $('#fechaNE').text(miDataNE[5]);
				$('#fcNE').text(miDataNE[6]); $('#frNE').text(miDataNE[7]); 
				$('#taNE').text(miDataNE[8]); $('#tempNE').text(miDataNE[9]); 
				$('#pesoNE').text(miDataNE[10]); $('#tallaNE').text(miDataNE[11]);
				$('#imcNE').text(miDataNE[12]); $('#notaNE').html(miDataNE[13]);
				$('#alergiasNE').text(miDataNE[14]); $('#doctorNE').html(miDataNE[15]);
				$('#especialidadesDRne').html(miDataNE[16]); $('.ocultoX1').hide();
				
				//para los DX
				$('#tabs-2hi').load("htmls/consultaH.php #dataTableDXh",function(response,status,xhr){if(status == "success"){
					var oTableDXh;
					oTableDXh = $('#dataTableDXh').dataTable({
						"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
							$('#tabs-2hi span.DataTables_sort_icon').remove();
						},
						"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs-2hi').height()-50, 
						"bAutoWidth": true, "bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
						"aoColumns": [{ "bSortable": false }, { "bSortable": false }], "iDisplayLength": 30000, 
						"bLengthChange": false, "bProcessing": true, "bServerSide": true, 
						"sAjaxSource": "datatable-serverside/diagnosticos1.php",
						"fnServerParams": function (aoData, fnCallback) { 
							var aleatorio = dataC; aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
						},
						"sDom": '<"filtroDX">l<"infoDX">r<"data_tDX"t>', 
						"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
						"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
						"sZeroRecords":"LA CONSULTA NO CUENTA CON DIAGNÓSTICOS","sInfo":"MOSTRADOS: _END_", 
						"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_","sSearch": "BUSCAR" }
					});/*fin datatable*/ $('#clickmeDXh').click(function(e) { oTableDXh.fnDraw(); });//FIn DT DX
					$('#tah2').click(function(e) { $('#clickmeDXh').click(); });
				}});
				//Para la receta (f)
				$('#tabs-3hi').load("htmls/receta1.php #miRecetaF",function(response,status,xhr){if( status == "success" ){
					var datosRF = {idConsul:dataC, idPac: idP}
					$.post('files-serverside/recetaF.php',datosRF).done(function(data){
						var miDataRF = data.split(';*}-{');
						$('#nombrePRF').text(miDataRF[0]); $('#edadPRF').text(miDataRF[1]);
						$('#sexoPRF').text(miDataRF[2]); $('#domicilioPRF').text(miDataRF[3]);
						$('#folioPRF').text(miDataRF[4]); $('#fechaRF').text(miDataRF[5]);
						$('#notaRF').html(miDataRF[13]); $('#doctorRF').html(miDataRF[15]);
						$('#especialidadesDRrf').html(miDataRF[16]); $('.ocultoX1').hide();
					});
				} });
			});
			//Para la receta (r)
				var datosRT = {idConsul:dataC, idPac: idP}
				$.post('files-serverside/recetaT.php',datosRT).done(function(data){
					var miDataRT = data.split(';*}-{'); //alert(miDataRT[13]);
					$('#tabs-4hi').html(miDataRT[13]).css('padding-top','5px');
				});
		});
	}});//alert(datosCo[0]);
	}else{$('#tabs-1hi').html('El paciente no cuenta con historial de notas médicas');}
}); }

function rDXno(idC,co,idP){$(document).ready(function(e){//idC es el id del concepto y co es el control para cargar la 1er nota de e de SERVICIOS
	var heR = $('#tabs-1hi').height(), wiR = $('#tabs-1hi').width() * 0.99, x1=idC; 
	$('#tabs-1hi, #tabs-2hi, #tabs-3hi, #tabs-4hi').css('font-size','0.8em'); //alert(idC);
	if(idC!=''){
	$('#tabs-1hi').load("htmls/nota_evolucion1.php #miNotaE",function(response,status,xhr){ if( status == "success" ){
		if(co==0){ var datosC = { idP:idP, idC:idC, x:0 } }else{var datosC={idP:idP, idC:idC} }
		$.post('files-serverside/datosOtrosS.php',datosC).done(function(dataC){ //alert(idP); dataC es el id de la consulta
			$('#idControl').val(dataC); //alert($('#idControl').val());
			$('.histoo').each(function(index, element) { 
				if($(this).hasClass(dataC)){
				   $(this).parent().parent().addClass('marcadorLista');}else{$(this).parent().parent().removeClass('marcadorLista');
				}
			});
			var datosNE = {idConsul:dataC, idPac: idP}
			$.post('files-serverside/notaEvo.php',datosNE).done(function(data){
				var miDataNE = data.split(';*}-{');
				$('#nombrePNE').html(miDataNE[0]); $('#edadPNE').html(miDataNE[1]);
				$('#sexoPNE').html(miDataNE[2]); //$('#domicilioPNE').text(miDataNE[3]);
				$('#folioPNE').html(miDataNE[4]); $('#fechaNE').html(miDataNE[5]);
				$('#fcNE').html(miDataNE[6]); $('#frNE').html(miDataNE[7]); 
				$('#taNE').html(miDataNE[8]); $('#tempNE').html(miDataNE[9]); 
				$('#pesoNE').html(miDataNE[10]); $('#tallaNE').html(miDataNE[11]);
				$('#imcNE').html(miDataNE[12]); $('#notaNE').html(miDataNE[13]);
				$('#alergiasNE').html(miDataNE[14]); $('#doctorNE').html(miDataNE[15]);
				
				//Para la receta (f)
				$('#tabs-3hi').load("htmls/receta1.php #miRecetaF",function(response,status,xhr){if( status == "success" ){
					var datosRF = {idConsul:dataC, idPac: idP}
					$.post('files-serverside/recetaF.php',datosRF).done(function(data){
						var miDataRF = data.split(';*}-{');
						$('#nombrePRF').html(miDataRF[0]); $('#edadPRF').html(miDataRF[1]);
						$('#sexoPRF').html(miDataRF[2]); $('#domicilioPRF').html(miDataRF[3]);
						$('#folioPRF').html(miDataRF[4]); $('#fechaRF').html(miDataRF[5]);
						$('#notaRF').html(miDataRF[13]); $('#doctorRF').html(miDataRF[15]);
						$('.ocultoX1').hide();
					});
				} });
			});
			//Para la receta (r)
				var datosRT = {idConsul:dataC, idPac: idP}
				$.post('files-serverside/recetaT.php',datosRT).done(function(data){
					var miDataRT = data.split(';*}-{'); //alert(miDataRT[13]);
					$('#tabs-4hi').html(miDataRT[13]).css('padding-top','5px');
				});
		});
	}});//alert(datosCo[0]);
	}else{$('#tabs-1hi').html('El paciente no cuenta con historial de servicios');}
}); }

function rDX1(idC,co,idP,n){$(document).ready(function(e){//idC es el id del estudio en vc y co es el control para cargar el primer estudio de laboratorio alert(idC);
	//alert(n);
	var heR = $('#tabs-1hi').height(), wiR = $('#tabs-1hi').width() * 0.99, x1=idC; //alert(n);
	if(co==0){
		var datosL = { idP:idP, idC:idC }
		$.post('files-serverside/datosLab.php',datosL).done(function(dataL){
			var datoL = dataL.split('{;}');
			if(datoL[1] == 8){// Es pdf
				var x='../laboratorio/takeArchivos/pdf/'+idC+'.pdf';
				$("#tabs-1hi").load('../laboratorio/htmls/miPDF.php #tablaMiPDF', function( response, status, xhr ) { 
					if ( status == "success" ) { $('a.media').media({width:wiR, height:heR-35, src:x}); } 
				});
			}else{
				$("#tabs-1hi").load('../laboratorio/htmls/capturar.php #fichaProcesar', function( response, status, xhr ) {
					if ( status == "success" ) {
						$('#cargaPDF').hide(); $('#idPacientePro').val(idP); $('#idEstudioPro').val(idC); 
						var datoP = {idP:idP, idE:idC}
						$.post('../laboratorio/archivos_save_ajax/datosCapturar.php', datoP).done(function( data ) { 
							var datosP = data.split('*}');
							$('#pacientePro,.myPacienteP').text(datosP[0]);$('#ordenPro, .myReferenciaP').text(datosP[1]); 
							$('#observacionPro').text(datosP[4]);
							$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); 
							$('.myNotaToma').html('<em>OBSERVACIONES</em>: '+datosP[8]);
							$('.myEstudioP').text(datosP[2]); $('.myFnacP').text(datosP[9]); $('.mySexoP').text(datosP[10]);
							$('.myEdadP').text('EDAD: '+datosP[11]+' - '); $('.myFechaP').text(datosP[12]); 
							$('.myMedicoP').text(datosP[13]); $('.dr').text(datosP[18]); $('.myUnidadMedicaP').text(datosP[19]);
							$('.nombreDR').text(datosP[14]); $('.cedula').text(datosP[15]);$('.myMuestraP').text(datosP[16]+'. ');
							$('.myMetodoP').text(datosP[17]); $('.myNoEstudio').text(datosP[20]);
							$('.firmaDR').html('');
							if(datosP[21]!='.png' || datosP[21]!='.jpg'){
							 $('.firmaDR').html('<img src="../usuarios/takePicture/firmas/'+datosP[21]+'" width="" height="75">');
							}
							$("#misResultados").load('../laboratorio/files-serverside/interpretarResultados.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) { $('.ocultarX').hide(); } });
							//aquí hacer que cuando sea la bh cambie de archivo para imprimir los resultados
							switch(n){
								case 'BIOMETRIA HEMATICA':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosBH.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) { $('#fichaProcesar, #tablaImpresion').css('font-size','0.75em'); } });
									$("#misResultados").load('../laboratorio/files-serverside/pre_imprimirResultadosBH.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'EXAMEN GENERAL DE ORINA':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosEGO.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosEGO.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'COPROLOGICO':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosCoprologico.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosCoprologico.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'COPROPARASITOSCOPICO UNICO':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio1.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio1.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'COPROPARASITOSCOPICO (2M)':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio2.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio2.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'COPROPARASITOSCOPICO SERIADO':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio3.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'COPROPARASITOSCOPIO (3)':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio3.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								default:
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultados.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) { 
										$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em'); 
									} });
							}
			
							var miTitle = 'IMPRIMIR - '+datosP[2]+'- '+datosP[1];
							
							var tamHX = $('#referencia').height() - 95; var tamWX = $('#referencia').width() * 0.98;
							$('#dialog-procesar').dialog({
								autoOpen: true, modal: true, width: 880, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', 
								title: miTitle, dialogClass: 'no-close',
								close: function( event, ui ) { $('#dialog-procesar').dialog('destroy'); },
								buttons: {
									Imprimir: function(){
										$('#dialog-impresion').show(); 
										$('#tablaImpresion *').not( document.getElementsByClassName('metod') ).css('font-size','1.01em');
										$('#notaF').css('font-size','0.8em'); 
										$('#dialog-impresion').printElement(); $('#dialog-impresion').hide();
									},
									Editar: function() { 
										$('#dialog-editar').dialog({
											autoOpen: false, modal: true, width: 750, height: 270, resizable: false, closeOnEscape: true,
											closeText:'', title: "EDITAR LA INTERPRETACIÓN",
											buttons: {
												Editar: function(){ 
													if($('#editarInterpretacionC').prop('checked')==false){
														$('#errorEditar').show('shake');
														window.setTimeout(function(){$('#errorEditar').hide();},1000);
													}else{
														var dato = { idE:b, idU:$('#idUser').val() }
														$.post('../laboratorio/files-serverside/editarInterpretacion.php', dato).done(function( data ) {
															if(data==1){
																$('#dialog-editar').dialog('close');
																$('#clickme').click();
																//dialog-confirmacion
																$('#dialog-confirmacion').dialog({
																	autoOpen: true, modal: true, width: 600, height: 150, resizable: false, 
																	closeOnEscape: true, 
																	closeText:'', title: "EDICIÓN LISTA", dialogClass: '',
																	open: function( event, ui ) {
																		$('#textoConfirma').text('!El estudio está listo para edición!');
																		window.setTimeout(function(){
																			$('#dialog-confirmacion').dialog('close');
																			var a_1 = a, b_1 = b, n_1 = n;
																			$('#dialog-procesar').dialog('close');
																			interpretar(a_1,b_1,n_1);
																		},2000);
																	},
																	buttons: ''
																});
															}else{alert(data);}
														});
													}
												},
												Cancelar: function() { $(this).dialog("close"); }
											},
											open: function( event, ui ) {
												$('.estudioEdit').text(datosP[2]);$('.referenciaEdit').text(datosP[1]);
												$('.pacienteEdit').text(datosP[0]);
											},
											close: function( event, ui ) {document.getElementById('formEdita').reset();}
										});//fin del dialog editar //alert($('#accesoU').val());
										if($('#accesoU').val()==1 || $('#accesoU').val()==6){$('#dialog-editar').dialog('open');}
										else{$('#dialog-alertar').dialog('open');}
									},
									Cerrar: function() { $(this).dialog("close"); }
								}
							});
						});
					}
					});
			}
		});
		$('#idControl').val(idC);
		$('.histol').each(function(index, element) { //alert(idC);
			if($(this).hasClass(idC)){
			   $(this).parent().parent().addClass('marcadorLista');}else{$(this).parent().parent().removeClass('marcadorLista');
			}
		});
	}else{// aquí entra sólo en la primera vez
		var datosL = { idP:idP, idC:idC }
		$.post('files-serverside/datosLab.php',datosL).done(function(dataL){
			var datoL = dataL.split('{;}'); //alert(datoL[0]);
			var x='../laboratorio/takeArchivos/pdf/'+datoL[0]+'.pdf';
			if(idC!=''){
				//Hay que diferenciar con el estatus si es capturado entonces esta guardado como pdf y de lo contrario autorizado
				if(datoL[1] == 8){// Es pdf
					$("#tabs-1hi").load('../laboratorio/htmls/miPDF.php #tablaMiPDF', function( response, status, xhr ) { 
						if ( status == "success" ) { $('a.media').media({width:wiR, height:heR-35, src:x}); } 
					});
				}else{
					$("#tabs-1hi").load('../laboratorio/htmls/capturar.php #fichaProcesar', function( response, status, xhr ) {
					if ( status == "success" ) {
						$('#cargaPDF').hide(); $('#idPacientePro').val(idP); $('#idEstudioPro').val(idC); var datoP = {idP:idP, idE:idC}
						$.post('../laboratorio/archivos_save_ajax/datosCapturar.php', datoP).done(function( data ) { 
							var datosP = data.split('*}');
							$('#pacientePro,.myPacienteP').text(datosP[0]);$('#ordenPro, .myReferenciaP').text(datosP[1]); 
							$('#observacionPro').text(datosP[4]);
							$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); 
							$('.myNotaToma').html('<em>OBSERVACIONES</em>: '+datosP[8]);
							$('.myEstudioP').text(datosP[2]); $('.myFnacP').text(datosP[9]); $('.mySexoP').text(datosP[10]);
							$('.myEdadP').text('EDAD: '+datosP[11]+' - '); $('.myFechaP').text(datosP[12]); 
							$('.myMedicoP').text(datosP[13]); $('.dr').text(datosP[18]); $('.myUnidadMedicaP').text(datosP[19]);
							$('.nombreDR').text(datosP[14]); $('.cedula').text(datosP[15]);$('.myMuestraP').text(datosP[16]+'. ');
							$('.myMetodoP').text(datosP[17]); $('.myNoEstudio').text(datosP[20]);
							$('.firmaDR').html('');
							if(datosP[21]!='.png' || datosP[21]!='.jpg'){
							 $('.firmaDR').html('<img src="../usuarios/takePicture/firmas/'+datosP[21]+'" width="" height="75">');
							}
							$("#misResultados").load('../laboratorio/files-serverside/interpretarResultados.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('.ocultarX').hide();} });
							//aquí hacer que cuando sea la bh cambie de archivo para imprimir los resultados
							switch(n){
								case 'BIOMETRIA HEMATICA':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosBH.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) { $('#fichaProcesar, #tablaImpresion').css('font-size','0.75em'); } });
									$("#misResultados").load('../laboratorio/files-serverside/pre_imprimirResultadosBH.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'EXAMEN GENERAL DE ORINA':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosEGO.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosEGO.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'COPROLOGICO':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosCoprologico.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosCoprologico.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'COPROPARASITOSCOPICO UNICO':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio1.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio1.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'COPROPARASITOSCOPICO (2M)':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio2.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio2.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'COPROPARASITOSCOPICO SERIADO':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio3.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								case 'COPROPARASITOSCOPIO (3)':
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio3.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
									$("#misResultados").load('../laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
								break;
								default:
									$(".myDiagnosticoP").load('../laboratorio/files-serverside/imprimirResultados.php?idE='+idC, function(response,status,xhr){if ( status == "success" ) { 
										$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em'); 
									} });
							}
			
							var miTitle = 'IMPRIMIR - '+datosP[2]+'- '+datosP[1];
							
							var tamHX = $('#referencia').height() - 95; var tamWX = $('#referencia').width() * 0.98;
							$('#dialog-procesar').dialog({
								autoOpen: true, modal: true, width: 880, height: tamHX, resizable: false, closeOnEscape: false, 
								closeText:'', title: miTitle, dialogClass: 'no-close',
								close: function( event, ui ) { $('#dialog-procesar').dialog('destroy'); },
								buttons: {
									Imprimir: function(){
										$('#dialog-impresion').show(); 
										$('#tablaImpresion *').not( document.getElementsByClassName('metod') ).css('font-size','1.01em');
										$('#notaF').css('font-size','0.8em'); 
										$('#dialog-impresion').printElement(); $('#dialog-impresion').hide();
									},
									Editar: function() { 
										$('#dialog-editar').dialog({
											autoOpen: false, modal: true, width: 750, height: 270, resizable: false, closeOnEscape: true,
											closeText:'', title: "EDITAR LA INTERPRETACIÓN",
											buttons: {
												Editar: function(){ 
													if($('#editarInterpretacionC').prop('checked')==false){
														$('#errorEditar').show('shake');
														window.setTimeout(function(){$('#errorEditar').hide();},1000);
													}else{
														var dato = { idE:b, idU:$('#idUser').val() }
														$.post('../laboratorio/files-serverside/editarInterpretacion.php', dato).done(function( data ) {
															if(data==1){
																$('#dialog-editar').dialog('close');
																$('#clickme').click();
																//dialog-confirmacion
																$('#dialog-confirmacion').dialog({
																	autoOpen: true, modal: true, width: 600, height: 150, resizable: false, 
																	closeOnEscape: true, 
																	closeText:'', title: "EDICIÓN LISTA", dialogClass: '',
																	open: function( event, ui ) {
																		$('#textoConfirma').text('!El estudio está listo para edición!');
																		window.setTimeout(function(){
																			$('#dialog-confirmacion').dialog('close');
																			var a_1 = a, b_1 = b, n_1 = n;
																			$('#dialog-procesar').dialog('close');
																			interpretar(a_1,b_1,n_1);
																		},2000);
																	},
																	buttons: ''
																});
															}else{alert(data);}
														});
													}
												},
												Cancelar: function() { $(this).dialog("close"); }
											},
											open: function( event, ui ) {
												$('.estudioEdit').text(datosP[2]);$('.referenciaEdit').text(datosP[1]);
												$('.pacienteEdit').text(datosP[0]);
											},
											close: function( event, ui ) {document.getElementById('formEdita').reset();}
										});//fin del dialog editar //alert($('#accesoU').val());
										if($('#accesoU').val()==1 || $('#accesoU').val()==6){$('#dialog-editar').dialog('open');}
										else{$('#dialog-alertar').dialog('open');}
									},
									Cerrar: function() { $(this).dialog("close"); }
								}
							});
						});
					}
						$('#idControl').val(datoL[0]); //alert(datoL[0]);
						$('.histol').each(function(index, element) { 
							if($(this).hasClass(datoL[0])){
							   $(this).parent().parent().addClass('marcadorLista');}
							   else{$(this).parent().parent().removeClass('marcadorLista');
							}
						});
					});
				}
			}else{$("#tabs-1hi").html('El paciente no cuenta con estudios de laboratorio');}
		});
	}
}); }

function rDX(idC,no,nP,f,a,r){$(document).ready(function(e){//idC es el id del concepto y no es el tipo de concepto.VER EL RESULTADO
	if(no == 1){var c = 'CONSULTA.';}else{var c = 'ESTUDIO.';}
	var heR = $('#referencia').height() - 95, wiR = $('#referencia').width() * 0.96, tituloR = c+' PACIENTE: '+nP+'. '+f;
	
	$('#dialog-rDX').dialog({
		autoOpen: false, modal: true, width: wiR, height: heR, title: tituloR, closeText: '', 
		closeOnEscape: true, dialogClass: '',
		buttons: { /*'Guardar y finalizar': function() { }, 'Salir sin guardar': function() { }*/ }, 
		open: function( event, ui ) { },
		close: function( event, ui ) { 
			$('#dialog-rDX').empty();
		}
	});
	
	switch(no){
		case 1://consulta
			$("#dialog-rDX").load("htmls/consultaH.php #tabs_c_h", function(response,status,xhr){if ( status == "success" ) { 
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
					"bLengthChange": false, "bProcessing": true, "bServerSide": true, 
					"sAjaxSource": "datatable-serverside/diagnosticos.php",
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
				autoOpen: true, 
				buttons: { /*'Guardar y finalizar': function() { }, 'Salir sin guardar': function() { }*/ }, 
				close: function( event, ui ) {  $("#dialog-rDX").tabs("destroy"); }
			});
		break;
		case 2://Estudio de endoscopía o laboratorio
			var x1=idC, x='../laboratorio/takeArchivos/pdf/'+idC+'.pdf'; 
			$("#dialog-rDX").load('../laboratorio/htmls/miPDF.php #tablaMiPDF', function( response, status, xhr ) { 
			if ( status == "success" ){ $('a.media').media({width:wiR, height:heR-35, src:x}); } });
			$('#dialog-rDX').dialog('open');
		break;
		case 3://Estudio de imagen
			$("#dialog-rDX").load("htmls/estudio_imagenH.php #tabs_i_h", function(response,status,xhr){if( status == "success" ) {
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
				var serie = 'http://sigma-csa.noip.me:8080/oviyam2/viewer.html?patientID='+r;
				var url = window.location.href;
				var myL = url.split('http://');
				var myL1 = myL[1].split('/'); var koby = myL1[0].split(':8888'); //alert(myL1[0]);
				var link_1 = koby[0]+koby[1];
				//var serie = 'http://'+myL1[0]+':8080/oviyam2/viewer.html?patientID='+r;
				var serie = 'http://'+link_1+':8080/oviyam2/viewer.html?patientID='+r;
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
function historiaCvacia(idP,control){ $(document).ready(function(e) {/*si control es 1 al cerrar la ventana abre VerHC*/
	$("#dialog").load("htmls/historia_clinica.php #tabs_hc", function( response, status, xhr ) {if( status == "success" ){ 
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
		
		var he1 = $('#referencia').height() - $('.botones').height() - 30, wi1 = $('#referencia').width() * 0.96, 
		titulo1 = 'HISTORIA CLÍNICA. PACIENTE: '+datos[0];
		$('#dialog').dialog({
			autoOpen:true,modal:true,width:wi1,height:he1,title:titulo1,closeText:'', closeOnEscape: true,
			buttons: { /*'Actualizar': function() { }, 'Cancelar': function() { $('#dialog').dialog('close'); }*/ },
			open: function( event, ui ) { 
				$('#tabs_hc ul').removeClass('ui-widget-header');
				$('#updateHC').click(function(event) {
                    event.preventDefault();
					var datosHC = $('#formHistoriaClinica').serialize();
					$.post('files-serverside/actualizarHC.php',datosHC).done(function(data){ if(data==1){
						$('#texto-informar').text('La historia clínica se ha guardado correctamente.');$('#dialog').dialog('close');
						$('#dialog-informar').dialog({autoOpen:true,modal:true,width:500,height:150, buttons:{},
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
	var imc; 
	imc=redondear((parseFloat(a)/(parseFloat(b)*parseFloat(b))),2); 
	if (imc>0 & imc<10000){ 
		document.getElementById('imcSV').value=imc;
	}else{ document.getElementById('imcSV').value=''; } 
}
function imc1(a,b){
	var imc; 
	imc=redondear((parseFloat(a)/(parseFloat(b)*parseFloat(b))),2); 
	if (imc>0 & imc<10000){ 
		$('.miDvisSV #imcSV').val(imc);
	}else{ $('.miDvisSV #imcSV').val(''); } 
}

function signosVvacios(idP,control){ $(document).ready(function(e) {//si control es 1 al cerrar la ventana abre VerSignos
	$("#dialog").load("htmls/signos_vitales.php #tabs_sv", function( response, status, xhr ) {if( status == "success" ){ 
		$('#tabs_sv #tabs-1-1').text('SIGNOS VITALES');
		$('#idUsuario_sv').val($('#idUser').val()); $('#formSignosVitales').validate({ignore: 'hidden'});
		$('#dialog input, #dialog select, #dialog textarea').addClass('campoITtab'); $(".miDvisSV").tabs({active: 0}); 
		$('#dialog #tabs-4-1').hide(); $('#dialog #tabs-5-1').hide();
		$("#dialog").css('overflow','hidden'); //alert(control);
		var datosIDP = {idP:idP,idC:1}
	  $.post('files-serverside/datosSV.php',datosIDP).done(function(data){ 
	  	var datos = data.split(';*-'); 
		$('.miDvisSV #pacienteSV').val(datos[0]); $('.miDvisSV #edadSV').val(datos[1]); $('.miDvisSV #sexoSV').val(datos[2]);
		
		var he1 = $('#referencia').height() - 95, wi1 = $('#referencia').width() * 0.98, 
		titulo1 = 'NUEVOS SIGNOS VITALES. PACIENTE: '+datos[0];
		$('#dialog').dialog({
			autoOpen: true, modal: true, width: wi1, height: he1, title: titulo1, closeText: '', closeOnEscape: false, 
			dialogClass: 'no-close',
			buttons: { /*'Guardar': function() { }, 'Cancelar': function() { } */}, 
			open: function( event, ui ) { //$('#dialog1').dialog('close');
				$('#tabs_sv ul').removeClass('ui-widget-header'); 
				$('#dialog #tomarNSV,#dialog #tabs-2-1,#dialog #tabs-3-1').hide(); $('#cancelNSV,#saveNSV').show();
				
				$('.miDvisSV #pesoSV').keyup(function(e){
					if($(this).val()>0 & $(this).val()<650){ imc1($(this).val(),$('.miDvisSV #tallaSV').val()); }
				});
				$('.miDvisSV #tallaSV').keyup(function(e){
					if($(this).val()>0 & $(this).val()<3){imc1($('.miDvisSV #pesoSV').val(),$(this).val());}
				});
				
				$('#cancelNSV').click(function(event) { 
					event.preventDefault(); 
					$('#dialog').dialog('close');
				});

				$('#cancelNSV').button({ icons:{ primary:'ui-icon-cancel' } });
				
				$('#saveNSV').click(function(event) { 
					event.preventDefault(); 
					if($('#formSignosVitales').valid()){
					var datosSsv={
						idPx1:idP,idU:$('#idUser').val(),peso:$('.miDvisSV #pesoSV').val(),
						talla:$('.miDvisSV #tallaSV').val(),cintura:$('.miDvisSV #cinturaSV').val(),imc:$('.miDvisSV #imcSV').val(),
						t:$('.miDvisSV #tSV').val(),a:$('.miDvisSV #aSV').val(),fr:$('.miDvisSV #frSV').val(),
						fc:$('.miDvisSV #fcSV').val(), temp:$('.miDvisSV #tempSV').val(), notas:$('.miDvisSV #notasSV').val()
					}
					$.post('files-serverside/guardarSV.php',datosSsv).done(function(data){ 
						if(data==1){ $('#clickme').click();
							if(control==2){
								$('#pesoC, #tabs-6 #pesoSV').val($('.miDvisSV #pesoSV').val());
								$('#tallaC, #tabs-6 #tallaSV').val($('.miDvisSV #tallaSV').val());
								$('#imcC, #tabs-6 #imcSV').val($('.miDvisSV #imcSV').val());
								$('#cinturaC, #tabs-6 #cinturaSV').val($('.miDvisSV #cinturaSV').val());
								$('#tC, #tabs-6 #tSV').val($('.miDvisSV #tSV').val());
								$('#aC, #tabs-6 #aSV').val($('.miDvisSV #aSV').val());
								$('#frC, #tabs-6 #frSV').val($('.miDvisSV #frSV').val());
								$('#fcC, #tabs-6 #fcSV').val($('.miDvisSV #fcSV').val());
								$('#tempC, #tabs-6 #tempSV').val($('.miDvisSV #tempSV').val());
								$('#notasC, #tabs-6 #notasSV').val($('.miDvisSV #notasSV').val());
								$('#fechaSignosC').val($('#fechaHoy').val());
							}
							$('#texto-informar').text('Los signos vitales se han guardado correctamente.');
							$('#dialog').dialog('close');
							$('#dialog-informar').dialog({
								title:'DATOS GUARDADOS',modal:true,autoOpen:true,closeText:'',width:600, height:200,
								closeOnEscape:true,dialogClass:'', buttons:{},
								open:function(event,ui){
									window.setTimeout(function(){$('#dialog-informar').dialog('close');},2500);
								} 
							});
						}
						else{alert(data);}
					}); }//fin valid
				});
				$('#saveNSV').button({ icons:{ primary:'ui-icon-disk' } });
			}, 
			close: function( event, ui ){ $(".miDvisSV").tabs("destroy"); }
		});
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
		$('#tabs-2-1s').click(function(e) {
			$('#miIMC').text($('#imcSV').val()); $('#miMedidaCintura').text($('#cinturaSV').val());
			if( $('#imcSV').val() >= 18.5 & $('#imcSV').val() < 25 ){
				$('.normalIMC').addClass('formatoRangosIMC');
				$('#miRiesgoP').text('no está en riesgo latente');
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){ $('.imc_1_1').addClass('formatoRangosIMC'); }
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
				$('#miRiesgoP').text('tiene riesgo alto');
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
				$('#miRiesgoP').text('tiene riesgo muy alto');
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
				$('#miRiesgoP').text('tiene riesgo extremadamente alto');
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
		$('#tabs-3-1s').click(function(e) {
			if( $('#imcSV').val() >= 18.5 & $('#imcSV').val() < 25 ){
				$('#recomendacionRN').show();
				$('#recomendacionSP, #recomendacionOB').hide();
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){ $('#miRiesgoE').text('sin riesgo'); }
					else if( $('#cinturaSV').val() > 80 ){ $('#miRiesgoE').text('con riesgo alto'); } 
					else{ }
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){ $('#miRiesgoE').text('sin riesgo'); }
					else if( $('#cinturaSV').val() > 90 ){ $('#miRiesgoE').text('con riesgo alto'); } 
					else{ }
				}
			} 
			else if( $('#imcSV').val() >= 25 & $('#imcSV').val() < 30 ){
				$('#recomendacionSP').show();
				$('#recomendacionRN, #recomendacionOB').hide();
				if($('#sexoSV').val()=='FEMENINO'){
					if( $('#cinturaSV').val() < 80 ){ $('#miRiesgoE').text('con riesgo moderado'); }
					else if( $('#cinturaSV').val() > 80 ){ $('#miRiesgoE').text('con riesgo alto'); }
					else{ }
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){ $('#miRiesgoE').text('con riesgo moderado'); }
					else if( $('#cinturaSV').val() > 90 ){ $('#miRiesgoE').text('con riesgo alto'); }
					else{ }
				}
			} 
			else if( $('#imcSV').val() >= 30 & $('#imcSV').val() < 35 ){
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
					if( $('#cinturaSV').val() < 80 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto'); }
					else if( $('#cinturaSV').val() > 80 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto'); } 
					else{ }
				}else if($('#sexoSV').val()=='MASCULINO')
				{
					if( $('#cinturaSV').val() < 90 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto'); }
					else if( $('#cinturaSV').val() > 90 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto'); }
					else{ }
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
			"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs_sv').height()-70, "bAutoWidth": true, 
			"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
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

function verSignosV(idPa){$(document).ready(function(e) {
	$("#dialog").load("htmls/signos_vitales.php #tabs_sv", function( response, status, xhr ) {if( status == "success" ){ 
		$('#idUsuario_sv').val($('#idUser').val()); 
		$('#dialog input, #dialog select, #dialog textarea').addClass('campoITtab'); $("#dialog").tabs({active: 0});
		
		graficasSV(idPa,0);
		
		var datosIDPa = {idP:idPa, idC:1}
		$.post('files-serverside/datosSV.php',datosIDPa).done(function(data){ 
			var datos3 = data.split(';*-'); $('#pacienteSV').val(datos3[0]);$('#edadSV').val(datos3[1]);$('#sexoSV').val(datos3[2]);
			$('#pesoSV').val(datos3[3]);$('#tallaSV').val(datos3[4]);$('#imcSV').val(datos3[5]);$('#cinturaSV').val(datos3[6]);
			$('#tSV').val(datos3[7]);$('#aSV').val(datos3[8]);
			$('#frSV').val(datos3[9]);$('#fcSV').val(datos3[10]);$('#tempSV').val(datos3[11]);$('#notasSV').val(datos3[12]);
			
			var he1 = $('#referencia').height() - $('.botones').height() - 30, wi1 = $('#referencia').width() * 0.96, 
				titulo = 'SIGNOS VITALES. FECHA: '+datos3[13]+' PACIENTE: '+datos3[0];
			
			$('#dialog').dialog({
				autoOpen:true,modal:true,width:wi1,height:he1,title:titulo,closeText:'',closeOnEscape: true,dialogClass: '',
				buttons:{ /*'Nuevos': function() { }, 'Cerrar': function() { $('#dialog').dialog('close'); } */ }, 
				open:function(event,ui){ //PAra calcular los riesgos y recomendaciones
					$('#tabs-2-1').click(function(e) {
						$('#miIMC').text($('#imcSV').val()); $('#miMedidaCintura').text($('#cinturaSV').val());
                        if( $('#imcSV').val() >= 18.5 & $('#imcSV').val() < 25 ){
							$('.normalIMC').addClass('formatoRangosIMC');
							$('#miRiesgoP').text('no está en riesgo latente');
							if($('#sexoSV').val()=='FEMENINO'){
								if( $('#cinturaSV').val() < 80 ){
									$('.imc_1_1').addClass('formatoRangosIMC');
								}else if( $('#cinturaSV').val() > 80 ){
									$('.imc_1_2').addClass('formatoRangosIMC');
								}
								else{$('.imc_1_1, .imc_1_2').removeClass('formatoRangosIMC');}
							}else if($('#sexoSV').val()=='MASCULINO')
							{
								if( $('#cinturaSV').val() < 90 ){
									$('.imc_1_1').addClass('formatoRangosIMC');
								}else if( $('#cinturaSV').val() > 90 ){
									$('.imc_1_2').addClass('formatoRangosIMC');
								}
								else{$('.imc_1_1, .imc_1_2').removeClass('formatoRangosIMC');}
							}
						} 
						else if( $('#imcSV').val() >= 25 & $('#imcSV').val() < 30 ){
							$('.sobrepesoIMC').addClass('formatoRangosIMC');
							$('#miRiesgoP').text('tiene riesgo moderado');
							if($('#sexoSV').val()=='FEMENINO'){
								if( $('#cinturaSV').val() < 80 ){
									$('.imc_2_1').addClass('formatoRangosIMC');
								}else if( $('#cinturaSV').val() > 80 ){
									$('.imc_2_2').addClass('formatoRangosIMC');
								}
								else{$('.imc_2_1, .imc_2_2').removeClass('formatoRangosIMC');}
							}else if($('#sexoSV').val()=='MASCULINO')
							{
								if( $('#cinturaSV').val() < 90 ){
									$('.imc_2_1').addClass('formatoRangosIMC');
								}else if( $('#cinturaSV').val() > 90 ){
									$('.imc_2_2').addClass('formatoRangosIMC');
								}
								else{$('.imc_2_1, .imc_2_2').removeClass('formatoRangosIMC');}
							}
						} 
						else if( $('#imcSV').val() >= 30 & $('#imcSV').val() < 35 ){
							$('.obesidad1IMC').addClass('formatoRangosIMC');
							$('#miRiesgoP').text('tiene riesgo alto');
							if($('#sexoSV').val()=='FEMENINO'){
								if( $('#cinturaSV').val() < 80 ){
									$('.imc_3_1').addClass('formatoRangosIMC');
								}else if( $('#cinturaSV').val() > 80 ){
									$('.imc_3_2').addClass('formatoRangosIMC');
								}
								else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
							}else if($('#sexoSV').val()=='MASCULINO')
							{
								if( $('#cinturaSV').val() < 90 ){
									$('.imc_3_1').addClass('formatoRangosIMC');
								}else if( $('#cinturaSV').val() > 90 ){
									$('.imc_3_2').addClass('formatoRangosIMC');
								}
								else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
							}
						} 
						else if( $('#imcSV').val() >= 35 & $('#imcSV').val() < 40 ){
							$('.obesidad2IMC').addClass('formatoRangosIMC');
							$('#miRiesgoP').text('tiene riesgo muy alto');
							if($('#sexoSV').val()=='FEMENINO'){
								if( $('#cinturaSV').val() < 80 ){
									$('.imc_3_1').addClass('formatoRangosIMC');
								}else if( $('#cinturaSV').val() > 80 ){
									$('.imc_3_2').addClass('formatoRangosIMC');
								}
								else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
							}else if($('#sexoSV').val()=='MASCULINO')
							{
								if( $('#cinturaSV').val() < 90 ){
									$('.imc_3_1').addClass('formatoRangosIMC');
								}else if( $('#cinturaSV').val() > 90 ){
									$('.imc_3_2').addClass('formatoRangosIMC');
								}
								else{$('.imc_3_1, .imc_3_2').removeClass('formatoRangosIMC');}
							}
						} 
						else if( $('#imcSV').val() >= 40 ){
							$('.obesidad3IMC').addClass('formatoRangosIMC');
							$('#miRiesgoP').text('tiene riesgo extremadamente alto');
							if($('#sexoSV').val()=='FEMENINO'){
								if( $('#cinturaSV').val() < 80 ){
									$('.imc_4_1').addClass('formatoRangosIMC');
								}else if( $('#cinturaSV').val() > 80 ){
									$('.imc_4_2').addClass('formatoRangosIMC');
								}
								else{$('.imc_4_1, .imc_4_2').removeClass('formatoRangosIMC');}
							}else if($('#sexoSV').val()=='MASCULINO')
							{
								if( $('#cinturaSV').val() < 90 ){
									$('.imc_4_1').addClass('formatoRangosIMC');
								}else if( $('#cinturaSV').val() > 90 ){
									$('.imc_4_2').addClass('formatoRangosIMC');
								}
								else{$('.imc_4_1, .imc_4_2').removeClass('formatoRangosIMC');}
							}
						} else{$('.sobrepesoIMC').removeClass('formatoRangosIMC'); }
                    });
					$('#tabs-3-1').click(function(e) {
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
						else if( $('#imcSV').val() >= 40 ){
							$('#recomendacionOB').show();
							$('#recomendacionRN, #recomendacionSP').hide();
							if($('#sexoSV').val()=='FEMENINO'){
								if( $('#cinturaSV').val() < 80 ){
									$('#miRiesgoE').text('con  riesgo extremadamente alto');
								}else if( $('#cinturaSV').val() > 80 ){
									$('#miRiesgoE').text('con  riesgo extremadamente alto');
								} else{ }
							}else if($('#sexoSV').val()=='MASCULINO')
							{
								if( $('#cinturaSV').val() < 90 ){
									$('#miRiesgoE').text('con  riesgo extremadamente alto');
								}else if( $('#cinturaSV').val() > 90 ){
									$('#miRiesgoE').text('con  riesgo extremadamente alto');
								} else{ }
							}
						} else{ }
                    });
					
					$('#tomarNSV').show(); $('#cancelNSV,#saveNSV').hide();

					$('#tomarNSV').click(function(event) { 
						event.preventDefault(); 
						$('#dialog').dialog('close'); 
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
	} });//Fin fe load signos vitales
}); } //Fin signos vitales dialog

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
		$.post('files-serverside/datosCharts.php',datosCHa).done(function(data){ var datosCH1 = data.split(';*');  
		var ctx = $("#myChartIMC").get(0).getContext("2d"); 
		//alert(datosCH1[1]); // This will get the first returned node in the jQuery collection.
			var dataCH = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
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
		$.post('files-serverside/datosChartsTA.php',datosCHa).done(function(data){ var datosCH2 = data.split(';*');  var ctxTA = $("#myChartTA").get(0).getContext("2d"); //alert(datosCH2[3]); // This will get the first returned node in the jQuery collection.
			var dataCH2 = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
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
		$.post('files-serverside/datosChartsFR.php',datosCHa).done(function(data){ var datosCH3 = data.split(';*');  var ctxFR = $("#myChartFR").get(0).getContext("2d"); //alert(datosCH1[1]); // This will get the first returned node in the jQuery collection.
			var dataCH3 = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
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
		$.post('files-serverside/datosChartsFC.php',datosCHa).done(function(data){ var datosCH4 = data.split(';*');  var ctxFC = $("#myChartFC").get(0).getContext("2d"); //alert(datosCH1[1]); // This will get the first returned node in the jQuery collection.
			var dataCH4 = { labels: ["",""],
				datasets: [
					{ label: "PACIENTE", fillColor: "rgba(220,220,220,0)", strokeColor: "rgba(220,220,220,1)", pointColor: "rgba(220,220,220,1)", pointStrokeColor: "#fff", pointHighlightFill: "#fff", pointHighlightStroke: "rgba(220,220,220,1)", data: [0,0] },
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


function ver_logo(nombre_img, name_s, exte, time,titulo,carpeta,id_doc,que_es){ $(document).ready(function(e) {
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel2').dialog({
		autoOpen: true, modal: true, width: w, height:h, title: titulo+' DEL ESTUDIO '+ name_s, closeText: '',
		open:function( event, ui ){
			$("#dialog-nivel2").load('../pacientes/htmls/miPDFdocs.php #tablaMiPDF', function( response, status, xhr ) { 
				if ( status == "success" ) { //alert(exte);
					if(exte != 'pdf' & exte != 'PDF'){
						x='../imagen/'+carpeta+'/files/'+id_doc+'.'+exte+'?'+time;
						$('#mi_documento').html('<img src='+x+' style="max-width:750px; border:5px solid white; border-radius:4px; background-color:rgba(255, 255, 255, 1);">');
					}else{
						x='../imagen/'+carpeta+'/files/'+id_doc+'.pdf';
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
}); }
</script>
