// -------------------- Inicio de las funciones para verificar casos -------------------- //

/**
 * Función que verifica si la tabla resumen de un apartado está vacía
 * @param { String } apartado
 */
const tablaResumenVacia = (apartado) => {
    // Concatenamos los selectores de JQuery
    let rowTotal = `#row_total_${apartado}`;
    return $(rowTotal).length === 0;
};

/**
 * Función que verifica si la tabla resumen tiene un descuento de tipo directo o por descuento
 * @param { String } apartado
 * @return { Boolean } devuelve true si ya existe un registro de descuento
 */
const hayDescuento = (apartado, tipoDescuento) => {
    // Concatenamos los selectores de JQuery
    let rowDescuentoDirecto = `#row_descuento_${apartado}_${tipoDescuento}`;
    return $(rowDescuentoDirecto).length === 1;
};

// -------------------- Fin de las funciones para verificar casos -------------------- //

// -------------------- Inicio de las funciones para actualizar la tabla resumen -------------------- //

/**
 * Función que permite insertar un único descuento directo o un descuento por porcentaje en una tabla resumen
 * @param { Object } registro
 */
const insertarDescuentoUnico = (apartado, tipoDescuento, infoDesc) => {
    // Concatenamos los selectores de JQuery
    let sinDescuentos = `#sin_descuentos_${apartado}`;
    let resumenBody = `#resumen_${apartado}_body`;

    $(sinDescuentos).hide();
    $(resumenBody).append(
        `
		<tr id='row_descuento_${apartado}_${tipoDescuento}'>
			<td style='text-align: center;'><strong id='num_desc_${apartado}_${tipoDescuento}'>1</strong></td>
			<td>${infoDesc.texto}</td>
			<td id='concepto_${apartado}_${tipoDescuento}'>${infoDesc.concepto}</td>
			<td id='monto_${apartado}_${tipoDescuento}'>$${infoDesc.monto}</td>
		</tr>
	`,
        `
		<tr id='row_total_${apartado}'>
			<th colspan='3'>Total</th>
			<td><strong id='montoTotalDescuentos_${apartado}'>$${infoDesc.monto}</strong></td>
		</tr>
	`
    );
    return;
};

/**
 * Función que actualiza un descuento directo o por porcentaje ya aplicado
 * @param { String } apartado
 * @param { String } tipoDescuento
 */
const actualizarDescuentoUnico = (apartado, tipoDescuento, infoDesc) => {
    // Concatenamos los selectores de JQuery
    let concepto = `#concepto_${apartado}_${tipoDescuento}`;
    let monto = `#monto_${apartado}_${tipoDescuento}`;
    let montoTotal = `#montoTotalDescuentos_${apartado}`;
    let precio = `#precio_${apartado.slice(0, 1)}`;

    $(concepto).text(infoDesc.concepto);

    // Verificamos que el valor no rebase el precio de los estudios
    if (parseFloat(infoDesc.monto) > parseFloat($(precio).val())) {
        infoDesc.monto = $(precio).val();
    }

    $(monto).text(`$${infoDesc.monto}`);
    $(montoTotal).text(`$${infoDesc.monto}`);
    return;
};

/**
 * Función que actualiza el concepto del descuento aplicado
 * @param { HTMLElement } inputMotivo
 * @param { String } apartado
 */
const actualizarConceptoDescuento = (inputMotivo, apartado) => {
	// Concatenamos los selectores de JQuery
	let precio = `#precio_${apartado.slice(0, 1)}`;
	let poDescuento = `#po_descuento_${apartado.slice(0, 1)}`;
	let daDescuento = `#da_descuento_${apartado.slice(0, 1)}`;
	let concepto = `#concepto_${apartado}_`;

    if ($(precio).val() == 0 || $(poDescuento).val() == 0 && $(daDescuento).val() == 0) return;

    if ($(poDescuento).val() != 0) {
		concepto += 'porcentaje';
        $(concepto).text(inputMotivo.value);
        return;
    }

	concepto += 'directo';
    $(concepto).text(inputMotivo.value);
    return;
};

/**
 * Función que elimina ya sea el registro de descuento directo, o el registro de descuento por porcentaje según el nuevo descuento aplicado
 * @param { String } apartado
 * @param { String } tipoDescuento
 */
const eliminarDescuento = (apartado, tipoDescuento) => {
    // Concatenamos los selectores de JQuery
    let rowDescuento = `#row_descuento_${apartado}_${tipoDescuento}`;
    let rowTotal = `#row_total_${apartado}`;
    let daDescuento = `#da_descuento_${apartado.slice(0, 1)}`;
    let poDescuento = `#po_descuento_${apartado.slice(0, 1)}`;
    let motivo = `#motivo_descuento_${apartado.slice(0, 1)}`;
    let sinDescuentos = `#sin_descuentos_${apartado}`;

    $(rowDescuento).remove();
    $(rowTotal).remove();
    $(daDescuento).val("");
    $(poDescuento).val("");
    $(motivo).val("");
    $(sinDescuentos).show();
    return;
};

// -------------------- Fin de las funciones para actualizar la tabla resumen -------------------- //
