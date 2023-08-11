const URL_REGISTRAR_REPORTE_CONSULTA_ANTAGONISTAS =
    "consultas/js/files-serverside/insertReporteConsultaAntagonismo.php";

/**
 * Se realiza la petición para registrar un reporte de receta con medicamentos antagonistas
 * @param { number } idConsulta
 * @param { number } idUsuario
 */
const registrarReporteConsultaAntagonismo = async (idConsulta, idUsuario) => {
    const body = new FormData();
    body.append("id_consulta", idConsulta);
    body.append("id_usuario", idUsuario);

    return new Promise(async (resolve, reject) => {
        await fetch(URL_REGISTRAR_REPORTE_CONSULTA_ANTAGONISTAS, {
            method: "POST",
            body,
        })
            .then((response) => resolve(response.json()))
            .catch((error) => reject(error));
    });
};
