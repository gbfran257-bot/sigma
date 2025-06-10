<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
//require('config.php');
$tipo       = $_FILES['dataCliente']['type'];
$tamanio    = $_FILES['dataCliente']['size'];
$archivotmp = $_FILES['dataCliente']['tmp_name'];
$lineas     = file($archivotmp);
$now = sqlValue(date('Y-m-d H:i:s'), "date");

$i = 1;

foreach ($lineas as $linea) {
    $cantidad_registros = count($lineas);

    if ($cantidad_registros > 0) {

        if (substr($linea, 0, 3) === "\xEF\xBB\xBF") {
            $linea = substr($linea, 3);
        }
        
        $linea = mb_convert_encoding($linea, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
        $datos = explode(",", $linea);
       
        $curp = !empty($datos[0])  ? ($datos[0]) : '';
        $nombre = !empty($datos[1])  ? ($datos[1]) : '';
        $a_paterno = !empty($datos[2])  ? ($datos[2]) : '';
        $a_materno = !empty($datos[3])  ? ($datos[3]) : '';
        $telefono = !empty($datos[4])  ? ($datos[4]) : '';
        $sexo = !empty($datos[5])  ? ($datos[5]) : '';
        $f_nacimiento = !empty($datos[6])  ? ($datos[6]) : '';
        $estado = !empty($datos[7])  ? ($datos[7]) : '';
        $correo_electronico = !empty($datos[8])  ? ($datos[8]) : '';
        $nombre_completo = "$nombre $a_paterno $a_materno";

        mysql_select_db($database_horizonte, $horizonte);
        $sql = "INSERT INTO pacientes (idUsuarioR_p, nombre_p, apaterno_p, amaterno_p, sexo_p, nacionalidad_p, fNac_p, ".
        "tCelular_p, tParticular_p, curp_p, rfc_p, idSucursal_p, entidadFederativa_p, municipio_p, ciudad_p, colonia_p, ".
        "cp_p, calle_p, tTrabajo_p, extensionTt_p, email_p, fechaR_p, entidad_nacimiento_p, razon_social_p, calle_pf, ".
        "entidadFederativa_pf, municipio_pf, ciudad_pf, colonia_pf, cp_pf, rfc_f_p, tSanguineo_p, nombre_completo_p, ".
        "coordenadas_p, email_pf, contactoEmergencia_p, tEmergencia_p, facebook, instagram, puesto_p, clave_p, ".
        "titular, paciente_titular, parentesco, clave_t, tipo_trabajador, departamento)";
        $sql.= "VALUES (1, '$nombre', '$a_paterno', '$a_materno', $sexo, 146, '$f_nacimiento', $telefono, $telefono, ".
        "'$curp', NULL, 4, $estado, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$correo_electronico', ".
        "$now, $estado, NULL, NULL, $estado, NULL, NULL, NULL, NULL, NULL, NULL, ".
        "'$nombre_completo', NULL, '$correo_electronico', NULL, NULL, NULL, NULL, NULL, NULL, ".
        "0, NULL, NULL, NULL, NULL, NULL)";
         
        //echo $sql;
        $update = mysql_query($sql, $horizonte) or die (mysql_error());
    }

      echo '<div>'. $i. "). " .$linea.'</div>';
    $i++;
}


  echo '<p style="text-aling:center; color:#333;">Total de Registros: '. $cantidad_registros .'</p>';

?>

<a href="../../importar_pacientes.php">Atras</a>