<?php require_once('../Connections/horizonte.php'); ?>
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
	
  $logoutGoTo = "../index.php";
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

if($row_usuario['acceso_u']==6){ }

mysql_select_db($database_horizonte, $horizonte);
$query_nombreSucursalUsuario = sprintf("SELECT nombre_su FROM seguros WHERE clave_su = %s", GetSQLValueString($row_usuario['idSucursal_u'], "text"));
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
<title>SEGUROS</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">
<link href="../DataTables-1.10.2/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">

<script src="../jquery-ui-1.12.1/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.1/jquery-ui.js"></script>
<script src="../jquery-ui-1.12.1/external/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../jquery-ui-1.12.1/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.12.1/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../DataTables-1.10.2/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.2/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/calcula_edad.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../jQuery-TE_v.1.4.0/uncompressed/jquery-te-1.4.0.js" charset="utf-8" type="text/javascript"></script>
<script src="../funciones/js/jquery.media.js"></script> 
<script src="../funciones/js/stdlib.js"></script>
<script src="../jq-file-upload-9.12.5/js/jquery.iframe-transport.js"></script>
<script src="../jq-file-upload-9.12.5/js/jquery.fileupload.js"></script>

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
</script>

<script>
$(document).ready(function(e) {
	//Refrescamos la sesión para que no caduque, aunque no se refresque la ventana
	setInterval(function(){$.post('../remote_files/refresh_session.php'); },500000);
	
	$('#verMenu').click(function(e){window.location='../menu.php?menu=ma';}); 
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
	
	var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 160;
	var wi = $('#referencia').width() * 0.96;
	$("#dialog-nivel1").tabs({active: 0});
	$("#dialog-nivel1").css('width',wi).css('height',he);
	
	$('.miTab').css('height', $('#dialog-nivel1').height() - 75).css('width',$('#dialog-nivel1').width()-90);
	$('.tabs').css('width',wi/7.2);
				
	$( window ).resize(function(e) {
		var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 160;
		var wi = $('#referencia').width() * 0.96;
		$("#dialog-nivel1").tabs({active: 0});
		$("#dialog-nivel1").css('width',wi).css('height',he);
		
		$('.miTab').css('height', $('#dialog-nivel1').height() - 75).css('width',$('#dialog-nivel1').width()-90);
		$('.tabs').css('width',wi/7.2);
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
	$('.jqte_editor').css('height',$('#dialog-nivel1').height()*0.7);
	
});
</script>

<script>
  $.widget( "ui.timespinner", $.ui.spinner, {
	options: {
	  // seconds
	  step: 60 * 1000,
	  // hours
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

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="sucursalU" type="hidden" id="sucursalU" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="indicePaciente" type="hidden" id="indicePaciente">
<input name="sucursalOV" type="hidden" id="sucursalOV" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="today" id="today" type="hidden" value="<?php echo date("d/m/Y"); ?>">
<input name="tit_mem" id="tit_mem" type="hidden" value="">

<div id="header" class="header ver_menu">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_sucursales.png" height="40"></td>
        <td align="left" valign="middle" nowrap><span id="verMenu" style="cursor:pointer;">SUCURSALES</span></td>
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

<div class="contenido" id="contenido" align="center" style="margin-top:23px;">
  <table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" id="dataTablePrincipal" class="tablilla">
    <thead id="cabecera_tBusquedaPrincipal">
      <tr class="titulos_dataceldas">
        <th id="clickme" align="center" width="1px">#</th>
        <th align="center" width="70px">CLAVE</th>
        <th align="center" nowrap>SUCURSAL</th>
     	<th align="center" nowrap width="15%">LOCALIDAD</th>
        <th align="center" nowrap width="10px">#USUARIOS</th>
        <th align="center" nowrap width="10px">#PACIENTES</th>
        <th align="center" nowrap width="1px">LOGO</th>
        <th align="center" nowrap width="1px">FOTOS</th>
        <th align="center" nowrap width="1px">MEMBRETES</th>
        <th align="center" nowrap width="1px">DOCS</th>
      </tr>
    </thead>
    <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
        <tr>
            <th><input name="sX" type="hidden" value="" class="search_init"></th>
            <th><input name="sClave" id="sClave" type="text" class="search_init campos_b_t" placeholder="-Clave-" autofocus/></th>
            <th><input name="sSucursal" id="sSucursal" type="text" class="search_init campos_b_t" placeholder="-Sucursal-"/></th>
            <th><input name="sLocali" id="sLocali" type="text" class="search_init campos_b_t" placeholder="-Localidad-"/></th>
            <th><input name="sX2" type="hidden" value="" class="search_init"></th>
            <th><input name="sX3" type="hidden" value="" class="search_init"></th>
            <th><input name="sX4" type="hidden" value="" class="search_init"></th>
            <th><input name="sX5" type="hidden" value="" class="search_init"></th>
            <th><input name="sX6" type="hidden" value="" class="search_init"></th>
            <th><input name="sX7" type="hidden" value="" class="search_init"></th>
        </tr>
    </tfoot>
  </table>
</div>

<div id="dialog-nivel1" class="dialogos"></div> 
<div id="dialog-nivel2" class="dialogos"></div>
<div id="dialog-nivel3" class="dialogos"></div>
<div id="dialog-auxiliar" class="dialogos"></div>

<div id="dialog-confirmarAlgo" class="dialogos"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2"> <tr> <td align="center" valign="middle"><span id="textoAlgo"></span></td> </tr> </table> </div>

<div id="dialog-confirmaAltaPaciente" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle" height="100%">LOS DATOS DE LA SUCURSAL SE HAN GUARDADO SATISFACTORIAMENTE</td> </tr> </table> </div>

<div id="dialog-verPaciente" align="right" style="display:none;"> </div>

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
	
	var oTableP, tamP = $('#referencia').height() - 155;
	oTableP = $('#dataTablePrincipal').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
			$('span.DataTables_sort_icon').remove();
			$('#dataTablePrincipal_wrapper td').removeClass('sorting_1');
		},
		"bJQueryUI": true,ordering: false, "bScrollCollapse": true, "sScrollY": tamP, "bAutoWidth": false, "bStateSave": true,
		"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [
			{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
			{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false}
		],
		"iDisplayLength": 50, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
		"sDom": '<"toolbar"><"filtro1Principal">lr<"data_tPrincipal"t><"infoPrincipal">S',
		"sAjaxSource": "datatable-serverside/seguros.php",
		"fnServerParams":function(aoData, fnCallback){
			var idU = $('#idUser').val();
			aoData.push({"name": "idU", "value": idU });
		},
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
			"sInfo": "ENCONTRADAS: _END_", "sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "<br/>CONSULTAS: _MAX_", "sSearch": "",
			"oPaginate": {
       			"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
				"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
      		}
		}
	});
	
	$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right;'><table id='ocultarFP' style='float:right;' width='' border='0' cellspacing='0' cellpadding='6'> <tr> <td><button id='addPacientePrincipal' onClick='nuevaSucursal()' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title='Agregar una nueva sucursal'><span class='ui-icon ui-icon-plusthick'></span>a </button></td> </tr> </table></div>" );
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { /* Filter on the column (the index) of this element */ oTableP.fnFilter( this.value, $("tfoot input").index(this) ); });
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus( function () { if ( this.className == "search_init" ) { this.className = ""; this.value = ""; } } );
     
    $("tfoot input").blur( function (i) { 
		if(this.value=="") { this.className = "search_init campos_b_t"; this.value = asInitVals[$("tfoot input").index(this)]; } 
	} );
	//fin filtros individuales por campo de texto
	
	//ponemos los botones de reset y de añadir un paciente de la tabla principal de busqueda de pacientes
	$("div.toolbar").css('white-space','nowrap').css('border','1px none red').css('padding','10px');
		
	var busquedaP = $('.filtro1Principal');
	var data_tP = $('#dataTablePrincipal tbody');
	var info_tP = $('.infoPrincipal *');
	var reseteP = $('#resetePrincipal');
	var div_botonesP = $('.botonesPrincipal');
	var paginacionesP = $('.paginacionPrincipal');
	var cabeceraP = $('#cabecera_tBusquedaPrincipal');
			
	paginacionesP.hide();
	
	$('#clickme').click(function(e) { oTableP.fnDraw(); });

});
</script>

