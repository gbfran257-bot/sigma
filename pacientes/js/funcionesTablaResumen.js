/**
 * Función que, si la tabla tiene descuentos normales y directo, actualiza los descuentos normales y el total
 * @param { string } apartado
 */
const actualizarDescuentosNormalesConDirecto = async (
    apartado,
    tipoDescuento
) => {
    // Eliminamos los descuentos normales
    const rowDescuentoNormal = `.row_descuento_${apartado}_normal`;
    $(rowDescuentoNormal).remove();

    // Obtenemos los descuentos normales
    const descuentosNormales = await obtenerDescuentos(apartado);
    if (descuentosNormales.length === 0) {
        // Actualizamos el total de la tabla con el monto del descuento directo
        const rowMontoDescuentoDirecto = `.monto_${apartado}_directo`;
        const rowTotalDescuentos = `#montoTotalDescuentos_${apartado}`;
        const montoDescuentoDirecto = parseFloat(
            $(rowMontoDescuentoDirecto)
                .text()
                .slice(1, $(rowMontoDescuentoDirecto).text().length)
        );
        $(rowTotalDescuentos).text(`$${montoDescuentoDirecto}`);
        return;
    }

    // Insertamos los nuevos descuentos normales
    const rowTotalDescuentos = `#row_total_${apartado}`;
    const rowMontoDescuentoDirecto = `.monto_${apartado}_directo`;
    let nuevoTotal = parseFloat(
        $(rowMontoDescuentoDirecto)
            .text()
            .slice(1, $(rowMontoDescuentoDirecto).text().length)
    );
    descuentosNormales.forEach((descuento, index) => {
        nuevoTotal += parseFloat(descuento.monto);
        $(`
            <tr class="row_descuento_${apartado}_${tipoDescuento}">
                <td style="text-align: center;"><strong class="num_descuento_${apartado}_${tipoDescuento}">${
            index + 2
        }</strong></td>
                <td class="nombre_${apartado}_${tipoDescuento}">${
            descuento.nombre
        }</td>
                <td class="concepto_${apartado}_${tipoDescuento}">${
            descuento.concepto
        }</td>
                <td class="monto_${apartado}_${tipoDescuento}">$${
            descuento.monto
        }</td>
            </tr>
        `).insertBefore($(rowTotalDescuentos));
    });
    const rowMontoTotalDescuentos = `#montoTotalDescuentos_${apartado}`;
    $(rowMontoTotalDescuentos).text(`$${nuevoTotal}`);
    return;
};

/**
 * Función que, si la tabla tiene descuentos normales y descuento directo, actualiza el descuento directo y el total
 * @param { string } apartado
 * @param { string } tipoDescuento
 */
const actualizarDescuentoDirectoConNormales = (apartado, tipoDescuento) => {
    const inputDescuentoDirecto = `#da_descuento_${apartado.slice(0, 1)}`;

    // Guardamos el descuento directo antiguo, es decir el que está registrado en la tabla
    const rowDescuentoDirectoAntiguo = `.monto_${apartado}_directo`;
    const montoDescuentoDirectoAntiguo = parseFloat(
        $(rowDescuentoDirectoAntiguo)
            .text()
            .slice(1, $(rowDescuentoDirectoAntiguo).text().length)
    );
    // Guardamos el total antiguo de los descuentos
    const rowTotalDescuentos = `#montoTotalDescuentos_${apartado}`;
    const montoTotalAntiguoDescuentos = parseFloat(
        $(rowTotalDescuentos)
            .text()
            .slice(1, $(rowTotalDescuentos).text().length)
    );
    // Definimos la variable para actualiza el total
    let nuevoTotal = 0.0;

    // Verificamos si el descuento directo es 0
    if ($(inputDescuentoDirecto).val() == 0) {
        // Actualizamos el total de los descuento en la tabla
        nuevoTotal = montoTotalAntiguoDescuentos - montoDescuentoDirectoAntiguo;
        $(rowTotalDescuentos).text(`$${nuevoTotal}`);
        // Eliminamos el descuento directo y actualizamos el total de la tabla
        const rowDescuentoDirecto = `.row_descuento_${apartado}_directo`;
        $(rowDescuentoDirecto).remove();
        // Actualizamos el número de los descuentos
        const rowsNumsDescuentos = `.num_descuento_${apartado}_normal`;
        const numsDescuentos = $(rowsNumsDescuentos);
        let cont = 0;
        for (let rowNumDescuento of numsDescuentos)
            rowNumDescuento.textContent = ++cont;
        return;
    }

    // Actualizamos el total de los descuento en la tabla
    nuevoTotal =
        montoTotalAntiguoDescuentos -
        montoDescuentoDirectoAntiguo +
        parseFloat($(inputDescuentoDirecto).val());
    $(rowTotalDescuentos).text(`$${nuevoTotal}`);
    $(rowDescuentoDirectoAntiguo).text(`$${$(inputDescuentoDirecto).val()}`);
};

