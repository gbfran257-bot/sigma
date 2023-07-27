/**
 * Función que asigna la información del impuesto al select del catálogo
 * @param { Object } impuesto
 */
const setImpuestosCatalogoSAT = (impuesto) => {
    console.log(impuesto);

    // Asignamos los valores de la primera fila
    $("#clave").val(impuesto.clave_sat);
    $("#descripcion").val(impuesto.descripcion_sat);

    // Asignamos a los select, los valores dependiendo el impuesto de la base de datos
    setTipo(impuesto.id_tipo);
    setImpuesto(impuesto.id_impuesto);
    setFactor(impuesto.id_factor);
    setTasaCuota(impuesto.id_impuesto_fijo, impuesto.impuesto_libre);
};

/**
 * @param { string } id_tipo
 */
const setTipo = (id_tipo) => {
    tipoChangeHandler(id_tipo);
    $("#select_tipo").val(parseInt(id_tipo));
};

/**
 * @param { string } id_impuesto
 */
const setImpuesto = (id_impuesto) => {
    impuestoChangeHandler(id_impuesto);
    $("#select_impuesto").val(parseInt(id_impuesto));
};

/**
 * @param { string } id_factor
 */
const setFactor = (id_factor) => {
    factorChangeHandler(id_factor);
    $("#select_factor").val(parseInt(id_factor));
};

/**
 * @param { string | null } impuestoLibre
 * @param { string | null } porcentaje
 */
const setTasaCuota = (id_impuesto_fijo, impuestoLibre) => {
    if (impuestoLibre !== null) {
        $("#select_tasa_cuota").val("otro");
        $("#monto_impuesto").val(parseFloat(impuestoLibre));
        $("#monto_impuesto").show();
        return;
    }
    if (id_impuesto_fijo !== null) {
        $("#select_tasa_cuota").val(parseInt(id_impuesto_fijo));
        return;
    }
};
