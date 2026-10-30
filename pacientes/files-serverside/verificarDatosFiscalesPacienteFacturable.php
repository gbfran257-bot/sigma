<?php

function infoFiscalIncompleta($paciente)
{
    return
        $paciente->razon_social_p == "" || 
        $paciente->rfc_f_p == "" || 
        $paciente->email_pf == "" || 
        $paciente->uso_cfdi == "" || 
        $paciente->regimen_fiscal == "" || 
        $paciente->entidadFederativa_pf == "" || 
        $paciente->municipio_pf == "" || 
        $paciente->ciudad_pf == "" || 
        $paciente->colonia_pf == "" || 
        $paciente->calle_pf == "" || 
        $paciente->cp_pf == "";
}

if (empty($_GET) || empty($_GET['id_paciente'])) {
    echo "ERROR: Ocurrió un error con la petición.";
    die();
}

try {
    require_once("../../Connections/horizonte2.php");

    $id_paciente = intval(htmlspecialchars($_GET['id_paciente'], ENT_QUOTES, "utf-8", true));

    $sql = "SELECT * FROM pacientes WHERE id_p = ?";
    $consulta = $horizonte->prepare($sql);
    $consulta->bind_param("i", $id_paciente);

    if (!$consulta->execute()) {
        throw new Exception($consulta->error);
    }

    $paciente = $consulta->get_result()->fetch_object();

    if (infoFiscalIncompleta($paciente)) {
        throw new Exception("Completar datos fiscales primero.");
    }

} catch (\Exception $ex) {
    echo "ERROR: {$ex->getMessage()}";
    die();
}

$horizonte->close();

echo "Paciente marcado correctamente.";
die();
