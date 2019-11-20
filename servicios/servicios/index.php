<?php require_once('../../Connections/horizonte.php'); ?>
<?php
//initialize the session
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
	
  $logoutGoTo = "../../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
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

$MM_restrictGoTo = "../../index.php";
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

if($row_usuario['acceso_u']==6){ }

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
<link rel="shortcut icon" href="../../imagenes/general/favicon.ico">
<meta charset="utf-8">
<title>SERVICIOS MÉDICOS</title>

<link href="../../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link href="../../DataTables-1.10.5/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../../jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">

<script src="../../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../../DataTables-1.10.5/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../../funciones/js/caracteres.js"></script>
<script src="../../funciones/js/calcula_edad.js"></script>
<script src="../../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../../jquery-ui-1.11.4/external/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../../funciones/js/jquery.printElement.min.js"></script>
<script type="text/javascript" src="../../jQuery-TE_v.1.4.0/uncompressed/jquery-te-1.4.0.js" charset="utf-8"></script>

<script language="javascript">
//para las tooltips
$( document ).tooltip({
	position: {
		my: "center bottom-20",	at: "center top",
		using: function( position, feedback ) {
			$( this ).css( position );
			$( "<div>" ).addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this );
		}
	}
});
$(document).ready(function() {	
	$('#formGenerales').validate({ ignore: 'hidden',
		rules:{ telmovilP:{ required:true, minlength: 4, "remote": { url: 'files-serverside/checkClaveEst.php', type: "post", data: { clave:function() { return $('#telmovilP').val(); } }, data: { idEs:function() { return $('#idPacienteN').val(); } } } } },
		messages:{ telmovilP:{ required:'Debe ingresar la clave del Estudio.', minlength:'La clave del estudio debe ser de por lo menos 4 dígitos.', remote:'¡Esta clave pertenece a un estudio registrado!' } }
	});
});
</script>

<script>
$(document).ready(function(e) {
	var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 160;
	var wi = $('#referencia').width() * 0.96;
	$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
	$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
	
	$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-90);
				
	$( window ).resize(function(e) {
		var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 160;
		var wi = $('#referencia').width() * 0.96;
		$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
		$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
		
		$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-90);
    });
	
	var cuadrado = 35;
	$('button').css('width',cuadrado).css('height',cuadrado);
	$('#addConvenio').button({ icons: { primary: "ui-icon-plusthick" }, text: false });
	
	$('form').submit(function(event) { event.preventDefault(); });
	
	$('#input').jqte();
	
	//datos iniciales
	$("#departamentoE").load('files-serverside/genera_departamentoI.php');
	
	$("#areasE").load('files-serverside/genera_areas.php');
	$('#input').jqteVal('');
	$('.jqte_editor').css('height',$('#dialog-confirmarNuevoPaciente').height()*0.7);
	
});
</script>

<script>
  $.widget( "ui.timespinner", $.ui.spinner, {
	options: { // seconds
	  step: 60 * 1000, // hours
	  page: 60
	},
	_parse: function( value ) {
      if ( typeof value === "string" ) { // already a timestamp
        if ( Number( value ) == value ) { return Number( value ); }
        return +Globalize.parseDate( value );
      }
      return value;
    },
	_format: function( value ) { return Globalize.format( new Date(value), "t" ); }
  });
</script>

<script>
function nuevoPaciente(){ $(document).ready(function(e) {
$("#dialog-confirmarNuevoPaciente").load("htmls/ficha_servicio.php #ficha_servicio",function(response,status,xhr){
	if(status=="success"){
		$("#miSucursalNS").load('../../pacientes/genera/genera_sucursales_ov.php?idU='+$('#idUser').val(),function(response,status,xhr){
			if (status = "success"){
				var datosUS = {idU:$('#idUser').val()}
				$.post('files-serverside/datosSucursalU.php',datosUS).done(function(data){ $("#miSucursalNS").val(data); });
			}
		});
	
		$('#formServicio').css('height',$("#dialog-confirmarNuevoPaciente").height()-20);
		
		var he=$('#referencia').height()-100, wi = $('#referencia').width() * 0.97;
	
		$('#dialog-confirmarNuevoPaciente').dialog({
			title:'NUEVO SERVICIO MÉDICO', modal:true,autoOpen:true,closeText:'', width: wi, height: he, closeOnEscape: false,
			dialogClass: 'no-close',
			buttons: {
			"GUARDAR": function() {
				if($('#formServicio').valid()){ 
					var datosP = $('#formServicio').serialize();
					$.post('files-serverside/addServicio.php',datosP).done(function( data ) {
						if (data==1){
							$('#clickme').click();
							$('#dialog-confirmarNuevoPaciente').dialog('close');
							$('#dialog-confirmaAltaPaciente').dialog('open');
						}
						else{alert(data);}
					});
				}
			},
			"CANCELAR": function() { $(this).dialog('close'); }
		  },
		  open:function( event, ui ){
			$('#formServicio').validate({ignore: 'hidden'}); $('#idUsuarioS').val($('#idUser').val());
			$('#departamentoS').load('genera/departamentosServicios.php', function( response, status, xhr ){ });
			
			$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
			$('#dialog-confirmarNuevoPaciente textarea').css('height','99%'); 
			},
		  close:function( event, ui ){ $('#dialog-confirmarNuevoPaciente').empty(); }
		});
	} 
});
}); }

