const URL_NUEVO_HISTORIAL = "historial/files-serverside/nuevoHistorial.php";
const URL_GET_INFO_HISTORIAL = "historial/files-serverside/getInfoHistorial.php?";

/**
 * Creamos un historial para cada estudio creado en una orden de venta
 * @param { string } id_temporal_estudios
 * @param { number } tipo_estudio laboratorio: 3, imagen: 4
 */
const nuevoHistorial = async (id_temporal_estudios, tipo_estudio) => {
    const body = new FormData();
    body.append("id_temporal_estudios", id_temporal_estudios);
    body.append("tipo_estudio", tipo_estudio);
    await fetch(URL_NUEVO_HISTORIAL, {
        method: "POST",
        body
    })
    .then(response => response.json())
    .then(respuesta => {
        if (respuesta.error) {
            throw new Error(respuesta.error);
        }
    })
    .catch(error => {
        throw error;
    });
};

/**
 * Obtiene la información del registro de historial de un estudio
 * @param { number } idEstudio
 * @param { number } estatus pendiete: 1, proceso: 2, capturado: 3, autorizado: 4, finalizado: 5
 */
const getInfoHistorial = async (idEstudio, estatus) => {
    return await fetch(`${URL_GET_INFO_HISTORIAL}ide=${idEstudio}&te=${estatus}`, {
        method: "GET",
    })
    .then(response => response.json())
    .catch(error => {
        throw error;
    });
};
