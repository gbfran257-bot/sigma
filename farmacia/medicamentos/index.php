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
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { $isValid = true; } 
    if (($strUsers == "") && true) { $isValid = true; } 
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
<title>CATALOGO MEDICAMENTOS</title>

<link href="../../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../../css/consultasA.css" rel="stylesheet" type="text/css">
<link href="../../jquery-ui-1.11.4/flick/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../DataTables-1.10.2/media/css/jquery.dataTables.css">
<link href="../../jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">

<script src="../../jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="../../jquery-ui-1.11.4/external/jquery/globalize.js"></script>
<script src="../../jquery-ui-1.11.4/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../../jquery-ui-1.11.4/jquery-ui.js"></script>
<script src="../../DataTables-1.10.2/media/js/jquery.dataTables.js"></script>
<script src="../../DataTables-1.10.2/extensions/Scroller/js/dataTables.scroller.js"></script>
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
	//inicializaciones			
	$('#menu_lat img').css('width','70%').css('height','84%').css('background-color','rgba(255,255,255,0.9)').css('border-radius','6px');
	$('#menu_lat img').hover(function(e) { $(this).css('cursor','pointer'); });	
	
	$('#formGenerales').validate({ ignore: 'hidden',
		rules:{ telmovilP:{ required:true, minlength: 4, "remote": { url: 'files-serverside/checkClaveEst.php', type: "post", data: { clave:function() { return $('#telmovilP').val(); } }, data: { idEs:function() { return $('#idPacienteN').val(); } } } } },
		messages:{ telmovilP:{ required:'Debe ingresar la clave del Estudio.', minlength:'La clave del estudio debe ser de por lo menos 4 dígitos.', remote:'¡Esta clave pertenece a un estudio registrado!' } }
	});
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
			if(dj%2==0){ misDatosUsuario.stop().show('explode','slow'); }else{ misDatosUsuario.stop().hide('explode','slow'); }
    	}
	);
	
	var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75);
	var cy = $('#header table').height() -8;

	misDatosUsuario.css('right',cx).css('top',cy);
	
	var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 160;
	var wi = $('#referencia').width() * 0.96;
	$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
	$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
	
	$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-90);
	$('.tabs').css('width',wi/7.2);
				
	$( window ).resize(function(e) {
        var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75);
		var cy = $('#header table').height();
	
		misDatosUsuario.css('right',cx).css('top',cy);
		
		var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 160;
		var wi = $('#referencia').width() * 0.96;
		$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
		$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
		
		$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-90);
		$('.tabs').css('width',wi/7.2);
    });
	
	var cuadrado = 35;
	$('button').css('width',cuadrado).css('height',cuadrado);
	$('#addConvenio').button({ icons: { primary: "ui-icon-plusthick" }, text: false });
	
	$('form').submit(function(event) { event.preventDefault(); });
	
	$('#input').jqte();
	
	//datos iniciales
	$("#departamentoE").load('files-serverside/genera_departamentoI.php');
	//$("#sucursalP").load('files-serverside/genera_sucursales.php?idS='+$('#sucursalU').val());
	$("#areasE").load('files-serverside/genera_areas.php');
	$('#input').jqteVal('');
	$('.jqte_editor').css('height',$('#dialog-confirmarNuevoPaciente').height()*0.7);
	
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

<script>
function nuevoPaciente(){ $(document).ready(function(e) {
$("#dialog-confirmarNuevoPaciente").load("htmls/ficha_consulta.php #ficha_consulta",function(response, status, xhr) {
	if ( status == "success" ) { 
		var he=$('#referencia').height() - 90, wi = $('#referencia').width() * 0.98;
		$('#areaC').load('genera/areasConsulta.php');
	
		$('#dialog-confirmarNuevoPaciente').dialog({
			title: 'AGREGAR UN MEDICAMENTO AL CATÁLOGO', modal: true, autoOpen: true, closeText: '', width: wi, height: he, 
			closeOnEscape: false, dialogClass: '',
			buttons: {
			"GUARDAR": function() {
				if($('#formFconsulta').valid()){ 
					var datosP = $('#formFconsulta').serialize();
					$.post('files-serverside/addConsulta.php',datosP).done(function( data ) {
						if (data==1){
							$('#clickme').click();
							$('#dialog-confirmarNuevoPaciente').dialog('close');
						}
						else{alert(data);}
					});
				}
			},
			"CANCELAR": function() { $(this).dialog('close'); }
		  },
		  open:function( event, ui ){ $('#idUsuarioNC').val($('#idUser').val());
				$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
				$('#dialog-confirmarNuevoPaciente textarea').css('height','99%');
				$('#formFconsulta').css('height',$('#dialog-confirmarNuevoPaciente').height()-0);
				
				$('#bCategoria, #bMedG').button({ icons: { primary: "ui-icon-search" }, text: false, label: "" });
				$('.botoncillo').click(function(event) { event.preventDefault(); });
				$('#bCategoria').button( "disable" );
				
				$('#areaC').change(function(e) {
					if($(this).val()!=''){
						$('#bCategoria').button( "enable" );
					}else{
						$('#bCategoria').button( "disable" );
					}
				});
				
				$('#bCategoria').click(function(e) {
					var he=$('#referencia').height() - 90, wi = $('#referencia').width() * 0.98;
					$("#dialog-categorias").load("htmls/buscar_categorias.php #buscar_categorias",function(response, status, xhr) {
					if ( status == "success" ) { 
						$('#dialog-categorias').dialog({
							title: 'AGREGAR UNA CONSULTA AL CATÁLOGO', modal: true, autoOpen: true, closeText: '', width: wi,
							height: he, closeOnEscape: false, dialogClass: '',
							buttons: {
								"CANCELAR": function() { $(this).dialog('close'); }
							} 
						});
					} 
					});
				});
			},
			close:function( event, ui ){$("#dialog-confirmarNuevoPaciente").empty();}
		});
	} 
});

}); }