<script>
$(document).ready(function(e) {
	var he1 = $('#referencia').height() - 100, wi1 = $('#referencia').width() * 0.97;
	
	$('#dialog-confirmaAltaPaciente').dialog({
		autoOpen: false, modal: true, width: 620, height:150, title: 'DATOS GUARDADOS', closeText: '',
		open:function( event, ui ){
			$('#dialog-nivel1').dialog('close');
			window.setTimeout(function(){$('#dialog-confirmaAltaPaciente').dialog('close');},2500);
		}
	});
    $('#dialog-verPaciente').dialog({autoOpen:false,modal:true,width:wi1,height:he1, title: 'FICHA DEL ESTUDIO', closeText: '' });
});
</script>

<script>
function reset_tab(a,idS){ $(document).ready(function(e) { var ok=0;
	$('#dialog-nivel2').dialog({
		autoOpen: false, modal: true, width: 550, height:270, title: 'CONFIRMAR', closeText: '', dialogClass: 'no-close',
		closeOnEscape:false, draggable:false, resizable: false, 
		open:function( event, ui ){
			$('#dialog-nivel2').html('<form action="" method="post" name="formResetTabu" id="formResetTabu" target="_self" style="height:100%;"><table border="0" cellpading="0" cellspacing="0" width="100%" height="100%"><tr><td align="justify"><button class="ui-button ui-widget ui-corner-all ui-button-icon-only" title="" style="font-size:0.7em;"><span class="ui-icon ui-icon-alert"></span> Button with icon only</button>Esta acción reiniciará totalmente al tabulador seleccionado. Para continuar debe ingresar su contraseña de administrador y dar click en CONFIRMAR</td></tr><tr><td><input maxlength="20" name="contrasenaU" id="contrasenaU" type="password" class="required" placeholder="Ingrese su contraseña"></td></tr></table></form>');
			$('#formResetTabu').validate(); $('#dialog-nivel2 .ui-button').click(function(event) { event.preventDefault(); });
			$('#contrasenaU').addClass('campoITtab');
		},
		buttons: {
			"Confirmar": function() {
				if($('#formResetTabu').valid()){
					var datos = {
						para:a, idU:$('#idUser').val(), pass:$('#contrasenaU').val(), p_t_i:$('#p_t_i').val(),
						p_t_l:$('#p_t_l').val(), p_t_s:$('#p_t_s').val(), tipo_tab_i:$('#tab_img').val(),
						tipo_tab_l:$('#tab_lab').val(), idS:idS, usuario: $('#idUser').val()
					}
					$.post('files-serverside/reset_tabulador.php',datos).done(function(data){
						if(data==0){ $('#dialog-nivel2').parent().effect( "shake", "slow" );$('#contrasenaU').focus(); }
						else if(data==1){
							$('#dialog-nivel2').html('<form action="" method="post" name="formResetTabu" id="formResetTabu" target="_self" style="height:100%;"><table border="0" cellpading="0" cellspacing="0" width="100%" height="100%"><tr><td align="center" valign="middle"><h2>¡EL TABULADOR SE HA REINICIADO SATISFACTORIAMENTE!</h2></td></tr></table></form>');
							$('#dialog-nivel2').dialog({
								buttons:'', height:200, title:'¡CONFIRMACIÓN!'
							});
							window.setTimeout(function(){
								$("#dialog-nivel1").dialog('close');$('#dialog-nivel2').dialog('close');verSucursal(idS);
							},1800);
						}
						else{alert(data);}
					});
				}
			}, "Cancelar": function() { $(this).dialog('close'); $('#dialog-nivel2').html(''); }
		},
	});
	
	switch (a){
		case 'i':
			if($('#tab_img').val()==null || $('#tab_img').val() == ''){ $('#tab_img').click(); }
			else{ ok = 1; }
		break;
		case 'l':
			if($('#tab_lab').val()==null || $('#tab_lab').val() == ''){ $('#tab_lab').click(); }
			else{ ok = 1; }
		break;
		case 's':
			ok = 1;
		break;
		case 't':
			if(($('#tab_lab').val()==null || $('#tab_lab').val()=='') || ($('#tab_img').val()==null || $('#tab_img').val()=='')){
				$('#tab_img').click();
			} else{ ok = 1; }
		break;
		default:
			ok = 0;
	}
	if(ok == 1){
		$('#dialog-nivel2').dialog('open');
	}
}); }

