<?php require_once('../Connections/productores.php'); ?>
<?php

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

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
if (!isset($_SESSION)) {
  session_start();
}
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
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
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

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_productores, $productores);
$query_usuario = sprintf("SELECT id_u, nombre_u, apaterno_u, amaterno_u, sucursal_u, activo_u, acceso_u, usuario_u, puesto_u FROM usuarios WHERE usuario_u = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $productores) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_productores, $productores);
$query_nombreSucursalUsuario = sprintf("SELECT nombre_su FROM sucursales WHERE id_su = %s", GetSQLValueString($row_usuario['sucursal_u'], "int"));
$nombreSucursalUsuario = mysql_query($query_nombreSucursalUsuario, $productores) or die(mysql_error());
$row_nombreSucursalUsuario = mysql_fetch_assoc($nombreSucursalUsuario);
$totalRows_nombreSucursalUsuario = mysql_num_rows($nombreSucursalUsuario);

mysql_select_db($database_productores, $productores);
$query_estados = "SELECT cve_ent, nom_ent FROM cat_entidades ORDER BY nom_ent ASC";
$estados = mysql_query($query_estados, $productores) or die(mysql_error());
$row_estados = mysql_fetch_assoc($estados);
$totalRows_estados = mysql_num_rows($estados);

$colname_miProductor = "-1";
if (isset($_POST['idProductor'])) {
  $colname_miProductor = $_POST['idProductor'];
}
mysql_select_db($database_productores, $productores);
$query_miProductor = sprintf("SELECT * FROM productor WHERE id_p = %s", GetSQLValueString($colname_miProductor, "int"));
$miProductor = mysql_query($query_miProductor, $productores) or die(mysql_error());
$row_miProductor = mysql_fetch_assoc($miProductor);
$totalRows_miProductor = mysql_num_rows($miProductor);

//sacamos entidad_cve (ESTADO)
mysql_select_db($database_productores, $productores);
$query_miEstado = sprintf("SELECT id_e FROM cat_entidades WHERE nom_ent = %s", GetSQLValueString($row_miProductor['direccion_estado_p'], "text"));
$miEstado = mysql_query($query_miEstado, $productores) or die(mysql_error());
$row_miEstado = mysql_fetch_assoc($miEstado);
$totalRows_miEstado = mysql_num_rows($miEstado);

//sacamos municipio_cve (MUNICIPIO)
mysql_select_db($database_productores, $productores);
$query_miMunicipio = sprintf("SELECT cve_mun FROM cat_municipios WHERE cve_ent = %s and nom_mun = %s", GetSQLValueString($row_miEstado['id_e'], "int"), GetSQLValueString($row_miProductor['direccion_municipio_p'], "text"));
$miMunicipio = mysql_query($query_miMunicipio, $productores) or die(mysql_error());
$row_miMunicipio = mysql_fetch_assoc($miMunicipio);
$totalRows_miMunicipio = mysql_num_rows($miMunicipio);

//Sacamos localidad_cve
mysql_select_db($database_productores, $productores);
$query_miLocalidad = sprintf("SELECT localidad_cve FROM cat_localidades WHERE entidad_cve = %s and municipio_cve = %s and localidad_nombre = %s", GetSQLValueString($row_miEstado['id_e'], "int"), GetSQLValueString($row_miMunicipio['cve_mun'], "int"), GetSQLValueString($row_miProductor['direccion_localidad_p'], "text"));
$miLocalidad = mysql_query($query_miLocalidad, $productores) or die(mysql_error());
$row_miLocalidad = mysql_fetch_assoc($miLocalidad);
$totalRows_miLocalidad = mysql_num_rows($miLocalidad);


mysql_select_db($database_productores, $productores);
$query_miGrupo = sprintf("SELECT nombre_g FROM grupo WHERE id_g = %s", GetSQLValueString($row_miProductor['id_grupo_p'], "int"));
$miGrupo = mysql_query($query_miGrupo, $productores) or die(mysql_error());
$row_miGrupo = mysql_fetch_assoc($miGrupo);
$totalRows_miGrupo = mysql_num_rows($miGrupo);

//Si es Socio
mysql_select_db($database_productores, $productores);
$query_socio = sprintf("SELECT count(id_so) as far FROM socios WHERE id_p_so = %s and id_g_so = %s", GetSQLValueString($row_miProductor['id_p'], "int"), GetSQLValueString($row_miProductor['id_grupo_p'], "int"));
$socio = mysql_query($query_socio, $productores) or die(mysql_error());
$row_socio = mysql_fetch_assoc($socio);
$totalRows_socio = mysql_num_rows($socio);

//nùmero de Acciones del Socio
mysql_select_db($database_productores, $productores);
$query_acciones = sprintf("SELECT acciones_so FROM socios WHERE id_p_so = %s", GetSQLValueString($row_miProductor['id_p'], "int"));
$miAcciones = mysql_query($query_acciones, $productores) or die(mysql_error());
$row_miAcciones = mysql_fetch_assoc($miAcciones);
$totalRows_miAcciones = mysql_num_rows($miAcciones);

//tipo de miembro en su asociación, sólo puede ser miembro de una, pero socio de muchas
mysql_select_db($database_productores, $productores);
$query_miMiembro = sprintf("SELECT puesto_a FROM asociados WHERE id_p_a = %s", GetSQLValueString($row_miProductor['id_p'], "int"));
$miMiembro = mysql_query($query_miMiembro, $productores) or die(mysql_error());
$row_miMiembro = mysql_fetch_assoc($miMiembro);
$totalRows_miMiembro = mysql_num_rows($miMiembro);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title><?php if($row_miProductor['temporal_p']==1) { echo "NUEVO PRODUCTOR";  }else{echo "ACTUALIZAR PRODUCTOR";} ?>. CENTRO ACOPIO</title>
<link href="../css/productor.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.10.2/css/blitzer/jquery-ui-1.10.3.custom.css" rel="stylesheet">
<script src="../jquery-ui-1.10.2/js/jquery-1.9.1.js"></script>
<script src="../jquery-ui-1.10.2/js/jquery-ui-1.10.2.custom.js"></script>
<script src="../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="../jquery/jquery.gomap-1.3.2.min.js"></script>
<script src="../jquery-validation/dist/jquery.validate.js"></script>

<script>
//para las tooltips
$( document ).tooltip({
	position: {
		my: "center bottom-20",	at: "center top",
		using: function( position, feedback ) {
			$( this ).css( position );
			$( "<div>" )
			.addClass( "arrow" )
			.addClass( feedback.vertical )
			.addClass( feedback.horizontal )
			.appendTo( this );
		}
	}
});
</script>
<script>
$(document).ready(function(e) {
	var requestG = $('#cGrupoP'),y,b;
		requestG.keyup(function(e) {
			var y1=$('#cGrupoP').val();
			var b1="files-serverside/catGrupos.php?grupo="+y1;
			$( "#cGrupoP" ).autocomplete({
				source: b1,
				minLength: 1
   			});
    	});
	
	$('#nombre_p').focus();
    var miUsuario = $('#miUsuario'),
		misDatosUsuario = $('#misDatosUsuario');
	misDatosUsuario.hide();
	miUsuario.mouseover(function(e) {
		misDatosUsuario.stop().show('explode','slow');
    });
	$('#cabecerita').mouseleave(function(e) {
		misDatosUsuario.stop().hide('explode','slow');
    });
});

</script>
<script>
  $(function() {
	  $('#bRFC').click(function( event ) {
        event.preventDefault();
      });
	  $('#bCURP').click(function( event ) {
        event.preventDefault();
      });
	  $('#bComprobante').click(function( event ) {
        event.preventDefault();
      });
	  $('#bFotografia').click(function( event ) {
        event.preventDefault();
      });
	  $('#bIdentificacion').click(function( event ) {
        event.preventDefault();
      });
    $('#save').click(function( event ) {
		$('#cFechaIUA1').val($('#cFechaIUA').val()[6]+$('#cFechaIUA').val()[7]+$('#cFechaIUA').val()[8]+$('#cFechaIUA').val()[9]+'-'+$('#cFechaIUA').val()[3]+$('#cFechaIUA').val()[4]+'-'+$('#cFechaIUA').val()[0]+$('#cFechaIUA').val()[1]);
		//evitamos que se envíe el formulario
        event.preventDefault();
		//hacemos que se valide el formulario
		if($('#formProductor').valid()){
			$('#dialog-save').dialog("open");
		}
		
    }).css('color','green');
	$('#save').button({
      icons: {
        primary: "ui-icon-locked"
      },
      text: false
    });
	
	$('#cancel').button().click(function( event ) {
        event.preventDefault();
		if($('#miFechaTemp').val()==0){
			window.location="productores.php";
		}else{
			$('#dialog-cancel').dialog('open');
		}
    }).css('color','red');
  
    $('#cFechaIUA').datepicker({
      changeMonth: true,
      changeYear: true,
	  nextText: "Siguiente",
	  prevText: "Anterior",
	  maxDate: "+0d",
	  minDate: new Date(2010, 1 - 1, 1),
	  dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ],
	  dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
	  monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septimbre", "Octubre", "Noviembre", "Diciembre" ],
	  monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
	  dateFormat: "dd-mm-yy"
    });
  });
  </script>
