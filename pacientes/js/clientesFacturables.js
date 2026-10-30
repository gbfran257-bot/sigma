const URL_AGREGAR_CLIENTE_FACTURABLE = "pacientes/files-serverside/agregarClienteFacturable.php";
const URL_GET_CLIENTES_FACTURABLES_PACIENTE = "pacientes/files-serverside/getClientesFacturablesPacientes.php";
const URL_ELIMINAR_CLIENTE_FACTURABLE = "pacientes/files-serverside/eliminarClienteFacturable.php";
const URL_VERIFICAR_DATOS_FISCALES_PACIENTE_FACTURABLE = "pacientes/files-serverside/verificarDatosFiscalesPacienteFacturable.php?id_paciente=";

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
    
    if (pacientes.length == 0) {
        return $("#table_body_adicionales").append(`
            <tr id="tr_sin_clientes_facturables">
                <td colspan="6" class="text-center" style="vertical-align: middle;">Aún no hay clientes facturables seleccionados</td>
            </tr>
        `);
    }

    $("#tr_sin_clientes_facturables").remove();
    pacientes.forEach((paciente, index) => {
        $("#table_body_adicionales").append(`
            <tr>
                <td id_p=${paciente.id_p} class="text-center cliente_facturable_ya_seleccionado" colspan="1" style="vertical-align: middle;">${++index}</td>
                <td class="text-center" colspan="4" style="vertical-align: middle;">${paciente.nombre_completo_p}</td>
                <td class="text-center" colspan="1" style="vertical-align: middle;">
                    <button class="btn btn-danger" type="button" style="padding: 0.5rem;">Eliminar</button>
                </td>
            </tr>
        `)

        $($($("#table_body_adicionales tr").last()).children("td").last()).children("button").click((e) => {
            eliminarClienteFacturable(parseInt(paciente.id_p));
            
            // Eliminamos el html del cliente facturable recién eliminado
            $(e.target).parent().parent().remove();
            
            // Si ya no hay clientes facturables seleccionados entonces muestra el mensaje por defecto
            if ($("#table_body_adicionales tr").length == 0) {
                return $("#table_body_adicionales").append(`
                    <tr id="tr_sin_clientes_facturables">
                        <td colspan="6" class="text-center" style="vertical-align: middle;">Aún no hay clientes facturables seleccionados</td>
                    </tr>
                `);
            }

            // Actualizamos el numeral de los clientes facturables seleccionados
            $("#table_body_adicionales tr").each((index, element) => {
                $($(element).children("td")[0]).text(++index);
            });
        });
    });
};

/**
 * @param { number } idClienteFacturable
 */
const eliminarClienteFacturable = async (idClienteFacturable) => {
    const idPaciente = parseInt($("#id_paciente_v").val());

    const body = new FormData();
    body.append("id_paciente", idPaciente);
    body.append("id_cliente_facturable", idClienteFacturable);

    await fetch(URL_ELIMINAR_CLIENTE_FACTURABLE, {
        method: "POST",
        body
    })
    .then(response => response.text())
    .then(respuesta => {
        if (respuesta.includes("Error:")) {
            throw new Error(respuesta);
        }
        swal({
            type: "success",
            title: "HECHO",
            text: respuesta,
            timer: 1800,
            showConfirmButton: false
        });
    })
    .catch(error => {
        swal({
            type: "error",
            title: "ERROR",
            text: error.message,
            timer: 1800,
            showConfirmButton: false
        });
    });
};

/**
 * @param { number } idPaciente
 */
const verificarDatosFiscalesPacienteFacturable = async (idPaciente) => {
    if (!$("#facturar").is(":checked")) {
        return;
    }

    return await fetch(URL_VERIFICAR_DATOS_FISCALES_PACIENTE_FACTURABLE + idPaciente, {
        method: "GET"
    })
    .then(response => response.text())
    .then(respuesta => {
        if (respuesta.includes("ERROR:")) {
            throw new Error(respuesta);
        }
        return swal({
            type: "success",
            title: "HECHO",
            text: respuesta,
            showConfirmButton: false,
            timer: 1800
        });
    })
    .catch(error => {
        throw error;
    });
};