/**
 * Función que, cuando la tabla tiene únicamente descuento directo o por porcentaje, actualiza la tabla
 * @param { string } apartado
 * @param { string } tipoDescuento
 * @returns
 */
const actualizarDescuentoUnico = (apartado, tipoDescuento) => {
    if (tipoDescuento === "directo") {
        const inputDescuentoDirecto = `#da_descuento_${apartado.slice(0, 1)}`;
        if ($(inputDescuentoDirecto).val() == 0)
            return limpiarTablaResumen(apartado);
        const rowMontoDescuento = `.monto_${apartado}_directo`;
        const rowMontoTotalDescuento = `#montoTotalDescuentos_${apartado}`;
        const montoDescuentoDirecto = parseFloat(
            $(inputDescuentoDirecto).val()
        );
        $(rowMontoDescuento).text(`$${montoDescuentoDirecto}`);
        $(rowMontoTotalDescuento).text(`$${montoDescuentoDirecto}`);
        return;
    }
    if (tipoDescuento === "porcentaje") {
        const inputDescuentoPorcentaje = `#po_descuento_${apartado.slice(
            0,
            1
        )}`;
        if ($(inputDescuentoPorcentaje).val() == 0)
            return limpiarTablaResumen(apartado);
        const inputPrecio = `#precio_${apartado.slice(0, 1)}`;
        const rowMontoDescuento = `.monto_${apartado}_porcentaje`;
        const rowMontoTotalDescuento = `#montoTotalDescuentos_${apartado}`;
        const montoDescuentoPorcentaje =
            parseFloat($(inputPrecio).val()) *
            (parseFloat($(inputDescuentoPorcentaje).val()) / 100);
        $(rowMontoDescuento).text(`$${montoDescuentoPorcentaje}`);
        $(rowMontoTotalDescuento).text(`$${montoDescuentoPorcentaje}`);
        return;
    }
    return;
};

/**
 * Función que, cuando solo hay descuentos normales, inserta un nuevo descuento directo
 * @param { string } apartado
 * @param { string } tipoDescuento
 */