function verSucursal(x){ $(document).ready(function(e) {
$("#dialog-nivel1").load("htmls/ficha_sucursal.php #ficha_sucursal",function(response,status,xhr){ if(status=="success"){
	
	$('#celda_maqui_i').append('&nbsp;<button lang="i" onClick="reset_tab(this.lang,'+x+');" class="ui-button ui-widget ui-corner-all ui-button-icon-only" title="Reiniciar el tabulador" style="font-size:0.7em;"><span class="ui-icon ui-icon-refresh"></span> Button with icon only</button>');
	
	$('#tabu_lab').append('&nbsp;<button lang="l" onClick="reset_tab(this.lang,'+x+');" class="ui-button ui-widget ui-corner-all ui-button-icon-only" title="Reiniciar el tabulador" style="font-size:0.7em;"><span class="ui-icon ui-icon-refresh"></span> Button with icon only</button>&nbsp;');
	
	$('#celda_maqui_s').append('&nbsp;<button lang="s" onClick="reset_tab(this.lang,'+x+');" class="ui-button ui-widget ui-corner-all ui-button-icon-only" title="Reiniciar el tabulador" style="font-size:0.7em;"><span class="ui-icon ui-icon-refresh"></span> Button with icon only</button>');
	
	$('#reset_all').append('&nbsp;<button lang="t" onClick="reset_tab(this.lang,'+x+');" class="ui-button ui-widget ui-corner-all" title="Reiniciar todos los tabuladores" style="font-size:0.7em;"><span class="ui-icon ui-icon-refresh"></span> Reiniciar tabuladores</button>');
	
	$('.ui-button').click(function(event) { event.preventDefault(); });
	
	$('#idSucursal').val(x);
	 var datos ={idC:x}
	 $.post('files-serverside/fichaSucursal.php',datos).done(function( data1 ) {
		var datosI = data1.split('*}');

		var he = $('#referencia').height() - 90, wi = $('#referencia').width() * 0.98;
		
		var title = 'FICHA DE LA SUCURSAL '+datosI[2];
		$('#dialog-nivel1').dialog({
			title:title,modal:true,autoOpen:true,closeText:'', width: wi, height: he, closeOnEscape: true, dialogClass: '',
			buttons: {
			"Actualizar": function() {
				if($('#formSucursal').valid()){
					var datosP = $('#formSucursal').serialize();
					$.post('files-serverside/updateSucursal.php',datosP).done(function( data ) {
						if (data==1){
							$('#dialog-nivel1').dialog('close');$('#clickme').click();
							$('#dialog-confirmaAltaPaciente').dialog('open');
						} else{alert(data);}
					});
				}
			}, "Cancelar": function() { $(this).dialog('close'); }
		  },
		  open:function( event, ui ){
			$("#ficha_sucursal").tabs({active: 0}); $('#pestanas').removeClass('ui-widget-header');  
			$('#dialog-nivel1 input, #dialog-nivel1 select, #dialog-nivel1 textarea').addClass('campoITtab');
			$('#dialog-nivel1 textarea').css('height','99%'); $('#idUsuarioNC').val($('#idUser').val());
			
			$('#formSucursal').css('height',$('#dialog-nivel1').height()-0);
			
			//Lunes
			var h_lunes_e = parseFloat(datosI[18].split(':')[1]) + parseFloat(datosI[18].split(':')[0] * 60);
			var h_lunes_s = parseFloat(datosI[19].split(':')[1]) + parseFloat(datosI[19].split(':')[0] * 60);
			if(datosI[18]=='00:00:01'){ 
				var h_e_lu='09:00',h_s_lu='18:00',s_e_lu=550,s_s_lu=1080; $('#checkbox-lu').click();
			}else{ var h_e_lu=datosI[18].substring(0, 5),h_s_lu=datosI[19].substring(0, 5),s_e_lu=h_lunes_e,s_s_lu=h_lunes_s; }
			//Lunes
			//Martes
			var h_martes_e = parseFloat(datosI[20].split(':')[1]) + parseFloat(datosI[20].split(':')[0] * 60);
			var h_martes_s = parseFloat(datosI[21].split(':')[1]) + parseFloat(datosI[21].split(':')[0] * 60);
			if(datosI[20]=='00:00:01'){ 
				var h_e_ma='09:00',h_s_ma='18:00',s_e_ma=550,s_s_ma=1080; $('#checkbox-ma').click(); //Horario Martes 
			}else{ var h_e_ma=datosI[20].substring(0,5),h_s_ma=datosI[21].substring(0,5),s_e_ma=h_martes_e,s_s_ma=h_martes_s; }
			//Martes
			//Miércoles
			var h_miercoles_e = parseFloat(datosI[22].split(':')[1]) + parseFloat(datosI[22].split(':')[0] * 60);
			var h_miercoles_s = parseFloat(datosI[23].split(':')[1]) + parseFloat(datosI[23].split(':')[0] * 60);
			if(datosI[22]=='00:00:01'){ 
				var h_e_mi='09:00',h_s_mi='18:00',s_e_mi=550,s_s_mi=1080; $('#checkbox-mi').click(); //Horario Miércoles
			}else{
				var h_e_mi=datosI[22].substring(0,5),h_s_mi=datosI[23].substring(0,5),s_e_mi=h_miercoles_e,s_s_mi=h_miercoles_s;
			}
			//Miércoles
			//Jueves
			var h_jueves_e = parseFloat(datosI[24].split(':')[1]) + parseFloat(datosI[24].split(':')[0] * 60);
			var h_jueves_s = parseFloat(datosI[25].split(':')[1]) + parseFloat(datosI[25].split(':')[0] * 60);
			if(datosI[24]=='00:00:01'){ 
				var h_e_ju='09:00',h_s_ju='18:00',s_e_ju=550,s_s_ju=1080; $('#checkbox-ju').click(); //Horario Jueves
			}else{ var h_e_ju=datosI[24].substring(0,5),h_s_ju=datosI[25].substring(0,5),s_e_ju=h_jueves_e,s_s_ju=h_jueves_s; }
			//Jueves
			//Viernes
			var h_viernes_e = parseFloat(datosI[26].split(':')[1]) + parseFloat(datosI[26].split(':')[0] * 60);
			var h_viernes_s = parseFloat(datosI[27].split(':')[1]) + parseFloat(datosI[27].split(':')[0] * 60);
			if(datosI[26]=='00:00:01'){ 
				var h_e_vi='09:00',h_s_vi='18:00',s_e_vi=550,s_s_vi=1080; $('#checkbox-vi').click(); //Horario Viernes
			}else{ var h_e_vi=datosI[26].substring(0,5),h_s_vi=datosI[27].substring(0,5),s_e_vi=h_viernes_e,s_s_vi=h_viernes_s; }
			//Viernes
			//Sábado
			var h_sabado_e = parseFloat(datosI[28].split(':')[1]) + parseFloat(datosI[28].split(':')[0] * 60);
			var h_sabado_s = parseFloat(datosI[29].split(':')[1]) + parseFloat(datosI[29].split(':')[0] * 60);
			if(datosI[28]=='00:00:01'){ 
				var h_e_sa='09:00',h_s_sa='14:00',s_e_sa=550,s_s_sa=850; $('#checkbox-sa').click(); //Horario Sábado
			}else{ var h_e_sa=datosI[28].substring(0,5),h_s_sa=datosI[29].substring(0,5),s_e_sa=h_sabado_e,s_s_sa=h_sabado_s; }
			//Sábado
			//Domingo
			var h_domingo_e = parseFloat(datosI[30].split(':')[1]) + parseFloat(datosI[30].split(':')[0] * 60);
			var h_domingo_s = parseFloat(datosI[31].split(':')[1]) + parseFloat(datosI[31].split(':')[0] * 60);
			if(datosI[30]=='00:00:01'){ 
				var h_e_do='09:00',h_s_do='14:00',s_e_do=550,s_s_do=850; $('#checkbox-do').click(); //Horario Domingo
			}else{ var h_e_do=datosI[30].substring(0,5),h_s_do=datosI[31].substring(0,5),s_e_do=h_domingo_e,s_s_do=h_domingo_s; }
			//Domingo
			window.setTimeout(function(){ //alert(h_e_ma);
				siempre(datosI[12],datosI[13],h_e_lu,h_s_lu,s_e_lu,s_s_lu,h_e_ma,h_s_ma,s_e_ma,s_s_ma,h_e_mi,h_s_mi,s_e_mi,s_s_mi,h_e_ju,h_s_ju,s_e_ju,s_s_ju,h_e_vi,h_s_vi,s_e_vi,s_s_vi,h_e_sa,h_s_sa,s_e_sa,s_s_sa,h_e_do,h_s_do,s_e_do,s_s_do);
			},200);
			window.setTimeout(function(){
				$('#claveC').val(datosI[1]); $('#nombreC').val(datosI[2]); $('#linkP').val(datosI[17]);
				$('#estadoS').val(datosI[6]);$('#municipioS').val(datosI[7]);$('#ciudadS').val(datosI[8]);
				$('#coloniaS').val(datosI[9]);$('#calleS').val(datosI[10]);$('#cpS').val(datosI[11]);
				$('#telefonoS').val(datosI[14]);$('#emailS').val(datosI[15]);$('#sitioS').val(datosI[16]);
				$('#sliderI').slider({value:datosI[3], disabled: false}); $('#amountI').text(datosI[3]+'%'); 
				$('#p_t_i').val(datosI[3]); $('#cluesC').val(datosI[35]);
				$('#sliderL').slider({value:datosI[4], disabled: false}); $('#amountL').text(datosI[4]+'%'); 
				$('#p_t_l').val(datosI[4]);
				$('#sliderS').slider({value:datosI[5], disabled: false}); $('#amountS').text(datosI[5]+'%'); 
				$('#p_t_s').val(datosI[5]);
				$('#p_latitud').text(redondear(datosI[12],4)); $('#p_longitud').text(redondear(datosI[13],4));
				$('#p_latitud_s').val(datosI[12]); $('#p_longitud_s').val(datosI[13]); //alert(datosI[20]);
				$('#tab_lab').val(datosI[32]); $('#tab_img').val(datosI[33]);
				$('#sliderMC').slider({value:datosI[34], disabled: false}); $('#amountMC').text(datosI[34]+'%'); 
				$('#p_m_c').val(datosI[34]);
				$('#sliderMI').slider({value:datosI[36], disabled: false}); $('#amountMI').text(datosI[36]+'%'); 
				$('#p_m_i').val(datosI[36]);
				$('#sliderML').slider({value:datosI[37], disabled: false}); $('#amountML').text(datosI[37]+'%'); 
				$('#p_m_l').val(datosI[37]);
				$('#sliderMS').slider({value:datosI[38], disabled: false}); $('#amountMS').text(datosI[38]+'%'); 
				$('#p_m_s').val(datosI[38]);
				$('#sliderMF').slider({value:datosI[39], disabled: false}); $('#amountMF').text(datosI[39]+'%'); 
				$('#p_m_f').val(datosI[39]);
			},500);
		  }, close:function( event, ui ){ $('#dialog-nivel1').empty(); }
		});
	});
} }); }); }

