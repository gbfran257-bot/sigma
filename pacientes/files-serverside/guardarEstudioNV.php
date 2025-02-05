<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 if(isset($_POST["idMedico"])){$idMedico = sqlValue($_POST["idMedico"], "int");}else{$idMedico=0;}
 
 $idE = sqlValue($_POST["idE"], "int");
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT id_to, id_departamento_to, id_area_to, precio_to, id_tipo_concepto_to, aleatorio_c from conceptos where id_to = $idE ", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC); $tempiU = sqlValue($rowC[5], "text");

 if($rowC[4]==1){
	 mysql_select_db($database_horizonte, $horizonte); 
	 $resultMCt = mysql_query("SELECT id_u from usuarios where temporal_u = $tempiU ", $horizonte) or die (mysql_error());
	 $rowMCt = mysql_fetch_row($resultMCt);
	 
	 $idMedico = $rowMCt[0];
 }

 // Obtenemos la cantidad a agregar del producto
 $cantidad = intval(htmlentities($_POST["cantidad"], ENT_QUOTES, "utf'8"));
 //obtenemos el id de la tabla stock_has_bach del medicamento
 $id_shb = sqlValue($_POST["id_shb"], "int");

 $idConvenio = sqlValue($_POST["idConvenio"], "int");
 if($_POST["idConvenio"]==''){$idConvenio=0;}
 $idDepartamento = sqlValue($rowC[1], "int");
 $idArea = sqlValue($rowC[2], "int");
 $idSucursal = sqlValue($_POST["idSucursal"], "int");
 $observaciones = sqlValue($_POST["observaciones"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $precio = sqlValue($_POST["precioTo"], "double");
 if(empty($_POST["precio_original"]))
 	$precio_orig = $precio;
 else
 	$precio_orig = sqlValue($_POST["precio_original"], "double");
 $honor = sqlValue($_POST["honor"], "double");
 $tipoConcepto = sqlValue($_POST["tipoConcepto"], "int");
 $id_con_bene = sqlValue($_POST["id_con_bene"], "int");
 $ocupado = sqlValue($_POST["ocupado"], "int");
 
 if($_POST["agendar"]==1){ $fechaC = sqlValue($_POST["fechaC"], "text"); } else{ $fechaC = $now; }
 
 $banderaExistencias = false;
 $idExistencias = 0;
 $cantExistencias = 0;
 	//comprobamos si el concepto pertenece a farmacia
 		mysql_select_db($database_horizonte, $horizonte);
		$farm = mysql_query("SELECT id_to FROM conceptos WHERE id_tipo_concepto_to = 5 and id_to = $idE", $horizonte) or die (mysql_error());
		$esProd = mysql_fetch_row($farm);

		if($esProd[0] != ''){
			//obtenemos la cnatidad del mismo producto que se esta agregando a la orden de venta 
			mysql_select_db($database_horizonte, $horizonte);
			$cantConc = mysql_query("SELECT count(id_vc) FROM venta_conceptos WHERE no_temp_vc = $noTemp and id_concepto_es = $idE", $horizonte) or die (mysql_error());
			$cant_c = mysql_fetch_row($cantConc);

			// Obtenemos el id del producto en caso de que ya haya sido agregado a la orden de venta para actualizarlo
			mysql_select_db($database_horizonte, $horizonte);
			$query_id_producto = mysql_query("SELECT id_vc FROM venta_conceptos WHERE no_temp_vc = $noTemp and id_concepto_es = $idE", $horizonte) or die (mysql_error());
			$id_producto = mysql_fetch_row($query_id_producto)[0];

			//OBTENER EXISTENCIA TOTAL DEL PRODUCTO 
			mysql_select_db($database_horizonte, $horizonte);
			$totalExistencias = mysql_query("SELECT SUM(s.existencias) FROM stock_has_bach s left join stock s1 on s1.id = s.id_stock WHERE id_Producto = $idE and s1.id_su = $idSucursal ", $horizonte) or die (mysql_error());
			$cantExiste = mysql_fetch_row($totalExistencias);
			
			//verificamos si tiene existencias 
			mysql_select_db($database_horizonte, $horizonte);
			$ext = "SELECT s.id, s.existencias from stock_has_bach s left join conceptos c  on c.id_to = s.id_Producto where s.id_Producto = $idE order by s.id DESC";
			$existen = mysql_query($ext, $horizonte) or die (mysql_error());
			while ($stock = mysql_fetch_assoc($existen)){
				if($stock['existencias'] >= 1 AND ($cant_c[0] + 1 ) <= $cantExiste[0]){
					$idExistencias =  $stock['id'];
					$cantExistencias = $stock['existencias'];
					$banderaExistencias = true;
				}else{
					if($idExistencias != 0){
						$banderaExistencias = true;
					}
				}
			}
			if($banderaExistencias){
				if($ocupado==0){
					if ($id_producto != "") {
						mysql_select_db($database_horizonte, $horizonte); 
						$sql="UPDATE venta_conceptos ";
						$sql.=" SET cantidad = {$cantidad} WHERE no_temp_vc = $noTemp and id_concepto_es = $idE";

						$query_update = mysql_query($sql, $horizonte) or die (mysql_error());
						if (!$query_update) { echo $sql; }else{ 
							echo 1;
						}
					} else {
						mysql_select_db($database_horizonte, $horizonte); 
						$sql="INSERT INTO venta_conceptos(no_temp_vc,id_paciente_vc,id_usuario_vc,id_personal_medico_vc,id_concepto_es,id_convenio_vc,observaciones_vc,fecha_venta_vc,precio_vc,usuarioEdo1_e,fechaEdo1_e,id_conceptos_beneficios,cantidad,id_vc_shb)";
						$sql.="VALUES ($noTemp, $idP, $idU, $idMedico, $idE, $idConvenio, $observaciones, $fechaC, $precio,  $idU, $fechaC, $id_con_bene, $cantidad, $id_shb)";
						
						$sql_1="INSERT INTO venta_conceptos_1(no_temp_vc,id_paciente_vc,id_usuario_vc,id_personal_medico_vc,id_concepto_es,id_convenio_vc,observaciones_vc,fecha_venta_vc,precio_vc,usuarioEdo1_e,fechaEdo1_e,id_conceptos_beneficios,cantidad,id_vc_shb)";
						$sql_1.="VALUES ($noTemp, $idP, $idU, $idMedico, $idE, $idConvenio, $observaciones, $fechaC, $precio, $idU, $fechaC, $id_con_bene, $cantidad, $id_shb)";
							
						$update = mysql_query($sql, $horizonte) or die (mysql_error());
						if (!$update) { echo $sql; }else{ 
							echo 1;
							
							$update_1 = mysql_query($sql_1, $horizonte) or die (mysql_error());
						}
					}
				}else{echo 1;}
			}else{
				echo 2;
			}
		}else{
			if($ocupado==0){
				mysql_select_db($database_horizonte, $horizonte); 
				$sql="INSERT INTO venta_conceptos(no_temp_vc,id_paciente_vc,id_usuario_vc,id_personal_medico_vc,id_concepto_es,id_convenio_vc,observaciones_vc,fecha_venta_vc,precio_vc,precio_original,honorarios,usuarioEdo1_e,fechaEdo1_e,id_conceptos_beneficios,cantidad)";
				$sql.="VALUES ($noTemp, $idP, $idU, $idMedico, $idE, $idConvenio, $observaciones, $fechaC, $precio, $precio_orig, $honor, $idU, $fechaC, $id_con_bene, $cantidad)";
				
				$sql_1="INSERT INTO venta_conceptos_1(no_temp_vc,id_paciente_vc,id_usuario_vc,id_personal_medico_vc,id_concepto_es,id_convenio_vc,observaciones_vc,fecha_venta_vc,precio_vc,usuarioEdo1_e,fechaEdo1_e,id_conceptos_beneficios,cantidad)";
				$sql_1.="VALUES ($noTemp, $idP, $idU, $idMedico, $idE, $idConvenio, $observaciones, $fechaC, $precio, $idU, $fechaC, $id_con_bene, $cantidad)";
				 
				$update = mysql_query($sql, $horizonte) or die (mysql_error());
				if (!$update) { echo $sql; }else{ 
					echo 1;
				   
				   $update_1 = mysql_query($sql_1, $horizonte) or die (mysql_error());
				}
			}else{echo 1;}
		}

 	
 


 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