const insertarDescuentoDirectoConNormales = (apartado, tipoDescuento) => {
    // Concatenamos el apartado con los selectores que nos permiten manejar la tabla
    const inputDescuentoDirecto = `#da_descuento_${apartado.slice(0, 1)}`;
    const bodyResumen = `#resumen_${apartado}_body`;
    // Se comprueba si el descuento directo es mayor a cero
    if ($(inputDescuentoDirecto).val() == 0) return;
    // Insertamos el nuevo descuento directo en la tabla
    $(bodyResumen).prepend(`
        <tr class="row_descuento_${apartado}_${tipoDescuento}">
            <td style="text-align: center;"><strong class="num_descuento_${apartado}_${tipoDescuento}">1</strong></td>
            <td class="nombre_${apartado}_${tipoDescuento}">Descuento directo aplicado</td>
            <td class="concepto_${apartado}_${tipoDescuento}"></td>
            <td class="monto_${apartado}_${tipoDescuento}">$${$(
        inputDescuentoDirecto
    ).val()}</td>
        </tr>
    `);
    // Calculamos el total de la tabla descuento y actualizamos el número de descuento en el resumen
    const descuentosNormales = $(`.row_descuento_${apartado}_normal`);
    const montoDescuentoNormal = `.monto_${apartado}_normal`;
    const numDescuentoNormal = `.num_descuento_${apartado}_normal`;
    let nuevoNum = 2;
    let nuevoTotal = parseFloat($(inputDescuentoDirecto).val());
    for (let descuentoNormal of descuentosNormales) {
        const monto = descuentoNormal
            .querySelector(montoDescuentoNormal)
            .textContent.slice(
                1,
                descuentoNormal.querySelector(montoDescuentoNormal).textContent
                    .length
            );
        nuevoTotal += parseFloat(monto);
        descuentoNormal.querySelector(numDescuentoNormal).textContent =
            nuevoNum++;
    }
    $(`#montoTotalDescuentos_${apartado}`).text(`$${nuevoTotal}`);
    return;
};

/**
 * Función que, si la tabla contiene un descuento directo, inserta nuevos descuentos normales
 * @param { string } apartado
 * @param { string } tipoDescuento
 */
const insertarDescuentosNormalesConDirecto = async (
    apartado,
    tipoDescuento
) => {
    // Obtenemos el nuevo descuento individual
    const nuevoDescuentoNormal = await obtenerDescuentos(apartado).then(
        (data) => data[0]
    );
    // Comprobamos si hay un descuento individual
    if (typeof nuevoDescuentoNormal === "undefined") return;
    // Pintamos la tabla actualizada y acumulamos el nuevo total
    const rowTotal = `#row_total_${apartado}`;
    const rowMontoDescuentoDirecto = `.monto_${apartado}_directo`;
    let nuevoTotal =
        parseFloat(
            $(rowMontoDescuentoDirecto)
                .text()
                .slice(1, $(rowMontoDescuentoDirecto).text().length)
        ) + parseFloat(nuevoDescuentoNormal.monto);
    $(`
        <tr class="row_descuento_${apartado}_${tipoDescuento}">
            <td style="text-align: center;"><strong class="num_descuento_${apartado}_${tipoDescuento}">${++nuevoDescuentoNormal.num}</strong></td>
            <td class="nombre_${apartado}_${tipoDescuento}">${
        nuevoDescuentoNormal.nombre
    }</td>
            <td class="concepto_${apartado}_${tipoDescuento}">${
        nuevoDescuentoNormal.concepto
    }</td>
            <td class="monto_${apartado}_${tipoDescuento}">$${
        nuevoDescuentoNormal.monto
    }</td>
        </tr>
    `).insertBefore($(rowTotal));
    // Actualizamos el total
    const rowDescuentoTotal = `#montoTotalDescuentos_${apartado}`;
    $(rowDescuentoTotal).text(`$${nuevoTotal}`);
    return;
};

/**
 * Función que, cuando solo hay descuentos normales, inserta nuevos descuentos normales
 * @param { string } apartado
 * @param { string } tipoDescuento
 */