function nuevaSucursal(){ $(document).ready(function(e) {
$("#dialog-nivel1").load("htmls/ficha_sucursal.php #ficha_sucursal",function(response, status, xhr){ if(status == "success"){ 
	
	var nv = new Date(); 
	$('#temporal_s').val(nv.format('Y-m-d-H-i-s-u').substring(0,22));

	var he=$('#referencia').height() - 90, wi = $('#referencia').width() * 0.98;

	$('#dialog-nivel1').dialog({
		title:'CREAR UNA SUCURSAL',modal:true,autoOpen:true,closeText:'',width:wi,height:he,
		closeOnEscape:false,dialogClass:'no-close',
		buttons: {
		"Guardar": function() {
			if($('#formSucursal').valid()){ 
				var datosP = $('#formSucursal').serialize();
				$.post('files-serverside/addSucursal.php',datosP).done(function( data ) {
					if(data==1){
					  $('#clickme').click();$('#dialog-nivel1').dialog('close');$('#dialog-confirmaAltaPaciente').dialog('open');
					} else{alert(data);}
				});
			}
		}, "Cancelar": function() { $(this).dialog('close'); }
	  },
	  open:function( event, ui ){
		$("#ficha_sucursal").tabs({active: 0}); $('#pestanas').removeClass('ui-widget-header');
		$('#idUsuarioNC').val($('#idUser').val());
		$('#dialog-nivel1 input, #dialog-nivel1 select, #dialog-nivel1 textarea').addClass('campoITtab');
		$('#dialog-nivel1 textarea').css('height','99%'); $('#formSucursal').css('height',$('#dialog-nivel1').height()-0);
		window.setTimeout(function(){
			hora_e_lv = '09:00'; hora_s_lv = '18:00'; hora_e_sd = '09:00'; hora_s_sd = '14:00';
			sli_e_lv = '550'; sli_s_lv = '1080'; sli_e_sd = '550'; sli_s_sd = '850';
			siempre(18.8135, -98.9535, hora_e_lv, hora_s_lv, sli_e_lv, sli_s_lv, hora_e_lv, hora_s_lv, sli_e_lv, sli_s_lv, hora_e_lv, hora_s_lv, sli_e_lv, sli_s_lv, hora_e_lv, hora_s_lv, sli_e_lv, sli_s_lv, hora_e_lv, hora_s_lv, sli_e_lv, sli_s_lv, hora_e_sd, hora_s_sd, sli_e_sd, sli_s_sd, hora_e_sd, hora_s_sd, sli_e_sd, sli_s_sd); 
		},200);
	  }, close:function( event, ui ){$("#dialog-nivel1").empty();}
	});
} }); }); }

