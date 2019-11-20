<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int"); $i = 0; $f = 0; $idU = sqlValue($_GET["idU"], "int"); $filillas = 0;

mysql_select_db($database_horizonte, $horizonte);
 $result2 = mysql_query("SELECT interpretacion_vc from venta_conceptos where id_vc = $idEvc ", $horizonte) or die (mysql_error());
 $row2 = mysql_fetch_row($result2);
  
$tabla = '<table id="p_contenido" width="500" border="0" cellspacing="6" cellpadding="4" style="text-align:left;"> <tr style="font-weight:bold;">
		<td width="730">'.$row2[0].'</td> </tr>';

/*if($filillas==1){$espacios = 'height="480"';}
else if($filillas==2){$espacios = 'height="455"';}
else if($filillas==3){$espacios = 'height="430"';}
else if($filillas==4){$espacios = 'height="405"';}
else if($filillas==5){$espacios = 'height="380"';}
else if($filillas==6){$espacios = 'height="355"';}
else if($filillas==7){$espacios = 'height="330"';}
else if($filillas==8){$espacios = 'height="305"';}
else if($filillas==9){$espacios = 'height="280"';}
else if($filillas==10){$espacios = 'height="255"';}
else if($filillas==11){$espacios = 'height="230"';}
else if($filillas==12){$espacios = 'height="205"';}
else if($filillas==13){$espacios = 'height="180"';}
else if($filillas==14){$espacios = 'height="155"';}
else if($filillas==15){$espacios = 'height="130"';}
else if($filillas==16){$espacios = 'height="105"';}
else{$espacios = '';}*/$espacios = 'height="105"';

if($f>0){
	$tabla = $tabla.'<tr> <td '.$espacios.' valign="top" nowrap colspan="1" style="font-size:0.2em; font-style:italic;" id="notaF"><hr style=" height:1px;">
<em>NOTA: <strong>*</strong> SIGNIFICA VALOR FUERA DE RANGO</em></td> </tr>';
}else{$tabla = $tabla.'<tr> <td nowrap colspan="1" style="font-size:0.2em; font-style:italic;" id="notaF"><hr style=" height:1px;">
</td> </tr>';}

$tabla = $tabla.'</table>';
$tabla1 = sqlValue($tabla, "text");

 mysql_select_db($database_horizonte, $horizonte);
 $sqlX = "UPDATE usuarios SET variable_temporal_u = $tabla1 where id_u = $idU limit 1";
 $updateX = mysql_query($sqlX, $horizonte) or die (mysql_error());
	
 if(!$updateX){ echo $sqlX; }else{ echo $tabla; }
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>