</script>

<script>
$(document).ready(function(e) {
	$('#miMenu').hide();
	$('#verMenu').click(function(e) { verMenu(); });
});
function verMenu(){ $(document).ready(function(e) {
        $('#miMenu').show('fold','slow');
		$('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">CATÁLOGO</span>');
}); }
function ocultarMenu(){ $(document).ready(function(e) {
        $('#miMenu').hide('fold','slow');
		$('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">CATÁLOGO</span>');
}); }
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
        <td align="right" class="iconito"><img src="../../imagenes/iconitos/_medicamentosIcon.png" height="45"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">CATÁLOGO</span></td>
        <td id="celdaUsuario" width="50%" valign="top" align="center">
            <table class="miUsuario" width="1%" height="100%" border="0" cellspacing="0" cellpadding="4" style="border-radius:0px;">
              <tr>
                <td align="center" nowrap valign="middle">
                <?php if($row_usuario['foto_u'] == 1){?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="25">
                <?php }else{?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="25">
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
                <img class="fotoUsuario" id="miFotoUsuarioMini" src="../../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="80">
            <?php }else{?>
                <img class="fotoUsuario" id="miFotoUsuario" src="../../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="80">
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

<div id="miMenu" class="miMenu">
<table width="98%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
  <tr valign="middle" class="fondoMenu">
  	<td class="eii"><img title="MENÚ ANTERIOR" src="../../imagenes/submenu/_consultas.png" width="100" onClick="window.location='../../menu_consultas.php'"></td>
    <td class="eid"><img title="INICIO" src="../../imagenes/submenu/_inicio.png" width="100" onClick="window.location='../../menu.php'"></td>
  </tr>
</table>
</div>

<div class="contenido" id="contenido" align="center">
  <table width="90%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="tablilla">
    <thead id="cabecera_tBusquedaPrincipal">
      <tr bgcolor="#FF6633" style="font-size:1em; color:white;">
        <th id="clickme" class="titulosTabs" align="center" style="color:white; padding:6px;">NOMBRE</th>
        <th class="titulosTabs" align="center" style="color:white;">ÁREA</th>
        <th class="titulosTabs" align="center" style="color:white;">CATEGORÍA</th>
        <th class="titulosTabs" align="center" style="color:white;">GENÉRICO</th>
        <th class="titulosTabs" align="center" style="color:white;">NIVEL</th>
        <th class="titulosTabs" align="center" nowrap style="color:white;" width="1px">PRECIO</th>
     	<th class="titulosTabs" align="center" nowrap style="color:white;" width="30px" nowrap>P.U.</th>
        <th class="titulosTabs" align="center" nowrap style="color:white;" width="70px">PRECIO H.</th>
        <th class="titulosTabs" align="center" nowrap style="color:white;" width="60px">PRECIO S.</th>
     	<th class="titulosTabs" align="center" nowrap style="color:white;" width="40px" nowrap>P.S.U.</th>
        <th class="titulosTabs" align="center" nowrap style="color:white;" width="50px" nowrap>P.S.H.</th>
        <th class="titulosTabs" align="center" nowrap style="color:white;" width="70px">PRECIO M.</th>
     	<th class="titulosTabs" align="center" nowrap style="color:white;" width="50px" nowrap>P.M.U.</th>
        <th class="titulosTabs" align="center" nowrap style="color:white;" width="50px" nowrap>P.M.H.</th>
      </tr>
    </thead>
    <tbody style="font-size:0.9em;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
    	<tr>
        	<th><input name="sNombre" id="sNombre" type="text" class="search_init campos_b_t" placeholder="-NOMBRE-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sArea" id="sArea" type="text" class="search_init campos_b_t" placeholder="-ÁREA-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sCate" id="sCate" type="text" class="search_init campos_b_t" placeholder="-CATEGORÍA-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sGen" id="sGen" type="text" class="search_init campos_b_t" placeholder="-GENÉRICO-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sNiv" id="sNiv" type="text" class="search_init campos_b_t" placeholder="-NIVEL-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sX1" type="hidden" value=""></th>
            <th><input name="sX2" type="hidden" value=""></th>
            <th><input name="sX3" type="hidden" value=""></th>
            <th><input name="sX4" type="hidden" value=""></th>
            <th><input name="sX5" type="hidden" value=""></th>
            <th><input name="sX6" type="hidden" value=""></th>
            <th><input name="sX7" type="hidden" value=""></th>
            <th><input name="sX8" type="hidden" value=""></th>
            <th><input name="sX9" type="hidden" value=""></th>
        </tr>
    </tfoot>
  </table>
</div>

<div id="dialog-confirmarNuevoPaciente" style="display:none;"> </div>

<div id="dialog-confirmaAltaPaciente" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle" height="100%">LOS DATOS DE LA CONSULTA SE HAN GUARDADO SATISFACTORIAMENTE</td> </tr> </table> </div>

<div id="dialog-verPaciente" align="right" style="display:none;"> </div>

<div id="dialog-categorias" style="display:none;"> </div>

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
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
			$('span.DataTables_sort_icon').remove();
			$('#dataTablePrincipal_wrapper td').removeClass('sorting_1');
		},
		"bJQueryUI": false,ordering: false, "bScrollCollapse": true, "sScrollY": tamP, "bAutoWidth": false, "bStateSave": false,
		"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [
			{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false },
			{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false },
			{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
		],
		"iDisplayLength": 50, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
		"sDom": '<"toolbar"><"filtro1Principal">lr<"data_tPrincipal"t><"infoPrincipal">S',
		"sAjaxSource": "datatable-serverside/consultas.php",
		"fnServerParams":function(aoData, fnCallback){ var de=$('#filtro').val();aoData.push({"name": "nombre", "value": de });},
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
	$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right;'><table id='ocultarFP' style='float:right;' width='' border='0' cellspacing='0' cellpadding='6'> <tr> <td><button id='addPacientePrincipal' onClick='nuevoPaciente()'>Nuevo</span></td> </tr> </table></div>" );
	$('#addPacientePrincipal').css('height', $('.filtro1Principal input').height());
	$('.filtro1Principal input').attr("placeholder", "PARA EMPEZAR, BUSQUE UNA CONSULTA AQUÍ...").addClass('placeHolder');
	
	$('#addPacientePrincipal').button({icons: {primary: "ui-icon-plusthick" }, text:true, label:"Nuevo medicamento" });
	
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
	var he1 = $('#referencia').height() - 100;
	var wi1 = $('#referencia').width() * 0.97;
	
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

