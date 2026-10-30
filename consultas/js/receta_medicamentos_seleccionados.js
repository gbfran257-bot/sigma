/**
 * Abre el modal que permite visualizar las sinergias de un medicamento
 * @param { number } idMedicamentoReceta
 */
const visualizarAntagonismos = async (idMedicamentoReceta) => {
    const respuesta = await getIdMedicamentoRecetaSeleccionado(
        idMedicamentoReceta
    );
    if (typeof respuesta === "string") {
        return swal({
            title: "¡Ocurrió un error!",
            text: respuesta,
            icon: "error",
            buttons: false,
            timer: 1800,
        });
    }
    $("#visualizar_medicamento_sinergias").load(
        "consultas/htmls/medicamento_sinergias.php",
        (response, status, xhr) => {
            if (status === "error") {
                return swal({
                    title: "¡Ocurrió un error!",
                    text: `Código de error: ${xhr.status}\nMensaje de error: ${xhr.statusText}`,
                    icon: "error",
                });
            }

            $("#visualizar_medicamento_sinergias").modal("show");
            $("#visualizar_medicamento_sinergias").on(
                "hidden.bs.modal",
                function (e) {
                    $("#visualizar_medicamento_sinergias").modal("hide");
                }
            );
        }
    );

    // Obtenemos las sinergias del medicamento seleccionado
    const sinergias = await getSinergias(respuesta);
    if (sinergias.length === 0) {
        $("#visualizar_medicamento_sinergias").modal("hide");
        return swal({
            title: "¡Hecho!",
            text: "El medicamento seleccionado no tiene sinergias asignadas aún.",
            icon: "warning",
        });
    }
    
    sinergias.forEach((element) => {
        $("#div_sinergias").append(`<p>${element}</p>`);
    });
};

const getIdMedicamentoRecetaSeleccionado = async (idMedicamentoReceta) => {
    const body = new FormData();
    body.append("id_medicamento_receta", idMedicamentoReceta);
    return await fetch(URL_GET_ID_MEDICAMENTO_COMERCIAL_RECETA, {
        method: "POST",
        body,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.ERROR) {
                throw new Error(data.ERROR);
            }
            console.log(data.ID);
            return parseInt(data.ID);
        })
        .catch((error) => error.message);
};

const URL_GET_ID_MEDICAMENTO_COMERCIAL_RECETA =
    "consultas/files-serverside/getIdMedicamentoComercialReceta.php";