</head>

<body>

<div id="header" class="header">
<script>
$(document).ready(function(e) {
	$('#misDatosUsuario').css( 'right', '5%' );
});
</script>
<div class="cabecerita nop" id="cabecerita">
  
    <table width="100%" border="0" cellpadding="5" cellspacing="0">
      <tr valign="middle">
        <td width="10%" class="cabe" valign="middle" align="right"><img src="../imagenes/general/productor.png" height="25"></td>
        <td align="left" valign="middle">
        	<span>
            	<?php if($row_miProductor['temporal_p']==1) { echo "NUEVO PRODUCTOR";  }else{echo "PRODUCTOR";} ?>
            </span>
        </td>
        <td style="overflow:hidden;"  id="celdaUsuario" align="right">
        <span style="overflow:hidden;" id="miUsuario"><?php echo $row_usuario['usuario_u']; ?></span>
        <div id="misDatosUsuario">
        <table width="100%" border="0" cellspacing="2" cellpadding="">
  		<tr>
    		<td><img class="fotoUsuario" id="miFotoUsuario" src="../usuarios/takePicture/photos/<?php echo $row_usuario['id_u']; ?>.jpg" width="100"></td>
    		<td align="center"><?php echo $row_usuario['nombre_u']." ".$row_usuario['apaterno_u']." ".$row_usuario['amaterno_u']; ?>
            <br><span style="font-size:0.7em">(<?php echo $row_usuario['puesto_u']; ?>)</span>
            </td>
  		</tr>
		</table>
        <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
  		<tr>
    	<td style="font-weight:;" align="center"><?php echo $row_nombreSucursalUsuario['nombre_su']; ?></td>
  		</tr>
  		<tr>
    	<td style="font-size:0.8em;" align="center"></td>
  		</tr>
  		<tr>
    	<td style="font-size:1em;" align="center"><span style="text-decoration:underline; cursor:pointer;"><a style="font-size:1.1em;" href="<?php echo $logoutAction ?>">CERRAR SESIÓN</a></span></td>
  		</tr>
		</table>
        </div>
        </td>
         <td align="left" width="10%" valign="middle"><span><img id="miFotoUsuarioMini" src="../usuarios/takePicture/photos/<?php echo $row_usuario['id_u']; ?>.jpg"  height="20" width=""></span></td>
      </tr>
    </table>
  </div>
  
</div>

