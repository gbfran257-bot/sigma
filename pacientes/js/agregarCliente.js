const URL_AGREGAR_CLIENTE_FACTURABLE = "pacientes/files-serverside/agregarClienteFacturable.php";
const URL_GET_CLIENTES_FACTURABLES_PACIENTE = "pacientes/files-serverside/getClientesFacturablesPacientes.php";

const agregarCliente = async () => {
    const idsPacientesFacturables = $("#body-nuevo-cliente .cliente")
    .filter((index, element) => $(element).is(":checked"))
    .map((index, element) => {
        return $(element).val();
    });

    const body = new FormData();
    body.append("id_paciente", $("#id_paciente_v").val());
    body.append("id_pacientes_facturables", JSON.stringify(idsPacientesFacturables.toArray()));
    
    return await fetch(URL_AGREGAR_CLIENTE_FACTURABLE, {
        method: "POST",
        body
    })
    .then(response => response.json())
    .then(respuesta => {
        if (respuesta.error) {
            throw new Error(respuesta.error);
        }
        return respuesta.exito;
    })
    .catch(error => {
        throw error;
    });
};

const verificarClientesSeleccionados = () => {
    if ($("#body-nuevo-cliente .cliente").filter((index, element) => $(element).is(":checked")).length !== 0) {
        $("#agregar-nuevo-cliente").removeAttr("disabled");
    } else {
        $("#agregar-nuevo-cliente").attr("disabled", true);
    }
};

/**
 * @param { number } idPaciente 
 */
const getClientesFacturablesPaciente = async (idPaciente) => {
    const body = new FormData();
    body.append("id_paciente", idPaciente);

    const pacientes = await fetch(URL_GET_CLIENTES_FACTURABLES_PACIENTE, {
        method: "POST",
        body
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
    
    pacientes.forEach((paciente, index) => $("#table_body_adicionales").append(`
        <tr>
            <td id_p=${paciente.id_p} class="text-center cliente_facturable_ya_seleccionado" colspan="1" style="vertical-align: middle;">${++index}</td>
            <td class="text-center" colspan="4" style="vertical-align: middle;">${paciente.nombre_completo_p}</td>
            <td class="text-center" colspan="1" style="vertical-align: middle;">
                <button class="btn btn-danger" type="button" id="eliminarClienteFacturable" style="padding: 0.5rem;" onclick="eliminarClienteFacturable(${paciente.id_p})">Eliminar</button>
            </td>
        </tr>
    `));
};