function siempre(la,lo,h_e_lu,h_s_lu,s_e_lu,s_s_lu,h_e_ma,h_s_ma,s_e_ma,s_s_ma,h_e_mi,h_s_mi,s_e_mi,s_s_mi,h_e_ju,h_s_ju,s_e_ju,s_s_ju,h_e_vi,h_s_vi,s_e_vi,s_s_vi,h_e_sa,h_s_sa,s_e_sa,s_s_sa,h_e_do,h_s_do,s_e_do,s_s_do){ $(document).ready(function(e) {
	$('#formSucursal').validate({ ignore: 'hidden',
		rules:{ 
			claveC:{ required:true, minlength: 4, 
				"remote": { 
					url: 'files-serverside/checkClaveEst.php', type: "post", 
					data: { clave:function() { return $('#claveC').val(); } }, 
					data: { idEs:function() { return $('#idSucursal').val(); } } 
				} 
			},
			nombreC:{ required:true,
				"remote": { 
					url: 'files-serverside/checkNombreSu.php', type: "post", 
					data: { nombre:function() { return $('#nombreC').val(); } }, 
					data: { idEs:function() { return $('#idSucursal').val(); } } 
				} 
			} 
		},
		messages:{ 
			claveC:{ 
				minlength:'La clave de la sucursal debe constar de 4 a 6 dígitos.', 
				remote:'¡Esta clave pertenece ya a otra sucursal!' 
			},
			nombreC:{ 
				required:'Debe ingresar el nombre de la sucursal.', 
				remote:'¡Este nombre pertenece ya a otra sucursal!' 
			} 
		}
	});
	
	var he=$('#referencia').height() - 90, wi = $('#referencia').width() * 0.98;
	$('#ficha_sucursal').css('height',he-155);
	$('#ficha_sucursal').parent().css('border','none');
	$('#t_t_1_1').css('height',$('#ficha_sucursal').height()-40);
	$('#t_t_1_2').css('height',$('#ficha_sucursal').height()-40);
	
	$( "#sliderI" ).slider({
	  value:100, min: 0, max: 200, step: 1, 
	  slide:function(event, ui){$( "#amountI" ).text(ui.value+"%"); $("#p_t_i").val(ui.value);}
	});
	$("#amountI").text($( "#sliderI" ).slider( "value" )+"%"); $("#p_t_i").val($("#sliderI").slider("value"));
	$( "#sliderL" ).slider({
	  value:100, min: 0, max: 200, step: 1, 
	  slide: function(event, ui){ $( "#amountL" ).text(ui.value+"%" ); $("#p_t_l").val(ui.value);}
	});
	$("#amountL").text($( "#sliderL" ).slider( "value" )+"%" ); $("#p_t_l").val($("#sliderL").slider("value"));
	$( "#sliderS" ).slider({
	  value:100, min: 0, max: 200, step: 1, 
	  slide: function(event, ui){ $( "#amountS" ).text(ui.value+"%" ); $("#p_t_s").val(ui.value);}
	});
	$("#amountS").text($( "#sliderS" ).slider( "value" )+"%" ); $("#p_t_s").val($("#sliderS").slider("value"));
	
	$("#sliderMC").slider({
	  value:0, min: 0, max: 100, step: 1, 
	  slide:function(event, ui){$( "#amountMC" ).text(ui.value+"%"); $("#p_m_c").val(ui.value);}
	});
	$("#sliderMI").slider({
	  value:0, min: 0, max: 100, step: 1, 
	  slide:function(event, ui){$( "#amountMI" ).text(ui.value+"%"); $("#p_m_i").val(ui.value);}
	});
	$("#sliderML").slider({
	  value:0, min: 0, max: 100, step: 1, 
	  slide:function(event, ui){$( "#amountML" ).text(ui.value+"%"); $("#p_m_l").val(ui.value);}
	});
	$("#sliderMS").slider({
	  value:0, min: 0, max: 100, step: 1, 
	  slide:function(event, ui){$( "#amountMS" ).text(ui.value+"%"); $("#p_m_s").val(ui.value);}
	});
	$("#sliderMF").slider({
	  value:0, min: 0, max: 100, step: 1, 
	  slide:function(event, ui){$( "#amountMF" ).text(ui.value+"%"); $("#p_m_f").val(ui.value);}
	});
					
	var i=0;
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
		  var address = document.getElementById('estadoS').value+' '+document.getElementById('ciudadS').value+' '+document.getElementById('coloniaS').value+' '+document.getElementById('calleS').value;

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
	
	window.setTimeout(function(){$('.checki').checkboxradio(); $('.checki').click();},200);
	
	$('#slider-lunes').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_lu, s_s_lu ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0'+hours; if(minutes1.length<10) minutes1='0' + minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#lunes_de').html(hours1+':'+minutes1); jQuery('#lunes_a').html(hours2+':'+minutes2);
		jQuery('#lunes_de1').val(hours1+':'+minutes1+':00'); jQuery('#lunes_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#lunes_de").html(h_e_lu); $("#lunes_a").html(h_s_lu); $("#lunes_de1").val(h_e_lu+':00'); $("#lunes_a1").val(h_s_lu+':00');
	
	$('#checkbox-lu').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-lunes').slider({disabled: false, values: [ s_e_lu, s_s_lu ]});
			$('.texto_lu').html('<span style="float:right;">(DE <span class="lun-vier-i" id="lunes_de"></span> A <span class="lun-vier-f" id="lunes_a"></span>)</span>'); 
			$("#lunes_de").html(h_e_lu);$("#lunes_a").html(h_s_lu);$("#lunes_de1").val(h_e_lu+':00');
			$("#lunes_a1").val(h_s_lu+':00');
		}
		else{
			$('#slider-lunes').slider({disabled: true, values: [h_e_lu,h_s_lu]});$(".texto_lu").html('(No se labora)');
			$("#lunes_de1").val('00:00:01'); $("#lunes_a1").val('00:00:01');
		}
	});
	
	$('#slider-martes').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_ma, s_s_ma ],
	  slide: function( event, ui ) { 
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60); 

		if(hours1.length<10) hours1='0'+hours; if(minutes1.length<10) minutes1 = '0' + minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#martes_de').html(hours1+':'+minutes1); jQuery('#martes_a').html(hours2+':'+minutes2);
		jQuery('#martes_de1').val(hours1+':'+minutes1+':00'); jQuery('#martes_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#martes_de").html(h_e_ma);$("#martes_a").html(h_s_ma);$("#martes_de1").val(h_e_ma+':00');$("#martes_a1").val(h_s_ma+':00');
	
	$('#checkbox-ma').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-martes').slider({disabled: false, values: [ s_e_ma, s_s_ma ]});
			$('.texto_ma').html('<span style="float:right;">(DE <span class="lun-vier-i" id="martes_de"></span> A <span class="lun-vier-f" id="martes_a"></span>)</span>'); 
			$("#martes_de").html(h_e_ma); $("#martes_a").html(h_s_ma); $("#martes_de1").val(h_e_ma+':00'); 
			$("#martes_a1").val(h_s_ma+':00');
		}
		else{
			$('#slider-martes').slider({disabled: true, values: [s_e_ma,s_s_ma]});$(".texto_ma").html('(No se labora)');
			$("#martes_de1").val('00:00:01'); $("#martes_a1").val('00:00:01');
		}
	});
	
	$('#slider-miercoles').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_mi, s_s_mi ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0' + hours; if(minutes1.length<10) minutes1='0'+minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#miercoles_de').html(hours1+':'+minutes1); jQuery('#miercoles_a').html(hours2+':'+minutes2);
		jQuery('#miercoles_de1').val(hours1+':'+minutes1+':00'); jQuery('#miercoles_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#miercoles_de").html(h_e_mi); $("#miercoles_a").html(h_s_mi); $("#miercoles_de1").val(h_e_mi+':00'); 
	$("#miercoles_a1").val(h_s_mi+':00');
	
	$('#checkbox-mi').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-miercoles').slider({disabled: false, values: [ s_e_mi, s_s_mi ]});
			$('.texto_mi').html('<span style="float:right;">(DE <span class="lun-vier-i" id="miercoles_de"></span> A <span class="lun-vier-f" id="miercoles_a"></span>)</span>'); 
			$("#miercoles_de").html(h_e_mi); $("#miercoles_a").html(h_s_mi);
			$("#miercoles_de1").val(h_e_mi+':00'); $("#miercoles_a1").val(h_s_mi+':00');
		}
		else{
			$('#slider-miercoles').slider({disabled:true, values: [s_e_mi,s_s_mi]});$(".texto_mi").html('(No se labora)');
			$("#miercoles_de1").val('00:00:01'); $("#miercoles_a1").val('00:00:01');
		}
	});
	
	$('#slider-jueves').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_ju, s_s_ju ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0' + hours; if(minutes1.length<10) minutes1='0' + minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#jueves_de').html(hours1+':'+minutes1); jQuery('#jueves_a').html(hours2+':'+minutes2);
		jQuery('#jueves_de1').val(hours1+':'+minutes1+':00'); jQuery('#jueves_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#jueves_de").html(h_e_ju);$("#jueves_a").html(h_s_ju);$("#jueves_de1").val(h_e_ju+':00');$("#jueves_a1").val(h_s_ju+':00');
	
	$('#checkbox-ju').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-jueves').slider({disabled: false, values: [ s_e_ju, s_s_ju ]});
			$('.texto_ju').html('<span style="float:right;">(DE <span class="lun-vier-i" id="jueves_de"></span> A <span class="lun-vier-f" id="jueves_a"></span>)</span>'); 
			$("#jueves_de").html(h_e_ju); $("#jueves_a").html(h_s_ju);
			$("#jueves_de1").val(h_e_ju+':00'); $("#jueves_a1").val(h_s_ju+':00');
		}
		else{
			$('#slider-jueves').slider({disabled:true, values: [s_e_ju,s_s_ju]});$(".texto_ju").html('(No se labora)');
			$("#jueves_de1").val('00:00:01'); $("#jueves_a1").val('00:00:01');
		}
	});
	
	$('#slider-viernes').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_vi, s_s_vi ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0'+hours; if(minutes1.length<10) minutes1='0' + minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#viernes_de').html(hours1+':'+minutes1); jQuery('#viernes_a').html(hours2+':'+minutes2);
		jQuery('#viernes_de1').val(hours1+':'+minutes1+':00'); jQuery('#viernes_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#viernes_de").html(h_e_vi); $("#viernes_a").html(h_s_vi);$("#viernes_de1").val(h_e_vi+':00'); 
	$("#viernes_a1").val(h_s_vi+':00');
	
	$('#checkbox-vi').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-viernes').slider({disabled: false, values: [ s_e_vi, s_s_vi ]});
			$('.texto_vi').html('<span style="float:right;">(DE <span class="lun-vier-i" id="viernes_de"></span> A <span class="lun-vier-f" id="viernes_a"></span>)</span>'); 
			$("#viernes_de").html(h_e_vi); $("#viernes_a").html(h_s_vi);
			$("#viernes_de1").val(h_e_vi+':00'); $("#viernes_a1").val(h_s_vi+':00');
		}
		else{
			$('#slider-viernes').slider({disabled:true, values: [s_e_vi,s_s_vi]});$(".texto_vi").html('(No se labora)');
			$("#viernes_de1").val('00:00:01'); $("#viernes_a1").val('00:00:01');
		}
	});
	
	$('#slider-sabado').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_sa, s_s_sa ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0'+hours; if(minutes1.length<10) minutes1='0'+minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#sabado_de').html(hours1+':'+minutes1); jQuery('#sabado_a').html(hours2+':'+minutes2);
		jQuery('#sabado_de1').val(hours1+':'+minutes1+':00'); jQuery('#sabado_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#sabado_de").html(h_e_sa);$("#sabado_a").html(h_s_sa);$("#sabado_de1").val(h_e_sa+':00');$("#sabado_a1").val(h_s_sa+':00');
	
	$('#checkbox-sa').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-sabado').slider({disabled: false, values: [ s_e_sa, s_s_sa ]});
			$('.texto_sa').html('<span style="float:right;">(DE <span class="sab-dom-i" id="sabado_de"></span> A <span class="sab-dom-f" id="sabado_a"></span>)</span>'); 
			$("#sabado_de").html(h_e_sa); $("#sabado_a").html(h_s_sa);
			$("#sabado_de1").val(h_e_sa+':00'); $("#sabado_a1").val(h_s_sa+':00');
		}
		else{
			$('#slider-sabado').slider({disabled:true, values: [s_e_sa,s_s_sa]});$(".texto_sa").html('(No se labora)');
			$("#sabado_de1").val('00:00:01'); $("#sabado_a1").val('00:00:01');
		}
	});
	
	$('#slider-domingo').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_do, s_s_do ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0'+hours; if(minutes1.length<10) minutes1 = '0' + minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#domingo_de').html(hours1+':'+minutes1); jQuery('#domingo_a').html(hours2+':'+minutes2);
		jQuery('#domingo_de1').val(hours1+':'+minutes1+':00'); jQuery('#domingo_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#domingo_de").html(h_e_do); $("#domingo_a").html(h_s_do); $("#domingo_de1").val(h_e_do+':00'); 
	$("#domingo_a1").val(h_e_do+':00');
	
	$('#checkbox-do').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-domingo').slider({disabled: false, values: [ s_e_do, s_s_do ]});
			$('.texto_do').html('<span style="float:right;">(DE <span class="sab-dom-i" id="domingo_de"></span> A <span class="sab-dom-f" id="domingo_a"></span>)</span>'); 
			$("#domingo_de").html(h_e_do); $("#domingo_a").html(h_s_do);
			$("#domingo_de1").val(h_e_do+':00'); $("#domingo_a1").val(h_s_do+':00');
		}
		else{
			$('#slider-domingo').slider({disabled:true, values: [s_e_do,s_s_do]});$(".texto_do").html('(No se labora)');
			$("#domingo_de1").val('00:00:01'); $("#domingo_a1").val('00:00:01');
		}
	});
}); }

