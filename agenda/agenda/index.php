<?php require_once('../../Connections/horizonte.php'); ?>
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
	
  $logoutGoTo = "../../index.php";
  if ($logoutGoTo) { header("Location: $logoutGoTo"); exit; }
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
    if (in_array($UserName, $arrUsers)) { $isValid = true; } 
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

mysql_select_db($database_horizonte, $horizonte);
$query_nombreSucursalUsuario = sprintf("SELECT nombre_su FROM sucursales WHERE clave_su = %s", GetSQLValueString($row_usuario['idSucursal_u'], "text"));
$nombreSucursalUsuario = mysql_query($query_nombreSucursalUsuario, $horizonte) or die(mysql_error());
$row_nombreSucursalUsuario = mysql_fetch_assoc($nombreSucursalUsuario);
$totalRows_nombreSucursalUsuario = mysql_num_rows($nombreSucursalUsuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombreDepartamentoUsuario = sprintf("SELECT id_d, nombre_d FROM departamentos WHERE id_d = %s", GetSQLValueString($row_usuario['idDepartamento_u'], "int"));
$nombreDepartamentoUsuario = mysql_query($query_nombreDepartamentoUsuario, $horizonte) or die(mysql_error());
$row_nombreDepartamentoUsuario = mysql_fetch_assoc($nombreDepartamentoUsuario);
$totalRows_nombreDepartamentoUsuario = mysql_num_rows($nombreDepartamentoUsuario);

mysql_select_db($database_horizonte, $horizonte);
$query_areas_estudiosL = "SELECT nombre_a, id_a FROM areas WHERE departamento_a = 1 ORDER BY nombre_a asc";
$areas_estudiosL = mysql_query($query_areas_estudiosL, $horizonte) or die(mysql_error());
$row_areas_estudiosL = mysql_fetch_assoc($areas_estudiosL);
$totalRows_areas_estudiosL = mysql_num_rows($areas_estudiosL);

mysql_select_db($database_horizonte, $horizonte);
$query_fechaRangoInicial = "SELECT fecha_venta_vc FROM venta_conceptos where tipo_concepto_vc = 3 ORDER BY fecha_venta_vc ASC limit 1";
$fechaRangoInicial = mysql_query($query_fechaRangoInicial, $horizonte) or die(mysql_error());
$row_fechaRangoInicial = mysql_fetch_assoc($fechaRangoInicial);
$totalRows_fechaRangoInicial = mysql_num_rows($fechaRangoInicial);

mysql_select_db($database_horizonte, $horizonte);
$query_fechaRangoFinal = "SELECT fecha_venta_vc FROM venta_conceptos where tipo_concepto_vc = 3 ORDER BY fecha_venta_vc DESC limit 1";
$fechaRangoFinal = mysql_query($query_fechaRangoFinal, $horizonte) or die(mysql_error());
$row_fechaRangoFinal = mysql_fetch_assoc($fechaRangoFinal);
$totalRows_fechaRangoFinal = mysql_num_rows($fechaRangoFinal);

mysql_select_db($database_horizonte, $horizonte);
$query_departamentosOV = "
	SELECT distinct(d.id_d), d.nombre_d FROM venta_conceptos vc left join departamentos d on d.id_d = vc.departamento_vc where d.id_d != 15 ORDER BY nombre_d ASC
";
$departamentosOV = mysql_query($query_departamentosOV, $horizonte) or die(mysql_error());
$row_departamentosOV = mysql_fetch_assoc($departamentosOV);
$totalRows_departamentosOV = mysql_num_rows($departamentosOV);
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../../imagenes/general/favicon.ico">
<meta charset="utf-8">
<title>LISTADO DE CITAS</title>

<link href="../../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../../css/caja.css" rel="stylesheet" type="text/css">
<link href="../../jquery-ui-1.11.4/flick/jquery-ui.css" rel="stylesheet">
<link href="../../TableTools-2.1.5/media/css/TableTools.css" rel="stylesheet">

<script src="../../jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="../../jquery-ui-1.11.4/jquery-ui.js"></script>
<script src="../../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
<script src="../../TableTools-2.1.5/media/js/TableTools.js"></script>
<script src="../../TableTools-2.1.5/media/js/ZeroClipboard.js"></script>
<script src="../../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../../funciones/js/caracteres.js"></script>
<script src="../../funciones/js/redondea.js"></script>

<script language="javascript"> //para las tooltips
$( document ).tooltip({ position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ) { $( this ).css( position ); $( "<div>" ).addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this ); } } });

