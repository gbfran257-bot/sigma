const URL_GET_REGIMENES_FISCALES = "pacientes/files-serverside/getRegimenesFiscales.php";

const getRegimenesFiscales = async () => {
    const regimenes = await fetch(URL_GET_REGIMENES_FISCALES, {
        method: "GET",
    })
    .then(response => response.json())
    .then(respuesta => {
        if (respuesta.error) {
            throw new Error(respuesta.error);
        }
        return respuesta.regimenes;
    })
    .catch(error => {
        throw error;
    });

    regimenes.forEach(regimen => $("#regimen_fiscal").append(`<option value="${regimen.clave_reg}">${regimen.descripcion_reg}</option>`));
};