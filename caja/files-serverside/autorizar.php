<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idOv = sqlValue($_POST["id_ov"], "int");
 $id_u = sqlValue($_POST["id_u"], "int");
 $refe = sqlValue($_POST["ref"], "text");
 $bandera = sqlValue($_POST["autorizado"], "int");

if($bandera == 10){
        mysql_select_db($database_horizonte, $horizonte);
    	//	ELIMINA DE LA TABLA DE VENTA_CONCEPTOS
        $sql = "delete from venta_conceptos where referencia_vc = $refe";
        $update = mysql_query($sql, $horizonte) or die (mysql_error());

        if (!$update) {echo $sql;} else{
            //	ELIMINA DE LA TABLA DE PAGOS_OV
            $sql1 = "delete from pagos_ov where referencia_pag = $refe";
            $update1 = mysql_query($sql1, $horizonte) or die (mysql_error()); 

            if (!$update1) {echo $sql1;} else{ 
                 //	ELIMINA DE LA TABLA DE ORDEN_VENTA
                $sql2 = "delete from orden_venta where referencia_ov = $refe limit 1";
                $update2 = mysql_query($sql2, $horizonte) or die (mysql_error());
                if (!$update2) {echo $sql2;} else{
                    $sql3 = "UPDATE orden_venta_del set estatus = 1 where id_ov = $idOv";
                    $update3 = mysql_query($sql3, $horizonte) or die (mysql_error()); 

                    echo 1;
                
                }
            }
        }
}else{
    
        mysql_select_db($database_horizonte, $horizonte);
        //	ELIMINA DE LA TABLA DE VENTA_CONCEPTOS
        $sql = "delete from venta_conceptos_del where referencia_vc = $refe";
        $update = mysql_query($sql, $horizonte) or die (mysql_error());

        if (!$update) {echo $sql;} else{
            //	ELIMINA DE LA TABLA DE PAGOS_OV
            $sql1 = "delete from pagos_ov_del where referencia_pag = $refe";
            $update1 = mysql_query($sql1, $horizonte) or die (mysql_error()); 

            if (!$update1) {echo $sql1;} else{ 
                 //	ELIMINA DE LA TABLA DE ORDEN_VENTA
                $sql2 = "delete from orden_venta_del where referencia_ov = $refe limit 1";
                $update2 = mysql_query($sql2, $horizonte) or die (mysql_error());
                if (!$update2) {echo $sql2;} else{ echo 1; }
            }
        }
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>