$(document).ready(function() { //inicializaciones					
	$('#menu_lat img').css('width','70%').css('height','84%').css('background-color','rgba(255,255,255,0.9)').css('border-radius','6px');
	$('#menu_lat img').hover(function(e) { $(this).css('cursor','pointer'); });									
});
</script>

<script>
$(document).ready(function(e) {
    var miUsuario = $('.miUsuario'),
	misDatosUsuario = $('#misDatosUsuario');
	misDatosUsuario.hide();
	 var dj = 1;
	miUsuario.click( function(e) { dj++; if(dj%2==0){ misDatosUsuario.stop().show('explode','slow'); }else{ misDatosUsuario.stop().hide('explode','slow'); } } );
	
	var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75);
	var cy = $('#header table').height() -8;

	misDatosUsuario.css('right',cx).css('top',cy);
});

</script>
<script>
$(document).ready(function(e) { $('#miMenu').hide(); $('#verMenu').click(function(e) { verMenu(); }); });
function verMenu(){ $(document).ready(function(e) { $('#miMenu').show('fold','slow'); $('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">PRÓXIMAS CITAS</span>'); }); }
function ocultarMenu(){ $(document).ready(function(e) { $('#miMenu').hide('fold','slow'); $('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">PRÓXIMAS CITAS</span>'); }); }
</script>

<script type="text/javascript">
//función para la info de detalle de cada registro
function fnFormatDetails ( oTable, nTr, x) { var aData = oTable.fnGetData( nTr ); var sOut = x; return sOut; }

//para filtros con cuadro de textos individuales
var asInitVals = new Array();

