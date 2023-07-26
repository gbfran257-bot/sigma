/**
 *
 * @param { HTMLSelectElement } selectFactor
 */
const factorChangeHandler = (selectFactor) => {
    limpiarSelects("select_tasa_cuota");
    const selectTasaCuota = $("#select_tasa_cuota");
    selectTasaCuota.show();
    selectTasaCuota.attr("required", true);

    const selectTipoValor = $("#select_tipo").val();
    const selectImpuestoValor = $("#select_impuesto").val();

    // Caso 1 -> traslado - iva - exento
    if (
        selectTipoValor === "1" &&
        selectImpuestoValor === "1" &&
        selectFactor.value === "3"
    ) {
        selectTasaCuota.hide();
        selectTasaCuota.attr("required", false);
    }

    // Caso 2 -> traslado - ieps - tasa / retencion - ieps - tasa
    if (
        (selectTipoValor === "1" &&
            selectImpuestoValor === "2" &&
            selectFactor.value === "1") ||
        (selectTipoValor === "2" &&
            selectImpuestoValor === "2" &&
            selectFactor.value === "1")
    ) {
        selectTasaCuota.append('<option value="2">0.06%</option>');
        selectTasaCuota.append('<option value="3">0.07%</option>');
        selectTasaCuota.append('<option value="4">0.08%</option>');
        selectTasaCuota.append('<option value="5">0.09%</option>');
        selectTasaCuota.append('<option value="6">0.25%</option>');
        selectTasaCuota.append('<option value="7">0.265%</option>');
        selectTasaCuota.append('<option value="8">0.3%</option>');
        selectTasaCuota.append('<option value="9">0.304%</option>');
        selectTasaCuota.append('<option value="10">0.5%</option>');
        selectTasaCuota.append('<option value="11">0.53%</option>');
        selectTasaCuota.append('<option value="12">1.6%</option>');
    }

    // Caso 3 -> retencion - ieps - cuota / retencion - isr - tasa / retencion - isr - cuota / traslado - ieps - cuota
    if (
        (selectTipoValor === "2" &&
            selectImpuestoValor === "2" &&
            selectFactor.value === "2") ||
        (selectTipoValor === "2" &&
            selectImpuestoValor === "3" &&
            selectFactor.value === "1") ||
        (selectTipoValor === "2" &&
            selectImpuestoValor === "3" &&
            selectFactor.value === "2") ||
        (selectTipoValor === "1" &&
            selectImpuestoValor === "2" &&
            selectFactor.value === "2")
    ) {
        selectTasaCuota.append('<option value="otro">Otro</option>');
    }

    // Caso 4 -> retencion - iva - exento / retencion - ieps - exento / traslado - ieps - exento
    if (
        (selectTipoValor === "2" &&
            selectImpuestoValor === "1" &&
            selectFactor.value === "3") ||
        (selectTipoValor === "2" &&
            selectImpuestoValor === "2" &&
            selectFactor.value === "3") ||
        (selectTipoValor === "1" &&
            selectImpuestoValor === "2" &&
            selectFactor.value === "3")
    ) {
        selectTasaCuota.append('<option value="1">0.00 %</option>');
    }

    // Caso 4.1 -> retencion - isr - exento
    if (
        selectTipoValor === "2" &&
        selectImpuestoValor === "3" &&
        selectFactor.value === "3"
    ) {
        selectTasaCuota.append('<option value="1">0.00%</option>');
        selectTasaCuota.append('<option value="otro">Otro</option>');
    }

    // Caso 5 -> traslado - iva - tasa
    if (
        selectTipoValor === "1" &&
        selectImpuestoValor === "1" &&
        selectFactor.value === "1"
    ) {
        selectTasaCuota.append('<option value="1">0.00%</option>');
        selectTasaCuota.append('<option value="13">8.00%</option>');
        selectTasaCuota.append('<option value="14">16.00%</option>');
    }

    // Caso 5.1 -> retencion - iva - tasa
    if (
        selectTipoValor === "2" &&
        selectImpuestoValor === "1" &&
        selectFactor.value === "1"
    ) {
        selectTasaCuota.append('<option value="1">0.00%</option>');
        selectTasaCuota.append('<option value="13">8.00%</option>');
        selectTasaCuota.append('<option value="14">16.00%</option>');
        selectTasaCuota.append('<option value="otro">Otro</option>');
    }
};

/**
 * Función que maneja los factores que serán mostrados en el select de factor según el valor del impuesto
 * @param { HTMLSelectElement } selectImpuesto
 */
const impuestoChangeHandler = (selectImpuesto) => {
    limpiarSelects("select_factor", "select_tasa_cuota");
    const selectFactor = $("#select_factor");

    if (selectImpuesto.value === "1") {
        selectFactor.append("<option value='1'>Tasa</option>");
        selectFactor.append("<option value='3'>Excento</option>");
        return;
    }
    if (selectImpuesto.value === "2" || selectImpuesto.value === "3") {
        selectFactor.append("<option value='1'>Tasa</option>");
        selectFactor.append("<option value='2'>Cuota</option>");
        selectFactor.append("<option value='3'>Exento</option>");
        return;
    }
};

/**
 * Función que maneja los impuestos que serán mostrados en el select de impuesto según el valor del tipo
 * @param { HTMLSelectElement } selectTipo
 */
const tipoChangeHandler = (selectTipo) => {
    limpiarSelects("select_impuesto", "select_factor", "select_tasa_cuota");
    const selectImpuesto = $("#select_impuesto");

    if (selectTipo.value === "2") {
        selectImpuesto.append(`<option value="1">IVA</option>`);
        selectImpuesto.append(`<option value="2">IEPS</option>`);
        selectImpuesto.append(`<option value="3">ISR</option>`);
        return;
    }

    if (selectTipo.value === "1") {
        selectImpuesto.append(`<option value="1">IVA</option>`);
        selectImpuesto.append(`<option value="2">IEPS</option>`);
        return;
    }
};

/**
 *
 * @param  {...string} ids
 */
const limpiarSelects = (...ids) => {
    ids.forEach((id) => {
        $(`#${id}`).empty();
        $(`#${id}`).append("<option selected></option>");
    });
    $("#monto_impuesto").hide();
    $("#monto_impuesto").val(0);
};

/**
 *
 * @param { HTMLSelectElement } selectTasaCuota
 */
const mostrarOcultarInputOtro = (selectTasaCuota) => {
    if (selectTasaCuota.value === "otro") {
        $("#monto_impuesto").show();
    } else {
        $("#monto_impuesto").hide();
        $("#monto_impuesto").val(0);
    }
};
