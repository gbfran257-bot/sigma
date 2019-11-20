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
<title>CORTE DE CAJA</title>

<link href="../../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link href="../../DataTables-1.10.5/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../../TableTools-2.1.5/media/css/TableTools.css" rel="stylesheet">

<script src="../../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
<script src="../../TableTools-2.1.5/media/js/TableTools.js"></script>
<script src="../../TableTools-2.1.5/media/js/ZeroClipboard.js"></script>
<script src="../../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../../funciones/js/caracteres.js"></script>
<script src="../../funciones/js/redondea.js"></script>

<script language="javascript"> //para las tooltips
$( document ).tooltip({ position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ) { $( this ).css( position ); $( "<div>" ).addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this ); } } });

setInterval(function(){$.post('../../remote_files/refresh_session.php'); },500000);

//función para la info de detalle de cada registro
function fnFormatDetails ( oTable, nTr, x) { var aData = oTable.fnGetData( nTr ); var sOut = x; return sOut; }
//función para la info de detalle de cada registro

//para filtros con cuadro de textos individuales
var asInitVals = new Array();
//fin fintros con cuadro de texto indivicuales

$(document).ready(function() {
	$('#miMenu').hide(); $('#verMenu').click(function(e){window.location='../../menu.php?menu=mr';}); 
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
	
	/* * Insert a 'details' column to the table */
    var nCloneTh = document.createElement( 'th' );
    var nCloneTd = document.createElement( 'td' );
    nCloneTd.innerHTML = '<img src="../../imagenes/generales/details_open.png">';
    nCloneTd.className = "center";
     
    $('#dataTable thead tr').each( function () { this.insertBefore( nCloneTh, this.childNodes[0] ); });
     
    $('#dataTable tbody tr').each( function () { this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] ); });
	
	var tam = $('#referencia').height() - 190;
	var wT = $('#referencia').width()*0.9;
	//$('#dataTable').css('width',100);
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
                iTotal += aaData[ aiDisplay[i] ][8]*1;
				iAbonado += aaData[ aiDisplay[i] ][11]*1;
				iSaldo += aaData[ aiDisplay[i] ][12]*1;
            }
             
            /* Modify the footer row to match what we want */
            var nCells = nRow.getElementsByTagName('th');
			nCells[5].innerHTML = '$'+redondear(parseFloat(iDescuento * 100)/100,2);
            nCells[6].innerHTML = '$'+redondear(parseFloat(iTotal * 100)/100,2);
			nCells[7].innerHTML = '$'+redondear(parseFloat(iAbonado * 100)/100,2);
			nCells[8].innerHTML = '$'+redondear(parseFloat(iSaldo * 100)/100,2);
			
			window.setTimeout(function(){$('.erase1').each(function(index, element){ $(this).parent().parent().remove(); });},200);
        },
		//fin de funciones para calcular los totales en los campos del pie de página
		"bJQueryUI": true, "sScrollY": tam-10, "bAutoWidth": true, "bPaginate": true, "sPaginationType": "two_button", 
		"bStateSave": false, "bInfo": false, "bFilter": true, ordering: false,
		"aoColumnDefs": [ 
			{"bSortable":false, "aTargets":[0]}, {"bSortable":false, "aTargets":[11] }, { "bVisible": false, "aTargets": [ 9 ] },
			{"bVisible": true, "aTargets": [ 7 ]},{ "bVisible": true, "aTargets": [ 8 ]},{"bVisible": false,"aTargets": [ 3 ] },
			{"sClass":"right1","aTargets":[ 6 ] },{"sClass":"right1", "aTargets":[ 9 ] },{ "bVisible": false, "aTargets":[ 10 ] },
			{"sClass":"right1","aTargets":[ 12 ] }, {"bVisible":false, "aTargets":[5]},{"sClass":"right1", "aTargets":[ 7 ] },
			{"sClass":"right1", "aTargets":[ 11 ] }
		],
		"aaSorting": [[3, "desc"]], "iDisplayLength": 500000000000000, "bLengthChange": false,
		"bProcessing": false, "bServerSide": true,
		"sDom": '<"opcTable"T><"filtro1"><"regis"l>r<"data_t"t><"info"i>',
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
			   var usuario = $('#idUser').val();

               aoData.push(  {"name": "min", "value": de /*'2013-02-01 00:00:00'*/ } );
               aoData.push(  {"name": "max", "value": a /*'2013-02-15 23:59:59'*/ } );
			   aoData.push(  {"name": "saldos", "value": saldos /*'2013-02-15 23:59:59'*/ } );
			   aoData.push(  {"name": "depto", "value": filtroDepto /*'2013-02-15 23:59:59'*/ } );
			   aoData.push(  {"name": "usuario", "value": usuario } );
        },
		"aLengthMenu": [[7, 15, 30, 100, -1], [7, 15, 30, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "_MENU_ REGISTROS",
			"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
			"sInfo": "MOSTRADOS: _END_",
			"sInfoEmpty": "MOSTRADOS: 0",
			"sInfoFiltered": "&nbsp;REGISTROS: _MAX_",
			"sSearch": "BUSCAR"
		}
	}); $('#clickme').click(function(e) { oTable.fnDraw(); });
	
	$('.regis').append('<div id="filtroDepto" style="border:1px none red; white-space:nowrap; width:60%; float:right;" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="2"><tr style="display:;"><td align="right"><select style="width:300px;" name="miFiltroDeptos" id="miFiltroDeptos"><option value="x">-DEPARTAMENTOS-</option><?php do { ?> <option value="<?php echo $row_departamentosOV['id_d']?>"><?php echo $row_departamentosOV['nombre_d']?></option><?php } while ($row_departamentosOV = mysql_fetch_assoc($departamentosOV)); $rows = mysql_num_rows($departamentosOV); if($rows > 0) { mysql_data_seek($departamentosOV, 0); $row_departamentosOV = mysql_fetch_assoc($departamentosOV); }?></select></td></tr></table></div>');
	
	$('#nuevoVale').button({ icons: { primary: "ui-icon-plusthick" }, text: true });
	$('#nuevoVale').click(function(event) { event.preventDefault(); });
	
	$('#radio1').click(function(e) { 
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); 
	});
	$('#radio2').click(function(e) { 
		$('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); 
	});
	$( "#fechaDe" ).datepicker({ 
		defaultDate: "-1", maxDate: +0, 
		onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); }, 
		"onSelect": function(date) { min = date+' 00:00:00'; oTable.fnDraw(); } 
	}).css('max-width','100px');
	
	$( "#fechaA" ).datepicker({ 
		defaultDate: "+0", maxDate: +0, 
		onClose: function( selectedDate ) { 
			$( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); 
		}, 
		"onSelect": function(date) { max = date+' 23:59:59'; oTable.fnDraw(); } 
	}).css('max-width','100px');
	
	$('#saldos').click(function(e) {
        if($(this).prop('checked')==true){ $(this).val('SI'); }else{$(this).val('NO');}
		oTable.fnDraw();
    });
	//window.setTimeout(function(){$('#miFiltroDeptos').change(function(e) { alert(a);$('#clickme').click(); }).css('margin-left','3px').hide();},200);
	
	$('#dialog-pagos1').dialog({
		dialogClass: 'no-close', autoOpen: false, closeOnEscape: false, width: 500, closeText: '', modal: true,
		title: 'CARGANDO DATOS',
		close: function( event, ui ) {
			var ref1x = $('#pagos-ref').text();
			var datosUovx ={ref:ref1x}
			$.post('files-serverside/updateOV.php',datosUovx,processDataUovx);//salva un registro de pago para la Consulta
			function processDataUovx(dataSx) {
		  		console.log(dataSx);
				if (dataSx == "ok"){ oTable.fnDraw(); }else{alert(dataSx);}
       		} // end processDataUov
			oTable.fnDraw();
			document.getElementById('formW').reset();
		}
	});
	$('#dialog-pagos').dialog({
		autoOpen: false, closeText: '', width: 500, modal: true, title: 'REALIZAR PAGO',
		close: function( event, ui ) {
			var ref1 = $('#pagos-ref').text();
			var datosUov ={ref:ref1}
			$.post('files-serverside/updateOV.php',datosUov,processDataUov);//salva un registro de pago para la Consulta
			function processDataUov(dataS) { console.log(dataS); if (dataS == "ok"){ oTable.fnDraw(); }else{alert(dataS);}
       		} // end processDataUov
			oTable.fnDraw();
			document.getElementById('formW').reset();
		},
		buttons: {//aqui
                "Aceptar": function() {
					var ref = $('#pagos-ref').text(), pago = $('#pagos-pagar').val(), user = $('#idUser').val();
					var datosP ={ref:ref, user:user, pago:pago}
					$.post('files-serverside/savePago.php',datosP).done(function(data){
						if(data==1){
							oTable.fnDraw();
							$('#dialog-pagos').dialog('close');
						}else{alert(data);}
					});			
				},
				"Cancelar": function() {
					$('#pagos-pagar').val(0);
                    $( this ).dialog( "close" );
                }
            }
	});
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
			var datoxOV ={ ref:ref }
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
	$("tfoot input").keyup( function () { oTable.fnFilter( this.value, $("tfoot input").index(this) ); });
	 /*
     * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
     * the footer
     */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; });
     
    $("tfoot input").focus( function () {
        if ( this.className == "search_init" ) { this.className = ""; this.value = ""; }
    } );
     
    $("tfoot input").blur( function (i) {
        if ( this.value == "" ) { this.className = "search_init"; this.value = asInitVals[$("tfoot input").index(this)]; }
    } );
	
});
  </script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">

