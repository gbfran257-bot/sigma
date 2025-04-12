<?php
 
 date_default_timezone_set("America/Mexico_City");
 
 try {
     require("../../Connections/horizonte2.php");
 
     if (!isset($_FILES['archivo_consultas'])) {
         throw new Exception("Selecciona un archivo válido.");
     }
 
     $archivo_consultas = $_FILES['archivo_consultas'];
     $id_consulta = $_POST['id_consulta'];
 
     $tipo_archivo = explode(".", $archivo_consultas['name']);
     $fecha = date("Y-m-d");
     $hora = date("H-i-s");
     $nombre_archivo_consultas = "archivo_notas_medicas_" . $id_consulta . "_" . $fecha . "_" . $hora . "." . $tipo_archivo[count($tipo_archivo) - 1];
 
     if (!move_uploaded_file($archivo_consultas['tmp_name'], "../archivos_notas_medicas/" . $nombre_archivo_consultas)) {
         throw new Exception("Ocurrió un error al subir el archivo.");
     }
     //Estamos reutilizando el modal de carga de consultas por lo que las variables se mantuvieron con el mismo nombre.
     $query_subir_archivo = "UPDATE notas_de_hospital SET archivo_notas_medicas = '{$nombre_archivo_consultas}' WHERE id_nh = {$id_consulta} LIMIT 1";
     if (!$resultado = mysqli_query($horizonte, $query_subir_archivo)) {
         throw new Exception(mysqli_error($horizonte));
     }
 
     echo json_encode(['success' => "Comprobante subido correctamente."]);
 
     mysqli_close($horizonte);
 } catch (\Exception $ex) {
     echo json_encode(['error' => $ex->getMessage()]);
 }
 
 die();