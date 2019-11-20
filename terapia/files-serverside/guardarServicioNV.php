<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $idMedico = sqlValue($_POST["idMedico"], "int");
 $claveE = sqlValue($_POST["claveE"], "text");
	 mysql_select_db($database_horizonte, $horizonte); 
	 $resultC = mysql_query("SELECT id_serv, id_departamento_serv, id_area_serv, costo_serv from servicios where clave_serv = $claveE ", $horizonte) or die (mysql_error());
	 $rowC = mysql_fetch_row($resultC);
 $idE = sqlValue($rowC[0], "int");
 $idConvenio = sqlValue($_POST["idConvenio"], "int");
 if($_POST["idConvenio"]==''){$idConvenio=0;}
 $idDepartamento = sqlValue($rowC[1], "int");
 $idArea = sqlValue($rowC[2], "int");
 $idSucursal = sqlValue($_POST["idSucursal"], "int");
 $observaciones = sqlValue($_POST["observaciones"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $precio = sqlValue($rowC[3], "double");
 $fechaEntrega = sqlValue($_POST["fechaEntrega"], "date");
	
 mysql_select_db($database_horizonte, $horizonte); 
$sql="INSERT INTO venta_conceptos(no_temp_vc,id_paciente_vc,id_usuario_vc,id_personal_medico_vc,id_concepto_es,id_convenio_vc,departamento_vc,area_vc,id_sucursal_vc,observaciones_vc,fecha_venta_vc,tipo_concepto_vc,precio_normal_vc,fecha_entrega_vc,usuarioEdo1_e,fechaEdo1_e)";
$sql.= "VALUES ($noTemp, $idP, $idU, $idMedico, $idE, $idConvenio, $idDepartamento, $idArea, $idSucursal, $observaciones, $now, 2, $precio, $fechaEntrega, $idU, $now)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>