$(document).ready(function() {
	/* * Insert a 'details' column to the table */
    var nCloneTh = document.createElement( 'th' );
    var nCloneTd = document.createElement( 'td' );
    nCloneTd.innerHTML = '<img src="../../imagenes/generales/details_open.png">';
    nCloneTd.className = "center";
     
    $('#dataTable thead tr').each( function () { this.insertBefore( nCloneTh, this.childNodes[0] ); });
     
    $('#dataTable tbody tr').each( function () { this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] ); });
	
	var tam = $('#referencia').height() - 190;
	var wT = $('#referencia').width()*0.9;
	
	var oTable = $('#dataTable').dataTable({
		//funciones para calcular los totales en los campos del pie de página
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$( '#rangosFechas' ).buttonset();
			
			$("#miFiltroDeptos").selectmenu({
				change:function(event,ui){$('#clickme').click();}
			}).selectmenu("menuWidget").addClass("overflow");
			
			$('.opcTable').css('float','left');
			$('span.DataTables_sort_icon').remove();
			$("#saldos").button();
			
            /* Calculate the market share for browsers on this page */
            var iTotal = 0, iDescuento=0, iIngreso = 0, iAbonado = 0, iSaldo = 0;
            for ( var i=iStart ; i<iEnd ; i++ )
            {
				iDescuento += aaData[ aiDisplay[i] ][7]*1;
                iTotal     += aaData[ aiDisplay[i] ][8]*1;
				iAbonado   += aaData[ aiDisplay[i] ][9]*1;
				iSaldo     += aaData[ aiDisplay[i] ][10]*1;
            }
             
            /* Modify the footer row to match what we want */
            var nCells = nRow.getElementsByTagName('th');
			nCells[6].innerHTML  = '$'+redondear(parseFloat(iDescuento * 100)/100,2);
            nCells[7].innerHTML  = '$'+redondear(parseFloat(iTotal * 100)/100,2);
			nCells[8].innerHTML  = '$'+redondear(parseFloat(iAbonado * 100)/100,2);
			nCells[9].innerHTML  = '$'+redondear(parseFloat(iSaldo * 100)/100,2);
			
			window.setTimeout(function(){$('.erase1').each(function(index, element) { $(this).parent().parent().remove(); });},200);
        },
		//fin de funciones para calcular los totales en los campos del pie de página
		"bJQueryUI": false, "sScrollY": tam, "bAutoWidth": false, "bPaginate": true,
		"sPaginationType": "two_button",  "bStateSave": false, "bInfo": true, "bFilter": true, ordering: false,
		"aoColumnDefs": [ 
			{ "bSortable": false, "aTargets": [ 0,1,2,3,4,5,6,7,8,9,10 ] }, { "bSortable": true, "aTargets": [ 12 ] },
			{ "bVisible": false, "aTargets": [ 3 ] } 
		],
		"aaSorting": [[12, "desc"]],
		"iDisplayLength": 500000000000000, "bLengthChange": false, "bProcessing": false,
		"bServerSide": true,
		"sDom": '<"opcTable"T><"filtro1"><"regis"l>r<"data_t"t><"info"i><"paginacion">',
		"oTableTools": {
			"sSwfPath": "../../TableTools-2.1.5/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [ 
						{
							"sExtends": "pdf",
							"sButtonText": "PDF",
							"sPdfOrientation": "landscape",
							"sPdfSize": "letter",
							"sPdfMessage": "Reporte de Ingresos."
						},
						{
							"sExtends": "xls",
							"sButtonText": "EXCEL"
						},
						{
							"sExtends": "copy",
							"sButtonText": "COPIAR"
						},
						{
							"sExtends": "print",
							"sButtonText": "IMPRIMIR",
							"sInfo": "</br>VISTA DE IMPRESIÓN </br></br></br> Presione SCAPE al terminar."
						}
						]
		},
		"sAjaxSource": "datatable-serverside/reportes.php",
 		"fnServerParams": function (aoData, fnCallback) {
			   var de = document.getElementById('fechaDe').value+' 00:00:00';
			   var a = $('#fechaA').val()+' 23:59:59';
			   var saldos = $('#saldos').val();
			   var filtroDepto = $('#miFiltroDeptos').val();

               aoData.push(  {"name": "min", "value": de /*'2013-02-01 00:00:00'*/ } );
               aoData.push(  {"name": "max", "value": a /*'2013-02-15 23:59:59'*/ } );
			   aoData.push(  {"name": "saldos", "value": saldos /*'2013-02-15 23:59:59'*/ } );
			   aoData.push(  {"name": "depto", "value": filtroDepto /*'2013-02-15 23:59:59'*/ } );
        },
		"aLengthMenu": [[7, 15, 30, 100, -1], [7, 15, 30, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "_MENU_ REGISTROS",
			"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
			"sInfo": "MOSTRADOS: _END_",
			"sInfoEmpty": "MOSTRADOS: 0",
			"sInfoFiltered": " REGISTROS: _MAX_",
			"sSearch": "BUSCAR"
		}
		
	}); $('#clickme').click(function(e) { oTable.fnDraw(); });
	
	$('.regis').append('<div id="filtroDepto" style="border:1px none red;width:50%; padding-right:;float:right;" align="right"><select style=" width:300px;" name="miFiltroDeptos" id="miFiltroDeptos"><option value="x">-DEPARTAMENTOS-</option><?php do { ?> <option value="<?php echo $row_departamentosOV['id_d']?>"><?php echo $row_departamentosOV['nombre_d']?></option><?php } while ($row_departamentosOV = mysql_fetch_assoc($departamentosOV)); $rows = mysql_num_rows($departamentosOV); if($rows > 0) { mysql_data_seek($departamentosOV, 0); $row_departamentosOV = mysql_fetch_assoc($departamentosOV); }?></select></div>');
	
	$('#radio1').click(function(e) { 
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); 
	});
	$('#radio2').click(function(e) { 
		$('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); 
	});
	$( "#fechaDe" ).datepicker({ 
		defaultDate: "-1", //maxDate: +0, 
		onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); }, 
		"onSelect": function(date) { min = date+' 00:00:00'; oTable.fnDraw(); }, minDate: 0
	}).css('max-width','100px');
	$( "#fechaA" ).datepicker({ 
		defaultDate: "+0", //maxDate: +0, 
		onClose: function( selectedDate ) { 
			$( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); 
		}, 
		"onSelect": function(date) { max = date+' 23:59:59'; oTable.fnDraw(); } 
	}).css('max-width','100px');
	
	$('#saldos').click(function(e) {
        if($(this).prop('checked')==true){ $(this).val('SI'); }else{$(this).val('NO');}
		oTable.fnDraw();
    });
	$('#miFiltroDeptos').change(function(e) { oTable.fnDraw(); });
	
	/* Add event listener for opening and closing details
     * Note that the indicator for showing which row is open is not controlled by DataTables,
     * rather it is done here
     */
    $(document).delegate('#dataTable tbody td img','click', function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTable.fnIsOpen(nTr) )
        { /* This row is already open - close it */
            this.src = "../../imagenes/generales/details_open.png";
            oTable.fnClose( nTr );
        }
        else
        { /* Open this row */
			var aData = oTable.fnGetData( nTr );
			this.src = "../../imagenes/generales/details_close.png";
			var so = aData[5], so1=aData[8],ref=aData[1], depto = aData[6], area = aData[7], total = aData[9];
			var datoxOV ={ //so:so,so1:so1,ref:ref,depto:depto,area:area,total:total
				ref:ref
			}
			$.post('datatable-serverside/datosAdicionales.php',datoxOV,processDataOV).error('ouch');//salva la OV
			function processDataOV(dataOV) {
		  		console.log(dataOV);
				var text = dataOV.split('/');
	            oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr, dataOV/*text[0], text[1], text[2]*/), 'details' );
       		} // end processDataOV
        }
    } );
	// fin  Add event listener for opening and closing details
	
