const URL_NUEVO_HISTORIAL = "laboratorio/estudios/files-serverside/historial/nuevoHistorial.php";

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
