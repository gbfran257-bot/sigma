/**
 *
 * @param { HTMLSelectElement } selectFactor
 */
const factorChangeHandler = (selectFactor) => {
    limpiarSelects("select_tasa_cuota");
    const selectTasaCuota = $("#select_tasa_cuota");
    selectTasaCuota.show();

    const selectTipoValor = $("#select_tipo").val();
    const selectImpuestoValor = $("#select_impuesto").val();

    // Caso 1 -> traslado - iva - excento
    if (selectTipoValor === "traslado" && selectImpuestoValor === "iva" && selectFactor.value === "excento") {
        selectTasaCuota.hide();
    }

    // Caso 2 -> traslado - ieps - tasa / retencion - ieps - tasa
    if ((selectTipoValor === "traslado" && selectImpuestoValor === "ieps" && selectFactor.value === "tasa") || (selectTipoValor === "retencion" && selectImpuestoValor === "ieps" && selectFactor.value === "tasa")) {
        selectTasaCuota.append('<option value="26.50">26.50%</option>');
        selectTasaCuota.append('<option value="30.00">30.00%</option>');
        selectTasaCuota.append('<option value="50.00">50.00%</option>');
        selectTasaCuota.append('<option value="53.00">53.00%</option>');
        selectTasaCuota.append('<option value="160.50">160.50%</option>');
        selectTasaCuota.append('<option value="30.40">30.40%</option>');
        selectTasaCuota.append('<option value="25.00">25.00%</option>');
    }

    // Caso 3 -> retencion - ieps - cuota / retencion - isr - tasa / retencion - isr - cuota / traslado - ieps - cuota
    if ((selectTipoValor === "retencion" && selectImpuestoValor === "ieps" && selectFactor.value === "cuota") || (selectTipoValor === "retencion" && selectImpuestoValor === "isr" && selectFactor.value === "tasa") || (selectTipoValor === "retencion" && selectImpuestoValor === "isr" && selectFactor.value === "cuota") || (selectTipoValor === "traslado" && selectImpuestoValor === "ieps" && selectFactor.value === "cuota")) {
        selectTasaCuota.append('<option value="otro">Otro</option>');
    }
    
    // Caso 4 -> retencion - iva - excento / retencion - ieps - excento / traslado - ieps - excento
    if ((selectTipoValor === "retencion" && selectImpuestoValor === "iva" && selectFactor.value === "excento") || (selectTipoValor === "retencion" && selectImpuestoValor === "ieps" && selectFactor.value === "excento") || (selectTipoValor === "traslado" && selectImpuestoValor === "ieps" && selectFactor.value === "excento")) {
        selectTasaCuota.append('<option value="0.00">0.00 %</option>');
    }

    // Caso 4.1 -> retencion - isr - excento
    if (selectTipoValor === "retencion" && selectImpuestoValor === "isr" && selectFactor.value === "excento") {
        selectTasaCuota.append('<option value="0.00">0.00%</option>');
        selectTasaCuota.append('<option value="otro">Otro</option>');
    }

    // Caso 5 -> traslado - iva - tasa
    if (selectTipoValor === "traslado" && selectImpuestoValor === "iva" && selectFactor.value === "tasa") {
        selectTasaCuota.append('<option value="0.00">0.00%</option>');
        selectTasaCuota.append('<option value="8.00">8.00%</option>');
        selectTasaCuota.append('<option value="16.00">16.00%</option>');
    }

    // Caso 5.1 -> retencion - iva - tasa
    if (selectTipoValor === "retencion" && selectImpuestoValor === "iva" && selectFactor.value === "tasa") {
        selectTasaCuota.append('<option value="0.00">0.00%</option>');
        selectTasaCuota.append('<option value="8.00">8.00%</option>');
        selectTasaCuota.append('<option value="16.00">16.00%</option>');
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

    if (selectImpuesto.value === "iva") {
        selectFactor.append("<option value='tasa'>Tasa</option>");
        selectFactor.append("<option value='excento'>Excento</option>");
        return;
    }
    if (selectImpuesto.value === "ieps" || selectImpuesto.value === "isr") {
        selectFactor.append("<option value='tasa'>Tasa</option>");
        selectFactor.append("<option value='cuota'>Cuota</option>");
        selectFactor.append("<option value='excento'>Excento</option>");
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

    if (selectTipo.value === "retencion") {
        selectImpuesto.append(`<option value="iva">IVA</option>`);
        selectImpuesto.append(`<option value="ieps">IEPS</option>`);
        selectImpuesto.append(`<option value="isr">ISR</option>`);
        return;
    }

    if (selectTipo.value === "traslado") {
        selectImpuesto.append(`<option value="iva">IVA</option>`);
        selectImpuesto.append(`<option value="ieps">IEPS</option>`);
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
