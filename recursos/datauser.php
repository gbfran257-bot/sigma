<?php
	if(isset($_SESSION['id'])){
		$id_u = $_SESSION['id'];
		
		mysql_select_db($database_horizonte, $horizonte);
		$result = mysql_query("SELECT t.abreviacion_ti, concat(u.nombre_u, ' ', u.apaterno_u), u.usuario_u, u.acceso_u, cp.nombre_cp, u.sexo_u, u.amaterno_u, idSucursal_u, multisucursal_u from usuarios u left join catalogo_puestos cp on cp.id_cp = u.idPuesto_u left join titulos t on t.id_ti = u.id_titulo_u where u.id_u = '$id_u' ", $horizonte) or die (mysql_error());
		$row = mysql_fetch_row($result);
		
		mysql_select_db($database_horizonte, $horizonte);
		$resultw = mysql_query("SELECT nombre_sistema_cf from configuracion order by id_cf desc limit 1 ", $horizonte) or die (mysql_error());
		$roww = mysql_fetch_row($resultw);
		
		$nombre_usuario = ucwords(strtolower($row[0].' '.$row[1]));
		$puesto_usuario = ucwords(strtolower($row[4]));
		$usuario_usuario = ucwords(strtolower($row[2]));
		$id_sucursal_u = $row[7]; $multisucu_u = $row[8];
		$nombre_system = $roww[0];
		
		if($row[5]==1){$usuario_bienvenida = 'Bienvenida '.ucwords(strtolower($row[1])).' '.ucwords(strtolower($row[6]));}
		else{$usuario_bienvenida = 'Bienvenido '.ucwords(strtolower($row[1])).' '.ucwords(strtolower($row[6]));}
	}else{
		header("Location: " . 'logout.php' );
	}