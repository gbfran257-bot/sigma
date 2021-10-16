<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

    $now = sqlValue(date('Y-m-d H:i:s'), "date");
    $cont = 0;
    mysql_select_db($database_horizonte, $horizonte);
	$result=mysql_query("SELECT id_su, clave_su, usuario_su FROM sucursales", $horizonte) or die(mysql_error()); 

    while($fila = mysql_fetch_assoc($result)){
        
        $idUsuario = $fila['usuario_su'];
        $idS = $fila['id_su'];
        $clave = sqlValue($fila['clave_su'], "text");

        mysql_select_db($database_horizonte, $horizonte);
	    $result1=mysql_query("SELECT id, clave_su FROM stock where id_su = $idS", $horizonte) or die(mysql_error()); 
        $row=mysql_fetch_row($result1);
	    $idStock = sqlValue($row[0], "int");
       
       
        if($row[0] == ''){
            //crear almacen de la sucursal 
            mysql_select_db($database_horizonte, $horizonte);
            $inv = "INSERT INTO stock (clave_su, id_su, usuario_registro, fecha_creacion, fecha_actualizacion)";
            $inv.= "VALUES ($clave, $idS, $idUsuario, $now, $now)";
            $create_inv = mysql_query($inv, $horizonte) or die (mysql_error());
            echo $inv;
        }
    }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>