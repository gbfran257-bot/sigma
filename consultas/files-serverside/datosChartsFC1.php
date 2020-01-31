<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idP = sqlValue($_POST["idP"], "int");
	$idCons = sqlValue($_POST["idCo"], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$resultDC = mysql_query("SELECT id_signosv_vc, count(id_vc) from venta_conceptos where id_vc = $idCons and id_paciente_vc = $idP ", $horizonte) or die (mysql_error());
	$rowDC = mysql_fetch_row($resultDC);
	
	if($rowDC[1]>0){
		$idSV = sqlValue($rowDC[0], "int");
	}else{
		mysql_select_db($database_horizonte, $horizonte);
		$resultDC1 = mysql_query("SELECT id_sv from signos_vitales where id_paciente_sv = $idP order by id_sv desc limit 1 ", $horizonte) or die (mysql_error());
		$rowDC1 = mysql_fetch_row($resultDC1);
		$idSV = sqlValue($rowDC1[0], "int");
	}
		
	$lista = ''; $lista1 = ''; $cont = 0; $vI = ''; $vF = ''; $lista2 = ''; $vIfr = ''; $vFfr = '';
	$listaT = ''; $listaT_ = ''; $vIt = ''; $vFt = ''; $listaA = ''; $vIa = ''; $vFa = ''; $listaTe = ''; $vIte = ''; $vFte = '';
	$listaPe = ''; $vI_pe = ''; $vF_pe = ''; $listaTa = ''; $listaIMC = ''; $lista1_imc = ''; $cont_imc = 0;
		
	mysql_select_db($database_horizonte, $horizonte);
	$consultaIm = "SELECT imc_sv, DATE_FORMAT(fecha_sv,'%d/%c/%Y') as fecha from signos_vitales where id_paciente_sv = $idP and id_sv <= $idSV group by DATE_FORMAT(fecha_sv,'%d/%c/%Y') order by id_sv desc limit 25";
	$queryIm = mysql_query($consultaIm) or die (mysql_error());
	while ($filaIm = mysql_fetch_array($queryIm)) { $cont_imc++;
		if($cont_imc==1){$listaIMC = $filaIm['imc_sv'];}else{$listaIMC = $listaIMC.','.$filaIm['imc_sv'];}
		if($cont_imc==1){$lista1_imc = $filaIm['fecha'];}else{$lista1_imc = $lista1_imc.','.$filaIm['fecha'];}
	};//echo $lista;
	
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT fc_sv as x, DATE_FORMAT(fecha_sv,'%d/%c/%Y') as fecha, peso_sv, DATE_FORMAT(fecha_sv,'%Y-%c-%d') as fecha1, fr_sv as xfr, TRUNCATE( (t_sv), 2) as x_t, TRUNCATE( (a_sv), 2) as x_a, temperatura_sv as x_te, peso_sv as x_pe, talla_sv as x_ta, imc_sv as x_imc from signos_vitales where id_paciente_sv = $idP and id_sv <= $idSV order by id_sv desc limit 25";
	$query = mysql_query($consulta) or die (mysql_error());
	while ($fila = mysql_fetch_array($query)) { $cont++;
		if($fila['x_t']=='' or $fila['x_t']==NULL){ $fila['x_t'] = 0; }
		if($fila['x_a']=='' or $fila['x_a']==NULL){ $fila['x_a'] = 0; }
		if($fila['x_te']=='' or $fila['x_te']==NULL){ $fila['x_te'] = 0; }
		if($fila['x_pe']=='' or $fila['x_pe']==NULL){ $fila['x_pe'] = 0; }
		if($fila['x_ta']=='' or $fila['x_ta']==NULL){ $fila['x_ta'] = 0; }
		if($fila['x_imc']=='' or $fila['x_imc']==NULL){ $fila['x_imc'] = 0; }
		
		if($cont==1){$lista = $fila['x'];}else{$lista = $lista.','.$fila['x'];}
		if($cont==1){$lista1 = $fila['fecha'];}else{$lista1 = $lista1.','.$fila['fecha'];}
		if($cont==1){$lista2 = $fila['xfr'];}else{$lista2 = $lista2.','.$fila['xfr'];}
		//Para T
		if($cont==1){$listaT = $fila['x_t'];}else{$listaT = $listaT.','.$fila['x_t'];}
		//Para A
		if($cont==1){$listaA = $fila['x_a'];}else{$listaA = $listaA.','.$fila['x_a'];}
		//Para Temp
		if($cont==1){$listaTe = $fila['x_te'];}else{$listaTe = $listaTe.','.$fila['x_te'];}
		//Para Peso
		if($cont==1){$listaPe = $fila['x_pe'];}else{$listaPe = $listaPe.','.$fila['x_pe'];}
		//Para Talla
		if($cont==1){$listaTa = $fila['x_ta'];}else{$listaTa = $listaTa.','.$fila['x_ta'];}
		//Para IMC
		if($cont==1){$listaIMC = $fila['x_imc'];}else{$listaIMC = $listaIMC.','.$fila['x_imc'];}
		
		$miF = $fila['fecha1'];
		mysql_select_db($database_horizonte, $horizonte); 
		$resultC = mysql_query("SELECT DATEDIFF('$miF',fNac_p) from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
		$rowC = mysql_fetch_row($resultC); $dias = $rowC[0];
		$edad = $dias/365; $peso = $fila['peso_sv'];
		
		mysql_select_db($database_horizonte, $horizonte);
		$resultAg = mysql_query("SELECT max(peso_sv) from signos_vitales where id_paciente_sv = $idP and id_sv <= $idSV ", $horizonte) or die (mysql_error());
		$rowAg = mysql_fetch_row($resultAg);
	
		$vMinPe = 0; $vMaxPe = $rowAg[0];
		
		if($edad==0){
			if( $peso < 2.5 ){
				$vMin = 140; $vMax = 160;
				$vMinFr = 40; $vMaxFr = 60;
				$vMinT = 39; $vMaxT = 59;
				$vMinA = 16; $vMaxA = 36;
			}
			if( $peso >= 2.5 and $peso <= 4 ){
				$vMin = 140; $vMax = 160; 
				$vMinFr = 40; $vMaxFr = 60;
				$vMinT = 50; $vMaxT = 75;
				$vMinA = 30; $vMaxA = 50;
			}
			if( $peso >= 4 and $peso <= 6 ){
				$vMin = 120; $vMax = 160; 
				$vMinFr = 30; $vMaxFr = 50;
				$vMinT = 80; $vMaxT = 100;
				$vMinA = 45; $vMaxA = 65;
			}		
		}
		if($edad>=1 and $edad <=2){
			$vMin = 100; $vMax = 140;
			$vMinFr = 24; $vMaxFr = 40;
			$vMinT = 80; $vMaxT = 105;
			$vMinA = 45; $vMaxA = 70;
		}
		if($edad>=2 and $edad <=3){
			$vMin = 90; $vMax = 140;
			$vMinFr = 24; $vMaxFr = 40;
			$vMinT = 80; $vMaxT = 120;
			$vMinA = 50; $vMaxA = 80;
		}
		if($edad>=3 and $edad <=4){
			$vMin = 85; $vMax = 125;
			$vMinFr = 23; $vMaxFr = 37;
			$vMinT = 80; $vMaxT = 120;
			$vMinA = 50; $vMaxA = 80;
		}
		if($edad>=4 and $edad <=5){
			$vMin = 80; $vMax = 110;
			$vMinFr = 22; $vMaxFr = 34;
			$vMinT = 80; $vMaxT = 120;
			$vMinA = 50; $vMaxA = 80;
		}
		if($edad>=5 and $edad <=6){
			$vMin = 78; $vMax = 105;
			$vMinFr = 20; $vMaxFr = 31;
			$vMinT = 80; $vMaxT = 120;
			$vMinA = 50; $vMaxA = 80;
		}
		if($edad>=6 and $edad<=13){
			$vMin = 75; $vMax = 100;
			$vMinFr = 18; $vMaxFr = 28;
			if($edad<=10){
				$vMinT = 85; $vMaxT = 130;
				$vMinA = 55; $vMaxA = 90;
			}
			if($edad>=10){
				$vMinT = 90; $vMaxT = 140;
				$vMinA = 60; $vMaxA = 95;
			}
		}
		if($edad>13){
			$vMin = 60; $vMax = 90;
			$vMinFr = 12; $vMaxFr = 28;
			if($edad>=13 and $edad<=14){
				$vMinT = 90; $vMaxT = 140;
				$vMinA = 60; $vMaxA = 95;
			}
			if($edad>14){
				$vMinT = 90; $vMaxT = 140;
				$vMinA = 60; $vMaxA = 95;
			}
		}
		
		if($cont==1){$vI = $vMin;}else{$vI = $vI.','.$vMin;}
		if($cont==1){$vF = $vMax;}else{$vF = $vF.','.$vMax;}
		
		$vIn1 = $vMin; $vMa1 = $vMax;
		$vInFr = $vMinFr; $vMaFr = $vMaxFr;
		//Para T
		$vInT = $vMinT; $vMaT = $vMaxT;
		//Para A
		$vInA = $vMinA; $vMaA = $vMaxA;
		//Para Temp
		$vMinTe = 36.5; $vMaxTe = 37.5;
		//Para IMC
		$vMinIMC = 18.50; $vMaxIMC = 25;
		
	};
			
	echo $lista1.';*['.$lista.'];*'.$cont.';*'.$vI.';*'.$vF.';*'.$vIn1.';*'.$vMa1.';*['.$lista2.'];*'.$vInFr.';*'.$vMaFr.';*['.$listaT.'];*'.$vInT.';*'.$vMaT.';*['.$listaA.'];*'.$vInA.';*'.$vMaA.';*['.$listaTe.'];*'.$vMinTe.';*'.$vMaxTe.';*['.$listaPe.'];*'.$vMinPe.';*'.$vMaxPe.';*['.$listaTa.'];*'.'['.$listaIMC.'];*'.$vMinIMC.';*'.$vMaxIMC.';*["mmHg",'.$listaT.']'.';*["mmHg",'.$listaA.']'.';*["x min",'.$lista2.']'.';*["x min",'.$lista.']'.';*["",'.$listaIMC.']'.';*["ªC",'.$listaTe.']'.';*["Kg",'.$listaPe.']'.';*["m",'.$listaTa.']';
	//   fechas       valores     cuantos  rango inicial   rango final válidos $
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>