//para filtros con cuadro de textos individuales
	$("tfoot input").keyup( function () { /* Filter on the column (the index) of this element */
        oTable.fnFilter( this.value, $("tfoot input").index(this) );
    } );
	 /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; });
     
    $("tfoot input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
     
    $("tfoot input").blur( function (i) {
        if ( this.value == "" )
        {
            this.className = "search_init";
            this.value = asInitVals[$("tfoot input").index(this)];
        }
    } );
	
	var busqueda = $('.filtro1');
	var data_t = $('#dataTable tbody');
	var info_t = $('.info *');
	var resete = $('#resete');
	var noRegistros = $('.regis *');
	
	noRegistros.css('float','right');
	$('.info').css('border','1px none red').css('float','right').css('color','black').css('font-size','12px');
});
		
// EndOAWidget_Instance_2586523
  </script>

<script>
$(document).ready(function(e) {
	var dataT = $('.dataT');
	dataT.css('font-size','0.8em');  
	pie=$('#dataTable .mimimi');
	pie.css('background-color','black');  
});
</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; border: 1px solid red; z-index:1000000000000000000000;"></div>
<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">

<div id="header" class="header" style="display:;">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" class="iconito"><img src="../../imagenes/iconitos/_agenda.png" height="45"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">PRÓXIMAS CITAS</span></td>
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
        <tr> <td style="font-weight:bold;" align="center"><?php echo $row_nombreSucursalUsuario['nombre_su']; ?></td> </tr>
        <tr> <td style="font-size:0.8em;" align="center"><?php echo $row_nombreDepartamentoUsuario['nombre_d']; ?></td> </tr>
        <tr> <td style="font-size:0.8em;" align="center"><span style="text-decoration:underline; cursor:pointer;"><a href="<?php echo $logoutAction ?>">CERRAR SESIÓN</a></span></td> </tr>
    </table>
    </div>
        </td>
      </tr>
    </table>
</div>

<div id="fondo" class="fondo">

<div id="miMenu" class="miMenu">
<table width="98%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
  <tr valign="middle" class="fondoMenu">
  	<td class="eii"><img title="MENÚ ANTERIOR" src="../../imagenes/submenu/_recepcion.png" width="100" onClick="window.location='../../menu_recepcion.php'"></td>
	<td class="eid"><img title="INICIO" src="../../imagenes/submenu/_inicio.png" width="100" onClick="window.location='../../menu.php'"></td>
  </tr>
</table>
</div>
  
  <div class="contenido" id="contenido" align="center">
   
