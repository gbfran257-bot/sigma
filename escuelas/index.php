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

if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT id_u, nombre_u, apaterno_u, amaterno_u, idSucursal_u, usuario_u, idDepartamento_u, idPuesto_u, acceso_u, sexo_u, foto_u, nombreFoto_u FROM usuarios WHERE usuario_u = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

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
<title>CATÁLOGO DE ESCUELAS</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link href="../DataTables-1.10.5/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">

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
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src='../tinymce/tinymce.min.js'></script>
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

$(document).ready(function(e) {
	var he = $('#referencia').height() - $('#header').height() - 160;
	var wi = $('#referencia').width() * 0.96;
	$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
	$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
	
	$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-90);
				
	$( window ).resize(function(e) {
		var he = $('#referencia').height() - $('#header').height() - 160;
		var wi = $('#referencia').width() * 0.96;
		$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
		$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
		
		$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-90);
    });
	
	var cuadrado = 35;
	$('button').css('width',cuadrado).css('height',cuadrado);
	$('#addConvenio').button({ icons: { primary: "ui-icon-plusthick" }, text: false });
	
	$('form').submit(function(event) { event.preventDefault(); });
	
	$("#departamentoE").load('files-serverside/genera_departamentoI.php');
	$("#areasE").load('files-serverside/genera_areas.php');
	
});

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
function nuevaEscuela(){ $(document).ready(function(e) { 
$("#dialog-confirmarNuevoPaciente").load("htmls/ficha_estudio.php",function(response, status, xhr){ if ( status == "success" ) { 
	tinymce.remove("#input");
	
	$('#formEstudio').validate({ ignore: 'hidden',
		//rules:{ input:{ required:true } }, messages:{ input:{required:'Debe ingresar el formato'} }
	});
		
	var he=$('#referencia').height()-100, wi = $('#referencia').width() * 0.97;
	
	$('#formEstudio').css('height',$("#dialog-confirmarNuevoPaciente").height()-100);

	$('#dialog-confirmarNuevoPaciente').dialog({
		title:'NUEVO FORMATO',modal:true,autoOpen:true,closeText:'',width:wi,height:he,closeOnEscape:false,
		dialogClass:'no-close',
		buttons: {
		"GUARDAR": function() {
			if($('#formEstudio').valid()){ 
				var datosP = {
					input:tinyMCE.get('input').getContent(),nombreNM:$('#nombreNM').val(),idusuarioNM:$('#idUser').val(), 
					area_nota:$('#area_nota').val()
				}
				$.post('files-serverside/addNota.php',datosP).done(function( data ) {
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
		tinymce.init({ 
			selector:'#contieneET #input',resize:false,height:$('#dialog-confirmarNuevoPaciente').height()*0.64,theme: "modern",
			plugins: 
				"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, responsivefilemanager, code, importcss",
			relative_urls: true,
			filemanager_title:"Administrador de archivos",
			filemanager_crossdomain: true,
			external_filemanager_path:"../tinymce/plugins/responsivefilemanager/filemanager/",
			external_plugins: { "filemanager" : "../tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js"},
			image_advtab: true,
			menubar: false, plugin_preview_width: $('#dialog-confirmarNuevoPaciente').width()*0.8,
			toolbar: 
				"table | undo redo | insert | styleselect | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink anchor | forecolor backcolor  | print_ preview code_ | emoticons_ | responsivefilemanager_",
			insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
			paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		});
		$("#area_nota").load("genera/areas_nota.php", function( response, status, xhr ){if(status=="success"){ }});
		
		$('#idusuarioNM').val($('#idUser').val());
		
		$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
		$('#dialog-confirmarNuevoPaciente textarea').css('height','99%'); 
		$("#ficha_estudio").tabs({active: 0}); $('#pestanas').removeClass('ui-widget-header');
		$('#ficha_estudio').removeClass('ui-widget-content');
		
	  },
	  close:function( event, ui ){ $('#dialog-confirmarNuevoPaciente').empty(); }
	});
} });
	
}); }

function verEscuela(x){ $(document).ready(function(e) { //asignamos el id del estudio
	$("#dialog-confirmarNuevoPaciente").load("htmls/ficha_estudio.php",function(response, status, xhr){ if ( status == "success" ){
		tinymce.remove("#input");
		$('#formEstudio').css('height',$("#dialog-confirmarNuevoPaciente").height()-100);
		
		var datos ={idN:x}
		$.post('files-serverside/fichaNotaM.php',datos).done(function( data1 ) {
			var datosI = data1.split('*}'); //alert(datosI)

			var he = $('#referencia').height() - 100, wi = $('#referencia').width() * 0.96;
			var title = 'FICHA DEL FORMATO. '+datosI[0];
			$('#dialog-confirmarNuevoPaciente').dialog({
				title:title,modal:true,autoOpen:true,closeText:'', width: wi, height: he, closeOnEscape: true, dialogClass: '',
				buttons: {
				"ACTUALIZAR": function() {
					if($('#formEstudio').valid()){
						var datosE = {
							input:tinyMCE.get('input').getContent(),nombreNM:$('#nombreNM').val(),idusuarioNM:$('#idUser').val(), 
							area_nota:$('#area_nota').val(), idEstudioE:x
						}
						$.post('files-serverside/updateNota.php',datosE).done(function( data ) {
							if (data==1){//si el paciente se Actualizó 
								$('#dialog-confirmarNuevoPaciente').dialog('close');$('#clickme').click();
								$('#dialog-confirmaAltaPaciente').dialog('open');
							}
							else{alert(data);}
						});
					}
				}, "CERRAR": function() { $(this).dialog('close'); }
			  },
			  open:function( event, ui ){
				$('#input').val(datosI[1]);
				tinymce.init({ 
					selector:'#contieneET #input',resize:false,height:$('#dialog-confirmarNuevoPaciente').height()*0.64,theme: "modern",
					plugins: 
						"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, responsivefilemanager, code, importcss",
					relative_urls: true,
					filemanager_title:"Administrador de archivos",
					filemanager_crossdomain: true,
					external_filemanager_path:"../tinymce/plugins/responsivefilemanager/filemanager/",
					external_plugins: { "filemanager" : "../tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js"},
					image_advtab: true,
					menubar: false, plugin_preview_width: $('#dialog-confirmarNuevoPaciente').width()*0.8,
					toolbar: 
						"undo redo | insert | styleselect | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink anchor | forecolor backcolor  | print_ preview code_ | emoticons_ | table | responsivefilemanager_",
					table_appearance_options: true,
					insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
					paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
				}); 
			  	$('#idEstudioE').val(x); $('#formEstudio').validate({ignore: 'hidden'});
				$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
				$('#dialog-confirmarNuevoPaciente textarea').css('height','99%');
					
				$('#nombreNM').val(datosI[0]);
				$("#area_nota").load("genera/areas_nota.php", function( response, status, xhr ){if(status=="success"){ 
					$("#area_nota").val(datosI[2]);
				}});
			  },
			  close:function( event, ui ){ $("#dialog-confirmarNuevoPaciente").empty(); }
			});
		});
	} });
}); }//fin verFicha
</script>

<script>
$(document).ready(function(e){
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
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_hospital.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">CATÁLOGO DE ESCUELAS</span></td>
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
  <table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" id="dataTablePrincipal" class="tablilla">
    <thead id="cabecera_tBusquedaPrincipal">
      <tr class="titulos_dataceldas">
      	<th id="clickme" align="center" width="1px" nowrap>#</th>
        <th align="center">CLAVE</th>
        <th align="center">NIVEL</th>
        <th align="center" nowrap>
        	NOMBRE
            <button style="font-size:0.4em;" id='addEscuela' onClick='nuevaEscuela()' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title='Agregar una nueva escuela'><span class='ui-icon ui-icon-plus'>s</span></button>
        </th>
        <th align="center">CONTROL</th>
        <th align="center">ESTADO</th>
        <th align="center">LOGO</th>
      </tr>
    </thead>
    <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot> <tr>
        <td><input name="sPaciente1" id="sPaciente1" type="hidden" class="search_init" style="width:90%;" /></td>
        <td>
        <input name="sClave" id="sClave" type="text" placeholder="-CLAVE-" class="search_init" style="width:90%;" />
        </td>
        <td><input name="sPaciente2" id="sPaciente2" type="hidden" class="search_init" style="width:90%;" /></td>
        <td>
        <input name="sNombre" id="sNombre" type="text" placeholder="-NOMBRE-" class="search_init" style="width:90%;" />
        </td>
        <td>
        <input name="sControl" id="sControl" type="text" placeholder="-CONTROL-" class="search_init" style="width:90%;" />
        </td>
        <td>
        <input name="sEntidad" id="sEntidad" type="text"placeholder="-ENTIDAD FEDERATIVA-" class="search_init"style="width:90%;" />
        </td>
        <td><input name="sPaciente3" id="sPaciente3" type="hidden" class="search_init" style="width:90%;" /></td>
  </tr> </tfoot>
  </table>
</div>

<div id="dialog-confirmarNuevoPaciente" style="display:none;"> </div>

<div id="dialog-confirmaAltaPaciente" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td align="center" valign="middle" height="100%">LOS DATOS DEL FORMATO SE HAN GUARDADO SATISFACTORIAMENTE</td> </tr>
</table>
</div>

<div id="dialog-verPaciente" align="right" style="display:none;"> </div>

<div id="dialog-nivel1" class="dialogos"></div> 
<div id="dialog-nivel2" class="dialogos"></div>
<div id="dialog-nivel3" class="dialogos"></div>
<div id="dialog-auxiliar" class="dialogos"></div>

<div id="dialog-confirmarAlgo" class="dialogos"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2"> <tr> <td align="center" valign="middle"><span id="textoAlgo"></span></td> </tr> </table> </div>

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
	var tamP = $('#referencia').height() - 131;
	
	oTableP = $('#dataTablePrincipal').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
		"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tamP, "bAutoWidth": false, 
		"bInfo": true, "bFilter": true, ordering: false, "iDisplayLength": 100,
		"aoColumns": [
			{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
			{"bSortable":false},{"bSortable":false}
		],
		"bLengthChange": false, "bProcessing": false, "bServerSide": true,
		"sDom": 't',
		"sAjaxSource": "datatable-serverside/escuelas.php",
		"fnServerParams":function(aoData, fnCallback){ 
			var access = $('#accesoU').val();
			aoData.push({"name": "access", "value": access });
		},
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
			"sInfo": "ENCONTRADAS: _END_", "sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "<span style='display:none;'><br/>NOTAS: _MAX_</span>", "sSearch": "",
			"oPaginate": {
				"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
				"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
			}
		}
		
	});
	
	$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right;'><table id='ocultarFP' style='float:right;' width='' border='0' cellspacing='0' cellpadding='6'> <tr><td></td> </tr> </table></div>" );
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { oTableP.fnFilter( this.value, $("tfoot input").index(this) ); } );
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus( function () { if ( this.className == "search_init" ) { this.className = ""; this.value = "";} } );
     
    $("tfoot input").blur( function (i) { if ( this.value == "" ) { this.className = "search_init"; this.value = asInitVals[$("tfoot input").index(this)]; } } );
	//fin filtros individuales por campo de texto
		
	$('.paginacionPrincipal').hide();
	
	$('#clickme').click(function(e) { oTableP.fnDraw(); });
	
});
</script>

<script>
$(document).ready(function(e) {
	var he1 = $('#referencia').height() - $('#header').height() - 100, wi1 = $('#referencia').width() * 0.97;
	
	$('#dialog-confirmaAltaPaciente').dialog({
		autoOpen: false, modal: true, width: 620, height:150, title: 'DATOS GUARDADOS', closeText: '',
		open:function( event, ui ){
			$('#dialog-confirmarNuevoPaciente').dialog('close');
			window.setTimeout(function(){$('#dialog-confirmaAltaPaciente').dialog('close');},2500);
		}
	});
    $('#dialog-verPaciente').dialog({autoOpen:false,modal:true,width:wi1,height:he1, title: 'FICHA DEL FORMATO', closeText:'' });
});

function subir_logo(id_s, name_s){ $(document).ready(function(e) {//alert(name_s);
	$('#dialog-nivel1').dialog({
		autoOpen:true,modal:true,width:850,height:190,title:'SUBIR EL LOGOTIPO DE LA ESCUELA '+name_s,closeText:'',
		closeOnEscape:true, dialogClass:'',
		open:function( event, ui ){
			$("#dialog-nivel1").load("../sucursales/htmls/subir_logo.php #documento",function(response,status,xhr){ if(status == "success"){
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
					$.post('../sucursales/files-serverside/eliminarLogo.php',datos).done(function( data ) { if (data==1){
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

function insertAtCaret(text) { tinymce.get("input").execCommand('mceInsertContent', false, text); $('#inserta_algo').val(''); }
</script>