const insertarDescuentosNormales = async (
    apartado,
    tipoDescuento,
    rowSinDescuentos
) => {
    // Eliminamos los descuentos de la tabla
    const rowDescuentoNormal = `.row_descuento_${apartado}_${tipoDescuento}`;
    $(rowDescuentoNormal).remove();
    // Obtenemos los descuentos normales y verificamos si hay descuentos aplicados
    const descuentosNormales = await obtenerDescuentos(apartado).then(
        (data) => data
    );
    if (descuentosNormales.length === 0) {
        const rowTotal = `#row_total_${apartado}`;
        $(rowSinDescuentos).show();
        $(rowTotal).remove();
        return;
    }
    // Concatenamos el apartado y el tipo de descuento con el nombre de los selectores para manejar la tabla
    const rowMontoTotalDescuentos = `#montoTotalDescuentos_${apartado}`;
    const tablaResumenBody = `#resumen_${apartado}_body`;
    let total = 0.0;
    // Actualizamos la tabla con los nuevos descuentos
    descuentosNormales.forEach((descuentoNormal, index) => {
        total += parseFloat(descuentoNormal.monto);
        $(tablaResumenBody).prepend(`
            <tr class="row_descuento_${apartado}_${tipoDescuento}">
                <td style="text-align: center;"><strong class="num_descuento_${apartado}_${tipoDescuento}">${
            descuentosNormales.length - index
        }</strong></td>
                <td class="nombre_${apartado}_${tipoDescuento}">${
            descuentoNormal.nombre
        }</td>
                <td class="concepto_${apartado}_${tipoDescuento}">${
            descuentoNormal.concepto
        }</td>
                <td class="monto_${apartado}_${tipoDescuento}">$${
            descuentoNormal.monto
        }</td>
            </tr>
        `);
    });
    // Actualizamos el total, el total de la tabla resumen y el total de descuentos
    const inputTotalDescuento = `#to_descuento_${apartado.slice(0, 1)}`;
    const inputTotal = `#total_${apartado.slice(0, 1)}`;
    const inputPrecio = `#precio_${apartado.slice(0, 1)}`;
    $(inputTotalDescuento).val(total);
    $(inputTotal).val(parseFloat($(inputPrecio).val()) - total);
    $(rowMontoTotalDescuentos).text(`$${total}`);
    return;
};

/**
 * Función que, cuando la tabla está vacía, inserta un descuento normal, un descuento directo o un descuento por porcentaje
 * @param { string } apartado
 * @param { string } tipoDescuento
 */
const insertarDescuentoTablaVacia = async (
    apartado,
    tipoDescuento,
    rowSinDescuentos
) => {
    // Concatenamos el apartado y el tipo de descuento con el nombre de los selectores para manejar la tabla
    const tablaResumenBody = `#resumen_${apartado}_body`;
    const inputPrecio = `#precio_${apartado.slice(0, 1)}`;
    let total = 0.0;

    // Caso 1: Se va a insertar uno o más descuentos normales
    if (tipoDescuento === "normal") {
        const descuentoNormal = await obtenerDescuentos(apartado).then(
            (data) => data[0]
        );
        if (typeof descuentoNormal === "undefined") return;
        total = descuentoNormal.monto;
        $(tablaResumenBody).prepend(`
            <tr class="row_descuento_${apartado}_${tipoDescuento}">
                <td style="text-align: center;"><strong class="num_descuento_${apartado}_${tipoDescuento}">${descuentoNormal.num}</strong></td>
                <td class="nombre_${apartado}_${tipoDescuento}">${descuentoNormal.nombre}</td>
                <td class="concepto_${apartado}_${tipoDescuento}">${descuentoNormal.concepto}</td>
                <td class="monto_${apartado}_${tipoDescuento}">$${descuentoNormal.monto}</td>
            </tr>
        `);
    }

    // Caso 2: Se va a insertar un descuento por porcentaje
    if (tipoDescuento === "porcentaje") {
        const inputDescuentoPorcentaje = `#po_descuento_${apartado.slice(
            0,
            1
        )}`;
        if ($(inputDescuentoPorcentaje).val() == 0 || $(inputPrecio).val() == 0)
            return;
        total =
            parseFloat($(inputPrecio).val()) *
            (parseFloat($(inputDescuentoPorcentaje).val()) / 100);
        $(tablaResumenBody).prepend(`
            <tr class="row_descuento_${apartado}_${tipoDescuento}">
                <td style="text-align: center;"><strong class="num_descuento_${apartado}_${tipoDescuento}">1</strong></td>
                <td class="nombre_${apartado}_${tipoDescuento}">Descuento por porcentaje aplicado</td>
                <td class="concepto_${apartado}_${tipoDescuento}"></td>
                <td class="monto_${apartado}_${tipoDescuento}">$${total}</td>
            </tr>
        `);
    }

    // Caso 3: Se va a insertar un descuento directo
    if (tipoDescuento === "directo") {
        const inputDescuentoDirecto = `#da_descuento_${apartado.slice(0, 1)}`;
        if ($(inputDescuentoDirecto).val() == 0 || $(inputPrecio).val() == 0)
            return;
        total = parseFloat($(inputDescuentoDirecto).val());
        $(tablaResumenBody).prepend(`
            <tr class="row_descuento_${apartado}_${tipoDescuento}">
                <td style="text-align: center;"><strong class="num_descuento_${apartado}_${tipoDescuento}">1</strong></td>
                <td class="nombre_${apartado}_${tipoDescuento}">Descuento directo aplicado</td>
                <td class="concepto_${apartado}_${tipoDescuento}"></td>
                <td class="monto_${apartado}_${tipoDescuento}">$${total}</td>
            </tr>
        `);
    }

    // Al final agregamos el total a la tabla y actualizamos el total del descuento y el total
    const inputTotalDescuento = `#to_descuento_${apartado.slice(0, 1)}`;
    const inputTotal = `#total_${apartado.slice(0, 1)}`;
    $(inputTotalDescuento).val(total);
    $(inputTotal).val(
        parseFloat($(inputPrecio).val()) -
            parseFloat($(inputTotalDescuento).val())
    );
    $(rowSinDescuentos).hide();
    $(tablaResumenBody).append(`
        <tr id="row_total_${apartado}">
            <th colspan="3">Total</th>
            <td><strong id="montoTotalDescuentos_${apartado}">$${total}</strong></td>
        </tr>
    `);
    return;
};