function cambiarTabuSer(idSer,idSu){ $(document).ready(function(e) {
	var datos ={idS:idSer, idSucursal:idSu}
	$.post('files-serverside/fichaServicio.php',datos).done(function(data1) { 
		var datosI = data1.split('*}');
		$("#precioMe").val(datosI[3]);$('#precioMe1').val(datosI[4]);
		$('#precioS').val(datosI[1]);$("#precioUrgenciaS").val(datosI[2]);
	});
}); }

function verPaciente(x){ $(document).ready(function(e) { //asignamos el id del estudio
$("#dialog-confirmarNuevoPaciente").load("htmls/ficha_servicio.php #ficha_servicio",function(response, status, xhr) {
	if ( status == "success" ) {
		
		$("#miSucursalNS").load('../../pacientes/genera/genera_sucursales_ov.php?idU='+$('#idUser').val(),function(response,status,xhr){
			if (status = "success"){
				$("#miSucursalNS").val($('#miSucursal').val());
				var datos ={idS:x, idSucursal:$('#miSucursal').val()}
				$.post('files-serverside/fichaServicio.php',datos).done(function(data1) { 
					var datosI = data1.split('*}');
		
					var he = $('#referencia').height() - 100, wi = $('#referencia').width() * 0.96;
					var title = 'FICHA DEL SERVICIO. '+datosI[0];
					$('#dialog-confirmarNuevoPaciente').dialog({
						title:title,modal:true,autoOpen:true,closeText:'',width:wi,height:he,closeOnEscape:true,dialogClass:'',
						buttons: {
						"ACTUALIZAR": function() {
							if($('#formServicio').valid()){
								var datosS = $('#formServicio').serialize();
								$.post('files-serverside/updateServicio.php',datosS).done(function( data ) {
									if (data==1){//si el paciente se Actualizó 
										$('#dialog-confirmarNuevoPaciente').dialog('close');$('#clickme').click();
										$('#dialog-confirmaAltaPaciente').dialog('open');
									} else{alert(data);}
								});
							}
						}, "CERRAR": function() { $(this).dialog('close'); }
					  },
					  open:function( event, ui ){ $('#idServicio').val(x); $('#formServicio').validate({ignore: 'hidden'});
							$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
							$('#dialog-confirmarNuevoPaciente textarea').css('height','99%');
							
							$('#departamentoS').load('genera/departamentosServicios.php', function( response, status, xhr ){
								$("#departamentoS").val(datosI[1]);
							});
							$('#nombreS').val(datosI[0]);$("#precioMe").val(datosI[3]);$('#precioMe1').val(datosI[4]);
							$('#precioS').val(datosI[1]);$("#precioUrgenciaS").val(datosI[2]);
							
							$('#miSucursalNS').change(function(e){ cambiarTabuSer(x,$(this).val()); });
						}, close:function( event, ui ){ $("#dialog-confirmarNuevoPaciente").empty(); }
					});
				});
			}
		});
		
		$('#formServicio').css('height',$("#dialog-confirmarNuevoPaciente").height()-20);
	}
});
}); }//fin verFicha
</script>

