<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");


if(!isset($_GET['idP'])){
    $aleatorio ="imagen_";
    mysql_select_db($database_horizonte, $horizonte);
    $sql = "SELECT * FROM documentos WHERE aleatorio_do like 'imagen_%'";
    $img = mysql_query($sql, $horizonte) or die (mysql_error());

    $cont = 1;
    $salida='';
    while ($fila =mysql_fetch_array($img)){
        $idU = $fila['usuario_do'];
        mysql_select_db($database_horizonte, $horizonte);
        $sql = "SELECT id_u, nombre_u, apaterno_u FROM usuarios WHERE id_u = $idU";
        $usuario = mysql_query($sql, $horizonte) or die (mysql_error());
        $rowF = mysql_fetch_row($usuario);
        $nombre = $rowF[1] . ' ' . $rowF[2];

        $salida .="
        <tr>
            <td class='text-center'>$cont</td>
            <td class='text-center'>".$fila['nombre_do']."</td>
            <td class='text-center'>".$nombre."</td>
            <td class='text-center'>".$fila['fecha_do']."</td>
            <td>
                <div align='center'><button type='button' lang='".$fila['id_do']."' class='btn btn-success btn-xs' onClick='ver_docu(this.lang,\"".$fila['ext_do']."\")'><i class='fa fa-eye' aria-hidden='true'></i></button></div>
            </td>";
            // if($fila['perfil_do'] == 1 ){
            //     $salida .="
            //     <td>
            //     <div align='center'><button type='button' class='btn bg-gray colorPink  btn-xs' lang='".$fila['id_do']."' id='".$fila['aleatorio_do']."' onClick='perfilMem(this.lang, this.id, \"NO\");'><i class='fa fa-check' aria-hidden='true'></i></button></div>
            //     </td>";
            // }else{
            //     $salida .="<td><div align='center'><button type='button' class='btn bg-gray colorPink  btn-xs' lang='".$fila['id_do']."' id='".$fila['aleatorio_do']."' onClick='perfilMem(this.lang, this.id, \"NO\");'><i class='fa fa-refresh' aria-hidden='true'></i></button></div></td>";
            // }
            $salida .="
            <td>
                <div align='center'><button type='button' lang='".$fila['id_do']."' class='btn btn-danger btn-xs' onClick='eliminarImg(".$fila['id_do'].",\"".$fila['nombre_do']."\",\"NO\")'><i class='fa fa-trash' aria-hidden='true'></i></button></div>
            </td>
        </tr>";
        $cont++;
    }
}else{
    $idP =$_GET['idP']; 
    mysql_select_db($database_horizonte, $horizonte);
    $sql = "SELECT * FROM documentos WHERE tipo_quien_do = 1 AND aleatorio_do = $idP";
    $img = mysql_query($sql, $horizonte) or die (mysql_error());

    $cont = 1;
    $salida='';
    while ($fila =mysql_fetch_array($img)){
        $idU = $fila['usuario_do'];
        mysql_select_db($database_horizonte, $horizonte);
        $sql = "SELECT id_u, nombre_u, apaterno_u FROM usuarios WHERE id_u = $idU";
        $usuario = mysql_query($sql, $horizonte) or die (mysql_error());
        $rowF = mysql_fetch_row($usuario);
        $nombre = $rowF[1] . ' ' . $rowF[2];
        $Perfil= false;

        $salida .="
        <tr>
            <td class='text-center'>$cont</td>
            <td class='text-center'>".$fila['nombre_do']."</td>
            <td class='text-center'>".$nombre."</td>
            <td class='text-center'>".$fila['fecha_do']."</td>
            <td>
                <div align='center'><button type='button' lang='".$fila['id_do']."' class='btn btn-success btn-xs' onClick='ver_docu(this.lang,\"".$fila['ext_do']."\")'><i class='fa fa-eye' aria-hidden='true'></i></button></div>
            </td>";
            if($fila['perfil_do'] == 1 ){
                $salida .="
                <td>
                <div align='center'><button type='button' class='btn bg-gray colorPink  btn-xs' lang='".$fila['id_do']."' id='".$fila['aleatorio_do']."' onClick='perfilMem(this.lang, this.id, 1);'><i class='fa fa-check' aria-hidden='true'></i></button></div>
                </td>";
            }else{
                $salida .="<td><div align='center'><button type='button' class='btn bg-gray colorPink  btn-xs' lang='".$fila['id_do']."' id='".$fila['aleatorio_do']."' onClick='perfilMem(this.lang, this.id, 0);'><i class='fa fa-refresh' aria-hidden='true'></i></button></div></td>";
            }
            $salida .="<td>
                <div align='center'><button type='button' lang='".$fila['id_do']."' class='btn btn-danger btn-xs' onClick='eliminarImg(".$fila['id_do'].",\"".$fila['nombre_do']."\",".$idP.")'><i class='fa fa-trash' aria-hidden='true'></i></button></div>
            </td>
        </tr>";
        $cont++;
    }
}
echo $salida;
