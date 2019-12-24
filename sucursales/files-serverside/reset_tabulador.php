<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$para = $_POST["para"]; $idU = sqlValue($_POST["idU"], "int"); $pass = sqlValue($_POST["pass"], "text");
$p_t_i = sqlValue($_POST["p_t_i"], "int"); $p_t_l = sqlValue($_POST["p_t_l"], "int"); $p_t_s = sqlValue($_POST["p_t_s"], "int");
$tipo_tab_i = sqlValue($_POST["tipo_tab_i"], "int"); $tipo_tab_l = sqlValue($_POST["tipo_tab_l"], "int");
$idS = sqlValue($_POST["idS"], "int"); $k1 = $_POST["idS"].'_precio'; $k2 = $_POST["idS"].'_precio_u';

 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT usuario_u from usuarios where id_u = $idU ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result); $usuario = sqlValue($row[0], "text");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result1 = mysql_query("SELECT count(id_u) from usuarios where usuario_u = $usuario and contrasena_u = $pass ", $horizonte) or die (mysql_error());
 $row1 = mysql_fetch_row($result1);
 
 $ok = 0;
 
 if($row1[0]>0 and $row1[0]<2){
	 if($para=='i'){
		$uno = $p_t_i*0.01;
		if($_POST["tipo_tab_i"]==1){//tabulador base maquila
			$sql2 = "update conceptos set $k1 = precio_to*$uno, $k2 = precio_urgencia_to*$uno where id_tipo_concepto_to = 4";
		}else{//tabulador base sucursal
			$sql2 = "update conceptos set $k1 = precio1_to*$uno, $k2 = precio_urgencia1_to*$uno where id_tipo_concepto_to = 4";
		}
		$update2 = mysql_query($sql2, $horizonte) or die (mysql_error());
		if (!$update2) { $ok = $sql2; }else{
			$sqlz="UPDATE sucursales SET tipo_tabulador_i_su = $tipo_tab_i, p_tabulador_i_su = $p_t_i where id_su = $idS limit 1";

			mysql_select_db($database_horizonte, $horizonte);
			$insertarz = mysql_query($sqlz, $horizonte);
				
			if (!$insertarz) { $ok = $sqlz; }else { $ok = 1; } 
		}
	 }
	 elseif($para=='l'){
		$dos = $p_t_l*0.01;
		if($_POST["tipo_tab_l"]==1){//tabulador base maquila
			$sql3 = "update conceptos set $k1 = precio_to*$dos, $k2 = precio_urgencia_to*$dos where id_tipo_concepto_to = 3";
		}else{//tabulador base sucursal
			$sql3 = "update conceptos set $k1 = precio1_to*$dos, $k2 = precio_urgencia1_to*$dos where id_tipo_concepto_to = 3";
		}
		$update3 = mysql_query($sql3, $horizonte) or die (mysql_error());
		if (!$update3) { $ok = $sql3; }else{
			$sqlz="UPDATE sucursales SET tipo_tabulador_su = $tipo_tab_l, p_tabulador_l_su = $p_t_l where id_su = $idS limit 1";

			mysql_select_db($database_horizonte, $horizonte);
			$insertarz = mysql_query($sqlz, $horizonte);
				
			if (!$insertarz) { $ok = $sqlz; }else { $ok = 1; }
		}
	 }
	 elseif($para=='s'){
		$tres = $p_t_s*0.01;
		$sql4 = "update conceptos set $k1 = precio_to*$tres, $k2 = precio_urgencia_to*$tres where id_tipo_concepto_to = 2";
		$update4 = mysql_query($sql4, $horizonte) or die (mysql_error());
		if (!$update4) { $ok=$sql4; }else{
			$sqlz="UPDATE sucursales SET p_tabulador_s_su = $p_t_s where id_su = $idS limit 1";

			mysql_select_db($database_horizonte, $horizonte);
			$insertarz = mysql_query($sqlz, $horizonte);
				
			if (!$insertarz) { $ok = $sqlz; }else { $ok = 1; } 
		}
	 }
	 elseif($para=='t'){ //Borramos todos los tabuladores y los reconstruimos
		 
		$uno = $p_t_i*0.01;
		//Para imagen
		if($_POST["tipo_tab_i"]==1){//tabulador base maquila
			$sql2 = "update conceptos set $k1 = precio_to*$uno, $k2 = precio_urgencia_to*$uno where id_tipo_concepto_to = 4";
		}else{//tabulador base sucursal
			$sql2 = "update conceptos set $k1 = precio1_to*$uno, $k2 = precio_urgencia1_to*$uno where id_tipo_concepto_to = 4";
		}
		//Para laboratorio
		$update2 = mysql_query($sql2, $horizonte) or die (mysql_error());
		if (!$update2) { $ok = $sql2; }else{ $dos = $p_t_l*0.01;
			if($_POST["tipo_tab_l"]==1){//tabulador base maquila
				$sql3 = "update conceptos set $k1 = precio_to*$dos, $k2 = precio_urgencia_to*$dos where id_tipo_concepto_to = 3";
			}else{//tabulador base sucursal
				$sql3 = "update conceptos set $k1 = precio1_to*$dos, $k2 = precio_urgencia1_to*$dos where id_tipo_concepto_to = 3";
			}
			//Para servicios
			$update3 = mysql_query($sql3, $horizonte) or die (mysql_error());
			if (!$update3) { $ok = $sql3; }else{ $tres = $p_t_s*0.01;
				$sql4 = "update conceptos set $k1 = precio_to*$tres, $k2 = precio_urgencia_to*$tres where id_tipo_concepto_to = 2";
				$update4 = mysql_query($sql4, $horizonte) or die (mysql_error());
				if (!$update4) { $ok=$sql4; }else{
					$sqlz = "UPDATE sucursales SET tipo_tabulador_su = $tipo_tab_l, tipo_tabulador_i_su = $tipo_tab_i, p_tabulador_i_su = $p_t_i, p_tabulador_l_su = $p_t_l, p_tabulador_s_su = $p_t_s where id_su = $idS limit 1";

					mysql_select_db($database_horizonte, $horizonte);
					$insertarz = mysql_query($sqlz, $horizonte);
						
					if (!$insertarz) { $ok = $sqlz; }else { $ok = 1; }
				}
			}
		}
	 }
	 else{$ok=0;}
 }else{$ok=0;}

 echo $ok; 

mysql_close($horizonte);
?>