/**
 * Función que realiza la petición para obtener los descuentos normales
 * @param { string } apartado
 */
const obtenerDescuentos = async (apartado) => {
    if (apartado === "consultas") {
        return await fetch(
            `${URL_CONSULTAS}?aleatorio=${$("#aleatorio_ov").val()}`,
            { method: "get" }
        )
            .then((response) => response.json())
            .catch((error) => console.log(error));
    }
    if (apartado === "imagen") {
        return await fetch(
            `${URL_IMAGEN}?aleatorio=${$("#aleatorio_ov").val()}`,
            { method: "get" }
        )
            .then((response) => response.json())
            .catch((error) => console.log(error));
    }
    if (apartado === "laboratorio") {
        return await fetch(
            `${URL_LABORATORIO}?aleatorio=${$("#aleatorio_ov").val()}`,
            { method: "get" }
        )
            .then((response) => response.json())
            .catch((error) => console.log(error));
    }
    if (apartado === "servicios") {
        return await fetch(
            `${URL_SERVICIOS}?aleatorio=${$("#aleatorio_ov").val()}`,
            { method: "get" }
        )
            .then((response) => response.json())
            .catch((error) => console.log(error));
    }
    if (apartado === "productos") {
        return await fetch(
            `${URL_PRODUCTOS}?aleatorio=${$("#aleatorio_ov").val()}`,
            { method: "get" }
        )
            .then((response) => response.json())
            .catch((error) => console.log(error));
    }
};

/**
 * Función que verifica si la tabla resumen de un apartado está vacía o no
 * @param { string } rowSinDescuentos id del elemento html que permite la verificación de la tabla vacía
 * @return { boolean } true si la tabla está vacía, false en caso contrario
 */
const tablaResumenVacia = (rowSinDescuentos) => {
    return $(rowSinDescuentos).css("display") === "table-row";
};

/**
 * Función que verifica si una tabla resumen contiene tanto descuentos normales como descuento directo
 * @param { string } apartado
 */