<input name="usuario" id="usuario" type="hidden" value="<?php echo $row_usuario['usuario_u']; ?>">
  <table cellspacing="1" cellpadding="4" id="dataTable" class="tablilla" width="100%" height="100%">
    <thead id="">
      <tr style="font-size:1em;" bgcolor="#FF6633">
        <th style="color:white;" width="30px" id="clickme">REF</th>
        <th style="color:white;">PACIENTE</th>
        <th style="color:white;" nowrap width="10">FECHA</th>
        <th style="color:white;" width="100">SUCURSAL</th>
        <th style="color:white;" width="10">USUARIO</th>
        <th style="color:white;" width="50">SUBT</th>
        <th style="color:white;" width="50">DESCTO</th>
        <th style="color:white;" width="50">TOTAL</th>
        <th style="color:white;" width="50">ABONADO</th>
        <th style="color:white;" width="50">SALDO</th>
        <th style="color:white;" width="50">PAGO</th>
        <th style="color:white;" width="40">ESTATUS</th>
        <th style="color:white;" width="40">HORA</th>
      </tr>
    </thead>
    <tbody style=" font-size:0.8em;">
		<tr>
			<td class="dataTables_empty">Cargando datos del servidor</td>
		</tr>
	</tbody>
    <tfoot>
		<tr bgcolor="#FF6633" style="color:white;">
			<th><input name="sX" type="hidden" value=""></th>
			<th><input name="sRef" id="sRef" type="text" value="-Referencia-" class="search_init" style="width:100px;" /></th>
			<th><input name="sPaciente" id="sPaciente" type="text" value="-Paciente-" class="search_init" width="98%" /></th>
            <th><input name="sX1" type="hidden" value=""></th>
			<th>
            <input name="sX2" type="hidden" value="">
            <input name="sSucursal" id="sSucursal" type="text" value="-Sucursal-" class="search_init" style="width:100px;" />
            </th>
			<th><input name="sUser" id="sUser" type="text" value="-Usuario-" class="search_init" style="width:100px;" /></th>
            <th><input name="sTotal" id="sTotal" type="hidden" class="search_init sCalculo" readonly /></th>
			<th><input name="sComision" id="sComision" type="hidden" class="search_init sCalculo" readonly /></th>
			<th><input name="sIngreso" id="sIngreso" type="hidden" class="search_init sCalculo" readonly /></th>
            <th><input name="sAbonado" id="sAbonado" type="hidden" class="search_init sCalculo" readonly /></th>
            <th><input name="sSaldo" id="sSaldo" type="hidden" class="search_init" readonly /></th>
            <th>
            	<input name="sX3" type="hidden" value=""><input name="sX4" type="hidden" value="">
                <input name="sX5" type="hidden" value=""><input name="sX6" type="hidden" value="">
                <input name="sX7" type="hidden" value="">
            </th>
            <th><input name="sEstatus" id="sEstatus" type="text" value="-Estatus-" class="search_init"/ style="width:70px"></th>
            <th></th>
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
    <td align="right"><input type="checkbox" id="saldos" value="" /><label for="saldos">Saldos</label></td>
  </tr>
</table>
</div>

</div>

</div>

<div class="footer" id="footer" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle">
    	&copy; GLOSS <?php echo date('Y'); ?>. Todos los derechos reservados.
    </td>
  </tr>
</table>
</div>

<div id="dialog-pagos1" style="display:none;"> Guardando Datos... </div>

<div id="dialog-pagos" style="display:none;"> </div>

</body>
</html>
<?php
mysql_free_result($usuario);
mysql_free_result($nombreSucursalUsuario);
mysql_free_result($nombreDepartamentoUsuario);
mysql_free_result($areas_estudiosL);
mysql_free_result($fechaRangoInicial);
mysql_free_result($fechaRangoFinal);
mysql_free_result($departamentosOV);
?>

<script>
jQuery(function($){
    $.datepicker.regional['es'] = {//dateFormat: 'mm/dd/yy',
        closeText: 'Cerrar', changeMonth: true, changeYear: true, numberOfMonths: 3, dateFormat: "yy-mm-dd", prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;', currentText: 'Hoy',
        monthNames:[
			'Enero','Febrero','Marzo','Abril','Mayo','Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
		], 
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun', 'Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'], 
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],  weekHeader: 'Sm', firstDay: 1, isRTL: false, 
		showMonthAfterYear: false, yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['es']);
});

$(document).ready(function(e) {
var divRangoFechas = $('#divRangoFechas');
	divRangoFechas.css('width','80%').css('float','left').css('border-width','1px').css('border-style','none'); 
	
	$( '#rangosFechas' ).buttonset().css('font-size','0.9em');
	$('.rad').css('font-size','0.8em');
});
 </script>
 
