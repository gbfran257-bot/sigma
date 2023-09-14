const URL_GET_ADICIONALES = "pacientes/files-serverside/getAdicionales.php";

const getAdicionales = async () => {
    const adicionales = await fetch(URL_GET_ADICIONALES, {
        method: "GET",
    })
    .then(response => response.json())
    .then(respuesta => {
        if (respuesta.error) {
            throw new Error(respuesta.error);
        }
        return respuesta.adicionales;
    })
    .catch(error => {
        throw error;
    });

    console.log(adicionales);
    /* regimenes.forEach(regimen => $("#regimen_fiscal").append(`<option value="${regimen.clave_reg}">${regimen.descripcion_reg}</option>`)); */
};