<script>
$(document).ready(function(e) {
	if($('#esSocio').val()==1){
		$("#socio").prop("checked", "checked");
		$('.acciones').show();
	}else{
		$("#socio").prop("checked", "");
		$('.acciones').hide();
	}
	$('#socio').click(function(e) {
    	if($("#socio").is(':checked')) {  
			$('#esSocio').val(1);
            $('.acciones').show();
        } else {  
			$('#esSocio').val(0);
            $('.acciones').hide();
        } 
	});
	
   $('#formProductor').validate({
	   rules:{
		   nombre_p:{
		   	required:true
		   },
		   apaterno_p:{
		   	required:true
		   },
		   curp_p:{
		   	required:true,
			minlength: 18,
			"remote":
                     {
                       url: 'files-serverside/checkCURPp.php?idP='+$('#idProductor').val(),
                       type: "post",
                       data:
                       {
                           curp:function()
                           {
                               return $('#curp_p').val();
                           }
                       }
					 }
		   },
		   cTipoIdentificacion_p:
		   {
		   	required:true
		   },
		   cNumeroID_p:
		   {
		   	required:true
		   },
		   cEstado_p:
		   {
		   	required:true
		   },
		   cMunicipio_p:
		   {
		   	required:true
		   },
		   cLocalidad_p:
		   {
		   	required:true
		   },
		   cGrupoP:
		   {
		   	required:true,
			"remote":
                     {
                       url: 'files-serverside/checkGRUPOp.php',
                       type: "post",
                       data:
                       {
                           grupo:function()
                           {
                               return $('#cGrupoP').val();
                           }
                       }
					 }
		   },
		   cProduccionP:
		   {
		   	required:true
		   },
		   email_p:
		   {
		   	email:true
		   },
		   acciones:
		   {
		   	required:true
		   }
	   },
	   messages:{
	    nombre_p:{
			required:'Debe proporcionar el nombre del Productor.'
		},
		apaterno_p:{
			required:'Debe proporcionar el apellido paterno del Productor.'
		},
		curp_p:{
			required:'Debe proporcionar el CURP del Productor.',
			minlength:'El CURP debe ser a 18 dígitos.',
			remote:'¡Este CURP ya ha sido registrado!'
		},
		cTipoIdentificacion_p:{
			required:'Debe seleccionar el tipo de identificación del Productor.'
		},
		cNumeroID_p:{
			required:'Debe proporcionar el número de la identificación del Productor.'
		},
		cEstado_p:{
			required:'Debe seleccionar el Estado en dónde reside el Productor.'
		},
		cMunicipio_p:{
			required:'Debe seleccionar el Municipio en dónde reside el Productor.'
		},
		cLocalidad_p:{
			required:'Debe seleccionar la Localidad en dónde reside el Productor.'
		},
		cGrupoP:{
			required:'Debe seleccionar la Asociación o Grupo que pertenece el Productor.',
			remote:'¡Este Grupo no Existe!'
		},
		cProduccionP:{
			required:'Debe seleccionar el tipo de Producto que siembra el Productor.'
		},
		email_p:{
			email:'Debe ingresar un Correo Electrónico Válido.'
		},
		acciones:{
			required:'Debe proporcionar el número de Acciones que posee el Productor en la Asociación que pertenece.'
		}
	   }
   }); 
});
</script>

<div id="contenedor" class="contenedor">

