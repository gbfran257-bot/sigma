/**
 * Devuelve false si alguno de los campos de impuestos extra es inválido
 * @param { HTMLElement[] } impuestosExtra
 * @return { boolean | Object }
 */
const verificarImpuestos = (impuestosExtra) => {
    const impuestos = [];
    for (const impuestoExtra of impuestosExtra) {
        const impuesto = verificarImpuesto(impuestoExtra);
        if (!impuesto) {
            return false;
        }
        impuestos.push(impuesto);
    }
    return impuestos;
};

/**
 * Devuelve false si alguno de los campos de un impuesto extra es inválido
 * @param { HTMLElement} impuestoActual
 * @return { boolean | Object }
 */
const verificarImpuesto = (impuestoActual) => {
    const tipo = impuestoActual.querySelector("#select_tipo").value;
    const impuesto = impuestoActual.querySelector("#select_impuesto").value;
    const factor = impuestoActual.querySelector("#select_factor").value;
    const porcentajeFijo = impuestoActual.querySelector("#select_tasa_cuota").value;
    const porcentajeLibre = impuestoActual.querySelector('#monto_impuesto').value;
    if ((impuesto === '1' && factor === '3') || (porcentajeFijo !== '' && porcentajeFijo !== 'otro') || (porcentajeFijo === 'otro' && porcentajeLibre != 0)) {
        return {
            tipo, impuesto, factor, porcentajeFijo, porcentajeLibre
        };
    }
    return false;
};
