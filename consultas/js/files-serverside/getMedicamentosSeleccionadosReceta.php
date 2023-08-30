<?php

require("../../../Connections/horizonte2.php");

## Verificamos que la consulta se haya hecho de manera correcta
if (empty($_GET) || empty($_GET['id_c'])) {
    echo json_encode(['error' => 'Ocurrió un error con la petición.']);
    die();
}

try {
    ## Obtenemos el id de la consulta para obtener sus medicamentos
    $id_consulta = intval(htmlspecialchars($_GET['id_c'], ENT_QUOTES, "utf-8", true));

    ## Preparamos la consulta para obtener los medicamentos
    $sql = "SELECT
            c.concepto_to AS nombre_comercial,
            m.nombre_generico_med AS nombre_generico,
            m.descripcion_med AS forma_farmaceutica,
            m.presentaciones_med AS presentacion,
            m.via_administracion_med AS via_administracion,
            m.indicaciones_med AS indicaciones_uso
            FROM medicamentos_receta mr
            LEFT JOIN conceptos c ON c.id_to = mr.id_med_mr
            LEFT JOIN medicamentos m ON m.id_med = c.id_medicamento_g
            WHERE mr.id_co_mr = ? AND c.id_area_to = 61 AND c.id_departamento_to = 3 AND c.id_tipo_concepto_to = 5";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("i", $id_consulta);

    ## Ejecutamos la consulta y verificamos si ocurrió un error
    if (!$consulta->execute()) {
        throw new Exception($consulta->error);
    }

    ## Obtenemos los registros de la consulta previamente ejecutada y creamos los elementos html que tendra la información
    $medicamentos = $consulta->get_result();
    $htmlMedicamentos = [];
    $cont = 0;
    while ($medicamento = $medicamentos->fetch_object()) {
        ++$cont;
        $htmlMedicamento = "<div class='tratamiento'>
                                <div class='tratamiento_numeracion'>
                                    <strong>#{$cont}</strong>
                                </div>
                                <div class='tratamiento_primera_seccion'>
                                    <div class='tratamiento_dato'>
                                        <strong>MEDICAMENTO:</strong>
                                        <span>{$medicamento->nombre_comercial}</span>
                                    </div>
                                    <div class='tratamiento_dato'>
                                        <strong>NOMBRE GENÉRICO:</strong>
                                        <span>{$medicamento->nombre_generico}</span>
                                    </div>
                                    <div class='tratamiento_dato'>
                                        <strong>FORMA FARMACÉUTICA:</strong>
                                        <span>{$medicamento->forma_farmaceutica}</span>
                                    </div>
                                    <div class='tratamiento_dato'>
                                        <strong>DOSIS:</strong>
                                        <span></spanid=>
                                    </div>
                                </div>
                                <div class='tratamiento_segunda_seccion'>
                                    <div class='tratamiento_dato'>
                                        <strong>PRESENTACIÓN:</strong>
                                        <span>{$medicamento->presentacion}</span>
                                    </div>
                                    <div class='tratamiento_dato'>
                                        <strong>FRECUENCIA:</strong>
                                        <span></span>
                                    </div>
                                    <div class='tratamiento_dato'>
                                        <strong>VÍA DE ADMINISTRACIÓN:</strong>
                                        <span>{$medicamento->via_administracion}</span>
                                    </div>
                                    <div class='tratamiento_dato'>
                                        <strong>INDICACIONES DE USO:</strong>
                                        <span>{$medicamento->indicaciones_uso}</span>
                                    </div>
                                </div>
                            </div>";
        array_push($htmlMedicamentos, $htmlMedicamento);
    }
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
    die();
}

echo json_encode(['medicamentos' => $htmlMedicamentos]);
die();