<script>
function verPaciente(x){ $(document).ready(function(e) {
$("#dialog-confirmarNuevoPaciente").load("htmls/ficha_consulta.php #ficha_consulta",function(response, status, xhr) {
	if ( status == "success" ) {
		$('#idConsulta').val(x);
		 var datos ={idC:x}
		 $.post('files-serverside/fichaConsulta.php',datos).done(function( data1 ) {
			if (data1 != "ok"){
				var datosI = data1.split('*}');
	
				var he = $('#referencia').height() - 90, wi = $('#referencia').width() * 0.98;
				
				var title = 'FICHA DE '+datosI[0];
				$('#dialog-confirmarNuevoPaciente').dialog({
					title:title,modal: true,autoOpen:true,closeText:'', width: wi, height:he, closeOnEscape: true, dialogClass: '',
					buttons: {
					"ACTUALIZAR": function() {
						if($('#formFconsulta').valid()){
							var datosP = $('#formFconsulta').serialize();
							$.post('files-serverside/updateConsulta.php',datosP).done(function( data ) {
								if (data==1){
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
						
						$('#areaC').load('genera/areasConsulta.php',function(response,status,xhr){$("#areaC").val(datosI[1]);});
						$('#nombreC').val(datosI[0]);$('#precioC').val(datosI[2]);
						$('#precioCurgencia').val(datosI[3]); $('#precioC1').val(datosI[4]); $('#precioCurgencia1').val(datosI[5]);
						$('#precioMe').val(datosI[6]); $('#precioMe1').val(datosI[7]);
						$('#formFconsulta').css('height',$('#dialog-confirmarNuevoPaciente').height()-0);
						
						$('#bCategoria, #bMedG').button({ icons: { primary: "ui-icon-search" }, text: false, label: "" });
						$('.botoncillo').click(function(event) { event.preventDefault(); });
						
						$('#areaC').change(function(e) {
                            if($(this).val()!=''){alert(1);}else{alert(0);}
                        });
					},
					close:function( event, ui ){ 
						$('#dialog-confirmarNuevoPaciente').dialog('close'); $('#dialog-confirmarNuevoPaciente').empty();
					}
				});
			}else{alert(data);}
		});
	}
});
}); }
</script>
