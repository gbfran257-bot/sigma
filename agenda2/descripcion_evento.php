<?php

/** https://github.com/icodeart/Calendario-Bootstrap-php-mysql **/
    
    //incluimos nuestro archivo config
    include './config.php'; 

    // Incluimos nuestro archivo de funciones
    include './funciones.php';

    // Obtenemos el id del evento
    $id  = evaluar($_GET['id']);

    // y lo buscamos en la base de dato
    $bd  = $conexion->query("SELECT * FROM agenda WHERE id=$id");

    // Obtenemos los datos
    $row = $bd->fetch_assoc();

    // titulo 
    $titulo=$row['title'];

    // cuerpo
    $evento=$row['body'];

    // Fecha inicio
    $inicio=$row['inicio_normal'];

    // Fecha Termino
    $final=$row['final_normal'];

    $id_departamento=$row['id_departamento'];
    $telefono_paciente=$row['telefono_paciente'];
    $email_doctor=$row['email_doctor'];
    $nombre_paciente=$row['nombre_paciente'];
    $direccion_paciente=$row['direccion_paciente'];
    $email_paciente=$row['email_paciente'];
    $telefono_doctor=$row['telefono_doctor'];
    $nombre_doctor=$row['nombre_doctor'];
    $departamento = "";

    switch ($id_departamento) {
        case 1:
            $departamento = "LABORATORIO";
            break;
        case 2:
            $departamento = "IMAGEN";
            break;
        case 3:
            $departamento = "FARMACIA";
            break;
        case 4:
            $departamento = "ASOCIACION MEDICA";
            break;
        default:
            $departamento = "Opción no válida";
            break;
    }

// Eliminar evento
if (isset($_POST['eliminar_evento'])) 
{
    $id  = evaluar($_GET['id']);
    $sql = "DELETE FROM agenda WHERE id = $id";
    if ($conexion->query($sql)) 
    {
        echo "Evento eliminado";
    }
    else
    {
        echo "El evento no se pudo eliminar";
    }
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$titulo?></title>
          <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
</head>
<body>
	 <h3><?=$titulo?></h3>
	 <hr>
     <b>Paciente:</b> <?=$nombre_paciente?> <br>
     <b>Telefono paciente:</b> <?=$telefono_paciente?> <br>
     <b>Dirección paciente:</b> <?=$direccion_paciente?> <br>
     <b>Doctor:</b> <?=$nombre_doctor?> <br>
     <b>Telefono Doctor:</b> <?=$telefono_doctor?> <br>
     <b>Departamento:</b> <?=$departamento?> <br>
     <b>Fecha inicio:</b> <?=$inicio?> <br>
     <b>Fecha termino:</b> <?=$final?>  <br>
 	 <b>Descripcion:</b><p><?=$evento?></p>
</body>
<form action="" method="post">
     <div class="modal-footer">
    <button type="submit" class="btn btn-danger" name="eliminar_evento">Eliminar</button>
</div>
</form>
</html>
