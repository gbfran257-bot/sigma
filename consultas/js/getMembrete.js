const URL_GET_MEMBRETE = "consultas/js/files-serverside/getMembrete.php";

/**
 * Se obtiene el encabezado y pie de página que irá en la impresión de la nota o receta médica
 * @param { number } idEstudio 
 * @param { string } tipoMembrete
 */
const getMembrete = async (idEstudio, tipoMembrete) => {
    return await fetch(`${URL_GET_MEMBRETE}?id_e=${idEstudio}&tipo_m=${tipoMembrete}`, {
        method: "GET",
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            throw new Error(data.error);
        }
        return {
            url_encabezado: data.encabezado,
            url_pie_pagina: data.pie_pagina,
        }
    })
    .catch(error => {
        throw error;
    });
};