function ver_membretes(id_s, name_s, exte, time,titulo,carpeta,id_doc,que_es){//alert(id_s);
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-auxiliar').dialog({
		autoOpen: true, modal: true, width: 700, height:520, title:titulo+'. SUCURSAL '+name_s, closeText: '',
		open:function( event, ui ){
			$("#dialog-auxiliar").load('htmls/subir_membretes.php',function(response,status,xhr){ if(status=="success"){
				//Primero checamos si la sucursal tiene membretes de tal tipo:
				var datosCH = {id_s:id_s,que_es:que_es}
				$.post('files-serverside/datosMembretesS.php',datosCH).done(function(data){ var datos = data.split('*{');
					if(datos[0]>0){
						x=carpeta+'/files/'+datos[1]+'.'+datos[2]+'?'+time; var membretD = 'url('+x+')';
						$("#membrete_en").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
					}
					
					if(datos[3]>0){
						x=carpeta+'/files/'+datos[4]+'.'+datos[5]+'?'+time; var membretD = 'url('+x+')';
						$("#membrete_pi").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
					}
				});
				
				$('#fileupload_membreteE').click(function(e) { $('#nombre_membrete').val('ENCABEZADO'); });
				$('#fileupload_membreteP').click(function(e) { $('#nombre_membrete').val('PIE'); });
				$('#membretes0').css('height',350);
				//Para subir el membrete encabezado
				'use strict'; var userL = $('#idUser').val();
				var url = window.location.hostname === 'blueimp.github.io' ?
					'//jquery-file-upload.appspot.com/' : 'membretes/index.php?idU='+userL+'&idP='+id_s+'&nombreD='+escape(id_s);
				$('.fileupload_membrete').fileupload({
					url: url, dataType: 'json',
					submit:function (e, data) {
						$.each(data.files, function (index, file) {
							var input = id_s; //alert($('#tit_mem').val());
							data.formData = {
								titulo_d: input, ext_d:file.name.split('.')[1], que_es:que_es, id_doc:'koby',
								nombre_doc:$('#nombre_membrete').val()
							};
						});
					},
					progress: function (e, data) {
						var progress=parseInt(data.loaded / data.total * 100,10);$('#progressM .bar').css('width',progress + '%');
					},
					done: function (e, data) {
						$('#dialog-nivel3').dialog({
							autoOpen: true, modal: true, width: 500, height:120, title: 'MEMBRETE GUARDADO', closeText: '',
							open:function( event, ui ){
								$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El membrete se guardó satisfactoriamente!</h3></td></tr></table>');
								//$('#dialog-nivel2').dialog('close');
								window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
								if($('#nombre_membrete').val()=='ENCABEZADO'){
									var datos = {id_s:id_s,nombre:'ENCABEZADO'}
									$.post('files-serverside/datosMembrete.php',datos).done(function( data ){
										var datosM = data.split('*{');
										x=carpeta+'/files/'+datosM[0]+'.'+datosM[1]+'?'+time;
									
										var membretD = 'url('+x+')';
										$("#membrete_en").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
									});
								}else{
									var datos = {id_s:id_s,nombre:'PIE'}
									$.post('files-serverside/datosMembrete.php',datos).done(function( data ){
										var datosM = data.split('*{');
										x=carpeta+'/files/'+datosM[0]+'.'+datosM[1]+'?'+time;
									
										var membretD = 'url('+x+')';
										$("#membrete_pi").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
									});
								}
							},
							close:function( event, ui ){ 
								$("#dialog-nivel3").empty(); $('#dialog-nivel3').dialog('destroy'); 
								$('#progressM .bar').css('width',0);
							}, buttons:{ }
						});
					},
				}); //Para el upload
			} });
		}, close:function( event, ui ){ $("#dialog-auxiliar").empty(); $('#dialog-auxiliar').dialog('destroy'); },
		buttons:{
			"Imprimir":function(){
				$('#table_membre').prop('border',0);
				$('#dialog-auxiliar #table_membre').printElement(); $('#table_membre').prop('border',1);
			},"Cerrar":function(){$('#dialog-auxiliar').dialog('close');}
		}
	});
}

function subir_logo(id_s, name_s){ $(document).ready(function(e) {//alert(name_s);
	$('#dialog-nivel1').dialog({
		autoOpen:true,modal:true,width:850,height:190,title:'SUBIR EL LOGOTIPO DE LA EMPRESA '+name_s,closeText:'',
		closeOnEscape:true, dialogClass:'',
		open:function( event, ui ){
			$("#dialog-nivel1").load("htmls/subir_logo.php #documento",function(response,status,xhr){ if(status == "success"){
				$('#form-documento').submit(function(event) { event.preventDefault(); });
				$('#form-documento').validate(); $('#titulo_d').val(id_s);
				//Para el upload
				'use strict'; var userL = $('#idUser').val();
				var url = window.location.hostname === 'blueimp.github.io' ?
					'//jquery-file-upload.appspot.com/' : 'logotipos/index.php?idU='+userL+'&idP='+id_s+'&nombreD='+escape($('#titulo_d').val());
				$('#fileupload_logo').fileupload({
					url: url, dataType: 'json',
					submit:function (e, data) {
						$.each(data.files, function (index, file) {
							var input = $('#titulo_d'); data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
						});
					},
					progress: function (e, data) {
						var progress=parseInt(data.loaded / data.total * 100,10);$('#progress .bar').css('width', progress + '%');
					},
					done: function (e, data) {
						$('#dialog-nivel2').dialog({
							autoOpen: true, modal: true, width: 500, height:120, title: 'LOGOTIPO GUARDADO', closeText: '',
							open:function( event, ui ){
								$('#dialog-nivel2').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El logotipo se guardó satisfactoriamente!</h3></td></tr></table>');
								$('#dialog-nivel1').dialog('close');
								window.setTimeout(function(){$('#dialog-nivel2').dialog('close');},2500);
							},
							close:function( event, ui ){ 
								$("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); $('#clickme').click();
							}, buttons:{ }
						});
					},
				});
				//Para el upload
			} });
		}, close:function( event, ui ){ $("#dialog-nivel1").empty(); $('#dialog-nivel1').dialog('destroy'); }, buttons:{ }
	});
}); }

function ver_logo(nombre_img, name_s, exte, time,titulo,carpeta,id_doc,que_es){ $(document).ready(function(e) {
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel2').dialog({
		autoOpen: true, modal: true, width: w, height:h, title: titulo+' DE LA EMPRESA '+ name_s, closeText: '',
		open:function( event, ui ){
			$("#dialog-nivel2").load('../pacientes/htmls/miPDFdocs.php #tablaMiPDF', function( response, status, xhr ) { 
				if ( status == "success" ) { //alert(exte);
					if(exte != 'pdf' & exte != 'PDF'){
						x=carpeta+'/files/'+id_doc+'.'+exte+'?'+time;
						$('#mi_documento').html('<img src='+x+' style="max-width:750px; border:5px solid white; border-radius:4px; background-color:rgba(255, 255, 255, 1);">');
					}else{
						x=carpeta+'/files/'+id_doc+'.pdf';
						$('#mi_documento').html('<a class="media" href=""> </a>');
						$('a.media').media({width:890, height:h-136, src:x});	
					}
				}
			});
		}, close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); },
		buttons:{
			"Imprimir":function(){$('#dialog-nivel2 #tablaMiPDF').printElement();},
			"Eliminar":function(){delete_documento(id_doc,titulo,exte,que_es,carpeta);},
			"Cerrar":function(){$('#dialog-nivel2').dialog('close');}
		}
	});
}); }