<div id="header" class="header">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../../imagenes/iconitos/_iconoCaja.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">CORTE CAJA</span></td>
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

<div class="contenido" id="contenido" align="center" style="padding-top:10px;"> 

<input name="usuario" id="usuario" type="hidden" value="<?php echo $row_usuario['usuario_u']; ?>">
  <table border="0" cellspacing="0" cellpadding="4" id="dataTable" width="90%" height="100%" class="tablilla">
    <thead>
      <tr style="font-size:1.1em;" bgcolor="#FF6633">
        <th style="color:white;" width="10px" id="clickme">REFERENCIA</th>
        <th style="color:white;">PACIENTE</th>
        <th style="color:white;" width="80px">FECHA</th>
        <th style="color:white;">SUCURSAL</th>
        <th style="color:white;">USUARIO</th>
        <th style="color:white; text-align:center;" width="10px">SUBTOTAL</th>
        <th style="color:white; text-align:center;" width="10px">DESCUENTO</th>
        <th style="color:white; text-align:center;" width="10px">TOTAL</th>
        <th style="color:white;">COMISION</th>
        <th style="color:white;">INGRESO</th>
        <th style="color:white; text-align:center;" width="10px">ABONADO</th>
        <th style="color:white; text-align:center;" width="10px">SALDO</th>
        <th style="color:white; text-align:center;" width="10px">PAGADO</th>
      </tr>
    </thead>
    <tbody style=" font-size:0.8em; background-color:white;">
		<tr>
			<td class="dataTables_empty">Cargando datos del servidor</td>
		</tr>
	</tbody>
    <tfoot>
		<tr bgcolor="#FF6633" style="color:white;">
			<th><input name="sX" type="hidden" value=""></th>
			<th><input name="sRef" id="sRef" type="text" value="-Referencia-" class="search_init" maxlength="13" / style="width:95%"></th>
			<th><input name="sPaciente" id="sPaciente" type="text" value="-Paciente-" class="search_init" / style="width:95%"></th>
            <th><input name="sX1" type="hidden" value=""></th>
			<th><input name="sSucursal"id="sSucursal"type="text"value="-Sucursal-"class="search_init" maxlength="10"/ style="width:95%"></th>
			<th><input name="sUser" id="sUser" type="text" value="¿?" maxlength="8" class="search_init" /></th>
            <th><input name="sSubTotal" id="sSubTotal" type="hidden" class="search_init sCalculo" readonly /></th>
            <th><input name="sDescuento" id="sDescuento" type="hidden" class="search_init sCalculo" readonly /></th>
            <th><input name="sTotal" id="sTotal" type="hidden" class="search_init sCalculo" readonly /></th>
			<th><input name="sComision" id="sComision" type="hidden" class="search_init sCalculo" readonly /></th>
			<th><input name="sIngreso" id="sIngreso" type="hidden" class="search_init sCalculo" readonly /></th>
            <th><input name="sAbonado" id="sAbonado" type="hidden" class="search_init sCalculo" readonly /></th>
            <th><input name="sSaldo" id="sSaldo" type="hidden" class="search_init" readonly /></th>
            <th></th>
		</tr>
	</tfoot>
  </table>
 
  <div id="divRangoFechas" style="border:2px none red; display:block; width:100%; float:left;">
  <table width="100%" border="0" cellpadding="4" cellspacing="0" style="color:black;">
  <tr>
    <td width="10px">De </td>
    <td width="1%">
    	<input style="height:80%; font-size:1.1em; border-radius:4px;" name="fechaDe" class="fechas" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly>
    </td>
    <td width="10px">A </td>
    <td width="1%">
    	<input style="height:80%; font-size:1.1em; border-radius:4px;" name="fechaA" type="text" class="fechas" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly>
    </td>
    <td id="rangosFechas">
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label>
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
    <td align="right" nowrap> <input type="checkbox" id="saldos" value="" /><label for="saldos">Saldos</label> </td>
  </tr>
