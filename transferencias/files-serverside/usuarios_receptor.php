<?php

try {
    require("../../Connections/horizonte2.php");

    $query_usuarios = "";

    // Comprobamos si se quiere filtrar por nombre del usuario
    if (isset($_GET['term']) && !empty($_GET['term'])) {
        $usuario_u = "%" . htmlentities($_GET['term'], ENT_QUOTES, "utf-8") . "%";
        $query_usuarios = "SELECT id_u AS id, usuario_u AS usuario FROM usuarios WHERE usuario_u LIKE \"{$usuario_u}\"";
    } else {
        $query_usuarios = "SELECT id_u AS id, usuario_u AS usuario FROM usuarios";
    }
    
    $resultado_query_usuarios = mysqli_query($horizonte, $query_usuarios);

    $usuarios = [];
    $usuarios["results"] = [];
    while ($resultado_usuario = mysqli_fetch_assoc($resultado_query_usuarios)) {
        $usuario = ["id" => $resultado_usuario['id'], "text" => $resultado_usuario['usuario']];
        $usuarios['results'][] = $usuario;
    }

    echo json_encode($usuarios);
} catch (\Exception $ex) {
    echo json_encode(['error' => $ex->getMessage()]);
}

die();
