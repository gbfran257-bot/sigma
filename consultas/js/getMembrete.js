const URL_GET_MEMBRETE = "consultas/js/files-serverside/getMembrete.php?id_e=";

/**
 * Se obtiene el encabezado y pie de página que irá en la impresión de la nota o receta médica
 * @param { number } idEstudio 
 */
const getMembrete = async (idEstudio) => {
    return await fetch(URL_GET_MEMBRETE + idEstudio, {
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
