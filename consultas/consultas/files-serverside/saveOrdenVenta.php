<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
if (isset($_POST["descuentoGral"])){$_POST["descuentoGral"]=0;}
if (isset($_POST["claveMedicoCx"])){$_POST["claveMedicoCx"]="";}
if (isset($_POST["clavePersonalS"])){$_POST["clavePersonalS"]="";}
//Generales
 //$numAleatorio = sqlValue($_POST["numAleatorio"], "int");
 $idPaciente = sqlValue($_POST["idPaciente"], "int");
 $idUsuario = sqlValue($_POST["idUsuario"], "text");
 $totalTotal = sqlValue($_POST["totalTotal"], "double");
 $ahorroTotal = sqlValue($_POST["ahorroTotal"], "double");
 $notaDescuentoGeneral = sqlValue($_POST["notaDescuentoGeneral"], "text");
 $estadoPago = sqlValue($_POST["estadoPago"], "text");
 $totalServicios = sqlValue($_POST["totalServicios"], "double");
 $costoReal = sqlValue($_POST["costoReal"], "double");
 $descuentoGral = sqlValue($_POST["descuentoGralOV"], "int");
 $totalConsulta = sqlValue($_POST["totalConsulta"], "double");
 $totalEstudios = sqlValue($_POST["totalEstudios"], "double");
 $cSucursal = sqlValue($_POST["cSucursal"], "text");
//Consulta
 $precio_c = sqlValue($_POST["precio_c"], "double");
 $descuentoConsulta = sqlValue($_POST["descuentoConsulta"], "int");
 $claveMedicoC = sqlValue($_POST["claveMedicoC"], "text");
 $observacionesC = sqlValue($_POST["observacionesC"], "text");
 $UrgenteC = sqlValue($_POST["UrgenteC"], "int");
 $notaDescuentoC = sqlValue($_POST["notaDescuentoC"], "text");
//Estudios
 $claveMedicoE = sqlValue($_POST["claveMedicoE"], "text");
 $observacionesEstudios = sqlValue($_POST["observacionesEstudios"], "text");
 $fechaEntrega = sqlValue($_POST["fechaEntrega"], "date");
 $tUrgenteE = sqlValue($_POST["tUrgenteE"], "double");
 $tTomaDomE = sqlValue($_POST["tTomaDomE"], "double");
 $tEntregaDomE = sqlValue($_POST["tEntregaDomE"], "double");
 $urgenciaE = sqlValue($_POST["urgenciaE"], "int");
 $descuentoEstudios = sqlValue($_POST["descuentoEstudios"], "int");
 $subtotalEstudios = sqlValue($_POST["subtotalEstudios"], "double");
 $notaDescuentoE = sqlValue($_POST["notaDescuentoE"], "text");
//Servicios
 $descuentoServicios = sqlValue($_POST["descuentoServicios"], "int");
 $clavePersonalS = sqlValue($_POST["clavePersonalS"], "text");
 $observacionesServicios = sqlValue($_POST["observacionesServicios"], "text");
 $tUrgenteS = sqlValue($_POST["tUrgenteS"], "double");
 $tAdomS = sqlValue($_POST["tAdomS"], "double");
 $urgenciaS = sqlValue($_POST["urgenciaS"], "int");
 $subtotalServicios = sqlValue($_POST["subtotalServicios"], "double");
 $notaDescuentoS = sqlValue($_POST["notaDescuentoS"], "text");
//Pago
 $saldo = sqlValue($_POST["saldo"], "double");
 $pago = sqlValue($_POST["pago"], "double");
 $comisionT = sqlValue($_POST["comisionT"], "double"); $comisionX=$_POST["comisionT"]; $totalX = $_POST["totalTotal"];
 $ingresoT=$totalX-$comisionX;
 
 //script para dar obtener el Número de Referencia
 $fecha1="'".date('Y-m-d')." 00:00:00"."'";
 $fecha2="'".date('Y-m-d')." 23:59:59"."'";
 mysql_select_db($database_horizonte, $horizonte);
 $resultR = mysql_query("SELECT count(id_ov) from orden_venta where fecha_venta_ov between ".$fecha1." and ".$fecha2." ", $horizonte) or die(mysql_error());
 $rowR = mysql_fetch_row($resultR);
 $noRef=0;
 $da=date('Ymd');
 if ($rowR[0]==0){
	 	$noRef=$da."-"."1";
		$noRef="'".$noRef."'";
	 }else{
	 	$daa=$rowR[0]+1;
	 	$noRef=$da."-".$daa;
		$noRef="'".$noRef."'";
	}
 //echo $noRef;
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO orden_venta (subtotal_estudios_ov, subtotal_consulta_ov, subtotal_servicios_ov, descuento_estudios_ov, descuento_consulta_ov, descuento_servicios_ov, total_e, total_c, total_s, gran_total_ov, usuario_ov, id_paciente_ov, fecha_venta_ov, descuento_general_ov, nota_descuento_ov, clave_medico_e_ov, fecha_entrega_e_ov, t_urgente_e_ov, t_entrega_domicilio_e_ov, t_toma_domicilio_e_ov, observaciones_e_ov, estado_pago_ov, total_real, ahorro, clave_medico_c_ov, clave_personal_s_ov, referencia_ov, clave_sucursal_ov, abonado_ov, saldo_ov, comision_personal_ov, ingreso_clinica_ov, t_urgente_s_ov, t_aDomicilio_s_ov) ";
$sql.= "VALUES (".$subtotalEstudios.", ".$precio_c.", ".$subtotalServicios.", ".$descuentoEstudios.", ".$descuentoConsulta.", ".$descuentoServicios.", ".$totalEstudios.", ".$totalConsulta.", ".$totalServicios.", ".$totalTotal.", ".$idUsuario.", ".$idPaciente.", now(), ".$descuentoGral.", ".$notaDescuentoGeneral.", ".$claveMedicoE.", ".$fechaEntrega.", ".$tUrgenteE.", ".$tEntregaDomE.", ".$tTomaDomE.", ".$observacionesEstudios.", ".$estadoPago.", ".$costoReal.", ".$ahorroTotal.", ".$claveMedicoC.", ".$clavePersonalS.", ".$noRef.", ".$cSucursal.", ".$pago.", ".$saldo.", ".$comisionT.", ".$ingresoT.", ".$tUrgenteS.", ".$tAdomS.")";

$insertar = mysql_query($sql, $horizonte) or die(mysql_error());

//al inicio, el saldo debe ser el total de la ov y el pago =0
$saldo=$totalTotal;
$pago=0;

$sql1 = "INSERT INTO pagos_ov (total_pag, saldo_pag, pago_pag, usuario_pag, fecha_pag, referencia_pag, clave_sucursal_pag) ";
$sql1.= "VALUES (".$totalTotal.", ".$saldo.", ".$pago.", ".$idUsuario.", now(), ".$noRef.", ".$cSucursal.")";

//$sql2 = "UPDATE pacientes SET visitas = visitas + 1 where id_p = ".$idPaciente.";";
	
if (!$insertar) {
	echo $sql;
}else {
	mysql_select_db($database_horizonte, $horizonte);
	$insertar1 = mysql_query($sql1, $horizonte) or die(mysql_error()); if (!$insertar1) {echo $sql1;}else{echo "ok";}
			//else{$insertar2 = mysql_query($sql2, $horizonte) or die(mysql_error());}
				//if (!$insertar2) {echo $sql2;}else{echo "ok";}
	}
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>