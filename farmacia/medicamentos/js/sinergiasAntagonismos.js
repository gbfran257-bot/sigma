const URL_ALL_MEDICAMENTOS_COMERCIALES =
    "farmacia/medicamentos/files-serverside/getAllMedicamentosComerciales.php";

const URL_SINERGIAS_ANTAGONISMOS =
    "farmacia/medicamentos/files-serverside/getSinergiasAntagonismos.php";

const URL_GET_SINERGIAS =
    "farmacia/medicamentos/files-serverside/getSinergias.php";

const URL_GET_ANTAGONISMOS =
    "farmacia/medicamentos/files-serverside/getAntagonismos.php";

const URL_GET_MEDICAMENTO_COMERCIAL_BY_ID =
    "farmacia/medicamentos/files-serverside/getMedicamentoComercialById.php";

/**
 * Obtiene toda la información del medicamento cuyo id sea pasado como parámetro
 * @param { number } idMedicamento
 */
const getMedicamentoComercialById = async (idMedicamento) => {
    const body = new FormData();
    body.append("id_medicamento", idMedicamento);
    return await fetch(URL_GET_MEDICAMENTO_COMERCIAL_BY_ID, {
        method: "POST",
        body,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.ERROR) {
                throw new Error(data.ERROR);
            }
            return data;
        })
        .catch((error) =>
            swal({
                title: "Ocurrió un error",
                text: error,
                type: "error",
            })
        );
};

/**
 * Obtiene los medicamentos sinergicos del medicamento cuyo id sea pasado como parámetro
 * @param { number } idMedicamento
 */
const getSinergias = async (idMedicamento) => {
    const body = new FormData();
    body.append("id_medicamento", idMedicamento);
    return await fetch(URL_GET_SINERGIAS, {
        method: "POST",
        body,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.ERROR) {
                throw new Error(data.ERROR);
            }
            return data;
        })
        .catch((error) =>
            swal({
                title: "Ocurrió un error",
                text: error.message,
                icon: "error",
            })
        );
};

/**
 * Obtiene los medicamento antagónicos del medicamento cuyo id sea pasado como parámetro
 * @param { number } idMedicamento
 */
const getAntagonismos = async (idMedicamento) => {
    const body = new FormData();
    body.append("id_medicamento", idMedicamento);
    return await fetch(URL_GET_ANTAGONISMOS, {
        method: "POST",
        body,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.ERROR) {
                throw new Error(data.ERROR);
            }
            return data;
        })
        .catch((error) =>
            swal({
                title: "Ocurrió un error",
                text: error,
                type: "error",
            })
        );
};

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
