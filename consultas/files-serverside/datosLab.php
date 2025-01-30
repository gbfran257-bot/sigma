<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idC = $_POST["idC"]; //'$_GET[aleatorio]'

	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT v.id_vc, v.estatus_vc, v.referencia_vc, v.nota_radiologo_vc, c.concepto_to from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where v.id_paciente_vc = $idP and c.id_tipo_concepto_to = 3 and v.estatus_vc > 6 and v.id_vc = $idC order by v.id_vc desc limit 1 ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $ultimo = sqlValue($row[0], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
 $result2 = mysql_query("SELECT v.id_concepto_es, v.nota_radiologo_vc, DATE_FORMAT(v.fecha_venta_vc,'%d/%c/%Y'), v.usuarioEdo4_e, v.id_personal_medico_vc, s.nombre_su, v.contador_vc, v.usuarioEdo4_e, s.id_su, concat(s.id_su,'.',s.id_su), c.id_tipo_concepto_to from venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es left join sucursales s on s.id_su = c.id_tipo_concepto_to where v.id_vc = $idC ", $horizonte) or die (mysql_error());
 $row2 = mysql_fetch_row($result2); $id_suc = sqlValue($row2[9], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
 	$result1 = mysql_query("SELECT concat(p.nombre_p, p.apaterno_p), p.amaterno_p, DATE_FORMAT(p.fNac_p,'%d/%c/%Y'), s.cat_sexo, p.fNac_p from pacientes p left join catalogo_sexos s on s.id_sexo = p.sexo_p where p.id_p = $idP ", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);

	 if(substr($row[4], 0, 12) == 'CUESTIONARIO'){
		$esCuestionario = 1;
	}
	else{
		$esCuestionario = 0;
	}
			
	echo $ultimo.'{;}'.$row[1].'{;}'.$row1[0].' '.$row1[1].'{;}'.$row[2].'{;}'.$row[3].'{;}'.$esCuestionario;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>