<form action="" method="post" name="formProductor" id="formProductor" target="_self">
  
  <div class="contenido" id="contenido" align="left">
  
  <table align="left" width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td height="1%" id="miMenu" valign="top" align="center">
        	<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
  			<tr align="center" valign="middle">
    		<td><div class="pestana d">INICIO</div></td>
    		<td>
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="pestana d" align="center">PRODUCTORES</div></td>
                  </tr>
                  <tr>
                    <td><div class="pestana d" align="center">CLIENTES</div></td>
                  </tr>
                </table>
            </td>
    		<td><div class="pestana d">USUARIOS</div></td>
    		<td><div class="pestana d">ASOCIACIONES</div></td>
    		<td><div class="pestana">PARCELAS</div></td>
            <td><img src="../imagenes/general/logo1.png" width="100" height=""></td>
    		<td><div class="pestana d">CRÉDITOS</div></td>
    		<td>
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="pestana d" align="center">ENTRADAS</div></td>
                  </tr>
                  <tr>
                    <td><div class="pestana d" align="center">SALIDAS</div></td>
                  </tr>
                </table>
            </td>
    		<td><div class="pestana d">REPORTE</div></td>
            <td><div class="pestana">COTIZACIONES</div></td>
  			</tr>
			</table>
        </td>
    </tr>
    <tr>
        <td align="right" style="font-size:1.2em;" id="miContenido" valign="center">
  			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  			<tr>
    		<td>&nbsp;</td>
    		<td id="celdaContenido" valign="top" align="left" width="90%">
             <table style="" id="tablaDatos" width="100%" border="0" cellspacing="0" cellpadding="0">
  			 <tr id="primerFila">
    		 <td valign="bottom" style="padding:10px 0px 0px 0px;"><p>
             	<span style="font-weight:bold; font-size:1.3em;">
                		<?php if($row_miProductor['temporal_p']==1) { echo "NUEVO PRODUCTOR";  }else{echo "ACTUALIZAR PRODUCTOR";} ?>
                </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="cursor:pointer" name="save" id="save" type="submit" value="Guardar">
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="cursor:pointer" name="cancel" id="cancel" type="submit" value="Cancelar">
             </p>
               	 <br>
    			 <?php if($row_miProductor['temporal_p']==1) { echo "Crear un nuevo PRODUCTOR";  }else{echo "Actualizar PRODUCTOR";} ?>. No olvide que los datos marcados con un <strong class="nop" style="color:yellow; font-size:1em;">*</strong> son OBLIGATORIOS.
             </td>
  			 </tr>
  		<tr>
    		 <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td align="center" colspan="2"><br>
    <p>
      <input name="idProductor" type="hidden" id="idProductor" value="<?php echo $_POST['idProductor']; ?>">
      <input name="cUsuario" type="hidden" id="cUsuario" value="<?php echo $row_usuario['id_u']; ?>">
      Indica el NOMBRE y los APELLIDOS del Productor.</p><br></td>
    </tr>
  <tr>
    <td align="right"><strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;Nombre</td>
    <td width="50%">
      <input name="nombre_p" type="text" autofocus class="cNombre campoDatosTabla" id="nombre_p" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" value="<?php echo $row_miProductor['nombre_p']; ?>"></td>
  </tr>
  <tr>
    <td align="right"><strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;APaterno</td>
    <td><input name="apaterno_p" type="text" class="cNombre campoDatosTabla" id="apaterno_p" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" value="<?php echo $row_miProductor['apaterno_p']; ?>"></td>
  </tr>
  <tr>
    <td align="right">AMaterno</td>
    <td><input name="amaterno_p" type="text" class="cNombre campoDatosTabla" id="amaterno_p" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" value="<?php echo $row_miProductor['amaterno_p']; ?>"></td>
  </tr>
  <tr>
    <td align="right">Fotografía</td>
    <td>
    <button id="bFotografia"></button>
    </td>
  </tr>
 </table>

           </td>
  		</tr>
        <tr id="segundaFila">
  		  <td>
           <table width="100%" border="0" cellspacing="0" cellpadding="3">
  			<tr>
    		<td align="center" colspan="4"><br>
    		Ingresa el CURP del Productor (18 dígitos).</td>
    		</tr>
  			<tr>
    		<td align="right"><br><strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;CURP</td>
    		<td width="50%" colspan="3"><br><input name="curp_p" type="text" class="cNombre campoDatosTabla" id="curp_p" onKeyUp="conMayusculas(this); curp(this.value, this.name);" value="<?php echo $row_miProductor['curp_p']; ?>" maxlength="18"></td>
  			</tr>
            <tr>
    <td align="right">Selecciona el archivo Imagen del CURP</td>
    <td colspan="3">
    <button id="bCURP"></button>
    </td>
  </tr>
  			<tr>
    		<td align="right">RFC</td>
   	 		<td><input name="rfc_p" type="text" class="cNombre campoDatosTabla" id="rfc_p" value="<?php echo $row_miProductor['rfc_p'][0].$row_miProductor['rfc_p'][1].$row_miProductor['rfc_p'][2].$row_miProductor['rfc_p'][3].$row_miProductor['rfc_p'][4].$row_miProductor['rfc_p'][5].$row_miProductor['rfc_p'][6].$row_miProductor['rfc_p'][7].$row_miProductor['rfc_p'][8].$row_miProductor['rfc_p'][9]; ?>" maxlength="10" readonly></td>
   	 		<td align="right">&nbsp;&nbsp;Homoclave</td>
   	 		<td><input name="homo_p" type="text" class="cNombre campoDatosTabla" id="homo_p" maxlength="3" onKeyUp="conMayusculas(this); curp(this.value, this.name);"></td>
  			</tr>
            <tr>
    <td align="right">Selecciona el archivo Imagen del RFC</td>
    <td colspan="3">
    <button id="bRFC"></button>
    </td>
  </tr>
		   </table>

          </td>
  		</tr>
        
        <tr id="terceraFila">
  		<td>
  <table id="datosIdentificacion" width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td colspan="4" align="center">
    <br>
    Indica los datos de IDENTIFICACIÓN del Productor.
    <input name="fechaCumpleP" id="fechaCumpleP" type="hidden">
    <input name="tIdentificacion" type="hidden" id="tIdentificacion" value="<?php echo $row_miProductor['tipo_identificacion_p']; ?>"></td>
    </tr>
  <tr>
    <td align="right"><br>
    <strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;
    Tipo de Identificación
    </td>
    <td id="xx" width="50%" colspan="3"><br>
    <select name="cTipoIdentificacion_p" id="cTipoIdentificacion_p" class="cNombre campoDatosTabla">
      <option value="" selected>- SELECCIONAR -</option>
      <option value="CREDENCIAL DE ELECTOR">CREDENCIAL DE ELECTOR</option>
      <option value="LICENCIA DE CONDUCIR">LICENCIA DE CONDUCIR</option>
      <option value="PASAPORTE">PASAPORTE</option>
      <option value="CARTILLA MILITAR">CARTILLA MILITAR</option>
      <option value="TITULO PROFESIONAL">TÍTULO PROFESIONAL</option>
    </select>
    </td>
  </tr>
  <script>
  $(document).ready(function(e) {
	  var valor=$('#tIdentificacion').val();
   $('#cTipoIdentificacion_p').val(valor);
  });
  </script>
  <tr>
    <td align="right">
    <strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;
    Número de <span id="spanTidentificacion">Identificación</span>
    </td>
    <td width="50%" colspan="3"><input name="cNumeroID_p" type="text" class="cNombre campoDatosTabla" id="cNumeroID_p" onKeyUp="conMayusculas(this); curp(this.value, this.name);" value="<?php echo $row_miProductor['numero_identidicacion_p']; ?>"></td>
  </tr>
  <tr>
    <td align="right">
    Selecciona el archivo Imagen de la Identificación
    </td>
    <td colspan="3"><button id="bIdentificacion"></button></td>
  </tr>
  <tr>
    <td align="center" colspan="4"><br>
	Ingresa los datos de la DIRECCIÓN del Productor.
      <input name="edo" type="hidden" id="edo" value="<?php echo $row_miEstado['id_e']; ?>">
      <input name="miMunicipio" type="hidden" id="miMunicipio" value="<?php echo $row_miProductor['direccion_municipio_p']; ?>">
      <input name="miMunicipio1" type="hidden" id="miMunicipio1" value="<?php echo $row_miMunicipio['cve_mun']; ?>">
      <input name="localida" type="hidden" id="localida" value="<?php echo $row_miLocalidad['localidad_cve']; ?>">
      </td>
    </tr>
  <tr>
    <td align="right" width="50%"><br>
    <strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;
    Estado
    </td>
    <td colspan="3"><br>
    <select class="cNombre campoDatosTabla" name="cEstado_p" id="cEstado_p">
      <option value="">- SELECCIONAR -</option>
      <?php