const descuentosNormalesYDirecto = (apartado) => {
    const rowDescuentoNormal = `.row_descuento_${apartado}_normal`;
    const rowDescuentoDirecto = `.row_descuento_${apartado}_directo`;
    return (
        $(rowDescuentoNormal).length != 0 && $(rowDescuentoDirecto).length != 0
    );
};

/**
 * Función que verifica si una tabla resumen contiene únicamente descuentos de tipo directo
 * @param { string } apartado
 */
const unicamenteDescuentoDirecto = (apartado) => {
    const rowDescuentoNormal = `.row_descuento_${apartado}_normal`;
    const rowDescuentoDirecto = `.row_descuento_${apartado}_directo`;
    const rowDescuentoPorcentaje = `.row_descuento_${apartado}_porcentaje`;
    return (
        $(rowDescuentoNormal).length == 0 &&
        $(rowDescuentoDirecto).length != 0 &&
        $(rowDescuentoPorcentaje).length == 0
    );
};

/**
 * Función que verifica si una tabla resumen contiene únicamente descuentos de tipo porcentaje
 * @param { string } apartado
 */
const unicamenteDescuentoPorcentaje = (apartado) => {
    const rowDescuentoNormal = `.row_descuento_${apartado}_normal`;
    const rowDescuentoDirecto = `.row_descuento_${apartado}_directo`;
    const rowDescuentoPorcentaje = `.row_descuento_${apartado}_porcentaje`;
    return (
        $(rowDescuentoNormal).length == 0 &&
        $(rowDescuentoDirecto).length == 0 &&
        $(rowDescuentoPorcentaje).length != 0
    );
};

/**
 * Función que verifica si una tabla resumen contiene únicamente descuentos de tipo normal
 * @param { string } apartado
 * @returns { boolean } true si la tabla contiene únicamente descuentos normales, false en caso contrario
 */
const unicamenteDescuentosNormales = (apartado) => {
    const rowDescuentoNormal = `.row_descuento_${apartado}_normal`;
    const rowDescuentoDirecto = `.row_descuento_${apartado}_directo`;
    const rowDescuentoPorcentaje = `.row_descuento_${apartado}_porcentaje`;
    return (
        $(rowDescuentoNormal).length != 0 &&
        $(rowDescuentoDirecto).length == 0 &&
        $(rowDescuentoPorcentaje).length == 0
    );
};

/**
 * Función que maneja los diferentes casos que pueden darse al momento de pintar la tabla resumen
 * @param { string } apartado Apartado en el que se van a manejar los descuentos: consultas, imagen, laboratorio, servicios o productos
 * @param { string } tipoDescuento Tipo de descuento que se va a aplicar: normal, directo o por porcentaje
 */
const pintarTablaResumen = (apartado, tipoDescuento) => {
    // Concatenamos el apartado y el tipo de descuento con el nombre de los selectores para manejar la tabla
    let rowSinDescuentos = `#sin_descuentos_${apartado}`;

    // Caso 1: La tabla está vacía para cualquier tipo de descuento a aplicar
    if (tablaResumenVacia(rowSinDescuentos))
        return insertarDescuentoTablaVacia(
            apartado,
            tipoDescuento,
            rowSinDescuentos
        );

    // Caso 2: La tabla tiene únicamente descuentos normales
    if (unicamenteDescuentosNormales(apartado)) {
        if (tipoDescuento === "normal")
            return insertarDescuentosNormales(
                apartado,
                tipoDescuento,
                rowSinDescuentos
            );
        if (tipoDescuento === "directo")
            return insertarDescuentoDirectoConNormales(apartado, tipoDescuento);
    }

    // Caso 3: La tabla tiene únicamente descuento por porcentaje
    if (unicamenteDescuentoPorcentaje(apartado)) {
        if (tipoDescuento === "normal" || tipoDescuento === "directo") {
            limpiarTablaResumen(apartado);
            insertarDescuentoTablaVacia(
                apartado,
                tipoDescuento,
                rowSinDescuentos
            );
            return;
        }
        if (tipoDescuento === "porcentaje")
            return actualizarDescuentoUnico(apartado, tipoDescuento);
    }

    // Caso 4: La tabla tiene únicamente descuento directo
    if (unicamenteDescuentoDirecto(apartado)) {
        if (tipoDescuento === "directo")
            return actualizarDescuentoUnico(apartado, tipoDescuento);
        if (tipoDescuento === "normal")
            return insertarDescuentosNormalesConDirecto(
                apartado,
                tipoDescuento
            );
    }

    // Caso 5: La tabla tienes descuentos normales y descuento directo
    if (descuentosNormalesYDirecto(apartado)) {
        if (tipoDescuento === "normal")
            return actualizarDescuentosNormalesConDirecto(
                apartado,
                tipoDescuento
            );
        if (tipoDescuento === "directo")
            return actualizarDescuentoDirectoConNormales(
                apartado,
                tipoDescuento
            );
    }
    return;
};

