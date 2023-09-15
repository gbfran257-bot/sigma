/**
 * Se obtienen los medicamentos seleccionados para la receta y se agregan a la receta
 * @param { number } idC 
 */
const agregarMedicamentos = async idC => {
    const medicamentosSeleccionados = await getMedicamentosSeleccionadosReceta(idC).catch(error => {
        throw error;
    });
    
    // Limpiamos la seccion de tratamientos para insertar los nuevos tratamientos
    $(".tratamiento").remove();

    // Agregamos los tratamientos a la receta
    medicamentosSeleccionados.forEach((htmlMedicamento) => {
        $("#receta_tratamiento").append(htmlMedicamento);
    });
};

/**
 * Se obtienen los medicamentos seleccionados para la receta
 * @param { number } idC 
 */
const getMedicamentosSeleccionadosReceta = async idC => {
    return await fetch(URL_GET_MEDICAMENTOS_SELECCIONADOS_RECETA + idC, {
        method: "GET",
    })
    .then(response => response.json())
    .then(respuesta => {
        if (respuesta.error) {
            throw new Error(respuesta.error);
        }
        return respuesta.medicamentos;
    })
    .catch(error => {
        throw error;
    });
};

const URL_GET_MEDICAMENTOS_SELECCIONADOS_RECETA = "consultas/js/files-serverside/getMedicamentosSeleccionadosReceta.php?id_c=";