do {  
?>
      <option value="<?php echo $row_estados['cve_ent']?>"><?php echo $row_estados['nom_ent']?></option>
      <?php
} while ($row_estados = mysql_fetch_assoc($estados));
  $rows = mysql_num_rows($estados);
  if($rows > 0) {
      mysql_data_seek($estados, 0);
	  $row_estados = mysql_fetch_assoc($estados);
  }
?>
    </select>
    </td>
  </tr>
  <script>
  $(document).ready(function(e) {
	  var valor1=$('#edo').val();
   $('#cEstado_p').val(valor1);
  });
  </script>
  <tr>
    <td align="right">
    <strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;
    Municipio
    </td>
    <td width="50%" colspan="3">
    <select class="cNombre campoDatosTabla" name="cMunicipio_p" id="cMunicipio_p"></select>
    </td>
  </tr>
  <tr>
    <td align="right">
    <strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;
    Localidad
    </td>
    <td width="50%" colspan="3">
    <select class="cNombre campoDatosTabla" name="cLocalidad_p" id="cLocalidad_p"></select>
    </td>
  </tr>
  <tr>
    <td align="right">
    Colonia
    </td>
    <td width="50%" colspan="3">
    <input name="cColonia_p" type="text" class="cNombre campoDatosTabla" id="cColonia_p" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" value="<?php echo $row_miProductor['direccion_colonia_p']; ?>">
    </td>
  </tr>
   <tr>
    <td align="right">
    Calle
    </td>
    <td width="50%" colspan="3">
    <input name="cCalle_p" type="text" class="cNombre campoDatosTabla" id="cCalle_p" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" value="<?php echo $row_miProductor['direccion_calle_p']; ?>">
    </td>
  </tr>
  <tr>
    <td align="right">
    Número
    </td>
    <td width="50%">
    <input name="cNumero_p" type="text" class="cNombre campoDatosTabla" id="cNumero_p" onKeyUp="conMayusculas(this); curp(this.value, this.name);" value="<?php echo $row_miProductor['direccion_numero_p']; ?>">
    </td>
    <td width="25%" align="right">&nbsp;C.P.&nbsp;&nbsp;</td>
    <td width="">
    <input name="cCP_p" type="text" class="cNombre campoDatosTabla" id="cCP_p" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" value="<?php echo $row_miProductor['direccion_cp_p']; ?>" maxlength="5">
    </td>
  </tr>
  <tr>
    <td align="right">
    <span id="mapa" style="font-style:italic; cursor:pointer; text-decoration:underline; color:; text-transform:uppercase;"><span id="miMapa">Ver Mapa</span></span>
    </td>
    <td width="50%" colspan="3">
    </td>
  </tr>
  <tr>
    <td colspan="4" align="center"><br>
      Indica los datos para Comprobar el Domicilio del Productor.
        <input name="miComprobante" type="hidden" id="miComprobante" value="<?php echo $row_miProductor['tipo_comprobante_domicilio_p']; ?>"></td>
    </tr>
  <tr>
    <td align="right"><br>
    Tipo de Comprobante
    </td>
    <td width="50%" colspan="3"><br>
    <select class="cNombre campoDatosTabla" name="cComprobante_p" id="cComprobante_p">
      <option value="0">- SELECCIONAR -</option>
      <option value="TELMEX">TELMEX</option>
      <option value="CFE">CFE</option>
      <option value="ESTADO DE CUENTA">ESTADO DE CUENTA</option>
    </select>
    </td>
  </tr>
  <script>
  $(document).ready(function(e) {
	  $('#cCP_p').css('width','70px');
	  var valor4=$('#miComprobante').val();
   $('#cComprobante_p').val(valor4);
  });
  </script>
  <tr>
    <td align="right">
    Selecciona el archivo Imagen del Comprobante
    </td>
    <td colspan="3"><button id="bComprobante"></button></td>
  </tr>
  <tr>
    <td align="center" colspan="4"><br>
	<p>Datos Adicionales del Productor.
	  <input name="miProduccion" type="hidden" id="miProduccion" value="<?php echo $row_miProductor['produccion_p']; ?>">
	</p>
    </td>
  </tr>
  <tr>
    <td align="right"><br>
    Email</td>
    <td width="50%" colspan="3"><br>
      <input name="email_p" type="text" autofocus class="cNombre campoDatosTabla" id="email_p" onKeyUp="emailx(this.value, this.name);" value="<?php echo $row_miProductor['email_p']; ?>" maxlength="70"></td>
  </tr>
  <tr>
    <td align="right"><strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;Número de Teléfono Particular</td>
    <td width="50%" colspan="3">
      <input name="cTelefonoParticularP" type="text" class="cNombre campoDatosTabla" id="cTelefonoParticularP" onKeyUp="conMayusculas(this); telefono(this.value, this.name);" value="<?php echo $row_miProductor['telefonoParticular_p']; ?>" maxlength="20"></td>
  </tr>
  <tr>
    <td align="right"><strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;Número de Teléfono Celular</td>
    <td width="50%" colspan="3">
      <input name="cTelefonoCelularP" type="text" class="cNombre campoDatosTabla" id="cTelefonoCelularP" onKeyUp="conMayusculas(this); telefono(this.value, this.name);" value="<?php echo $row_miProductor['telefonoCelular_p']; ?>" maxlength="20"></td>
  </tr>
  <tr>
    <td align="right">
    	Fecha de Ingreso a la Unión de Asociaciones Productoras
        <input name="cFechaIUA1" type="hidden" id="cFechaIUA1" value="">
        <input name="miFechaTemp" type="hidden" id="miFechaTemp" value="<?php echo $row_miProductor['temporal_p']; ?>">
        </td>
    <td width="50%" colspan="3">
      <input name="cFechaIUA" style="cursor:pointer;" type="text" class="cNombre campoDatosTabla" id="cFechaIUA" value="<?php echo DATE('d-m-Y'); ?>" readonly></td>
  </tr>
  <tr>
    <td align="right"><strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;Asociación o Grupo al que Pertenece</td>
    <td width="50%" colspan="3">
      <input name="cGrupoP" type="text" class="cNombre campoDatosTabla" id="cGrupoP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" value="<?php echo $row_miGrupo['nombre_g']; ?>"></td>
  </tr>
  <tr>
    <td align="right">Función en su Asociación</td>
    <td width="50%" colspan="3">
      <select class="cNombre campoDatosTabla" name="funcion" id="funcion">
        <option value="MIEMBRO" <?php if (!(strcmp("MIEMBRO", $row_miMiembro['puesto_a']))) {echo "selected=\"selected\"";} ?>>MIEMBRO</option>
        <option value="PRESIDENTE" <?php if (!(strcmp("PRESIDENTE", $row_miMiembro['puesto_a']))) {echo "selected=\"selected\"";} ?>>PRESIDENTE</option>
        <option value="VICEPRESIDENTE" <?php if (!(strcmp("VICEPRESIDENTE", $row_miMiembro['puesto_a']))) {echo "selected=\"selected\"";} ?>>VICEPRESIDENTE</option>
        <option value="SECRETARIO" <?php if (!(strcmp("SECRETARIO", $row_miMiembro['puesto_a']))) {echo "selected=\"selected\"";} ?>>SECRETARIO</option>
        <option value="TESORERO" <?php if (!(strcmp("TESORERO", $row_miMiembro['puesto_a']))) {echo "selected=\"selected\"";} ?>>TESORERO</option>
        <option value="FISCAL" <?php if (!(strcmp("FISCAL", $row_miMiembro['puesto_a']))) {echo "selected=\"selected\"";} ?>>FISCAL</option>
        <option value="OTRO" <?php if (!(strcmp("OTRO", $row_miMiembro['puesto_a']))) {echo "selected=\"selected\"";} ?>>OTRO</option>
      </select>
      </td>
  </tr>
  <tr>
    <td align="right"><input name="esSocio" type="hidden" id="esSocio" value="<?php 
			if($row_socio['far'] > 0 and $row_miAcciones['acciones_so'] > 0){
			echo 1; }else { echo 0;}
		?>">
      Socio de su Asociación&nbsp;<input name="socio" id="socio" type="checkbox"></td>
    <td width="50%" align="right"><span class="acciones">Acciones</span></td>
    <td width="25" colspan="2">
      <span class="acciones"><input name="acciones" type="text" class="cNombre campoDatosTabla" id="acciones" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" value="<?php echo $row_miAcciones['acciones_so']; ?>"></span>
      </td>
  </tr>
  <tr>
    <td align="right"><strong class="nop" style="color:yellow; font-size:1em;">*</strong>&nbsp;Producción</td>
    <td width="50%" colspan="3">
    	<select class="cNombre campoDatosTabla" name="cProduccionP" id="cProduccionP">
    	  <option value="" <?php if (!(strcmp("", $row_miProductor['produccion_p']))) {echo "selected=\"selected\"";} ?>>- SELECCIONAR - </option>
    	  <option value="SORGO" <?php if (!(strcmp("SORGO", $row_miProductor['produccion_p']))) {echo "selected=\"selected\"";} ?>>SORGO</option>
    	  <option value="MAIZ" <?php if (!(strcmp("MAIZ", $row_miProductor['produccion_p']))) {echo "selected=\"selected\"";} ?>>MAIZ</option>
    	  <option value="AMBOS" <?php if (!(strcmp("AMBOS", $row_miProductor['produccion_p']))) {echo "selected=\"selected\"";} ?>>AMBOS</option>
    	</select>  
    </td>
  </tr>
  <script>
  $(document).ready(function(e) {
	  var valor5=$('#miProduccion').val();
   $('#cProduccionP').val(valor5);
  });
  </script>
  <tr>
    <td align="right">Antiguedad en Producción(Años)</td>
    <td width="50%" colspan="3">
      <input name="cAntiguedadP" type="text" class="cNombre campoDatosTabla" id="cAntiguedadP" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" value="<?php echo $row_miProductor['antiguedad_produccion_p']; ?>" maxlength="2"></td>
  </tr>
  <tr>
    <td align="right">Actividad Principal(Ocupación)<br><br><br></td>
    <td width="50%" colspan="3">
      <input name="cOcupacionP" type="text" class="cNombre campoDatosTabla" id="cOcupacionP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" value="<?php echo $row_miProductor['actividad_principal_p']; ?>"><br><br><br>
      </td>
  </tr>
  </table>

        </td>
  		</tr>
        
			 </table>

             </td>
    		 <td>&nbsp;</td>
  			</tr>
			</table>

        </td>
    </tr>
