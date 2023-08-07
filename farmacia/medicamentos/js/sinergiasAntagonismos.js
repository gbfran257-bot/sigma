const URL_ALL_MEDICAMENTOS_COMERCIALES =
    "farmacia/medicamentos/files-serverside/getAllMedicamentosComerciales.php";

const URL_SINERGIAS_ANTAGONISMOS =
    "farmacia/medicamentos/files-serverside/getSinergiasAntagonismos.php";

/**
 * Obtiene todos los medicamentos genéricos sin filtros
 */
const getAllMedicamentosComerciales = async () => {
    return await fetch(URL_ALL_MEDICAMENTOS_COMERCIALES, {
        method: "GET",
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.ERROR) {
                throw new Error(data.ERROR);
            }
            return data.medicamentos;
        })
        .catch((error) => {
            swal({
                title: "Ocurrió un error",
                text: error,
                type: "error",
            });
        });
};

/**
 * Obtiene todos los medicamentos genéricos sin filtros
 */
const getSinergiasAntagonismos = async (idMedicamento) => {
    return await fetch(
        `${URL_SINERGIAS_ANTAGONISMOS}?id_medicamento=${idMedicamento}`,
        {
            method: "GET",
        }
    )
        .then((response) => response.json())
        .then((data) => {
            if (data.ERROR) {
                throw new Error(data.ERROR);
            }
            return data;
        })
        .catch((error) => {
            swal({
                title: "Ocurrió un error",
                text: error,
                type: "error",
            });
        });
};

/**
 * Asigna los elementos option a los select de sinergias y de antagonismos
 */
const cargarAllSinergiasAntagonismos = async () => {
    const medicamentos = await getAllMedicamentosComerciales().then(
        (data) => data
    );
    if (medicamentos !== undefined) {
        const selectSinergias = $("#sinergias");
        const selectAntagonismos = $("#antagonismos");
        medicamentos.forEach((medicamento) => {
            selectSinergias.append(
                `<option class='sinergia' value=${medicamento.id_concepto_medicamento}>${medicamento.concepto_medicamento}</option>`
            );
            selectAntagonismos.append(
                `<option class='antagonismo' value=${medicamento.id_concepto_medicamento}>${medicamento.concepto_medicamento}</option>`
            );
        });
    }
};

/**
 * Asigna los elementos option a los select de sinergias y antagonismos correspondientes a un medicamento
 * @param { number } idMedicamento
 */
const cargarMedicamentosSinergiasAntagonismos = async (idMedicamento) => {
    const resultados = await getSinergiasAntagonismos(idMedicamento).then(
        (data) => data
    );
    $(".mensaje_select_multiple").hide();

    $("#sinergias").attr("disabled", true);
    $("#sinergias").attr("required", false);
    $("#buscar_sinergia").hide();
    resultados.sinergias.forEach((sinergia) => {
        $("#sinergias").append(`<option disabed>${sinergia}</option>`);
    });

    $("#antagonismos").attr("disabled", true);
    $("#antagonismos").attr("required", false);
    $("#buscar_antagonismo").hide();
    resultados.antagonismos.forEach((antagonismo) => {
        $("#antagonismos").append(`<option disabed>${antagonismo}</option>`);
    });
};
