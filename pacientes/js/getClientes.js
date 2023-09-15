const URL_GET_CLIENTES = "pacientes/files-serverside/getClientes.php?";

/**
 * @param { number } idPaciente
 */
const getClientes = async (idPaciente) => {
    const clienteSeleccionados = JSON.stringify(
        $(".cliente_facturable_ya_seleccionado")
            .map((index, element) => {
                return $(element).attr("id_p");
            })
            .toArray()
    );

    const clientes = await fetch(`${URL_GET_CLIENTES}id_paciente=${idPaciente}&clientes_seleccionados=${clienteSeleccionados}`, {
        method: "GET",
    })
    .then(response => response.json())
    .then(respuesta => {
        if (respuesta.error) {
            throw new Error(respuesta.error);
        }
        return respuesta.clientes;
    })
    .catch(error => {
        throw error;
    });
    
    clientes.forEach(cliente => $("#body-nuevo-cliente").append(`
        <div style="display: flex; align-items: center;">
            <input class="cliente" style="margin: 0px 0.5rem 0px 0px;" type="checkbox" id="${cliente.id_p}" value="${cliente.id_p}"/>
            <label style="margin: 0px 0.5rem 0px 0px;" for="${cliente.id_p}">${cliente.nombre_completo_p}</label>
        </div>
    `));
};