/**
 * Función que muestra un modal para confirmar que se quiere ingresar un descuento por porcentaje y eliminar todos los descuentos aplicados
 * @param { string } apartado
 * @param { HTMLElement } inputDescuentoPorcentaje
 */
const alertaEliminarDescuentos = (apartado, inputDescuentoPorcentaje) => {
    // Verificamos si hay un descuento por porcentaje ya activado para evitar eliminar los descuentos y limpiar la tabla
    const inputPrecio = `#precio_${apartado.slice(0, 1)}`;
    if (inputDescuentoPorcentaje.value != 0 || $(inputPrecio).val() == 0)
        return;
    Swal.fire({
        title: "Esta acción borrará los descuentos individuales de cada estudio y el descuento directo",
        text: "¿Deseas continuar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Continuar",
        cancelButtonText: `Cancelar`,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Aceptar",
        allowOutsideClick: false,
        allowEscapeKey: false,
        width: "50rem",
    }).then((result) => {
        if (result.isConfirmed) {
            // Eliminamos el descuentos directo, el motivo del descuento y actualizamos el total de descuentos y el total
            const inputDescuentoDirecto = `#da_descuento_${apartado.slice(
                0,
                1
            )}`;
            const inputMotivoDescuento = `#motivo_descuento_${apartado.slice(
                0,
                1
            )}`;
            const inputTotalDescuento = `#to_descuento_${apartado.slice(0, 1)}`;
            const inputTotal = `#total_${apartado.slice(0, 1)}`;
            const inputPrecio = `#precio_${apartado.slice(0, 1)}`;
            $(inputDescuentoDirecto).val(0);
            $(inputMotivoDescuento).val("");
            $(inputTotalDescuento).val(0);
            $(inputTotal).val($(inputPrecio).val());

            // Comprobamos a qué apartado se le eliminarán los descuentos
            let url = "";
            if (apartado === "consultas")
                url = URL_CONSULTAS_ELIMINAR_DESCUENTOS;
            else if (apartado === "imagen")
                url = URL_IMAGEN_ELIMINAR_DESCUENTOS;
            else if (apartado === "laboratorio")
                url = URL_LABORATORIO_ELIMINAR_DESCUENTOS;
            else if (apartado === "productos")
                url = URL_PRODUCTOS_ELIMINAR_DESCUENTOS;
            else if (apartado === "servicios")
                url = URL_SERVICIOS_ELIMINAR_DESCUENTOS;

            // Realizamos la consulta para eliminar los descuentos individuales
            const formData = new FormData();
            formData.append("aleatorio", $("#aleatorio_ov").val());
            fetch(url, {
                method: "post",
                body: formData,
            })
                .then((response) => response.json())
                .then((result) => {
                    Swal.fire({
                        title: "Descuentos eliminados correctamente :)",
                        icon: "success",
                    });
                })
                .catch((error) => {
                    Swal.fire({
                        title: "Ocurrió un problema :(",
                        text: error,
                        icon: "error",
                    });
                });

            // Limpiamos la tabla resumen
            limpiarTablaResumen(apartado);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
        }
    });
};

