<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
// Recibir datos JSON
$data = json_decode(file_get_contents("php://input"), true);

if(isset($data["imagen"]) && isset($data["idf"]) && $data["idf"] != "") {

    $imagen = $data["imagen"];
    $idf    = $data["idf"];
    $now = sqlValue(date('Y-m-d H:i:s'), "date");

    //Buscamos si existe el id del paciente
    mysql_select_db($database_horizonte, $horizonte);
    $resultid = mysql_query("SELECT referencia_ov, id_paciente_ov FROM orden_venta WHERE id_paciente_ov = $idf ORDER BY id_ov DESC limit 1", $horizonte) or die (mysql_error());
    $idpaciente = mysql_fetch_row($resultid);

    if($idpaciente[1] >= 1){
        // Quitar encabezado "data:image/png;base64,"
        $imagen = str_replace("data:image/png;base64,", "", $imagen);
        $imagen = str_replace(" ", "+", $imagen);
    
        // Decodificar Base64
        $imagenBinaria = base64_decode($imagen);
    
        //obtenemos el valor de time
        //$time = time();
    
        //guardamos el registro en bd
        mysql_select_db($database_horizonte, $horizonte);
        $sql = "INSERT INTO documentos (nombre_do, ext_do, aleatorio_do, tipo_quien_do, usuario_do, fecha_do, que_es_do)";
        $sql.= "VALUES ('firma_".$idpaciente[0]."', 'png', ".$idpaciente[1].", 1, 1, $now, 'IMAGEN')";
        $update = mysql_query($sql, $horizonte) or die (mysql_error());
    
        //obtenemos el ultimo id guardado para nombrar la imagen como id.png
        mysql_select_db($database_horizonte, $horizonte);
        $resultF = mysql_query("SELECT MAX(id_do) from documentos limit 1 ", $horizonte) or die (mysql_error());
        $rowF = mysql_fetch_row($resultF);
        $nombreimg = $rowF[0].".png";
    
        // Guardar en archivo
        $nombreArchivo = "../documentos/fotos/$nombreimg";
        $resultado = file_put_contents($nombreArchivo, $imagenBinaria);
    
        if ($resultado !== false && file_exists($nombreArchivo)) {
            echo 1;
        } else {
            echo "Error: No se pudo guardar la imagen.";
        }
    }else{
        echo "Identificador no encontrado.";
    }

} else {
    echo "No se recibió la imagen y/o el identificador.";
}
?>
