const handlerDescuentoDirectoProductos = (inputDescuentoDirecto) => {
    // Si el precio de los productos es 0 no se puede aplicar nigún descuento
    if ($("#precio_p").val() == 0) {
        inputDescuentoDirecto.value = "";
        return;
    }

    // Si el input de descuento directo es 0 entonces eliminamos el descuento y limpiamos el input del motivo del descuento
    if (inputDescuentoDirecto.value == 0) {
        return eliminarDescuento("productos", "directo");
    }

    // Caso 1: La tabla de descuentos está vacía
    if (tablaResumenVacia("productos")) {
        return insertarDescuentoUnico("productos", "directo", {
            texto: "Descuento directo aplicado",
            concepto: $("#motivo_descuento_p").val(),
            monto: inputDescuentoDirecto.value,
        });
    }

    // Caso 2: La tabla tiene un registro de descuento directo
    if (hayDescuento("productos", "directo")) {
        return actualizarDescuentoUnico("productos", "directo", {
            concepto: $("#motivo_descuento_p").val(),
            monto: inputDescuentoDirecto.value,
        });
    }

    return;
};

const handlerDescuentoPorcentajeProductos = (inputDescuentoPorcentaje) => {
    // Si el precio de los productos es 0 no se puede aplicar nigún descuento
    if ($("#precio_p").val() == 0) {
        inputDescuentoPorcentaje.value = "";
        return;
    }

    // Si el input de descuento por porcentaje es 0 entonces eliminamos el descuento y limpiamos el input del motivo del descuento
    if (inputDescuentoPorcentaje.value == 0) {
        return eliminarDescuento("productos", "porcentaje");
    }

    // Caso 1: La tabla de descuentos está vacía
    if (tablaResumenVacia("productos")) {
        return insertarDescuentoUnico("productos", "porcentaje", {
            texto: "Descuento por porcentaje aplicado",
            concepto: $("#motivo_descuento_p").val(),
            monto:
                (parseFloat(inputDescuentoPorcentaje.value) / 100) *
                parseFloat($("#precio_p").val()),
        });
    }

    // Caso 2: La tabla tiene un registro de descuento por porcentaje
    if (hayDescuento("productos", "porcentaje")) {
        return actualizarDescuentoUnico("productos", "porcentaje", {
            concepto: $("#motivo_descuento_p").val(),
            monto:
                (parseFloat(inputDescuentoPorcentaje.value) / 100) *
                parseFloat($("#precio_p").val()),
        });
    }

    return;
};

/**
 * Función para eliminar descuentos directos o por descuento según el descuento que se vaya a pintar en la tabla
 * @param { String } tipoDescuento tipo de descuento que se va a eliminar
 */
const eliminarDescuentosProductos = (tipoDescuento) => {
    return eliminarDescuento("productos", tipoDescuento);
};