<script>
$(document).ready(function(e){
	setInterval(function(){$.post('../../remote_files/refresh_session.php'); },500000);
	$('#miMenu').hide(); $('#verMenu').click(function(e){window.location='../../menu.php?menu=ms';}); 
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
<input name="sucursalOV" type="hidden" id="sucursalOV" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="today" id="today" type="hidden" value="<?php echo date("d/m/Y"); ?>">

<div id="header" class="header">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../../imagenes/iconitos/_servicios.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">SERVICIOS</span></td>
        <td width="1%" nowrap valign="middle">
        	<span id="dispara_menu">
            	<?php if($row_usuario['foto_u'] == 1){?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="21">
                <?php }else{?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="21">
                <?php }?>
            	<?php echo $row_usuario['usuario_u']; ?> <span class="ui-icon ui-icon-triangle-1-s"></span>
            </span>
        </td>
        <td width="100" nowrap align="left"> </td>
      </tr>
    </table>
</div>

<div class="contenido" id="contenido" align="center" style="padding-top:7px;">
  <table width="90%" height="100%" border="0" cellpadding="5" cellspacing="0" id="dataTablePrincipal" class="tablilla">
    <thead id="cabecera_tBusquedaPrincipal">
      <tr class="titulos_dataceldas">
      	<th id="clickme" align="center">#</th>
        <th align="center">SERVICIO</th>
        <th align="center" nowrap>PRECIO</th>
     	<th align="center" nowrap>PRECIO URGENCIA</th>
      </tr>
    </thead>
    <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
        <tr>
            <th><input name="sX" type="hidden" value=""></th>
            <th><input name="CServicio" id="CServicio" type="text" class="search_init campos_b_t" placeholder="-Servicio-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sX1" type="hidden" value=""></th>
            <th><input name="sX2" type="hidden" value=""></th>
        </tr>
    </tfoot>
  </table>
</div>

<div id="dialog-confirmarNuevoPaciente" style="display:none;"> </div>

<div id="dialog-confirmaAltaPaciente" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle" height="100%">LOS DATOS DEL SERVICIO SE HAN GUARDADO SATISFACTORIAMENTE</td> </tr> </table> </div>

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
	var asInitVals = new Array();
	
	var oTableP;
	var tamP = $('#referencia').height() - 160;
	oTableP = $('#dataTablePrincipal').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
		"bJQueryUI": true,ordering: false, "bScrollCollapse": true, "sScrollY": tamP, "bAutoWidth": false, "bStateSave": true,
		"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [
			{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
		],
		"iDisplayLength": 5000, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
		"sDom": '<"toolbar"><"filtro1Principal">lr<"data_tPrincipal"t><"infoPrincipal">S',
		"sAjaxSource": "datatable-serverside/servicios.php",
		"fnServerParams":function(aoData, fnCallback){ 
			var de = $("#miSucursal").val();
			aoData.push({"name": "idSu", "value": de });
		},
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
			"sInfo": "ENCONTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>SERVICIOS: _MAX_", "sSearch": "",
			"oPaginate": {
       			"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
				"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
      		}
		}
		
	});
	$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right;'><table id='ocultarFP' style='float:right;' width='' border='0' cellspacing='0' cellpadding='6'> <tr><td><select name='miSucursal' id='miSucursal'></select></td> <td><button id='addPacientePrincipal' onClick='nuevoPaciente()' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title='Agregar un nuevo servicio médico'><span class='ui-icon ui-icon-plus'></span>B</button></td> </tr> </table></div>" );
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { /* Filter on the column (the index) of this element */ oTableP.fnFilter( this.value, $("tfoot input").index(this) ); });
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus( function () { if ( this.className == "search_init" ) { this.className = ""; this.value = ""; } } );
     
    $("tfoot input").blur( function (i) { 
		if(this.value=="") { this.className = "search_init campos_b_t"; this.value = asInitVals[$("tfoot input").index(this)]; } 
	} );
	//fin filtros individuales por campo de texto
		
	$('.paginacionPrincipal').hide();
			
	$('#clickme').click(function(e) { oTableP.fnDraw(); });
	
	$("#miSucursal").load('../../pacientes/genera/genera_sucursales_ov.php?idU='+$('#idUser').val(), function(response,status,xhr){
		if (status = "success"){
			var datosUS = {idU:$('#idUser').val()}
			$.post('files-serverside/datosSucursalU.php',datosUS).done(function(data){ 
				$("#miSucursal").val(data); $('#clickme').click();
				$("#miSucursal").change(function(e) { $('#clickme').click(); });
			});
		}
	});

});
</script>

<script>
$(document).ready(function(e) {
	var he1 = $('#referencia').height() - 100, wi1 = $('#referencia').width() * 0.97;
	
	$('#dialog-confirmaAltaPaciente').dialog({
		autoOpen: false, modal: true, width: 620, height:150, title: 'DATOS GUARDADOS', closeText: '',
		open:function( event, ui ){
			$('#dialog-confirmarNuevoPaciente').dialog('close');
			window.setTimeout(function(){$('#dialog-confirmaAltaPaciente').dialog('close');},2500);
		}
	});
    $('#dialog-verPaciente').dialog({autoOpen:false,modal:true,width:wi1,height:he1, title: 'FICHA DEL ESTUDIO', closeText: '' });
});
</script>