</table>
  </div>
</form>
</div>
<script>
             $(document).ready(function(e) {
			  var mapa = $('#mapa'),dialogMap=$('#dialog-mapa');
			  mapa.hide();
			  $('#cMunicipio_p').change(function(e) {
              	if($(this).val()!=''){
					mapa.show();
				} else{mapa.hide();}
              });
			  $('#cEstado_p').change(function(e) {
              	if($(this).val()!=''){
				} else{mapa.hide();}
              });
				
                miMapa=$('#miMapa'); miMapa.click(function(e) {
					
					var direccion, estado=$('#cEstado_p option:selected').text(),municipio=$('#cMunicipio_p option:selected').text(),localidad=$('#cLocalidad_p option:selected').text(),colonia=$('#cColonia_p').val(),calle=$('#cCalle_p').val(),numero=$('#cNumero_p').val(),cp=$('#cCP_p').val();
					direccion='MEXICO'+' '+estado+' '+localidad+' COLONIA '+colonia+' '+calle+' '+numero+' ';
							
					$('#dialog-mapa').dialog('open');
					
					dialogMap.html('<div id="map"></div>');
					
					$('#map').goMap({
						address:direccion,zoom:18, maptype:'hybrid',
						markers:[
						{
							address:direccion,
							title:'AQUÍ',
							html:{
								content: '<span style="color:black"><p>DIRECCIÓN DEL PRODUCTOR</p></span>', 
                				popup:true
							}
						}
						]
					});
                    //alert(direccion);
                });
            });
             </script>

