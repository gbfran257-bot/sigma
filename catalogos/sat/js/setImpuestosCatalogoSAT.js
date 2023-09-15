/**
 * Función que asigna la información del impuesto al select del catálogo
 * @param { HTMLElement } divImpuestoExtra
 * @param { Object } impuestoExtra
 */
const setImpuestosCatalogoSAT = (divImpuestoExtra, impuestoExtra) => {
    // Asignamos a los select, los valores dependiendo el impuesto de la base de datos
    setTipo(divImpuestoExtra.querySelector('#select_tipo'), impuestoExtra.id_tipo);
    setImpuesto(divImpuestoExtra.querySelector('#select_impuesto'), impuestoExtra.id_impuesto);
    setFactor(divImpuestoExtra.querySelector('#select_factor'), impuestoExtra.id_factor);
    setTasaCuota(divImpuestoExtra.querySelector('#select_tasa_cuota'), divImpuestoExtra.querySelector('#monto_impuesto'), impuestoExtra.id_impuesto_fijo, impuestoExtra.impuesto_libre);
};

/**
 * @param { HTMLSelectElement } selectTipo
 * @param { string } id_tipo
 */
const setTipo = (selectTipo, id_tipo) => {
    tipoChangeHandler(selectTipo, id_tipo);
    selectTipo.value = parseInt(id_tipo);
};

/**
 * @param { HTMLSelectElement } selectImpuesto
 * @param { string } id_impuesto
 */
const setImpuesto = (selectImpuesto, id_impuesto) => {
    impuestoChangeHandler(selectImpuesto, id_impuesto);
    selectImpuesto.value = parseInt(id_impuesto);
};

/**
 * @param { HTMLSelectElement } selectFactor
 * @param { string } id_factor
 */
const setFactor = (selectFactor, id_factor) => {
    factorChangeHandler(selectFactor, id_factor);
    selectFactor.value = parseInt(id_factor);
};

/**
 * @param { HTMLSelectElement } selectTasaCuota
 * @param { HTMLInputElement } inputMonto
 * @param { string | null } impuestoLibre
 * @param { string | null } porcentaje
 */
const setTasaCuota = (selectTasaCuota, inputMonto, id_impuesto_fijo, impuestoLibre) => {
    if (impuestoLibre !== null) {
        selectTasaCuota.value = "otro";
        inputMonto.value = parseFloat(impuestoLibre);
        inputMonto.style.display = "";
        return;
    }
    if (id_impuesto_fijo !== null) {
        selectTasaCuota.value = parseInt(id_impuesto_fijo);
        return;
    }
};