/**
 * Función que limpia completamente la tabla resumen de un apartado, dejando únicamente el mensaje de sin descuentos aplicados
 * @param { string } apartado
 */
const limpiarTablaResumen = (apartado) => {
    const rowDescuentosNormales = `.row_descuento_${apartado}_normal`;
    const rowDescuentoDirecto = `.row_descuento_${apartado}_directo`;
    const rowDescuentoPorcentaje = `.row_descuento_${apartado}_porcentaje`;
    const rowTotal = `#row_total_${apartado}`;
    const rowSinDescuentos = `#sin_descuentos_${apartado}`;
    const inputDescuentoPorcentaje = `#po_descuento_${apartado.slice(0, 1)}`;
    const inputDescuentoDirecto = `#da_descuento_${apartado.slice(0, 1)}`;
    $(rowDescuentosNormales).remove();
    $(rowDescuentoDirecto).remove();
    $(rowDescuentoPorcentaje).remove();
    $(rowTotal).remove();
    $(inputDescuentoDirecto).val(0);
    $(inputDescuentoPorcentaje).val(0);
    $(rowSinDescuentos).show();
    return;
};

/**
 * Función que, si hay un descuento directo o un descuento porcentaje aplicado, actualiza el concepto en el descuento de la tabla correspondiente
 * @param { string } apartado
 * @param { HTMLElement } inputMotivoDescuento
 */
const actualizarConcepto = (apartado, inputMotivoDescuento) => {
    const inputDescuentoPorcentaje = `#po_descuento_${apartado.slice(0, 1)}`;
    const inputDescuentoDirecto = `#da_descuento_${apartado.slice(0, 1)}`;
    if (
        $(inputDescuentoPorcentaje).val() === 0 &&
        $(inputDescuentoDirecto).val() == 0
    )
        return;

    if (
        $(inputDescuentoPorcentaje).val() != 0 &&
        $(inputDescuentoDirecto).val() == 0
    ) {
        const rowConceptoDescuentoPorcentaje = `.concepto_${apartado}_porcentaje`;
        $(rowConceptoDescuentoPorcentaje).text(inputMotivoDescuento.value);
    }

    if (
        $(inputDescuentoPorcentaje).val() == 0 &&
        $(inputDescuentoDirecto).val() != 0
    ) {
        const rowConceptoDescuentoDirecto = `.concepto_${apartado}_directo`;
        $(rowConceptoDescuentoDirecto).text(inputMotivoDescuento.value);
    }

    return;
};

// URL's para cada petición según el apartado
const URL_CONSULTAS =
    "pacientes/js/datatable-serverside/getDescConsultasSeleccionadas.php";
const URL_IMAGEN =
    "pacientes/js/datatable-serverside/getDescImagenSeleccionadas.php";
const URL_LABORATORIO =
    "pacientes/js/datatable-serverside/getDescLabSeleccionadas.php";
const URL_SERVICIOS =
    "pacientes/js/datatable-serverside/getDescServiciosSeleccionados.php";
const URL_PRODUCTOS =
    "pacientes/js/datatable-serverside/getDescProductosSeleccionados.php";

const URL_CONSULTAS_ELIMINAR_DESCUENTOS =
    "pacientes/js/datatable-serverside/eliminarDescuentosConsultas.php";
const URL_IMAGEN_ELIMINAR_DESCUENTOS =
    "pacientes/js/datatable-serverside/eliminarDescuentosImagen.php";
const URL_LABORATORIO_ELIMINAR_DESCUENTOS =
    "pacientes/js/datatable-serverside/eliminarDescuentosLaboratorio.php";
const URL_SERVICIOS_ELIMINAR_DESCUENTOS =
    "pacientes/js/datatable-serverside/eliminarDescuentosServicios.php";
const URL_PRODUCTOS_ELIMINAR_DESCUENTOS =
    "pacientes/js/datatable-serverside/eliminarDescuentosProductos.php";