<script>
function foco(a,b){
$(document).ready(function(e) {
		if (b>=0 && b<=100000){ document.getElementById('precioTemp').value=b; }
		document.getElementById(a).value="";
});
}//fin de foco()
function blure(a,b){
	$(document).ready(function(e) {	
		if ( b==""){ document.getElementById(a).value=document.getElementById('precioTemp').value; }
});
};//fin de blure()
function miPago(a,b){
	$(document).ready(function(e) {
        var saldo = $('#saldoMiOV').val();
		//alert(b);alert(saldo);alert(document.getElementById(a).value);
		if (parseFloat(b)>0 & b<=100000){//alert("entra");
			if (parseFloat(b)>parseFloat(saldo)){ //alert("mas");
				$('#pagos-pagar').val(parseFloat(saldo));
			}else{}//alert("menos");}
		}else{}//alert("no entra");}
    });
};//fin miPago()
$(document).ready(function(e) {
	var miPago = $('#pagos-pagar'), miSaldo = $('#saldoMiOV');
    $('#pagos-liquidar').button();
		$('#pagos-liquidar').click(function(e) {
            if($(this).attr('checked') == 'checked'){
				miPago.attr('readOnly',true); 
				miPago.val(miSaldo.val());
			}
			else{
				miPago.attr('readOnly',false);
				miPago.focus(); miPago.val('');
			}
        });
});
</script>

<script>
function pagar(ref, tot, sal, abo, pac, noTemp){ $(document).ready(function(e) { //alert(noTemp);
	$("#dialog-pagos").load("htmls/dialogPagarOV.php #pagarOV", function( response, status, xhr ) {if ( status == "success" ) {
		$('#totalOVP').val(tot); $('#abonadoOVP').val(abo); $('#saldoP').val(sal);
		$('#pagarOV input').addClass('campoITtab');
		$('#pagarOV select').addClass('campoITtab');
		
		$('#montoPagarP').keyup(function(e) {
			if( parseFloat($('#montoPagarP').val()) > parseFloat($('#saldoP').val()) ){
				$('#montoPagarP').val($('#saldoP').val());
			}
		});

		$('#montoPagarP').keyup(function(e) {
			$('#pagaConP, #cambioP').val('');
		});
		
		$('#pagaConP').keyup(function(e) {
		 if( $(this).val() > parseFloat($('#montoPagarP').val()) ){
		  $('#cambioP').val(redondear(parseFloat($('#pagaConP').val())-parseFloat($('#montoPagarP').val()),2) );
		 }else{$('#cambioP').val('')}
		});
		
		$('#formaPagoP').load("genera/formas_pago.php",function(response,status,xhr){
			$('#formaPagoP').change(function(e) { 
				$('#montoPagarP, #pagaConP, #cambioP').val('');
				if($(this).val()!=''){ 
					$('#montoPagarP').prop('readonly',false);
					$('#montoPagarP').focus();
				}else{ 
					$('#montoPagarP').prop('readonly',true);
					$('#ivaP').val(0);
				}
				
				if($(this).val()==4){$('#numeroCheque').show();$('#noChequeP').focus();}
				else{$('#numeroCheque').hide();}
				
				if($(this).val()==1){
					$('#pagaConP').prop('readonly',false); 
				}else{$('#pagaConP').prop('readonly',true);}
			});
		});
		
		var titleDP = 'PAGO. PACIENTE '+pac;
		$('#form-pagar').validate({ });
		var hx = $('#referencia').height() - $('.botones').height() - 20, wx = $('#referencia').width() * 0.96;
		$('#dialog-pagos').dialog({ 
			title: titleDP, modal: true, autoOpen:true,closeText: '',
			width: 550, height: 530, closeOnEscape: false, dialogClass: 'no-close',
			buttons: {
				"Pagar": function() { if( $('#form-pagar').valid() ){
					var datosP ={ref:ref, user:$('#idUser').val(), pago:$('#montoPagarP').val(), noTemp:noTemp}
					$.post('files-serverside/savePago.php',datosP).done(function(data){
						if(data==1){
							$('#clickme').click();
							$('#dialog-pagos').dialog({buttons:{}, height:150, title: 'PAGO REALIZADO'});
							$('#dialog-pagos').html('<div align="center" style=" height:100%;"><br>EL PAGO SE HA REGISTRADO SATISFACTORIAMENTE</div>');
							window.setTimeout(function(){$('#dialog-pagos').dialog('close');},2000);
						}else{alert(data);}
					});		
					
				} },
			"Cancelar": function() { $('#dialog-pagos').dialog('close'); }
		  }, create: function( event, ui ) {}, 
		  close:function( event, ui ){ $('#dialog-pagos').empty(); },
		  open: function(event, ui){}
		});//fin dialog pagar OV
	} }); //fin de load
}); }
</script>  