function delete_documento(id_doc, nombre_doc, tipo_doc, titulo,carpeta){ $(document).ready(function(e) {//alert(tipo_doc);
$("#dialog-nivel3").load("../pacientes/htmls/eliminacion.php", function( response, status, xhr ) { if ( status == "success" ) { 
	$('#dialog-nivel3').dialog({ title: 'ELIMINAR ARCHIVO', modal: true, autoOpen: true, closeText: '', width: 700, 
		height: 230, closeOnEscape: true, dialogClass: '',
		buttons:{
			"Aceptar":function(){
				if($('#confirmaEA').prop('checked')==true){
					var datos = {id:id_doc, tipo:tipo_doc, que_es:titulo,carpeta:carpeta}
					$.post('files-serverside/eliminarLogo.php',datos).done(function( data ) { if (data==1){
						$('#dialog-nivel2').dialog('close');
						$('#dialog-confirmarAlgo').dialog({ title:'ARCHIVO ELIMINADO',modal:true, autoOpen: true, closeText: '',
							width: 600, height: 200, closeOnEscape: true, dialogClass: '',
							buttons:{ "Cerrar":function(){ $('#dialog-confirmarAlgo').dialog('close'); } },
							open:function( event, ui ) {
								$('#textoAlgo').text('¡EL ARCHIVO SE HA ELIMINADO SATISFACTORIAMENTE!');
							    document.getElementById('form-eliminarAlgo').reset();$('#debeConfirmarCOEA').hide();
								window.setTimeout(function(){$('#dialog-confirmarAlgo').dialog('close');},1500);
								$('#dialog-nivel3').dialog('close');$('#clickme,#clickmeMem,#clickmeFo').click();
							}, close:function( event, ui ) { $('#clickme,#clickmeMem,#clickmeDo').click(); }
						});
					} else{alert(data);} });
				}else{
					$('#debeConfirmarCOEA').hide().show('shake');
					window.setTimeout(function(){$('#debeConfirmarCOEA').hide()},1500);
				}
			}, "Cancelar":function(){ $('#dialog-nivel3').dialog('close'); }
		},
		open:function(event, ui){$('#texto_eliminar_algo').html('¿ESTÁ SEGURO QUE DESEA ELIMINAR EL ARCHIVO '+nombre_doc+'?');}, 
		close:function(event,ui){ $('#dialog-nivel3').empty();$('#tabla_eliminar_algo').remove(); }
	});
} });
}); }

function membretes(id_su, clave_su){ $(document).ready(function(e) {
$("#dialog-nivel1").load("htmls/ficha_sucursal.php #mis_membretes",function( response, status, xhr ){ if ( status == "success" ) {
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel1').dialog({
		autoOpen:true,modal:true,width:w,height:h,title:'TIPOS DE MEMBRETES PARA LA SUCURSAL '+clave_su,closeText:'',
		closeOnEscape:true, dialogClass:'',
		open:function( event, ui ){
			var oTable1, tam1 = $('#dialog-nivel1').height()-40;
			oTable1 = $('#dataTableMem').dataTable({
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
					$('span.DataTables_sort_icon').remove(); $('#dataTableMem_wrapper td').removeClass('sorting_1');
				},
				"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam1, "bAutoWidth": false, 
				"bInfo": true, "bFilter": false, ordering: false,
				"aoColumns": [ {"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false} ],
				"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
				"sDom": 't', "sAjaxSource": "datatable-serverside/formatos.php",
				"fnServerParams":function(aoData, fnCallback){
					var id_s = id_su; aoData.push(  {"name": "id_s", "value": id_s } );
				},
				"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
					"sInfo":"ENCONTRADOS: _END_","sInfoEmpty":"MOSTRADOS: 0","sInfoFiltered":"<br/>FORMATOS: _MAX_","sSearch": "",
					"oPaginate": {
						"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
						"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
					}
				}
			}); $('#clickmeMem').click(function(e) { oTable1.fnDraw(); });
			$('#tabs-4-1').click(function(e){ $('#clickmeMem').click(); });
			
			$('.boton_mem').click(function(event){event.preventDefault();});
		}, close:function( event, ui ){ $("#dialog-nivel1").empty(); $('#dialog-nivel1').dialog('destroy'); }, buttons:{ }
	});
} }); }); }

function subir_mem(id_s,tipo_mem,num_tipo){ $(document).ready(function(e) {//alert(tipo_mem);
	switch(num_tipo){
		case 1:$('#tit_mem').val('MEMBRETE DE RECETA MÉDICA');var title_1=$('#tit_mem').val(),id_documento=1;break;
		case 2:$('#tit_mem').val('MEMBRETE DE NOTA MÉDICA');var title_1=$('#tit_mem').val(),id_documento=2;break;
		case 3:$('#tit_mem').val('MEMBRETE DE SERVICIOS MEDICOS');var title_1=$('#tit_mem').val(),id_documento=3;break;
		case 4:$('#tit_mem').val('MEMBRETE DE RESULTADOS DE IMAGENOLOGIA');var title_1=$('#tit_mem').val(),id_documento=4;break;
		case 5:$('#tit_mem').val('MEMBRETE DE RESULTADOS DE ENDOSCOPIA');var title_1=$('#tit_mem').val(),id_documento=5;break;
		case 6:$('#tit_mem').val('MEMBRETE DE RESULTADOS DE ULTRASONIDO');var title_1=$('#tit_mem').val(),id_documento=6;break;
		case 7:$('#tit_mem').val('MEMBRETE DE RESULTADOS DE LABORATORIO');var title_1=$('#tit_mem').val(),id_documento=7;break;
		case 8:$('#tit_mem').val('MEMBRETE DE RESULTADOS DE COLPOSCOPIA');var title_1=$('#tit_mem').val(),id_documento=8;break;
		default: $('#tit_mem').val('');var title_1=$('#tit_mem').val(),id_documento='';
	}
	$('#dialog-nivel2').dialog({
		autoOpen:true,modal:true,width:850,height:190,title:'SUBIR EL '+title_1,closeText:'', closeOnEscape:true,
		open:function( event, ui ){
			$("#dialog-nivel2").load("htmls/subir_logo.php #membrete",function(response,status,xhr){ if(status == "success"){
				$('#form-membrete').submit(function(event) { event.preventDefault(); });
				$('#form-membrete').validate(); $('#titulo_d').val(id_s);
				//Para el upload
				'use strict'; var userL = $('#idUser').val();
				var url = window.location.hostname === 'blueimp.github.io' ?
					'//jquery-file-upload.appspot.com/' : 'membretes/index.php?idU='+userL+'&idP='+id_s+'&nombreD='+escape($('#titulo_d').val());
				$('#fileupload_mem').fileupload({
					url: url, dataType: 'json',
					submit:function (e, data) {
						$.each(data.files, function (index, file) {
							var input = $('#titulo_d'); //alert($('#tit_mem').val());
							data.formData = {
								titulo_d: input.val(), ext_d:file.name.split('.')[1], que_es:tipo_mem, id_doc:id_documento,
								nombre_doc:$('#tit_mem').val()
							};
						});
					},
					progress: function (e, data) {
						var progress=parseInt(data.loaded / data.total * 100,10);$('#progress .bar').css('width', progress + '%');
					},
					done: function (e, data) {
						$('#dialog-nivel3').dialog({
							autoOpen: true, modal: true, width: 500, height:120, title: 'MEMBRETE GUARDADO', closeText: '',
							open:function( event, ui ){
								$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El membrete se guardó satisfactoriamente!</h3></td></tr></table>');
								$('#dialog-nivel2').dialog('close');
								window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
							},
							close:function( event, ui ){ 
								$("#dialog-nivel3").empty(); $('#dialog-nivel3').dialog('destroy'); $('#clickmeMem').click();
							}, buttons:{ }
						});
					},
				}); //Para el upload
			} });
		}, close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); }, buttons:{ }
	});
}); }