</table>
</div>
    
</div>

<div id="dialog-pagos1"> Guardando Datos... </div>

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
        monthNames: [
			'Enero','Febrero','Marzo','Abril','Mayo','Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
		], 
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun', 'Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        dayNamesShort: [
			'Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'], dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'
		], 
		weekHeader:'Sm', firstDay:1, isRTL:false, showMonthAfterYear:false, yearSuffix:'', nextText: 'Sig&#x3e;', currentText: 'Hoy',
	};
    $.datepicker.setDefaults($.datepicker.regional['es']);
});

</script>
 
<script>
function pagar1(ref, tot, sal, abo, pac){
	$('#pagos-ref').text(ref);
	$('#pagos-total').text('$'+tot);
	$('#totalMiOV').val(tot);
	$('#pagos-saldo').text('$'+sal);
	$('#saldoMiOV').val(sal);
	$('#pagos-abonado').text('$'+abo);
	$('#abonadoMiOV').val(abo);
	$('#pagos-paciente').text(pac);
	$('#dialog-pagos').dialog('open');
}
function pagar(ref, tot, sal, abo, pac, noTemp){
	$("#dialog-pagos").load("htmls/dialogPagarOV.php #pagarOV", function( response, status, xhr ) {if ( status == "success" ) {
		$('#totalOVP').val(tot); $('#abonadoOVP').val(abo); $('#saldoP').val(sal);
		$('#pagarOV input').addClass('campoITtab1');
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
		var hx = $('#referencia').height() - 100, wx = $('#referencia').width() * 0.96;
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
}
</script>