/**
 * Permite editar la cantidad a surtir de un producto.
 * @param { HTMLElement } span
 */
const cambiarSurtir = (span) => {
    const surtirPorDefecto = parseInt(span.textContent);
    $(span).replaceWith(`<input id="surtir_temporal" type="number" step="1" min="0" max="10" value="${surtirPorDefecto}" class="form-control" />`);
    $("#surtir_temporal").focus();
    $("#surtir_temporal").on("blur", () => $("#surtir_temporal").replaceWith(`<span onclick="cambiarSurtir(this);">${$("#surtir_temporal").val()}</span>`));
};