function fotos(id_su, clave_su){ $(document).ready(function(e) {
$("#dialog-nivel1").load("htmls/ficha_sucursal.php #dataTableFotos",function(response, status, xhr){ if ( status == "success" ) {
	$('#b_subir_foto').click(function(e) { subir_foto(id_su); });
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 60;
	$('#dialog-nivel1').dialog({
		autoOpen:true,modal:true,width:w,height:h,title:'FOTOGRAFÍAS DE LA SUCURSAL '+clave_su,closeText:'', dialogClass:'',
		closeOnEscape:true,
		open:function( event, ui ){
			var oTableF, tamF = $('#dialog-nivel1').height()-40;
			oTableF = $('#dataTableFotos').dataTable({
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
					$('span.DataTables_sort_icon').remove(); $('#dataTableMem_wrapper td').removeClass('sorting_1');
				},
				"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tamF, "bAutoWidth": false, 
				"bInfo": true, "bFilter": false, ordering: false,
				"aoColumns": [ {"bSortable":false},{"bSortable":false},{"bSortable":false},{"bVisible":false} ],
				"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
				"sDom": 't', "sAjaxSource": "datatable-serverside/fotos.php",
				"fnServerParams":function(aoData, fnCallback){ var id_s = id_su; aoData.push({"name": "id_s", "value": id_s });},
				"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "LA SUCURSAL NO CUENTA CON FOTOGRAFÍAS",
					"sInfo":"ENCONTRADAS: _END_","sInfoEmpty":"MOSTRADAS: 0","sInfoFiltered":"<br/>FOTOGRAFÍAS: _MAX_", "sSearch": "",
					"oPaginate": {
						"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
						"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
					}
				}
			}); $('#clickmeFo').click(function(e){oTableF.fnDraw();});
			
			$('.boton_mem').click(function(event){event.preventDefault();});
		}, close:function( event, ui ){ $("#dialog-nivel1").empty(); $('#dialog-nivel1').dialog('destroy'); }, buttons:{ }
	});
} }); }); }

function subir_foto(idS){ $(document).ready(function(e) {
$("#dialog-nivel2").load("htmls/subir_fotografia.php #fotografia",function(response,status,xhr){ if(status == "success"){
	$('#dialog-nivel2').dialog({
		autoOpen:true,modal:true,width:800,height:300,title:'SUBIR UNA FOTOGRAFÍA',closeText:'',
		open:function( event, ui ){
			$('#form-fotografia').submit(function(event) { event.preventDefault(); });
			$('#form-fotografia').validate(); $('#fileupload_foto').addClass('ui-state-disabled');
			$('#titulo_foto').keyup(function(e) {//$('#fileupload').valid();
				if($(this).val()!=''){$('#fileupload_foto').removeClass('ui-state-disabled');}
				else{$('#fileupload_foto').addClass('ui-state-disabled');}
			});
			//Para el upload
			'use strict';
			// Change this to the location of your server-side upload handler:
			var ko = $('#idUser').val();
			var url = window.location.hostname === 'blueimp.github.io' ?
						'//jquery-file-upload.appspot.com/' : 'fotografias/index.php?idU='+ko+'&idP='+idS+'&nombreD='+escape($('#titulo_foto').val());
			$('#fileupload_foto').fileupload({
				url: url, dataType: 'json',
				submit:function (e, data) {
					$.each(data.files, function (index, file) {
						var input = $('#titulo_foto'); data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
					});
				},
				progress: function (e, data) {
					var progress = parseInt(data.loaded / data.total * 100, 10);
					$('#progress .bar').css( 'width', progress + '%' );
				},
				done: function (e, data) {
					$('#dialog-nivel3').dialog({
						autoOpen: true, modal: true, width: 500, height:120, title: 'FOTOGRAFÍA CARGADA', closeText: '',
						open:function( event, ui ){
							$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El archivo se guardó satisfactoriamente!</h3></td></tr></table>');
							$('#dialog-nivel2').dialog('close');
							window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
						},
						close:function( event, ui ){ 
							$("#dialog-nivel3").empty(); $('#dialog-nivel3').dialog('destroy'); $('#clickmeFo').click();
						}, buttons:{ }
					});
				},
			}); //Para el upload
		},
		close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); },
		buttons:{ "Cancelar":function(){$('#dialog-nivel2').dialog('close');} }
	});
} });
}); }

function documentos(id_su, clave_su){ $(document).ready(function(e) {
$("#dialog-nivel1").load("htmls/ficha_sucursal.php #dataTableDocs",function(response, status, xhr){ if ( status == "success" ) {
	$('#b_subir_doc').click(function(e) { subir_documento(id_su); });
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 60;
	$('#dialog-nivel1').dialog({
		autoOpen:true,modal:true,width:w,height:h,title:'DOCUMENTOS DE LA SUCURSAL '+clave_su,closeText:'', dialogClass:'',
		closeOnEscape:true,
		open:function( event, ui ){
			var oTableDo, tamF = $('#dialog-nivel1').height()-40;
			oTableDo = $('#dataTableDocs').dataTable({
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
					$('span.DataTables_sort_icon').remove(); $('#dataTableMem_wrapper td').removeClass('sorting_1');
				},
				"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tamF, "bAutoWidth": false, 
				"bInfo": true, "bFilter": false, ordering: false,
				"aoColumns": [ {"bSortable":false},{"bSortable":false},{"bSortable":false},{"bVisible":false} ],
				"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
				"sDom": 't', "sAjaxSource": "datatable-serverside/documentos.php",
				"fnServerParams":function(aoData, fnCallback){ var id_s = id_su; aoData.push({"name": "id_s", "value": id_s });},
				"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "LA SUCURSAL NO CUENTA CON DOCUMENTOS",
					"sInfo":"ENCONTRADOS: _END_","sInfoEmpty":"MOSTRADOS: 0","sInfoFiltered":"<br/>DOCUMENTOS: _MAX_","sSearch": "",
					"oPaginate": {
						"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
						"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
					}
				}
			}); $('#clickmeDo').click(function(e){oTableDo.fnDraw();});
			
			$('.boton_mem').click(function(event){event.preventDefault();});
		}, close:function( event, ui ){ $("#dialog-nivel1").empty(); $('#dialog-nivel1').dialog('destroy'); }, buttons:{ }
	});
} }); }); }

function subir_documento(idS){ $(document).ready(function(e) {
$("#dialog-nivel2").load("htmls/subir_documento.php #documento",function(response,status,xhr){ if(status == "success"){
	$('#dialog-nivel2').dialog({
		autoOpen:true,modal:true,width:800,height:300,title:'SUBIR UN DOCUMENTO',closeText:'',
		open:function( event, ui ){
			$('#form-documento').submit(function(event) { event.preventDefault(); });
			$('#form-documento').validate(); $('#fileupload_docu').addClass('ui-state-disabled');
			$('#titulo_documento').keyup(function(e) {//$('#fileupload').valid();
				if($(this).val()!=''){$('#fileupload_docu').removeClass('ui-state-disabled');}
				else{$('#fileupload_docu').addClass('ui-state-disabled');}
			});
			//Para el upload
			'use strict';
			// Change this to the location of your server-side upload handler:
			var ko = $('#idUser').val();
			var url = window.location.hostname === 'blueimp.github.io' ?
						'//jquery-file-upload.appspot.com/' : 'documentos/index.php?idU='+ko+'&idP='+idS+'&nombreD='+escape($('#titulo_documento').val());
			$('#fileupload_docu').fileupload({
				url: url, dataType: 'json',
				submit:function (e, data) {
					$.each(data.files, function (index, file) {
						var input=$('#titulo_documento'); data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
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
						autoOpen: true, modal: true, width: 500, height:120, title: 'DOCUMENTO CARGADO', closeText: '',
						open:function( event, ui ){
							$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El archivo se guardó satisfactoriamente!</h3></td></tr></table>');
							$('#dialog-nivel2').dialog('close');
							window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
						},
						close:function( event, ui ){ 
							$("#dialog-nivel3").empty(); $('#dialog-nivel3').dialog('destroy'); $('#clickmeDo').click();
						}, buttons:{ }
					});
				},
			}); //Para el upload
		},
		close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); },
		buttons:{ "Cancelar":function(){$('#dialog-nivel2').dialog('close');} }
	});
} });
}); }

function computeTotalDistance(result) { var total = 0,  myroute = result.routes[0];
  for (var i = 0; i < myroute.legs.length; i++) { total += myroute.legs[i].distance.value; }
  total = total / 1000; document.getElementById('total').innerHTML = total + ' km';
}

function ubicacion(idU, nombreU){ $(document).ready(function(e){ //alert(idU);
$("#dialog-nivel1").load("htmls/ficha_sucursal.php #ubicacion", function( response, status, xhr ) { if ( status == "success" ) {
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel1').dialog({ 
		title:'UBICACIÓN DE LA SUCURSAL '+nombreU,modal:true,autoOpen:true,closeText:'',width:w,height:h,closeOnEscape:true,
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
