const handlerDescuentoDirectoServicios = (inputDescuentoDirecto) => {
    // Si el precio de los servicios es 0 no se puede aplicar nigún descuento
    if ($("#precio_s").val() == 0) {
        inputDescuentoDirecto.value = "";
        return;
    }

    // Si el input de descuento directo es 0 entonces eliminamos el descuento y limpiamos el input del motivo del descuento
    if (inputDescuentoDirecto.value == 0) {
        return eliminarDescuento("servicios", "directo");
    }

    // Caso 1: La tabla de descuentos está vacía
    if (tablaResumenVacia("servicios")) {
        return insertarDescuentoUnico("servicios", "directo", {
            texto: "Descuento directo aplicado",
            concepto: $("#motivo_descuento_s").val(),
            monto: inputDescuentoDirecto.value,
        });
    }

    // Caso 2: La tabla tiene un registro de descuento directo
    if (hayDescuento("servicios", "directo")) {
        return actualizarDescuentoUnico("servicios", "directo", {
            concepto: $("#motivo_descuento_s").val(),
            monto: inputDescuentoDirecto.value,
        });
    }

    return;
};

const handlerDescuentoPorcentajeServicios = (inputDescuentoPorcentaje) => {
    // Si el precio de los servicios es 0 no se puede aplicar nigún descuento
    if ($("#precio_s").val() == 0) {
        inputDescuentoPorcentaje.value = "";
        return;
    }

    // Si el input de descuento por porcentaje es 0 entonces eliminamos el descuento y limpiamos el input del motivo del descuento
    if (inputDescuentoPorcentaje.value == 0) {
        return eliminarDescuento("servicios", "porcentaje");
    }

    // Caso 1: La tabla de descuentos está vacía
    if (tablaResumenVacia("servicios")) {
        return insertarDescuentoUnico("servicios", "porcentaje", {
            texto: "Descuento por porcentaje aplicado",
            concepto: $("#motivo_descuento_s").val(),
            monto:
                (parseFloat(inputDescuentoPorcentaje.value) / 100) *
                parseFloat($("#precio_s").val()),
        });
    }

    // Caso 2: La tabla tiene un registro de descuento por porcentaje
    if (hayDescuento("servicios", "porcentaje")) {
        return actualizarDescuentoUnico("servicios", "porcentaje", {
            concepto: $("#motivo_descuento_s").val(),
            monto:
                (parseFloat(inputDescuentoPorcentaje.value) / 100) *
                parseFloat($("#precio_s").val()),
        });
    }

    return;
};

/**
 * Función para eliminar descuentos directos o por descuento según el descuento que se vaya a pintar en la tabla
 * @param { String } tipoDescuento tipo de descuento que se va a eliminar
 */
const eliminarDescuentosServicios = (tipoDescuento) => {
    if ((tipoDescuento === 'directo' && hayDescuento('servicios', 'directo')) || (tipoDescuento === 'porcentaje' && hayDescuento('servicios', 'porcentaje'))) {
        return eliminarDescuento("servicios", tipoDescuento);
    }
    return;
};