<div class="footer" id="footer">
<table width="100%" height="100%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="middle"><span id="divFooter">
    Copyright © 2013 | UNION DE ASOCIACIONES PRODUCTORAS DE GRANOS BASICOS DE LA ZONA ORIENTE DE MORELOS SPR DE RL. Todos los Derechos Reservados.
    </span></td>
  </tr>
</table>
</div>

<div id="dialog-mapa"></div>
<script>
$(document).ready(function(e) {
    $('#dialog-mapa').dialog({
		width: 790,
		height: 480,
		modal:true,
		title: 'DIRECCIÓN DEL PRODUCTOR. MAPA',
		autoOpen: false,
		closeText: ''
	});
});
</script>
<div id="dialog-fotografia" title="tituloVentanaFotografia">
  &nbsp;
</div>

<div id="dialog-cancel"><br>
<p>¿Desea Cancelar el Registro del Productor?</p>
</div>
<div id="dialog-save"><br>
<p>¿Desea Guardar el Registro del Productor?</p>
</div>
<div id="dialog-confirmaSave"><br>
<p>¡Los datos se guardaron satisfactoriamente!</p>
</div>

</body>
</html>
<?php
mysql_free_result($usuario);
mysql_free_result($nombreSucursalUsuario);
mysql_free_result($estados);
mysql_free_result($miEstado);
mysql_free_result($miMunicipio);
mysql_free_result($miLocalidad);
mysql_free_result($miProductor);
mysql_free_result($miGrupo);
mysql_free_result($miAcciones);
mysql_free_result($socio);
mysql_free_result($miMiembro);
?>

