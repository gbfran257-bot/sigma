const URL_GET_USO_CFDI = "pacientes/files-serverside/getUsoCFDI.php";

const getUsoCFDI = async () => {
    const usos = await fetch(URL_GET_USO_CFDI, {
        method: "GET",
    })
    .then(response => response.json())
    .then(respuesta => {
        if (respuesta.error) {
            throw new Error(respuesta.error);
        }
        return respuesta.usos;
    })
    .catch(error => {
        throw error;
    });

    usos.forEach(regimen => $("#uso_cfdi").append(`<option value="${regimen.clave}">${regimen.descripcion}</option>`));
};