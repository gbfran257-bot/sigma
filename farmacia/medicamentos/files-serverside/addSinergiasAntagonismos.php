<?php
require("../../../Connections/horizonte.php");

// Abrimos la conexion con la base de datos.
mysql_select_db($database_horizonte, $horizonte);

$sinergias = json_decode($_POST['sinergias']);
$antagonismos = json_decode($_POST['antagonismos']);

// Obtenemos el id del medicamento recién registrado
$selectID = "SELECT MAX(id_to) AS id_to_medicamento FROM conceptos";
$idMedicamento = intval(mysql_fetch_assoc(mysql_query($selectID, $horizonte))['id_to_medicamento']);

//verificamos si se trata de creacion de nuevo registro o actualizacion
if(isset($_GET['id_med_com'])){
    $id_medicamento_com = $_GET['id_med_com'];
}else{
    $id_medicamento_com = $idMedicamento;
}

// Primero registramos todas las sinergias
for ($i = 0; $i < count($sinergias); $i++) {
    // Insertamos las sinergias
    $insertSinergia = "INSERT INTO sinergia(id_medicamento) VALUES($sinergias[$i])";
    $resultado = mysql_query($insertSinergia, $horizonte);

    if (!$resultado) {
        echo json_encode(['ERROR' => 'Ocurrió un error al registrar las sinergias']);
        die();
    }

    // Obtenemos el id de la sinergia recién registrada
    $selectIdSinergia = "SELECT MAX(id) AS id_sinergia FROM sinergia";
    $idSinergia = mysql_fetch_assoc(mysql_query($selectIdSinergia, $horizonte))['id_sinergia'];

    //buscamos si ya existe la sinergia registrada, de ser el caso se elimina.
    //verificamos si existe
    mysql_select_db($database_horizonte, $horizonte);
    $query_find_sin = mysql_query("SELECT COUNT(*) FROM sinergia s LEFT JOIN medicamento_sinergia m ON m.id_sinergia = s.id WHERE m.id_medicamento = ".$id_medicamento_com." AND s.id_medicamento = " . $sinergias[$i]);
    $ejecutar_qfs = mysql_fetch_row($query_find_sin);
    $existe_sin = $ejecutar_qfs[0];

    //obtenemos datos
    mysql_select_db($database_horizonte, $horizonte);
    $query_data_sin = mysql_query("SELECT m.id_medicamento, m.id_sinergia FROM sinergia s LEFT JOIN medicamento_sinergia m ON m.id_sinergia = s.id WHERE m.id_medicamento = ".$id_medicamento_com." AND s.id_medicamento = " . $sinergias[$i]);
    $ejecutar_qds = mysql_fetch_row($query_data_sin);
    $medicamento_m = $ejecutar_qds[0];
    $sinergia_m = $ejecutar_qds[1];

    if($existe_sin>=1){
        mysql_select_db($database_horizonte, $horizonte); 
        $sql_del_sin = "DELETE FROM medicamento_sinergia WHERE id_medicamento = ". $medicamento_m . " AND id_sinergia = " . $sinergia_m;
        $update = mysql_query($sql_del_sin, $horizonte) or die (mysql_error());
    }else{
        // insertamos la relación medicamento - sinergia
        $insertMedicamentoSinergia = "INSERT INTO medicamento_sinergia(id_medicamento, id_sinergia) VALUES($id_medicamento_com, $idSinergia)";
        $resultado = mysql_query($insertMedicamentoSinergia, $horizonte);
    
        if (!$resultado) {
            echo json_encode(['ERROR' => 'Ocurrió un error al registrar las sinergias del medicamento']);
            die();
        }
    }

}

// Después insertamos todos los antagonismos
for ($i = 0; $i < count($antagonismos); $i++) {
    // Insertamos las antagonismos
    $insertAntagonismo = "INSERT INTO antagonismo(id_medicamento) VALUES($antagonismos[$i])";
    $resultado = mysql_query($insertAntagonismo, $horizonte);

    if (!$resultado) {
        echo json_encode(['ERROR' => 'Ocurrió un error al registrar los antagonismos']);
        die();
    }

    // Obtenemos el id del antagonismo recién registrada
    $selectIdAntagonismo = "SELECT MAX(id) AS id_antagonismo FROM antagonismo";
    $idAntagonismo = mysql_fetch_assoc(mysql_query($selectIdAntagonismo, $horizonte))['id_antagonismo'];

    //buscamos si ya existe el antagonismo registrado, de ser el caso se elimina.
    //verificamos si existe
    mysql_select_db($database_horizonte, $horizonte);
    $query_find_sin2 = mysql_query("SELECT COUNT(*) FROM antagonismo s LEFT JOIN medicamento_antagonismo m ON m.id_antagonismo = s.id WHERE m.id_medicamento = ".$id_medicamento_com." AND s.id_medicamento = " . $antagonismos[$i]);
    $ejecutar_qfs2 = mysql_fetch_row($query_find_sin2);
    $existe_sin2 = $ejecutar_qfs2[0];

    //obtenemos datos
    mysql_select_db($database_horizonte, $horizonte);
    $query_data_sin2 = mysql_query("SELECT m.id_medicamento, m.id_antagonismo FROM antagonismo s LEFT JOIN medicamento_antagonismo m ON m.id_antagonismo = s.id WHERE m.id_medicamento = ".$id_medicamento_com." AND s.id_medicamento = " . $antagonismos[$i]);
    $ejecutar_qds2 = mysql_fetch_row($query_data_sin2);
    $medicamento_m2 = $ejecutar_qds2[0];
    $sinergia_m2 = $ejecutar_qds2[1];

    if($existe_sin2>=1){
        mysql_select_db($database_horizonte, $horizonte); 
        $sql_del_sin2 = "DELETE FROM medicamento_antagonismo WHERE id_medicamento = ". $medicamento_m2 . " AND id_antagonismo = " . $sinergia_m2;
        $update2 = mysql_query($sql_del_sin2, $horizonte) or die (mysql_error());
    }else{
        // insertamos la relación medicamento - antagonismo
        $insertMedicamentoAntagonismo = "INSERT INTO medicamento_antagonismo(id_medicamento, id_antagonismo) VALUES($id_medicamento_com, $idAntagonismo)";
        $resultado = mysql_query($insertMedicamentoAntagonismo, $horizonte);
    
        if (!$resultado) {
            echo json_encode(['ERROR' => 'Ocurrió un error al registrar los antagonismos del medicamento']);
            die();
        }
    }

}

echo json_encode(['EXITO' => "El medicamento se ha creado satisfactoriamente"]);
die();

// Cerramos la conexion con la base de datos
mysql_close($horizonte);