<script>
$(document).ready(function(){
	$('#dialog-cancel').dialog({
		title: 'CONFIRMAR CANCELACIÓN',
		modal: true,
		autoOpen: false,
		closeText: '',
		width: 450,
		height: 210,
		closeOnEscape: false,
		dialogClass: 'no-close',
		buttons: {
        "Aceptar": function() {
          var misDatos1 = $('#formProductor').serialize();
		  $.post('files-serverside/cancelProductor.php',misDatos1,processData1);
			function processData1(data){
				if (data=='ok'){
					window.location="productores.php";
					//alert(data);
				}
				else{
					alert(data);
				}
			}
        },
        "Cancelar": function() {
          $( this ).dialog( "close" );
        }
      }
	});
	$('#dialog-save').dialog({
		title: 'CONFIRMAR GUARDAR',
		modal: true,
		autoOpen: false,
		closeText: '',
		width: 450,
		height: 210,
		closeOnEscape: false,
		dialogClass: 'no-close',
		buttons: {
        "Aceptar": function() {
		  var misDatos = $('#formProductor').serialize();
		  $.post('files-serverside/updateProductor.php',misDatos,processData);
			function processData(data){
				if (data=='ok'){
					$('#dialog-save').dialog( "close" );
					$('#dialog-confirmaSave').dialog( "open" );
					//alert('ok');
				}
				else{
					alert(data);
				}
			}
        },
        "Cancelar": function() {
          $( this ).dialog( "close" );
        }
      }
	});
	$('#dialog-confirmaSave').dialog({
		title: 'CONFIRMACIÓN DATOS GUARDADOS',
		modal: true,
		autoOpen: false,
		closeText: '',
		width: 450,
		height: 210,
		closeOnEscape: false,
		dialogClass: 'no-close',
		buttons: {
        "Continuar": function() {
          $( this ).dialog( "close" );
		  window.location="productores.php";
        }
      }
	});
	
    	$("#cEstado_p").change(function(event){
			var id = $("#cEstado_p").find(':selected').val();
    	    $("#cMunicipio_p").load('files-serverside/genera_municipios.php?id='+escape(id));	
			if ($("#cEstado_p").val()==0){
				var id1x = $("#cEstado_p").find(':selected').val();
 	            var idx = $("#cMunicipio_p").find(':selected').val();
				$("#cLocalidad_p").load('files-serverside/genera_localidades.php?id='+escape(idx)+'&id1='+escape(id1x));
			}
        });
		$("#cMunicipio_p").change(function(event){
			var id1x = $("#cEstado_p").find(':selected').val();
            var idx = $("#cMunicipio_p").find(':selected').val();
            $("#cLocalidad_p").load('files-serverside/genera_localidades.php?id='+escape(idx)+'&id1='+escape(id1x));
        });
		//cuando se trata de Actualizar al paciente:
		if($('#edo').val()!=''){
			var id = $("#cEstado_p").find(':selected').val(),
				municip = $('#miMunicipio').val();
    	    $("#cMunicipio_p").load('files-serverside/genera_municipios.php?id='+escape(id)+'&municipio='+escape(municip));	
			
			
			var id1x = $("#cEstado_p").find(':selected').val();
            var idx = $("#miMunicipio1").val();
			var localida = $('#localida').val();
			
            $("#cLocalidad_p").load('files-serverside/genera_localidades.php?id='+escape(idx)+'&id1='+escape(id1x)+'&localidad='+escape(localida));
		}
		
		$('#verMapa').hide();
		
		var bFotografia = $('#bFotografia'),
			bIdentificacion = $('#bIdentificacion'),
			bCURP = $('#bCURP'),
			bRFC = $('#bRFC'),
			bComprobante = $('#bComprobante');
		
		bRFC.button({
      		icons: {
        		primary: "ui-icon-image"
      		}
    	});
		
		bRFC.css('width','36px').css('height','35px');
		bRFC.click(function(e) {
		  $('#dialog-fotografia').html('<table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td height="10%" align="left">Selecciona el archivo del RFC del Productor.</td>  </tr><tr><td valign="top"><iframe id="frameFotoP" name="frameFotoP" allowtransparency="yes" frameborder="0" width="500" height="440" src="takePicture/subirRFCp.htm"></iframe><span style="display:block; color:red;" id="response"></span></td></tr></table>');
		  $('#dialog-fotografia').dialog({
			title: 'ARCHIVO DEL RFC DEL PRODUCTOR',
			modal: true,
			closeText: '',
			autoOpen: false,
			width: 550,
			height: 600,
			closeOnEscape: true
		  });
		  $('#dialog-fotografia').dialog('open');
		  window.frames.frameFotoP.asigna($('#idProductor').val());
        });
		
		bCURP.button({
      		icons: {
        		primary: "ui-icon-image"
      		}
    	});
		
		bCURP.css('width','36px').css('height','35px');
		bCURP.click(function(e) {
		  $('#dialog-fotografia').html('<table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td height="10%" align="left">Selecciona el archivo del CURP del Productor.</td>  </tr><tr><td valign="top"><iframe id="frameFotoP" name="frameFotoP" allowtransparency="yes" frameborder="0" width="500" height="440" src="takePicture/subirCURPp.htm"></iframe><span style="display:block; color:red;" id="response"></span></td></tr></table>');
		  $('#dialog-fotografia').dialog({
			title: 'ARCHIVO DEL CURP DEL PRODUCTOR',
			modal: true,
			closeText: '',
			autoOpen: false,
			width: 550,
			height: 600,
			closeOnEscape: true
		  });
		  $('#dialog-fotografia').dialog('open');
		  window.frames.frameFotoP.asigna($('#idProductor').val());
        });
		
		bFotografia.button({
      		icons: {
        		primary: "ui-icon-image"
      		}
    	});
		
		bFotografia.css('width','36px').css('height','35px');
		bFotografia.click(function(e) {
		  $('#dialog-fotografia').html('<table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td height="10%" align="left">Selecciona una Fotografía para el Perfíl del Productor.</td>  </tr><tr><td valign="top"><iframe id="frameFotoP" name="frameFotoP" allowtransparency="yes" frameborder="0" width="500" height="440" src="takePicture/subirFotoProductor.htm"></iframe><span style="display:block; color:red;" id="response"></span></td></tr></table>');
		  $('#dialog-fotografia').dialog({
			title: 'FOTOGRAfÍA DEL PRODUCTOR',
			modal: true,
			closeText: '',
			autoOpen: false,
			width: 550,
			height: 600,
			closeOnEscape: true
		  });
		  $('#dialog-fotografia').dialog('open');
		  window.frames.frameFotoP.asigna($('#idProductor').val());
        });
		
		bIdentificacion.button({
      		icons: {
        		primary: "ui-icon-image"
      		}
    	});
		bIdentificacion.css('width','36px').css('height','35px');
		bIdentificacion.click(function(e) {
            $('#dialog-fotografia').html('<table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td height="10%" align="left">Selecciona los archivos de imagen de Identificación del Productor.</td>  </tr><tr><td valign="top"><iframe id="frameFotoP" name="frameFotoP" allowtransparency="yes" frameborder="0" width="600" height="440" src="takePicture/subirFotosIdentificacion.htm"></iframe><span style="display:block; color:red;" id="response"></span></td></tr></table>');
		  $('#dialog-fotografia').dialog({
			title: 'ARCHIVOS DE LA IDENTIFICACIÓN DEL PRODUCTOR',
			modal: true,
			closeText: '',
			autoOpen: false,
			width: 650,
			height: 600,
			closeOnEscape: true
		  });
		  $('#dialog-fotografia').dialog('open');
		  window.frames.frameFotoP.asigna($('#idProductor').val());
        });
		
		bComprobante.button({
      		icons: {
        		primary: "ui-icon-image"
      		}
    	});
		
		bComprobante.css('width','36px').css('height','35px');
		bComprobante.click(function(e) {
            $('#dialog-fotografia').html('<table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td height="10%" align="left">Selecciona el Archivo del Comprobante de Domicilio del Productor.</td>  </tr><tr><td valign="top"><iframe id="frameFotoP" name="frameFotoP" allowtransparency="yes" frameborder="0" width="500" height="440" src="takePicture/subirFotoComprobanteD.htm"></iframe><span style="display:block; color:red;" id="response"></span></td></tr></table>');
		  $('#dialog-fotografia').dialog({
			title: 'COMPROBANTE DE DOMICILIO DEL PRODUCTOR',
			modal: true,
			closeText: '',
			autoOpen: false,
			width: 550,
			height: 600,
			closeOnEscape: true
		  });
		  $('#dialog-fotografia').dialog('open');
		  window.frames.frameFotoP.asigna($('#idProductor').val());
        });
     });
	 
	 function asigna(){
		 return document.getElementById('idProductor').value;
	 }
	 
	 function badFP(x){
		 $(document).ready(function(e) {
  			  $('#response').html(x); 
         });
	 }
	 
	 function goodFP(){
		 $(document).ready(function(e) {
  			  $('#response').html(''); 
         });
	 }
	 
	 function goodFP1(){
		 $(document).ready(function(e) {
  			  $('#response').html('El Archivo se subió correctamente, ahora puede cerrar la ventana.'); 
         });
	 }
	 $(document).ready(function(e) {
        $('#curp_p').keyup(function(e) {
			if($('#curp_p').val().length>9){
	            $('#rfc_p').val($(this).val()[0]+$(this).val()[1]+$(this).val()[2]+$(this).val()[3]+$(this).val()[4]+$(this).val()[5]+$(this).val()[6]+$(this).val()[7]+$(this).val()[8]+$(this).val()[9]);
				$('#fechaCumpleP').val($(this).val()[4]+$(this).val()[5]+'-'+$(this).val()[6]+$(this).val()[7]+'-'+$(this).val()[8]+$(this).val()[9]);
			}
        });
    });
</script>